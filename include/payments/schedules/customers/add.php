<?php 
//------------------------------------------------
if(!isset($_GET['id']) && LMS_VIEW == 'add')  { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '38', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'customerspaymentschedule.php\'"><span>close</span></button> 
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Payment Schedule Detail</h4>
</div>

<div class="modal-body">';

//------------------------------------------------
echo '
	<div class="col-sm-100">
		<div class="form_sep">
			<label class="req">Customer Name </label>
			<select id="id_customer" name="id_customer" onchange="get_customerdetail(this.value)" style="width:100%" required autocomplete="off" autofocus tabindex="1">
					<option value="">Choose Customer</option>';
			
				foreach($Customers as $listcusts) { 
					echo '<option value="'.$listcusts['customer_id'].'">'.$listcusts['customer_code'].' - '.$listcusts['customer_name'].'</option>';
				}
				echo'
				</select>
		</div> 
	</div>
	
	<div style="clear:both;padding:5px;"></div>

	<div id="getcustomerdetail">

		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Name</label>
				<input type="text" class="form-control" id="ade_name" name="ade_name" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>ADE Phone #</label>
				<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Opening Balance</label>
				<input type="text" class="form-control" id="customer_openingbalance" name="customer_openingbalance" required readonly>
			</div> 
		</div>
		<div class="col-sm-32">
			<div class="form_sep">
				<label>Company Name</label>
				<input type="text" class="form-control" id="id_company" name="id_company" required readonly>
			</div> 
		</div>

		<div style="clear:both;padding:5px;"></div>
	
	</div>
	
	<div style="clear:both;"></div>
	<div class="col-lg-12 heading-modal" style="margin-top:20px; margin-bottom:10px; font-weight:600;">Payment Schedule</div>
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">No of Installments</label>
			<select id="installments" name="installments" style="width:100%" autocomplete="off" required  onchange="get_installments(this.value)">
				<option value="">Select </option>';
				for($inum = 1; $inum<=50; $inum++) { 
					echo '<option value="'.$inum.'">'.$inum.'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	<br>
	<div style="clear:both; margin-top:20px; margin-bottom:20px;"></div>
	<div id="getinstallments">
	</div>
	

</div>

<div class="modal-footer">

	<button type="submit" class="btn btn-warning" value="savehold" id="submit_order" name="submit_order"  onClick=\'return confirmSubmit()\'>Save Record</button>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="location.href=\'customerspaymentschedule.php\'">Closed</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    
	$("#inv_form").validate({
		rules: {
             id_paid_edit	: "required",
			 method_edit	: "required"
		},
		messages: {
			id_paid_edit	: "This field is required",
			method_edit		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
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
	$("#id_customer").select2({
        allowClear: true
    });
	
</script>';

} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
}