<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
	$sqllmslastorder 	= $dblms->querylms("SELECT id FROM ".JOURANALVOUCHERS."  WHERE jv_type = '2' ORDER BY id DESC");
	$reultorder		 	= mysqli_fetch_array($sqllmslastorder);
	$countorder 		= $reultorder['id'];
		
	if($countorder<9) {
		$orderno = 'JV-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'JV-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'JV-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'JV-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'JV-0'.($countorder+1);
	}else {
		$orderno = 'JV-'.($countorder+1);
	}
	

	$dataInv = array(
						  'status'			=> '2'
						, 'jv_type'			=> 2
						, 'jv_no'			=> cleanvars($orderno)
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'jv_details'		=> cleanvars($_POST['jv_details'])						
						, 'totalcredits'	=> cleanvars($_POST['inV_grandcreditTotal'])
						, 'totaldebits'		=> cleanvars($_POST['inV_granddebitTotal'])
						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'		=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(JOURANALVOUCHERS , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$POgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_customer']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_customer'][$ichk])) {
		
				if(!empty($_POST['amout_credit'][$ichk])) {
					$creditdebit = 1;
					$amount = $_POST['amout_credit'][$ichk];
				} else if(!empty($_POST['amout_debit'][$ichk])) {
					$creditdebit = 2;
					$amount = $_POST['amout_debit'][$ichk];
				}
///----------------------------------------------
			$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".JOURANALVOUCHERS_DETAIL."   
											WHERE  id_jv 		= '".cleanvars($latest_id)."' 
											AND id_customer 	= '".cleanvars($_POST['id_customer'][$ichk])."' 
											AND credit_debit 	= '".cleanvars($creditdebit)."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$dataInvDetail = array(
											  'id_jv'			=> cleanvars($latest_id)
											, 'id_customer'		=> cleanvars($_POST['id_customer'][$ichk])
											, 'credit_debit'	=> $creditdebit
											, 'amount'			=> $amount
											, 'detail'			=> cleanvars($_POST['detail'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(JOURANALVOUCHERS_DETAIL,$dataInvDetail);

					
				}
			}

		}
		

		$remarks = 'Add JV # : '.cleanvars($orderno).' details';
		
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
		header("Location: vendorsjv.php", true, 301);
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
						  'status'			=> $proStatus
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'jv_details'		=> cleanvars($_POST['jv_details'])						
						, 'totalcredits'	=> cleanvars($_POST['inV_grandcreditTotal'])
						, 'totaldebits'		=> cleanvars($_POST['inV_granddebitTotal'])
						, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'		=> date("Y-m-d H:i:s")											
					);
	
	$qryUpdate = $dblms->Update(JOURANALVOUCHERS, $dataInv, "WHERE id = '".$_POST['idedit']."'");
	

	if($qryUpdate) { 
		
		//$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		$sqllmsdel  = $dblms->querylms("DELETE FROM ".JOURANALVOUCHERS_DETAIL."  WHERE id_jv = '".cleanvars($_POST['idedit'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_customer']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_customer'][$ichk])) {
		
				if(!empty($_POST['amout_credit'][$ichk])) {
					$creditdebit = 1;
					$amount = $_POST['amout_credit'][$ichk];
				} else if(!empty($_POST['amout_debit'][$ichk])) {
					$creditdebit = 2;
					$amount = $_POST['amout_debit'][$ichk];
				}
///----------------------------------------------
			$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".JOURANALVOUCHERS_DETAIL."   
                                                                        WHERE  id_jv 		= '".cleanvars($_POST['idedit'])."' 
                                                                        AND id_customer 	= '".cleanvars($_POST['id_customer'][$ichk])."' 
                                                                        AND credit_debit 	= '".cleanvars($creditdebit)."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$dataInvDetail = array(
											  'id_jv'			=> cleanvars($_POST['idedit'])
											, 'id_customer'		=> cleanvars($_POST['id_customer'][$ichk])
											, 'credit_debit'	=> $creditdebit
											, 'amount'			=> $amount
											, 'detail'			=> cleanvars($_POST['detail'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(JOURANALVOUCHERS_DETAIL,$dataInvDetail);
					if($proStatus == 3) {
						// Insert amount in payments
						$dataInvamount = array(
												  'status'			=> '1'
												, 'ledgerfor'		=> '2'
												, 'docs_types'		=> '13'
												, 'id_user'			=> cleanvars($_POST['id_customer'][$ichk])
												, 'reference_no'	=> cleanvars($_POST['idedit'])
												, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
												, 'amount'			=> $amount
												, 'debit_credit'	=> $creditdebit
												, 'pay_mode'		=> '5'
												, 'remarks'			=> cleanvars($_POST['detail'][$ichk])
												, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
												, 'date_added'		=> date("Y-m-d H:i:s")
											);

							$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
					}

					
				}
			}

		}
		

		$remarks = 'Update JV ID : '.cleanvars($_POST['idedit']).' details';
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
		header("Location: vendorsjv.php", true, 301);
		exit();

	}
}
