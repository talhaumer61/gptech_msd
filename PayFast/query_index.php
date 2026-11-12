<?php 
//------------------------------------------------
if(isset($_POST['submit_paynow'])) { 
	
	if($_POST['otheramnt'] != 0) {
		$amtpayable = $_POST['otheramnt'];
	} elseif(isset($_POST['approved_amount'])){
		$amtpayable = $_POST['approved_amount'];
	} else {
		$vars 		= explode(',', $_POST['payamount']);
		$amtpayable = $vars[0];
	}
	
	$duedays = 30;

	if($control == "estimatepayment") {

		$checkconditions = array ( 
									  'select' 		=> 'voucher_no'
									, 'where' 		=> array( 
																'estimate_id' => cleanvars($_POST['estimate_id'])
															)
									, 'not_equal' 	=> array( 
																'voucher_no' => ''
															)
									, 'return_type' => 'count' 
								); 
		$valuechecker 	= $dblms->getRows(ESTIMATES, $checkconditions);
		if($valuechecker != 0){
			$_SESSION['msg']['status'] = '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Challan already generated! </div>';
			header("Location: ".SITE_URL."/customerestimates.php", true, 301);
			exit();
		}
		//Customer Creation Request Start
		$curl = curl_init();

		$dataCustomer['email']      = cleanvars($_POST['customer_email']);
		$dataCustomer['mobile']     = cleanvars($_POST['customer_cellno']);
		$dataCustomer['firstname']  = cleanvars($_POST['customer_name']);
		$dataCustomer['lastname']   = ' ';
		$jsonRequestCustomer 		= json_encode($dataCustomer,JSON_UNESCAPED_UNICODE);

		curl_setopt_array($curl, array(
										CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/customer/create',
										CURLOPT_RETURNTRANSFER 	=> true,
										CURLOPT_ENCODING 		=> '',
										CURLOPT_MAXREDIRS 		=> 10,
										CURLOPT_TIMEOUT 		=> 0,
										CURLOPT_FOLLOWLOCATION 	=> true,
										CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST 	=> 'POST',
										CURLOPT_POSTFIELDS 		=>$jsonRequestCustomer,
										CURLOPT_HTTPHEADER 		=> array(
																			'Authorization: Basic '.PAYFAST_BASICAUTH.'',
																			'Content-Type: application/json'
																		),
									)
						 );

		$responseCustomer = curl_exec($curl);

		curl_close($curl);
		//echo $responseCustomer;
		//exit();
		//Customer Creation Request End
		//Voucher Creation Request Start
		$callBackURL = PAYFAST_CALLBACK.'?estid='.cleanvars($_POST['estimate_id']);
		//echo $callBackURL;
		

		$data['customer_email']  = cleanvars($_POST['customer_email']);
		$data['recipient_email'] = cleanvars($_POST['customer_email']);
		$data['total_amount']    = $amtpayable;
		$data['invoice_ref_id']  = (string)$_POST['estimate_id'];
		$data['billing_month']   = date('Y-m');
		$data['bill_category']   = 'BILL';
		$data['due_in_days']     = $duedays;
		$data['expires_in_days'] = $duedays;
		$data['callback_url']    = $callBackURL;

		$jsonRequest = json_encode($data,JSON_UNESCAPED_UNICODE);

		//	echo ($jsonRequest);

		$curl12 = curl_init();

		curl_setopt_array($curl12, array(
											CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/invoice/create',
											CURLOPT_RETURNTRANSFER 	=> true,
											CURLOPT_ENCODING 		=> '',
											CURLOPT_MAXREDIRS 		=> 10,
											CURLOPT_TIMEOUT 		=> 0,
											CURLOPT_FOLLOWLOCATION 	=> true,
											CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST 	=> 'POST',
											CURLOPT_POSTFIELDS 		=> $jsonRequest,
											CURLOPT_HTTPHEADER 		=> array(
																				'Authorization: Basic '.PAYFAST_BASICAUTH.'',
																				'Content-Type: application/json'
																			),
										)
						 );

		$response 	= curl_exec($curl12);
		$err 		= curl_error($curl12);

		$httpCode = curl_getinfo($curl12, CURLINFO_HTTP_CODE);
		if ($httpCode != 200) {
			error_log("PayFast HTTP Code: " . $httpCode);
			error_log("PayFast Response: " . $response);
		}

		
		curl_close($curl12);


		//Voucher Creation Request End
		if($err) {
			//Set Error Message
			$_SESSION['msg']['status'] = '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> You\'re not registered due to some error. Please try again.</div>';
			header("Location: ".SITE_URL."/customerestimates.php?view=payment_request_edit&id=".$_POST['estimate_id']."", true, 301);
			exit();

		} else {

			//Decode Request Response
			$requestResponse = json_decode($response, true);

			$invoiceKey         = '';
			$invoiceNumber      = '';
			$invoiceID          = '';
			$invoiceReferenceID = '';
			$paymentLink        = '';


			//To Values of Response
			foreach($requestResponse as $key => $object){

				if($key == 'invoice_key')	{ $invoiceKey 		= $object; }
				if($key == 'invoice_number'){ $invoiceNumber 	= $object; }
				if($key == 'invoice_id')	{ $invoiceID 		= $object; }
				if($key == 'invoice_ref_id'){ $invoiceReferenceID = $object; }
				if($key == 'payment_link')	{ $paymentLink 		= $object; }         

			}

			if($paymentLink){

				// challan no
				$yearMonth = substr(date('Y'),2,4).date('m');
				do {
					$voucherno 	= $yearMonth.mt_rand(10000,99999);
					$checkconditions = array ( 
												  'select' 		=> 'voucher_no'
												, 'where' 		=> array( 
																			'voucher_no' => cleanvars($voucherno)
																		)
												, 'return_type' => 'count' 
											); 
					$sqlCheck 	= $dblms->getRows(ESTIMATES, $checkconditions);
				} while ($sqlCheck > 0);

				//Set Success Message & Redirect 

					$dataInv = array(
										  'invoice_key'		=> $invoiceKey					
										, 'invoice_number'	=> $invoiceNumber
										, 'voucher_no'		=> $voucherno
										, 'estimate_status'	=> '6'
										, 'invoice_id'		=> cleanvars($invoiceID)
										, 'pay_url'			=> cleanvars($paymentLink)
										, 'issue_date'		=> date('Y-m-d')
										, 'expiry_date'		=> date('Y-m-d', strtotime(' + '.$duedays.' days'))
										, 'total_amount'	=> cleanvars($amtpayable)
										, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
										, 'date_modify'		=> date("Y-m-d H:i:s")											
									);

					if(isset($_POST['approved_amount'])){
						$redirect = '?view=payment_request';
						$data	= array (
											  'id_estimate'			=> cleanvars($_POST['estimate_id'])
											, 'id_director'			=> cleanvars($_POST['id_director'])
											, 'director_remarks'	=> cleanvars($_POST['director_remarks'])
											, 'amount'				=> cleanvars($_POST['approved_amount'])
											, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
											, 'date_added'			=> date('Y-m-d h:i:s')
										);
						$sqllmsRemarks  = $dblms->Insert(REQUEST_PAYMENT_REMARKS , $data);

						if($sqllmslog){
							$idLatest = $dblms->lastestid();
							$remarks = 'Add Request Payment Remarks # : '.$idLatest.' details';

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

						$dataInv['approved_amount'] = cleanvars($amtpayable);
					}

					$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");

					if($qryUpdate) { 
						
						// . "Invoice Number: `" . ONEBILL_PREFIX . $invoiceNumber . "`\n\n"
						$phone		= convertPhoneNumber($_POST['customer_cellno']);
						$message	= "Dear ".$_POST['customer_name']."\n\n"
									. "Your Order Request has been approved and Your Voucher has been Generated.\n\n"
									. "Total Payables Rs: " . number_format($amtpayable) . "\n\n"
									. "Invoice Number: `NA`\n\n"
									. "Kindly pay within 48 hours for order processing within time.\n\n"
									. "Regards,\n"
									. "*Laurel Publisher*";

						$curl = curl_init();
						curl_setopt_array($curl, array(
														   CURLOPT_URL              => WA_URL,
														   CURLOPT_RETURNTRANSFER   => true,
														   CURLOPT_ENCODING         => '',
														   CURLOPT_MAXREDIRS        => 10,
														   CURLOPT_TIMEOUT          => 0,
														   CURLOPT_FOLLOWLOCATION   => true,
														   CURLOPT_HTTP_VERSION     => CURL_HTTP_VERSION_1_1,
														   CURLOPT_CUSTOMREQUEST    => 'POST',
														   CURLOPT_POSTFIELDS      => array(
																								  'api_key' => WA_APPKEY
																								, 'sender'  => WA_SENDER
																								, 'number'  => $phone
																								, 'message' => $message
																							),
													 ));
				
						$response = curl_exec($curl);
						$responseArray = json_decode($response, true);
				
						curl_close($curl);

						$remarks = 'Challan Generated Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
						$dataLog = array(
											 'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
											, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
											, 'action'		=> '2'	
											, 'dated'		=> date("Y-m-d H:i:s")
											, 'ip'			=> cleanvars($ip)
											, 'remarks'		=> cleanvars($remarks)
										);
						$sqllmslog  = $dblms->Insert(LOGS , $dataLog);


						$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Challan Generated</div>';
						header("Location: ".SITE_URL."/customerestimates.php".$redirect."", true, 301);
						exit();

					}

			} else{
				//Set Error Message
				$_SESSION['msg']['status'] = '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> You\'re not registered due to some error. Please try again.</div>';
				header("Location: ".SITE_URL."/customerestimates.php?view=payment_request_edit&id=".$_POST['estimate_id']."", true, 301);
				exit();
			}
		}
	} // control estimatepayment
	
	// customer payment control
	if($control == "customerpayment") { 
		
		// generate random voucher no
		$voucherno = mt_rand(1000000000,9999999999);
		//Customer Creation Request Start
		$curl = curl_init();

		$dataCustomer['email']      = cleanvars($_POST['customer_email']);
		$dataCustomer['mobile']     = cleanvars($_POST['customer_cellno']);
		$dataCustomer['firstname']  = cleanvars($_POST['customer_name']);
		$dataCustomer['lastname']   = ' ';
		$jsonRequestCustomer 		= json_encode($dataCustomer,JSON_UNESCAPED_UNICODE);

		curl_setopt_array($curl, array(
										CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/customer/create',
										CURLOPT_RETURNTRANSFER 	=> true,
										CURLOPT_ENCODING 		=> '',
										CURLOPT_MAXREDIRS 		=> 10,
										CURLOPT_TIMEOUT 		=> 0,
										CURLOPT_FOLLOWLOCATION 	=> true,
										CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST 	=> 'POST',
										CURLOPT_POSTFIELDS 		=>$jsonRequestCustomer,
										CURLOPT_HTTPHEADER 		=> array(
																			'Authorization: Basic '.PAYFAST_BASICAUTH.'',
																			'Content-Type: application/json'
																		),
									)
						 );

		$responseCustomer = curl_exec($curl);

		curl_close($curl);
		//echo $responseCustomer;
		//exit();
		//Customer Creation Request End
		//Voucher Creation Request Start
		$callBackURL = PAYFAST_CALLBACK.'?cusid='.$voucherno;
		//echo $callBackURL;
		

		$data['customer_email']  = cleanvars($_POST['customer_email']);
		$data['recipient_email'] = cleanvars($_POST['customer_email']);
		$data['total_amount']    = $amtpayable;
		$data['invoice_ref_id']  = (string)$voucherno;
		$data['billing_month']   = date('Y-m');
		$data['bill_category']   = 'BILL';
		$data['due_in_days']     = $duedays;
		$data['expires_in_days'] = $duedays;
		$data['callback_url']    = $callBackURL;

		$jsonRequest = json_encode($data,JSON_UNESCAPED_UNICODE);

		//	echo ($jsonRequest);

		$curl12 = curl_init();

		curl_setopt_array($curl12, array(
											CURLOPT_URL 			=> 'https://paylink.apps.net.pk/api/merchant/invoice/create',
											CURLOPT_RETURNTRANSFER 	=> true,
											CURLOPT_ENCODING 		=> '',
											CURLOPT_MAXREDIRS 		=> 10,
											CURLOPT_TIMEOUT 		=> 0,
											CURLOPT_FOLLOWLOCATION 	=> true,
											CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST 	=> 'POST',
											CURLOPT_POSTFIELDS 		=> $jsonRequest,
											CURLOPT_HTTPHEADER 		=> array(
																				'Authorization: Basic '.PAYFAST_BASICAUTH.'',
																				'Content-Type: application/json'
																			),
										)
						 );

		$response 	= curl_exec($curl12);
		$err 		= curl_error($curl12);

		curl_close($curl12);

		//Voucher Creation Request End
		if($err) {
			//Set Error Message
			$_SESSION['msg']['status'] = '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> You\'re not registered due to some error. Please try again.</div>';
			header("Location: ".SITE_URL."/customerpaynow.php", true, 301);
			exit();

		} else {

			//Decode Request Response
			$requestResponse = json_decode($response, true);

			$invoiceKey         = '';
			$invoiceNumber      = '';
			$invoiceID          = '';
			$invoiceReferenceID = '';
			$paymentLink        = '';


			//To Values of Response
			foreach($requestResponse as $key => $object){

				if($key == 'invoice_key')	{ $invoiceKey 		= $object; }
				if($key == 'invoice_number'){ $invoiceNumber 	= $object; }
				if($key == 'invoice_id')	{ $invoiceID 		= $object; }
				if($key == 'invoice_ref_id'){ $invoiceReferenceID = $object; }
				if($key == 'payment_link')	{ $paymentLink 		= $object; }         

			}

			if($paymentLink){

				//Set Success Message & Redirect 

					$dataInv = array(
										  'id_user'			=> $_POST['customer_id']	
										, 'voucherno'		=> $voucherno	
										, 'invoice_key'		=> $invoiceKey	
										, 'invoice_number'	=> $invoiceNumber
										, 'invoice_id'		=> cleanvars($invoiceID)
										, 'pay_url'			=> cleanvars($paymentLink)
										, 'expiry_date'		=> date('Y-m-d', strtotime(' + '.$duedays.' days'))
										, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
										, 'date_added'		=> date("Y-m-d H:i:s")											
									);

					$qryUpdate = $dblms->Insert(PAYFAST_ORDERS, $dataInv);
					header("Location:".$paymentLink."", true, 301);
					exit();

			} else{
				//Set Error Message
				$_SESSION['msg']['status'] = '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> You\'re not registered due to some error.</div>';
				header("Location: ".SITE_URL."/customerpaynow.php", true, 301);
				exit();
			}
		}
	} // customer payment control 
		
} //end submit