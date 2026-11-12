<?php 
//--------------------------------------
if(isset($_POST['submit_usr'])) { 
//------------------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA'] == 1) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".ADMINS." (
														adm_status									, 
														adm_logintype								, 
														adm_type									, 
														adm_username								, 
														adm_userpass								, 
														adm_fullname								, 
														adm_email									, 
														adm_phone									, 
														id_company									
													)
	   										VALUES (
														'".cleanvars($_POST['adm_status'])."'		, 
														'1'											, 
														'".cleanvars($_POST['adm_type'])."'			, 
														'".cleanvars($_POST['adm_username'])."'		, 
														'".md5(cleanvars($_POST['adm_userpass']))."', 
														'".cleanvars($_POST['adm_fullname'])."'		, 
														'".cleanvars($_POST['adm_email'])."'		, 
														'".cleanvars($_POST['adm_phone'])."'		, 
														'".cleanvars($_POST['id_company'])."'		
													)
						");
//------------------------------------------------
} else { 
//------------------------------------------------
if(isset($_POST['id_office'])) { 
	$officeid	= $_POST['id_office'];
} else { 
	$officeid	= '';
}
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".ADMINS." (
														adm_status									, 
														adm_logintype								, 
														adm_type									, 
														adm_username								, 
														adm_userpass								, 
														adm_fullname								, 
														adm_email									, 
														adm_phone									, 
														id_office									, 
														id_company									
													)
	   										VALUES (
														'".cleanvars($_POST['adm_status'])."'		, 
														'1'											, 
														'".cleanvars($_POST['adm_type'])."'			, 
														'".cleanvars($_POST['adm_username'])."'		, 
														'".md5(cleanvars($_POST['adm_userpass']))."', 
														'".cleanvars($_POST['adm_fullname'])."'		, 
														'".cleanvars($_POST['adm_email'])."'		, 
														'".cleanvars($_POST['adm_phone'])."'		, 
														'".cleanvars($officeid)."'					, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'		
													)
						");
//------------------------------------------------
}
//--------------------------------------
	if($sqllms) { 

//--------------------------------------
	$std_id = $dblms->lastestid();
	$arraychecked = $_POST['right_name'];
//--------------------------------------
//	 foreach($_POST['right_name'] as $key => $value){
	for($ichk=0; $ichk<=sizeof($_POST['right_name']); $ichk++) {
//--------------------------------------
		if(((!empty($_POST['delete'][$ichk])) || (!empty($_POST['edit'][$ichk])) || (!empty($_POST['view'][$ichk])) || (!empty($_POST['add'][$ichk])))) {		
//--------------------------------------		
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".ADMIN_ROLES." (
																			right_name				, 
																			added					, 
																			updated					,
																			deleted					,
																			view					,
																			right_type				,
																			id_adm					
																							
													  					  )
						   										VALUES	 (
																			'".cleanvars($_POST['right_name'][$ichk])."'	, 
																			'".cleanvars($_POST['add'][$ichk])."'			,
																			'".cleanvars($_POST['edit'][$ichk])."'			,
																			'".cleanvars($_POST['delete'][$ichk])."'		,
																			'".cleanvars($_POST['view'][$ichk])."'			,
																			'".cleanvars($_POST['right_type'][$ichk])."'		,
																			'".cleanvars($std_id)."'
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}
//--------------------------------------
	$remarks = 'Add Admin: '.cleanvars($_POST['adm_fullname']).' with login name: '.cleanvars($_POST['adm_username']).' details';
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
															'".cleanvars($_SESSION['LOGINOFFICE_SSS'])."'	,
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
if(!empty($_POST['adm_userpass_edit'])) {
	$sqllms  = $dblms->querylms("UPDATE ".ADMINS." SET adm_userpass = '".md5(cleanvars($_POST['adm_userpass_edit']))."' 
													WHERE adm_id 	= '".cleanvars($_POST['adm_id'])."'");
unset($sqllms);
}
//------------------------------------------------
$sql12 = '';
if($_SESSION['userlogininfo']['LOGINCOMPANY']) {  
//------------------------------------------------
	if(isset($_POST['id_office_edit'])) { 
		$sql12 .=  " , id_office	= '".cleanvars($_POST['id_office_edit'])."'";
	} else { 
		$$sql12 = '';
	}
//------------------------------------------------
	$sql12 .=  " , id_company	= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'";
} else {
	$sql12 .=  " , id_company	= '".cleanvars($_POST['id_company_edit'])."'";
}
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".ADMINS." SET   adm_status		 	= '".cleanvars($_POST['adm_status_edit'])."'
													, adm_type			= '".cleanvars($_POST['adm_type_edit'])."'
													, adm_username		= '".cleanvars($_POST['adm_username_edit'])."'
													, adm_fullname		= '".cleanvars($_POST['adm_fullname_edit'])."'
													, adm_email			= '".cleanvars($_POST['adm_email_edit'])."'
													, adm_phone			= '".cleanvars($_POST['adm_phone_edit'])."'
													$sql12
												WHERE adm_id			= '".cleanvars($_POST['adm_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Admin: '.cleanvars($_POST['adm_fullname_edit']).' with login name: '.cleanvars($_POST['adm_username_edit']).' details';
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
															'".cleanvars($_SESSION['LOGINOFFICE_SSS'])."'	,
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


//--------------------------------------
if(isset($_POST['submit_permission'])) { 
//------------------------------------------------
if(!empty($_POST['adm_userpass'])) {
	$sqllms  = $dblms->querylms("UPDATE ".ADMINS." SET adm_userpass = '".md5(cleanvars($_POST['adm_userpass']))."' 
													WHERE adm_id 	= '".cleanvars($_GET['id'])."'");
unset($sqllms);
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".ADMINS." SET adm_status	= '".cleanvars($_POST['adm_status'])."'
													, adm_type		= '".cleanvars($_POST['adm_type'])."'
													, adm_username	= '".cleanvars($_POST['adm_username'])."'
													, adm_fullname	= '".cleanvars($_POST['adm_fullname'])."'
													, adm_email		= '".cleanvars($_POST['adm_email'])."'
													, adm_phone		= '".cleanvars($_POST['adm_phone'])."'
													, id_office		= '".cleanvars($_POST['id_office'])."'
												WHERE adm_id		= '".cleanvars($_GET['id'])."'");
if($sqllms) { 
//--------------------------------------
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".ADMIN_ROLES." WHERE id_adm = '".$_GET['id']."'");
	$arraychecked = $_POST['right_name'];
//--------------------------------------
//	 foreach($_POST['right_name'] as $key => $value){
	for($ichk=0; $ichk<=sizeof($_POST['right_name']); $ichk++) {
//--------------------------------------
		if(((!empty($_POST['delete'][$ichk])) || (!empty($_POST['edit'][$ichk])) || (!empty($_POST['view'][$ichk])) || (!empty($_POST['add'][$ichk])))) {		
//--------------------------------------		
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".ADMIN_ROLES." (
																			right_name				, 
																			added					, 
																			updated					,
																			deleted					,
																			view					,
																			right_type				,
																			id_adm					
																							
													  					  )
						   										VALUES	 (
																			'".cleanvars($_POST['right_name'][$ichk])."'	, 
																			'".cleanvars($_POST['add'][$ichk])."'			,
																			'".cleanvars($_POST['edit'][$ichk])."'			,
																			'".cleanvars($_POST['delete'][$ichk])."'		,
																			'".cleanvars($_POST['view'][$ichk])."'			,
																			'".cleanvars($_POST['right_type'][$ichk])."'	,
																			'".cleanvars($_GET['id'])."'
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}

	$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//--------------------------------------
}
}

