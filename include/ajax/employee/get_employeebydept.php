<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['id_dept'])) {
	$iddept = $_GET['id_dept']; 
//--------------------------------------------	
		
		$sqllmsemply  = $dblms->querylms("SELECT emply_id, emply_no, emply_name, id_dept 
												FROM ".EMPLOYEES." 
												WHERE id_dept = '".cleanvars($_GET['id_dept'])."' 
												AND id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												AND emply_status = '1'
												ORDER BY emply_no ASC");
		$employarray = array();
		while($rowemply	= mysqli_fetch_array($sqllmsemply)) {
			$employarray[] = $rowemply;
		}
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Employee Name</label>
			<select id="id_emply" name="id_emply" style="width:100%" autocomplete="off" onchange="get_employeeleves(this.value)">
				<option value="">Select Employee</option>';
			foreach($employarray as $itememply) { 
				echo '<option value="'.$itememply['emply_id'].'">'.$itememply['emply_no'].'-'.$itememply['emply_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Alternate Employee</label>
			<select id="alternate_emply" name="alternate_emply" style="width:100%" autocomplete="off">
				<option value="">Select Employee</option>';				
				foreach($employarray as $itemaltemply) { 
					echo '<option value="'.$itemaltemply['emply_id'].'">'.$itemaltemply['emply_no'].'-'.$itemaltemply['emply_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
<script>
    $("#alternate_emply").select2({
        allowClear: true
    });
	$("#id_emply").select2({
        allowClear: true
    });
	
</script>';
}
//--------------------------------------------
?>