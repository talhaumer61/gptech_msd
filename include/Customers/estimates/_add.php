<?php 
if(LMS_VIEW == 'add' && !isset($_GET['id'])  ) { 


	$conditions = array ( 
								'select' 		=> ''.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
													'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 			=> "INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".CUSTOMERS.".id_ade 
													INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company",
								'where' 		=> array( 
															''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);
	// get Credit Debit Payments of Customer
	
	$debitcreditconditions = array ( 
								'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 		=> array ( 
															  ''.PAYMENTS.'.status' => 1
															, ''.PAYMENTS.'.id_user' => cleanvars($valueCustomer['customer_id'])
														), 
								'return_type' 	=> 'single' 
							); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	


	$openingbalance = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form"  name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_ade" name="id_ade" value="'.$valueCustomer['ade_id'].'">
<input type="hidden" id="id_customer" name="id_customer" value="'.$valueCustomer['customer_id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;">Add Estimate Order</h4>
	
</div>

<div class="modal-body">

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Estimate #</label>
			<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="EST-'.mt_rand(100000,999999).'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated" name="dated" required value="'.date("Y-m-d").'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<input type="text" class="form-control" id="customername" name="customername" required value="'.$valueCustomer['customer_code'].' - '.$valueCustomer['customer_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>



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

	<div style="clear:both;padding:5px;"></div>
	


		

	<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Item Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. #</th>
				<th style="text-align:left;">Items </th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Unit Price</th>
				<th style="text-align:center;">Total</th>
			</tr>
		</thead>
		<tbody>';
		///----------------------------------------------
		for ($i=1; $i <=25; $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_item['.$i.']" id="id_item_'.$i.'" class="id_item" style="width:100%"  '.$required.'  autocomplete="off" onchange="get_PrdEstimateValue(this.value, '.$i.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" id="total_qty_'.$i.'"  autocomplete="off" '.$required.' >
				</td>
				
				<td style="width:130px;">
					<div id="getPrdEstimateValue_'.$i.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" name="unit_price['.$i.']" id="unit_price_'.$i.'" readonly  autocomplete="off" '.$required.' >
					</div>		
					
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
				</td>
			</tr>';	
		}
echo'
<tr class="last_row">
	<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
		<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span></span></span></b></p>
		<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span></span></span></b></p>
		<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="0.00">
		<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="0.00">
	</td>
</tr>
</tbody>	
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php\'">Closed</button>
		<input class="btn btn-primary" type="submit" value=" Add Record " id="submit_purchase_order" name="submit_purchase_order" onClick=\'return confirmSubmit()\'>
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--JS_SELECT_LISTS-->

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>
<script>
    $(".select2").select2({
        allowClear: true
    });
    
    $(".id_item").select2({
        allowClear: true
    });
	
	$("#id_type").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#inv_form").validate({
		rules: {
             company_name		: "required",
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}
