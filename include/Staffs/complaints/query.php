<?php 


//Send Message
if(isset($_POST['send_message'])) {

    if($_POST['message'] == '' && $_FILES['attachment']['name'] == ''){

		//Set Error MSG in Session
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error!</span> Please Write something to be sent.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

    } else {

		$data = array(
			'id_complaint' =>        cleanvars($_GET['id'])       						,
			'message'      =>        cleanvars($_POST['message'])               		,
			'id_added'     =>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 	,
			'date_added'   =>        date('Y-m-d H:i:s')          						,	
		);
		$sqllmsInsert = $dblms->Insert(COMPLAINTS_MESSAGE , $data);

		//Latest PK of Table
		$latestID = $dblms->lastestid();

		//Check File is not empty
		if(!empty($_FILES['attachment']['name'])) {

			//File Extension
			$path_parts = pathinfo($_FILES["attachment"]["name"]);
			$extension 	= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('png','jpg','jpeg','gif','ppt','pptx','html','docx','pptx','pdf','ppt','xls','xlsx'))) {

				if (($_FILES["attachment"]["size"] <= 204800)) {

					$directoryName 	= 'downloads/complaints/'.date('Y-m');

					//Create Directory if not exist
					if(!is_dir($directoryName)){
						
						mkdir($directoryName, 0777);
					}

					//Set File Name
					$img_dir		= $directoryName."/";
					$originalImage	= $directoryName."/".cleanvars($_GET['id']).'_'.$latestID.".".($extension);
					$img_fileName	= date('Y-m').'/'.cleanvars($_GET['id']).'_'.$latestID.".".($extension);

					//Update File Name in DB
					$sqllmsUpdate   = $dblms->querylms("UPDATE ".COMPLAINTS_MESSAGE."
															SET attachment 		= '".$img_fileName."'
															WHERE  id		= '".$latestID."'");
					unset($sqllmsUpdate);
					$mode = '0644';
				
					move_uploaded_file($_FILES['attachment']['tmp_name'] , $originalImage);
					chmod ($originalImage, octdec($mode));

				}
			}
		}

		//Set Success MSG in Session
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success!</span> Message has been sent.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }
}

//Update Status
if(isset($_POST['change_status'])) {

	if(cleanvars($_POST['status']) == 3){ 
		$completionDate = date('Y-m-d');
		$completionRemarks = '<span align="center" class="alert-box success"><span>Congratulations! </span>You have completed your task.</span>';
	} else{ 
		$completionDate = '0000-00-00';
		$completionRemarks = '<div class="alert-box success"><span>Success: </span>Status has been updated successfully.</div>';
	}

	$sqllmsUpdate  = $dblms->querylms("UPDATE ".COMPLAINTS." SET complaint_status 	= '".cleanvars($_POST['status'])."'
														, completion_date	= '".cleanvars($completionDate)."'
														, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
														, date_modify		= NOW()
													WHERE complaint_id			= '".cleanvars($_GET['id'])."'");
	if($sqllmsUpdate) {

		$_SESSION['msg']['status'] = $completionRemarks;
		header("Location: complaints.php", true, 301);
		exit();
	}

}
