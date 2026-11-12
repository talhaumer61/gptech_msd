<?php 
//Add Purchase Order
if(isset($_POST['submit_order'])) { 

	//Check if order # already exist
	$sqllmschecked  = $dblms->querylms("SELECT job_order_no FROM ".SALES_RETURNS." WHERE job_order_no = '".cleanvars($_POST['job_order_no'])."' LIMIT 1");
	$rowchecked 	= mysqli_fetch_array($sqllmschecked);

	//If already order then show error and exit
	if($rowchecked['job_order_no']) { 

		//Set Error MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Sales Return: '.cleanvars($_POST['job_order_no']).' already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else { 

	$sqllmslastorder 	= $dblms->querylms("SELECT job_order_id FROM ".SALES_RETURNS." ORDER BY job_order_id DESC");
	$reultorder		 	= mysqli_fetch_array($sqllmslastorder);
	$countorder 		= $reultorder['job_order_id'];
		
	if($countorder<9) {
		$orderno = 'SR-00000'.($countorder+1);
	} else if($countorder<99) {
		$orderno = 'SR-0000'.($countorder+1);
	} else if($countorder<999) {
		$orderno = 'SR-000'.($countorder+1);
	} else if($countorder<9999) {
		$orderno = 'SR-00'.($countorder+1);
	} else if($countorder<99999) {
		$orderno = 'SR-0'.($countorder+1);
	}else {
		$orderno = 'SR-'.($countorder+1);
	}

		//Remaining Amount
		$remainingAmount = $_POST['inV_grandtotal']; 
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		//Insert Query Fields & Values
		$dataInv = array(
								  'job_order_id'		=> cleanvars($_POST['job_order_id'])
								, 'job_order_status'	=> '2'
								, 'id_ade'				=> cleanvars($_POST['id_ade'])
								, 'id_customer'			=> cleanvars($_POST['id_customer'])
								, 'job_order_no'		=> cleanvars($orderno)
								, 'dated'				=> cleanvars($dated)
								, 'total'				=> cleanvars($_POST['inV_invoicetotal'])
								, 'deducation_per'		=> cleanvars($_POST['deducation_per'])
								, 'deducation_amount'	=> cleanvars($_POST['inV_deducation'])
								, 'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))
								, 'paid_date'			=> date('Y-m-d')
								, 'id_company'			=> cleanvars($_POST['id_company'])
								, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'			=> date('Y-m-d h:i:s')
								, 'balance'				=> cleanvars($_POST['inV_receiveable'])
								, 'opening_balance'		=> cleanvars($_POST['customer_openingbalance'])
								, 'grand_total'			=> cleanvars($_POST['inV_grandtotal'])
								, 'remarks'				=> cleanvars($_POST['remarks'])
						);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(SALES_RETURNS , $dataInv);

		//If Insert Query Executed
		if($sqllmsInsert) { 

			//latest PK of Table
			$idLatest = $dblms->lastestid();
			
			$JOgrandtotal = 0;
			

			//Iterate over Items Array
			for($ichk=0; $ichk<sizeof($_POST['id_item']); $ichk++){

				//Check if ID item is not empty
				if(!empty($_POST['id_item'][$ichk])) {
///----------------------------------------------
		$sqllmsitemchecker  = $dblms->querylms("SELECT * FROM ".SALES_RETURNS_DETAILS."   
										WHERE  id_job_order = '".cleanvars($idLatest)."' AND id_item = '".cleanvars($_POST['id_item'][$ichk])."'");
		if(mysqli_num_rows($sqllmsitemchecker) == 0) {
			
			$JOgrandtotal = ($JOgrandtotal + $_POST['total_price'][$ichk]);

					$dataOrderDetail = array(
												  'id_job_order'	=> cleanvars($idLatest)
												, 'id_company'		=> cleanvars($_POST['id_company'])
												, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
												, 'deduction'		=> cleanvars($_POST['deducation_per'])
												, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
												, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
												, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])			
											);
					$sqllmsInsertDetail  = $dblms->Insert(SALES_RETURNS_DETAILS , $dataOrderDetail);

					unset($sqllmsInsertDetail);
		}

				}
			}
			
$dataupdateInv = array(
		'total'				=> cleanvars($JOgrandtotal)				,
		'grand_total'		=> cleanvars($JOgrandtotal + $_POST['customer_openingbalance'])
	);

	$qryUpdate2nd = $dblms->Update(SALES_RETURNS, $dataupdateInv, "WHERE job_order_id = '".$idLatest."'");
	
			//Insert Log Remarks
			$remarks = 'Add Sales Return Order: "'.cleanvars($_POST['job_order_no']).'" Details';
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
			header("Location: salereturns.php?printid=".$idLatest."", true, 301);
			exit();
		}

	}

}


//Update Purchase Order
if(isset($_POST['bill_changes'])) { 

	//Assign Job Order Status
	if($_POST['bill_changes'] == 'saveconfirmed'){

		$jobOrderStatus = '3';

	} else{

		$jobOrderStatus = '2';

	}

	$balance = $_POST['inV_receiveable']; 
	$dataOrder = array(
						  'job_order_status'	=> $jobOrderStatus
						, 'total'				=> cleanvars($_POST['inV_invoicetotal'])
						, 'deducation_per'		=> cleanvars($_POST['deducation_per'])
						, 'deducation_amount'	=> cleanvars($_POST['inV_deducation'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'sales_tax'			=> cleanvars(($_POST['inV_grandtotal'] * 0.16))
						, 'date_modified'		=> date('Y-m-d h:i:s')
						, 'balance'				=> cleanvars($balance)
						, 'grand_total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'remarks'				=> cleanvars($_POST['remarks'])
					);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(SALES_RETURNS , $dataOrder , " WHERE job_order_id = '".cleanvars($_GET['id'])."'");

	//If Update Query Executed
	if($sqllmsUpdate) { 
		


		//Delete Previous Order Details
		$sqllmsDel  = $dblms->querylms("DELETE FROM ".SALES_RETURNS_DETAILS." WHERE id_job_order = '".cleanvars($_GET['id'])."'");

		//Iterate over Items Array
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){
			
			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) {

				$dataOrderDetail = array(
											  'id_job_order'	=> cleanvars($_GET['id'])
											, 'id_company'		=> cleanvars($_POST['id_company'])
											, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
											, 'deduction'		=> cleanvars($_POST['deducation_per'])
											, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
											, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
											, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])
										);
				$sqllmsInsertDetail  = $dblms->Insert(SALES_RETURNS_DETAILS , $dataOrderDetail);
			
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
															'".cleanvars($remarks)."'									,
															'".cleanvars($_SESSION['userlogininfo']['LOGINOFFICE'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'			
															)
									");
	
		//If Save & Forward then Add to Sales Invoice
if($_POST['bill_changes'] == 'saveconfirmed'){

	$sqllmspayment  	= $dblms->querylms("SELECT id  
												FROM ".PAYMENTS." 
												WHERE id_user 		= '".cleanvars($_POST['id_customer'])."' 
												AND reference_no 	= '".cleanvars($_GET['id'])."' 
												AND docs_types 		= '3'
												AND ledgerfor 		= '1' 
												AND debit_credit	= '1' 
											");
	if(mysqli_num_rows($sqllmspayment)>0) { 
		$rowpayment = mysqli_fetch_array($sqllmspayment);
	$dataInvamount = array( 
								  'amount'			=> cleanvars($_POST['inV_grandtotal'])
								, 'id_modify'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_modify'		=> date("Y-m-d H:i:s")
						 );
		$sqllmsUpdateamount  = $dblms->Update(PAYMENTS , $dataInvamount , " WHERE id = '".cleanvars($rowpayment['id'])."'");
		
	} else {
			// Insert Invoice amount in payments
	$dataInvamount = array(
							  'status'			=> '1'
							, 'ledgerfor'		=> '1'
							, 'docs_types'		=> '3'
							, 'id_user'			=> cleanvars($_POST['id_customer'])
							, 'reference_no'	=> cleanvars($_GET['id'])
							, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
							, 'amount'			=> cleanvars($_POST['inV_grandtotal'])
							, 'debit_credit'	=> '1'
							, 'pay_mode'		=> '2'
							, 'remarks'			=> 'Sales Return'
							, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_added'		=> date("Y-m-d H:i:s")
						);
		
		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
	}
	//Delete Previous Order Details
		$sqllmsDelStock  = $dblms->querylms("DELETE FROM ".STOCK." 
													WHERE reference_no = '".cleanvars($_GET['id'])."' 
													AND reference_type = '3'
													AND stock_type = '1'");

for($istk=1; $istk<=sizeof($_POST['id_item']); $istk++){

		//Check if ID item is not empty
		if(!empty($_POST['total_qty'][$istk])>0) {
					
			$dataStck = array(
								  'id_item'				=> cleanvars($_POST['id_item'][$istk])
								, 'grn_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
								, 'qty'					=> cleanvars($_POST['total_qty'][$istk])
								, 'unitprice'			=> cleanvars($_POST['unit_price'][$istk])
								, 'stock_type'			=> 1
								, 'reference_no'		=> cleanvars($_GET['id'])
								, 'reference_type'		=> 3
								, 'dated'				=> date('Y-m-d')
								, 'remarks'				=> 'Stock Return'
								, 'id_user'				=> cleanvars($_POST['id_customer'])
								, 'customer_vendorname'	=> cleanvars($_POST['customer_name'])
								, 'invoice_orderno'		=> cleanvars($_POST['job_order_no'])
								, 'view_path'			=> 'salesreturnprint.php?id='.$_GET['id'].''
								, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'			=> date("Y-m-d H:i:s")
							);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);

	
		}

	}
		
			}
		
		
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: salereturns.php?printid=".$_GET['id']."", true, 301);
		exit();
	
	}
}