<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	
if(isset($_POST['id_vendor'])) {
	
	
	$conditions = array ( 
							'select' 		=> "".PURCHASE_ORDER.".purchase_order_id, ".PURCHASE_ORDER.".po_order_no",
							'join' 			=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
							'where' 		=> array ( 
														''.PURCHASE_ORDER.'.id_vendor' 	=> cleanvars($_POST['id_vendor']) 
												 	), 
							'order_by' 		=> "".PURCHASE_ORDER.".purchase_order_id ASC",
							'return_type' 	=> 'all' 
						); 
    $Orders 	= $dblms->getRows(PURCHASE_ORDER, $conditions);
	
	echo '
	<input type="hidden" id="id_vendor" name="id_vendor" value="'.cleanvars($_POST['id_vendor']).'">
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Vendor Orders</label>
			<select id="vendor_order" name="vendor_order" onchange="get_vendororderdetail(this.value)" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
	
				if (!empty($Orders)) {
					foreach($Orders as $valeOrder) {		
						// Total Ordered Qty
						// $purchaseorder = array ( 
						// 						'select' 		=> "SUM(".PURCHASE_ORDER_DETAILS.".qty) as TotalorderedQTY",
						// 						'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".PURCHASE_ORDER_DETAILS.".id_item",
						// 						'where' 		=> array ( 
						// 													''.PURCHASE_ORDER_DETAILS.'.id_po' 	=> cleanvars($valeOrder['purchase_order_id']) 
						// 												), 
						// 						'return_type' 	=> 'single' 
						// 					); 
    					// $valueItemqty 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $purchaseorder);

						// // Check Stocks received 
						
						// $receivedstock = array ( 
						// 							'select' 	=> " SUM(qty) as TotalQTY",
						// 							'where' 	=> array( 
						// 												  'stock_type' 		=> 1 
						// 												, 'reference_type' 	=> 1  
						// 												, 'reference_no' 	=> cleanvars($valeOrder['purchase_order_id']) 
						// 											), 
						// 							'return_type' 	=> 'single' 
						// 						); 
    					// $valuestock 	= $dblms->getRows(STOCK, $receivedstock);
						// $qtyreceiveable = ($valueItemqty['TotalorderedQTY'] - $valuestock['TotalQTY']);
						// if($qtyreceiveable>0) {
							echo '<option value="'.$valeOrder['purchase_order_id'].'">'.$valeOrder['po_order_no'].'</option>';
						// }
					}
				}
				echo '
			</select>
		</div> 
	</div>
	<script>
		$("#vendor_order").select2({
			allowClear: true
		});
	</script>';
}
