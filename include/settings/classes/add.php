<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '14', 'add' => '1'))) { 
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
	<h4 class="modal-title" style="font-weight:700;"> Add Class Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Class Code</label>
			<input type="text" class="form-control" id="cls_code" name="cls_code" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep">
			<label class="req">Class Name</label>
			<input type="text" class="form-control" id="cls_name" name="cls_name" required autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>


	
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Details</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="cls_detail" name="cls_detail" autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-81">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Company</label>
			<select id="id_company" name="id_company" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($Company as $itemcompany) {
				echo '<option value="'.$itemcompany['company_id'].'">'.$itemcompany['company_code'].'-'.$itemcompany['company_name'].'</option>';
			}
	echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="cls_status" name="cls_status" style="width:100%" autocomplete="off" required>
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
    $("#cls_status").select2({
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
} else {
	echo '<h1 style="margin-top: 200px; color: #f00; font-weight: 600; text-align: center;">Sorry, you have no right to access this page</h1>';
	
}