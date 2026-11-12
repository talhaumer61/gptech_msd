<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".SHIFTS."(
														shift_status							, 
														shift_name								,
														shift_detail							,
														id_office 								,
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES( 
														'".cleanvars($_POST['shift_status'])."'				,
														'".cleanvars($_POST['shift_name'])."'				, 
														'".cleanvars($_POST['shift_detail'])."'				, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW()
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$std_id = $dblms->lastestid();
//--------------------------------------
		$arraychecked = $_POST['days'];
//--------------------------------------
	for($ichk=0; $ichk<=sizeof($arraychecked); $ichk++){
//--------------------------------------
		if((!empty($_POST['wrkid'][$ichk]) && !empty($_POST['workinghours'][$ichk]))) {	
//--------------------------------------
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".SHIFT_DETAIL." (
																				id_shift				, 
																				day						, 
																				workinghours			, 
																				time_from				, 
																				time_to					, 
																				break_from				,
																				break_to 
													  					  )
						   										VALUES	 (
																			'".cleanvars($std_id)."'						, 
																			'".cleanvars($_POST['days'][$ichk])."'			,
																			'".cleanvars($_POST['workinghours'][$ichk])."'	,
																			'".cleanvars($_POST['time_from'][$ichk])."'		,
																			'".cleanvars($_POST['time_to'][$ichk])."'		,
																			'".cleanvars($_POST['break_from'][$ichk])."'	,
																			'".cleanvars($_POST['break_to'][$ichk])."'			 
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}
//--------------------------------------
	
	$remarks = 'Add Working Shift: "'.cleanvars($_POST['std_id']).'" Details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'	
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
if(isset($_POST['bill_changes'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".SHIFTS." SET 
													  shift_status		= '".cleanvars($_POST['shift_status'])."'
													, shift_name		= '".cleanvars($_POST['shift_name'])."'
													, shift_detail		= '".cleanvars($_POST['shift_detail'])."'
													, id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
													, id_company		= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify		= NOW()
												WHERE shift_id			= '".cleanvars($_GET['id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".SHIFT_DETAIL." WHERE id_shift = '".cleanvars($_GET['id'])."'");
//--------------------------------------

	$remarks = 'Update Working Shift: "'.cleanvars($_GET['id']).'" Details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_company				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'			
														  )
									");
//--------------------------------------
		$arraychecked = $_POST['days'];
//--------------------------------------
	for($ichk=0; $ichk<=sizeof($arraychecked); $ichk++){
//--------------------------------------
		if((!empty($_POST['wrkid'][$ichk]) && !empty($_POST['workinghours'][$ichk]))) {	
//--------------------------------------
			$sqllmsedu  = $dblms->querylms("INSERT INTO ".SHIFT_DETAIL." (
																				id_shift				, 
																				day						, 
																				workinghours			, 
																				time_from				, 
																				time_to					, 
																				break_from				,
																				break_to 
													  					  )
						   										VALUES	 (
																			'".cleanvars($_GET['id'])."'					, 
																			'".cleanvars($_POST['days'][$ichk])."'			,
																			'".cleanvars($_POST['workinghours'][$ichk])."'	,
																			'".cleanvars($_POST['time_from'][$ichk])."'		,
																			'".cleanvars($_POST['time_to'][$ichk])."'		,
																			'".cleanvars($_POST['break_from'][$ichk])."'	,
																			'".cleanvars($_POST['break_to'][$ichk])."'			 
													 					 )
										 ");
//--------------------------------------	
			unset($sqllmsedu);
//--------------------------------------
		}
	}
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}
