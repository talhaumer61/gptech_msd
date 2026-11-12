<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customerpayments.php" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Payment</h4>
</div>

<div class="modal-body">
	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Account Name</label>
			<select id="id_account_edit" name="id_account_edit" style="width:100%" autocomplete="off" required tabindex="1">
				<option value="">Select Account</option>';
			$sqllmsaccount	= $dblms->querylms("SELECT account_id, account_name 
													FROM ".ACCOUNTS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND account_status = '1' ORDER BY account_name ASC");
				while($valueaccount	= mysqli_fetch_array($sqllmsaccount)) {  
					echo '<option value="'.$valueaccount['account_id'].'">'.$valueaccount['account_name'].' </option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Customer Name</label>
			<select id="id_paid_edit" name="id_paid_edit" style="width:100%" autocomplete="off" required tabindex="2">
				<option value="">Select Customer</option>';
			$sqllmsloc	= $dblms->querylms("SELECT customer_id, customer_name, customer_cellno  
													FROM ".CUSTOMERS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND customer_status = '1' ORDER BY customer_name ASC");
				while($valueloc 	= mysqli_fetch_array($sqllmsloc)) {  
					echo '<option value="'.$valueloc['customer_id'].'">'.$valueloc['customer_name'].' - '.$valueloc['customer_cellno'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated_edit" name="dated_edit" autocomplete="off" tabindex="3">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Slip #</label>
			<input type="text" class="form-control" id="slipno_edit" name="slipno_edit" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_edit" name="amount_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Payment Method</label>
			<select id="method_edit" name="method_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Method</option>';
			foreach($pay_types as $itempaytypes) {
				echo '<option value="'.$itempaytypes['id'].'">'.$itempaytypes['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Type</label>
			<select id="type_edit" name="type_edit" style="width:100%" autocomplete="off" required>';
			foreach($ptypes as $iteptypess) {
				echo '<option value="'.$iteptypess['id'].'">'.$iteptypess['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque #</label>
			<input type="text" class="form-control" id="cheque_edit" name="cheque_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque Date</label>
			<input type="text" class="form-control pickadate" id="cheque_date_edit" name="cheque_date_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Banks</label>
			<select id="id_bank_edit" name="id_bank_edit" style="width:100%" autocomplete="off">
				<option value="">Select Bank</option>';
				$sqllmsbanks	= $dblms->querylms("SELECT bank_id, bank_name 
													FROM ".BANKS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND bank_status = '1' ORDER BY bank_name ASC");
				while($valuebanks 	= mysqli_fetch_array($sqllmsbanks)) {  
					echo '<option value="'.$valuebanks['bank_id'].'">'.$valuebanks['bank_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks_edit" name="remarks_edit" autocomplete="off">
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="id_edit" name="id_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
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

<script type="text/javascript">
$(document).ready(function(){
//---edit item link clicked-------
    $(".edit-country-modal").click(function(){
    
        //get variables from "edit link" data attributes
		var dated_edit 				= $(this).attr("data-com-dated");
        var id_paid_edit 			= $(this).attr("data-com-paid");
		var slipno_edit 			= $(this).attr("data-com-slipno");
		var amount_edit 			= $(this).attr("data-com-amount");
		var method_edit 			= $(this).attr("data-com-method");
		var type_edit 				= $(this).attr("data-com-ptype");
		var cheque_edit 			= $(this).attr("data-com-cheque");
		var cheque_date_edit 		= $(this).attr("data-com-chequedate");
		var id_bank_edit 			= $(this).attr("data-com-bank");
		var id_account_edit 		= $(this).attr("data-com-account");
		var remarks_edit 			= $(this).attr("data-com-remarks");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")			.val(dated_edit);
		$("#slipno_edit")			.val(slipno_edit);
		$("#amount_edit")			.val(amount_edit);
		$("#cheque_edit")			.val(cheque_edit);
		$("#cheque_date_edit")		.val(cheque_date_edit);
		$("#remarks_edit")			.val(remarks_edit);
		$("#id_edit")				.val(id_edit);

       //pre-select data in pull down lists
       $("#id_paid_edit")			.select2().select2("val", id_paid_edit); 
	   $("#method_edit")			.select2().select2("val", method_edit); 
	   $("#type_edit")				.select2().select2("val", type_edit); 
	   $("#id_bank_edit")			.select2().select2("val", id_bank_edit); 
	   $("#id_account_edit")		.select2().select2("val", id_account_edit); 
  });
    
});
</script>';
}