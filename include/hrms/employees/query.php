<?php 
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".EMPLOYEES."(
														emply_status							, 
														emply_no								,
														emply_name								,
														emply_fathername						,
														emply_cellno							,
														emply_cnic								, 
														emply_email								,
														emply_address							, 
														emply_joindate							, 
														emply_basicsalary						, 
														id_designation							, 
														id_dept 								, 
														id_shift 								, 
														id_office								, 
														id_company 								,
														id_added 								,
														date_added 	
													  )
	   											VALUES(
														'".cleanvars($_POST['emply_status'])."'			, 
														'".cleanvars($_POST['emply_no'])."'				,
														'".cleanvars($_POST['emply_name'])."'			,
														'".cleanvars($_POST['emply_fathername'])."'		,
														'".cleanvars($_POST['emply_cellno'])."'			, 
														'".cleanvars($_POST['emply_cnic'])."'			, 
														'".cleanvars($_POST['emply_email'])."'			, 
														'".cleanvars($_POST['emply_address'])."'		,
														'".cleanvars($_POST['emply_joindate'])."'		,
														'".cleanvars($_POST['emply_basicsalary'])."'	,
														'".cleanvars($_POST['id_designation'])."'		, 
														'".cleanvars($_POST['id_dept'])."'				, 
														'".cleanvars($_POST['id_shift'])."'				, 
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
if(!empty($_FILES['std_photo']['name'])) { 
//--------------------------------------
	$img_dir		= "images/employees/";
	$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
	$extension 		= strtolower($path_parts['extension']);
	$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['emply_name'])).'_'.$std_id.".".strtolower($extension);
	$img_fileName	= to_seo_url(cleanvars($_POST['emply_name'])).'_'.$std_id.".".strtolower($extension);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLOYEES."
														SET emply_photo = '".$img_fileName."'
												 WHERE  emply_id		 = '".cleanvars($std_id)."'");
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
	$remarks = 'Add Employee: "'.cleanvars($_POST['emply_name']).'" Details';
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
$sqllms  = $dblms->querylms("UPDATE ".EMPLOYEES." SET emply_status		= '".cleanvars($_POST['emply_status_edit'])."'
												  , emply_name			= '".cleanvars($_POST['emply_name_edit'])."' 
												  , emply_fathername	= '".cleanvars($_POST['emply_fathername_edit'])."' 
												  , emply_cellno		= '".cleanvars($_POST['emply_cellno_edit'])."' 
												  , emply_cnic			= '".cleanvars($_POST['emply_cnic_edit'])."' 
												  , emply_email			= '".cleanvars($_POST['emply_email_edit'])."' 
												  , emply_address		= '".cleanvars($_POST['emply_address_edit'])."' 
												  , emply_joindate		= '".cleanvars($_POST['emply_joindate_edit'])."' 
												  , emply_basicsalary	= '".cleanvars($_POST['emply_basicsalary_edit'])."' 
												  , id_designation		= '".cleanvars($_POST['id_designation_edit'])."' 
												  , id_dept				= '".cleanvars($_POST['id_dept_edit'])."' 
												  , id_shift			= '".cleanvars($_POST['id_shift_edit'])."' 
												  , id_office			= '".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."' 
												  , id_company			= '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												  , id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
												  , date_modify			= NOW() 
   											  WHERE emply_id			= '".cleanvars($_POST['emply_id'])."'");
//--------------------------------------
	if($sqllms) { 

//--------------------------------------
if(!empty($_FILES['std_photo']['name'])) { 
//--------------------------------------
	$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
	$extension 		= strtolower($path_parts['extension']);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
	$img_dir		= "images/employees/";
	$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['emply_name_edit'])).'_'.$_POST['emply_id'].".".strtolower($extension);
	$img_fileName	= to_seo_url(cleanvars($_POST['emply_name_edit'])).'_'.$_POST['emply_id'].".".strtolower($extension);
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLOYEES."
														SET emply_photo = '".$img_fileName."'
												 WHERE  emply_id		= '".cleanvars($_POST['emply_id'])."'");
		unset($sqllmsupload);
//--------------------------------------
		$mode = '0644'; 	
		move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
	$remarks = 'Update Employee: "'.cleanvars($_POST['emply_name_edit']).'" details';
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