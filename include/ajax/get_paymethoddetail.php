<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['payment_method'])) {
//--------------------------------------------
	if($_POST['payment_method'] == 1){

		echo ' 
		<div class="col-sm-31">
			<div class="form_sep">
				<label class="req">Account #</label>
				<select id="id_account" class="select2" name="id_account" style="width:100%" required autocomplete="off">
					<option value="">Select Account</option>';
						foreach($bankAccounts as $account) { 
							if (in_array($account['id'], [7, 8])) :
								echo '<option value="'.$account['id'].'">'.$account['bank'].' - '.$account['acc_number'].'</option>';
							endif;
						}
				echo'
				</select>
			</div> 
		</div>
		<script>
			$("#id_account").select2({
				allowClear: true
			});			
		</script>
		<div class="col-sm-31">
			<div class="form_sep">
				<label class="req">Deposit/Receipt #</label>
				<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" required autocomplete="off">
			</div> 
		</div>';
		

	} else{

		echo '
		<div class="col-sm-51">
			<div class="form_sep">
				<label class="req">Deposit/Receipt #</label>
				<input type="text" class="form-control" id="deposit_slip" name="deposit_slip" required autocomplete="off">
			</div> 
		</div>';

	}
}
//--------------------------------------------
?>