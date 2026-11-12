<?php 

// get all Items
	$Items	= $mainclass->get_items(1, $idcat);
// get all Customers
if($idcompany = 'all') {
    $Customers 	= $mainclass->get_customers(1, 0, 0);
} else {
	$Customers 	= $mainclass->get_customers(1, 0, $idcompany);
}

// Excel file name for download 
$fileName = "zonewiseitemsales-report_" . date('Y-m-d') . ".xls"; 
// Column names 
$fields = array('Sr #', 'Customer Name', 'Company Name');
foreach($Items as $listitem) {
	$fields[] = $listitem['item_code'].'-'.$listitem['item_name'];
}
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
$srno = 0;
foreach ($Customers as $listcusterm) {
	$srno++;
	$lineData = array($srno, "'".$listcusterm['customer_code'].'-'.$listcusterm['customer_name'], $listcusterm['company_name']); 
	foreach($Items as $listitem) {
		///----------------------------------------------
		$conditions = array ( 
								'select' 	=> "SUM(".SALES_INVOICE_DETAILS.".qty) as totalQty",
								'join' 		=> "INNER JOIN ".SALES_INVOICE." ON ".SALES_INVOICE.".salesinvoice_id =  ".SALES_INVOICE_DETAILS.".id_salesinvoice 
												INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' 	=> array( 
													  ''.SALES_INVOICE.'.id_customer' => cleanvars($listcusterm['customer_id']) 
													, ''.CUSTOMERS.'.customer_id' => cleanvars($listcusterm['customer_id'])  
													, ''.SALES_INVOICE_DETAILS.'.id_item' => cleanvars($listitem['item_id'])  
												), 
								'search_by' 	=> " AND ".SALES_INVOICE.".salesinvoice_status IN(3,5)  AND ".SALES_INVOICE.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) ",
								'return_type' 	=> 'single'
							); 
		$Sales 		= $dblms->getRows(SALES_INVOICE_DETAILS, $conditions);
		
		$lineData[] = $Sales['totalQty'];
		
		
	}
	array_walk($lineData, 'filterData'); 
	$excelData .= implode("\t", array_values($lineData)) . "\n"; 
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;