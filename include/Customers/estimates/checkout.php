<?php 
if(LMS_VIEW == 'checkout' && !isset($_GET['id'])) {

	$conditions = array ( 
							'select' 		=> ''.CUSTOMERS.'.customer_id',
							'where' 		=> array( 
														''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													), 
							'limit' 		=> 1,
							'return_type' 	=> 'single' 
						); 
	$valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);

	// get Credit Debit Payments of Customer
	$debitcreditconditions = array ( 
										'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
															SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
										'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
										'where' 		=> array ( 
																	''.PAYMENTS.'.status' => 1
																	, ''.PAYMENTS.'.id_user' => cleanvars($valueCustomer['customer_id'])
																), 
										'return_type' 	=> 'single' 
									); 
	$valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance 	= ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);

	echo '
	<div class="modal-dialog" style="width:95%;">
        <div class="modal-content">
			<form action="#" method="post" id="inv_form"  name="inv_form" autocomplete="off">
				<input type="hidden" id="id_customer" name="id_customer" value="'.$valueCustomer['customer_id'].'">
				<div class="modal-header">
					<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
					<h4 class="modal-title" style="font-weight:700;"><i class="icon-list-ul"></i> Cart Items</h4>
				</div>
				<div class="modal-body" id="pbody">';
					if ($_SESSION['cart']) {
						echo '
						<div style="clear:both;"></div>
						<table class="table table-bordered table-hover invE_table" id="cartTable">
							<thead>
								<tr>
									<th style="text-align:center;" width="40"></th>
									<th style="text-align:center;" width="50">Sr. #</th>
									<th>Items</th>
									<th style="text-align:center;" width="150">Avaiable Stock</th>
									<th style="text-align:center;" width="150">Qty</th>
									<th style="text-align:center;" width="150">Unit Price</th>
									<th style="text-align:center;" width="150">Total</th>
								</tr>
							</thead>
							<tbody>';
								$srno 	= 0;
								$gtotal = 0;
								foreach($_SESSION['cart'] as $item){
									$srno++;
									$gtotal = $gtotal + (round($item['pricesale']) * $item['quantity']);
				
									$stockconditions	= array ( 
																	'select' 		=> "".ITEMS.".item_pricepurchase, 
																						SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
																						SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY ",
																	'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
																	'where' 		=> array( 
																								''.STOCK.'.id_item' => cleanvars($item['id']) 
																							), 
																	'return_type' 	=> 'single' 
																); 
									$valuestockinout 	= $dblms->getRows(STOCK, $stockconditions);
									$itemstock 			= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);
				
									echo '
									<tr>
										<td style="text-align:center;">
											<a onclick="removeitem(\''.$item['id'].'\')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
										</td>
										<td style="text-align:center;">'.$srno.'</td>
										<td>
											'.$item['name'].'
											<input type="hidden" name="id_item['.$srno.']" id="id_item_'.$srno.'" class="form-control" value="'.$item['id'].'" >
										</td>
										<td style="text-align:center;">
											<span style="color:#00f; font-size:16px; font-weight:600; text-align:center;">'.number_format($itemstock).'</span>
											<input type="hidden" name="is_available['.$srno.']" id="is_available_'.$srno.'" value="'.($itemstock > 0 ? '1' : '0').'">
										</td>
										<td style="text-align:center;">
											<input type="number" name="total_qty['.$srno.']" id="total_qty_'.$srno.'"  oninput="updatequantityWithCheck(\''.$item['id'].'\',this, '.$itemstock.')" style="color:#00f; font-weight:600; text-align:center;" class="form-control jQinv_item_qty" required value="'.$item['quantity'].'" min="0" max="'.$itemstock.'" >
										</td>
										<td style="text-align:center;">
											<input type="number" name="unit_price['.$srno.']" id="unit_price_'.$srno.'" style="color:#f00; font-weight:600; text-align:center;" readonly="" class="form-control jQinv_item_rate" value="'.round($item['pricesale']).'" >
										</td>
										<td style="text-align:center;">
											<input type="number" name="total_price['.$srno.']" id="total_price_'.$srno.'" style="color:orangered; font-weight:600; text-align:center;" readonly="" class="form-control jQinv_item_total" value="'.(round($item['pricesale']) * $item['quantity']).'" >
										</td>
									</tr>';
								} 
								echo '
								<tr>
									<th style="text-align:right;" colspan="6">
										Total Amount
									</th>
									<th style="text-align:center;">
										<span style="color:#00f; font-size:16px; font-weight:600;" class="inV_grandtotal"><span>'.number_format(round($gtotal)).'</span></span>
									</th>
								</tr>
							</tbody>
						</table>
						<hr>
						<table class="footable table table-bordered" id="payable">
							<thead>
								<tr>
									<th style="text-align:center;">Prvious Balance</th>
									<th style="text-align:center;">This Order Amount</th>
									<th style="text-align:center;">Total Payable Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th style="text-align:center;vertical-align: middle;">
										<span style="color:#00f; font-size:16px; font-weight:600; text-align:center;">Rs.<span>'.number_format($openingbalance).'</span></span>
									</th>
									<th style="text-align:center;vertical-align: middle;">
										<span style="color:#00f; font-size:16px; font-weight:600; text-align:center;" class="inV_grandtotal">Rs.<span>'.number_format(round($gtotal)).'</span></span>
									</th>
									<th style="text-align:center;vertical-align: middle;">
										<span style="color:#00f; font-size:16px; font-weight:600; text-align:center;" class="inV_receiveable">Rs.<span>'.number_format(round($gtotal + $openingbalance)).'</span></span>
										<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.round($gtotal).'">
										<input type="hidden" id="opening_balance" name="opening_balance" value="'.$openingbalance.'">
										<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="">
									</th>
								</tr>
							</tbody>
						</table>';
					} else { 
						echo '
						<div class="col-lg-12">
							<div class="widget-tabs-notification">No Record Found</div>
						</div>';
					}
					echo '
				</div>';
				if ($_SESSION['cart']) {

					if(isset($_SESSION['estimate_id']) && !empty($_SESSION['estimate_id']))	{
						echo '<input type="hidden" id="estimate_id" name="estimate_id" value="'.$_SESSION['estimate_id'].'">';
						$btn = 'submit_changes';
					}else{
						$btn = 'submit_estimate';
					}
					echo '
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php?view=add\'">Closed</button>
						<button type="submit" class="btn btn-warning" value="savehold" id="'.$btn.'" name="'.$btn.'" onclick="return confirmSubmit()"> Check Out </button> 
					</div>';
				}
				echo '
			</form>
        </div>
    </div>
	<script type="text/javascript">

				
		function updatequantityWithCheck(itemId, inputElement, maxLimit) {
			let qty = parseInt(inputElement.value, 10) || 0; // Get input value and convert to number

			if (qty > maxLimit) {
				alert(`Quantity cannot exceed the maximum limit of ${maxLimit}.`);
				inputElement.value = maxLimit; // Reset input value to max limit
				qty = maxLimit;
				// Proceed with update
				updatequantity(itemId, qty);
			}else{
				// Proceed with update
				updatequantity(itemId, qty);
			}
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

		function removeitem(item_id) {
			$("#loading").html(\'<img src="assets/images/preloader.gif"> loading...\');
			$.ajax({
				type: "POST",
				url: "include/ajax/cart/removeitem.php", 
				data: {
						item_id: item_id
					},
				success: function(msg) {
					data = JSON.parse(msg);
					if (data.status_code == \'11\') {
						$(\'#pbody\').html(data.pbody);
						// $(\'#pfooter\').hide();
					} else if (data.status_code == \'00\') {
						$(\'#cartTable tbody\').html(data.tbody);
						$(\'#payable tbody\').html(data.payable);
					}
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

		function confirmSubmit() {
			var agree=confirm("Are you sure you wish to continue?");
			if (agree)
				return true ;
			else
				return false ;
		}
		$(document).ready(function() {

			//* clone row
			var id = 0;
			$(".inv_clone_btn").click(function() {
				id++;
				var table = $(this).closest("table");
				var clonedRow = table.find(".inv_row").clone();
				clonedRow.removeAttr("class")
				clonedRow.find(".id").attr("value", id);
				clonedRow.find(".inv_clone_row").html(\'<i class="icon-minus inv_remove_btn"></i>\');
				clonedRow.find("input").each(function() {
					$(this).val(\'\');
				});
				table.find(".last_row").before(clonedRow);
			});

			//* remove row
			$(".invE_table").on("click",".inv_remove_btn", function() {
				$(this).closest("tr").remove();
				rowInputs();
			});

			//* subtotal sum
			$(\'#inv_form\').on(\'keyup\',\'.jQinv_item_qty, .jQinv_item_rate\', function() {
				rowInputs();
			});

			function rowInputs() {
				//var balance = 0;
				//var subTotal = 0;
				var grandTotal = 0;
				//var taxTotal = 0;
				$(".invE_table tr").not(\'.last_row\').each(function () {
					var $qty 			= $(\'.jQinv_item_qty\', this).val();
					var $rate 			= $(\'.jQinv_item_rate\', this).val();
					//monthly
					var $linetotal 	= ($rate * $qty); 
					var parsedSubTotal = parseFloat( (\'0\' + $linetotal).replace(/[^0-9-\.]/g, \'\'), 10 );
					$(\'.jQinv_item_total\',this).val($linetotal);
					grandTotal += parsedSubTotal;
					
				});
				var openingbalance = document.getElementById("opening_balance").value;  
				var totalReceivable = ((openingbalance * 1) + (grandTotal * 1)); 
				$(".inV_grandtotal span").html(grandTotal.toLocaleString("en-US"));
				$("#inV_grandtotal").val(grandTotal); // Keep raw value for backend processing
				$(".inV_receiveable span").html(totalReceivable.toLocaleString("en-US"));
				$("#inV_receiveable").val(totalReceivable); // Keep raw value for backend processing

			}

			function clearInvForm() {
				$(\'#inv_form\').find(\'input\').each(function() {
					$(this).val(\'\');
					$(".inV_grandtotal span").html(\'0.00\');
				})
			}
			
		});

	</script>';
}
?>