<?php 
//--------------------------------------
if(isset($_POST['submit_import'])) { 
$arraychecked = $_POST['acno'];
for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){ 
	$sqllmschecker  = $dblms->querylms("SELECT * FROM ".EMPLY_ATTENDANCE."	
													WHERE id_emply = '".cleanvars($_POST['id_emply'][$ichk])."' 
													AND dated = '".cleanvars($_POST['dated'][$ichk])."'LIMIT 1");
	$valueemply = mysqli_fetch_array($sqllmschecker);
if(mysqli_num_rows($sqllmschecker)<1) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLY_ATTENDANCE."(
														id_dept								, 
														id_emply							,
														id_shift							,
														dated								,
														onduty								,
														offduty								,
														clock_in							,
														clock_out							,
														id_office							,
														id_company												
													  )
	   											VALUES( 
														'".cleanvars($_POST['id_dept'][$ichk])."'		,
														'".cleanvars($_POST['id_emply'][$ichk])."'		, 
														'".cleanvars($_POST['id_shift'][$ichk])."'		, 
														'".cleanvars($_POST['dated'][$ichk])."'			, 
														'".cleanvars($_POST['onduty'][$ichk])."'		, 
														'".cleanvars($_POST['offduty'][$ichk])."'		, 
														'".cleanvars($_POST['ClockIn'][$ichk])."'		, 
														'".cleanvars($_POST['ClockOut'][$ichk])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'		,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
													  )"
							);
}
//------------------------------------------------
		}

		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
}

//--------------------------------------
if(isset($_POST['submit_country'])) { 

	$sqllmschecker  = $dblms->querylms("SELECT * FROM ".EMPLY_ATTENDANCE."	
													WHERE id_emply = '".cleanvars($_POST['id_emply'])."' 
													AND dated = '".cleanvars($_POST['dated'])."'LIMIT 1");
	$valueemply = mysqli_fetch_array($sqllmschecker);
//--------------------------------------------------
if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box error">
									<span>Notice: </span>Attendance: 
									"<span style="color:red;"> Dated '.cleanvars($_POST['dated']).' </span>" already exists
								</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
} else {
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".EMPLY_ATTENDANCE."(
														id_dept								, 
														id_emply							,
														id_shift							,
														dated								,
														clock_in							,
														clock_out							,
														remarks								,
														id_office 							,
														id_company 							,
														id_added 							,
														date_added 	
													  )
	   											VALUES( 
														'".cleanvars($_POST['id_dept'])."'				,
														'".cleanvars($_POST['id_emply'])."'				, 
														'".cleanvars($_POST['id_shift'])."'				, 
														'".cleanvars($_POST['dated'])."'				, 
														'".cleanvars($_POST['clock_in'])."'				, 
														'".cleanvars($_POST['clock_out'])."'			, 
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
	
	$remarks = 'Add Employee Attendance: "'.cleanvars($_POST['emply_no']).' - '.cleanvars($_POST['emply_name']).'" Details';
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
}

//--------------------------------------
if(isset($_POST['bill_changes'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".EMPLY_ATTENDANCE." SET 
												  dated			= '".cleanvars($_POST['dated'])."'
												, clock_in		= '".cleanvars($_POST['clock_in'])."'
												, clock_out		= '".cleanvars($_POST['clock_out'])."'
												, remarks		= '".cleanvars($_POST['remarks'])."'
												, id_office		= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
												, id_company	= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
												, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 												, date_modify	= NOW()
												WHERE id		= '".cleanvars($_GET['id'])."'");
//--------------------------------------
	if($sqllms) { 

//--------------------------------------
	$remarks = 'Update Employee Attendance: "'.cleanvars($_POST['emply_no']).' - '.cleanvars($_POST['emply_name']).'" Details';
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
														  )
									");
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}
//------------------------------------------------