<?php 

//--------------------Import----------------------------
if(isset($_GET['id'])) { 
//------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '30', 'add' => '1'))) { 
//------------------------------------------------

	$sqllms  	= $dblms->querylms("SELECT *  
										FROM ".EMPLY_ATTENDANCE." el 
										INNER JOIN ".EMPLOYEES." e ON e.emply_id = el.id_emply 
										INNER JOIN ".DEPTS." d ON d.dept_id = el.id_dept  
										WHERE el.id = '".cleanvars($_GET['id'])."' 
										AND el.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="attendance.php?id='.cleanvars($_GET['id']).'" method="post" id="editCountry" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Attendance Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Employee ID</label>
			<input type="text" class="form-control" id="emply_no" name="emply_no" value="'.$rowstd['emply_no'].'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" value="'.$rowstd['emply_name'].'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Department</label>
			<input type="text" class="form-control" id="dept_name" name="dept_name" value="'.$rowstd['dept_name'].'" readonly required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>	
	
<div style="clear:both;"></div>	

	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" value="'.$rowstd['dated'].'" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Clock In</label>
			<input type="text" class="form-control" id="clock_in" name="clock_in" value="'.$rowstd['clock_in'].'" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Clock Out</label>
			<input type="text" class="form-control" id="clock_out" name="clock_out" value="'.$rowstd['clock_out'].'" required autocomplete="off">
		</div> 
	</div>
	

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off" value="'.$rowstd['remarks'].'">
		</div>
	</div>


</div>


<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="bill_changes" name="bill_changes">
	<button type="button" class="btn btn-default" onclick="location.href=\'attendance.php\'" >Cancel</button>
</div>

</div>
</form>
<script>
	
	$("#idleave").select2({
        allowClear: true
    });
	$("#leavetype").select2({
        allowClear: true
    });
	$("#durationedit").select2({
        allowClear: true
    });
	$("#alternateemply").select2({
        allowClear: true
    });
	
</script>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
}