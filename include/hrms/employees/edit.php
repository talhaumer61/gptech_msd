<?php 

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'edit' => '1'))) { 
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Employee Detail</h4>
</div>

<div class="modal-body">
	<div class="col-sm-31" style="margin-bottom:10px;">
		<div class="form_sep">
			<label>Employee #</label>
			<input type="text" class="form-control" id="emply_no_edit" name="emply_no_edit"  readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51" style="margin-bottom:10px;">
		<div class="form_sep">
			<label class="req">Full Name</label>
			<input type="text" class="form-control" id="emply_name_edit" name="emply_name_edit" required autocomplete="off" style="text-transform: capitalize;">
		</div> 
	</div>
	
	<div class="col-sm-51" style="margin-bottom:10px;">
		<div class="form_sep">
			<label class="req">Father Name</label>
			<input type="text" class="form-control" id="emply_fathername_edit" name="emply_fathername_edit" required autocomplete="off" style="text-transform: capitalize;">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Cell #</label>
			<input type="text" class="form-control" id="emply_cellno_edit" name="emply_cellno_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>CNIC #</label>
			<input type="text" class="form-control" id="emply_cnic_edit" name="emply_cnic_edit" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="emply_email_edit" name="emply_email_edit" autocomplete="off">
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Join Date</label>
			<input type="text" class="form-control pickadate" id="emply_joindate_edit" name="emply_joindate_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Basic Salary</label>
			<input type="number" class="form-control" id="emply_basicsalary_edit" name="emply_basicsalary_edit" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Working Shift</label>
			<select id="id_shift_edit" name="id_shift_edit" style="width:100%" autocomplete="off" required>
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
			<select id="id_designation_edit" name="id_designation_edit" style="width:100%" autocomplete="off" required>
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
			<select id="id_dept_edit" name="id_dept_edit" style="width:100%" autocomplete="off" required>
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
	
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="emply_address_edit" name="emply_address_edit" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Photo</b></label>
		<div class="col-lg-12">
			<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Status</b></label>
		<div class="col-lg-12">
			<select id="emply_status_edit" name="emply_status_edit" style="width:100%" autocomplete="off" required>
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
	<input type="hidden" id="emply_id_edit" name="emply_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->
<script>

	$("#emply_status_edit").select2({
        allowClear: true
    });
	

	$("#id_designation_edit").select2({
        allowClear: true
    });
	
	
	$("#id_dept_edit").select2({
        allowClear: true
    });

	
	$("#id_shift_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
    
	$("#editCountry").validate({
		rules: {
             emply_name_edit		: "required",
			 emply_status_edit	: "required"
		},
		messages: {
			emply_name_edit		: "This field is required",
			emply_status_edit		: "This field is required"
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
		var emply_status_edit 			= $(this).attr("data-com-status");
        var emply_no_edit 				= $(this).attr("data-com-emplyno");
	    var emply_name_edit 			= $(this).attr("data-com-name");
		var emply_fathername_edit 		= $(this).attr("data-com-fathername");
		var emply_cellno_edit 			= $(this).attr("data-com-phone");
		var emply_cnic_edit 			= $(this).attr("data-com-cnic");
		var emply_email_edit 			= $(this).attr("data-com-email");
		var emply_address_edit 			= $(this).attr("data-com-address");
		var emply_joindate_edit 		= $(this).attr("data-com-joindate");
		var emply_basicsalary_edit 		= $(this).attr("data-com-bsalary");
		var id_designation_edit 		= $(this).attr("data-com-designation");
		var id_dept_edit 				= $(this).attr("data-com-dept");
		var id_shift_edit 				= $(this).attr("data-com-shift");
		var emply_id_edit 				= $(this).attr("data-com-id");

        //set modal input values dynamically
		$("#emply_name_edit")			.val(emply_name_edit);
		$("#emply_no_edit")				.val(emply_no_edit);
		$("#emply_fathername_edit")		.val(emply_fathername_edit);
		$("#emply_cellno_edit")			.val(emply_cellno_edit);
		$("#emply_cnic_edit")			.val(emply_cnic_edit);
		$("#emply_email_edit")			.val(emply_email_edit);
		$("#emply_address_edit")		.val(emply_address_edit);
		$("#emply_joindate_edit")		.val(emply_joindate_edit);
		$("#emply_basicsalary_edit")	.val(emply_basicsalary_edit);
		$("#emply_id_edit")				.val(emply_id_edit);

       //pre-select data in pull down lists
       $("#emply_status_edit")			.select2().select2("val", emply_status_edit); 
	   $("#id_designation_edit")		.select2().select2("val", id_designation_edit); 
	   $("#id_dept_edit")				.select2().select2("val", id_dept_edit); 
	   $("#id_shift_edit")				.select2().select2("val", id_shift_edit); 
  });
    
});
</script>';
}