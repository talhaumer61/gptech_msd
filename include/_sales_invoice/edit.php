<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
//------------------------------------------------
	$sqlrow = $dblms->querylms("SELECT inv.*, jo.job_order_id, jo.job_order_status, jo.job_order_no,
									cu.customer_name, cu.customer_openingbalance, ad.ade_name, 
									ad.ade_cellno, cm.company_id, cm.company_name, jo.opening_balance 
									FROM ".SALES_INVOICE." inv 
									INNER JOIN ".JOB_ORDER." jo ON jo.job_order_id = inv.id_joborder
									INNER JOIN ".CUSTOMERS." cu ON cu.customer_id = inv.id_customer 
									INNER JOIN ".ADES." ad ON ad.ade_id = inv.id_ade 
									INNER JOIN ".COMPANY." cm ON cm.company_id = inv.id_company 
									WHERE inv.salesinvoice_id = '".cleanvars($_GET['id'])."' 
									LIMIT 1");
	$valueinvoice = mysqli_fetch_assoc($sqlrow);
//------------------------------------------------
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="#" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_order" name="id_order" value="'.$valueinvoice['job_order_id'].'">
<input type="hidden" id="id_company" name="id_company" value="'.$valueinvoice['company_id'].'">
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
			<input type="text" class="form-control" id="salesinvoice_no"   name="salesinvoice_no" readonly value="'.$valueinvoice['salesinvoice_no'].'" required autocomplete="off">
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

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Total Receiveable</label>
			<input type="text" class="form-control" id="receiveable" name="receiveable" value="'.$valueinvoice['grand_total'].'" autocomplete="off" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Total Paid</label>
			<input type="text" class="form-control" id="total_paid" name="total_paid" value="'.$valueinvoice['paid'].'" readonly autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Total Remaining</label>
			<input type="text" class="form-control" id="total_remaining" name="total_remaining" value="'.$valueinvoice['balance'].'" readonly autocomplete="off">
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
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------
$sqllmsdet  = $dblms->querylms("SELECT * FROM ".SALES_INVOICE_DETAILS." d
										INNER JOIN ".ITEMS." it ON it.item_id = d.id_item 
										WHERE d.id_salesinvoice = '".cleanvars($_GET['id'])."'");
///----------------------------------------------
$i=0;
$total = 0 ;
while ($rowsdet = mysqli_fetch_assoc($sqllmsdet)) {
	$total = $total +$rowsdet['total']; 

// Check Stocks In 
	$sqllmsstockin  = $dblms->querylms("SELECT SUM(qty) as TotalInQTY 
									FROM ".STOCK."  
									WHERE stock_type = '1' AND id_item = '".cleanvars($rowsdet['item_id'])."'");
	$valuestockin = mysqli_fetch_array($sqllmsstockin);

// Check Out
	$sqllmsstockout  = $dblms->querylms("SELECT SUM(qty) as TotalOutQTY 
									FROM ".STOCK."  
									WHERE stock_type = '2' AND id_item = '".cleanvars($rowsdet['item_id'])."'");
	$valuestockout = mysqli_fetch_array($sqllmsstockout);
	$avaiablestock = ($valuestockin['TotalInQTY'] - $valuestockout['TotalOutQTY']);

	$backgroundColor = '';
	/*
	if($rowStock['stock_available'] < $rowsdet['qty']){
		$backgroundColor = 'style="background-color:red;color:#fff;"';
	}
	*/
	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<input type="text" class="form-control col-lg-12" id="item_name_'.$i.'" name="item_name['.$i.']" value="'.$rowsdet['item_code'].' - '.$rowsdet['item_name'].'" readonly>
		</td>
		<td style="width:120px;">
			<input type="text" class="form-control col-lg-12" style="text-align:center; color:#00f; font-size:16px !important;  font-weight:600;"  id="stock_'.$i.'" name="stock['.$i.']" '.$backgroundColor.' value="'.$avaiablestock.'" readonly>
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" max="'.$avaiablestock.'" name="qty['.$i.']" value="'.$rowsdet['qty'].'" id="qty_'.$i.'" min="1">
		</td>
		<td style="width:85px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly value="'.$rowsdet['unit_price'].'" name="unit_price['.$i.']" id="unit_price_'.$i.'">	
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
<p class="clearfix"><b> Invoice Total: <span class="inV_grandtotal">Rs.<span>'.$valueinvoice['total'].'</span></span></b></p>
<p class="clearfix"><b> Opening Balance: <span class="inVgrandtotal">Rs.<span>'.$valueinvoice['opening_balance'].'</span></span></b></p>
<p class="clearfix"><b> Total Receiveable: <span class="inV_receiveable">Rs.<span>'.$valueinvoice['grand_total'].'</span></span></b></p>
<p class="clearfix"><b> Advance Paid: <span class="inV_paid">Rs.<span>'.$valueinvoice['paid'].'</span></span></b></p>
<p class="clearfix"><b> Total Remaining: <span class="inV_remaining">Rs.<span>'.$valueinvoice['balance'].'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$total.'">
<input type="hidden" id="inV_receiveable" name="inV_receiveable" value="'.$valueinvoice['grand_total'].'">
</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'sales-invoice.php\'">Close</button>
	<input type="hidden" id="salesinvoice_id" name="salesinvoice_id" value="'.cleanvars($_GET['id']).'"> 
	<button type="submit" class="btn btn-warning" value="savehold" id="submit_changes" name="submit_changes"> Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_changes" name="submit_changes">Confirmed</button>';

echo '
</div>
</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->


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
</script>
<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes

		var item_status_edit			 = $(this).attr("data-item-status");
		var item_code_edit				 = $(this).attr("data-item-code");
		var item_name_edit				 = $(this).attr("data-item-name");
		var item_type_edit				 = $(this).attr("data-item-type");
		var item_reorder_edit			 = $(this).attr("data-item-reorder");
		var item_details_edit			 = $(this).attr("data-item-details");
		var item_pricepurchase_edit		 = $(this).attr("data-item-pricepurchase");
		var item_pricesale_edit			 = $(this).attr("data-item-pricesale");
		var id_cls_edit					 = $(this).attr("data-id-cls");
		var id_company_edit				 = $(this).attr("data-id-company");
		var item_id_edit				 = $(this).attr("data-item-id");
		var id_cat_edit				 	= $(this).attr("data-id-cat");


        //set modal input values dynamically
		$("#item_code_edit") 			.val(item_code_edit) 
		$("#item_name_edit") 			.val(item_name_edit) 
		// $("#item_type_edit") 			.val(item_type_edit) 
		$("#item_reorder_edit") 		.val(item_reorder_edit) 
		$("#item_details_edit") 		.val(item_details_edit) 
		$("#item_pricepurchase_edit") 	.val(item_pricepurchase_edit) 
		$("#item_pricesale_edit") 		.val(item_pricesale_edit) 
		$("#item_id_edit") 				.val(item_id_edit) 


       //pre-select data in pull down lists
       $("#item_type_edit")				.select2().select2("val", item_type_edit); 
       $("#item_status_edit")			.select2().select2("val", item_status_edit); 
       $("#id_cls_edit")				.select2().select2("val", id_cls_edit); 
       $("#id_company_edit")			.select2().select2("val", id_company_edit); 
       $("#id_cat_edit")			.select2().select2("val", id_cat_edit); 
  });
    
});
</script>';
}