<?php 
//----------------------------------------
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  = $dblms->querylms("DELETE FROM ".LEAVES." WHERE leave_id = '".cleanvars($_GET['id'])."'");
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record deleted successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
}
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".LEAVES."(
														leave_status									, 
														leave_name										, 
														leave_type										, 
														leave_peryear									, 
														id_office										, 
														id_company								 
													  )
	   											VALUES(
														'".cleanvars($_POST['leave_status'])."'			, 
														'".cleanvars($_POST['leave_name'])."'			, 
														'".cleanvars($_POST['leave_type'])."'			, 
														'".cleanvars($_POST['leave_peryear'])."'		, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
													  )"
							);
if($sqllms) { 
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
$sqllms  = $dblms->querylms("UPDATE ".LEAVES." SET leave_status			= '".cleanvars($_POST['leave_status_edit'])."'
													, leave_name		= '".cleanvars($_POST['leave_name_edit'])."'
													, leave_type		= '".cleanvars($_POST['leave_type_edit'])."'
													, leave_peryear		= '".cleanvars($_POST['leave_peryear_edit'])."'
													, id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
													, id_company		= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
												WHERE leave_id			= '".cleanvars($_POST['leave_id'])."'");
if($sqllms) { 
//--------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//--------------------------------------
}
//--------------------------------------
}