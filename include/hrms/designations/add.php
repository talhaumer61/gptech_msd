<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '13', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="designations.php" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Designation Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="designation_name" name="designation_name" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="designation_status" name="designation_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Create Designation" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
    $("#designation_status").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             designation_name		: "required",
			 designation_status		: "required"
		},
		messages: {
			designation_name		: "This field is required",
			designation_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}