<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'edit' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Office Detail</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Office Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="office_name_edit" name="office_name_edit" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Phone #</label>
			<input type="text" class="form-control" id="office_phone_edit" name="office_phone_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="office_email_edit" name="office_email_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Fax #</label>
			<input type="text" class="form-control" id="office_fax_edit" name="office_fax_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Contact Person</label>
			<input type="text" class="form-control" id="office_contactperson_edit" name="office_contactperson_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="office_address_edit" name="office_address_edit" autocomplete="off">
		</div>
	</div>
    
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="office_status_edit" name="office_status_edit" style="width:100%" autocomplete="off">
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
	<input type="hidden" id="office_id_edit" name="office_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#office_status_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             office_name_edit		: "required",
			 office_status_edit	: "required"
		},
		messages: {
			office_name_edit		: "This field is required",
			office_status_edit		: "This field is required"
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
		var office_status_edit 			= $(this).attr("data-com-status");
        var office_name_edit 			= $(this).attr("data-com-name");
		var office_phone_edit 			= $(this).attr("data-com-phone");
		var office_email_edit 			= $(this).attr("data-com-email");
		var office_fax_edit 			= $(this).attr("data-com-fax");
		var office_address_edit 		= $(this).attr("data-com-address");
		var office_contactperson_edit 	= $(this).attr("data-com-person");
		var office_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#office_name_edit")			.val(office_name_edit);
		$("#office_phone_edit")			.val(office_phone_edit);
		$("#office_email_edit")			.val(office_email_edit);
		$("#office_fax_edit")			.val(office_fax_edit);
		$("#office_address_edit")		.val(office_address_edit);
		$("#office_contactperson_edit")	.val(office_contactperson_edit);
		$("#office_id_edit")			.val(office_id_edit);

       //pre-select data in pull down lists
       $("#office_status_edit")			.select2().select2("val", office_status_edit); 
  });
    
});
</script>';
}