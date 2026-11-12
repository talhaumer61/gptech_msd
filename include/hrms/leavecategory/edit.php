<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1)  || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'edit' => '1'))) {
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
	<h4 class="modal-title" style="font-weight:700;"> Edit Leave Type Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12"> <b> Leave Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="leave_name_edit" name="leave_name_edit" required autofocus autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label> Leave Type </label>
			<select id="leave_type_edit" name="leave_type_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($leavetype as $itemleavetype) {
				echo "<option value='$itemleavetype[id]'>$itemleavetype[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label> Leave Per Year </label>
			<input type="text" class="form-control" id="leave_peryear_edit" name="leave_peryear_edit"  autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="leave_status_edit" name="leave_status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input type="hidden" id="leave_id_edit" name="leave_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>
	$("#leave_status_edit").select2({
        allowClear: true
    });

	$("#leave_type_edit").select2({
        allowClear: true
    });

</script>

<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editCountry").validate({
		rules: {
             leave_type_edit		: "required",
			 leave_status_edit		: "required"
		},
		messages: {
			leave_type_edit			: "This field is required",
			leave_status_edit		: "This field is required"
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
        var leave_type_edit 		= $(this).attr("data-cls-type");
		var leave_name_edit 		= $(this).attr("data-cls-name");
		var leave_peryear_edit 		= $(this).attr("data-cls-peryear");
		var leave_status_edit 		= $(this).attr("data-cls-status");
		var leave_id_edit 			= $(this).attr("data-cls-id");

        //set modal input values dynamically
		$("#leave_name_edit")		.val(leave_name_edit);
		$("#leave_peryear_edit")	.val(leave_peryear_edit);
		$("#leave_id_edit")			.val(leave_id_edit);

       //pre-select data in pull down lists
       $("#leave_status_edit").select2().select2("val", leave_status_edit); 
	   $("#leave_type_edit").select2().select2("val", leave_type_edit); 
  });
    
});
</script>';
}
