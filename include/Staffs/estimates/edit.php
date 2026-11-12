<?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '34', 'edit' => '1'))) { 
//------------------------------------------------
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
		$canEdit = '<button type="submit" class="btn btn-warning" value="savehold" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'> Save & Hold </button> ';
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
<form class="form-horizontal" action="customerestimates.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="estimate_id" name="estimate_id" value="'.$rowstd['estimate_id'].'">
<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['id_customer'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'customerestimates.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Estimate Detail</h4>
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
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
		</div> 
	</div>
	<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
	<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['customer_id'].'">

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

<table class="footable table table-bordered table-hover invE_table footable-loaded">
<thead>
	<tr>
		<th style="text-align:center;">Sr #</th>
		<th style="text-align:left;">Items </th>
		<th style="text-align:center;">Qty</th>
		<th style="text-align:center;">Unit Price</th>
		<th style="text-align:center;">Total</th>
	</tr>
</thead>
<tbody>';
///----------------------------------------------
	$POconditions = array ( 
								'select' 		=> '*',
								'where' 		=> array( 
															'id_estimate' => cleanvars($_GET['id'])
														), 
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

///----------------------------------------------
$i=0;
$total = 0 ;
foreach ($podetails as $rowsdet) {
	$total = $total +$rowsdet['total_price']; 
	

	$readonly = '';

	$i++;
	echo'
	<tr class="inv_row">
		<td class="inv_clone_row" style="width:50px;text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
		<td>
			<select name="id_item['.$i.']" id="id_item_'.$i.'" style="width:100%" autocomplete="off" onchange="get_PrdEstimateValue(this.value, '.$i.')">
				<option value=""></option>';
				foreach($Items as $arrayitem) {
					if($arrayitem['item_id'] == $rowsdet['id_item']){
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo '
					<option value="'.$arrayitem['item_id'].'" '.$selected.'>
						'.$arrayitem['item_code'].' '.$arrayitem['item_name'].'
					</option>';
				}
			echo'
			</select>
		</td>
		<td style="width:120px;">
			<input type="text" class="form-control col-lg-12 jQinv_item_qty " style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$i.']" value="'.$rowsdet['qty'].'" id="total_qty_'.$i.'" '.$readonly.'>
		</td>
		
		<td style="width:120px;">
			<div id="getPrdEstimateValue_'.$i.'">
				<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$i.']" id="unit_price_'.$i.'" value="'.$rowsdet['unit_price'].'" style="text-align:center; color:#00f; font-weight:600; font-size:14px !important;">
			</div>		
			
		</td>
		<td style="width:130px;">
			<input type="number" class="form-control col-lg-12 jQinv_item_total" value="'.$rowsdet['total_price'].'" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$i.']" id="total_price_'.$i.'" readonly="" style="text-align:right;">
		</td>
	</tr>
	<script>
		$("#id_item_'.$i.'").select2({
			allowClear: true
		});
	</script>';	
}
	///----------------------------------------------
	$ijn = ($i+1);
		for ($ij=$ijn; $ij <= ($i+10); $ij++) {
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$ij.'</td>
				<td>
					<select name="id_item['.$ij.']" id="id_item_'.$ij.'" class="id_item" style="width:100%"  autocomplete="off" onchange="get_PrdEstimateValue(this.value, '.$ij.')">
						<option value=""></option>';
						foreach($Items as $arrayitem) {
							echo '<option value="'.$arrayitem['item_id'].'">'.$arrayitem['item_code'].' - '.$arrayitem['item_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_qty" style="color:#00f; font-weight:600; text-align:center;" name="total_qty['.$ij.']" id="total_qty_'.$ij.'"  autocomplete="off"  >
				</td>
				
				<td style="width:130px;">
					<div id="getPrdEstimateValue_'.$ij.'">
						<input type="text" class="form-control col-lg-12 jQinv_item_rate" readonly name="unit_price['.$ij.']" id="unit_price_'.$ij.'" style="text-align:center; color:#00f; font-weight:600; font-size:14px !important;">
					</div>		
					
				</td>
				<td style="width:150px;">
					<input type="number" class="form-control col-lg-12 jQinv_item_total" style="color:orangered; font-weight:600; text-align:center;" name="total_price['.$ij.']" id="total_price_'.$ij.'" readonly="" style="text-align:right;">
				</td>
			</tr>
			<script>
				$("#id_item_'.$ij.'").select2({
					allowClear: true
				});
			</script>';	
		}
echo'
<tr class="last_row">
<td colspan="15" style="text-align:right;"><span class="footable-toggle"></span>
<p class="clearfix"><b> Total Bill Amount: <span class="inV_grandtotal">Rs.<span>'.$rowstd['estimate_total'].'</span></span></b></p>
<input type="hidden" id="inV_grandtotal" name="inV_grandtotal" value="'.$rowstd['estimate_total'].'">
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
//------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}