<?php 

if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'add' => '1'))) { 
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="employeeleaves.php" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Employee Leave Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Department</label>
			<select id="id_dept" name="id_dept" style="width:100%" autocomplete="off" required onchange="get_employeebydept(this.value)" >
				<option value="">Select Department</option>';
//------------------------------------------------
			foreach($departmentarry as $listdepts) {
				echo '<option value="'.$listdepts['dept_id'].'">'.$listdepts['dept_name'].'</option>';
			}
echo '
			</select>
		</div> 
	</div>
<div id="getemployeebydept">
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<select id="id_emply" name="id_emply" style="width:100%" autocomplete="off" required >
				<option value="">Select Employee</option>
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Alternate Employee</label>
			<select id="alternate_emply" name="alternate_emply" style="width:100%" autocomplete="off">
				<option value="">Select Employee</option>
			</select>
		</div> 
	</div>
</div>

	<div style="clear:both;"></div>	
	
<div id="getemployeeleves">

</div>

	
	
	<div style="clear:both;"></div>	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Leave</label>
			<select id="id_leave" name="id_leave" style="width:100%" autocomplete="off" required>
				<option value="">Select Leave</option>';
				$sqllmsleave  = $dblms->querylms("SELECT leave_id, leave_name 
													FROM ".LEAVES." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													ORDER BY leave_name ASC");
			while($rowleave		= mysqli_fetch_array($sqllmsleave)) {
					echo '<option value="'.$rowleave['leave_id'].'">'.$rowleave['leave_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Leave Type</label>
			<select id="leave_type" name="leave_type" style="width:100%" autocomplete="off" required>
				<option value="">Select Type</option>';
				foreach($leavetype as $itemtype) {
					echo '<option value="'.$itemtype['id'].'">'.$itemtype['name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Duration</label>
			<select id="duration" name="duration" style="width:100%" autocomplete="off" required>
				<option value="">Select Duration</option>';
				foreach($leaveduration as $itemduration) {
					echo '<option value="'.$itemduration['id'].'">'.$itemduration['name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>	
	<div style="clear:both;"></div>
	
	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">From Date</label>
			<input type="text" class="form-control pickadate" id="date_from" name="date_from" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">To Date</label>
			<input type="text" class="form-control pickadate" id="date_to" name="date_to" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label>Application</label>
			<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div> 
	</div>
	

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Reason</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="reason" name="reason" autocomplete="off">
		</div>
	</div>


</div>


<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Leave" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
<script>
	
	$("#id_leave").select2({
        allowClear: true
    });
	$("#leave_type").select2({
        allowClear: true
    });
	$("#duration").select2({
        allowClear: true
    });
	
	$("#alternate_emply").select2({
        allowClear: true
    });
	$("#id_emply").select2({
        allowClear: true
    });
	$("#id_dept").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
