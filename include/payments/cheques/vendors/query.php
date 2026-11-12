<?php 
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".PAYMENTS." SET cheque				= '".cleanvars($_POST['cheque_edit'])."'
												  , cheque_date			= '".cleanvars($_POST['cheque_date_edit'])."' 
												  , cheque_status		= '".cleanvars($_POST['cheque_status_edit'])."' 
												  , cheque_cleardate	= '".cleanvars($_POST['cheque_cleardate_edit'])."' 
												  , cheque_remarks		= '".cleanvars($_POST['remarks_edit'])."' 
												  , id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify			= NOW()  
   											  WHERE id					= '".cleanvars($_POST['id_edit'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Cheque : "'.cleanvars($_POST['cheque_edit']);
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

//--------------------------------------
if(isset($_POST['submit_cleared'])) { 
//------------------------------------------------
for($iod=0;$iod<=count($_POST['payid']);$iod++) {
	if(!empty($_POST['payid'][$iod])) {
		$sqllmscler  = $dblms->querylms("UPDATE ".PAYMENTS." SET cheque_status	= '1'
												  		, cheque_cleardate	= '".cleanvars(date("Y-m-d"))."' 
   											  		WHERE id				= '".cleanvars($_POST['payid'][$iod])."'");

$sqllms  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.id = '".cleanvars($_POST['payid'][$iod])."' LIMIT 1");
		$valuepay = mysqli_fetch_array($sqllms);
//--------------------------------------
	$sqllmsledger  = $dblms->querylms("INSERT INTO ".CUSTOMERS_LEDGER."(
														dated									, 
														detail									, 
														slipno									,
														type									,
														doc_type								,
														pay_type								,
														ledgerfor								,
														amount									,
														id_customer								,
														id_invpay								, 
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars(date("Y-m-d"))."'									, 
														'".get_paytypes($valuepay['method']).' Payment'."'				, 
														'".cleanvars($valuepay['slipno'])."'							,
														'2'																,
														'1'																,
														'2'																,
														'2'																,
														'".cleanvars($valuepay['amount'])."'							,  
														'".cleanvars($valuepay['id_paid'])."'							,
														'".cleanvars($_POST['payid'][$iod])."'							,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
														NOW()
													  )"
							);


	}
}
//--------------------------------------
	if($sqllmscler) { 
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Cheques cleared successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}