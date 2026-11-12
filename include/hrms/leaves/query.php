<?php 
//------------------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$datefrom = $_POST['date_from'];
$newdatefrom = date('Y-m-d' , strtotime($datefrom));

$dateto = $_POST['date_to'];
$newdateto = date('Y-m-d', strtotime($dateto));
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT id_emply, date_from, date_to
										FROM ".EMPLY_LEAVES."  
										WHERE id_emply  = '".cleanvars($_POST['id_emply'])."' 
										AND date_from   = '".cleanvars($newdatefrom)."' LIMIT 1");
//--------------------------------------------------
if(mysqli_num_rows($sqllmschecker)>0) {
	echo '<div class="alert-box error"><span>Notice: </span> Leave "<span style="color:red;"> from '.cleanvars($_POST['date_from']).' to '.cleanvars($_POST['date_to']).' </span>" already exists</div>';
	$_SESSION['msg']['status'] = '<div class="alert-box error">
									<span>Notice: </span> Leave 
									"<span style="color:red;"> 
										from '.cleanvars($_POST['date_from']).' to '.cleanvars($_POST['date_to']).' 
									</span>" 
									already exists
								</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//--------------------------------------------------
} else {
//--------------------------------------------------

//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLY_LEAVES."(
														id_dept								, 
														id_emply							,
														id_leave							,
														leave_type							,
														reason								,
														duration							,
														date_from							,
														date_to								,
														alternate_emply						,
														id_office 							,
														id_company 							,
														id_added 							,
														date_added 	
													  )
	   											VALUES( 
														'".cleanvars($_POST['id_dept'])."'				,
														'".cleanvars($_POST['id_emply'])."'				, 
														'".cleanvars($_POST['id_leave'])."'				, 
														'".cleanvars($_POST['leave_type'])."'			, 
														'".cleanvars($_POST['reason'])."'				, 
														'".cleanvars($_POST['duration'])."'				, 
														'".$newdatefrom."'								, 
														'".$newdateto."'								, 
														'".cleanvars($_POST['alternate_emply'])."'					, 
														'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'	,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
														NOW()
													  )"
							);
//------------------------------------------------
	if($sqllms) { 
//------------------------------------------------
$std_id = $dblms->lastestid();
//------------------------------------------------
if(!empty($_FILES['std_photo']['name'])) { 
//--------------------------------------
	$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
	$extension 		= strtolower($path_parts['extension']);
//------------------------------------------------
	$img_dir		= "images/leaves/";
	$originalImage	= $img_dir.date("Y-m-d").'-'.(cleanvars($_POST['id_emply'])).'_'.$std_id.".".strtolower($extension);
	$img_fileName	= date("Y-m-d").'-'.(cleanvars($_POST['id_emply'])).'_'.$std_id.".".strtolower($extension);
//------------------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//------------------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLY_LEAVES."
														SET attachemnt = '".$img_fileName."'
												 WHERE  id		 = '".cleanvars($std_id)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//------------------------------------------------	
		move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//------------------------------------------------
	}
//------------------------------------------------
}
//------------------------------------------------	
	$remarks = 'Add Employee Leave: "'.cleanvars($_POST['id_emply']).'" Details';
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
//------------------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//------------------------------------------------
		} 
	}
}


if(isset($_POST['bill_changes'])) { 
//------------------------------------------------

$datefrom = $_POST['date_from'];
$newdatefrom = date('Y-m-d' , strtotime($datefrom));

$dateto = $_POST['date_to'];
$newdateto = date('Y-m-d', strtotime($dateto));

//------------------------------------------------

	$sqllms  = $dblms->querylms("UPDATE ".EMPLY_LEAVES." SET 
													  id_leave			= '".cleanvars($_POST['id_leave'])."'
													, leave_type		= '".cleanvars($_POST['leave_type'])."'
													, reason			= '".cleanvars($_POST['reason'])."'
													, duration			= '".cleanvars($_POST['duration'])."'
													, date_from			= '".$newdatefrom."'
													, date_to			= '".$newdateto."'
													, alternate_emply	= '".cleanvars($_POST['alternate_emply'])."'
													, id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'
													, id_company		= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
 													, date_modify		= NOW()
												WHERE id				= '".cleanvars($_GET['id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
if(!empty($_FILES['std_photo']['name'])) { 
//--------------------------------------
	$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
	$extension 		= strtolower($path_parts['extension']);
//--------------------------------------
	$img_dir		= "images/leaves/";
	$originalImage	= $img_dir.date("Y-m-d").'-'.(cleanvars($_POST['id_emply'])).'_'.$_GET['id'].".".strtolower($extension);
	$img_fileName	= date("Y-m-d").'-'.(cleanvars($_POST['id_emply'])).'_'.$_GET['id'].".".strtolower($extension);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLY_LEAVES."
														SET attachemnt = '".$img_fileName."'
												 WHERE  id		 = '".cleanvars($_GET['id'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
	$remarks = 'Update Employee Leave: "'.cleanvars($_POST['id_emply']).'" Details';
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
