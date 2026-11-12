<?php 
//Update Sale Invoice
if(isset($_POST['submit_changes'])) { 
	
	//Assign Job Order Status
	if($_POST['submit_changes'] == 'saveconfirmed'){

		$invoiceStatus = '3';

	} else{

		$invoiceStatus = '1';

	}

	$sqllmsOrder  	= $dblms->querylms("SELECT jo.total, jo.advance, inv.prev_balance, inv.balance, inv.id_customer
											FROM ".JOB_ORDER." jo
											INNER JOIN ".SALES_INVOICE." inv ON inv.salesinvoice_id = jo.job_order_id 
											WHERE jo.job_order_id = '".cleanvars($_POST['id_order'])."' LIMIT 1");
	$rowOrder 	= mysqli_fetch_array($sqllmsOrder);

	$grandTotal = ($rowOrder['prev_balance'] + $_POST['inV_grandtotal']);
	$balance 	= ($_POST['inV_grandtotal'] - $rowOrder['advance']);

	$dataInv = array(
		'salesinvoice_status'	=> cleanvars($invoiceStatus)								,
		'total'					=> cleanvars($_POST['inV_grandtotal'])						,
		'tax'					=> cleanvars(($_POST['inV_grandtotal'] * 0.16))				,
		'grand_total'			=> cleanvars($_POST['inV_grandtotal'])						,
		'balance'				=> cleanvars($balance)										,
		'remarks'				=> cleanvars($_POST['remarks'])
	);

	//Execute Update Query
	$qryUpdate = $dblms->Update(SALES_INVOICE, $dataInv, "WHERE salesinvoice_id = '".$_POST['salesinvoice_id']."'");

	//If Update Query Executed
	if($qryUpdate) { 

		// Update Invoice amount in payments
	$dataInvamount = array(
		'amount'			=> cleanvars($_POST['inV_grandtotal'])		,
		'remarks'			=> 'Sales Invoice'							,
		'id_modify'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
		'date_modify'		=> date("Y-m-d H:i:s")								
	);
	
	$qryUpdatePayment = $dblms->Update(PAYMENTS, $dataInvamount, " WHERE reference_no = '".$_POST['salesinvoice_id']."' AND docs_types = '2' AND debit_credit = '2'");

		//Delete Previous Sale Details
		$sqllmsDel  	= $dblms->querylms("DELETE FROM ".SALES_INVOICE_DETAILS." WHERE id_salesinvoice = '".cleanvars($_POST['salesinvoice_id'])."'");
		
		//Iterate over Items Array
		for($ichk=1; $ichk<=sizeof($_POST['item_id']); $ichk++){

			$dataInvDetail = array(
				'id_salesinvoice'		=> cleanvars($_POST['salesinvoice_id'])		, 
				'id_company'			=> cleanvars($_POST['id_company'])			, 
				'id_item'				=> cleanvars($_POST['item_id'][$ichk])		,
				'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])	,
				'qty'					=> cleanvars($_POST['qty'][$ichk])			,
				'total'					=> cleanvars($_POST['total_price'][$ichk])		
				
			);

			$sqllmsInsertDetail  = $dblms->Insert(SALES_INVOICE_DETAILS , $dataInvDetail);

			unset($sqllmsInsertDetail);

		}
		
// update Stock
if($_POST['submit_changes'] == 'saveconfirmed'){	
	for($istk=1; $istk<=sizeof($_POST['item_id']); $istk++){

		//Check if ID item is not empty
		if(!empty($_POST['qty'][$istk])>0) {
					
			$dataStck = array(
				'id_item'						=> cleanvars($_POST['item_id'][$istk])				,
				'qty'							=> cleanvars($_POST['qty'][$istk])					,
				'stock_type'					=> 2												,
				'reference_no'					=> cleanvars($_POST['salesinvoice_id'])				,
				'reference_type'				=> 2												,
				'dated'							=> date('Y-m-d')									,
				'remarks'						=> 'Stock Out'									 ,
				'id_added'						=> cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ,
				'date_added'					=> date("Y-m-d H:i:s")
			);

			$sqllmsInsertHistory  = $dblms->Insert(STOCK,$dataStck);

	
		}

	}

}

		//UPDATE Query Fields & Values
		$dataOrder = array(
			'job_order_status'	=> '3'						
		);

		//Execute Update Query
//		$sqllmsUpdateOrder  = $dblms->Update(JOB_ORDER , $dataOrder , " WHERE job_order_id = '".cleanvars($_POST['id_order'])."'");

		$remarks = 'Update Sales Invoice # : '.cleanvars($_POST['salesinvoice_no']).' details';

		$dataLog = array(
				'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])				, 
				'filename'		=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)			, 
				'action'		=> '2'																,
				'dated'			=> date("Y-m-d H:i:s")												,
				'ip'			=> cleanvars($ip)													,
				'remarks'		=> cleanvars($remarks)												,
				'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])							, 
				'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
		);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: sales-invoice.php", true, 301);
		exit();

	}

}

//Update Order Status to Dispatch
if(isset($_POST['sale_dispatch'])){

	//UPDATE Query Fields & Values
	$dataOrder = array(
		'salesinvoice_status'	=> '4'						
	);

	//Execute Update Query
	$sqllmsUpdateOrder  = $dblms->Update(SALES_INVOICE , $dataOrder , " WHERE salesinvoice_id = '".cleanvars($_POST['id_order'])."'");

	//If Update Query Executed
	if($sqllmsUpdateOrder) { 

	

		$remarks = 'Dispatched Order ID: '.cleanvars($_POST['id_order']).' details';

		$dataLog = array(
				'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])				, 
				'filename'		=> strstr(basename($_SERVER['REQUEST_URI']), '.php', true)			, 
				'action'		=> '2'																,
				'dated'			=> date("Y-m-d H:i:s")												,
				'ip'			=> cleanvars($ip)													,
				'remarks'		=> cleanvars($remarks)												,
				'id_office'		=> cleanvars($_SESSION['LOGINOFFICE_SSS'])							, 
				'id_company'	=> cleanvars($_SESSION['LOGINCOMPANY_SSS'])
		);
		$sqllmslog  = $dblms->Insert(LOGS , $dataLog);

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Order dispatched successfully.</div>';
		header("Location: sales-invoice.php", true, 301);
		exit();
	}
}