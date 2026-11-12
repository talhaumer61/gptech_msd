<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['vendor_order'])) {
//--------------------------------------------
	$purchaseitems = array ( 
							'select' 		=> "".PURCHASE_ORDER_DETAILS.".qty, ".PURCHASE_ORDER_DETAILS.".unit_price, 
												".ITEMS.".item_id, ".ITEMS.".item_name, ".ITEMS.".item_code",
							'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".PURCHASE_ORDER_DETAILS.".id_item",
							'where' 		=> array ( 
														''.PURCHASE_ORDER_DETAILS.'.id_po' 	=> cleanvars($_POST['vendor_order']) 
												 	), 
							'order_by' 		=> "".PURCHASE_ORDER_DETAILS.".id_item ASC",
							'return_type' 	=> 'all' 
						); 
    $PurchaseItems 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $purchaseitems);

	if (!empty($PurchaseItems)) {
echo '
	<input type="hidden" id="id_order" name="id_order" value="'.cleanvars($_POST['vendor_order']).'">
	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. # </th>
				<th style="text-align:left;">Item </th>
				<th style="text-align:center;">Ordered</th>
				<th style="text-align:center;">Already Received</th>
				<th style="text-align:center;">Receive</th>
				<th style="text-align:center;">Balance</th>
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Unit Total</th>
			</tr>
		</thead>
		<tbody>';
		$sr = 0;
		$sij = 0;
		foreach($PurchaseItems as $valueItem) {

		$sij++;
			
// Check Stocks received 
		$receivedstock = array ( 
								'select' 	=> " SUM(qty) as TotalQTY",
								'where' 	=> array( 
													  'id_item' 		=> cleanvars($valueItem['item_id']) 
													, 'stock_type' 		=> 1 
													, 'reference_type' 	=> 1  
													, 'reference_no' 	=> cleanvars($_POST['vendor_order']) 
												), 
								'return_type' 	=> 'single' 
							); 
    	$valuestock 	= $dblms->getRows(STOCK, $receivedstock);
	
	$qtyreceiveable = ($valueItem['qty'] - $valuestock['TotalQTY']);
			
if($qtyreceiveable>0) {
	
		$sr++;
			echo'
			<input type="hidden" id="id_item['.$sr.']"" name="id_item['.$sr.']"" value="'.$valueItem['item_id'].'">
			<input type="hidden" id="unit_price['.$sr.']"" name="unit_price['.$sr.']"" value="'.$valueItem['unit_price'].'">
			<tr class="inv_row">
				<td style="text-align:center; width:50px;">'.$sr.'</td>
				<td>'.$valueItem['item_code'].' - '.$valueItem['item_name'].'</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_itemtotal" id="quantity" name="quantity" style="text-align:center; font-weight:600; font-size:15px !important; color:#00f;" value="'.$valueItem['qty'].'" readonly>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_received" id="received" name="received" value="'.$valuestock['TotalQTY'].'" readonly style="text-align:center; font-weight:600; font-size:18px !important;"  autocomplete="off">
				</td>
				<td style="width:100px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_receive" id="qty['.$sr.']" name="qty['.$sr.']" min="1"  autocomplete="off">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_balance" id="balance" name="balance" value="'.$qtyreceiveable.'" readonly  autocomplete="off">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_unitprice" id="unitprice['.$sr.']" name="unitprice['.$sr.']" value="'.$valueItem['unit_price'].'" style="text-align:center; font-weight:600; font-size:14px !important; color:#f00;"   autocomplete="off">
				</td>
				<td style="width:100px;">
					<input type="text" class="form-control col-lg-12 jQinv_unittotal" id="unittotal['.$sr.']" name="unittotal['.$sr.']" value="" style="text-align:center; font-weight:600; font-size:14px !important; color:#f00;" readonly  autocomplete="off">
				</td>
				
				
			</tr>';
} else if($sr == 0 && $sij == 1) {
	echo '<tr class="inv_row"><td colspan="10"><h1 style="text-align:center; font-weight:600; color:#f00;"> All QTYS has been received.</h1></td></tr>';
}
		}
		echo'
		<tr class="last_row">
			<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
				<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
				<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0">
			</td>
		</tr>
		</tbody>	
	</table>
	<div style="clear:both;padding:5px;"></div>';
	}
}
//--------------------------------------------