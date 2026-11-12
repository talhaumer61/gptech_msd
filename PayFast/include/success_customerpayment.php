<?php  

	// get Order  detail
	$ordconditions = array ( 
							  'select' 		=> 'invoice_number, id_user, invoice_id'
							, 'where' 		=> array ( 
														  'voucherno' 	=> cleanvars($cusid)
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $roworder = $dblms->getRows(PAYFAST_ORDERS, $ordconditions);

	// get invoice status	
	$curl = curl_init();

	curl_setopt_array($curl, array(
										CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/invoice/?invoice_number='.$roworder['invoice_number'],
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
		//	echo $key .'='.$object.'<br>';

		if($key == 'status') 				 { $orderStatus 			= $object; }
		if($key == 'total_amount') 			 { $orderAmnt 			 	= $object; }
		if($key == 'bill_consumer_number') 	 { $bill_consumer_number 	= $object; }
		if($key == 'payment_transaction_id') { $payment_transaction_id 	= $object; }
		if($key == 'invoice_id') 			 { $invoice_id 				= $object; }
		if($key == 'last_payment_date') 	 { $last_payment_date 		= $object; }
		if($key == 'payment_channel') 		 { $payment_channel 		= $object; }
		if($key == 'payment_link') 			 { $payment_link 			= $object; }
	}
	// if invoice status paid
	if($orderStatus == 'PAID') {  
		// transation details	
		$dataTrans = array (
									  'status'				=> 1
									, 'reference_type'		=> 2
									, 'order_no'			=> cleanvars($cusid)
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
									, 'device_details'		=> $devicedetails
									, 'ip_address'			=> LMS_IP
							);
		$sqllmsTransInsert  = $dblms->Insert(PAYFAST_TRANSACTIONS , $dataTrans);

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
										, 'docs_types'			=> '1'
										, 'id_cat'				=> '3'
										, 'receipt_no'			=> cleanvars($receipt_no['next_receipt_no'])	
										, 'id_user'				=> cleanvars($roworder['id_user'])	
										, 'dated'				=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
										, 'transaction_id'		=> cleanvars($payment_transaction_id)
										, 'transaction_status'	=> 1
										, 'transaction_invoiceno'=> $roworder['invoice_id']
										, 'transaction_amount'	=> cleanvars($orderAmnt)
										, 'transaction_paiddate'=> date('Y-m-d', strtotime(cleanvars($last_payment_date)))
										, 'response_detail'		=> json_encode($requestResponse)
										, 'amount'				=> cleanvars($orderAmnt)
										, 'debit_credit'		=> '1'
										, 'pay_mode'			=> 4
										, 'remarks'				=> get_doctype(1)
										, 'date_added'			=> date("Y-m-d H:i:s")								
								);

		$sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);

			
	} // end check paid