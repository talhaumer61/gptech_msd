<?php 
error_reporting(0);
//session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_vendor'])) {
//--------------------------------------------	
	$conditions = array ( 
								'select' 		=> 'vendor_id, vendor_cellno, vendor_email, vendor_openingbalance',
								'where' 		=> array ( 
															'vendor_id' => cleanvars($_POST['id_vendor'])
														 ), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueVendor 	= $dblms->getRows(VENDORS, $conditions);
	
// get Credit debit Payments of Vendors
	$debitcreditconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
								'where' 		=> array ( 
															''.PAYMENTS.'.status' 	=> 1 , 
															''.PAYMENTS.'.id_user' 	=> cleanvars($_POST['id_vendor']) 
														 ), 								
								'return_type' 	=> 'single' 
							); 
    $valuecrditdebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance 	= ($valuecrditdebit['TotalCredit'] - $valuecrditdebit['TotalDebit']);
//--------------------------------------------
echo ' 
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Vendor Phone #</label>
			<input type="text" class="form-control" id="vendor_cellno" name="vendor_cellno" required value="'.$valueVendor['vendor_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Vendor Email</label>
			<input type="text" class="form-control" id="vendor_email" name="vendor_email" required value="'.$valueVendor['vendor_email'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	<div style="clear:both;padding:5px;"></div>
	<input type="hidden" id="vendor_openingbalance" name="vendor_openingbalance" value="'.$openingbalance.'">';
}
//--------------------------------------------