<?php 
//--------------------------------------
if(isset($_POST['submit_bcat'])) { 
//------------------------------------------------

	$sqllmsget  = $dblms->querylms("SELECT role_id, role_status, role_name, role_type 
										FROM ".ROLES." 
										WHERE role_name	= '".cleanvars($_POST['role_name'])."'  LIMIT 1");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsget) > 0) { 
//--------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>error: </span>Role Name '.cleanvars($_POST['role_name']).' already exists.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//--------------------------------------------------
} else { 
//--------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".ROLES." (
															role_status								, 
															role_name								,
															role_type							
														)
	   											VALUES	(
															'".cleanvars($_POST['role_status'])."'	, 
															'".cleanvars($_POST['role_name'])."'	,
															'".cleanvars($_POST['role_type'])."'	
														)
							");
//--------------------------------------
	if($sqllms) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".ROLES." SET role_status		= '".cleanvars($_POST['role_status_edit'])."'
 													,  role_name		= '".cleanvars($_POST['role_name_edit'])."'
													,  role_type		= '".cleanvars($_POST['role_type_edit'])."'
													 WHERE role_id		= '".cleanvars($_POST['role_id'])."'");
//--------------------------------------
	if($sqllms) { 
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//----------------------------------
}