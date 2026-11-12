<?php 


//------------------Job Orders------------------------------

	$joconditions = array ( 
								'select' 	=> "COUNT(".JOB_ORDER.".job_order_id) AS Totalorders, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'not_equal' => array( 
													''.JOB_ORDER.'.job_order_id' => 0 
												), 
								'return_type' 	=> 'single' 
							); 
    $valueorders 	= $dblms->getRows(JOB_ORDER, $joconditions);



//------------------Sale Invoices------------------------------
	$Invsconditions = array ( 
								'select' 	=> "COUNT(".SALES_INVOICE.".salesinvoice_id) AS totalInvoices, 
												COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '3' then 1 end) as totalConfirmed, 
												COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '1' then 1 end) as totalPending, 
												COUNT(CASE WHEN ".SALES_INVOICE.".salesinvoice_status = '5' then 1 end) as totalCompleted",
								'join' 		=> "INNER JOIN ".JOB_ORDER."  ON ".JOB_ORDER.".job_order_id = ".SALES_INVOICE.".id_joborder  
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".SALES_INVOICE.".id_customer",
								'not_equal' => array( 
													''.SALES_INVOICE.'.salesinvoice_id' => 0 
												), 
								'return_type' 	=> 'single' 
							); 
    $valueinvoices 	= $dblms->getRows(SALES_INVOICE, $Invsconditions);


//------------------Stock------------------------------
	$Stocksconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".STOCK.".stock_type = '1' then ".STOCK.".qty end) as AllStockIn, 
												SUM(CASE WHEN ".STOCK.".stock_type = '2' then ".STOCK.".qty end) as AllStockOUT ",
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCK.".id_item",
								'not_equal' => array( 
													''.STOCK.'.id' => 0 
												), 
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut = $dblms->getRows(STOCK, $Stocksconditions);


//Last 6 months Job Orders Stats

	$Mothlysconditions = array ( 
								'select' 	=> "COUNT(".JOB_ORDER.".job_order_id) as Total, date_format(".JOB_ORDER.".dated,'%M') as month,
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '4' then 1 end) as totalDispatched, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '2' then 1 end) as totalPending, 
												COUNT(CASE WHEN ".JOB_ORDER.".job_order_status = '1' then 1 end) as totalSaveHold ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".JOB_ORDER.".id_customer",
								'not_equal' => array( 
													''.JOB_ORDER.'.job_order_id' => 0 
												), 
								'group_by' 	=> 'YEAR('.JOB_ORDER.'.dated),MONTH('.JOB_ORDER.'.dated)',
								'order_by' 	=> 'YEAR('.JOB_ORDER.'.dated) DESC,MONTH('.JOB_ORDER.'.dated) DESC',
								'limit' 	=> 6,
								'return_type' 	=> 'all' 
							); 
    $Mothlyorders = $dblms->getRows(JOB_ORDER, $Mothlysconditions);
