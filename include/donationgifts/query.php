<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
	$sqllmslastorder 	= $dblms->querylms("SELECT CONCAT('DG-', LPAD(IFNULL(SUBSTRING_INDEX(MAX(pr_no), '-', -1) + 1, 1), 6, '0')) AS next_prno FROM ".DONATIONGIFTS." WHERE pr_no LIKE 'DG-%'");
	$resultorder		 = mysqli_fetch_array($sqllmslastorder);
	$orderno = $resultorder['next_prno'];

	$dataInv = array(
						  'pr_status'		=> '2'
						, 'id_type'			=> cleanvars($_POST['id_type'])
						, 'id_crs'			=> cleanvars($_POST['id_crs'])
						, 'customer_name'	=> cleanvars($_POST['customer_name'])
						, 'customer_cell'	=> cleanvars($_POST['customer_cell'])
						, 'customer_email'	=> cleanvars($_POST['customer_email'])
						, 'customer_address'=> cleanvars($_POST['customer_address'])
						, 'pr_no'			=> cleanvars($orderno)
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'		=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(DONATIONGIFTS , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$POgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {
		
			$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".DONATIONGIFTS_DETAILS."   
											WHERE  id_pr = '".cleanvars($latest_id)."' AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

				$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
											  'id_pr'			=> cleanvars($latest_id)
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(DONATIONGIFTS_DETAILS,$dataInvDetail);

					
				}
			}

		}
		

		$remarks = 'Add Donation / Gift Order # : '.cleanvars($_POST['pr_no']).' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		header("Location: donationgifts.php?printid=".$latest_id."", true, 301);
		exit();

	}

}

//Update Purchase Order
if(isset($_POST['submit_changes'])) { 
	
		//Assign Job Order Status
	if($_POST['submit_changes'] == 'saveconfirmed'){

		$proStatus = '3';

	} else{

		$proStatus = '2';

	}
	
	$dataInv = array(
						  'pr_status'		=> $proStatus
						, 'id_type'			=> cleanvars($_POST['id_type'])
						, 'id_crs'			=> cleanvars($_POST['id_crs'])
						, 'customer_name'	=> cleanvars($_POST['customer_name'])
						, 'customer_cell'	=> cleanvars($_POST['customer_cell'])
						, 'customer_email'	=> cleanvars($_POST['customer_email'])
						, 'customer_address'=> cleanvars($_POST['customer_address'])
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'remarks'			=> cleanvars($_POST['remarks'])
						, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modified'	=> date("Y-m-d H:i:s")											
					);
	
	

	$qryUpdate = $dblms->Update(DONATIONGIFTS, $dataInv, "WHERE pr_id = '".$_POST['pr_id']."'");
	

	if($qryUpdate) { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".DONATIONGIFTS_DETAILS."  WHERE id_pr = '".cleanvars($_POST['pr_id'])."'");
		$sqllmsdelStock	= $dblms->querylms("DELETE FROM ".STOCK."  WHERE reference_no = '".cleanvars($_POST['pr_id'])."' 
																AND stock_type = '2' 
																AND reference_type = '".cleanvars($_POST['id_type'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) { 
				
			if($_POST['submit_changes'] == 'saveconfirmed'){
				
				
				$dataStck = array (
										  'id_item'			=> cleanvars($_POST['id_item'][$ichk])
										, 'grn_date'		=> $dated
										, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
										, 'unitprice'		=> cleanvars($_POST['unit_price'][$ichk])
										, 'stock_type'		=> 2
										, 'reference_no'	=> cleanvars($_POST['pr_id'])
										, 'reference_type'	=> cleanvars($_POST['id_type'])
										, 'dated'			=> $dated
										, 'remarks'			=> 'Stock Out' 
										, 'customer_vendorname'	=> cleanvars($_POST['customer_name'])
										, 'invoice_orderno'	=> cleanvars($_POST['pr_no'])
										, 'view_path'		=> 'donationgiftsprint.php?id='.$_POST['pr_id'].''
										, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
										, 'date_added'		=> date("Y-m-d H:i:s")
								);

				$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);
			}

				
					$dataInvDetail = array(
											  'id_pr'			=> cleanvars($_POST['pr_id'])
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(DONATIONGIFTS_DETAILS,$dataInvDetail);
			}

		}

		$remarks = 'Update Donation  / Gifts ID : '.cleanvars($_POST['pr_id']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);


		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: donationgifts.php?printid=".$_POST['pr_id']."", true, 301);
		exit();

	}
}

//Update Order Status to Dispatch
if(isset($_POST['sale_dispatch'])){

	//UPDATE Query Fields & Values
	$dataInvOrder = array(
							  'pr_status'			=> '5'
							, 'dispatch_status'		=> '1'
							, 'dispatchno'			=> cleanvars($_POST['dispatchno_edit'])
							, 'dispatchvia'			=> cleanvars($_POST['dispatchvia_edit'])
							, 'dispatchdate'		=> date('Y-m-d', strtotime(cleanvars($_POST['dispatchdate_edit'])))
							, 'biltyno'				=> cleanvars($_POST['biltyno_edit'])
							, 'dispatchto'			=> cleanvars($_POST['dispatchto_edit'])
							, 'dispatchcellno'		=> cleanvars($_POST['dispatchcellno_edit'])
							, 'dispatchaddress'		=> cleanvars($_POST['dispatchaddress_edit'])
							, 'id_dispatched'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_dispatched'		=> date("Y-m-d H:i:s")
						);
	
	//Execute Update Query
	$sqllmsUpdateINV  	= $dblms->Update(DONATIONGIFTS , $dataInvOrder , " WHERE pr_id  = '".cleanvars($_POST['id_pr'])."'");
	
	//If Update Query Executed
	if($sqllmsUpdateINV) { 

		if(!empty($_FILES['upload_file']['name'])) { 
			$filesize		= $_FILES['upload_file']['size'];
			$path_parts 	= pathinfo($_FILES["upload_file"]["name"]);
			$extension 		= $path_parts['extension'];
			
			if(in_array($extension , array('pdf','jpg', 'png'))) { 
				
				$directoryName 	= 'downloads/dispatchslips/'.date("Y");
				if(!is_dir($directoryName)){
					//Directory does not exist, so lets create it.
					mkdir($directoryName, 0777);
					$content = "Options -Indexes";
					$fp = fopen($directoryName."/.htaccess","wb");
					fwrite($fp,$content);
					fclose($fp);
				}	

				$img_dir		= $directoryName."/";
				//$img 			= explode('.', $_FILES['student_file']['name']);
				$originalImage	= $directoryName."/".($_POST['pr_no_edit'].'-'.$_POST['id_pr']).".".strtolower($extension);
				$img_fileName	= date("Y").'/'.($_POST['pr_no_edit'].'-'.$_POST['id_pr']).".".strtolower($extension);
				//$extension 		= strtolower($img[1]);
				
				$sqllmsupload  = $dblms->querylms("UPDATE ".DONATIONGIFTS."
																SET dispatch_slip = '".$img_fileName."'
															WHERE pr_id = '".cleanvars($_POST['id_pr'])."'");
				unset($sqllmsupload);
				$mode = '0644'; 
				
				move_uploaded_file($_FILES['upload_file']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));
				
			}
			
		}

		$remarks = 'Dispatched Order ID: '.cleanvars($_POST['id_pr']).' details';

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

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Order dispatched successfully.</div>';
		header("Location: donationgifts.php?printid=".$_POST['id_pr']."", true, 301);
		exit();
	}
}


//Add Estimate Details
if(isset($_POST['submit_estimates'])) { 
	
	$sqllmslastorder 	= $dblms->querylms("SELECT count(pr_id) AS totalRd FROM ".DONATIONGIFTS." WHERE estimate_no != '' ORDER BY pr_id DESC");
	$reultorder		 	= mysqli_fetch_array($sqllmslastorder);
	$countorder 		= $reultorder['totalRd'];
		
	if($countorder<9) {
		$orderno = 'EDG-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'EDG-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'EDG-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'EDG-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'EDG-0'.($countorder+1);
	}else {
		$orderno = 'EDG-'.($countorder+1);
	}
	

	$dataInv = array(
						  'pr_status'		=> '2'
						, 'id_type'			=> cleanvars($_POST['id_type'])
						, 'id_crs'			=> cleanvars($_POST['id_crs'])
						, 'customer_name'	=> cleanvars($_POST['customer_name'])
						, 'customer_cell'	=> cleanvars($_POST['customer_cell'])
						, 'customer_email'	=> cleanvars($_POST['customer_email'])
						, 'customer_address'=> cleanvars($_POST['customer_address'])
						, 'estimate_no'		=> cleanvars($orderno)
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'		=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(DONATIONGIFTS , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$POgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {
		
			
			$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".DONATIONGIFTS_DETAILS."   
											WHERE  id_pr = '".cleanvars($latest_id)."' AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

				$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
											  'id_pr'			=> cleanvars($latest_id)
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(DONATIONGIFTS_DETAILS,$dataInvDetail);

					
				}
			}

		}
		

		$remarks = 'Add Donation / Gift Order # : '.cleanvars($_POST['pr_no']).' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		header("Location: donationgifts.php?view=estimates&estprintid=".$latest_id."", true, 301);
		exit();

	}

}


//Update Estimate Order
if(isset($_POST['submit_estimatechanges'])) { 
	
		//Assign Job Order Status
	if($_POST['submit_estimatechanges'] == 'saveconfirmed'){
		
		$sqllmslastorder 	= $dblms->querylms("SELECT CONCAT('DG-', LPAD(IFNULL(SUBSTRING_INDEX(MAX(pr_no), '-', -1) + 1, 1), 6, '0')) AS next_prno FROM ".DONATIONGIFTS." WHERE pr_no LIKE 'DG-%'");
		$resultorder		 = mysqli_fetch_array($sqllmslastorder);
		$orderno = $resultorder['next_prno'];

		$proStatus = '2';

	} else{

		$proStatus 	= '2';
		$orderno	= '';

	}
		
	$dataInv = array(
						  'pr_status'		=> $proStatus
						, 'id_type'			=> cleanvars($_POST['id_type'])
						, 'id_crs'			=> cleanvars($_POST['id_crs'])
						, 'customer_name'	=> cleanvars($_POST['customer_name'])
						, 'customer_cell'	=> cleanvars($_POST['customer_cell'])
						, 'customer_email'	=> cleanvars($_POST['customer_email'])
						, 'customer_address'=> cleanvars($_POST['customer_address'])
						, 'pr_no'			=> $orderno
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'remarks'			=> cleanvars($_POST['remarks'])
						, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modified'	=> date("Y-m-d H:i:s")											
					);
	
	

	$qryUpdate = $dblms->Update(DONATIONGIFTS, $dataInv, "WHERE pr_id = '".$_POST['pr_id']."'");
	

	if($qryUpdate) { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".DONATIONGIFTS_DETAILS."  WHERE id_pr = '".cleanvars($_POST['pr_id'])."'");
	

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) { 
				
			
				
					$dataInvDetail = array(
											  'id_pr'			=> cleanvars($_POST['pr_id'])
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(DONATIONGIFTS_DETAILS,$dataInvDetail);
			}

		}

		$remarks = 'Update Donation  / Gifts ID : '.cleanvars($_POST['pr_id']).' details';
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '2'	
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);


		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: donationgifts.php?view=estimates&estprintid=".$_POST['pr_id']."", true, 301);
		exit();

	}
}