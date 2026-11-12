<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 

	if(isset($_GET['idest']) && !empty($_GET['idest'])){
		$id_estimate = cleanvars($_GET['idest']);
	}else{

		// GET CUSTOMER ID
		$conditions = array ( 
								'select' 		=> 'e.estimate_id'
								,'join' 		=> "INNER JOIN ".CUSTOMERS." c ON c.customer_id =  e.id_customer"
								, 'where' 		=> array( 
															'c.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
															,'e.estimate_status'  => '1'
														)
								, 'order_by' 	=> 'e.estimate_id DESC'
								, 'return_type' => 'single' 
							); 
		$resultorder 	= $dblms->getRows(ESTIMATES. ' e', $conditions);

		if($resultorder){
			$id_estimate = $resultorder['estimate_id'];
		}else{
			$id_estimate = '';
		}
	}

	if(!empty($id_estimate)) {

		session_start(); 
		unset($_SESSION['cart']);
		unset($_SESSION['estimate_id']);

		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
		}

		if (!isset($_SESSION['estimate_id'])) {
			$_SESSION['estimate_id'] = $id_estimate;
		}

		$POconditions = array ( 
							  'select' 		=> 'ed.id_item, ed.qty, i.item_name, i.item_photo, i.item_pricesale'
							, 'join' 		=> "INNER JOIN ".ITEMS." i ON i.item_id = ed.id_item"
							, 'where' 		=> array( 
															'ed.id_estimate' => cleanvars($id_estimate)
													)
							, 'order_by' 	=> 'ed.id ASC' 
							, 'return_type' => 'all' 
						); 
    	$Orderdetail 	= $dblms->getRows(ESTIMATES_DETAIL. ' ed', $POconditions);

		foreach($Orderdetail as $row) {

			$img = SITE_URL.'/uploads/items/'.(!empty($row['item_photo']) ? $row['item_photo'] : 'default.jpg');

			$item = array(
                     'id'           =>  $row['id_item']
                    ,'photo'        =>  $img
                    ,'name'         =>  $row['item_name']
                    ,'pricesale'    =>  $row['item_pricesale']
                    ,'quantity'     =>  $row['qty']
                );

			$_SESSION['cart'][$row['id_item']] = $item;
			
		}

	}

echo '
<div class="row">
	<div class="col-md-9">';
		include_once("cart/items.php");
		echo '
	</div>
	<div class="col-md-3">';
		include_once("cart/cart.php");
		echo '
	</div>
</div>

<script LANGUAGE="JavaScript">
	function confirmSubmit() {
		var agree=confirm("Are you sure you wish to continue?");
		if (agree)
		return true ;
		else
		return false ;
	}
	$(".select2").select2({
        allowClear: true
    });
    
    $(".id_cls").select2({
        allowClear: true
    });
	
	$("#id_cat").select2({
        allowClear: true
    });
	function addtocart(id,photo,name,pricesale) {
		$.ajax({
			type: "POST",
			url: "include/ajax/cart/addtocart.php", 
			data: {
						id: id,
						photo: photo,
						name: name,
						pricesale: pricesale
					},
			success: function(msg) {
				data = JSON.parse(msg);

				new PNotify({
					title	: data.title,
					text	: data.text,
					type	: data.type,
					hide	: true,
					buttons: {
						closer	: true	,
						sticker	: false
					}
				});
				// $(\'#cart-item\').text(data.cnt);
				$(\'#cart-products\').html(data.cartHtml);
			}
		});
	}
	function removefromcart(item_id) {
		$.ajax({
			type: "POST",
			url: "include/ajax/cart/removeproduct.php", 
			data: {
					item_id: item_id
					},
			success: function(msg) {
				data = JSON.parse(msg);
					$(\'#cart-products\').html(data.cartHtml);
				new PNotify({
					title	: data.title,
					text	: data.text,
					type	: data.type,
					hide	: true,
					buttons: {
						closer	: true	,
						sticker	: false
					}
				});
			}
		});
	}
	function updatequantity(id,value) {
		$("#loading").html(\'<img src="assets/images/preloader.gif"> loading...\');
		$.ajax({
			type: "POST",
			url: "include/ajax/cart/updatequantity.php", 
			data: {
						id: id,
						value: value
					},
			success: function(msg) {
				data = JSON.parse(msg);
				new PNotify({
					title	: data.title,
					text	: data.text,
					type	: data.type,
					hide	: true,
					buttons: {
						closer	: true	,
						sticker	: false
					}
				});
			}
		});
	}
	function search() {
		$("#loading").html(\'<img src="assets/images/preloader.gif"> loading...\');
		var search_word = $(\'#search_word\').val();
		var id_cls 		= $(\'#id_cls\').val();
		var id_cat 		= $(\'#id_cat\').val();
		$.ajax({
			type: "POST",
			url: "include/ajax/cart/searchitems.php", 
			data: {
						search_word: search_word,
						id_cls: id_cls,
						id_cat: id_cat
					},
			success: function(msg) {
				$(\'#items\').html(msg);
			}
		});
	}
	function updateQuantity(productId, change) {
		const quantityInput = document.getElementById(`quantity-${productId}`);
		let currentQuantity = parseInt(quantityInput.value);
		if (!isNaN(currentQuantity)) {
			currentQuantity = Math.max(1, currentQuantity + change); // Ensure quantity is at least 1
			quantityInput.value = currentQuantity;
		}
		updateSubtotal();
		updatequantity(productId, currentQuantity);
	}
	function updateSubtotal() {
		let subtotal = 0;
		const products = document.querySelectorAll(\'.product\');
		products.forEach(product => {
			const price = parseFloat(product.querySelector(\'.cart-product-info\').textContent.split(\'× Rs.\')[1]);
			const quantityInput = product.querySelector(\'input[type="text"]\');
			const quantity = parseInt(quantityInput.value);
			if (!isNaN(price) && !isNaN(quantity)) {
				subtotal += price * quantity;
			}
		});
		document.getElementById(\'cart-subtotal\').textContent = `Rs.${subtotal.toFixed(2)}`;
	}
</script>';
}
?>

