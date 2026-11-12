<?php 
//Add Record
if(isset($_POST['add_complaint'])) {

	$sqllmsCheck = $dblms->querylms("SELECT complaint_id   
											FROM ".COMPLAINTS."
											WHERE complaint_title   = '".cleanvars($_POST['title'])."'
											AND id_customer 		= '".cleanvars($_POST['id_customer'])."'");
	if(mysqli_num_rows($sqllmsCheck) > 0) {

		//Set Error MSG in Session
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error!</span> Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else {

		$data = array(
						  'complaint_status'        =>        1              											
						, 'complaint_priority'      =>        cleanvars($_POST['priority_level'])       				
						, 'complaint_title'         =>        cleanvars($_POST['title'])               					
						, 'complaint_description'   =>        cleanvars($_POST['description'])         					     								
						, 'id_dept'           		=>        cleanvars($_POST['id_dept'])  
						, 'id_customer'             =>        cleanvars($_POST['id_customer'])		 
						, 'id_added'              	=>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 	
						, 'date_added'            	=>        date('Y-m-d H:i:s')          								
					);

		$sqllmsInsert = $dblms->Insert(COMPLAINTS , $data);
			
		//Latest PK of Table
		$latestID = $dblms->lastestid();

		//Check File is not empty
		if(!empty($_FILES['attachment']['name'])) {
			
			//File Extension
			$path_parts = pathinfo($_FILES["attachment"]["name"]);
			$extension 	= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) {

				if (($_FILES["attachment"]["size"] <= 204800)) {

					$directoryName 	= 'downloads/complaints/'.date('Y-m');

					//Create Directory if not exist
					if(!is_dir($directoryName)){
						mkdir($directoryName, 0777);
					}

					//Set File Name
					$img_dir		= $directoryName."/";
					$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['title'])).'_'.$latestID.".".($extension);
					$img_fileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['title'])).'_'.$latestID.".".($extension);

					//Update File Name in DB
					$sqllmsUpdate   = $dblms->querylms("UPDATE ".COMPLAINTS."
																SET complaint_attachment = '".$img_fileName."'
																WHERE  complaint_id		= '".cleanvars($latestID)."'");
					unset($sqllmsUpdate);
					$mode = '0644';
				
					move_uploaded_file($_FILES['attachment']['tmp_name'] , $originalImage);
					chmod ($originalImage, octdec($mode));

				}

			}

		}

		if($sqllmsInsert) {

			//Set Success MSG in Session
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
			header("Location: complaints.php", true, 301);
			exit();
		}
	}

}

//Update Record
if(isset($_POST['submit_changes'])) {


	$data = array(
					  'complaint_priority'      =>        cleanvars($_POST['priority_level'])       				
					, 'complaint_title'         =>        cleanvars($_POST['title'])               					
					, 'complaint_description'   =>        cleanvars($_POST['description'])         					     								
					, 'id_dept'           		=>        cleanvars($_POST['id_dept'])  
					, 'id_modify'             	=>        cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 		
					, 'date_modify'           	=>        date('Y-m-d H:i:s')          									
				);

	$sqllmsUpdate = $dblms->Update(COMPLAINTS, $data, "WHERE complaint_id = ".cleanvars($_POST['id_edit'])."");

	//Check File is not empty
	if(!empty($_FILES['attachment']['name'])) {
			
		//File Extension
		$path_parts = pathinfo($_FILES["attachment"]["name"]);
		$extension 	= strtolower($path_parts['extension']);

		//Check File extension
		if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) {

			if (($_FILES["attachment"]["size"] <= 204800)) {

				$directoryName 	= 'downloads/complaints/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['title'])).'_'.cleanvars($_POST['id_edit']).".".($extension);
				$img_fileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['title'])).'_'.cleanvars($_POST['id_edit']).".".($extension);

				//Update File Name in DB
				$sqllmsUpdate   = $dblms->querylms("UPDATE ".COMPLAINTS."
														SET complaint_attachment = '".$img_fileName."'
														WHERE  complaint_id		= '".cleanvars($_POST['id_edit'])."'");
				unset($sqllmsUpdate);
				$mode = '0644';
			
				move_uploaded_file($_FILES['attachment']['tmp_name'] , $originalImage);
				chmod ($originalImage, octdec($mode));

			}
		}

	}

	if($sqllmsUpdate) {

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: complaints.php", true, 301);
		exit();
	}
}

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
		//$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success!</span> Message has been sent.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }
}

//Delete Record
if(isset($_GET['del']) && $_GET['del'] != '') {

	$sqllmsUpdate  = $dblms->querylms("UPDATE ".COMPLAINTS." SET is_deleted = '1' 
														, date_deleted	= NOW()
														, id_deleted	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
														, deleted_ip	= '".cleanvars($ip)."'
													WHERE complaint_id		= '".cleanvars($_GET['del'])."'");

	
	if($sqllmsUpdate) {

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been deleted successfully.</div>';
		header("Location: complaints.php", true, 301);
		exit();
	}
}