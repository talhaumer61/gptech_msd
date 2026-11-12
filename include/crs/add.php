<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Customer Representatives Detail</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-100">
		<div class="form_sep">
			<label class="req">Full Name</label>
			<input type="text" class="form-control" id="crs_name" name="crs_name" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>


	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Mobile #</label>
			<input type="text" class="form-control" id="crs_mobile" name="crs_mobile" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Whatsapp #</label>
			<input type="text" class="form-control" id="crs_whatsapp" name="crs_whatsapp" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="crs_email" name="crs_email" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<input type="text" class="form-control" id="crs_designation" name="crs_designation" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="crs_status" name="crs_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
    $("#crs_status").select2({
        allowClear: true
    });
	$("#id_company").select2({
        allowClear: true
    });
</script>

<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             customer_name		: "required",
			 customer_status		: "required"
		},
		messages: {
			customer_name		: "This field is required",
			customer_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}