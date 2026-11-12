<?php 
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['id_customer'])) {
//--------------------------------------------
	
	$conditions = array ( 
								'select' 	=> ''.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' => array( 
													''.CUSTOMERS.'.customer_id' 	=> cleanvars($_POST['id_customer'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);
	
	// get Credit & Debit Payments of Customer

	$debitcreditconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
								'where' 	=> array( 
													''.PAYMENTS.'.status' 	=> 1, 
													''.PAYMENTS.'.id_user' 	=> cleanvars($_POST['id_customer']) 
												), 								
								'return_type' 	=> 'single' 
							); 
    $valuedebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance = ($valuedebit['TotalDebit'] - $valuedebit['TotalCredit']);
//--------------------------------------------
echo ' 
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Name</label>
			<input type="text" class="form-control" id="ade_name" name="ade_name" required value="'.$valueCustomer['ade_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>ADE Phone #</label>
			<input type="text" class="form-control" id="ade_cellno" name="ade_cellno" required value="'.$valueCustomer['ade_cellno'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Opening Balance</label>
			<input type="text" class="form-control" style="font-weight:600; font-size:18px !important; text-align:center; color:#00f;" value="'.number_format($openingbalance).'" readonly>
		</div> 
	</div>
	<div class="col-sm-32">
		<div class="form_sep">
			<label>Company Name</label>
			<input type="text" class="form-control" id="company_name" name="company_name" required value="'.$valueCustomer['company_name'].'" readonly>
		</div> 
	</div>
	<input type="hidden" id="id_ade" name="id_ade" value="'.$valueCustomer['ade_id'].'">
	<input type="hidden" id="customer_openingbalance" name="customer_openingbalance" value="'.$openingbalance.'">
	<input type="hidden" id="id_company" name="id_company" value="'.$valueCustomer['company_id'].'">
	<div style="clear:both;padding:5px;"></div>';
}
//--------------------------------------------
?>