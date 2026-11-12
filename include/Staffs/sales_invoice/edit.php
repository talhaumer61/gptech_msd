<?php 

if(!LMS_VIEW && isset($_GET['id'])) { 
//------------------------------------------------
//if(($_SESSION['userlogininfo']['LOGINIDA'] == 2)) { 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '2', 'edit' => '1'))) { 
//------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.SALES_INVOICE.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name,
												'.JOB_ORDER.'.job_order_id, '.JOB_ORDER.'.job_order_status, '.JOB_ORDER.'.job_order_no, 
												'.JOB_ORDER.'.opening_balance',
								'join' 		=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer 
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".SALES_INVOICE.".id_ade 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".SALES_INVOICE.".id_company",
								'where' => array( 
													''.SALES_INVOICE.'.salesinvoice_id' 	=> cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueinvoice 	= $dblms->getRows(SALES_INVOICE, $conditions);


	$saveholdbutton = '<button type="submit" class="btn btn-warning" value="savehold" id="submit_changes" name="submit_changes"  onClick=\'return confirmSubmit()\'> Save & Hold </button>';
	
	if($_SESSION['userlogininfo']['LOGINIDA'] == 2) { $discountreadonly = ' '; } else { $discountreadonly = ' readonly'; }
//------------------------------------------------
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_order" name="id_order" value="'.$valueinvoice['job_order_id'].'">
<input type="hidden" id="id_company" name="id_company" value="'.$valueinvoice['company_id'].'">
<input type="hidden" id="id_customer" name="id_customer" value="'.$valueinvoice['customer_id'].'">
<input type="hidden" id="customer_openingbalance" name="customer_openingbalance" value="'.$valueinvoice['opening_balance'].'">
<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'sales-invoice.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Sales Invoice</h4>
	</div>

<div class="modal-body">
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Invoice #</label>
			<input type="text" class="form-control" id="salesinvoice_no"  name="salesinvoice_no" readonly value="'.$valueinvoice['salesinvoice_no'].'" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Job Order #</label>
			<input type="text" class="form-control" id="job_order_no" name="job_order_no" value="'.($valueinvoice['job_order_no']).'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Order Date</label>
			<input type="text" class="form-control" id="dated" value="'.$valueinvoice['dated'].'" name="dated" autocomplete="off" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customer_name" name="customer_name" value="'.($valueinvoice['customer_name']).'" readonly>
		</div> 
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" value="'.$valueinvoice['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" value="'.$valueinvoice['ade_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($valueinvoice['opening_balance']).'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" value="'.$valueinvoice['company_name'].'" readonly>
		</div> 
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label>Freight Charges</label>
			<input type="text" class="form-control" id="freight_charges" name="freight_charges" value="'.$valueinvoice['freight_charges'].'" oninput="this.value = this.value.replace(/\D+/g, \'\')" autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Total Receiveable</label>
			<input type="text" class="form-control" id="receiveable" name="receiveable" value="'.$valueinvoice['grand_total'].'" autocomplete="off" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Total Paid</label>
			<input type="text" class="form-control" id="total_paid" name="paid_date" value="'.$valueinvoice['paid'].'" readonly autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Total Remaining</label>
			<input type="text" class="form-control" id="total_remaining" name="total_remaining" value="'.(($valueinvoice['total'] + $valueinvoice['prev_balance']) - $valueinvoice['paid']).'" readonly autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" value="'.($valueinvoice['remarks']).'" autocomplete="off">
		</div>
	</div>
<div style="clear:both;"></div>

<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">Item Details</div>

<table class="footable table table-bordered table-hover invE_table footable-loaded">
<thead>
	<tr>
		<th style="text-align:center;">Sr #</th>
		<th style="text-align:left;">Items </th>
		<th style="text-align:center;">Stock in Hand</th>
		<th style="text-align:center;">Qty</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Discount %</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span>'.$valueinvoice['total'].'</span></span></b></p>
</td>
</tr>';
///----------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.SALES_INVOICE_DETAILS.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".SALES_INVOICE_DETAILS.".id_item",
								'where' => array( 
													''.SALES_INVOICE_DETAILS.'.id_salesinvoice' 	=> cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.SALES_INVOICE_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(SALES_INVOICE_DETAILS, $Odconditions);

///----------------------------------------------
$i=0;
$total = 0 ;
foreach($Orderdetail as $rowsdet) {
	$total = $total +$rowsdet['total']; 

// Check Stocks In Out
	$Stockconditions = array ( 
								'select' 	=> "SUM(CASE WHEN stock_type = '1' then qty end) as TotalInQTY, 
												SUM(CASE WHEN stock_type = '2' then qty end) as TotalOutQTY",
								'where' => array( 
													'id_item' => cleanvars($rowsdet['item_id'])
												), 
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut 	= $dblms->getRows(STOCK, $Stockconditions);

	
	$avaiablestock = ($resulttotalInOut['TotalInQTY'] - $resulttotalInOut['TotalOutQTY']);

	$backgroundColor = '';
	/*
	if($rowStock['stock_available'] < $rowsdet['qty']){
		$backgroundColor = 'style="background-color:red;color:#fff;"';
	}
	*/
	if($valueinvoice['salesinvoice_status'] == 5) {
		 $mincheck = ''; 
		 $maxcheck = ''; 
		
	} else {
		if($avaiablestock == 0) { $mincheck = ' min="0"'; } else { $mincheck = ' min="1"'; }
		$maxcheck = ' max="'.$avaiablestock.'"';
		// $maxcheck = ''; 
	}
	
	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<input type="text" class="form-control col-lg-12" id="item_name_'.$i.'" name="item_name['.$i.']" value="'.$rowsdet['item_code'].' - '.str_replace('"', '“', $rowsdet['item_name']).'" readonly>
		</td>
		<td style="width:120px;">
			<input type="text" class="form-control col-lg-12" style="text-align:center; color:#00f; font-size:16px !important;  font-weight:600;"  id="stock_'.$i.'" name="stock['.$i.']" '.$backgroundColor.' value="'.$avaiablestock.'" readonly>
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" '.$maxcheck.' name="qty['.$i.']" value="'.$rowsdet['qty'].'" id="qty_'.$i.'" '.$mincheck.' style="text-align:center; font-weight:600;">
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">	
		</td>
		<td  style="width:100px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_discount" name="discount_percentage['.$i.']" id="discount_percentage'.$i.'" value="'.$rowsdet['discount'].'" autocomplete="off"  style="text-align:center; font-weight:600; color:#f00;" '.$discountreadonly.'>
		</td>
		<td style="width:130px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total'].'" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>
	<input type="hidden" id="item_id_'.$i.'" name="item_id['.$i.']" value="'.$rowsdet['item_id'].'" readonly>';	
}
echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total: <span class="inV_grandtotal">Rs.<span>'.$total.'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$total.'">
</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'sales-invoice.php\'">Close</button>
	<input type="hidden" id="salesinvoice_id" name="salesinvoice_id" value="'.cleanvars($_GET['id']).'"> 
	 '.$saveholdbutton.'
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_changes" name="submit_changes"  onClick=\'return confirmSubmit()\'>Confirmed</button>';

echo '
</div>
</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

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

<script src="js/salesinvoice.js"></script>

<!--JS_SELECT_LISTS-->

<script>
	$(".select2").select2({
        allowClear: true
    });
	$("#id_company_edit").select2({
        allowClear: true
    });
	$("#id_ade_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
	$().ready(function() {
		
		$("#inv_form").validate({
			rules: {
				company_name_edit		: "required",
				company_status_edit	: "required"
			},
			messages: {
				company_name_edit		: "This field is required",
				company_status_edit		: "This field is required"
			},
			submitHandler: function(form) {
			form.submit();
			}
		});
	});
</script>';

//------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
	
}