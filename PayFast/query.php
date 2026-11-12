<?php 
$basketchars = substr($_POST['basket_id'],0,3);

if($basketchars == 'CUS') {
	// transation details	
	$dataTrans = array (
							  'status'				=> 1
							, 'reference_type'		=> 2
							, 'order_no'			=> cleanvars($_POST['basket_id'])
							, 'reference_no'		=> cleanvars($_POST['basket_id'])
							, 'status_code'			=> cleanvars($_POST['err_code'])
							, 'transaction_id'		=> cleanvars($_POST['transaction_id'])
							, 'basket_id'			=> cleanvars($_POST['basket_id'])
							, 'order_date'			=> cleanvars($_POST['order_date'])
							, 'rdv_message_key'		=> cleanvars($_POST['Rdv_Message_Key'])
							, 'response_key'		=> cleanvars($_POST['Response_Key'])
							, 'validation_hash'		=> cleanvars($_POST['validation_hash'])
							, 'transaction_amount'	=> cleanvars($_POST['transaction_amount'])
							, 'merchant_amount'		=> cleanvars($_POST['merchant_amount'])
							, 'discounted_amount'	=> cleanvars($_POST['discounted_amount'])
							, 'issuer_name'			=> cleanvars($_POST['issuer_name'])
							, 'transaction_currency'=> cleanvars($_POST['transaction_currency'])
							, 'paymenttype'			=> cleanvars($_POST['PaymentType'])
							, 'paymentname'			=> cleanvars($_POST['PaymentName'])
							, 'date_added'			=> date("Y-m-d H:i:s")
							, 'device_details'		=> $devicedetails
							, 'ip_address'			=> LMS_IP
					);
	$sqllmsTransInsert  = $dblms->Insert(PAYFAST_TRANSACTIONS , $dataTrans);
	if($sqllmsTransInsert) {
		
		// Insert Invoice amount in payments
		$dataInvPayment = array(
										  'status'			=> '1'
										, 'ledgerfor'		=> '1'
										, 'docs_types'		=> '1'
										, 'id_user'			=> cleanvars($_POST['customerid'])	
										, 'dated'			=> cleanvars($_POST['order_date'])
										, 'transaction_id'	=> cleanvars($_POST['transaction_id'])
										, 'amount'			=> cleanvars($_POST['merchant_amount'])
										, 'debit_credit'	=> '1'
										, 'pay_mode'		=> 4
										, 'remarks'			=> get_doctype(1)
										, 'date_added'		=> date("Y-m-d H:i:s")								
								);

		$sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Payment completed successfully.</div>';
		header("Location: ".SITE_URL."/customerledger.php", true, 301);
		exit();
	} else {
		$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Payment could not completed.</div>';
		header("Location: ".SITE_URL."/customerledger.php", true, 301);
		exit();
	}
	
} elseif($basketchars == 'EST') {

// transation details	
	$dataTrans = array (
							  'status'				=> 1
							, 'reference_type'		=> 1
							, 'order_no'			=> cleanvars($_POST['id'])
							, 'reference_no'		=> cleanvars($_POST['basket_id'])
							, 'status_code'			=> cleanvars($_POST['err_code'])
							, 'transaction_id'		=> cleanvars($_POST['transaction_id'])
							, 'basket_id'			=> cleanvars($_POST['basket_id'])
							, 'order_date'			=> cleanvars($_POST['order_date'])
							, 'rdv_message_key'		=> cleanvars($_POST['Rdv_Message_Key'])
							, 'response_key'		=> cleanvars($_POST['Response_Key'])
							, 'validation_hash'		=> cleanvars($_POST['validation_hash'])
							, 'transaction_amount'	=> cleanvars($_POST['transaction_amount'])
							, 'merchant_amount'		=> cleanvars($_POST['merchant_amount'])
							, 'discounted_amount'	=> cleanvars($_POST['discounted_amount'])
							, 'issuer_name'			=> cleanvars($_POST['issuer_name'])
							, 'transaction_currency'=> cleanvars($_POST['transaction_currency'])
							, 'paymenttype'			=> cleanvars($_POST['PaymentType'])
							, 'paymentname'			=> cleanvars($_POST['PaymentName'])
							, 'date_added'			=> date("Y-m-d H:i:s")
							, 'device_details'		=> $devicedetails
							, 'ip_address'			=> LMS_IP
					);
	$sqllmsTransInsert  = $dblms->Insert(PAYFAST_TRANSACTIONS , $dataTrans);
	if($sqllmsTransInsert) {
//------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'job_order_id'
							, 'where' 		=> array ( 
														'is_placebycustomer' => 1 
													 )

							, 'return_type' => 'count' 
						); 
    $SalesOrders 	= $dblms->getRows(JOB_ORDER, $conditions);
	$countorder 	=  $SalesOrders;
			
	if($countorder<9) {
		$orderno = 'JC-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'JC-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'JC-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'JC-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'JC-0'.($countorder+1);
	} else {
		$orderno = 'JC-'.($countorder+1);
	}
// get Estimate detail
	$estconditions = array ( 
								'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' 	=> array ( 
														  ''.ESTIMATES.'.estimate_id' 	=> cleanvars($_POST['id'])
														, ''.ESTIMATES.'.estimate_no' 	=> cleanvars($_POST['basket_id'])
													), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowestimate 	= $dblms->getRows(ESTIMATES, $estconditions);
		
// get customers balance		
	$debitcreditconditions = array ( 
								'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 		=> array ( 
															  ''.PAYMENTS.'.status' => 1
															, ''.PAYMENTS.'.id_user' => cleanvars($rowestimate['customer_id'])
														), 
								'return_type' 	=> 'single' 
							); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
	$openingbalance = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);
// end get customer balance	
	
	$POconditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'id_estimate' => cleanvars($_POST['id'])
													)
							, 'order_by' 	=> 'id ASC' 
							, 'return_type' => 'all' 
						); 
    $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

//Insert Query Fields & Values
	$dataInv = array(
							  'job_order_status'	=> '2'
							, 'is_placebycustomer'	=> 1
							, 'id_ade'				=> cleanvars($rowestimate['ade_id'])
							, 'id_customer'			=> cleanvars($rowestimate['id_customer'])	
							, 'job_order_no'		=> cleanvars($orderno)
							, 'dated'				=> date('Y-m-d')
							, 'total'				=> cleanvars($rowestimate['estimate_total'])
							, 'advance'				=> cleanvars($_POST['merchant_amount'])
							, 'sales_tax'			=> cleanvars(($rowestimate['estimate_total'] * 0.16))
							, 'paid_date'			=> cleanvars($_POST['order_date'])
							, 'paid_method'			=> 4
							, 'deposit_slip'		=> cleanvars($_POST['transaction_id'])
							, 'id_company'			=> cleanvars($rowestimate['company_id'])
							, 'id_added'			=> cleanvars($rowestimate['id_added'])
							, 'date_added'			=> date('Y-m-d h:i:s')
							, 'balance'				=> cleanvars($openingbalance + $rowestimate['estimate_total'])
							, 'opening_balance'		=> cleanvars($openingbalance)
							, 'grand_total'			=> cleanvars($openingbalance + $rowestimate['estimate_total'])
							, 'remarks'				=> cleanvars($rowestimate['estimate_remarks'])							
						);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataInv);


//--------------------------------------
	if($sqllmsInsert) { 
		$idOrder = $dblms->lastestid();
//-------------------- Invoice------------------
		$Invconditions = array ( 
							  'select' 		=> 'salesinvoice_id'
							, 'order_by' 	=> 'salesinvoice_id DESC' 
							, 'return_type' => 'single' 
						); 
    	$reultinvs = $dblms->getRows(SALES_INVOICE, $Invconditions);
		$countInv  = $reultinvs['salesinvoice_id'];

		if($countInv<9) {
			$Invoiceno = 'INV-00000'.($countInv+1);
		} else if($countInv<99) {
			$Invoiceno = 'INV-0000'.($countInv+1);
		} else if($countInv<999) {
			$Invoiceno = 'INV-000'.($countInv+1);
		} else if($countInv<9999) {
			$Invoiceno = 'INV-00'.($countInv+1);
		} else if($countInv<99999) {
			$Invoiceno = 'INV-0'.($countInv+1);
		}else {
			$Invoiceno = 'INV-'.($countInv+1);
		}

		$invocieNumber = $Invoiceno;	
		$dataInv = array(
							  'salesinvoice_status'	=> '3'
							, 'salesinvoice_no'		=> $invocieNumber
							, 'dated'				=> date('Y-m-d')
							, 'id_company'			=> cleanvars($rowestimate['company_id'])
							, 'id_customer'			=> cleanvars($rowestimate['id_customer'])
							, 'id_ade'				=> cleanvars($rowestimate['ade_id'])
							, 'id_joborder'			=> cleanvars($idOrder)
							, 'total'				=> cleanvars($rowestimate['estimate_total'])
							, 'paid'				=> cleanvars($_POST['merchant_amount'])
							, 'tax'					=> cleanvars(($rowestimate['estimate_total'] * 0.16))
							, 'prev_balance'		=> cleanvars($openingbalance)
							, 'grand_total'			=> cleanvars($openingbalance + $rowestimate['estimate_total'])
							, 'balance'				=> cleanvars(($openingbalance + $rowestimate['estimate_total'])-$_POST['merchant_amount'])
							, 'remarks'				=> cleanvars($rowestimate['estimate_remarks'])
						);

		//Execute Sales Insert Query
		$sqllmsSaleInsert  = $dblms->Insert(SALES_INVOICE , $dataInv);
		//If Sales Insert Query Executed
		if($sqllmsSaleInsert) {

			$idInvoice = $dblms->lastestid();
			///----------------------------------------------
			foreach($podetails as $rowsdet) {
				// Insert Job Order Details
				$dataOrderDetail = array(
											  'id_job_order'	=> cleanvars($idOrder)
											, 'id_company'		=> cleanvars($rowestimate['company_id'])
											, 'id_item'			=> cleanvars($rowsdet['id_item'])
											, 'unit_price'		=> cleanvars($rowsdet['unit_price'])
											, 'discount'		=> 0
											, 'total_price'		=> cleanvars($rowsdet['total_price'])
											, 'total_qty'		=> cleanvars($rowsdet['qty'])
										);
				$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);
				// end Insert Job order Details
				// Insert Invoice detail
				$dataInvDetail = array(
										  'id_salesinvoice'		=> cleanvars($idInvoice)
										, 'id_company'			=> cleanvars($rowestimate['company_id'])
										, 'id_item'				=> cleanvars($rowsdet['id_item'])
										, 'unit_price'			=> cleanvars($rowsdet['unit_price'])
										, 'discount'			=> 0
										, 'qty'					=> cleanvars($rowsdet['qty'])
										, 'total'				=> cleanvars($rowsdet['total_price'])	
									);

				$sqllmsInsertInvocieDetail  = $dblms->Insert(SALES_INVOICE_DETAILS , $dataInvDetail);
				//end Insert Invoice detail
				// Insert Stock detail
				$dataStck = array (
								  'id_item'			=> cleanvars($rowsdet['id_item'])
								, 'grn_date'		=> date('Y-m-d')
								, 'qty'				=> cleanvars($rowsdet['qty'])
								, 'unitprice'		=> cleanvars($rowsdet['unit_price'])
								, 'stock_type'		=> 2
								, 'reference_no'	=> cleanvars($idInvoice)
								, 'reference_type'	=> 2
								, 'dated'			=> date('Y-m-d')
								, 'remarks'			=> 'Stock Out'
								, 'id_user'			=> cleanvars($rowestimate['id_customer'])
								, 'customer_vendorname'	=> cleanvars($rowestimate['customer_name'])
								, 'invoice_orderno'		=> cleanvars($invocieNumber)
								, 'view_path'			=> 'saleinvoiceprint.php?id='.$idInvoice.''
								, 'date_added'		=> date("Y-m-d H:i:s")
							);
				$sqllmsInsertStock  = $dblms->Insert(STOCK,$dataStck);
				// end Insert Stock detail
			} 
			
			// insert invoice amount
			$dataInvamount = array(
										  'status'			=> '1'
										, 'ledgerfor'		=> '1'
										, 'docs_types'		=> '2'
										, 'id_user'			=> cleanvars($rowestimate['id_customer'])
										, 'reference_no'	=> cleanvars($idOrder)
										, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['order_date'])))
										, 'amount'			=> cleanvars($rowestimate['estimate_total'])
										, 'debit_credit'	=> '2'
										, 'remarks'			=> 'Sales Invoice'
										, 'date_added'		=> date("Y-m-d H:i:s")
									);
					
			$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
			
			// Insert Invoice amount in payments
			$dataInvPayment = array(
										  'status'			=> '1'
										, 'ledgerfor'		=> '1'
										, 'docs_types'		=> '7'
										, 'id_user'			=> cleanvars($rowestimate['id_customer'])	
										, 'reference_no'	=> cleanvars($idOrder)
										, 'dated'			=> cleanvars($_POST['order_date'])
										, 'transaction_id'	=> cleanvars($_POST['transaction_id'])
										, 'amount'			=> cleanvars($_POST['merchant_amount'])
										, 'debit_credit'	=> '1'
										, 'pay_mode'		=> 4
										, 'remarks'			=> get_doctype(7)
										, 'date_added'		=> date("Y-m-d H:i:s")								
								);

			$sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);
			// update job order in estimate table
			$dataEstimate = array(
									  'estimate_status'	=> 2
									, 'id_joborder'		=> cleanvars($idOrder)
									, 'joborder_no'		=> cleanvars($orderno)
								);
			$qryUpdateEstimate = $dblms->Update(ESTIMATES, $dataEstimate, "WHERE estimate_id = '".cleanvars($_POST['id'])."'");

		} // end check Insert Invoice
//--------------------------------------

//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Payment completed successfully.</div>';
		header("Location: ".SITE_URL."/customerestimates.php", true, 301);
		exit();
//--------------------------------------
	} // end check Job Order Insert
//--------------------------------------
} else {
	$_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>'.$_POST['err_msg'].'</div>';
	header("Location: ".SITE_URL."/customerestimates.php?view=convertjoborder&id=".$_POST['id']."", true, 301);
	exit();
}
}