<?php 
if(isset($_GET['id'])  && !LMS_VIEW) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '38', 'edit' => '1'))) { 
//------------------------------------------------
	
	$conditions = array ( 
								'select' 	=> ''.PAYMENTS_SCHEDULE.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS_SCHEDULE.".id_user 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' => array( 
													  ''.PAYMENTS_SCHEDULE.'.id' 		=> cleanvars($_GET['id'])
									 				, ''.PAYMENTS_SCHEDULE.'.user_type' => 1 
													, ''.PAYMENTS_SCHEDULE.'.is_deleted' => 0 
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(PAYMENTS_SCHEDULE, $conditions);

//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="customerspaymentschedule.php?id='.cleanvars($_GET['id']).'" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<input type="hidden" id="id_customer" name="id_customer" value="'.$rowstd['id_customer'].'">
<input type="hidden" id="id_ade" name="id_ade" value="'.$rowstd['ade_id'].'">
<input type="hidden" id="id_company" name="id_company" value="'.$rowstd['company_id'].'">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" onclick="location.href=\'customerspaymentschedule.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Payment Schedule Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-100">
		<div class="form_sep">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customer_name" name="customer_name" value="'.($rowstd['customer_name']).'" readonly>
		</div> 
	</div>

	<div style="clear:both;padding:5px;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$rowstd['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$rowstd['ade_cellno'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$rowstd['company_name'].'" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" value="'.($rowstd['remarks']).'" autocomplete="off">
		</div>
	</div>

	<div style="clear:both; padding:5px;"></div>

	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;font-weight:600;"> 
		Item Details
	</div>	
	<div style="clear:both;padding:5px;"></div>	
<table class="footable table table-bordered table-hover footable-loaded">
	<thead>
		<tr>
			<th style="text-align:center;">Sr #</th>
			<th style="text-align:center;">Amount</th>
			<th style="text-align:center;">Dated</th>
			<th style="text-align:center;">Remarks</th>
		</tr>
	</thead>
<tbody>';

///----------------------------------------------
	$Odconditions = array ( 
								'select' 		=> ''.PAYMENTS_SCHEDULE_DETAILS.'.*',
								'where' 		=> array( 
															''.PAYMENTS_SCHEDULE_DETAILS.'.id_setup' => cleanvars($_GET['id'])
														), 
								'order_by' 		=> ''.PAYMENTS_SCHEDULE_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(PAYMENTS_SCHEDULE_DETAILS, $Odconditions);
	
///----------------------------------------------
$inum     = 0;
$total = 0 ;
foreach($Orderdetail as $rowsdet) {
	$inum++;
	echo'
	<tr>
		<td style="width:50px; text-align:center;vertical-align: middle;">'.$inum.'</td>
		<td style="width:150px;"><input type="text" class="form-control txtinstpay" id="intamount['.$inum.']" name="intamount['.$inum.']"  autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="'.$rowsdet['amount'].'"></td>
		<td style="width:250px;">
			<input type="date" class="form-control" id="intdated['.$inum.']" name="intdated['.$inum.']" value="'.$rowsdet['dated'].'" autocomplete="off"></td>
		<td><input type="text" class="form-control" id="intremarks['.$inum.']" name="intremarks['.$inum.']" value="'.$rowsdet['remarks'].'"  autocomplete="off"></td>
	</tr>
	<input type="hidden" id="id_edit['.$inum.']" name="id_edit['.$inum.']" value="'.$rowsdet['id'].'">';
}
	
	
echo '
</tbody>
	<thead>
		<tr>
			<th style="text-align:center;"></th>
			<th style="text-align:center;">
				<input type="text" class="form-control" value="'.$rowstd['totalamount'].'" id="grand_insttotal" name="grand_insttotal" autocomplete="off" readonly></th>
			<th style="text-align:center;"></th>
			<th style="text-align:center;"></th>
		</tr>
	</thead>
	</table>

<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	 
	<button type="submit" class="btn btn-info" value="saveconfirmed" id="bill_changes" name="bill_changes"  onClick=\'return confirmSubmit()\'>Save Changes</button>
	<button type="button" class="btn btn-default" onclick="location.href=\'customerspaymentschedule.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
//--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSumint();

    $(".txtinstpay").on("keydown keyup", function() {
        calculateSumint();
    });
});

function calculateSumint() {
    var suminst = 0;
    //iterate through each textboxes and add the values
    $(".txtinstpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            suminst += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#grand_insttotal").val(suminst.toFixed(0));	
}


</script>

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
<!--JS_SELECT_LISTS-->

<script>
	$("#payment_method").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
	$().ready(function() {
		$("#inv_form").validate({
			submitHandler: function(form) {
			form.submit();
			}
		});
	});
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}