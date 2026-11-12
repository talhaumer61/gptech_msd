<?php 
//----------------------------------------
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  	= $dblms->querylms("DELETE FROM ".EXPENSES." WHERE id ='".$_GET['id']."'");
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record delete successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
}
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".EXPENSES."(
														status								, 
														id_cat								,
														dated								,
														srno								, 
														voucher								, 
														bill_no								, 
														amount								,
														note								, 
														id_office							, 
														id_company 							,
														id_added							,
														date_added	
													  )
	   											VALUES(
														'".cleanvars($_POST['status'])."'		, 
														'".cleanvars($_POST['id_cat'])."'		,
														'".cleanvars($_POST['dated'])."'		, 
														'".cleanvars($_POST['srno'])."'			, 
														'".cleanvars($_POST['voucher'])."'		, 
														'".cleanvars($_POST['bill_no'])."'		, 
														'".cleanvars($_POST['amount'])."'		, 
														'".cleanvars($_POST['note'])."'			, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
														NOW()
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Expense: Amount: "'.cleanvars($_POST['amount']).'" Dated: "'.cleanvars($_POST['dated']).'" Details';
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
$sqllms  = $dblms->querylms("UPDATE ".EXPENSES." SET status			= '".cleanvars($_POST['status_edit'])."'
												  , id_cat			= '".cleanvars($_POST['id_cat_edit'])."' 
												  , dated			= '".cleanvars($_POST['dated_edit'])."' 
												  , voucher			= '".cleanvars($_POST['voucher_edit'])."' 
												  , bill_no			= '".cleanvars($_POST['bill_no_edit'])."' 
												  , amount			= '".cleanvars($_POST['amount_edit'])."' 
												  , note			= '".cleanvars($_POST['note_edit'])."' 
												  , id_office		= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company		= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												  , id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify		= NOW()  
   											  WHERE id				= '".cleanvars($_POST['edit_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Expense Detail of Expense ID: "'.cleanvars($_POST['edit_id']).'"';
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
															'20'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record udpate successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}