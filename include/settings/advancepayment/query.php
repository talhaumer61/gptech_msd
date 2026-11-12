<?php 
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	
		//Check if order # already exist
	$conditions = array ( 
							  'select' 		=> 'id'
							, 'where' 		=> array ( 
													  	  'balance_from' 	=> cleanvars(trim($_POST['balance_from']))
													  	, 'balance_to' 		=> cleanvars(trim($_POST['balance_to']))
													 )
							, 'return_type' => 'count' 
						); 
    $sqllmscheck = $dblms->getRows(ADVANCE_PAYSETTING, $conditions);

	//If already order then show error and exit
	if($sqllmscheck>0) { 

		//Set Error MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();


//--------------------------------------
	} else { 
//------------------------------------------------
		$data = array (
					  'status'				=> cleanvars($_POST['status'])
					, 'balance_from'		=> cleanvars(trim($_POST['balance_from']))
					, 'balance_to'			=> cleanvars(trim($_POST['balance_to']))
					, 'balance_percentage'	=> cleanvars($_POST['balance_percentage'])
					, 'neworder_percentage '=> cleanvars($_POST['neworder_percentage'])
					, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
					, 'date_added'			=> date('Y-m-d h:i:s')
				);

		$sqllmsItem  = $dblms->Insert(ADVANCE_PAYSETTING , $data);


//--------------------------------------
	if($sqllmsItem) { 
//--------------------------------------
		$idLatest = $dblms->lastestid();
		$remarks = 'Add Advance Payment Setting # : '.$idLatest.' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
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
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
	$data = array (
					  'status'				=> cleanvars($_POST['status_edit'])
					, 'balance_from'		=> cleanvars(trim($_POST['balance_from_edit']))
					, 'balance_to'			=> cleanvars(trim($_POST['balance_to_edit']))
					, 'balance_percentage'	=> cleanvars($_POST['balance_percentage_edit'])
					, 'neworder_percentage'=> cleanvars($_POST['neworder_percentage_edit'])
					, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
					, 'date_modify'			=> date('Y-m-d h:i:s')
				);
	
	print_r($data);
	echo $_POST['edit_id'];

	$qryUpdate = $dblms->Update(ADVANCE_PAYSETTING, $data, "WHERE id = '".cleanvars($_POST['edit_id'])."'");

//--------------------------------------
	if($qryUpdate) { 
//--------------------------------------
		$remarks = 'Update Advance Payment Setting # : '.$_POST['edit_id'].' details';	
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