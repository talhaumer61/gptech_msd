<?php 

if(isset($_POST['submit_zone'])) { 
	
	$sqllms  = $dblms->querylms("INSERT INTO ".COMPANY."(
														company_status								, 
														company_code								,
														company_name								,
														id_ade										, 
														company_address								, 
													  )
	   											VALUES(
														'".cleanvars($_POST['company_status'])."'		, 
														'".cleanvars($_POST['company_code'])."'			,
														'".cleanvars($_POST['company_name'])."'			,
														'".cleanvars($_POST['id_ade'])."'				,
														'".cleanvars($_POST['company_address'])."'		, 
													  )"
							);
	if($sqllms) { 

		$remarks = 'Add Zone: '.cleanvars($_POST['company_name']).' details';
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
															'".cleanvars($_SESSION['LOGINOFFICE_SSS'])."'	,
															'".cleanvars($_SESSION['LOGINCOMPANY_SSS'])."'			
														  )
									");
									
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
	
}

if(isset($_POST['submit_changes'])) { 
	
	$sqllms  = $dblms->querylms("UPDATE ".COMPANY." SET company_status			= '".cleanvars($_POST['company_status_edit'])."'
												  , company_code			= '".cleanvars($_POST['company_code_edit'])."' 
												  , company_name			= '".cleanvars($_POST['company_name_edit'])."' 
												  , id_ade					= '".cleanvars($_POST['id_ade_edit'])."' 
												  , company_address			= '".cleanvars($_POST['company_address_edit'])."' 
   											  WHERE company_id				= '".cleanvars($_POST['company_id'])."'");
											  
	if($sqllms) { 
		
		if(!empty($_FILES['std_photo']['name'])) { 
			
			$path_parts 	= pathinfo($_FILES["std_photo"]["name"]);
			$extension 		= strtolower($path_parts['extension']);
			
			$img_dir		= "images/company/";
			$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['company_name_edit'])).'_'.$_POST['company_id'].".".strtolower($extension);
			$img_fileName	= to_seo_url(cleanvars($_POST['company_name_edit'])).'_'.$_POST['company_id'].".".strtolower($extension);
			
			if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
				
				$sqllmsupload  = $dblms->querylms("UPDATE ".COMPANY."
																SET company_logo = '".$img_fileName."'
														WHERE  company_id		 = '".cleanvars($_POST['company_id'])."'");
				unset($sqllmsupload);
				$mode = '0644'; 
				
				move_uploaded_file($_FILES['std_photo']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));
				
			}
			
		}

		$remarks = 'Update Company: '.cleanvars($_POST['company_name_edit']).' details';
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
															'".cleanvars($_SESSION['LOGINOFFICE_SSS'])."'	,
															'".cleanvars($_SESSION['LOGINCOMPANY_SSS'])."'			
														  )
									");
									
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
	
}
