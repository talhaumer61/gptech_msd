<?php 



//--------------------------------------
if(isset($_POST['submit_changes'])) { 
 
//------------------------------------------------
	if(!empty($_POST['adm_userpass'])) { 
		
		//Insert Query Fields & Values
		$dataPass = array(
							  'adm_userpass'	 => md5(cleanvars($_POST['adm_userpass']))
							, 'adm_originalpass' => (cleanvars($_POST['adm_userpass']))
						 );
	//Execute Update Query
		$sqllmsUpdatePass  = $dblms->Update(ADMINS , $dataPass , " WHERE adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'");

	}
	//Insert Query Fields & Values
	$dataInv = array(
						  'adm_email'		=> cleanvars($_POST['customer_email'])
						, 'adm_phone'		=> cleanvars($_POST['customer_cellno'])						
					);
	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(ADMINS , $dataInv , " WHERE adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'");

//--------------------------------------
	if($sqllmsUpdate) { 
//--------------------------------------
		$dataLoginUpdate = array(
										  'customer_cellno'			=> cleanvars($_POST['customer_cellno']) 
										, 'customer_email'			=> cleanvars($_POST['customer_email']) 
										, 'customer_address'		=> cleanvars($_POST['customer_address']) 
										, 'customer_contactperson'	=> cleanvars($_POST['customer_contactperson']) 
										, 'customer_personcell'		=> cleanvars($_POST['customer_personcell'])
										, 'customer_personwhatsapp'	=> cleanvars($_POST['customer_personwhatsapp']) 
										, 'id_city'					=> cleanvars($_POST['id_city']) 
								);
		$sqllmsUpdateCustomer  = $dblms->Update(CUSTOMERS , $dataLoginUpdate , " WHERE customer_id = '".cleanvars($_POST['customerid'])."'");
//--------------------------------------
		$remarks = 'Update admin: '.cleanvars($_POST['adm_fullname']).' details';
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
