<?php 


//------------------Job Orders------------------------------

	$joconditions = array ( 
								'select' 		=> "COUNT(".JOB_ORDER.".job_order_id) AS Totalorders, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'where' 		=> array( 
															''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
														), 
								'return_type' 	=> 'single' 
							); 
    $valueorders 	= $dblms->getRows(JOB_ORDER, $joconditions);



//------------------Sale Invoices------------------------------
	$Invsconditions = array ( 
								'select' 		=> "COUNT(".SALES_INVOICE.".salesinvoice_id) AS totalInvoices, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '3' then 1 end) as totalConfirmed, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '1' then 1 end) as totalPending, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '5' then 1 end) as totalCompleted",
								'join' 			=> "INNER JOIN ".JOB_ORDER."  ON ".JOB_ORDER.".job_order_id = ".SALES_INVOICE.".id_joborder  
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".SALES_INVOICE.".id_customer",
								'where' 		=> array( 
															''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
														), 
								'return_type' 	=> 'single' 
							); 
    $valueinvoices 	= $dblms->getRows(SALES_INVOICE, $Invsconditions);


//------------------MY Ledger------------------------------
	$receivablesconditions = array ( 
								'select' 		=> "".CUSTOMERS.".customer_id, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
													SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 		=> array( 
														  ''.PAYMENTS.'.status' => 1 
														, ''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
														), 
								'return_type' 	=> 'single' 
							); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $receivablesconditions);


//Last 6 months Job Orders Stats

	$Mothlysconditions = array ( 
								'select' 	=> "COUNT(".JOB_ORDER.".job_order_id) as Total, date_format(".JOB_ORDER.".dated,'%M') as month,
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'where' 	=> array( 
														''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
													), 
								'group_by' 	=> 'YEAR('.JOB_ORDER.'.dated),MONTH('.JOB_ORDER.'.dated)',
								'order_by' 	=> 'YEAR('.JOB_ORDER.'.dated) DESC,MONTH('.JOB_ORDER.'.dated) DESC',
								'limit' 	=> 6,
								'return_type' 	=> 'all' 
							); 
    $Mothlyorders = $dblms->getRows(JOB_ORDER, $Mothlysconditions);
