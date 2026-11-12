<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT ade_name  
										FROM ".ADES." 
										WHERE ade_cellno = '".cleanvars($_POST['ade_cellno'])."'  LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)>0) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>ADE Cell NO: "<b>'.cleanvars($_POST['ade_cellno']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".ADES."(
														ade_status					, 
														ade_code					,
														ade_name					,
														ade_cellno					,
														ade_whatsapp				, 
														ade_email					, 
														ade_cnic					,
														ade_address					, 
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['ade_status'])."'	, 
														'".cleanvars($_POST['ade_code'])."'		,
														'".cleanvars($_POST['ade_name'])."'		, 
														'".cleanvars($_POST['ade_cellno'])."'	, 
														'".cleanvars($_POST['ade_whatsapp'])."'	, 
														'".cleanvars($_POST['ade_email'])."'	, 
														'".cleanvars($_POST['ade_cnic'])."'		, 
														'".cleanvars($_POST['ade_address'])."'	, 
														'".cleanvars($_POST['id_company'])."'		
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add ADE: "'.cleanvars($_POST['ade_name']).'" Details';
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
$sqllms  = $dblms->querylms("UPDATE ".ADES." SET    ade_status		= '".cleanvars($_POST['ade_status_edit'])."'
												  , ade_code		= '".cleanvars($_POST['ade_code_edit'])."' 
												  , ade_name		= '".cleanvars($_POST['ade_name_edit'])."' 
												  , ade_cellno		= '".cleanvars($_POST['ade_cellno_edit'])."' 
												  , ade_whatsapp	= '".cleanvars($_POST['ade_whatsapp_edit'])."' 
												  , ade_email		= '".cleanvars($_POST['ade_email_edit'])."' 
												  , ade_cnic		= '".cleanvars($_POST['ade_cnic_edit'])."' 
												  , ade_address		= '".cleanvars($_POST['ade_address_edit'])."' 
												  , id_company		= '".cleanvars($_POST['id_company_edit'])."' 
   											  WHERE ade_id			= '".cleanvars($_POST['ade_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update ADE: "'.cleanvars($_POST['ade_name_edit']).'" details';
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