<?php 
//------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
//if($_SESSION['userlogininfo']['LOGINIDA'] == 2) { 	
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '36', 'edit' => '1'))) { 	
//------------------------------------------------	
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														  'id' => cleanvars($_GET['id'])
                                                        , 'jv_type' => 1
													) 
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $valuepurchase 	= $dblms->getRows(JOURANALVOUCHERS, $conditions);

//------------------------------------------------
$diabledFields = '';
$diabledSelect = '';
if($valuepurchase['status'] != 3 || ($_SESSION['userlogininfo']['LOGINIDA']  == 2)) {
	$editbuttn = '<button type="submit" class="btn btn-warning" value="savehold" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'> Save & Hold </button> 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="submit_changes" name="submit_changes" onClick=\'return confirmSubmit()\'>Confirmed</button>';
} else {
	$editbuttn = '';
}
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%">
<form class="form-horizontal" action="journalvouchers.php" method="post" id="inv_form" enctype="multipart/form-data">
<input type="hidden" name="idedit" name="idedit" value="'.$valuepurchase['id'].'">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'journalvouchers.php\'"><span>close</span></button> 
		<h4 class="modal-title" style="font-weight:700;"> Edit Customer Journal Vouche Detail</h4>
	</div>

<div class="modal-body">

	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Order #</label>
			<input type="text" class="form-control" id="pr_no" name="pr_no" required value="'.$valuepurchase['jv_no'].'" readonly autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req"> Date</label>
			<input type="text" class="form-control pickadate" id="dated" value="'.$valuepurchase['dated'].'" name="dated" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both; padding:5px;"></div>

	<div class="col-sm-100">
		<div class="form_sep">
			<label> Detail</label>
			<input type="text" class="form-control" id="jv_details" name="jv_details" value="'.$valuepurchase['jv_details'].'" autocomplete="off">
		</div> 
	</div>

<div style="clear:both; padding:5px;"></div>


	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:20px; font-weight:600;">
		Details
	</div>

	<table class="footable table table-bordered table-hover invE_table footable-loaded">
		<thead>
			<tr>
				<th style="text-align:center;">Sr. #</th>
				<th style="text-align:left;">Customer </th>
				<th style="text-align:center;">Credit</th>
				<th style="text-align:center; width:120px;">Debit</th>
				<th style="text-align:left; width:120px;">Remarks</th>
			</tr>
		</thead>
		<tbody>';
	///----------------------------------------------
		$POconditions = array ( 
									'select' 		=> '*',
									'where' 		=> array( 
																'id_jv' => cleanvars($_GET['id'])
															), 
									'return_type' 	=> 'all' 
								); 
		$podetails 	= $dblms->getRows(JOURANALVOUCHERS_DETAIL, $POconditions);
		$srno =0;
	
		foreach ($podetails as $rowsdet) { 
			if(($rowsdet['credit_debit'] == 1)) {
				$amountcredit = $rowsdet['amount'];
			} else {
				$amountcredit = 0;	
			}if(($rowsdet['credit_debit'] == 2)) {
				$amountdebit = $rowsdet['amount'];
			} else {
				$amountdebit = 0;
			}	
		$srno++;
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$srno.'</td>
				<td>
					<select name="id_customer['.$srno.']" id="id_customer_'.$srno.'" class="select2" style="width:100%"   autocomplete="off">
						<option value=""></option>';
						foreach($Customers as $arrayitem) { 
							echo ($arrayitem['customer_id'] == $rowsdet['id_customer']) ? '<option value="'.$arrayitem['customer_id'].'" selected>'.$arrayitem['customer_code'].' - '.$arrayitem['customer_name'].'</option>' : '<option value="'.$arrayitem['customer_id'].'">'.$arrayitem['customer_code'].' - '.$arrayitem['customer_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_credit" style="color:#00f; font-weight:600; text-align:center;" name="amout_credit['.$srno.']" id="amout_credit_'.$srno.'" value="'.$amountcredit.'"  autocomplete="off" >
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_debit" style="color:#00f; font-weight:600; text-align:center;" name="amout_debit['.$srno.']" id="amout_debit_'.$srno.'" value="'.$amountdebit.'"  autocomplete="off" >
				</td>
				<td style="width:250px;">
					<input type="text" class="form-control col-lg-12" name="detail['.$srno.']" id="detail_'.$srno.'" value="'.$rowsdet['detail'].'"  autocomplete="off" >
				</td>
				
			</tr>';	
		}
///----------------------------------------------
		for ($i=($srno+1); $i <= ($srno +5); $i++) { 
			if($i == 1) { $required = " required"; } else { $required = " "; }
			echo'
			<tr class="inv_row">
				<td class="inv_clone_row" style="width:50px; text-align:center;"><span class="footable-toggle"></span>'.$i.'</td>
				<td>
					<select name="id_customer['.$i.']" id="id_customer_'.$i.'" class="select2" style="width:100%"  '.$required.'  autocomplete="off">
						<option value=""></option>';
						foreach($Customers as $arrayitem) {
							echo '<option value="'.$arrayitem['customer_id'].'">'.$arrayitem['customer_code'].' - '.$arrayitem['customer_name'].'</option>';
						}
					echo'
					</select>
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_credit" style="color:#00f; font-weight:600; text-align:center;" name="amout_credit['.$i.']" id="amout_credit_'.$i.'"  autocomplete="off" >
				</td>
				<td style="width:130px;">
					<input type="text" class="form-control col-lg-12 jQinv_item_debit" style="color:#00f; font-weight:600; text-align:center;" name="amout_debit['.$i.']" id="amout_debit_'.$i.'"  autocomplete="off" >
				</td>
				<td style="width:250px;">
					<input type="text" class="form-control col-lg-12" name="detail['.$i.']" id="detail_'.$i.'"  autocomplete="off" >
				</td>
				
			</tr>';	
		}
echo '
</tbody>
	<thead>
			<tr class="last_row">
				<th style="text-align:center;"></th>
				<th style="text-align:left;"> </th>
				<th style="text-align:center;"><input type="text" class="form-control" id="inV_grandcreditTotal" name="inV_grandcreditTotal" value="'.$valuepurchase['totalcredits'].'" readonly></th>
				<th style="text-align:center; width:120px;"><input type="text" class="form-control"  id="inV_granddebitTotal" name="inV_granddebitTotal" value="'.$valuepurchase['totaldebits'].'" readonly></th>
				<th style="text-align:left; width:120px;"></th>
			</tr>
		</thead>
</table>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'journalvouchers.php\'">Closed</button>
	'.$editbuttn.'
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
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}