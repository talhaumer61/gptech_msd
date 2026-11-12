<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT cat_name  
										FROM ".EXPENSE_CATS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND cat_name = '".cleanvars($_POST['cat_name'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div id="infoupdated" class="alert-box error">
										<span>error: </span>Item "<b>'.cleanvars($_POST['cat_name']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".EXPENSE_CATS."(
														cat_status							, 
														cat_name							,
														cat_detail							,
														id_office							, 
														id_company 	
													  )
	   											VALUES(
														'".cleanvars($_POST['cat_status'])."'			, 
														'".cleanvars($_POST['cat_name'])."'				,
														'".cleanvars($_POST['cat_detail'])."'			,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Expense Category: "'.cleanvars($_POST['cat_name']).'" detail';
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
$sqllms  = $dblms->querylms("UPDATE ".EXPENSE_CATS." SET cat_status	= '".cleanvars($_POST['cat_status_edit'])."'
												  , cat_name			= '".cleanvars($_POST['cat_name_edit'])."' 
												  , cat_detail			= '".cleanvars($_POST['cat_detail_edit'])."' 
												  , id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company			= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
   											  WHERE cat_id				= '".cleanvars($_POST['cat_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Expense Category: "'.cleanvars($_POST['cat_name_edit']).'" details';
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
