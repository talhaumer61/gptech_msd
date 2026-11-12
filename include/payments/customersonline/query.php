<?php 
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
	
//------------------------------------------------
	$dataOrder = array(
							  'reference_no'	=> cleanvars($_POST['reference_no_edit'])
							, 'receipt_no'		=> cleanvars($_POST['receipt_no_edit'])
							, 'id_cat'			=> cleanvars($_POST['id_cat_edit'])
							, 'remarks'			=> cleanvars($_POST['remarks_edit'])
							, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_modify'		=> date('Y-m-d h:i:s')
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(PAYMENTS , $dataOrder , " WHERE id = '".cleanvars($_POST['id_edit'])."'");

//--------------------------------------
	if($sqllmsUpdate) { 

//--------------------------------------
		$remarks = 'Update Payment ID: "'.cleanvars($_POST['id_edit']);
		$dataLog = array(
								  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '2'	
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
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
