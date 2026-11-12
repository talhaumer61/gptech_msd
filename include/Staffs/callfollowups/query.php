<?php 
//Add Record
if(isset($_POST['add_calllog'])) {
		$data = array(
						  'id_customer'        		=>        cleanvars($_POST['id_customer'])              											
						, 'contact_person'      	=>        cleanvars($_POST['contact_person'])       				
						, 'phone'         			=>        cleanvars($_POST['phone'])               					
						, 'call_status'   			=>        cleanvars($_POST['call_status'])         					     								
						, 'purpose'           		=>        cleanvars($_POST['purpose'])  
						, 'next_followup'           =>        cleanvars($_POST['next_followup'])		 
						, 'remarks'           		=>        cleanvars($_POST['remarks'])		 
						, 'id_added'              	=>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 	
						, 'date_added'            	=>        date('Y-m-d H:i:s')          								
					);

		$sqllmsInsert = $dblms->Insert(CALL_FOLLOWUPS , $data);

		if($sqllmsInsert) {

			//Set Success MSG in Session
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
			header("Location: callfollowups.php", true, 301);
			exit();
		}

}

//Update Record
if(isset($_POST['submit_changes'])) {


	$data = array(
					  'id_customer'        		=>        cleanvars($_POST['id_customer'])              											
					, 'contact_person'      	=>        cleanvars($_POST['contact_person'])       				
					, 'phone'         			=>        cleanvars($_POST['phone'])               					
					, 'call_status'   			=>        cleanvars($_POST['call_status'])         					     								
					, 'purpose'           		=>        cleanvars($_POST['purpose'])  
					, 'next_followup'           =>        cleanvars($_POST['next_followup'])		 
					, 'remarks'           		=>        cleanvars($_POST['remarks'])		 
					, 'id_modify'             	=>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 		
					, 'date_modify'           	=>        date('Y-m-d H:i:s')          									
				);

	$sqllmsUpdate = $dblms->Update(CALL_FOLLOWUPS, $data, "WHERE call_id = ".cleanvars($_POST['id_edit'])."");

	if($sqllmsUpdate) {

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: callfollowups.php", true, 301);
		exit();
	}
}


//Delete Record
if(isset($_GET['del']) && $_GET['del'] != '') {

	$sqllmsUpdate  = $dblms->querylms("UPDATE ".CALL_FOLLOWUPS." SET is_deleted = '1' 
														, date_deleted	= NOW()
														, id_deleted	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
														, deleted_ip	= '".cleanvars($ip)."'
													WHERE call_id		= '".cleanvars($_GET['del'])."'");

	
	if($sqllmsUpdate) {

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been deleted successfully.</div>';
		header("Location: callfollowups.php", true, 301);
		exit();
	}
}