<?php 
// get Estimate detail
	$estconditions = array ( 
							  'select' 		=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade "
							, 'where' 		=> array ( 
														  ''.ESTIMATES.'.estimate_id' 		=> cleanvars($estid)
														 ,''.ESTIMATES.'.is_deleted' 		=> '0'
														 ,''.ESTIMATES.'.estimate_status' 	=> '6'
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $rowestimate = $dblms->getRows(ESTIMATES, $estconditions);

	if($rowestimate){
	
		// get invoice status	
		$curl = curl_init();

		curl_setopt_array($curl, array(
											CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/invoice/?invoice_number='.$rowestimate['invoice_number'],
											CURLOPT_RETURNTRANSFER 	=> true,
											CURLOPT_ENCODING 		=> '',
											CURLOPT_MAXREDIRS 		=> 10,
											CURLOPT_TIMEOUT 		=> 0,
											CURLOPT_FOLLOWLOCATION 	=> true,
											CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST 	=> 'GET',
											CURLOPT_HTTPHEADER 		=> array(
																				'Authorization: Basic '.PAYFAST_BASICAUTH.''
																			),
									)
						);

		$response = curl_exec($curl);

		//Decode Request Response
		$requestResponse = json_decode($response, true);

		$orderStatus 			= '' ;
		$orderAmnt 				= '' ;
		$bill_consumer_number 	= '' ;
		$payment_transaction_id = '' ;
		$invoice_id 			= '' ;
		$last_payment_date 		= '' ;
		$payment_channel 		= '' ;
		$payment_link 			= '' ;
		//To Get Order Status of Response
		foreach($requestResponse as $key => $object) { 
			//		echo $key .'='.$object.'<br>';

			if($key == 'status') 				 { $orderStatus 			= $object; }
			if($key == 'total_amount') 			 { $orderAmnt 			 	= $object; }
			if($key == 'bill_consumer_number') 	 { $bill_consumer_number 	= $object; }
			if($key == 'payment_transaction_id') { $payment_transaction_id 	= $object; }
			if($key == 'invoice_id') 			 { $invoice_id 				= $object; }
			if($key == 'last_payment_date') 	 { $last_payment_date 		= $object; }
			if($key == 'payment_channel') 		 { $payment_channel 		= $object; }
			if($key == 'payment_link') 			 { $payment_link 			= $object; }
		}

		if($orderStatus == 'PAID') {  
			// transation details	
			$dataTrans = array (
										'status'				=> 1
										, 'reference_type'		=> 1
										, 'order_no'			=> cleanvars($estid)
										, 'reference_no'		=> cleanvars($bill_consumer_number)
										, 'transaction_id'		=> cleanvars($payment_transaction_id)
										, 'basket_id'			=> cleanvars($invoice_id)
										, 'order_date'			=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
										, 'transaction_amount'	=> cleanvars($orderAmnt)
										, 'merchant_amount'		=> cleanvars($orderAmnt)
										, 'transaction_currency'=> 'PKR'
										, 'paymentname'			=> cleanvars($payment_channel)
										, 'payment_link'		=> cleanvars($payment_link)
										, 'response_detail'		=> json_encode($requestResponse)
										, 'date_added'			=> date("Y-m-d H:i:s")
										, 'device_details'		=> ($devicedetails)
										, 'ip_address'			=> LMS_IP
								);
			$sqllmsTransInsert  = $dblms->Insert(PAYFAST_TRANSACTIONS , $dataTrans);
			
			// get latest job order 
			$conditions = array ( 
									'select' 		=> 'job_order_id'
									, 'where' 		=> array ( 
																'is_placebycustomer' => 1 
															)
									, 'return_type' => 'count' 
								); 
			$SalesOrders = $dblms->getRows(JOB_ORDER, $conditions);
			$countorder  =  $SalesOrders;
				
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
			// get customers balance		
			$debitcreditconditions = array ( 
											'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
																SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit"
											, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user"
											, 'where' 		=> array ( 
																		''.PAYMENTS.'.status' => 1
																		, ''.PAYMENTS.'.id_user' => cleanvars($rowestimate['customer_id'])
																	)
											, 'return_type' => 'single' 
										); 
			$valuedebitcrdit = $dblms->getRows(PAYMENTS, $debitcreditconditions);
			$openingbalance  = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);
			// end get customer balance	
		
			$POconditions = array ( 
										'select' 		=> '*'
										, 'where' 		=> array( 
																	'id_estimate' => cleanvars($estid)
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
								, 'advance'				=> cleanvars($orderAmnt)
								, 'sales_tax'			=> cleanvars(($rowestimate['estimate_total'] * 0.16))
								, 'paid_date'			=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
								, 'paid_method'			=> 4
								, 'deposit_slip'		=> cleanvars($payment_transaction_id)
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
			
			if($sqllmsInsert) { 
				$idOrder = $dblms->lastestid();
				//-------------------- Invoice------------------
				// $Invconditions = array ( 
				// 							  'select' 		=> 'salesinvoice_id'
				// 							, 'order_by' 	=> 'salesinvoice_id DESC' 
				// 							, 'return_type' => 'single' 
				// 						); 
				// $reultinvs = $dblms->getRows(SALES_INVOICE, $Invconditions);
				// $countInv  = $reultinvs['salesinvoice_id'];

				// if($countInv<9) {
				// 	$Invoiceno = 'INV-00000'.($countInv+1);
				// } else if($countInv<99) {
				// 	$Invoiceno = 'INV-0000'.($countInv+1);
				// } else if($countInv<999) {
				// 	$Invoiceno = 'INV-000'.($countInv+1);
				// } else if($countInv<9999) {
				// 	$Invoiceno = 'INV-00'.($countInv+1);
				// } else if($countInv<99999) {
				// 	$Invoiceno = 'INV-0'.($countInv+1);
				// } else {
				// 	$Invoiceno = 'INV-'.($countInv+1);
				// }

				// $invocieNumber = $Invoiceno;
				
				// $dataInv = array(
				// 					  'salesinvoice_status'	=> '3'
				// 					, 'salesinvoice_no'		=> $invocieNumber
				// 					, 'dated'				=> date('Y-m-d')
				// 					, 'id_company'			=> cleanvars($rowestimate['company_id'])
				// 					, 'id_customer'			=> cleanvars($rowestimate['id_customer'])
				// 					, 'id_ade'				=> cleanvars($rowestimate['ade_id'])
				// 					, 'id_joborder'			=> cleanvars($idOrder)
				// 					, 'total'				=> cleanvars($rowestimate['estimate_total'])
				// 					, 'paid'				=> cleanvars($orderAmnt)
				// 					, 'tax'					=> cleanvars(($rowestimate['estimate_total'] * 0.16))
				// 					, 'prev_balance'		=> cleanvars($openingbalance)
				// 					, 'grand_total'			=> cleanvars($openingbalance + $rowestimate['estimate_total'])
				// 					, 'balance'				=> cleanvars(($openingbalance + $rowestimate['estimate_total'])-$orderAmnt)
				// 					, 'remarks'				=> cleanvars($rowestimate['estimate_remarks'])
				// 			);

				// //Execute Sales Insert Query
				// $sqllmsSaleInsert  = $dblms->Insert(SALES_INVOICE , $dataInv);
				
					//If Sales Insert Query Executed
				// if($sqllmsSaleInsert) {

					// $idInvoice = $dblms->lastestid();
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
						// $dataInvDetail = array(
						// 						  'id_salesinvoice'		=> cleanvars($idInvoice)
						// 						, 'id_company'			=> cleanvars($rowestimate['company_id'])
						// 						, 'id_item'				=> cleanvars($rowsdet['id_item'])
						// 						, 'unit_price'			=> cleanvars($rowsdet['unit_price'])
						// 						, 'discount'			=> 0
						// 						, 'qty'					=> cleanvars($rowsdet['qty'])
						// 						, 'total'				=> cleanvars($rowsdet['total_price'])	
						// 					);

						// $sqllmsInsertInvocieDetail  = $dblms->Insert(SALES_INVOICE_DETAILS , $dataInvDetail);
						//end Insert Invoice detail
						// Insert Stock detail
						// $dataStck = array (
						// 					  'id_item'			=> cleanvars($rowsdet['id_item'])
						// 					, 'grn_date'		=> date('Y-m-d')
						// 					, 'qty'				=> cleanvars($rowsdet['qty'])
						// 					, 'unitprice'		=> cleanvars($rowsdet['unit_price'])
						// 					, 'stock_type'		=> 2
						// 					, 'reference_no'	=> cleanvars($idInvoice)
						// 					, 'reference_type'	=> 2
						// 					, 'dated'			=> date('Y-m-d')
						// 					, 'remarks'			=> 'Stock Out'
						// 					, 'id_user'			=> cleanvars($rowestimate['id_customer'])
						// 					, 'customer_vendorname'	=> cleanvars($rowestimate['customer_name'])
						// 					, 'invoice_orderno'		=> cleanvars($invocieNumber)
						// 					, 'view_path'			=> 'saleinvoiceprint.php?id='.$idInvoice.''
						// 					, 'date_added'		=> date("Y-m-d H:i:s")
						// 			);
						// $sqllmsInsertStock  = $dblms->Insert(STOCK,$dataStck);
						// end Insert Stock detail
					} 

					// insert invoice amount
					$dataInvamount = array(
												'status'			=> '1'
												, 'ledgerfor'		=> '1'
												, 'docs_types'		=> '2'
												, 'id_user'			=> cleanvars($rowestimate['id_customer'])
												, 'reference_no'	=> cleanvars($idOrder)
												, 'dated'			=>  date('Y-m-d', strtotime(cleanvars($last_payment_date)))
												, 'amount'			=> cleanvars($rowestimate['estimate_total'])
												, 'debit_credit'	=> '2'
												, 'remarks'			=> 'Sales Invoice'
												, 'date_added'		=> date("Y-m-d H:i:s")
											);

					$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

					// RECEIPT NO
					$year = substr(date('Y'), -2);
					$conReceipt = array ( 
											'select' 		=> "CONCAT('BR-".$year."', LPAD(
																	COALESCE(MAX(CAST(SUBSTRING(receipt_no, 6) AS UNSIGNED)), 0) + 1, 
																	5, '0')) 
																AS next_receipt_no"
											, 'where' 		=> array ( 
																		'status ' => 1 
																	)
											, 'search_by' 	=> " AND receipt_no LIKE 'BR-".$year."%'"
											, 'return_type' => 'single' 
										); 
					$receipt_no = $dblms->getRows(PAYMENTS, $conReceipt);

					// Insert Invoice amount in payments
					$dataInvPayment = array(
												'status'				=> '1'
												, 'ledgerfor'			=> '1'
												, 'docs_types'			=> '7'
												, 'id_cat'				=> '4'
												, 'receipt_no'			=> cleanvars($receipt_no['next_receipt_no'])	
												, 'id_user'				=> cleanvars($rowestimate['id_customer'])	
												, 'reference_no'		=> cleanvars($idOrder)
												, 'dated'				=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
												, 'transaction_id'		=> cleanvars($payment_transaction_id)
												, 'transaction_status'	=> 1
												, 'transaction_invoiceno'=> cleanvars($rowestimate['invoice_id'])
												, 'transaction_amount'	=> cleanvars($orderAmnt)
												, 'transaction_paiddate'=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
												, 'response_detail'		=> json_encode($requestResponse)
												, 'amount'				=> cleanvars($orderAmnt)
												, 'debit_credit'		=> '1'
												, 'pay_mode'			=> 4
												, 'remarks'				=> get_doctype(7)
												, 'date_added'			=> date("Y-m-d H:i:s")								
										);

					$sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);
					// update job order in estimate table
					$dataEstimate = array(
											'estimate_status'		=> 7
											, 'id_joborder'			=> cleanvars($idOrder)
											, 'joborder_no'			=> cleanvars($orderno)
											, 'voucher_status'		=> 2
											, 'voucher_amount'		=> $orderAmnt 
											, 'voucher_paid_date'	=> date("Y-m-d H:i:s")
											, 'response_detail'		=> json_encode($requestResponse)
										);
					$qryUpdateEstimate = $dblms->Update(ESTIMATES, $dataEstimate, "WHERE estimate_id = '".cleanvars($estid)."'");

				// } // end check Insert Invoice

				
			}

				
		} // end check paid

	}
