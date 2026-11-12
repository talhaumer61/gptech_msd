<?php 
//------------------------------------------------
if(LMS_VIEW == 'convertjoborder' && isset($_GET['id'])) { 
	
//------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' 	=> array ( 
														  ''.ESTIMATES.'.estimate_id' 	=> cleanvars($_GET['id'])
													), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(ESTIMATES, $conditions);

	if($rowstd['estimate_status'] == 1){
		$canEdit = '<button type="submit" class="btn btn-purple" value="savehold" id="submit_converttojoborder" name="submit_converttojoborder" onClick=\'return confirmSubmit()\'>Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="savepayment" id="submit_converttojoborder" name="submit_converttojoborder" onClick=\'return confirmSubmit()\'> Convert to Job Order </button> ';
	} else {
		$canEdit = '';
	}
	
	$debitcreditconditions = array ( 
								'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 		=> array ( 
															  ''.PAYMENTS.'.status' => 1
															, ''.PAYMENTS.'.id_user' => cleanvars($rowstd['customer_id'])
														), 
								'return_type' 	=> 'single' 
							); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	


	$openingbalance = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);
//------------------------------------------------
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="customerestimates.php?view=payments&id='.$rowstd['estimate_id'].'" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="estimate_id" name="estimate_id" value="'.$rowstd['estimate_id'].'">
<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['customer_id'].'">
<input type="hidden" id="id_company" name="id_company" value="'.$rowstd['company_id'].'">
<input type="hidden" id="openingbalance" name="openingbalance" value="'.$openingbalance.'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Estimate Detail</h4>
	</div>

<div class="modal-body">

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Estimate #</label>
			<input type="text" class="form-control" id="estimate_no" name="estimate_no" value="'.$rowstd['estimate_no'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated" name="dated" required value="'.$rowstd['estimate_date'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<input type="text" class="form-control" id="customername" name="customername" required value="'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>



	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" id="openingbalance1" name="openingbalance1" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
		</div> 
	</div>
	

	<div style="clear:both;padding:5px;"></div>
	

	<div style="clear:both;"></div>
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="estimate_remarks" name="estimate_remarks" value="'.($rowstd['estimate_remarks']).'" autocomplete="off">
		</div>
	</div>

	<div style="clear:both; padding:5px;"></div>

<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
Item Details
</div>

<table class="footable table table-bordered invE_table footable-loaded">
<thead>
	<tr>
		<th style="text-align:center;">Sr #</th>
		<th style="text-align:center;">Item Code </th>
		<th style="text-align:left;">Item Name </th>
		<th style="text-align:center;" title="Avaiable Stock">Stock</th>
		<th style="text-align:center;">Qty</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------
	$POconditions = array ( 
							  'select' 		=> ''.ESTIMATES_DETAIL.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name'
							, 'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".ESTIMATES_DETAIL.".id_item"
							, 'where' 		=> array( 
															''.ESTIMATES_DETAIL.'.id_estimate' => cleanvars($_GET['id'])
													)
							, 'order_by' 	=> ''.ESTIMATES_DETAIL.'.id ASC' 
							, 'return_type' => 'all' 
						); 
    $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

///----------------------------------------------
$i				= 0;
$total 			= 0 ;
$estimatetotal 	= 0 ;
	
foreach($podetails as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	

	
// Check Stocks In out
	$stockconditions 	= array ( 
									  'select' 		=> "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as TotalInQTY, 
														SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as TotalOutQTY"
									, 'where' 		=> array ( 
																''.STOCK.'.id_item' 	=> cleanvars($rowsdet['item_id'])
															 )
									, 'return_type' => 'single' 
								); 
    $valuestockinout 	= $dblms->getRows(STOCK, $stockconditions);
	$avaiablestock 		= ($valuestockinout['TotalInQTY'] - $valuestockinout['TotalOutQTY']);
	if($avaiablestock>=0) {
		$stockcheck = $avaiablestock;
	} else {
		$stockcheck = 0;
	}
	
	if($avaiablestock>0) { $isavailable = 1; } else { $isavailable = 0; }
	
	
	if($avaiablestock<$rowsdet['qty'] && $avaiablestock>0) {
		$estimatetotal 	= ($estimatetotal + $rowsdet['total_price']);
		$qty 			= $rowsdet['qty'];
		$unitprice 		= $rowsdet['unit_price'];
		$totalprice 	= $rowsdet['total_price'];
		$readonly 		= '';
		$bgcolor 		= ' style="background-color:#F9E6BB; font-weight:600;"';
		$stockremarks	= '';
		$stockavaiable 	= ' <span style="color:red; font-weight:600; font-size:16px;">'.$avaiablestock.'</span>';
	} elseif($avaiablestock>0 && $avaiablestock>$rowsdet['qty']) {
		$estimatetotal 	= ($estimatetotal + $rowsdet['total_price']);
		$qty 			= $rowsdet['qty'];
		$unitprice 		= $rowsdet['unit_price'];
		$totalprice 	= $rowsdet['total_price'];
		$readonly 		= '';
		$bgcolor 		= '';
		$stockremarks	= ' ';
		$stockavaiable 	= ' <span style="color:darkgreen; font-weight:600; font-size:16px; ">'.$avaiablestock.'</span>';
	} elseif($avaiablestock>0) {
		$estimatetotal 	= ($estimatetotal + $rowsdet['total_price']);
		$qty 			= $rowsdet['qty'];
		$unitprice 		= $rowsdet['unit_price'];
		$totalprice 	= $rowsdet['total_price'];
		$readonly 		= '';
		$bgcolor 		= '';
		$stockremarks	= ' ';
		$stockavaiable 	= ' <span style="color:darkgreen; font-weight:600; font-size:16px; ">'.$avaiablestock.'</span>';
	} elseif($avaiablestock <= 0) {
		$qty 			= 0;
		$unitprice 		= 0;
		$totalprice 	= 0;
		$readonly 		= ' readonly="readonly"';
		$bgcolor 		= ' style="font-weight:600;"';
		$stockremarks	= ' <span style="font-weight:600; color:#f00; font-size:14px; ">(Out of Stock)</span>';
		$stockavaiable 	= ' <span style="font-weight:600; color:#f00; font-size:16px; ">'.$avaiablestock.'</span>';
	}

	$i++;
	echo'
	<input type="hidden" name="is_available['.$i.']" id="is_available_'.$i.'" value="'.$isavailable.'">
	<input type="hidden" name="id_item['.$i.']" id="id_item_'.$i.'" value="'.$rowsdet['item_id'].'">
	<tr class="inv_row" '.$bgcolor.'>
		<td class="inv_clone_row" style="width:50px;text-align:center;vertical-align: middle;"><span class="footable-toggle"></span>'.$i.'</td>
		<td style="vertical-align: middle; width:80px;">'.$rowsdet['item_code'].'</td>
		<td style="vertical-align: middle;">'.$rowsdet['item_name'].' '.$stockremarks.'</td>
		<td style="width:120px; text-align:center;vertical-align: middle;">'.$stockavaiable.'</td>
		<td style="width:120px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" value="'.$qty.'" id="total_qty_'.$i.'" min="0" max="'.$stockcheck.'" required '.$readonly .' onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
		</td>
		
		<td style="width:120px;">
			
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$i.']" id="unit_price_'.$i.'" value="'.$unitprice.'" style="text-align:center; color:#00f; font-weight:600; font-size:14px !important;" >
			
		</td>
		<td style="width:130px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_total" value="'.$totalprice.'" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>';	
}

echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$estimatetotal.'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$estimatetotal.'">
</td>
</tr>
</tbody>	
</table>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerestimates.php\'">Closed</button>'.$canEdit.'
	
</div>
</div>
</form>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

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
	$("#id_company_edit").select2({
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
}