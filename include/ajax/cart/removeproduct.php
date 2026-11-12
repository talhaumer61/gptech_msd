<?php
if(isset($_POST['item_id']) ){

    session_start(); 

    unset($_SESSION['cart'][$_POST['item_id']]);

    if(count($_SESSION['cart']) > 0){
        $gtotal     = 0;
        $cartHtml   ='';
        foreach ($_SESSION['cart'] as $item) {
            $gtotal += ($item['pricesale'] * $item['quantity']);
            $cartHtml .= '
            <div class="product">
                <div class="product-details">
                    <h4 class="product-title">'.$item['name'].'</h4>
                    <span class="cart-product-info">
                        <div class="quantity-container">
                            <button type="button" onclick="updateQuantity(\''.$item['id'].'\', -1)">-</button>
                            <input type="text" value="'.$item['quantity'].'" id="quantity-'.$item['id'].'" onchange="updateSubtotal();">
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

        $data['cartHtml'] = $cartHtml;
    }else{
        $cartHtml = '
        <div class="text-center">
            <h2 class="text text-center text-danger mt-lg">No item!</h2>
        </div>';
        $data['cartHtml'] = $cartHtml;
    }

    
    $data['title'] = 'Error';
    $data['text']  = 'Item Removed Successfully.';
    $data['type']  = 'error';
    echo json_encode($data);

}
?>