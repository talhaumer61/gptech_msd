<?php 
//----------------------------------------
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  = $dblms->querylms("DELETE FROM ".HOLIDAYS." WHERE id = '".cleanvars($_GET['id'])."'");
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record deleted successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
}
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".HOLIDAYS."(
														status									, 
														caption									, 
														date_start								, 
														date_end								, 
														id_office 								,
														id_company 								,
														id_added								,
														date_added							 
													  )
	   											VALUES(
														'".cleanvars($_POST['status'])."'		, 
														'".cleanvars($_POST['caption'])."'		, 
														'".date('Y-m-d' , strtotime($_POST['date_start']))."'	, 
														'".date('Y-m-d' , strtotime($_POST['date_end']))."'		, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
														NOW()	
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
$sqllms  = $dblms->querylms("UPDATE ".HOLIDAYS." SET status			= '".cleanvars($_POST['status_edit'])."'
													, caption		= '".cleanvars($_POST['caption_edit'])."'
													, date_start	= '".date('Y-m-d' , strtotime($_POST['date_start_edit']))."'
													, date_end		= '".date('Y-m-d' , strtotime($_POST['date_end_edit']))."'
													, id_office		= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
													, id_company	= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id'])."'");
if($sqllms) { 
//--------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//--------------------------------------
}
//--------------------------------------
}