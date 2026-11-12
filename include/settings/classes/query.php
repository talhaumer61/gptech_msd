<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT cls_id, cls_name  
										FROM ".CLASSES." 
										WHERE cls_name = '".cleanvars($_POST['cls_name'])."'
										AND  id_company = '".cleanvars($_POST['id_company'])."'LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)>0) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Class: "<b>'.cleanvars($_POST['cls_name']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".CLASSES."(
														cls_status					, 
														cls_code					,
														cls_name					,
														cls_detail					,
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['cls_status'])."'	, 
														'".cleanvars($_POST['cls_code'])."'		,
														'".cleanvars($_POST['cls_name'])."'		, 
														'".cleanvars($_POST['cls_detail'])."'	, 
														'".cleanvars($_POST['id_company'])."'		
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Class: "'.cleanvars($_POST['cls_name']).'" Details';
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
$sqllms  = $dblms->querylms("UPDATE ".CLASSES." SET cls_status		= '".cleanvars($_POST['cls_status_edit'])."'
												  , cls_code		= '".cleanvars($_POST['cls_code_edit'])."' 
												  , cls_name		= '".cleanvars($_POST['cls_name_edit'])."' 
												  , cls_detail		= '".cleanvars($_POST['cls_detail_edit'])."' 
												  , id_company		= '".cleanvars($_POST['id_company_edit'])."' 
   											  WHERE cls_id			= '".cleanvars($_POST['cls_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Class: "'.cleanvars($_POST['cls_name_edit']).'" details';
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