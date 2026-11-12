<?php 
$bad_symbols = array(",", ".");
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT receipt_no, amount   
										FROM ".PAYMENTS." 
										WHERE receipt_no = '".cleanvars(trim($_POST['receipt_no']))."'
										AND docs_types = '1' AND debit_credit = '1' AND ledgerfor = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Slip #: <b>'.cleanvars($_POST['receipt_no']).'</b> already exist.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		
		$systemslip 	= $mainclass->get_systemslipno(2,2);
		
		
		
		$amount = str_replace($bad_symbols, "", $_POST['amount']);
		
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".PAYMENTS."(
														status									,
														systemslip_no							,
														ledgerfor								, 
														docs_types								,
														id_user									,
														reference_no							, 
														dated									,
														receipt_no								, 
														amount									, 
														debit_credit							, 
														pay_mode								, 
														remarks									, 
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'1'												,
														'".$systemslip."'								,
														'2'												, 
														'1'												,
														'".cleanvars($_POST['id_paid'])."'				, 
														'".cleanvars($_POST['reference_no'])."'			, 
														'".cleanvars($dated)."'							, 
														'".cleanvars($_POST['receipt_no'])."'			, 
														'".$amount."'									, 
														'2'												, 
														'".cleanvars($_POST['method'])."'				, 
														'".cleanvars($_POST['remarks'])."'				, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW() 
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Vendor Payment Amount: '.cleanvars($_POST['amount']);
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						
														  )
									");
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
	}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
	
	$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated_edit'])));
	$amount = str_replace($bad_symbols, "", $_POST['amount_edit']);
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".PAYMENTS." SET status				= '1'
												  , reference_no		= '".cleanvars($_POST['reference_no_edit'])."' 
												  , dated				= '".cleanvars($dated)."' 
												  , receipt_no			= '".cleanvars($_POST['receipt_no_edit'])."' 
												  , amount				= '".$amount."' 
												  , pay_mode			= '".cleanvars($_POST['method_edit'])."' 
												  , remarks				= '".cleanvars($_POST['remarks_edit'])."' 
												  , id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify			= NOW()  
   											  WHERE id					= '".cleanvars($_POST['id_edit'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Payment Amount: "'.cleanvars($_POST['amount_edit']);
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'							
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
