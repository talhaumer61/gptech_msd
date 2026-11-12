<?php 
$bad_symbols = array(",", ".");
//--------------------------------------
if(isset($_POST['submit_othercountry'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT receipt_no, amount   
										FROM ".PAYMENTS." 
										WHERE receipt_no = '".cleanvars(trim($_POST['receipt_no']))."'
										AND docs_types = '1' AND debit_credit = '1' AND ledgerfor = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Slip #: <b>'.cleanvars($_POST['receipt_no']).'</b> already exist.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		
		if($_POST['method'] == 1) {
			$idaccount = $_POST['id_account'];
		} else {
			$idaccount = 0;
		}
		
		$systemslip 	= $mainclass->get_systemslipno(1,1);
		
		$amount = str_replace($bad_symbols, "", $_POST['amount']);
		
//------------------------------------------------
		// Insert  payments
		$dataInvamount = array(
									  'status'			=> '1'
									, 'systemslip_no'	=> $systemslip
									, 'ledgerfor'		=> '1'
									, 'docs_types'		=> '1'
									, 'id_user'			=> cleanvars($_POST['id_paid'])
									, 'reference_no'	=> cleanvars($_POST['reference_no'])
									, 'dated'			=> $dated
									, 'receipt_no'		=> cleanvars($_POST['receipt_no'])
									, 'amount'			=> cleanvars($amount)
									, 'debit_credit'	=> '1'
									, 'pay_mode'		=> cleanvars($_POST['method'])
									, 'id_account'		=> cleanvars($idaccount)
									, 'id_cat'			=> cleanvars($_POST['id_cat'])
									, 'remarks'			=> cleanvars($_POST['remarks'])
									, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'date_added'		=> date("Y-m-d H:i:s")								
							);
							
		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS, $dataInvamount);

//--------------------------------------
	if($sqllmsInsertamount) { 
		
		$idLatest = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['assign_file']['name'])) { 
		$directoryName 	= 'uploads/customerreceipts/'.date("Y");
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777);
	$content = "Options -Indexes";
	$fp = fopen($directoryName."/.htaccess","wb");
	fwrite($fp,$content);
	fclose($fp);
}
	
	$img_dir		= $directoryName."/";
	$filesize		= $_FILES['assign_file']['size'];
	$path_parts 	= pathinfo($_FILES["assign_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
	$img_fileName	= date("Y")."/".date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$dataupload = array (
							  'attachment'	=> $img_fileName
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($idLatest)."'");
		
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
	
}
//--------------------------------------
		$remarks = 'Add Customer Payment Amount: '.cleanvars($_POST['amount']);
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
	}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['submit_multipleadd'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT receipt_no, amount   
										FROM ".PAYMENTS." 
										WHERE receipt_no = '".cleanvars(trim($_POST['receipt_no']))."'
										AND docs_types = '1' AND debit_credit = '1' AND ledgerfor = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Slip #: <b>'.cleanvars($_POST['receipt_no']).'</b> already exist.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		if($_POST['method'] == 1) {
			$idaccount = $_POST['id_account'];
		} else {
			$idaccount = 0;
		}
		
		
		$systemslip 	= $mainclass->get_systemslipno(1,1);
		
		
		
		for($ichk=0; $ichk<sizeof($_POST['amount']); $ichk++){
//------------------------------------------------
			if(!empty($_POST['amount'][$ichk])) {
				
				$amount = str_replace($bad_symbols, "", $_POST['amount'][$ichk]);
				// Insert  payments
				$dataInvamount = array(
											  'status'			=> '1'
											, 'systemslip_no'	=> $systemslip
											, 'ledgerfor'		=> '1'
											, 'docs_types'		=> '1'
											, 'id_user'			=> cleanvars($_POST['id_paid'])
											, 'id_invoice'		=> cleanvars($_POST['id_invoice'][$ichk])
											, 'reference_no'	=> cleanvars($_POST['id_invoice'][$ichk])
											, 'dated'			=> $dated
											, 'receipt_no'		=> cleanvars($_POST['receipt_no'])
											, 'amount'			=> cleanvars($amount)
											, 'debit_credit'	=> '1'
											, 'pay_mode'		=> cleanvars($_POST['method'])
											, 'id_account'		=> cleanvars($idaccount)
											, 'id_cat'			=> cleanvars($_POST['id_cat'][$ichk])
											, 'remarks'			=> cleanvars($_POST['remarks'][$ichk])
											, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
											, 'date_added'		=> date("Y-m-d H:i:s")								
									);

				$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
						
				
				$idLatest = $dblms->lastestid();	
				

	//--------------------------------------
			$remarks = 'Add Customer Payment Amount: '.cleanvars($_POST['amount'][$ichk]);
			$dataLog = array(
								  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '1'	
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
							);
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
			
			}
		}
	//--------------------------------------
		if($sqllmsInsertamount) { 
			
			
//Insert Query Fields & Values
		$dataInv = array(
								  'id_user'			=> cleanvars($_POST['id_paid'])
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
			$idLatestp = $dblms->lastestid();
			
		for($intk=1; $intk<=sizeof($_POST['intamount']); $intk++){
//------------------------------------------------
			if(!empty($_POST['intamount'][$intk])) {
				
				
				$intamount = str_replace($bad_symbols, "", $_POST['intamount'][$intk]);
				// Insert  payments
				$dataInst = array(
										  'id_setup'		=> $idLatestp
										, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['intdated'][$intk])))
										, 'amount'			=> cleanvars($intamount)
										, 'remarks'			=> cleanvars($_POST['intremarks'][$intk])						
								);

				$sqllmsInsts  = $dblms->Insert(PAYMENTS_SCHEDULE_DETAILS , $dataInst);
			
			}
		}
		}

//--------------------------------------
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
//--------------------------------------
		}
	}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT receipt_no, amount   
										FROM ".PAYMENTS." 
										WHERE receipt_no = '".cleanvars(trim($_POST['receipt_no']))."'
										AND docs_types = '1' AND debit_credit = '1' AND ledgerfor = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Slip #: <b>'.cleanvars($_POST['receipt_no']).'</b> already exist.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		if($_POST['method'] == 1) {
			$idaccount = $_POST['id_account'];
		} else {
			$idaccount = 0;
		}
		
		$amount = str_replace($bad_symbols, "", $_POST['amount']);
//------------------------------------------------
		// Insert  payments
		$dataInvamount = array(
									  'status'			=> '1'
									, 'ledgerfor'		=> '1'
									, 'docs_types'		=> '1'
									, 'id_user'			=> cleanvars($_POST['id_paid'])
									, 'reference_no'	=> cleanvars($_POST['reference_no'])
									, 'dated'			=> $dated
									, 'receipt_no'		=> cleanvars($_POST['receipt_no'])
									, 'amount'			=> cleanvars($amount)
									, 'debit_credit'	=> '1'
									, 'pay_mode'		=> cleanvars($_POST['method'])
									, 'id_account'		=> cleanvars($idaccount)
									, 'remarks'			=> cleanvars($_POST['remarks'])
									, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'date_added'		=> date("Y-m-d H:i:s")								
							);
							
		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

//--------------------------------------
	if($sqllmsInsertamount) { 
		
		$idLatest = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['assign_file']['name'])) { 
		$directoryName 	= 'uploads/customerreceipts/'.date("Y");
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777);
	$content = "Options -Indexes";
	$fp = fopen($directoryName."/.htaccess","wb");
	fwrite($fp,$content);
	fclose($fp);
}
	
	$img_dir		= $directoryName."/";
	$filesize		= $_FILES['assign_file']['size'];
	$path_parts 	= pathinfo($_FILES["assign_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
	$img_fileName	= date("Y")."/".date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$dataupload = array (
							  	'attachment'	=> $img_fileName
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($idLatest)."'");
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
	
}
		
		
//--------------------------------------
		$remarks = 'Add Customer Payment Amount: '.cleanvars($_POST['amount']);
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
	}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
	
	$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
	if($_POST['method'] == 1) {
		$idaccount = $_POST['id_account'];
	} else {
		$idaccount = 0;
	}
	
	$amount = str_replace($bad_symbols, "", $_POST['amount']);
//------------------------------------------------
	$dataOrder = array(
							  'status'			=> 1
							, 'id_invoice'		=> cleanvars($_POST['id_invoice'])
							, 'reference_no'	=> cleanvars($_POST['reference_no'])
							, 'dated'			=> cleanvars($dated)
							, 'receipt_no'		=>cleanvars($_POST['receipt_no'])
							, 'amount'			=> cleanvars($amount)
							, 'pay_mode'		=> cleanvars($_POST['method'])
							, 'id_account'		=> cleanvars($idaccount)
							, 'remarks'			=> cleanvars($_POST['remarks'])
							, 'id_cat'			=> cleanvars($_POST['id_cat'])
							, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_modify'		=> date('Y-m-d h:i:s')
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(PAYMENTS , $dataOrder , " WHERE id = '".cleanvars($_POST['id_edit'])."'");

//--------------------------------------
	if($sqllmsUpdate) { 
//--------------------------------------
if(!empty($_FILES['assign_file_edit']['name'])) { 
		$directoryName 	= 'uploads/customerreceipts/'.date("Y");
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777);
	$content = "Options -Indexes";
	$fp = fopen($directoryName."/.htaccess","wb");
	fwrite($fp,$content);
	fclose($fp);
}
	
	$img_dir		= $directoryName."/";
	$filesize		= $_FILES['assign_file_edit']['size'];
	$path_parts 	= pathinfo($_FILES["assign_file_edit"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.date("Y-m-d").'_'.$_POST['id_edit'].".".strtolower($extension);
	$img_fileName	= date("Y")."/".date("Y-m-d").'_'.$_POST['id_edit'].".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$dataupload = array (
							  'attachment'	=> $img_fileName
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($_POST['id_edit'])."'");

		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file_edit']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
	
}
//--------------------------------------
		$remarks = 'Update Payment Amount: "'.cleanvars($_POST['amount']);
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

//--------------------------------------
if(isset($_POST['change_creditnotecountry'])) { 
	
	$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated_crnote'])));
	$amount = str_replace($bad_symbols, "", $_POST['amount_crnote']);
//------------------------------------------------
	$dataOrder = array(
							  'status'			=> 1
							, 'reference_no'	=> cleanvars($_POST['reference_no_crnote'])
							, 'dated'			=> cleanvars($dated)
							, 'receipt_no'		=>cleanvars($_POST['receipt_no_crnote'])
							, 'amount'			=> cleanvars($amount)
							, 'pay_mode'		=> cleanvars($_POST['method_modal_crnote'])
							, 'id_cat'			=> cleanvars($_POST['id_cat_noteedit'])
							, 'remarks'			=> cleanvars($_POST['remarks_crnote'])
							, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_modify'		=> date('Y-m-d h:i:s')
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(PAYMENTS , $dataOrder , " WHERE id = '".cleanvars($_POST['id_edit'])."'");

//--------------------------------------
	if($sqllmsUpdate) { 
//--------------------------------------
if(!empty($_FILES['assign_file']['name'])) { 
		$directoryName 	= 'uploads/customerreceipts/'.date("Y");
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777);
	$content = "Options -Indexes";
	$fp = fopen($directoryName."/.htaccess","wb");
	fwrite($fp,$content);
	fclose($fp);
}
	
	$img_dir		= $directoryName."/";
	$filesize		= $_FILES['assign_file']['size'];
	$path_parts 	= pathinfo($_FILES["assign_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.date("Y-m-d").'_'.$_POST['id_edit'].".".strtolower($extension);
	$img_fileName	= date("Y")."/".date("Y-m-d").'_'.$_POST['id_edit'].".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$dataupload = array (
							  'attachment'	=> $img_fileName
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($_POST['id_edit'])."'");

		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
	
}
//--------------------------------------
		$remarks = 'Update Payment Amount: "'.cleanvars($_POST['amount_crnote']);
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


//--------------------------------------
if(isset($_POST['submit_creditnotecountry'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT receipt_no, amount   
										FROM ".PAYMENTS." 
										WHERE receipt_no = '".cleanvars(trim($_POST['receipt_no']))."'
										AND docs_types = '12' AND debit_credit = '1' AND ledgerfor = '1' LIMIT 1");
	if(mysqli_num_rows($sqllmscheck)) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box error">
										<span>error: </span>Slip #: <b>'.cleanvars($_POST['receipt_no']).'</b> already exist.
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	} else { 
		
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		if($_POST['method'] == 1) {
			$idaccount = $_POST['id_account'];
		} else {
			$idaccount = 0;
		}
		
		$systemslip 	= $mainclass->get_systemslipno(1,1);
		$amount 		= str_replace($bad_symbols, "", $_POST['amount']);
//------------------------------------------------
		// Insert  payments
		$dataInvamount = array(
									  'status'			=> '1'
									, 'systemslip_no'	=> $systemslip 
									, 'ledgerfor'		=> '1'
									, 'docs_types'		=> '12'
									, 'id_user'			=> cleanvars($_POST['id_paid'])
									, 'reference_no'	=> cleanvars($_POST['reference_no'])
									, 'dated'			=> $dated
									, 'receipt_no'		=> cleanvars($_POST['receipt_no'])
									, 'amount'			=> cleanvars($amount)
									, 'debit_credit'	=> '1'
									, 'pay_mode'		=> cleanvars($_POST['method'])
									, 'id_account'		=> cleanvars($idaccount)
									, 'id_cat'			=> cleanvars($_POST['id_cat'])
									, 'remarks'			=> cleanvars($_POST['remarks'])
									, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'date_added'		=> date("Y-m-d H:i:s")								
							);
							
		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

//--------------------------------------
	if($sqllmsInsertamount) { 
		
		$idLatest = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['assign_file']['name'])) { 
		$directoryName 	= 'uploads/customerreceipts/'.date("Y");
if(!is_dir($directoryName)){
    //Directory does not exist, so lets create it.
    mkdir($directoryName, 0777);
	$content = "Options -Indexes";
	$fp = fopen($directoryName."/.htaccess","wb");
	fwrite($fp,$content);
	fclose($fp);
}
	
	$img_dir		= $directoryName."/";
	$filesize		= $_FILES['assign_file']['size'];
	$path_parts 	= pathinfo($_FILES["assign_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
	$img_fileName	= date("Y")."/".date("Y-m-d").'_'.$idLatest.".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$dataupload = array (
							  'attachment'	=> $img_fileName
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($idLatest)."'");

		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
	
}
		
//--------------------------------------
		
			$remarks = 'Add Customer Credit Note Amount: '.cleanvars($_POST['amount']);
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
	}
//--------------------------------------
}