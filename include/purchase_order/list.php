<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.PURCHASE_ORDER.'.purchase_order_id',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
								'not_equal' => array( 
													''.PURCHASE_ORDER.'.purchase_order_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PURCHASE_ORDER.'.purchase_order_id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Purchases 	= $dblms->getRows(PURCHASE_ORDER, $conditions);

//--------------------------------------------------
	$count 		= ($Purchases);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
	
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.PURCHASE_ORDER.'.purchase_order_id,'.PURCHASE_ORDER.'.po_order_no, 
												'.PURCHASE_ORDER.'.total, '.PURCHASE_ORDER.'.balance, '.PURCHASE_ORDER.'.dated,
												'.PURCHASE_ORDER.'.po_status, '.VENDORS.'.vendor_name, '.PURCHASE_ORDER.'.opening_balance,
												'.PURCHASE_ORDER.'.grand_total, '.PURCHASE_ORDER.'.advance',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
								'not_equal' => array( 
													''.PURCHASE_ORDER.'.purchase_order_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PURCHASE_ORDER.'.purchase_order_id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Purchases 	= $dblms->getRows(PURCHASE_ORDER, $conditions);
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
	<th style="text-align:center;">PO #</th>
	<th style="text-align:center;">Dated </th>
	<th>Vendor Name </th>
	<th style="text-align:center;">PO Total</th>
	<th style="text-align:center;">Prv Balance</th>
	<th style="text-align:center;">Advane</th>
	<th style="text-align:center;">Balance</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Purchases as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_complete($rowstd['po_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$rowstd['purchase_order_id'].'</td>
	<td style="text-align:center; width:80px;">'.$rowstd['po_order_no'].'</td>
	<td style="width:90px;">'.$rowstd['dated'].' </td>
	<td>'.$rowstd['vendor_name'].' </td>
	
	<td style="text-align:right;width:100px;">'.number_format($rowstd['total']).'</td>
	<td style="text-align:right;width:100px;">'.number_format($rowstd['opening_balance']).'</td>
	<td style="text-align:right;width:100px;">'.number_format($rowstd['advance']).'</td>
	<td style="text-align:right;width:100px;">'.number_format($rowstd['grand_total'] - $rowstd['advance']).'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Purchase Order Detail</b>" data-src="purchaseorderview.php?id='.$rowstd['purchase_order_id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) { 
	
	if($rowstd['po_status'] != 1 || ($_SESSION['userlogininfo']['LOGINIDA']  == 2)) {
		echo '<a class="btn btn-xs btn-info" href="purchase-order.php?id='.$rowstd['purchase_order_id'].'">
				<i class="icon-pencil"></i>
			</a>';
	}
}
echo '
		<a class="btn btn-xs btn-information" href="purchaseorderprint.php?id='.$rowstd['purchase_order_id'].'" target="_blank"><i class="icon-print"></i></a>
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
	echo $Pagination->get_Paginator('purchase-order.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
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
