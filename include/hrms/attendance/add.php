<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '30', 'add' => '1'))) { 

$nowtime = new DateTime();
//echo $nowtime->format('Y-m-d H:i:s');
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="attendance.php" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Attendance Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Employee ID</label>
			<input type="text" class="form-control" onchange="get_employeeattendbyno(this.value)" autofocus id="emply_no" name="emply_no" required autocomplete="off">
		</div> 
	</div>
<div id="getemployeeattendbyno">
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Department</label>
			<input type="text" class="form-control" id="dept_name" name="dept_name" required autocomplete="off">
		</div> 
	</div>
</div>

	<div style="clear:both;"></div>	

	
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Dated</label>
			<input type="text" class="form-control pickadate" id="dated" name="dated" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Clock In</label>
			<input type="text" class="form-control" id="clock_in" name="clock_in" required autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Clock Out</label>
			<input type="text" class="form-control" id="clock_out" name="clock_out" required autocomplete="off">
		</div> 
	</div>
	

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="remarks" name="remarks" autocomplete="off">
		</div>
	</div>


</div>


<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Add Attendance" id="submit_country" name="submit_country">
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
	
</script>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//---------------------------------------------------------
}
