<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
	$sqllmslastorder 	= $dblms->querylms("SELECT purchase_order_id FROM ".PURCHASE_ORDER." ORDER BY purchase_order_id DESC");
	$reultorder		 	= mysqli_fetch_array($sqllmslastorder);
	$countorder 		= $reultorder['purchase_order_id'];
		
	if($countorder<9) {
		$orderno = 'PO-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'PO-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'PO-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'PO-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'PO-0'.($countorder+1);
	}else {
		$orderno = 'PO-'.($countorder+1);
	}
	
	$dataInv = array(
						  'po_status'		=> '4'
						, 'po_order_no'		=> cleanvars($orderno)
						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'id_vendor'		=> cleanvars($_POST['id_vendor'])
						, 'total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'grand_total'		=> cleanvars($_POST['inV_grandtotal'] + $_POST['vendor_openingbalance'])
						, 'opening_balance'	=> cleanvars($_POST['vendor_openingbalance'])
						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'		=> date("Y-m-d H:i:s")
					);
	$sqllmsInsert  = $dblms->Insert(PURCHASE_ORDER , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		

		
		$POgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {
				
///----------------------------------------------
				$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".PURCHASE_ORDER_DETAILS."   
												WHERE  id_po = '".cleanvars($latest_id)."' AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
				if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
												  'id_po'		=> cleanvars($latest_id)
												, 'id_company'	=> cleanvars($_POST['id_company'])
												, 'id_item'		=> cleanvars($_POST['id_item'][$ichk])
												, 'unit_price'	=> cleanvars($_POST['unit_price'][$ichk])
												, 'qty'			=> cleanvars($_POST['qty'][$ichk])
												, 'total_price'	=> cleanvars($_POST['total_price'][$ichk])
											);

					$sqllmsInsertDetail  = $dblms->Insert(PURCHASE_ORDER_DETAILS,$dataInvDetail);

					unset($sqllmsInsertDetail);
				}
			}

		}
		
		$dataupdateInv = array(
								  'total'		=> cleanvars($POgrandtotal)
								, 'grand_total'	=> cleanvars($POgrandtotal + $_POST['vendor_openingbalance'])
							);

		$qryUpdate2nd = $dblms->Update(PURCHASE_ORDER, $dataupdateInv, "WHERE purchase_order_id = '".$latest_id."'");
		

		$remarks = 'Add Purchase Order # : '.cleanvars($_POST['po_order_no']).' details';
		
		$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
							, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
							, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
						);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		header("Location: purchase-order.php?printid=".$latest_id."", true, 301);
		exit();

	}

}

//Update Purchase Order
if(isset($_POST['submit_changes'])) { 
	
		//Assign Job Order Status
	if($_POST['submit_changes'] == 'saveconfirmed'){

		$proStatus = '1';

	} else{

		$proStatus = '3';

	}

	$balance = ($_POST['inV_grandtotal']+$_POST['vendor_openingbalance']) - $_POST['advance']; 
	$dataInv = array(
					  'po_status'		=> $proStatus
					, 'total'			=> cleanvars($_POST['inV_grandtotal'])
					, 'advance'			=> cleanvars($_POST['advance'])
					, 'paid_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
					, 'paid_method'		=> cleanvars($_POST['payment_method'])
					, 'id_account'		=> cleanvars($_POST['id_account'])
					, 'deposit_slip'	=> cleanvars($_POST['deposit_slip'])
					, 'grand_total'		=> cleanvars($_POST['inV_grandtotal']+$_POST['vendor_openingbalance'])
					, 'balance'			=> cleanvars($balance)
					, 'remarks'			=> cleanvars($_POST['remarks'])
					, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
					, 'date_modify'		=> date("Y-m-d H:i:s")
				);

	$qryUpdate = $dblms->Update(PURCHASE_ORDER, $dataInv, "WHERE purchase_order_id = '".$_POST['purchase_order_id']."'");

	if($qryUpdate) { 
			
		
// Insert Invoice amount in payments
if($_POST['advance']>0)  {

// check if amount already added
	$sqllmscheck  = $dblms->querylms("SELECT * 
									FROM ".PAYMENTS."  
									WHERE status = '1' AND id_user = '".cleanvars($_POST['id_vendor'])."'
									AND ledgerfor = '2'  AND debit_credit = '2'  AND docs_types = '7'
									AND reference_no = ".cleanvars($_POST['purchase_order_id'])."");
		if(mysqli_num_rows($sqllmscheck)>0) { 
			$valuecheck = mysqli_fetch_array($sqllmscheck);
		// Insert Invoice amount in payments
			$dataInvamount = array(
									  'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
									, 'receipt_no'		=> cleanvars($_POST['deposit_slip'])
									, 'amount'			=> cleanvars($_POST['advance'])
									, 'pay_mode'		=> cleanvars($_POST['payment_method'])
									, 'remarks'			=> get_doctype(7)
									, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'date_modify'		=> date("Y-m-d H:i:s")
								);	

			$sqllmsUpdatepayment  = $dblms->Update(PAYMENTS , $dataInvamount , " WHERE id = '".cleanvars($valuecheck['id'])."'");

		} else { 
			
			$systemslip 	= $mainclass->get_systemslipno(2,2);
			
			$dataadvance = array(
									  'status'			=> '1'
									, 'systemslip_no'	=> $systemslip
									, 'ledgerfor'		=> '2'
									, 'docs_types'		=> '7'
									, 'id_user'			=> cleanvars($_POST['id_vendor'])
									, 'reference_no'	=> cleanvars($_POST['purchase_order_id'])
									, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
									, 'receipt_no'		=> cleanvars($_POST['deposit_slip'])
									, 'amount'			=> cleanvars($_POST['advance'])
									, 'pay_mode'		=> cleanvars($_POST['payment_method'])
									, 'debit_credit'	=> '2'
									, 'remarks'			=> get_doctype(7)
									, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									, 'date_added'		=> date("Y-m-d H:i:s")
								);

				$sqllmsInsertadvance  = $dblms->Insert(PAYMENTS , $dataadvance);
		}
	
} // end advance payment

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".PURCHASE_ORDER_DETAILS."  WHERE id_po = '".cleanvars($_POST['purchase_order_id'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$dataInvDetail = array(
										  'id_po'		=> cleanvars($_POST['purchase_order_id'])
										, 'id_item'		=> cleanvars($_POST['id_item'][$ichk])
										, 'unit_price'	=> cleanvars($_POST['unit_price'][$ichk])
										, 'qty'			=> cleanvars($_POST['qty'][$ichk])
										, 'total_price'	=> cleanvars($_POST['total_price'][$ichk])
									);
				$sqllmsInsertDetail  = $dblms->Insert(PURCHASE_ORDER_DETAILS , $dataInvDetail);

				unset($sqllmsInsertDetail);
			}

		}

		$remarks = 'Update Purchase Order ID : '.cleanvars($_POST['purchase_order_id']).' details';
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
		
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."&printid=".$_POST['purchase_order_id']."", true, 301);
		exit();

	}
}

//Add Stock in against Purchase Order
if(isset($_POST['submit_stockin'])) { 
		
	for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

		//Check if ID item is not empty
		if(!empty($_POST['qty'][$ichk])>0) {
					
			$dataStck = array(
								  'id_item'			=> cleanvars($_POST['id_item'][$ichk])
								, 'grn'				=> cleanvars($_POST['grn'])
								, 'grn_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['grn_date'])))
								, 'qty'				=> cleanvars($_POST['qty'][$ichk])
								, 'stock_type'		=> 1
								, 'reference_no'	=> cleanvars($_POST['id_order'])
								, 'reference_type'	=> 1
								, 'dated'			=> date('Y-m-d')
								, 'remarks'			=> 'Stock Received'
								, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'		=> date("Y-m-d H:i:s")
							);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);
		}

	}

	$remarks = 'Add Stock in for Purchase Order ID : '.cleanvars($_POST['po_order_no']);
	$dataLog = array(
							  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
							, 'action'		=> '1'
							, 'dated'		=> date("Y-m-d H:i:s")
							, 'ip'			=> cleanvars($ip)
							, 'remarks'		=> cleanvars($remarks)
							, 'id_office'	=> cleanvars($_SESSION['LOGINOFFICE_SSS'])
							, 'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
						);
	$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
	header("Location: purchase-order.php?printid=".$_POST['id_order']."", true, 301);
	exit();

}