<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['grn'])) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> ''.STOCK.'.id'
							, 'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id = ".STOCK.".reference_no 
												INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor"
							, 'where' 		=> array( 
													  ''.STOCK.'.stock_type' 	=> 1 
													, ''.STOCK.'.reference_type' => 1 
												)
							, 'search_by' 	=> $sql2
							, 'group_by' 	=> ''.STOCK.'.grn_id '
							, 'order_by' 	=> ''.STOCK.'.grn_date DESC '
							, 'return_type' => 'count' 
					 ); 
    $Stocks 	= $dblms->getRows(STOCK, $conditions);
//--------------------------------------------------
	$count 		= ($Stocks);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

//--------------------------------------------------
if (($Stocks) > 0) {
	
	$conditions = array ( 
							  'select' 		=> ''.STOCK.'.id, '.PURCHASE_ORDER.'.po_order_no, '.PURCHASE_ORDER.'.purchase_order_id, 
												'.STOCK.'.grn, '.STOCK.'.grn_date, '.STOCK.'.grn_id, SUM('.STOCK.'.qty) AS totalQTY,  
												SUM('.STOCK.'.unitprice * '.STOCK.'.qty) AS totalAmt, '.VENDORS.'.vendor_name, '.VENDORS.'.vendor_cellno'
							, 'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id = ".STOCK.".reference_no 
												INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor"
							, 'where' 		=> array( 
													  ''.STOCK.'.stock_type' 		=> 1
													, ''.STOCK.'.reference_type' 	=> 1 
												) 
							, 'search_by' 	=> $sql2
							, 'group_by' 	=> ''.STOCK.'.grn_id '
							, 'order_by' 	=> ''.STOCK.'.grn_date DESC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						); 
    $Stocks 	= $dblms->getRows(STOCK, $conditions);
//------------------------------------------------
echo '
	<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
		Total Records: ('.number_format($count).')
	</div>
	<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th style="text-align:center;">GRN</th>
	<th style="text-align:center;">Dated </th>
	<th style="text-align:left;">Vendor Name </th>
	<th style="text-align:left;">Vendor Cell </th>
	<th style="text-align:center;">PO #</th>
	<th style="text-align:center;">QTY Received</th>
	<th style="text-align:center;">QTY AMNT</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
//------------------------------------------------
foreach($Stocks as $rowstd) {
	
/*//------------------------------------------------
// Get Payments detail

	$recconditions = array ( 
								  'select' 		=> "SUM(qty) AS totalReceived"
								, 'where' 		=> array( 
															  'grn_id' 			=> cleanvars($rowstd['grn_id'])
															, 'stock_type' 		=> 1
															, 'reference_type' 	=> 1 
														)
								, 'return_type' => 'single' 
							); 
    $rowsReceived 	= $dblms->getRows(STOCK, $recconditions);	*/
	
//------------------------------------------------
	$srno++;
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['grn'].'</td>
	<td style="width:85px;">'.$rowstd['grn_date'].' </td>
	<td>'.$rowstd['vendor_name'].' </td>
	<td >'.$rowstd['vendor_cellno'].' </td>
	<td style="text-align:center;width:90px;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Purchase Order Detail</b>" data-src="purchaseorderview.php?id='.$rowstd['purchase_order_id'].'" href="#" style="font-weight:600;"> '.($rowstd['po_order_no']).'</a></td>
	<td style="text-align:center;width:100px;font-weight:600; font-size:14px; color:#00f;">'.number_format($rowstd['totalQTY']).'</td>
	<td style="text-align:center;width:100px;font-weight:600; font-size:14px; color:#00f;">'.number_format($rowstd['totalAmt']).'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Goods Received Note Detail</b>" data-src="stocksreceivesview.php?grn='.$rowstd['grn_id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="stocksreceives.php?grn='.$rowstd['grn_id'].'">
			<i class="icon-pencil"></i>
		</a> ';
}
echo '<a class="btn btn-xs btn-information" href="stocksreceivesprint.php?grn='.$rowstd['grn_id'].'" target="_blank"><i class="icon-print"></i></a>
		<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('stocksreceives.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);

//------------------------------------------------
	} else { 
//------------------------------------------------
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';
//------------------------------------------------
	}
}
