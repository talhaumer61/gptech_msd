<?php

echo '
    <div style="width:105%; padding: 15px 10px 10px 0px; margin-left:-15px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight:700;"><i class="fa fa-shopping-cart"></i> Cart Items</h4>
            </div>

            <div class="modal-body scrollable">
                
                <div class="dropdown-cart-products" id="cart-products">';
                    if($_SESSION['cart']){
                        foreach($_SESSION['cart'] as $item){
                            $srno++;
                            $gtotal += ($item['pricesale'] * $item['quantity']);
                            echo '
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
                        echo '
                        <div class="dropdown-cart-total">
                            <span>SUBTOTAL:</span>
                            <span class="cart-total-price" id="cart-subtotal">Rs.'.$gtotal.'.00</span>
                        </div>
                        <div class="dropdown-cart-action">
                            <a href="customerestimates.php?view=checkout" class="btn btn-danger btn-block">View Cart</a>
                        </div>';
                    }else{
                        echo'
                        <div class="text-center">
                            <h2 class="text text-center text-danger mt-lg">No item!</h2>
                        </div>';
                    }
                echo '
                </div> 
            </div>

        </div>
    </div>';