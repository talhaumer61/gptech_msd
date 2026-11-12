<?php 
//Add Purchase Order
if(isset($_POST['submit_order'])) { 

	//Check if order # already exist

	$conditions = array ( 
								'select' 		=> 'pr_id', 
								'where' 		=> array ( 
															'pr_no' => cleanvars($_POST['pr_no'])
														 ), 
								'return_type' 	=> 'count' 
							); 
    $rowchecked 	= $dblms->getRows(PURCHASE_RETURNS, $conditions);

	//If already order then show error and exit
	if($rowchecked>0) { 

		//Set Error MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Error: </span>Purchase Return: '.cleanvars($_POST['pr_no']).' already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else { 
		
		$conditions = array ( 
								'select' 		=> 'pr_id', 
								'order_by' 		=> ' pr_id DESC',
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
		$reultorder 	= $dblms->getRows(PURCHASE_RETURNS, $conditions);
		$countorder 	= $reultorder['pr_id'];
		
		if($countorder<9) {
			$orderno = 'PR-00000'.($countorder+1);
		} else if($countorder<99) {
			$orderno = 'PR-0000'.($countorder+1);
		} else if($countorder<999) {
			$orderno = 'PR-000'.($countorder+1);
		} else if($countorder<9999) {
			$orderno = 'PR-00'.($countorder+1);
		} else if($countorder<99999) {
			$orderno = 'PR-0'.($countorder+1);
		}else {
			$orderno = 'PR-'.($countorder+1);
		}

		//Remaining Amount
		$remainingAmount = $_POST['inV_grandtotal']; 
		$dated = date('Y-m-d', strtotime(cleanvars($_POST['dated'])));

		//Insert Query Fields & Values
		$dataInv = array (
							  'pr_status'			=> '2'
							, 'id_vendor'			=> cleanvars($_POST['id_vendor'])
							, 'pr_no'				=> cleanvars($orderno)
							, 'dated'				=> cleanvars($dated)
							, 'total'				=> cleanvars($_POST['inV_invoicetotal'])
							, 'deducation_per'		=> cleanvars($_POST['deducation_per'])
							, 'deducation_amount'	=> cleanvars($_POST['inV_deducation'])
							, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							, 'date_added'			=> date('Y-m-d h:i:s')
							, 'balance'				=> cleanvars($_POST['inV_receiveable'])
							, 'opening_balance'		=> cleanvars($_POST['customer_openingbalance'])
							, 'grand_total'			=> cleanvars($_POST['inV_grandtotal'])
						);

		//Execute Insert Query
		$sqllmsInsert  = $dblms->Insert(PURCHASE_RETURNS , $dataInv);

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
					$itemconditions = array ( 
												'select' 		=> 'id', 
												'where' 		=> array ( 
																			  'id_pr' 	=> cleanvars($idLatest)
																			, 'id_item' => cleanvars($_POST['id_item'][$ichk])
																		 ), 
												'return_type' 	=> 'count' 
											); 
    				$sqllmsitemchecker 	= $dblms->getRows(SALES_RETURNS_DETAILS, $itemconditions);

					if(($sqllmsitemchecker) == 0) {

						$JOgrandtotal = ($JOgrandtotal + $_POST['total_price'][$ichk]);

						$dataOrderDetail = array (
														  'id_pr'			=> cleanvars($idLatest)
														, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
														, 'deduction'		=> cleanvars($_POST['deducation_per'])
														, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
														, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
														, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])			
													);
						$sqllmsInsertDetail  = $dblms->Insert(PURCHASE_RETURNS_DETAILS , $dataOrderDetail);
					}

				}
			}
			
			$dataupdateInv = array(
									  'total'		=> cleanvars($JOgrandtotal)
									, 'grand_total'	=> cleanvars($JOgrandtotal + $_POST['vendor_openingbalance'])
								);

			$qryUpdate2nd = $dblms->Update(PURCHASE_RETURNS, $dataupdateInv, "WHERE pr_id = '".$idLatest."'");
	
			//Insert Log Remarks
			$remarks = 'Add Purchase Return Order: "'.cleanvars($_POST['pr_no']).'" Details';
			$dataLog = array (
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

			//Set Success MSG in Session & Exit
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
			header("Location: purchasereturns.php?printid=".$idLatest."", true, 301);
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
						  'pr_status'			=> $jobOrderStatus
						, 'total'				=> cleanvars($_POST['inV_invoicetotal'])
						, 'deducation_per'		=> cleanvars($_POST['deducation_per'])
						, 'deducation_amount'	=> cleanvars($_POST['inV_deducation'])
						, 'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
						, 'date_modified'		=> date('Y-m-d h:i:s')
						, 'balance'				=> cleanvars($balance)
						, 'grand_total'			=> cleanvars($_POST['inV_grandtotal'])
						, 'remarks'				=> cleanvars($_POST['remarks'])

	);

	//Execute Update Query
	$sqllmsUpdate  = $dblms->Update(PURCHASE_RETURNS , $dataOrder , " WHERE pr_id = '".cleanvars($_GET['id'])."'");

	//If Update Query Executed
	if($sqllmsUpdate) { 
		


		//Delete Previous Order Details
		$sqllmsDel  = $dblms->querylms("DELETE FROM ".PURCHASE_RETURNS_DETAILS." WHERE id_pr = '".cleanvars($_GET['id'])."'");

		//Iterate over Items Array
		for($ichk=1; $ichk<=sizeof($_POST['id_item']); $ichk++){
			
			//Check if ID item is not empty
			if(!empty($_POST['id_item'][$ichk])) { 
				$dataOrderDetail = array (
										  'id_pr'			=> cleanvars($_GET['id'])
										, 'id_item'			=> cleanvars($_POST['id_item'][$ichk])
										, 'deduction'		=> cleanvars($_POST['deducation_per'])
										, 'unit_price'		=> cleanvars($_POST['unit_price'][$ichk])
										, 'total_price'		=> cleanvars($_POST['total_price'][$ichk])
										, 'total_qty'		=> cleanvars($_POST['total_qty'][$ichk])			
									);
				$sqllmsInsertDetail  = $dblms->Insert(PURCHASE_RETURNS_DETAILS , $dataOrderDetail);

			}
		}

		//Insert Log Remarks
		$remarks = 'Update Purchase Return: "'.cleanvars($_POST['pr_no']).'" Details';
		$dataLog = array (
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
		
		//If Save & Forward then Add to Sales Invoice
if($_POST['bill_changes'] == 'saveconfirmed'){

	$sqllmspayment  	= $dblms->querylms("SELECT id  
												FROM ".PAYMENTS." 
												WHERE id_user 		= '".cleanvars($_POST['id_vendor'])."' 
												AND reference_no 	= '".cleanvars($_GET['id'])."' 
												AND docs_types 		= '8'
												AND ledgerfor 		= '2' 
												AND debit_credit	= '2' 
											");
	if(mysqli_num_rows($sqllmspayment)>0) { 
		$rowpayment = mysqli_fetch_array($sqllmspayment);
		$dataInvamount = array( 
			'amount'			=> cleanvars($_POST['inV_grandtotal'])		,
			'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
			'date_modify'		=> date("Y-m-d H:i:s")								
		);
		
		$sqllmsUpdateamount  = $dblms->Update(PAYMENTS , $dataInvamount , " WHERE id = '".cleanvars($rowpayment['id'])."'");
		
	} else {
			// Insert Invoice amount in payments
	$dataInvamount = array(
								  'status'			=> '1'
								, 'ledgerfor'		=> '2'
								, 'docs_types'		=> '8'
								, 'id_user'			=> cleanvars($_POST['id_vendor'])
								, 'reference_no'	=> cleanvars($_GET['id'])
								, 'dated'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
								, 'amount'			=> cleanvars($_POST['inV_grandtotal'])
								, 'debit_credit'	=> '2'
								, 'pay_mode'		=> '2'
								, 'remarks'			=> 'Purchase Return'
								, 'id_added'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
								, 'date_added'		=> date("Y-m-d H:i:s")
						);
		
		$sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);
	}
	//Delete Previous Order Details
		$sqllmsDelStock  = $dblms->querylms("DELETE FROM ".STOCK." 
													WHERE reference_no = '".cleanvars($_GET['id'])."' 
													AND reference_type = '8'
													AND stock_type = '2'");

	for($istk=1; $istk<=sizeof($_POST['id_item']); $istk++){

		//Check if ID item is not empty
		if(!empty($_POST['total_qty'][$istk])>0) {
					
			$dataStck = array(
								  'id_item'				=> cleanvars($_POST['id_item'][$istk])
								, 'grn_date'			=> date('Y-m-d', strtotime(cleanvars($_POST['dated'])))
								, 'qty'					=> cleanvars($_POST['total_qty'][$istk])
								, 'unitprice'			=> cleanvars($_POST['unit_price'][$istk])
								, 'stock_type'			=> 2
								, 'reference_no'		=> cleanvars($_GET['id'])
								, 'reference_type'		=> 8
								, 'dated'				=> date('Y-m-d')
								, 'remarks'				=> 'Purchase Stock Return'
								, 'id_user'				=> cleanvars($_POST['id_vendor'])
								, 'customer_vendorname'	=> cleanvars($_POST['vendor_name'])
								, 'invoice_orderno'		=> cleanvars($_POST['pr_no'])
								, 'view_path'			=> 'purchasesreturnprint.php?id='.$_GET['id'].''
								, 'id_added'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
								, 'date_added'			=> date("Y-m-d H:i:s")
							);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);

	
		}

	}
		
	}
		
		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: purchasereturns.php?printid=".$_GET['id']."", true, 301);
		exit();
	
	}
}