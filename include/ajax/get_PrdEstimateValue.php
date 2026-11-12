<?php 

	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	include "../../functions/db_functions.php";
	$mainclass	= new main();

	$idcustomer = (isset($_POST['idcustomer']) && $_POST['idcustomer'] != '') ? $_POST['idcustomer'] : '';
	$id_item 	= $_POST['id_item']; 
	$srno 		= $_POST['srno']; 
//--------------------------------------------
// get item price
	$itemprice		= $mainclass->get_itemprice($id_item);
// get customer type
	$customertype	= $mainclass->get_customertype($idcustomer);
// get item stock
	$valuestockinout = $mainclass->get_itemstock($id_item);

	$avaiablestock 		= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);

	if($avaiablestock>0) { $isavailable = 1; } else { $isavailable = 0;	}
	if(!empty($customertype)) {
		if($customertype['id_type'] == 2) {
			$pricesale = $itemprice['item_pricedealership'];
		} elseif($customertype['id_type'] == 4) {
			$pricesale = $itemprice['item_priceretail'];
		} else {
			$pricesale = $itemprice['item_pricesale'];
		} 
	} else {
		$pricesale = $itemprice['item_pricesale'];
	}
//------------------------------------------------
echo '
<input type="hidden" name="is_available['.$srno.']" id="is_available_'.$srno.'" value="'.$isavailable.'">
	<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$srno.']" id="unit_price_'.$srno.'" value="'.$pricesale.'" style="text-align:center; color:#00f; font-weight:600; font-size:14px !important;">
';
//--------------------------------------------