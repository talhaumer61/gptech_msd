<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
//--------------------------------------------
if(isset($_POST['idcustomer'])) {
//--------------------------------------------	
	
	$conditions 	= array ( 
								'select' 	=> ''.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_status, '.CUSTOMERS.'.customer_name,
												'.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_email,
												'.CUSTOMERS.'.customer_address, '.CUSTOMERS.'.customer_contactperson, '.CUSTOMERS.'.customer_loginid,
												'.CUSTOMERS.'.customer_personcell, '.CUSTOMERS.'.customer_personwhatsapp, 
												'.CUSTOMERS.'.customer_openingbalance, '.CUSTOMERS.'.id_ade, '.CUSTOMERS.'.id_company, 
												'.ADES.'.ade_name, '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name, 
												'.CUSTOMERS.'.id_brand, '.CUSTOMERS.'.id_zone',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' 	=> array ( 
														''.CUSTOMERS.'.customer_id' => $_POST['idcustomer'] 
													 ), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valueCustomer 	= $dblms->getRows(CUSTOMERS, $conditions);
//--------------------------------------------
echo ' 
	  <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Full Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_fullname" name="adm_fullname" value="'.$valueCustomer['customer_name'].'" required autocomplete="off">
		</div>
	</div>
	 <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Login ID/ Email</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_username" name="adm_username" value="'.$valueCustomer['customer_code'].'" readonly required autocomplete="off">
		</div>
	</div>
	
    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Login Password</b></label>
		<div class="col-lg-12">
			<input type="password" class="form-control" id="adm_userpass" name="adm_userpass" autocomplete="off">
		</div>
	</div>	

    <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Email Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_email" name="adm_email" value="'.$valueCustomer['customer_email'].'" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Phone No.</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_phone" name="adm_phone" value="'.$valueCustomer['customer_personcell'].'" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Whatsapp</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="adm_personwhatsapp" name="adm_personwhatsapp" value="'.$valueCustomer['customer_personwhatsapp'].'" autocomplete="off">
		</div>
	</div>';
}
//--------------------------------------------
