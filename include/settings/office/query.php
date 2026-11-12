<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".OFFICES."(
														office_status								, 
														office_name								   ,
														office_phone								, 
														office_email								, 
														office_fax									, 
														office_address								, 
														office_contactperson						,
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['office_status'])."'		, 
														'".cleanvars($_POST['office_name'])."'			,
														'".cleanvars($_POST['office_phone'])."'			, 
														'".cleanvars($_POST['office_email'])."'			, 
														'".cleanvars($_POST['office_fax'])."'			, 
														'".cleanvars($_POST['office_address'])."'		, 
														'".cleanvars($_POST['office_contactperson'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Office: '.cleanvars($_POST['office_name']).' details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".OFFICES." SET office_status			= '".cleanvars($_POST['office_status_edit'])."'
												  , office_name			= '".cleanvars($_POST['office_name_edit'])."' 
												  , office_phone			= '".cleanvars($_POST['office_phone_edit'])."' 
												  , office_email			= '".cleanvars($_POST['office_email_edit'])."' 
												  , office_fax				= '".cleanvars($_POST['office_fax_edit'])."' 
												  , office_address			= '".cleanvars($_POST['office_address_edit'])."' 
												  , office_contactperson	= '".cleanvars($_POST['office_contactperson_edit'])."' 
												  , id_company				= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
   											  WHERE office_id				= '".cleanvars($_POST['office_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Office: '.cleanvars($_POST['office_name_edit']).' details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}
