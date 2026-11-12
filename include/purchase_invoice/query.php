<?php 
//Add Purchase Invoice
if(isset($_POST['submit_purchase_invoice'])) { 

	$sqllmsOrder  = $dblms->querylms("SELECT i.invoice_balance
											FROM ".PURCHASE_INVOICE." i  
											WHERE i.id_po = '".$_POST['id_po']."'
											ORDER BY i.purchaseinvoice_id DESC LIMIT 1");
	if(mysqli_num_rows($sqllmsOrder) == 1){

		$rowOrder = mysqli_fetch_array($sqllmsOrder);

		$invoiceTotal = $rowOrder['invoice_balance'];

	} else {

		$sqllmsPurchaseOrder  = $dblms->querylms("SELECT i.purchase_order_id, i.po_order_no, i.advance, i.balance, i.grand_total
													FROM ".PURCHASE_ORDER." i  
													WHERE i.purchase_order_id = '".$_POST['id_po']."' 
													LIMIT 1");
		$rowPurchaseOrder = mysqli_fetch_array($sqllmsPurchaseOrder);
		$invoiceTotal = $rowPurchaseOrder['balance'];

	}
	
	$balance = $invoiceTotal - $_POST['invoice_paid'];

	$dataInv = array(
		'purchaseinvoice_status'=> '1'														, 
		'purchaseinvoice_no'	=> cleanvars($_POST['purchaseinvoice_no'])					, 
		'dated'					=> cleanvars($_POST['dated'])								, 
		'id_vendor'				=> cleanvars($_POST['id_vendor'])							,
		'id_po'					=> cleanvars($_POST['id_po'])								,
		'invoice_total'			=> cleanvars($invoiceTotal)									,
		'invoice_paid'			=> cleanvars($_POST['invoice_paid'])						,
		'invoice_tax'			=> cleanvars($_POST['tax'])									,
		'paid_method'			=> cleanvars($_POST['payment_method'])						,
		'id_account'			=> cleanvars($_POST['id_account'])							,
		'deposit_slip'			=> cleanvars($_POST['deposit_slip'])						,
		'invoice_grand'			=> cleanvars($invoiceTotal)									,
		'invoice_balance'		=> cleanvars($balance)										,
		'remarks'				=> cleanvars($_POST['remarks'])								, 
	);
	
	$sqllms  = $dblms->Insert(PURCHASE_INVOICE , $dataInv);

	if($sqllms) { 

		$remarks = 'Add Purchase Invoice # : '.cleanvars($_POST['salesinvoice_no']).' details';
		
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

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	}
}

//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
	$balance = $_POST['inV_grandtotal'] - $_POST['paid']; 
	$dataInv = array(
		'purchaseinvoice_status'=> cleanvars($_POST['purchaseinvoice_status'])						, 
		'purchaseinvoice_no'	=> cleanvars($_POST['purchaseinvoice_no'])							, 
		'dated'					=> cleanvars($_POST['po_dated'])									, 
		'id_company'			=> cleanvars($_POST['id_company'])									,
		'id_vendor'				=> cleanvars($_POST['id_vendor'])									,
		'id_po'					=> cleanvars($_POST['id_po'])										,
		'invoice_total'			=> cleanvars($_POST['inV_grandtotal'])								,
		'invoice_paid'			=> cleanvars($_POST['invoice_paid'])								,
		'invoice_tax'			=> cleanvars($_POST['tax'])											,
		'invoice_grand'			=> cleanvars($_POST['inV_grandtotal'])								,
		'invoice_balance'		=> cleanvars($balance)												,
		'remarks'				=> cleanvars($_POST['remarks'])										, 
	);
	// $sqllms  = $dblms->Insert(SALES_INVOICE , $dataInv);
	$qryUpdate = $dblms->Update(PURCHASE_INVOICE, $dataInv, "WHERE purchaseinvoice_id = '".$_POST['purchaseinvoice_id']."'");


//--------------------------------------
	if($qryUpdate) { 
//--------------------------------------
		//--------------------------------------
		$latest_id = ($_POST['purchaseinvoice_id']);
		//--------------------------------------
		$arraychecked = $_POST['id_item'];
		//--------------------------------------
		$sqllmsdel  	= $dblms->querylms("DELETE FROM ".PURCHASE_INVOICE_DETAILS." 
												WHERE id_purchaseinvoice = '".cleanvars($latest_id)."'");
		//--------------------------------------
		for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
			$dataInvDetail = array(
				'id_purchaseinvoice'	=> cleanvars($latest_id)					, 
				'id_company'			=> cleanvars($_POST['id_company'])			, 
				'id_item'				=> cleanvars($_POST['id_item'][$ichk])		,
				'unit_price'			=> cleanvars($_POST['unit_price'][$ichk])	,
				'qty'					=> cleanvars($_POST['qty'][$ichk])			,
				'total'					=> cleanvars($_POST['total_price'][$ichk])			
			);
			$sqllmsdet  = $dblms->Insert(PURCHASE_INVOICE_DETAILS , $dataInvDetail);

			unset($sqllmsdet);
		}
//--------------------------------------
		// If Purchase Invoice is Set to Paid then the Stock will add to the table and the history will be saved 
		if(cleanvars($_POST['purchaseinvoice_status']) == '1'){
			for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
				if(!empty($_POST['id_item'][$ichk]) ){
					$dataHistory = array(
						'id_item'						=> cleanvars($_POST['id_item'][$ichk])				,
						'qty'							=> cleanvars($_POST['qty'][$ichk])					,
						'unit_price'					=> cleanvars($_POST['unit_price'][$ichk])			,
						'transaction_type'				=> '2'												,
						'transaction_date'				=> cleanvars($_POST['dated'])						,
						'id_order'						=> cleanvars($latest_id)							,
						'id_company'					=> cleanvars($_POST['id_company'])					,
						'id_vendor'						=> cleanvars($_POST['id_vendor'])					,
						'id_user'						=> cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
					);
					$sqllmsdet  = $dblms->Insert(STOCK_HISTORY , $dataHistory);	
					unset($sqllmsdet);
					$sqlStock = $dblms->querylms("SELECT stock_id , id_item, stock_available FROM ".STOCK."
													WHERE id_item = '".cleanvars($_POST['id_item'][$ichk])."'
													AND id_company = '".cleanvars($_POST['id_company'])."' LIMIT 1");
					if(mysqli_num_rows($sqlStock) > 0){
						$rowStock = mysqli_fetch_assoc($sqlStock);
						$latest_stock = $rowStock['stock_available'] + $_POST['qty'][$ichk];
						$stckID = $rowStock['stock_id'];
						$dataStck = array(
							'id_item'						=> cleanvars($_POST['id_item'][$ichk])				,
							'stock_available'				=> cleanvars($latest_stock)							,
							'id_company'					=> cleanvars($_POST['id_company'])					,
							'last_transaction'				=> date("Y-m-d H:i:s")								,
						);
						$qryStck = $dblms->Update(STOCK, $dataStck, "WHERE stock_id = '".cleanvars($stckID)."'");

						unset($rowStock);
						unset($stckID);

					}else {
						$latest_stock = $_POST['qty'][$ichk];
						$dataStck = array(
							'id_item'						=> cleanvars($_POST['id_item'][$ichk])				,
							'stock_available'				=> cleanvars($latest_stock)							,
							'id_company'					=> cleanvars($_POST['id_company'])					,
							'last_transaction'				=> date("Y-m-d H:i:s")								,
						);
						$qryStck = $dblms->Insert(STOCK, $dataStck);
					}
					unset($latest_stock);
					unset($dataStck);
					unset($qryStck);
					unset($sqlStock);	
				} //End if !empty
			}//ENd for loop
		}//End if status paid
//--------------------------------------
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
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
//--------------------------------------
	}
//--------------------------------------
}
