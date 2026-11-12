<?php 
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT bank_name  
										FROM ".BANKS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND bank_name = '".cleanvars($_POST['bank_name'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Bank "<b>'.cleanvars($_POST['bank_name']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".BANKS."(
														bank_status								, 
														bank_name								,
														bank_phone								, 
														bank_email								,
														bank_address							, 
														id_office								, 
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['bank_status'])."'			, 
														'".cleanvars($_POST['bank_name'])."'			,
														'".cleanvars($_POST['bank_phone'])."'			, 
														'".cleanvars($_POST['bank_email'])."'			, 
														'".cleanvars($_POST['bank_address'])."'			, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Bank: '.cleanvars($_POST['bank_name']);
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
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".BANKS." SET   bank_status			= '".cleanvars($_POST['bank_status_edit'])."'
												  , bank_name			= '".cleanvars($_POST['bank_name_edit'])."' 
												  , bank_phone			= '".cleanvars($_POST['bank_phone_edit'])."' 
												  , bank_email			= '".cleanvars($_POST['bank_email_edit'])."' 
												  , bank_address		= '".cleanvars($_POST['bank_address_edit'])."' 
												  , id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company			= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
   											  WHERE bank_id				= '".cleanvars($_POST['bank_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Bank: "'.cleanvars($_POST['bank_name_edit']).'" details';
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
//------------------------------------------------
