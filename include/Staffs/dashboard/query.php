<?php 
	//Job Order
	$joconditions = array ( 
								'select' 		=> "COUNT(".JOB_ORDER.".job_order_id) AS Totalorders, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'where' 		=> array( 
															''.JOB_ORDER.'.is_deleted'	=> 0
														), 
								'not_equal' 	=> array( 
															''.JOB_ORDER.'.job_order_id' => 0 
														), 
								'return_type' 	=> 'single' 
							); 
    $valueorders 	= $dblms->getRows(JOB_ORDER, $joconditions);

	//Sale Invoices
	$Invsconditions = array ( 
								'select' 		=> "COUNT(".SALES_INVOICE.".salesinvoice_id) AS totalInvoices, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '3' then 1 end) as totalConfirmed, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '1' then 1 end) as totalPending, 
													COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '5' then 1 end) as totalCompleted",
								'join' 			=> "INNER JOIN ".JOB_ORDER."  ON ".JOB_ORDER.".job_order_id = ".SALES_INVOICE.".id_joborder  
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".SALES_INVOICE.".id_customer",
								'not_equal' 	=> array( 
															''.SALES_INVOICE.'.salesinvoice_id' => 0 
														), 
								'return_type' 	=> 'single' 
							); 
    $valueinvoices 	= $dblms->getRows(SALES_INVOICE, $Invsconditions);

 	//Stock
	$Stocksconditions = array ( 
								'select' 		=> "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as AllStockIn, 
													SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as AllStockOUT ",
								'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCK.".id_item",
								'not_equal' 	=> array( 
															''.STOCK.'.id' => 0 
														), 
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut = $dblms->getRows(STOCK, $Stocksconditions);


	//Re-Order Items
	$reorderconditions = array ( 
								'select' 		=> "".ITEMS.".item_reorder, (SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) - SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end)) AS balance",
								'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".STOCK.".id_item",
								'where' 		=> array( 
															''.ITEMS.'.item_status' => 1
														), 
								'group_by' 		=> ''.STOCK.'.id_item',
								'having' 		=> ' balance < '.ITEMS.'.item_reorder',
								'return_type' 	=> 'count' 
							); 
    $StockReorders 	= $dblms->getRows(STOCK, $reorderconditions);

	// latest 20 Job Orders
	$ljoconditions = array ( 
								'select' 		=> ''.JOB_ORDER.'.job_order_id, '.JOB_ORDER.'.job_order_no, '.JOB_ORDER.'.dated, '.JOB_ORDER.'.total,
													'.JOB_ORDER.'.advance, '.JOB_ORDER.'.job_order_status, '.JOB_ORDER.'.opening_balance, 
													'.JOB_ORDER.'.id_ade, '.JOB_ORDER.'.id_company, '.JOB_ORDER.'.balance, '.JOB_ORDER.'.grand_total,
													'.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_cellno',
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".JOB_ORDER.".id_customer",
								'not_equal' 	=> array( 
															''.JOB_ORDER.'.job_order_id' => 0 
														), 
								'order_by' 		=> ''.JOB_ORDER.'.job_order_id DESC ',
								'limit' 		=> 20,
								'return_type' 	=> 'all' 
							); 
    $LatedstSalesOrders 	= $dblms->getRows(JOB_ORDER, $ljoconditions);


	// latest 20 Invoices
	$linconditions = array ( 
								'select' 		=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, '.SALES_INVOICE.'.grand_total, 
													'.SALES_INVOICE.'.paid, '.SALES_INVOICE.'.balance, '.SALES_INVOICE.'.dated, '.SALES_INVOICE.'.total, 
													'.SALES_INVOICE.'.prev_balance, '.SALES_INVOICE.'.salesinvoice_status, '.JOB_ORDER.'.job_order_id,
													'.JOB_ORDER.'.job_order_status, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.id_company, '.CUSTOMERS.'.customer_cellno, '.SALES_INVOICE.'.dispatch_status',
								'join' 			=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'not_equal' 	=> array( 
															''.SALES_INVOICE.'.salesinvoice_id' => 0 
														), 
								'order_by' 		=> ''.SALES_INVOICE.'.salesinvoice_id DESC ',
								'limit' 		=> 20,
								'return_type' 	=> 'all' 
							); 
    $LatestInvoices 	= $dblms->getRows(SALES_INVOICE, $linconditions);

	//Last 6 months Job Orders Stats
	$Mothlysconditions = array ( 
								'select' 		=> "COUNT(".JOB_ORDER.".job_order_id) as Total, date_format(".JOB_ORDER.".dated,'%M') as month,
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
													COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'not_equal' 	=> array ( 
															''.JOB_ORDER.'.job_order_id' => 0 
														), 
								'group_by' 		=> 'YEAR('.JOB_ORDER.'.dated),MONTH('.JOB_ORDER.'.dated)',
								'order_by' 		=> 'YEAR('.JOB_ORDER.'.dated) DESC,MONTH('.JOB_ORDER.'.dated) DESC',
								'limit' 		=> 6,
								'return_type' 	=> 'all' 
							); 
    $Mothlyorders = $dblms->getRows(JOB_ORDER, $Mothlysconditions);
