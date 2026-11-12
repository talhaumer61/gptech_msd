<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1)  || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Leave Type</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12"> <b> Leave Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="leave_name" name="leave_name" required autofocus autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label> Leave Type </label>
			<select id="leave_type" name="leave_type" style="width:100%" autocomplete="off" required>
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
			<input type="text" class="form-control" id="leave_peryear" name="leave_peryear"  autocomplete="off">
		</div>
	</div>

<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="leave_status" name="leave_status" style="width:100%" autocomplete="off" required>
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
		<input class="btn btn-primary" type="submit" value="Create Leave Type" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<!--JS_SELECT_LISTS-->
<script>

    $("#leave_status").select2({
        allowClear: true
    });

    $("#leave_type").select2({
        allowClear: true
    });


</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewCountry").validate({
		rules: {
             leave_type			: "required",
			 leave_status		: "required"
		},
		messages: {
			leave_type			: "This field is required",
			leave_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->';
}