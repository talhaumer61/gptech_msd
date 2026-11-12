<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	include "../../functions/db_functions.php";
	$mainclass	= new main();

	$id_item 	= $_POST['id_item']; 
	$srno 		= $_POST['srno']; 
//--------------------------------------------
// get item price
	$valueitem		= $mainclass->get_itemprice($id_item);

  //------------------------------------------------
// Check Stocks In out
// get item stock
	$valuestockinout = $mainclass->get_itemstock($id_item);

	$avaiablestock 		= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);
echo '
	<div class="col-sm-61" >
		<input type="text" class="form-control col-lg-12" name="stock_qty['.$srno.']" id="stock_qty'.$srno.'" value="'.$avaiablestock.'" style="text-align:center; color:#00f; font-weight:600; font-size:16px !important;" readonly>
	</div>
				
	<div class="col-sm-61">
		<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$srno.']" id="unit_price_'.$srno.'" value="'.$valueitem['item_pricepurchase'].'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;">
	</div>';
//--------------------------------------------
