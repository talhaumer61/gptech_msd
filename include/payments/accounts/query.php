<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".ACCOUNTS."(
														account_status							, 
														account_name							,
														account_no								,
														id_bank									, 
														account_bankaddress						,
														account_balance							, 
														id_office								, 
														id_company 								,
														id_added								,
														date_added	
													  )
	   											VALUES(
														'".cleanvars($_POST['account_status'])."'		, 
														'".cleanvars($_POST['account_name'])."'			,
														'".cleanvars($_POST['account_no'])."'			, 
														'".cleanvars($_POST['id_bank'])."'				, 
														'".cleanvars($_POST['account_bankaddress'])."'	, 
														'".cleanvars($_POST['account_balance'])."'		, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW()
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Added Chart of Account: "'.cleanvars($_POST['account_name']).'" Account no: "'.cleanvars($_POST['account_no']).'" Details';
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
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".ACCOUNTS." SET account_status			= '".cleanvars($_POST['account_status_edit'])."'
												  , account_name			= '".cleanvars($_POST['account_name_edit'])."' 
												  , account_no				= '".cleanvars($_POST['account_no_edit'])."' 
												  , id_bank					= '".cleanvars($_POST['id_bank_edit'])."' 
												  , account_bankaddress		= '".cleanvars($_POST['account_bankaddress_edit'])."' 
												  , account_balance			= '".cleanvars($_POST['account_balance_edit'])."' 
												  , id_office				= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company				= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												  , id_modify				= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify				= NOW()  
   											  WHERE account_id				= '".cleanvars($_POST['account_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Account Detail of Account ID: "'.cleanvars($_POST['account_id']).'"';
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