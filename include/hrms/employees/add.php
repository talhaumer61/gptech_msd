<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'add' => '1'))) {  

$sqllmslatest  = $dblms->querylms("SELECT emply_no FROM ".EMPLOYEES."								
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										ORDER BY emply_no DESC");
$valuelst = mysqli_fetch_array($sqllmslatest);
//--------------------------------------------
if($valuelst['emply_no'] == '') { 
	$emplyno = '1001';
} else { 
	$emplyno = ($valuelst['emply_no'] + 1);
}
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
	<h4 class="modal-title" style="font-weight:700;"> Add Employee Detail</h4>
</div>

<div class="modal-body">
	
	<div class="col-sm-31" style="margin-bottom:10px;">
		<div class="form_sep">
			<label>Employee #</label>
			<input type="text" class="form-control" id="emply_no" name="emply_no" value="'.$emplyno.'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51" style="margin-bottom:10px;">
		<div class="form_sep">
			<label class="req">Full Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" required autocomplete="off" style="text-transform: capitalize;">
		</div> 
	</div>
	
	<div class="col-sm-51" style="margin-bottom:10px;">
		<div class="form_sep">
			<label class="req">Father Name</label>
			<input type="text" class="form-control" id="emply_fathername" name="emply_fathername" required autocomplete="off" style="text-transform: capitalize;">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Cell #</label>
			<input type="text" class="form-control" id="emply_cellno" name="emply_cellno" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>CNIC #</label>
			<input type="text" class="form-control" id="emply_cnic" name="emply_cnic" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Email Address</label>
			<input type="email" class="form-control" id="emply_email" name="emply_email" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Join Date</label>
			<input type="text" class="form-control pickadate" id="emply_joindate" name="emply_joindate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Basic Salary</label>
			<input type="number" class="form-control" id="emply_basicsalary" name="emply_basicsalary" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Working Shift</label>
			<select id="id_shift" name="id_shift" style="width:100%" autocomplete="off" required>
				<option value="">Select Shift</option>';
//------------------------------------------------
			foreach($arrayshift as $listshift) {
				echo '<option value="'.$listshift['shift_id'].'">'.$listshift['shift_name'].'</option>';
			}
echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<select id="id_designation" name="id_designation" style="width:100%" autocomplete="off" required>
				<option value="">Select Designation</option>';
//------------------------------------------------
			foreach($arraydesgs as $listdesgs) {
				echo '<option value="'.$listdesgs['designation_id'].'">'.$listdesgs['designation_name'].'</option>';
			}
echo '
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Department </label>
			<select id="id_dept" name="id_dept" style="width:100%" autocomplete="off" required>
				<option value="">Select Department</option>';
//------------------------------------------------
			foreach($arraydepts as $listdepts) {
				echo '<option value="'.$listdepts['dept_id'].'">'.$listdepts['dept_name'].'</option>';
			}
echo '
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="emply_address" name="emply_address" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Photo</b></label>
		<div class="col-lg-12">
			<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="emply_status" name="emply_status" style="width:100%" autocomplete="off" required>
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
		<input class="btn btn-primary" type="submit" value="Create Employee" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
    $("#emply_status").select2({
        allowClear: true
    });
	
	$("#id_designation").select2({
        allowClear: true
    });

	$("#id_dept").select2({
        allowClear: true
    });
	
	$("#id_shift").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addNewCountry").validate({
		rules: {
             emply_name		: "required",
			 emply_status		: "required"
		},
		messages: {
			emply_name		: "This field is required",
			emply_status		: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
';
}