<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$conditions = array ( 
								'select' 	=> 'customer_id',							
								'where' 	=> array ( 
														  'customer_name' => cleanvars(trim($_POST['customer_name'])) 
													 ), 
								'return_type' 	=> 'count' 
							); 
    $sqllmscheck = $dblms->getRows(CUSTOMERS, $conditions);
	
if(($sqllmscheck)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Customer name already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	
} else {
	
		$conditions = array ( 
								  'select' 		=> 'customer_id'
								, 'order_by' 	=> 'customer_id DESC'
								, 'return_type' => 'single' 
							); 
    	$reultorder = $dblms->getRows(CUSTOMERS, $conditions);
		$countorder = $reultorder['customer_id'];
			
		if($countorder<9) {
			$orderno = get_brandcode($_POST['id_brand']).'-00000'.($countorder+1);
		} else if($countorder<99) {
			$orderno = get_brandcode($_POST['id_brand']).'-0000'.($countorder+1);
		} else if($countorder<999) {
			$orderno = get_brandcode($_POST['id_brand']).'-000'.($countorder+1);
		} else if($countorder<9999) {
			$orderno = get_brandcode($_POST['id_brand']).'-00'.($countorder+1);
		} else if($countorder<99999) {
			$orderno = get_brandcode($_POST['id_brand']).'-0'.($countorder+1);
		}else {
			$orderno = get_brandcode($_POST['id_brand']).'-'.($countorder+1);
		}
//------------------------------------------------
		$data = array(
						  'customer_status'			=> cleanvars($_POST['customer_status'])	
						, 'id_type'					=> cleanvars($_POST['id_type'])	
						, 'customer_code'	        => cleanvars($orderno)
						, 'customer_name'		    => cleanvars(trim($_POST['customer_name']))
						, 'customer_cellno'		    => cleanvars($_POST['customer_cellno'])
						, 'customer_email'		    => cleanvars($_POST['customer_email'])
						, 'customer_address'		=> cleanvars($_POST['customer_address'])
						, 'customer_contactperson'	=> cleanvars($_POST['customer_contactperson'])
						, 'customer_personcell'		=> cleanvars($_POST['customer_personcell'])
						, 'customer_personwhatsapp'	=> cleanvars($_POST['customer_personwhatsapp'])
						, 'id_city'		    		=> cleanvars($_POST['id_city'])
						, 'id_ade'		    		=> cleanvars($_POST['id_ade'])
						, 'id_company'	        	=> cleanvars($_POST['id_company'])
						, 'id_brand'	        	=> cleanvars($_POST['id_brand'])
						, 'customer_invoicelogo'	=> cleanvars($_POST['customer_invoicelogo'])
			);

		$sqllms  = $dblms->Insert(CUSTOMERS , $data);

//--------------------------------------
	if($sqllms) { 
		
			$latest_id = $dblms->lastestid();	
			//Insert Query Fields & Values
			$dataLogin = array(
								  'adm_status'			=> 1
								, 'adm_logintype'		=> 2
								, 'adm_username'		=> cleanvars($orderno)
								, 'adm_userpass'		=> md5(cleanvars($orderno))
								, 'adm_originalpass'	=> (cleanvars($orderno))
								, 'adm_fullname'		=> cleanvars(trim($_POST['customer_name']))
								, 'adm_email'			=> cleanvars($_POST['customer_email'])
								, 'adm_phone'			=> cleanvars($_POST['customer_personcell'])		
							);
			$sqllmsInsertLoin  = $dblms->Insert(ADMINS , $dataLogin);
		if($sqllmsInsertLoin) {
				// update customer table with admin id
				$idLatestAdmin = $dblms->lastestid();
				
				$dataLoginUpdate = array(
											'customer_loginid'	=> $idLatestAdmin 
										);
				//Execute Update Query
				$sqllmsUpdateCustomer  = $dblms->Update(CUSTOMERS , $dataLoginUpdate , " WHERE customer_id = '".cleanvars($latest_id)."'");
		}
//--------------------------------------
		$remarks = 'Add Customer: '.cleanvars($_POST['customer_name']).' details';
		$datalog = array(
						  'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'filename'	    => strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
						, 'action'		    => 1
						, 'dated'		    => date("Y-m-d H:i:s")
						, 'ip'		    	=> cleanvars($ip)
						, 'remarks'			=> cleanvars($remarks)
						, 'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
						, 'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
			);
		$sqllmslog  = $dblms->Insert(LOGS , $datalog);
		
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
 }// end check customer name 
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
	
//------------------------------------------------
	$conditions = array ( 
								'select' 	=> 'customer_id',							
								'where' 	=> array ( 
														  'customer_name' => cleanvars(trim($_POST['customer_name_edit'])) 
													 ), 
								'return_type' 	=> 'count' 
							); 
    $sqllmscheck = $dblms->getRows(CUSTOMERS, $conditions);
	
if(($sqllmscheck)>1) { 
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Customer <span style="color:#f00;">"'.$_POST['customer_name_edit'].'"</span> already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	
} else {	
	
	if($_POST['customer_id']<9) {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-00000'.($_POST['customer_id']);
	} else if($_POST['customer_id']<99) {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-0000'.($_POST['customer_id']);
	} else if($_POST['customer_id']<999) {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-000'.($_POST['customer_id']);
	} else if($_POST['customer_id']<9999) {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-00'.($_POST['customer_id']);
	} else if($_POST['customer_id']<99999) {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-0'.($_POST['customer_id']);
	}else {
		$orderno = get_brandcode($_POST['id_brand_edit']).'-'.($_POST['customer_id']);
	}

	
// checking admin id 
if(!empty($_POST['loginid_edit'])) {
	
	if($orderno != $_POST['customer_code_edit']) {
		$dataLoginUpdate = array (
									  'adm_username'	=> cleanvars($orderno)
									, 'adm_userpass'	=> md5(cleanvars($orderno))
									, 'adm_originalpass'=> (cleanvars($orderno))
								);
					//Execute Update Query
		$sqllmsUpdateCustomer  = $dblms->Update(ADMINS , $dataLoginUpdate , " WHERE adm_id = '".cleanvars($_POST['loginid_edit'])."'");
	}
	$idLatestAdmin = $_POST['loginid_edit'];

} else {
		//Insert Query Fields & Values
		$dataLogin = array(
								  'adm_status'		=> 1
								, 'adm_logintype'	=> 2
								, 'adm_username'	=> cleanvars($orderno)
								, 'adm_userpass'	=> md5(cleanvars($orderno))
								, 'adm_originalpass'=> (cleanvars($orderno))
								, 'adm_fullname'	=> cleanvars(trim($_POST['customer_name_edit']))
								, 'adm_email'		=> cleanvars($_POST['customer_email_edit'])
								, 'adm_phone'		=> cleanvars($_POST['customer_personcell_edit'])		
							);
		$sqllmsInsertLoin  = $dblms->Insert(ADMINS , $dataLogin);
		$idLatestAdmin = $dblms->lastestid();
}
//------------------------------------------------
	$data = array(
						  'customer_status'			=> cleanvars($_POST['customer_status_edit'])
						, 'id_type'					=> cleanvars($_POST['id_type_edit'])	
						, 'customer_loginid'		=> cleanvars($idLatestAdmin)
						, 'customer_code'	        => cleanvars($orderno)
						, 'customer_codelhsmes'		=> cleanvars(trim($_POST['customer_codelhsmes_edit']))
						, 'customer_name'		    => cleanvars(trim($_POST['customer_name_edit']))
						, 'customer_cellno'		    => cleanvars($_POST['customer_cellno_edit'])
						, 'customer_email'		    => cleanvars($_POST['customer_email_edit'])
						, 'customer_address'		=> cleanvars($_POST['customer_address_edit'])
						, 'customer_contactperson'	=> cleanvars($_POST['customer_contactperson_edit'])
						, 'customer_personcell'		=> cleanvars($_POST['customer_personcell_edit'])
						, 'customer_personwhatsapp'	=> cleanvars($_POST['customer_personwhatsapp_edit'])
						, 'id_city'		    		=> cleanvars($_POST['id_city_edit'])
						, 'id_ade'		    		=> cleanvars($_POST['id_ade_edit'])
						, 'id_company'	        	=> cleanvars($_POST['id_company_edit'])
						, 'id_brand'	        	=> cleanvars($_POST['id_brand_edit'])
						, 'customer_invoicelogo'	=> cleanvars($_POST['customer_invoicelogo_edit'])
			);
	$sqllms = $dblms->Update(CUSTOMERS, $data, "WHERE customer_id = '".cleanvars($_POST['customer_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------

//--------------------------------------
		$remarks = 'Update Customer: '.cleanvars($_POST['customer_name_edit']).' details';
		$datalog = array(
						  'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'filename'	    => strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
						, 'action'		    => 2
						, 'dated'		    => date("Y-m-d H:i:s")
						, 'ip'		    	=> cleanvars($ip)
						, 'remarks'			=> cleanvars($remarks)
						, 'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
						, 'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
			);
		$sqllmslog  = $dblms->Insert(LOGS , $datalog);
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} // end query successfully run
} // end check customer name
//--------------------------------------
} // end submit
 