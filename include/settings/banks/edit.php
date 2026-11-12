<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '14', 'edit' => '1'))) { 
//-----------------------------------
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Bank Detail</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Bank Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="bank_name_edit" name="bank_name_edit" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Phone #</label>
			<input type="text" class="form-control" id="bank_phone_edit" name="bank_phone_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="bank_email_edit" name="bank_email_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="bank_address_edit" name="bank_address_edit" autocomplete="off">
		</div>
	</div>
    
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="bank_status_edit" name="bank_status_edit" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadms_tatus) {
				echo "<option value='$itemadms_tatus[status_id]'>$itemadms_tatus[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="bank_id_edit" name="bank_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#bank_status_edit").select2({
        allowClear: true
    });
	
</script>

<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             bank_name_edit		: "required",
			 bank_status_edit	: "required"
		},
		messages: {
			bank_name_edit		: "This field is required",
			bank_status_edit		: "This field is required"
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
		var bank_status_edit 			= $(this).attr("data-com-status");
        var bank_name_edit 				= $(this).attr("data-com-name");
		var bank_phone_edit 			= $(this).attr("data-com-phone");
		var bank_email_edit 			= $(this).attr("data-com-email");
		var bank_address_edit 			= $(this).attr("data-com-address");
		var bank_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#bank_name_edit")			.val(bank_name_edit);
		$("#bank_phone_edit")			.val(bank_phone_edit);
		$("#bank_email_edit")			.val(bank_email_edit);
		$("#bank_address_edit")			.val(bank_address_edit);
		$("#bank_id_edit")				.val(bank_id_edit);

       //pre-select data in pull down lists
       $("#bank_status_edit")			.select2().select2("val", bank_status_edit); 
  });
    
});
</script>';
//-----------------------------------
}
