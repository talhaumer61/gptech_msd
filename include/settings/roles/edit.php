<?php 
echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editBcatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editBcat">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Role Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Role Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="role_name_edit" name="role_name_edit" data-required="true" data-required-message="Please enter a valid Book Number" autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Under Role</b></label>
		<div class="col-lg-12">
			<select id="role_type_edit" name="role_type_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($roletypes as $itemroletypes) {
				echo '<option value="'.$itemroletypes['id'].'">'.$itemroletypes['name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>


	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="role_status_edit" name="role_status_edit" style="width:100%" autocomplete="off" required>
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
	<input type="hidden" id="role_id_edit" name="role_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editBcat").validate({
		rules: {
             role_name_edit	: "required",
			 role_status_edit: "required"
		},
		messages: {
			role_name_edit	: "This field is required",
			role_status_edit	: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    //USED BY: WI_EDIT_TASK_MODAL
	//ACTIONS: dynamically add data into modal form
	//REQUIRES: jquery.js
	//ACTIONS-2: creates a pull down/select for each specified field (with preselected values)
    //REQUIRES-2: select2.js
		
    //---edit item link clicked-------
//---edit item link clicked-------
    $(".edit-bcat-modal").click(function(){
    
        //get variables from "edit link" data attributes
        var role_name_edit 			= $(this).attr("data-cat-name");
		var role_type_edit 			= $(this).attr("data-cat-type");
		var role_status_edit 		= $(this).attr("data-cat-status");
		var role_id_edit 			= $(this).attr("data-cat-id");

        //set modal input values dynamically
		$("#role_name_edit")		.val(role_name_edit);
		$("#role_id_edit")			.val(role_id_edit);

       //pre-select data in pull down lists
       $("#role_status_edit")		.select2().select2("val", role_status_edit); 
	   $("#role_type_edit")			.select2().select2("val", role_type_edit); 
  });
    
});
</script>';