<?php 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Vendor Cheque</h4>
</div>

<div class="modal-body">
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Vendor Name</label>
			<input type="text" class="form-control pickadate" id="vendor_name_edit" name="vendor_name_edit" autocomplete="off" readonly>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control" id="dated_edit" name="dated_edit" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Slip #</label>
			<input type="text" class="form-control" id="slipno_edit" name="slipno_edit" readonly autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Amount</label>
			<input type="number" class="form-control" id="amount_edit" name="amount_edit" readonly autocomplete="off">
		</div> 
	</div>
		
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque #</label>
			<input type="text" class="form-control" id="cheque_edit" name="cheque_edit" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cheque Date</label>
			<input type="text" class="form-control" id="cheque_date_edit" name="cheque_date_edit" readonly autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Banks</label>
			<input type="text" class="form-control" id="bank_name_edit" name="bank_name_edit" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cleared Date</label>
			<input type="text" class="form-control pickadate" id="cheque_cleardate_edit" name="cheque_cleardate_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="chequestatus_edit" name="cheque_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($cheques as $itemchequesedit) {
				echo '<option value="'.$itemchequesedit['id'].'">'.$itemchequesedit['name'].'</option>';
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
        var vendor_name_edit 		= $(this).attr("data-com-paid");
		var slipno_edit 			= $(this).attr("data-com-slipno");
		var amount_edit 			= $(this).attr("data-com-amount");
		var chequestatus_edit		= $(this).attr("data-cchqstatus");
		var cheque_edit 			= $(this).attr("data-com-cheque");
		var cheque_date_edit 		= $(this).attr("data-com-chequedate");
		var cheque_cleardate_edit	= $(this).attr("data-com-cleardate");
		var bank_name_edit 			= $(this).attr("data-com-bank");
		var remarks_edit 			= $(this).attr("data-com-remarks");
		var id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#dated_edit")			.val(dated_edit);
		$("#slipno_edit")			.val(slipno_edit);
		$("#amount_edit")			.val(amount_edit);
		$("#cheque_edit")			.val(cheque_edit);
		$("#cheque_date_edit")		.val(cheque_date_edit);
		$("#cheque_cleardate_edit")	.val(cheque_cleardate_edit);
		$("#vendor_name_edit")	.val(vendor_name_edit);
		$("#bank_name_edit")		.val(bank_name_edit);
		$("#remarks_edit")			.val(remarks_edit);
		$("#id_edit")				.val(id_edit);

       //pre-select data in pull down lists
	   $("#method_edit")			.select2().select2("val", method_edit); 
	   $("#chequestatus_edit")		.select2().select2("val", chequestatus_edit); 
  });
    
});
</script>';