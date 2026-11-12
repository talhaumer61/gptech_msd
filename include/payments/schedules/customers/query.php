<?php 
//Add Purchase Order
if(isset($_POST['submit_order'])) { 

	
		//Insert Query Fields & Values
		$dataInv = array(
								  'id_user'			=> cleanvars($_POST['id_customer'])
								, 'user_type'		=> 1 
								, 'totalamount'		=> cleanvars($_POST['grand_insttotal'])
								, 'totalinsts'		=> count(($_POST['intamount']))
								, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'		=> date('Y-m-d h:i:s')
						);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(PAYMENTS_SCHEDULE , $dataInv);

		//If Insert Query Executed
		if($sqllmsInsert) { 

			//latest PK of Table
			$idLatest = $dblms->lastestid();
			
		for($intk=1; $intk<=sizeof($_POST['intamount']); $intk++){
//------------------------------------------------
			if(!empty($_POST['intamount'][$intk])) {
				
				// Insert  payments
				$dataInst = array(
										  'id_setup'		=> $idLatest
										, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['intdated'][$intk])))
										, 'amount'			=> cleanvars($_POST['intamount'][$intk])
										, 'remarks'			=> cleanvars($_POST['intremarks'][$intk])						
								);

				$sqllmsInsts  = $dblms->Insert(PAYMENTS_SCHEDULE_DETAILS , $dataInst);
			
			}
		}
			//--------------------------------------
			$remarks = 'Add Customer Payment Schedule: '.$idLatest;
			$dataLog = array(
									  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
									, 'action'		=> '1'	
									, 'dated'		=> date("Y-m-d H:i:s")
									, 'ip'			=> cleanvars($ip)
									, 'remarks'		=> cleanvars($remarks)
								);
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
	

			//Set Success MSG in Session & Exit
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
			header("Location: customerspaymentschedule.php", true, 301);
			exit();
		}

	

}


//Update Purchase Order
if(isset($_POST['bill_changes'])) { 


	$dataOrder = array(
						  'totalamount'		=> cleanvars($_POST['grand_insttotal'])
						, 'totalinsts'		=> count(($_POST['intamount']))
						, 'remarks'			=> cleanvars($_POST['remarks'])
						, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(PAYMENTS_SCHEDULE , $dataOrder , " WHERE id = '".cleanvars($_GET['id'])."'");

	//If Update Query Executed
	if($sqllmsUpdate) { 
		


		//Delete Previous Order Details
		$sqllmsDel  = $dblms->querylms("DELETE FROM ".PAYMENTS_SCHEDULE_DETAILS." WHERE id_setup = '".cleanvars($_GET['id'])."'");

		for($intk=1; $intk<=sizeof($_POST['intamount']); $intk++){
//------------------------------------------------
			if(!empty($_POST['intamount'][$intk])) {
				
				// Insert  payments
				$dataInst = array(
										  'id_setup'		=> $_GET['id']
										, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['intdated'][$intk])))
										, 'amount'			=> cleanvars($_POST['intamount'][$intk])
										, 'remarks'			=> cleanvars($_POST['intremarks'][$intk])						
								);

				$sqllmsInsts  = $dblms->Insert(PAYMENTS_SCHEDULE_DETAILS , $dataInst);
			
			}
		}

		$remarks = 'Update Customer Payment Schedule: '.$_GET['id'];
		$dataLog = array(
									  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
									, 'action'		=> '1'	
									, 'dated'		=> date("Y-m-d H:i:s")
									, 'ip'			=> cleanvars($ip)
									, 'remarks'		=> cleanvars($remarks)
								);
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: customerspaymentschedule.php", true, 301);
		exit();
	
	}
}