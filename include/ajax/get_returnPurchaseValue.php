<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	$id_item = $_POST['id_item']; 
	$srno = $_POST['srno']; 
	$id_vendor = $_POST['id_vendor']; 
//--------------------------------------------
	$conditions 	= array ( 
								'select' 		=> 'item_pricepurchase',
								'where' 		=> array ( 
															'item_id' 	=> cleanvars($id_item)
														 ), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueitem 		= $dblms->getRows(ITEMS, $conditions);
//------------------------------------------------
echo '
	<input type="text" class="form-control col-lg-12 jQinv_item_rate" required name="unit_price['.$srno.']" id="unit_price_'.$srno.'" value="'.$valueitem['item_pricepurchase'].'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;" autocomplete="off">';
//--------------------------------------------
