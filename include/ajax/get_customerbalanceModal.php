<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_user'])) { 
		
	// get Credit & Debit Payments of Customer

	$debitcreditconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
								'where' 	=> array( 
													''.PAYMENTS.'.status' 	=> 1, 
													''.PAYMENTS.'.id_user' 	=> cleanvars($_POST['id_user']) 
												), 								
								'return_type' 	=> 'single' 
							); 
    $valuecrditdebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);	
	$openingbalance 	= ($valuecrditdebit['TotalDebit'] - $valuecrditdebit['TotalCredit']);
//--------------------------------------------
echo ' 
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Payable (Balance)</label>
			<input type="text" class="form-control" id="payable" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" name="payable" value="'.number_format($openingbalance).'" autocomplete="off" readonly>
		</div> 
	</div>';
	
}
//--------------------------------------------
