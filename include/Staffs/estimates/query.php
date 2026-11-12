<?php 
//Add Purchase Order
if(isset($_POST['submit_purchase_order'])) { 
	
	$conditions = array ( 
							  'select' 		=> 'estimate_id'
							, 'order_by' 	=> ' estimate_id DESC'
							, 'return_type' => 'single' 
						); 
    $reultorder 	= $dblms->getRows(ESTIMATES, $conditions);
	$countorder 	= $reultorder['estimate_id'];
		
	if($countorder<9) {
		$orderno = 'EST-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'EST-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'EST-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'EST-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'EST-0'.($countorder+1);
	}else {
		$orderno = 'EST-'.($countorder+1);
	}
	

	$dataInv = array(
						  'estimate_status'		=> '1'
						, 'estimate_no'			=> cleanvars($orderno)
						, 'estimate_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_added'			=> date("Y-m-d H:i:s")											
					);
	$sqllmsInsert  = $dblms->Insert(ESTIMATES , $dataInv);

	if($sqllmsInsert) { 

		$latest_id = $dblms->lastestid();
		
		$POgrandtotal = 0;
		
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {
		
			$sqllmsitemchecker  = $dblms->querylms("SELECT id FROM ".ESTIMATES_DETAIL."   
															  WHERE  id_estimate = '".cleanvars($latest_id)."' 
															  AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
			if(mysqli_num_rows($sqllmsitemchecker) == 0) {

				$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


					$dataInvDetail = array(
											  'id_estimate'		=> cleanvars($latest_id)
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
										);

					$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);

					
				}
			}

		}
		

		$remarks = 'Add Customer Estimate  # : '.cleanvars($orderno).' details';
		
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
		header("Location: customerestimates.php?printid=".$latest_id."", true, 301);
		exit();

	}

}

//Update Purchase Order
if(isset($_POST['submit_changes'])) { 
	
		//Assign Job Order Status

	$proStatus = '1';


	
	$dataInv = array(
						  'estimate_status'		=> $proStatus					
						, 'estimate_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'estimate_remarks'	=> cleanvars($_POST['estimate_remarks'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);

	$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");
	

	if($qryUpdate) { 

		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".ESTIMATES_DETAIL."  WHERE id_estimate = '".cleanvars($_POST['estimate_id'])."'");

		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$sqllmsitemchecker  = $dblms->querylms("SELECT id FROM ".ESTIMATES_DETAIL."   
																WHERE  id_estimate = '".cleanvars($_POST['estimate_id'])."' 
																AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
				if(mysqli_num_rows($sqllmsitemchecker) == 0) {

					$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


						$dataInvDetail = array(
												  'id_estimate'		=> cleanvars($_POST['estimate_id'])
												, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
												, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
												, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
												, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
												, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
											);

						$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);


					}
			}

		}

		$remarks = 'Update Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
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
		header("Location: ".$_SERVER['HTTP_REFERER']."&printid=".$_POST['estimate_id']."", true, 301);
		exit();

	}
}

//Add Director Remarks
if(isset($_POST['submit_director_remarks'])) { 

	$conditions = array ( 
							  'select' 		=> 'id'
							, 'where' 		=> array ( 
														  'id_director' 	=> cleanvars(trim($_POST['id_director']))
														, 'id_estimate' 	=> cleanvars(trim($_POST['estimate_id']))
														, 'is_deleted ' 	=> '0'
													)
							, 'return_type' => 'count' 
						); 
	$sqllmscheck = $dblms->getRows(REQUEST_PAYMENT_REMARKS, $conditions);

	// ALREADY EXIST
	if($sqllmscheck>0) { 
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Record already exists.</div>';
		header("Location: customerestimates.php?view=payment_request", true, 301);
		exit();
	}else{
		$data	= array (
							  'id_estimate'			=> cleanvars($_POST['estimate_id'])
							, 'id_director'			=> cleanvars($_POST['id_director'])
							, 'director_remarks'	=> cleanvars($_POST['director_remarks'])
							, 'amount'				=> cleanvars($_POST['approved_amount'])
							, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_added'			=> date('Y-m-d h:i:s')
						);

		$sqllmsRemarks  = $dblms->Insert(REQUEST_PAYMENT_REMARKS , $data);


		if($sqllmsRemarks) { 

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

			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Remarks added successfully.</div>';
			header("Location: customerestimates.php?view=payment_request", true, 301);
			exit();

		}

	}

}

//Add Director Remarks And Approve
if(isset($_POST['submit_approve'])) { 

	$conditions = array ( 
							  'select' 		=> 'id'
							, 'where' 		=> array ( 
														  'id_director' 	=> cleanvars(trim($_POST['id_director']))
														, 'id_estimate' 	=> cleanvars(trim($_POST['estimate_id']))
														, 'is_deleted ' 	=> '0'
													)
							, 'return_type' => 'count' 
						); 
	$sqllmscheck = $dblms->getRows(REQUEST_PAYMENT_REMARKS, $conditions);

	// ALREADY EXIST
	if($sqllmscheck>0) { 
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}else{
		$data	= array (
							  'id_estimate'			=> cleanvars($_POST['estimate_id'])
							, 'id_director'			=> cleanvars($_POST['id_director'])
							, 'director_remarks'	=> cleanvars($_POST['director_remarks'])
							, 'amount'				=> cleanvars($_POST['approved_amount'])
							, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_added'			=> date('Y-m-d h:i:s')
						);

		$sqllmsRemarks  = $dblms->Insert(REQUEST_PAYMENT_REMARKS , $data);


		if($sqllmsRemarks) { 

			// APPROVE REQUEST
			$dataInv = array(
								  'estimate_status'		=> '5'			
								, 'approved_amount'		=> cleanvars($_POST['approved_amount'])
								, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_modify'			=> date("Y-m-d H:i:s")											
							);
			$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");

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

			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Request payment approved successfully.</div>';
			header("Location: customerestimates.php?view=payment_request", true, 301);
			exit();

		}

	}

}


//submit_converttojoborder
if(isset($_POST['submit_converttojoborder'])) { 

	if($_POST['submit_converttojoborder'] == 'savehold') { 
		
		$dataInv = array(
						  'estimate_status'		=> 1
						, 'estimate_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'estimate_remarks'	=> cleanvars($_POST['estimate_remarks'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);
		$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");

		if($qryUpdate) { 

			$sqllmsdel  = $dblms->querylms("DELETE FROM ".ESTIMATES_DETAIL."  WHERE id_estimate = '".cleanvars($_POST['estimate_id'])."'");

			for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

				//Check if ID item is not empty
				if(!empty($_POST['id_item'][$ichk])) {


						$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


						$dataInvDetail = array(
													  'id_estimate'		=> cleanvars($_POST['estimate_id'])
													, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
													, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
													, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
													, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
													, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
											  );

						$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);


				}

			}

			$remarks = 'Update Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
			$dataLog = array(
								  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '2'	
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
							);
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
			$hredredirect = 'customerestimates.php';
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
			header("Location:".$hredredirect."", true, 301);
			exit();

		}
		
		// save and hold and start confirm convert
	} elseif($_POST['submit_converttojoborder'] == 'savepayment') { 
		
		$dataInv = array(
						  'estimate_status'		=> 1
						, 'estimate_date'		=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
						, 'estimate_total'		=> cleanvars($_POST['inV_grandtotal'])
						, 'id_customer'			=> cleanvars($_POST['id_customer'])
						, 'estimate_remarks'	=> cleanvars($_POST['estimate_remarks'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modify'			=> date("Y-m-d H:i:s")											
					);
		$qryUpdate = $dblms->Update(ESTIMATES, $dataInv, "WHERE estimate_id = '".$_POST['estimate_id']."'");

		if($qryUpdate) { 
			
			$conditions = array ( 
							  'select' 		=> 'job_order_id'
							, 'where' 		=> array ( 
														'is_placebycustomer' => 0
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
			
			//Job Order Insert Query Fields & Values
			$dataJO = array(
								  'job_order_status'	=> 1
								, 'is_placebycustomer'	=> 0
								, 'id_ade'				=> cleanvars($_POST['id_ade'])
								, 'id_customer'			=> cleanvars($_POST['id_customer'])
								, 'job_order_no'		=> cleanvars($orderno)
								, 'dated'				=> date('Y-m-d')
								, 'total'				=> cleanvars($_POST['inV_grandtotal'])
								, 'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))
								, 'id_company'			=> cleanvars($_POST['id_company'])
								, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'			=> date('Y-m-d h:i:s')
								, 'balance'				=> cleanvars($_POST['openingbalance'] + $_POST['inV_grandtotal'])
								, 'opening_balance'		=> cleanvars($_POST['openingbalance'])
								, 'grand_total'			=> cleanvars($_POST['openingbalance'] + $_POST['inV_grandtotal'])
								, 'remarks'				=> cleanvars($_POST['estimate_remarks'])		
							);

			//Execute Insert Query
			$sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataJO);
			$idOrder 	   = $dblms->lastestid();


			$sqllmsdel  = $dblms->querylms("DELETE FROM ".ESTIMATES_DETAIL."  WHERE id_estimate = '".cleanvars($_POST['estimate_id'])."'");

			for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

				//Check if ID item is not empty
				if(!empty($_POST['id_item'][$ichk])) {


						$POgrandtotal = ($POgrandtotal + $_POST['total_price'][$ichk]);


						$dataInvDetail = array(
													  'id_estimate'		=> cleanvars($_POST['estimate_id'])
													, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
													, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
													, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
													, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
													, 'is_available'	=> cleanvars($_POST['is_available'][$ichk])
											  );

						$sqllmsInsertDetail  = $dblms->Insert(ESTIMATES_DETAIL,$dataInvDetail);
					
					// Insert Job Order Details
						$dataOrderDetail = array(
													  'id_job_order'	=> cleanvars($idOrder)
													, 'id_company'		=> cleanvars($_POST['id_company'])
													, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
													, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
													, 'discount'		=> 0
													, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
													, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
												);
						$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);

				}

			}
			
			// update job order in estimate table
			$dataEstimate = array(
									  'estimate_status'	=> 2
									, 'id_joborder'		=> cleanvars($idOrder)
									, 'joborder_no'		=> cleanvars($orderno)
								);
			$qryUpdateEstimate = $dblms->Update(ESTIMATES, $dataEstimate, "WHERE estimate_id = '".cleanvars($_POST['estimate_id'])."'");

			$remarks = 'Update Estimate ID : '.cleanvars($_POST['estimate_id']).' details';
			$dataLog = array(
								  'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '2'	
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
							);
			$sqllmslog  = $dblms->Insert(LOGS , $dataLog);
			$hredredirect = 'customerestimates.php';
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
			header("Location:".$hredredirect."", true, 301);
			exit();

		}
		
	}

	


		
}


//Add Manual Payment
if(isset($_POST['submit_manualpayment'])) { 

	 $estconditions = array ( 
							  'select' 		=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade "
							, 'where' 		=> array ( 
														  ''.ESTIMATES.'.estimate_id' 		=> cleanvars($_POST['estimate_id'])
														 ,''.ESTIMATES.'.is_deleted' 		=> '0'
														 ,''.ESTIMATES.'.estimate_status' 	=> '6'
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
        $rowestimate = $dblms->getRows(ESTIMATES, $estconditions);

        if($rowestimate){



            // LATEST JOB ORDER NO
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

            // CUSTOMER OPENING BALANCE
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


            $POconditions = array ( 
                                        'select' 		=> '*'
                                        , 'where' 		=> array( 
                                                                    'id_estimate' => cleanvars($rowestimate['estimate_id'])
                                                                )
                                        , 'order_by' 	=> 'id ASC' 
                                        , 'return_type' => 'all' 
                                ); 
            $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

			$bad_symbols = array(",", ".");
            $advance = str_replace($bad_symbols, "", $_POST['advance']);
			$dataInv = array(
								  'job_order_status'	=> '2'
								, 'is_placebycustomer'	=> 1
								, 'id_ade'				=> cleanvars($rowestimate['ade_id'])
								, 'id_customer'			=> cleanvars($rowestimate['id_customer'])	
								, 'job_order_no'		=> cleanvars($orderno)
								, 'dated'				=> date('Y-m-d')
								, 'total'				=> cleanvars($rowestimate['estimate_total'])
								, 'advance'				=> cleanvars($advance)
								, 'sales_tax'			=> cleanvars(($rowestimate['estimate_total'] * 0.16))
								, 'paid_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
								, 'paid_method'			=> cleanvars($_POST['payment_method'])
								, 'id_account'			=> cleanvars($_POST['id_account'])
								, 'deposit_slip'		=> cleanvars($_POST['deposit_slip'])
								, 'id_company'			=> cleanvars($rowestimate['company_id'])
								, 'id_added'			=> cleanvars($rowestimate['id_added'])
								, 'date_added'			=> date('Y-m-d h:i:s')
								, 'balance'				=> cleanvars($openingbalance + $rowestimate['estimate_total'])
								, 'opening_balance'		=> cleanvars($openingbalance)
								, 'grand_total'			=> cleanvars($openingbalance + $rowestimate['estimate_total'])
								, 'remarks'				=> cleanvars($rowestimate['estimate_remarks'])							
							);
                            
			$sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataInv);

            if($sqllmsInsert) { 
				$idOrder = $dblms->lastestid();
				
                foreach($podetails as $rowsdet) {
                    
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
                } 

                // INVOICE AMOUNT
                $dataInvamount = array(
                                            'status'			=> '1'
                                            , 'ledgerfor'		=> '1'
                                            , 'docs_types'		=> '2'
                                            , 'id_user'			=> cleanvars($rowestimate['id_customer'])
                                            , 'reference_no'	=> cleanvars($idOrder)
                                            , 'dated'			=>  date('Y-m-d')
                                            , 'amount'			=> cleanvars($rowestimate['estimate_total'])
                                            , 'debit_credit'	=> '2'
                                            , 'remarks'			=> 'Sales Invoice'
											, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                                            , 'date_added'		=> date("Y-m-d H:i:s")
                                        );

                $sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);


                //SLIP NO
                $systemslip 	= $mainclass->get_systemslipno(1,1);

                // INVOICE AMOUNT PAYMENT
                $dataInvPayment = array(
                                              'status'				=> '1'
											, 'systemslip_no'		=> $systemslip
                                            , 'ledgerfor'			=> '1'
                                            , 'docs_types'			=> '7'
                                            , 'id_user'				=> cleanvars($rowestimate['id_customer'])	
                                            , 'reference_no'		=> cleanvars($idOrder)
                                            , 'dated'				=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
                                            , 'receipt_no'			=> cleanvars($_POST['deposit_slip'])
                                            , 'amount'				=> cleanvars($advance)
                                            , 'debit_credit'		=> '1'
                                            , 'pay_mode'			=> cleanvars($_POST['payment_method'])
											, 'id_account'			=> cleanvars($_POST['id_account'])
                                            , 'id_cat'				=> '1'
                                            , 'remarks'				=> get_doctype(7)
											, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                                            , 'date_added'			=> date("Y-m-d H:i:s")								
                                    );

                $sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);
				
				$idLatest = $dblms->lastestid();

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
	
							$dataupload = array (
												'attachment'	=> $img_fileName
												);

							//Execute Update Query
							$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".cleanvars($idLatest)."'");
							
							$mode = '0644'; 
							
							move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
							chmod ($originalImage, octdec($mode));
					}
					
				}

                
                // UPDATE ESTIMATE STATUS
                $dataEstimate = array(
                                        'estimate_status'		=> 7
                                        , 'id_joborder'			=> cleanvars($idOrder)
                                        , 'joborder_no'			=> cleanvars($orderno)
                                        , 'voucher_status'		=> 2
                                        , 'voucher_amount'		=> $respData['amount'] 
                                        , 'voucher_paid_date'	=> date("Y-m-d H:i:s")
                                        , 'response_detail'		=> json_encode($data)
                                    );
                $qryUpdateEstimate = $dblms->Update(ESTIMATES, $dataEstimate, "WHERE estimate_id = '".cleanvars($rowestimate['estimate_id'])."'");
				
			}

            http_response_code(200);
            echo json_encode(["status" => "200", 'description' => 'Challan Status Updated']);

			if($sqllmsInsertPayment) { 

				$remarks = 'Add Manual Payment Remarks # : '.$idLatest.' details';

				$dataLog = array(
									'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'filename'	=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)
								, 'action'		=> '1'	
								, 'dated'		=> date("Y-m-d H:i:s")
								, 'ip'			=> cleanvars($ip)
								, 'remarks'		=> cleanvars($remarks)
							);
				$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

				$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Manual payment added successfully.</div>';
				header("Location: customerestimates.php?view=challan_generated", true, 301);
				exit();

			}
        }else{
			$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Record already exists.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
}
