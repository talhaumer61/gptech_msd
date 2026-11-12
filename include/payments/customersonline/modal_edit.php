<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '35', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="customeronlinepayments.php" method="post" id="editCountry">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Customer Payment</h4>
</div>

<div class="modal-body">
	<div class="col-sm-51">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Customer Name</label>
			<input type="text" class="form-control" id="customername_edit" name="customername_edit" autocomplete="off" readonly >
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated_edit" name="dated_edit" autocomplete="off" readonly >
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Payment Category</label>
			<select id="id_cat_edit" name="id_cat_edit" style="width:100%" autocomplete="off" required >
				<option value="">Select Category</option>';
			foreach($Paycats as $listcat) {
				echo '<option value="'.$listcat['cat_id'].'">'.$listcat['cat_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Pay Mode</label>
			<input type="text" class="form-control" id="pmode_edit" name="pmode_edit" readonly autocomplete="off">
		</div> 
	</div>

		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Transaction #</label>
			<input type="text" class="form-control" id="transaction_id_edit" name="transaction_id_edit" readonly autocomplete="off" required>
		</div> 
	</div>
	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_edit" name="amount_edit" readonly autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>

	
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Receipt #</label>
			<input type="text" class="form-control" id="receipt_no_edit" name="receipt_no_edit"  readonly required autocomplete="off">
		</div> 
	</div>

		
	<div class="col-sm-32">
		<div class="form_sep" style="margin-top:10px;">
			<label>Reference #</label>
			<input type="text" class="form-control" id="reference_no_edit" name="reference_no_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
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
		var dated_edit 				= $(this).attr("data-com-date");
        var id_paid_edit 			= $(this).attr("data-com-paid");
		var pmode_edit 				= $(this).attr("data-com-pmode");
		var amount_edit 			= $(this).attr("data-com-amount");
		var transaction_id_edit 	= $(this).attr("data-com-transid");
		var customername_edit 		= $(this).attr("data-com-name");
		var receipt_no_edit 		= $(this).attr("data-com-receipt");
		var reference_no_edit 		= $(this).attr("data-com-reference");
		var id_bank_edit 			= $(this).attr("data-com-bank");
		var id_account_edit 		= $(this).attr("data-com-account");
		var remarks_edit 			= $(this).attr("data-com-remarks");
		var id_cat_edit 			= $(this).attr("data-com-idcat");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")			.val(dated_edit);
		$("#pmode_edit")			.val(pmode_edit);
		$("#amount_edit")			.val(amount_edit);
		$("#customername_edit")		.val(customername_edit);
		$("#transaction_id_edit")	.val(transaction_id_edit);
		$("#receipt_no_edit")		.val(receipt_no_edit);
		$("#reference_no_edit")		.val(reference_no_edit);
		$("#remarks_edit")			.val(remarks_edit);
		$("#id_edit")				.val(id_edit);

	 	$("#id_cat_edit")			.select2().select2("val", id_cat_edit); 
  });
    
});
</script>';
}