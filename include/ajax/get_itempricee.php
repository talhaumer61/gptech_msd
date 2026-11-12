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
echo '		
	<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$srno.']" id="unit_price_'.$srno.'" value="'.$valueitem['item_pricesale'].'" style="text-align:center; color:#f00; font-weight:600; font-size:16px !important;">
	';
//--------------------------------------------
