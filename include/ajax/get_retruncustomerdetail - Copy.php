<?php 
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_customer'])) {
//--------------------------------------------	
	$sqllmsCustomer  = $dblms->querylms("SELECT cu.customer_id, cu.customer_openingbalance, ad.ade_id, ad.ade_name, ad.ade_cellno, 
											cm.company_id, cm.company_name
											FROM ".CUSTOMERS." cu
											INNER JOIN ".ADES." ad ON ad.ade_id =  cu.id_ade 
											INNER JOIN ".COMPANY." cm ON cm.company_id =  cu.id_company 
											WHERE cu.customer_id = '".$_POST['id_customer']."' LIMIT 1");
	$valueCustomer = mysqli_fetch_array($sqllmsCustomer);


	// get Credit Payments of Vendors
	$sqllmscredit  = $dblms->querylms("SELECT SUM(amount) as TotalCredit
									FROM ".PAYMENTS."  
									WHERE status = '1' AND id_user = '".cleanvars($_POST['id_customer'])."'
									AND ledgerfor = '1'  AND debit_credit = '1'");
	$valuecrdit = mysqli_fetch_array($sqllmscredit);
// get Debit Payments of Vendors
	$sqllmsdebit  = $dblms->querylms("SELECT SUM(amount) as TotalDebit
									FROM ".PAYMENTS."  
									WHERE status = '1' AND id_user = '".cleanvars($_POST['id_customer'])."'
									AND ledgerfor = '1'  AND debit_credit = '2'");
	$valuedebit = mysqli_fetch_array($sqllmsdebit);
	
	$openingbalance = ($valuedebit['TotalDebit'] - $valuecrdit['TotalCredit']);
//--------------------------------------------
echo ' 
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$valueCustomer['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$valueCustomer['ade_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$valueCustomer['company_name'].'" readonly>
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
			$sqllmsitem  = $dblms->querylms("SELECT it.item_id, it.item_name, it.item_code FROM ".SALES_INVOICE_DETAILS." d
												INNER JOIN ".SALES_INVOICE." inv ON inv.salesinvoice_id = d.id_salesinvoice 
												INNER JOIN ".ITEMS." it ON it.item_id = d.id_item 
												WHERE inv.id_customer = '".$_POST['id_customer']."' 
												GROUP BY d.id_item ORDER BY item_name ASC");
			while($valueitem 	= mysqli_fetch_assoc($sqllmsitem)) {
				$arrayitems[] = $valueitem;
			}
		///----------------------------------------------
		for ($i=1; $i <= 20; $i++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td style="width:400px;">
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="select2" style="width:100% !important;"   autocomplete="off" onchange="getReturnPrdValue(this.value,'.$_POST['id_customer'].', '.$i.')">
						<option value=""></option>';
						foreach($arrayitems as $arrayitem) {
							echo '
							<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
					
				
				<td style="width:100px;">
				<div id="getReturnPrdValue_'.$i.'">
			
					<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$i.']" id="unit_price_'.$i.'">
					
				</div>
						
				</td>
				
				
					<td  style="width:100px;">
						<input type="text" class="form-control col-lg-12 jQinv_item_qty" name="total_qty['.$i.']" id="total_qty_'.$i.'">
					</td>
				
				<td style="width:120px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
				</td>
			</tr>
			';	
			
			
		}
echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

	<div style="clear:both;"></div>	
	<input type="hidden" id="id_ade" name="id_ade" value="'.$valueCustomer['ade_id'].'">
	<input type="hidden" id="customer_openingbalance" name="customer_openingbalance" value="'.$openingbalance.'">
	<input type="hidden" id="id_company" name="id_company" value="'.$valueCustomer['company_id'].'">
	<div style="clear:both;padding:5px;"></div>
	<script>
	$(".select2").select2({
		allowClear: true
	});
    
	
</script>';
}
//--------------------------------------------
?>