<?php 

	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";

	$id_item = $_POST['id_item']; 
	$srno 	 = $_POST['srno']; 
//--------------------------------------------

	$stockconditions = array ( 
								'select' 		=> "".ITEMS.".item_pricepurchase, 
													SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
													SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY ",
								'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'where' 		=> array( 
															''.STOCK.'.id_item' => cleanvars($id_item) 
														), 
								'return_type' 	=> 'single' 
							); 
	$valuestockinout 	= $dblms->getRows(STOCK, $stockconditions);	

	$avaiablestock 		= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);
//------------------------------------------------
echo '
	<input type="hidden" class="jQinv_sale_price" name="sale_price['.$srno.']" id="sale_price_'.$srno.'" value="'.$valuestockinout['item_pricepurchase'].'">
	<div class="col-sm-61" >
		<input type="text" class="form-control col-lg-12 jQinv_system_stock" name="system_stock['.$srno.']" id="stock_qty'.$srno.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.$avaiablestock.'">
	</div>
	<div class="col-sm-61">
		<input type="text" class="form-control col-lg-12 jQinv_system_stockamount" name="system_stockamount['.$srno.']" id="system_stockamount_'.$srno.'" style="color:#00f; font-weight:600; text-align:center;" readonly value="'.($avaiablestock * $valuestockinout['item_pricepurchase']).'">
	</div>';
//--------------------------------------------