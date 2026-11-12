<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT crs_name  
										FROM ".CRS." 
										WHERE crs_mobile = '".cleanvars($_POST['crs_mobile'])."'  LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)>0) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Mobile NO: "<b>'.cleanvars($_POST['crs_mobile']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".CRS."(
														crs_status					, 
														crs_name					,
														crs_mobile					,
														crs_whatsapp				, 
														crs_email					, 
														crs_designation				,
														id_added                    ,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars($_POST['crs_status'])."'	, 
														'".cleanvars($_POST['crs_name'])."'		, 
														'".cleanvars($_POST['crs_mobile'])."'	, 
														'".cleanvars($_POST['crs_whatsapp'])."'	, 
														'".cleanvars($_POST['crs_email'])."'	, 
														'".cleanvars($_POST['crs_designation'])."'	, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
														NOW()			
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add CRS: "'.cleanvars($_POST['crs_name']).'" Details';
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
$sqllms  = $dblms->querylms("UPDATE ".CRS." SET     crs_status		= '".cleanvars($_POST['crs_status_edit'])."'
												  , crs_name		= '".cleanvars($_POST['crs_name_edit'])."' 
												  , crs_mobile		= '".cleanvars($_POST['crs_mobile_edit'])."' 
												  , crs_whatsapp	= '".cleanvars($_POST['crs_whatsapp_edit'])."' 
												  , crs_email		= '".cleanvars($_POST['crs_email_edit'])."' 
												  , crs_designation	= '".cleanvars($_POST['crs_designation_edit'])."' 
												  , id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify		= '".date("Y-m-d H:i:s")."'
   											  WHERE crs_id			= '".cleanvars($_POST['crs_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update CRS: "'.cleanvars($_POST['crs_name_edit']).'" details';
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