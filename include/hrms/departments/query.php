<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
	$sqllmscheck  = $dblms->querylms("SELECT dept_name  
										FROM ".DEPTS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND dept_name = '".cleanvars($_POST['dept_name'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Department "<b>'.cleanvars($_POST['dept_name']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".DEPTS."(
														dept_status						, 
														dept_name						,
														id_office								, 
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['dept_status'])."'	, 
														'".cleanvars($_POST['dept_name'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Department: "'.cleanvars($_POST['dept_name']).'" detail';
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
	} // end checker
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".DEPTS." SET  dept_status	= '".cleanvars($_POST['dept_status_edit'])."'
												  , dept_name	= '".cleanvars($_POST['dept_name_edit'])."' 
												  , id_office	= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company	= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
   											  WHERE dept_id		= '".cleanvars($_POST['dept_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Department: "'.cleanvars($_POST['dept_name_edit']).'" details';
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
