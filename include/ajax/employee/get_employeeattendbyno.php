<?php 
error_reporting(0);
session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['emply_no'])) {
	$emplyno = $_GET['emply_no']; 
//--------------------------------------------	
	$sqllmsget  = $dblms->querylms("SELECT e.emply_id, e.emply_no, e.emply_name, e.id_dept, e.id_shift, d.dept_name  
													FROM ".EMPLOYEES." e 
													INNER JOIN ".DEPTS." d ON d.dept_id = e.id_dept 
													WHERE e.emply_no = '".cleanvars($emplyno)."' LIMIT 1");
	$rowsqt		= mysqli_fetch_array($sqllmsget);
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" value="'.$rowsqt['emply_name'].'" readonly required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Department</label>
			<input type="text" class="form-control" id="dept_name" name="dept_name" value="'.$rowsqt['dept_name'].'" readonly required autocomplete="off">
		</div> 
	</div>
<input type="hidden" name="id_emply" id="id_emply" value="'.$rowsqt['emply_id'].'">
<input type="hidden" name="id_shift" id="id_shift" value="'.$rowsqt['id_shift'].'">
<input type="hidden" name="id_dept" id="id_dept" value="'.$rowsqt['id_dept'].'">';
}
//--------------------------------------------
?>