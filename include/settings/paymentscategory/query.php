<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$dataCat = array(
						  'cat_status'		=> cleanvars($_POST['cat_status'])
						, 'cat_name'		=> cleanvars($_POST['cat_name'])
						, 'cat_detail'		=> cleanvars($_POST['cat_detail'])
					);
	$sqllms = $dblms->Insert(PAYMENTS_CATEGORY , $dataCat);
	
//--------------------------------------
	if($sqllms) { 
		$remarks = 'Add  Payment Category : '.cleanvars($_POST['cat_name']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
							, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
							, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
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

	$dataCat = array(
						  'cat_status'	=> cleanvars($_POST['cat_status_edit'])	
						, 'cat_name'	=> cleanvars($_POST['cat_name_edit'])
						, 'cat_detail'	=> cleanvars($_POST['cat_detail_edit'])
					);
	$qryUpdate = $dblms->Update(PAYMENTS_CATEGORY, $dataCat, "WHERE cat_id = '".$_POST['cat_id']."'");


//--------------------------------------
	if($qryUpdate) { 
//--------------------------------------

//--------------------------------------
	$remarks = 'Edit  Payment Category : '.cleanvars($_POST['cat_name_edit']).' details';

		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
							, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
							, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}
