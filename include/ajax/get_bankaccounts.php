<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['pmode'])) {
	$arraybank 		= explode(',', $_POST['pmode']);
	$paymode 		= $arraybank[0];
	$idaccount 		= $arraybank[1];
//--------------------------------------------
	if($paymode == 1){

		echo ' 
		<div class="col-sm-41">
			<div class="form_sep" style="margin-top:10px;">
				<label class="req">Account #</label>
				<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off">
					<option value="">Select Account</option>';
						foreach($bankAccounts as $account) { 
							if($account['id'] == $idaccount) {
								echo '<option value="'.$account['id'].'" selected>'.$account['bank'].' - '.$account['acc_number'].'</option>';
							} else {
								echo '<option value="'.$account['id'].'">'.$account['bank'].' - '.$account['acc_number'].'</option>';
							}
							
						}
				echo'
				</select>
			</div> 
		</div>
		<script>
			$("#id_account").select2({
				allowClear: true
			});			
		</script>';
		

	}
}
//--------------------------------------------
?>