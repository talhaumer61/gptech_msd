<?php
if(isset($_POST['id']) && isset($_POST['value']) ){

    session_start(); 

    $_SESSION['cart'][$_POST['id']]['quantity'] = $_POST['value'];
    $data['title'] = 'Successfully';
    $data['text']  = 'Item Quantity Successfully Updated.';
    $data['type']  = 'info';
    echo json_encode($data);

}

?>