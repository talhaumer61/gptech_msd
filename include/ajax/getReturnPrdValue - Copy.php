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
	$id_customer = $_POST['id_customer']; 
//--------------------------------------------
    $sqllmsitem  = $dblms->querylms("SELECT d.unit_price FROM ".SALES_INVOICE_DETAILS." d
										INNER JOIN ".SALES_INVOICE." inv ON inv.salesinvoice_id = d.id_salesinvoice 
										INNER JOIN ".ITEMS." it ON it.item_id = d.id_item 
										WHERE d.id_item = '".cleanvars($id_item)."' 
										AND inv.id_customer = '".$_POST['id_customer']."'
										ORDER BY d.id DESC ");
	$valueitem 	= mysqli_fetch_assoc($sqllmsitem);

//------------------------------------------------
echo '
	<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$srno.']" id="unit_price_'.$srno.'" value="'.$valueitem['unit_price'].'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;">

';
//--------------------------------------------

?>
<!--JS_SELECT_LISTS-->
