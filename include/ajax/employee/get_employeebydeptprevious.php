<?php 
error_reporting(0);
session_start();
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['id_dept'])) {
	$iddept = $_GET['id_dept']; 
//--------------------------------------------	
	$sqllmsget  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
													FROM ".EMPLOYEES." 
													WHERE id_dept = '".cleanvars($iddept)."' LIMIT 1");
	$rowsqt		= mysqli_fetch_array($sqllmsget);
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<div class="col-sm-61">
		<div class="form_sep">
			<label>Employee Name</label>
			<select id="id_emply" name="id_emply" style="width:100%" autocomplete="off">
				<option value="">Select Employee</option>';			
				$sqllmsemply  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
													FROM ".EMPLOYEES." 
													WHERE id_dept = '".cleanvars($rowsqt['id_dept'])."' 
													AND id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
													AND emply_status = '1'
													ORDER BY emply_no ASC");
			while($rowemply		= mysqli_fetch_array($sqllmsemply)) {
					echo '<option value="'.$rowemply['emply_id'].'">'.$rowemply['emply_no'].'-'.$rowemply['emply_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

<script>

	$("#id_emply").select2({
        allowClear: true
    });
	
</script>';
}
//--------------------------------------------
?>