<?php 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewBcatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewBcat" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Role Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Role Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="role_name" name="role_name" data-required="true" data-required-message="Please enter a valid Book Number" autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Under Role</b></label>
		<div class="col-lg-12">
			<select id="role_type" name="role_type" style="width:100%" autocomplete="off" required>
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
			<select id="role_status" name="role_status" style="width:100%" autocomplete="off" required>';
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
		<input class="btn btn-primary" type="submit" value="Add Role" id="submit_bcat" name="submit_bcat">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewBcat").validate({
		rules: {
             role_name: "required",
			 role_status: "required"
		},
		messages: {
			role_name: "This field is required",
			role_status: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->';
