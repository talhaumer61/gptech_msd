<?php
if(isset($_POST['id']) && isset($_POST['photo']) && isset($_POST['name']) && isset($_POST['pricesale'])){

    session_start(); 

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $item = array(
                     'id'           =>  $_POST['id']
                    ,'photo'        =>  $_POST['photo']
                    ,'name'         =>  $_POST['name']
                    ,'pricesale'    =>  $_POST['pricesale']
                    ,'quantity'     =>  '1'
                );
    if(isset($_SESSION['cart'][$_POST['id']])){
        $data['title'] = 'Error';
        $data['text']  = 'Item already exist in cart';
        $data['type']  = 'error';
        $data['cnt']   =  count($_SESSION['cart']);
    }else{ 
        $_SESSION['cart'][$_POST['id']] = $item;
        $data['title'] = 'Successfully';
        $data['text']  = 'Item Successfully Added.';
        $data['type']  = 'success';
        $data['cnt']   = count($_SESSION['cart']);
    }

    $gtotal = 0;
    $cartHtml = ''; // Initialize the cart HTML
    
    foreach ($_SESSION['cart'] as $item) {
        $gtotal += ($item['pricesale'] * $item['quantity']);
        $cartHtml .= '
        <div class="product">
            <div class="product-details">
                <h4 class="product-title">'.$item['name'].'</h4>
                <span class="cart-product-info">
                    <div class="quantity-container">
                        <button type="button" onclick="updateQuantity(\''.$item['id'].'\', -1)">-</button>
                        <input type="text" value="1" id="quantity-'.$item['id'].'" onchange="updateSubtotal()">
                        <button type="button" class="btn btn-primar" onclick="updateQuantity(\''.$item['id'].'\', 1)">+</button>
                        <span class="price">× Rs.'.$item['pricesale'].'</span>
                    </div>
                </span>
            </div>
            <figure class="product-image-container">
                <img src="'.$item['photo'].'" alt="product" width="50" height="50">
                <a onclick="removefromcart(\''.$item['id'].'\')" class="btn-remove" title="Remove Product"><span>×</span></a>
            </figure>
        </div>';
    }
    $cartHtml .= '
                <div class="dropdown-cart-total">
                    <span>SUBTOTAL:</span>
                    <span class="cart-total-price" id="cart-subtotal">Rs.'.$gtotal.'.00</span>
                </div>
                <div class="dropdown-cart-action">
                    <a href="customerestimates.php?view=checkout" class="btn btn-danger btn-block">View Cart</a>
                </div>';
    $data['cartHtml']   = $cartHtml;
    echo json_encode($data);

}
?>