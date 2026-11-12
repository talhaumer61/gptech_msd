<?php 

//Update Purchase Order
if(isset($_POST['bill_changes'])) { 

	//Assign Job Order Status
	if($_POST['bill_changes'] == 'savehold') {
		$jobOrderStatus = '1';
	} else if($_POST['bill_changes'] == 'saveforward') {
		$jobOrderStatus = '3';
	}	
	
	
	if($_POST['payment_method'] == 1) {
		$idaccount = $_POST['id_account'];
	} else {
		$idaccount = 0;
	}

	$balance = $_POST['inV_receiveable'] - $_POST['advance']; 
	$dataOrder = array(
							  'job_order_status'	=> $jobOrderStatus
							, 'freight_charges'		=> cleanvars($_POST['freight_charges'])
							, 'total'				=> cleanvars($_POST['inV_grandtotal'])
							, 'advance'				=> cleanvars($_POST['advance'])
							, 'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))
							// , 'paid_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
							// , 'paid_method'			=> cleanvars($_POST['payment_method'])
							// , 'id_account'			=> cleanvars($idaccount)
							// , 'deposit_slip'		=> cleanvars($_POST['deposit_slip'])
							, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_modified'		=> date('Y-m-d h:i:s')
							, 'balance'				=> cleanvars($balance)
							, 'grand_total'			=> cleanvars($_POST['inV_receiveable'])
							, 'remarks'				=> cleanvars($_POST['remarks'])
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(JOB_ORDER , $dataOrder , " WHERE job_order_id = '".cleanvars($_GET['id'])."'");

	//If Update Query Executed
	if($sqllmsUpdate) { 
		
		//Delete Previous Order Details
		$sqllmsDel  = $dblms->querylms("DELETE FROM ".JOB_ORDER_DETAILS." WHERE id_job_order = '".cleanvars($_GET['id'])."'");

		//Iterate over Items Array
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){
			
			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$dataOrderDetail = array(
											  'id_job_order'	=> cleanvars($_GET['id'])
											, 'id_company'		=> cleanvars($_POST['id_company'])
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'discount'		=> cleanvars($_POST['discount_percentage'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);
				$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);
			
				unset($sqllmsInsertDetail);
			}
		}

		//Insert Log Remarks
		$remarks = 'Update Job Order: "'.cleanvars($_POST['job_order_no']).'" Details';
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_office									, 
															id_company				
															)
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."' , 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($remarks)."'						,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
															)
									");
	
		if($_POST['bill_changes'] == 'saveforward') {
			// check job order in invoice table
			$sqllmsCheck 	= $dblms->querylms("SELECT id_joborder FROM ".SALES_INVOICE." 
														WHERE id_joborder =  '".cleanvars($_GET['id'])."'"); 
			if(mysqli_num_rows($sqllmsCheck) == 0) {

				//To Set Invoice Number
				$sqllmslastinv 	= $dblms->querylms("SELECT salesinvoice_id FROM ".SALES_INVOICE." ORDER BY salesinvoice_id DESC");
				$reultinvs		= mysqli_fetch_array($sqllmslastinv);
				$countInv 		= $reultinvs['salesinvoice_id'];

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
				$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));
		
				$dataInv = array(
									  'salesinvoice_status'	=> '3'
									, 'freight_charges'		=> cleanvars($_POST['freight_charges'])
									, 'salesinvoice_no'		=> $invocieNumber
									, 'dated'				=> date('Y-m-d')
									, 'id_company'			=> cleanvars($_POST['id_company'])
									, 'id_customer'			=> cleanvars($_POST['id_customer'])
									, 'id_ade'				=> cleanvars($_POST['id_ade'])
									, 'id_joborder'			=> cleanvars($_GET['id'])
									, 'total'				=> cleanvars($_POST['inV_grandtotal'])
									, 'paid'				=> cleanvars($_POST['advance'])
									, 'tax'					=> cleanvars(($_POST['inV_grandtotal'] * 0.16))
									, 'prev_balance'		=> cleanvars($_POST['customer_openingbalance'])
									, 'grand_total'			=> cleanvars($_POST['inV_receiveable'])
									, 'balance'				=> cleanvars($balance)
									, 'remarks'				=> cleanvars($_POST['remarks'])
								);

				//Execute Sales Insert Query
				$sqllmsSaleInsert  = $dblms->Insert(SALES_INVOICE , $dataInv);

			//If Sales Insert Query Executed
			if($sqllmsSaleInsert) {

				$idSales = $dblms->lastestid();
				
				// if($_POST['advance']>0) {	

				// 	// check if amount already added
				// 	$sqllmscheck  = $dblms->querylms("SELECT * 
				// 									FROM ".PAYMENTS."  
				// 									WHERE status = '1' AND id_user = '".cleanvars($_POST['id_customer'])."'
				// 									AND ledgerfor = '1'  AND debit_credit = '1'  AND docs_types = '7'
				// 									AND reference_no = ".cleanvars($_GET['id'])."");
				// 	// if(mysqli_num_rows($sqllmscheck)>0) { 

				// 	// 	$valuecheck = mysqli_fetch_array($sqllmscheck);

				// 	// 	// Insert Invoice amount in payments
				// 	// 	$dataInvamount = array(
				// 	// 							  'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
				// 	// 							, 'receipt_no'		=> cleanvars($_POST['deposit_slip'])
				// 	// 							, 'amount'			=> cleanvars($_POST['advance'])
				// 	// 							, 'pay_mode'		=> cleanvars($_POST['payment_method'])
				// 	// 							, 'id_account'		=> cleanvars($idaccount)
				// 	// 							, 'id_cat'			=> 1
				// 	// 							, 'remarks'			=> get_doctype(7)
				// 	// 							, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
				// 	// 							, 'date_modify'		=> date("Y-m-d H:i:s")
				// 	// 						);	
						
				// 	// 	$sqllmsUpdatepayment  = $dblms->Update(PAYMENTS , $dataInvamount , " WHERE id = '".cleanvars($valuecheck['id'])."'");
						
				// 	// } else {
				// 	// 	$systemslip 	= $mainclass->get_systemslipno(1,1);
						

				// 	// 	// Insert Invoice amount in payments
				// 	// 	$dataInvamount = array(
				// 	// 							  'status'			=> '1'
				// 	// 							, 'systemslip_no'	=> $systemslip
				// 	// 							, 'ledgerfor'		=> '1'
				// 	// 							, 'docs_types'		=> '7'
				// 	// 							, 'id_user'			=> cleanvars($_POST['id_customer'])
				// 	// 							, 'reference_no'	=> cleanvars($_GET['id'])
				// 	// 							, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))
				// 	// 							, 'receipt_no'		=> cleanvars($_POST['deposit_slip'])
				// 	// 							, 'amount'			=> cleanvars($_POST['advance'])
				// 	// 							, 'debit_credit'	=> '1'
				// 	// 							, 'pay_mode'		=> cleanvars($_POST['payment_method'])
				// 	// 							, 'id_account'		=> cleanvars($idaccount)
				// 	// 							, 'id_cat'			=> 1
				// 	// 							, 'remarks'			=> get_doctype(7)
				// 	// 							, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
				// 	// 							, 'date_added'		=> date("Y-m-d H:i:s")
				// 	// 						);
							
				// 	// 	$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
				// 	// }
					
				// } // end check advance Payment

				// // Insert Invoice amount in payments
				// $dataInvamount = array(
				// 						  'status'			=> '1'
				// 						, 'ledgerfor'		=> '1'
				// 						, 'docs_types'		=> '2'
				// 						, 'id_user'			=> cleanvars($_POST['id_customer'])
				// 						, 'reference_no'	=> cleanvars($idSales)
				// 						, 'dated'			=> date('Y-m-d', strtotime(cleanvars($dated)))
				// 						, 'amount'			=> cleanvars($_POST['inV_grandtotal'])
				// 						, 'debit_credit'	=> '2'
				// 						, 'remarks'			=> 'Sales Invoice'
				// 						, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
				// 						, 'date_added'		=> date("Y-m-d H:i:s")
				// 					);
					
				// $sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

				//Iterate over Items Array
				for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

					//Check if ID item is not empty
					if(!empty($_POST['id_item'][$ichk])) {

						$dataInvDetail = array(
												  'id_salesinvoice'		=> cleanvars($idSales)
												, 'id_company'			=> cleanvars($_POST['id_company'])
												, 'id_item'				=> cleanvars($_POST['id_item'][$ichk])
												, 'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])
												, 'discount'			=> cleanvars($_POST['discount_percentage'][$ichk])
												, 'qty'					=> cleanvars($_POST['total_qty'][$ichk])
												, 'total'				=> cleanvars($_POST['total_price'][$ichk])
											);

						$sqllmsInsertInvocieDetail  = $dblms->Insert(SALES_INVOICE_DETAILS , $dataInvDetail);
						unset($sqllmsInsertInvocieDetail);


						// Insert Stock detail
						$dataStck = array (
											  'id_item'			=>  cleanvars($_POST['id_item'][$ichk])
											, 'grn_date'		=> date('Y-m-d')
											, 'qty'				=> cleanvars($_POST['total_qty'][$ichk])
											, 'unitprice'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'stock_type'		=> 2
											, 'reference_no'	=> cleanvars($idSales)
											, 'reference_type'	=> 2
											, 'dated'			=> date('Y-m-d')
											, 'remarks'			=> 'Stock Out'
											, 'id_user'			=> cleanvars($_POST['id_customer'])
											, 'customer_vendorname'	=> cleanvars($_POST['customer_name'])
											, 'invoice_orderno'		=> cleanvars($invocieNumber)
											, 'view_path'			=> 'saleinvoiceprint.php?id='.$idSales.''
											, 'date_added'		=> date("Y-m-d H:i:s")
									);
						$sqllmsInsertStock  = $dblms->Insert(STOCK,$dataStck);
						// end Insert Stock detail
					}
				}
				// UPDATE SLAE INVOICE ID IN PAYMENT
				$dataPayment = array(
									  'reference_no'	=> $idSales
								  );

				//Execute Update Query
				$sqllmsUpdate  = $dblms->Update(PAYMENTS , $dataPayment , " WHERE reference_no = '".cleanvars($_GET['id'])."' AND id_user = '".cleanvars($_POST['id_customer'])."' AND ledgerfor = '1'");

				// UPDATE SLAE INVOICE AMOUNT IN PAYMENT
				$dataPaymentAmount = array(
									  'amount'			=> ($_POST['inV_grandtotal'] + $_POST['freight_charges'])
								  	);
				
				//Execute Update Query
				$sqllmsUpdateAmount  = $dblms->Update(PAYMENTS , $dataPaymentAmount , " WHERE reference_no = '".cleanvars($idSales)."' AND id_user = '".cleanvars($_POST['id_customer'])."' AND ledgerfor = '1' AND docs_types = '2'");
						
			}
				
			} // end check job order in invoice table
						
		}
		
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: sale-orders.php", true, 301);
		exit();
	
	}
}