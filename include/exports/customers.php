<?php 

	$sql2 = $_POST['querystring'];

//------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_status, '.CUSTOMERS.'.customer_name,
												'.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_email,
												'.CUSTOMERS.'.customer_address, '.CUSTOMERS.'.customer_contactperson,'.CUSTOMERS.'.customer_loginid, 
												'.CUSTOMERS.'.customer_personcell, '.CUSTOMERS.'.customer_personwhatsapp, '.CUSTOMERS.'.id_city, 
												'.CUSTOMERS.'.customer_openingbalance, '.CUSTOMERS.'.id_ade, '.CUSTOMERS.'.id_company, 
												'.ADES.'.ade_name, '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name, 
												'.CUSTOMERS.'.id_brand, '.CUSTOMERS.'.id_zone, '.CUSTOMERS.'.id_type',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'not_equal' => array( 
													''.CUSTOMERS.'.customer_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.CUSTOMERS.'.customer_id ASC ',
								'return_type' 	=> 'all' 
						); 
    $Customers 	= $dblms->getRows(CUSTOMERS, $conditions);

/** Include PHPExcel */
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';

// Create new PHPExcel object
//echo date('H:i:s').' Create new PHPExcel object'.EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s').' Set document properties'.EOL;
$objPHPExcel->getProperties()->setCreator('Maarten Balliauw')
							 ->setLastModifiedBy('Maarten Balliauw')
							 ->setTitle('PHPExcel Test Document')
							 ->setSubject('PHPExcel Test Document')
							 ->setDescription('Test document for PHPExcel, generated using PHP classes.')
							 ->setKeywords('office PHPExcel php')
							 ->setCategory('Test result file');

// Create the worksheet
//echo date('H:i:s').' Add data'.EOL;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', SITE_NAME);
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'List of Customers');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Sr.#')
                              ->setCellValue('B3', 'Customer Code')
                              ->setCellValue('C3', 'Customer Type')
                              ->setCellValue('D3', 'Customer Name')
                              ->setCellValue('E3', 'Organization Phone #')
                              ->setCellValue('F3', 'Email Address')
							  ->setCellValue('G3', 'Name of Contact Person')
							  ->setCellValue('H3', 'Whatsapp #')
							  ->setCellValue('I3', 'Address')
							  ->setCellValue('J3', 'Brand')
							  ->setCellValue('K3', 'Zone')
							  ->setCellValue('L3', 'ADE')
							  ->setCellValue('M3', 'Balance')
							  ->setCellValue('N3', 'Status');
$dataArray = array();


$srno = 0;
foreach($Customers as $row) {
//------------------------------------------------
	$srno++;
	if($row['id_brand']) { $bandname = get_brandnames($row['id_brand']); } else { $bandname = ''; }

// Get Payments detail

	$sumconditions = array ( 
								'select' 	=> "SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '1' 
													AND ".PAYMENTS.".debit_credit = '2' 
													then ".PAYMENTS.".amount end
												) as totalreceivables, 
												SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '1' 
													AND ".PAYMENTS.".debit_credit = '1' 
													then ".PAYMENTS.".amount end
												) as totalpaid",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.PAYMENTS.'.id_user' => cleanvars($row['customer_id']) 
												), 
								'return_type' 	=> 'single' 
							); 
    $rowsreceivables 	= $dblms->getRows(PAYMENTS, $sumconditions);
	$balance = ($rowsreceivables['totalreceivables']  - $rowsreceivables['totalpaid']);
//---------------------------------------------
	 $dataArray[] = array(	  $srno
	 						, $row['customer_code']
						  	, get_customertype($row['id_type'])
						  	, $row['customer_name']
						  	, $row['customer_cellno']
						  	, $row['customer_email']
						  	, $row['customer_contactperson']
						  	, $row['customer_personwhatsapp']
						  	, $row['customer_address']
						  	, $bandname
						  	, $row['company_name']
						  	, $row['ade_name']
						  	, number_format($balance)
							, get_admstatus1($row['customer_status'])	
						);
}
$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A4');

// Set title row bold
//echo date('H:i:s').' Set title row bold'.EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Set autofilter
//echo date('H:i:s').' Set autofilter'.EOL;
// Always include the complete filter range!
// Excel does support setting only the caption
// row, but that's not a best practise...
//$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
//$callStartTime = microtime(true);

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
//$callEndTime = microtime(true);
//$callTime = $callEndTime - $callStartTime;
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="customers-'.date('Y-m-d-H-i-s').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>