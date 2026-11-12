<?php 
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_vendor'])) {
//--------------------------------------------	
	$conditions = array ( 
								'select' 		=> '*',
								'where' 		=> array ( 
															'vendor_id' 	=> cleanvars($_POST['id_vendor'])
														 ), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueVendor 	= $dblms->getRows(VENDORS, $conditions);

	// get Credit Payments of Vendors
	
// get Credit & Debit Payments of Customer

	$debitcreditconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
								'where' 		=> array ( 
															''.PAYMENTS.'.status' 	=> 1 , 
															''.PAYMENTS.'.id_user' 	=> cleanvars($_POST['id_vendor']) 
														 ), 								
								'return_type' 	=> 'single' 
							); 
    $valuecrditdebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance 	= ($valuecrditdebit['TotalCredit'] - $valuecrditdebit['TotalDebit']);
	
	
// get all items
	$itemsconditions = array ( 
								'select' 		=> 'item_id, item_name, item_code',
								'not_equal' 	=> array ( 
															'item_id' => 0 
														 ), 
								'order_by' 		=> 'item_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Items = $dblms->getRows(ITEMS, $itemsconditions);

//--------------------------------------------
echo ' 
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>




	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr #</th>
				<th style="text-align:left;">Items </th>
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';

		///----------------------------------------------
		for ($i=1; $i <= 25; $i++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:40px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td style="width:400px;">
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="select2" style="width:100% !important;"  autocomplete="off" onchange="get_returnPurchaseValue(this.value,'.$_POST['id_vendor'].', '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '
							<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
					
				
				<td style="width:70px;">
				<div id="getreturnPurchaseValue_'.$i.'">
			
					<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$i.']" id="unit_price_'.$i.'" autocomplete="off">
					
				</div>
						
				</td>
				
				
					<td  style="width:70px;">
						<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$i.']" id="total_qty_'.$i.'" style="text-align:center; color:#00f; font-weight:600; font-size:16px !important;" autocomplete="off">
					</td>
				
				<td style="width:120px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
				</td>
			</tr>';	
			
			
		}
echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_invoicetotal">Rs.<span></span></span></b></p>
		<p class="clearfix"><b>Deducation % </b><input type="number" class="jQinv_deducation" id="deducation_per" name="deducation_per" value="0" style="font-weight:600;color: chocolate;text-align:center; width:100px;" min="0" max="70"></p>
		<p class="clearfix"><b>Deducation Amount <span class="inV_deducation">Rs.<span></span></span></b></p>
		<p class="clearfix"><b> Grand Total: <span class="inV_grandtotal">Rs.<span></span></span></b></p>

		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="0.00">
		<input type="hidden" id="inV_deducation" name="inV_deducation" value="0.00">
		<input type="hidden" id="inV_invoicetotal" name="inV_invoicetotal" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

	<div style="clear:both;"></div>	
	<input type="hidden" id="vendor_openingbalance" name="vendor_openingbalance" value="'.$openingbalance.'">
	<div style="clear:both;padding:5px;"></div>
	<script>
	$(".select2").select2({
		allowClear: true
	});
    
	
</script>';
}
//--------------------------------------------
