<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------

			
	//Insert Query Fields & Values
	$dataLogin = array (
								  'adm_status'			=> 1
								, 'adm_logintype'		=> 2
								, 'adm_username'		=> cleanvars($_POST['adm_username'])
								, 'adm_userpass'		=> md5(cleanvars($_POST['adm_userpass']))
								, 'adm_originalpass'	=> (cleanvars($_POST['adm_userpass']))
								, 'adm_fullname'		=> cleanvars($_POST['adm_fullname'])
								, 'adm_email'			=> cleanvars($_POST['adm_email'])
								, 'adm_phone'			=> cleanvars($_POST['adm_phone'])		
						);
	$sqllmsInsertLoin  = $dblms->Insert(ADMINS , $dataLogin);
	if($sqllmsInsertLoin) {
				// update customer table with admin id
				$idLatestAdmin = $dblms->lastestid();
				
				$dataLoginUpdate = array(
											  'customer_loginid'		=> $idLatestAdmin 
											, 'customer_email'			=> cleanvars($_POST['adm_email']) 
											, 'customer_personcell'		=> cleanvars($_POST['adm_phone']) 
											, 'customer_personwhatsapp'	=> cleanvars($_POST['adm_personwhatsapp']) 
										);
				//Execute Update Query
				$sqllmsUpdateCustomer  = $dblms->Update(CUSTOMERS , $dataLoginUpdate , " WHERE customer_id = '".cleanvars($_POST['id_customer'])."'");

			


//----------- for log
		$remarks = 'Add Admin: '.cleanvars($_POST['customer_name']).' details';
		//Insert Query Fields & Values
		$dataLog = array(
				'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])			,
				'filename'			=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)		,
				'action'			=> 1															,
				'dated'				=> date('Y-m-d h:i:s')											,
				'ip'				=> cleanvars($ip)												,
				'remarks'			=> cleanvars($remarks)											,
				'id_office'			=> cleanvars($_SESSION['LOGINOFFICE_SSS'])						,
				'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])			
			);
		$sqllmsInsertLog  = $dblms->Insert(LOGS , $dataLog);
		// end log
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} // end check insert

//--------------------------------------
} // end submit



//--------------------------------------
if(isset($_POST['submit_changes'])) { 
 
//------------------------------------------------
	if(!empty($_POST['adm_userpass_edit'])) { 
		
		//Insert Query Fields & Values
		$dataPass = array(
							  'adm_userpass'	 => md5(cleanvars($_POST['adm_userpass_edit']))
							, 'adm_originalpass' => (cleanvars($_POST['adm_userpass_edit']))
						 );
	//Execute Update Query
		$sqllmsUpdatePass  = $dblms->Update(ADMINS , $dataPass , " WHERE adm_id = '".cleanvars($_POST['adm_id'])."'");

	}
	//Insert Query Fields & Values
	$dataInv = array(
						  'adm_status'		=> cleanvars($_POST['adm_status_edit'])
						, 'adm_fullname'	=> cleanvars($_POST['adm_fullname_edit'])
						, 'adm_email'		=> cleanvars($_POST['adm_email_edit'])
						, 'adm_phone'		=> cleanvars($_POST['adm_phone_edit'])						
					);
	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(ADMINS , $dataInv , " WHERE adm_id = '".cleanvars($_POST['adm_id'])."'");

//--------------------------------------
	if($sqllmsUpdate) { 
//--------------------------------------
		$dataLoginUpdate = array(
									  'customer_email'			=> cleanvars($_POST['adm_email_edit']) 
									, 'customer_personcell'		=> cleanvars($_POST['adm_phone_edit']) 
									, 'customer_personwhatsapp'	=> cleanvars($_POST['adm_personwhatsapp_edit']) 
								);
		$sqllmsUpdateCustomer  = $dblms->Update(CUSTOMERS , $dataLoginUpdate , " WHERE customer_id = '".cleanvars($_POST['customer_id'])."'");
//--------------------------------------
		$remarks = 'Update admin: '.cleanvars($_POST['adm_fullname_edit']).' details';
		//Insert Query Fields & Values
		$dataLog = array(
				'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])			,
				'filename'			=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)		,
				'action'			=> 2															,
				'dated'				=> date('Y-m-d h:i:s')											,
				'ip'				=> cleanvars($ip)												,
				'remarks'			=> cleanvars($remarks)											,
				'id_office'			=> cleanvars($_SESSION['LOGINOFFICE_SSS'])						,
				'id_company'		=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])			
			);
		$sqllmsInsertLog  = $dblms->Insert(LOGS , $dataLog);

//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}
