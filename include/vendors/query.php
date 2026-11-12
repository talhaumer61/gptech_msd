<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT vendor_name, vendor_cellno   
										FROM ".VENDORS." 
										WHERE  vendor_name = '".cleanvars($_POST['vendor_name'])."'
										AND vendor_cellno = '".cleanvars($_POST['vendor_cellno'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div id="infoupdated" class="alert-box error">
										<span>error: </span>Vendor "<b>'.cleanvars($_POST['vendor_name']).'</b>" already exists.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
//------------------------------------------------

$sqllms  = $dblms->querylms("INSERT INTO ".VENDORS."(
														vendor_status								, 
														vendor_name									,
														vendor_cellno								,
														vendor_email								,
														vendor_address								, 
														vendor_contactperson						, 
														vendor_personcell							, 
														vendor_personwhatsapp						
													  )
	   											VALUES(
														'".cleanvars($_POST['vendor_status'])."'		, 
														'".cleanvars($_POST['vendor_name'])."'			,
														'".cleanvars($_POST['vendor_cellno'])."'		,  
														'".cleanvars($_POST['vendor_email'])."'			, 
														'".cleanvars($_POST['vendor_address'])."'		, 
														'".cleanvars($_POST['vendor_contactperson'])."'	, 	
														'".cleanvars($_POST['vendor_personcell'])."'	, 	
														'".cleanvars($_POST['vendor_personwhatsapp'])."' 	
													  )"
							);
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Add Vendor: "'.cleanvars($_POST['vendor_name']).'" Details';
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
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".VENDORS." SET vendor_status		= '".cleanvars($_POST['vendor_status_edit'])."'
												  , vendor_name			= '".cleanvars($_POST['vendor_name_edit'])."' 
												  , vendor_cellno		= '".cleanvars($_POST['vendor_cellno_edit'])."' 
												  , vendor_email		= '".cleanvars($_POST['vendor_email_edit'])."' 
												  , vendor_address		= '".cleanvars($_POST['vendor_address_edit'])."' 
												  , vendor_contactperson= '".cleanvars($_POST['vendor_contactperson_edit'])."'
												  , vendor_personcell	= '".cleanvars($_POST['vendor_personcell_edit'])."'
												  , vendor_personwhatsapp= '".cleanvars($_POST['vendor_personwhatsapp_edit'])."'
   											  WHERE vendor_id			= '".cleanvars($_POST['vendor_id'])."'");
//--------------------------------------
	if($sqllms) { 
//--------------------------------------
	$remarks = 'Update Vendor: "'.cleanvars($_POST['vendor_name_edit']).'" details';
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