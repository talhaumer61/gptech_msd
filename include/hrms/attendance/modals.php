<?php 
//---------------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="reportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="attendancereport.php" target="_blank" method="post" id="attend_form" name="attend_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Print Reports</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>From Date</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="formdate" name="formdate" autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>To Date</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="todate" name="todate" autocomplete="off">
		</div>
	</div>

</div>


<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Print Report" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>

</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="attendanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="reports.php" target="_blank" method="post" id="absent_form" name="absent_form" enctype="multipart/form-data">

<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Attendance Report </h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Department</label>
			<select id="id_dept" name="id_dept" style="width:100%" autocomplete="off" required  onchange="get_employeebydeptprevious(this.value)" >
				<option value="">Select Department</option>';
				foreach($departmentarry as $listdept) {
					echo '<option value="'.$listdept['dept_id'].'">'.$listdept['dept_name'].'</option>';
				}
echo '
			</select>
		</div> 
	</div>
	
<div id="getemployeebydeptprevious">
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label>Employee Name</label>
			<select id="id_emply" name="id_emply" style="width:100%" autocomplete="off">
				<option value="">Select Employee</option>
			</select>
		</div> 
	</div>
	

</div>

	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req"> From Date </label>
			<input type="text" class="form-control pickadate" id="fromdate" name="fromdate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req"> To Date </label>
			<input type="text" class="form-control pickadate" id="todate" name="todate" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Report For</b></label>
		<div class="col-lg-12">
			<select id="id_report" name="id_report" style="width:100%" autocomplete="off"  >
				<option value="">Select option</option>
				<option value="1">Absent Report</option>
				<option value="2">Present Report</option>
			</select>
		</div>
	</div>
	
<div style="clear:both;"></div>

</div>


<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
		<input class="btn btn-primary" type="submit" value="Attendance Report" id="submit_attendance" name="submit_attendance">
	</button>
</div>

</div>
</form>

</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--IMPORT ATTENDANCE-->
<div class="row">
<div id="addIMportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="attendance.php" method="post" id="attendanceimport" enctype="multipart/form-data">
<input type="hidden" name="view" id="view" value="import">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Import Attendance </h4>
</div>
<div class="modal-body">
 

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>File</b></label>
		<div class="col-lg-12">
			<input id="std_photo" name="std_photo" class="btn btn-mid btn-primary clearfix" required type="file"> 
			<span style="color:#f00;">File extension should be .csv only</span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label  col-lg-12" style="width:150px;"> <b>Format</b></label>
		<div class="col-lg-12">
<table class="table table-bordered table-hover" style="margin-top:10px;">
<thead>
<tr>
	<td style="text-align:center;"> Employee No#. </td>
	<td style="text-align:center;"> Date </td>
	<td style="text-align:center;"> On duty </td>
	<td style="text-align:center;"> Off duty </td>
	<td style="text-align:center;"> Clock In </td>
	<td style="text-align:center;"> Clock Out </td>
</tr>
</thead>
</table>
		</div>
	</div>
<div style="clear:both;"></div>

</div>

<div style="clear:both;"></div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input class="btn btn-primary" type="submit" value=" Import " id="submit_file" name="submit_file">
</div>

</div>
</form>
</div>
</div>
</div>
<!--IMPORT ATTENDANCE-->';
