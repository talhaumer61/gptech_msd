<?php 

	$sql2 = $_POST['querystring'];

//------------------------------------------------
	$vendorconditions = array ( 
								'select' 	=> 'vendor_id, vendor_status, vendor_name, vendor_cellno, vendor_contactperson, 
												vendor_email, vendor_openingbalance, vendor_address, vendor_personcell, 
												vendor_personwhatsapp',
								'not_equal' => array( 
														'vendor_id' => 0 
													), 
								'search_by' 	=> $sql2,
								'order_by' 		=> 'vendor_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Vendors 	= $dblms->getRows(VENDORS, $vendorconditions);

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
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'List of Vendors');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Sr.#')
                              ->setCellValue('B3', 'Vendor Name')
                              ->setCellValue('C3', 'Contact Person')
                              ->setCellValue('D3', 'Cell #')
                              ->setCellValue('E3', 'Email Address')
                              ->setCellValue('F3', 'Whatsapp #')
							  ->setCellValue('G3', 'Address')
							  ->setCellValue('H3', 'Balance')
							  ->setCellValue('I3', 'Status');
$dataArray = array();


$srno = 0;
foreach($Vendors as $row) {
//------------------------------------------------
	$srno++;

// Get Payments detail

	$sumconditions = array ( 
								'select' 	=> "SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '2' 
													AND ".PAYMENTS.".debit_credit = '1' 
													then ".PAYMENTS.".amount end
												) as totalpayable, 
												SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '2' 
													AND ".PAYMENTS.".debit_credit = '2' 
													then ".PAYMENTS.".amount end
												) as totalpaid",
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id = ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.PAYMENTS.'.id_user' => cleanvars($row['vendor_id']) 
												), 
								'return_type' 	=> 'single' 
							); 
    $rowspayable 	= $dblms->getRows(PAYMENTS, $sumconditions);
	
	$balance = ($rowspayable['totalpayable']  - $rowspayable['totalpaid']);
//---------------------------------------------
	 $dataArray[] = array(	  $srno
	 						, $row['vendor_name']
						  	, $row['vendor_contactperson']
						  	, $row['vendor_personcell']
						  	, $row['vendor_email']
						  	, $row['vendor_personwhatsapp']					  	
						  	, $row['vendor_address']
						  	, number_format($balance)
							, get_admstatus1($row['vendor_status'])	
						);
}
$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A4');

// Set title row bold
//echo date('H:i:s').' Set title row bold'.EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');

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
header('Content-Disposition: attachment;filename="vendors-'.date('Y-m-d-H-i-s').'.xlsx"');
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