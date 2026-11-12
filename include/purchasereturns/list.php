<?php 
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
			
	$conditions = array ( 
								'select' 	=> ''.PURCHASE_RETURNS.'.pr_id',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_RETURNS.".id_vendor",
								'not_equal' => array( 
													''.PURCHASE_RETURNS.'.pr_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PURCHASE_RETURNS.'.pr_id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Returns 	= $dblms->getRows(PURCHASE_RETURNS, $conditions);

										// b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
//--------------------------------------------------
	$count 		= ($Returns);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

										
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------	
	$conditions = array ( 
								'select' 		=> ''.PURCHASE_RETURNS.'.pr_id, '.PURCHASE_RETURNS.'.pr_no, '.PURCHASE_RETURNS.'.dated,
													'.PURCHASE_RETURNS.'.total, '.PURCHASE_RETURNS.'.advance, '.PURCHASE_RETURNS.'.pr_status,
													'.PURCHASE_RETURNS.'.balance, 
													'.PURCHASE_RETURNS.'.grand_total, '.VENDORS.'.vendor_name, '.VENDORS.'.vendor_cellno,
													'.PURCHASE_RETURNS.'.deducation_per, '.PURCHASE_RETURNS.'.deducation_amount',
								'join' 			=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_RETURNS.".id_vendor",
								'not_equal' 	=> array ( 
															''.PURCHASE_RETURNS.'.pr_id' => 0 
														 ), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PURCHASE_RETURNS.'.pr_id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Returns 	= $dblms->getRows(PURCHASE_RETURNS, $conditions);
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Ord.#</th>
	<th> Dated</th>
	<th> Vendor</th>
	<th style="text-align:center;">Total</th>
	<th style="text-align:center;">Ded. %</th>
	<th style="text-align:center;">Ded. Amount</th>
	<th style="text-align:center;">Grand Total</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:100px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
foreach($Returns as $rowstd) {
//------------------------------------------------
	$ctystatus = get_saletypes($rowstd['pr_status']);

	$orderdate = new DateTime($rowstd['dated']); 
//------------------------------------------------
	
//------------------------------------------------
echo '
<tr>
	<td style="width:80px;vertical-align:middle; text-align:center;">'.$rowstd['pr_no'].'</td>
	<td style="width:90px;vertical-align:middle;">'.$orderdate->format('d/m/Y').' </td>
	<td style="vertical-align:middle;">'.$rowstd['vendor_name'].' ('.($rowstd['vendor_cellno']).')</td>
	<td style="width:80px;vertical-align:middle; text-align:right;">'.number_format($rowstd['total']).'</td>
	<td style="width:70px;vertical-align:middle; text-align:center;">'.number_format($rowstd['deducation_per']).'</td>
	<td style="width:100px;vertical-align:middle; text-align:right;">'.number_format($rowstd['deducation_amount']).'</td>
	<td style="width:100px;vertical-align:middle; text-align:right;">'.number_format($rowstd['total']-$rowstd['deducation_amount']).'</td>
	<td style="width:70px;vertical-align:middle;">'.$ctystatus.'</td>
	<td style="text-align:center;vertical-align:middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'edit' => '1'))) { 
if($rowstd['pr_status'] != 3 || ($_SESSION['userlogininfo']['LOGINIDA'] == 2)) {
	echo '<a class="btn btn-xs btn-info" href="purchasereturns.php?id='.$rowstd['pr_id'].'"><i class="icon-pencil"></i></a> ';
}
	
}
echo '<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Purchase Return Detail</b>" data-src="purchasesreturnview.php?id='.$rowstd['pr_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
		<a class="btn btn-xs btn-information" href="purchasesreturnprint.php?id='.$rowstd['pr_id'].'" target="_blank"><i class="icon-print"></i></a> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '27', 'delete' => '1'))) { 
	echo '<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
}
echo '
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('salereturns.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
} // end if id not