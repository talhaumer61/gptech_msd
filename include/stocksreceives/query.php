<?php 

//Add Stock in against Purchase Order
if(isset($_POST['submit_stockin'])) { 
	
	$grnid = 'GRN-'.mt_rand(100000,999999);
		
	for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

		//Check if ID item is not empty
		if(!empty($_POST['qty'][$ichk])>0) {
					
			$dataStck = array(
								  'id_item'				=> cleanvars($_POST['id_item'][$ichk])
								, 'grn_id'				=> cleanvars($grnid)
								, 'grn'					=> cleanvars($_POST['grn'])
								, 'grn_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['grn_date'])))
								, 'qty'					=> cleanvars($_POST['qty'][$ichk])
								, 'unitprice'			=> cleanvars($_POST['unitprice'][$ichk])
								, 'stock_type'			=> 1
								, 'reference_no'		=> cleanvars($_POST['id_order'])
								, 'reference_type'		=> 1
								, 'dated'				=> date('Y-m-d')
								, 'remarks'				=> 'Stock Received'
								, 'id_user'				=> cleanvars($_POST['id_vendor'])
								, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'			=> date("Y-m-d H:i:s")
							);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);

	
		}

	}
	
// Insert Good Received amount in payments
		$dataInvamount = array(
								  'status'			=> '1'
								, 'ledgerfor'		=> '2'
								, 'docs_types'		=> '9'
								, 'id_user'			=> cleanvars($_POST['id_vendor'])
								, 'reference_no'	=> cleanvars($grnid)
								, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['grn_date'])))
								, 'amount'			=> cleanvars($_POST['inV_grandtotal'])
								, 'debit_credit'	=> '1'
								, 'remarks'			=> 'Stock Received Amount Purchase Order ID : '.cleanvars($_POST['id_order'])
								, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'		=> date("Y-m-d H:i:s")
							);

		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

	$remarks = 'Add Stock in for Purchase Order ID : '.cleanvars($_POST['po_order_no']);
	
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
	header("Location: stocksreceives.php?printid=".$grnid."", true, 301);
	exit();

}


// Update Stock Receive Note
if(isset($_POST['stock_update'])) { 
		
	for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

		//Check if ID item is not empty
	
					
			$dataStck = array(
								  'grn_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['grn_date'])))
								, 'qty'				=> cleanvars($_POST['qty'][$ichk])
								, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_modify'		=> date("Y-m-d H:i:s")
							);

			$qryUpdate = $dblms->Update(STOCK, $dataStck, " WHERE 
																	id = '".cleanvars($_POST['id_edit'][$ichk])."' 
																AND grn_id = '".cleanvars($_POST['grn_no'])."'");

	}
	
	// Update Invoice amount in payments
	$dataInvamount = array(
							  'amount'			=> cleanvars($_POST['inV_grandtotal'])
							, 'debit_credit'	=> '1'
							, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_modify'		=> date("Y-m-d H:i:s")								
						);
	
	$qryUpdatePayment = $dblms->Update(PAYMENTS, $dataInvamount, " WHERE 
																			reference_no = '".$_POST['grn_no']."' 
																		AND id_user 	 = '".$_POST['id_vendor']."' 
																		AND docs_types 	 = '9' 
																		AND debit_credit = '1'");
	
	$remarks = 'Edit Stock in for Purchase Order ID : '.cleanvars($_POST['po_order_no']);
	
	$dataLog = array(
						  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
						, 'action'		=> '2'
						, 'dated'		=> date("Y-m-d H:i:s")
						, 'ip'			=> cleanvars($ip)
						, 'remarks'		=> cleanvars($remarks)
					);
	$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
	header("Location: stocksreceives.php?printid=".$_POST['grn_no']."", true, 301);
	exit();

}