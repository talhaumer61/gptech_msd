<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '15', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Zone Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Code</label>
			<input type="text" class="form-control" id="company_code" name="company_code" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">ADE</label>
			<select id="id_ade" name="id_ade" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
				foreach($Ades as $itemade) {
					echo '<option value="'.$itemade['ade_id'].'">'.$itemade['ade_name'].'('.$itemade['ade_cellno'].')</option>';
				}
				echo '
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="company_status" name="company_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
				foreach($admstatus as $itemadm_status) {
					echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="company_address" name="company_address" autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Create Zone" id="submit_zone" name="submit_zone">
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
    $("#company_status").select2({
        allowClear: true
    });
	$("#id_ade").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             company_name		: "required",
			 company_status		: "required"
		},
		messages: {
			company_name		: "This field is required",
			company_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}