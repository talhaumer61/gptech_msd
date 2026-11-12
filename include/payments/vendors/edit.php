<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '5', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Vendor Payment</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-100">
		<div class="form_sep">
			<label>Vendor</label>
			<input type="text" class="form-control" id="vendorname_edit" name="vendorname_edit" value="" autocomplete="off" readonly>
		</div> 
	</div>

	
	<div style="clear:both;"></div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated_edit" name="dated_edit" value="" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no_edit" name="receipt_no_edit" autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="text" class="numbers form-control" id="amount_edit" name="amount_edit" required autocomplete="off" onblur="numberWithCommas(this)">
		</div> 
	</div>
	
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no_edit" name="reference_no_edit" autocomplete="off">
		</div> 
	</div>
	
<div style="clear:both;"></div>	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
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
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:10px;">
			<label>Remarks</label>
			<input type="text" class="form-control" id="remarks_edit" name="remarks_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>

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
		var receipt_no_edit			= $(this).attr("data-com-receiptno");
		var amount_edit 			= $(this).attr("data-com-amount");
		var method_edit 			= $(this).attr("data-com-method");
		var vendorname_edit 		= $(this).attr("data-com-vendors");
		var reference_no_edit 		= $(this).attr("data-com-referenceno");
		var id_bank_edit 			= $(this).attr("data-com-bank");
		var id_account_edit 		= $(this).attr("data-com-account");
		var remarks_edit 			= $(this).attr("data-com-remarks");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")			.val(dated_edit);
		$("#receipt_no_edit")		.val(receipt_no_edit);
		$("#amount_edit")			.val(amount_edit);
		$("#vendorname_edit")		.val(vendorname_edit);
		$("#reference_no_edit")		.val(reference_no_edit);
		$("#remarks_edit")			.val(remarks_edit);
		$("#id_edit")				.val(id_edit);

       //pre-select data in pull down lists
       $("#id_paid_edit")			.select2().select2("val", id_paid_edit); 
	   $("#method_edit")			.select2().select2("val", method_edit); 
	   $("#id_bank_edit")			.select2().select2("val", id_bank_edit); 
	   $("#id_account_edit")		.select2().select2("val", id_account_edit);
  });
    
});
</script>';
}