<?php 

	$sql2 = $_POST['querystring'];

//------------------------------------------------
	$itemconditions = array ( 
								  'select' 		=> ''.ITEMS.'.*, '.ITEMS_CAT.'.cat_name'
								, 'join' 		=> "INNER JOIN ".ITEMS_CAT." ON ".ITEMS_CAT.".cat_id = ".ITEMS.".id_cat"
								, 'where' 		=> array( 
															''.ITEMS.'.id_company' 	=> 0 
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> ''.ITEMS.'.item_status ASC, '.ITEMS.'.item_code ASC, '.ITEMS.'.item_name ASC'
								, 'return_type' => 'all' 
							); 
    $Items 	= $dblms->getRows(ITEMS, $itemconditions);

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
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'List of Items');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Sr.#')
                              ->setCellValue('B3', 'Item Code')
                              ->setCellValue('C3', 'Item Name')
                              ->setCellValue('D3', 'Category Name')
                              ->setCellValue('E3', 'Weight (KG)')
                              ->setCellValue('F3', 'Reorder Point')
                              ->setCellValue('G3', 'Max Quantity (upper limit)')
							  ->setCellValue('H3', 'Purchase Price')
							  ->setCellValue('I3', 'Sale Price')
							  ->setCellValue('J3', 'Dealership Rate')
							  ->setCellValue('K3', 'Retail Rate')
							  ->setCellValue('L3', 'Classes')
							  ->setCellValue('M3', 'CGS')
							  ->setCellValue('N3', 'Income for Department')
							  ->setCellValue('O3', 'Stock Available')
							  ->setCellValue('P3', 'Status');
$dataArray = array();


$srno = 0;
foreach($Items as $row) {
//------------------------------------------------
	$srno++;
	if($row['cgs']) { $cgsname = get_cgs($row['cgs']); } else { $cgsname = ''; }
	if($row['income_department']) { $incomefor = get_incomeFor($row['income_department']); } else { $incomefor = ''; }
// Get Stock detail

	$sumconditions = array ( 
								'select' 	=> "SUM(CASE WHEN stock_type = '1' then qty end) as totalStockIN, 
											 	SUM(CASE WHEN stock_type = '2' then qty end) as totalStockOut",
								'where' 	=> array( 
													'id_item' => cleanvars($row['item_id']) 
												), 
								'return_type' 	=> 'single' 
							); 
    $resulttotalInOut 	= $dblms->getRows(STOCK, $sumconditions);

	
	if($resulttotalInOut['totalStockIN'] - $resulttotalInOut['totalStockOut']) {
		$stockavaiable = ($resulttotalInOut['totalStockIN'] - $resulttotalInOut['totalStockOut']);
	} else {
		$stockavaiable = 0;
	}


//---------------------------------------------
	 $dataArray[] = array(	  $srno
	 						, $row['item_code']
	 						, $row['item_name']
						  	, $row['cat_name']
						  	, $row['item_weight']
						  	, $row['item_reorder']
						  	, $row['item_maxquantity']
						  	, $row['item_pricepurchase']
						  	, $row['item_pricesale']
						  	, $row['item_pricedealership']
						  	, $row['item_priceretail']
						  	, ''
						  	, $cgsname
						  	, $incomefor
						  	, $stockavaiable
							, get_admstatus1($row['item_status'])	
						);
}
$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A4');

// Set title row bold
//echo date('H:i:s').' Set title row bold'.EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:P2');

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
header('Content-Disposition: attachment;filename="items-'.date('Y-m-d-H-i-s').'.xlsx"');
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