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
	$sqllmsget  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
													FROM ".EMPLOYEES." 
													WHERE emply_no = '".cleanvars($emplyno)."' LIMIT 1");
	$rowsqt		= mysqli_fetch_array($sqllmsget);
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<input type="text" class="form-control" id="emply_name" name="emply_name" value="'.$rowsqt['emply_name'].'" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-51">
		<div class="form_sep">
			<label class="req">Alternate Employee</label>
			<select id="alternate_emply" name="alternate_emply" style="width:100%" autocomplete="off" required>
				<option value="">Select Employee</option>';
				
				$sqllmsemply  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
													FROM ".EMPLOYEES." 
													WHERE id_dept = '".cleanvars($rowsqt['id_dept'])."' 
													AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND emply_status = '1'
													ORDER BY emply_name ASC");
			while($rowemply		= mysqli_fetch_array($sqllmsemply)) {
					echo '<option value="'.$rowemply['emply_id'].'">'.$rowemply['emply_no'].'-'.$rowemply['emply_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
<input type="hidden" name="id_emply" id="id_emply" value="'.$rowsqt['emply_id'].'">
<input type="hidden" name="id_dept" id="id_dept" value="'.$rowsqt['id_dept'].'">
<script>
    $("#alternate_emply").select2({
        allowClear: true
    });
	
</script>';
}
//--------------------------------------------
?>