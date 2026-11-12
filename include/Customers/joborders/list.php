<?php 
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$conditions = array ( 
								'select' 		=> ''.JOB_ORDER.'.job_order_id',
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".JOB_ORDER.".id_customer",
								'where' 		=> array( 
													''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.JOB_ORDER.'.job_order_id DESC ',
								'return_type' 	=> 'count' 
							); 
    $SalesOrders 	= $dblms->getRows(JOB_ORDER, $conditions);

//--------------------------------------------------
	$count 		= ($SalesOrders);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
								
//--------------------------------------------------
if (($count) > 0) {
//------------------------------------------------
		$conditions = array ( 
								'select' 		=> ''.JOB_ORDER.'.job_order_id, '.JOB_ORDER.'.job_order_no, '.JOB_ORDER.'.dated, '.JOB_ORDER.'.total,
													'.JOB_ORDER.'.advance, '.JOB_ORDER.'.job_order_status, '.JOB_ORDER.'.opening_balance, 
													'.JOB_ORDER.'.id_ade, '.JOB_ORDER.'.id_company, '.JOB_ORDER.'.balance, '.JOB_ORDER.'.grand_total,
													'.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_cellno',
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".JOB_ORDER.".id_customer",
								'where' 		=> array( 
														''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
														), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.JOB_ORDER.'.job_order_id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $SalesOrders 	= $dblms->getRows(JOB_ORDER, $conditions);
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr#</th>
	<th style="text-align:center;"> Ord.#</th>
	<th> Dated</th>
	<th> Customer</th>
	<th style="text-align:center;">Order Total</th>
	<th style="text-align:center;">Prv Balance</th>
	<th style="text-align:center;"> Paid</th>
	<th style="text-align:center;"> Balance</th>
	<th style="text-align:center;"> Invoice #</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	$srno =0;
//------------------------------------------------
foreach($SalesOrders as $rowstd) {
//------------------------------------------------
	$ctystatus = get_orders($rowstd['job_order_status']);
//------------------------------------------------
	$Invconditions = array ( 
								'select' 		=> 'salesinvoice_id, salesinvoice_no',
								'where' 		=> array( 
															'id_joborder' => cleanvars($rowstd['job_order_id']) 
														), 
								'group_by' 		=> 'id_joborder',
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowbills 	= $dblms->getRows(SALES_INVOICE, $Invconditions);

	if (!empty($rowbills)) {

		$invoiceno = '<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Invoice: '.$rowbills['salesinvoice_no'].' Details</b>" data-src="saleinvoicview.php?id='.$rowbills['salesinvoice_id'].'" href="#"> '.$rowbills['salesinvoice_no'].' </a>';
	} else { 
		$invoiceno = '';
	}
	$orderdate = new DateTime($rowstd['dated']); 
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;vertical-align:middle; text-align:center;">'.$rowstd['job_order_id'].'</td>
	<td style="width:80px;vertical-align:middle; text-align:center;">'.$rowstd['job_order_no'].'</td>
	<td style="width:90px;vertical-align:middle;">'.$orderdate->format('d/m/Y').' </td>
	<td style="vertical-align:middle;">'.$rowstd['customer_name'].' ('.($rowstd['customer_cellno']).')</td>
	<td style="width:100px;vertical-align:middle; text-align:right;">'.number_format($rowstd['total']).'</td>
	<td style="width:100px;vertical-align:middle; text-align:right;">'.number_format($rowstd['opening_balance']).'</td>
	<td style="width:80px;vertical-align:middle; text-align:right;">'.number_format($rowstd['advance']).'</td>
	<td style="width:80px;vertical-align:middle; text-align:right;">'.number_format($rowstd['grand_total'] - $rowstd['advance']).'</td>
	<td style="width:80px;vertical-align:middle; text-align:center;">'.$invoiceno.'</td>
	<td style="width:70px;vertical-align:middle;text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;vertical-align:middle;">';
//--------------------------------------------

	/*if($rowstd['job_order_status'] == 1) {
		echo '<a class="btn btn-xs btn-info" href="sale-orders.php?id='.$rowstd['job_order_id'].'"><i class="icon-pencil"></i></a> ';
	}*/
	
echo '<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Job Order Detail</b>" data-src="orderview.php?id='.$rowstd['job_order_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
 
		<a class="btn btn-xs btn-information" href="ordersprint.php?id='.$rowstd['job_order_id'].'" target="_blank"><i class="icon-print"></i></a> ';
//--------------------------------------------

	

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
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
//--------------------------------------------------
$pagination = "";

if($lastpage > 1) {	
//previous button
if ($page > 1) {
	$pagination.= '<li><a href="sale-orders.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sale-orders.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="sale-orders.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="sale-orders.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="sale-orders.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="sale-orders.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="sale-orders.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="sale-orders.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sale-orders.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="sale-orders.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="sale-orders.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="sale-orders.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="sale-orders.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="sale-orders.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sale-orders.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="sale-orders.php?page='.$next.$sqlstring.'">Next</a></li>';
} else {
	$pagination.= "";
}
	echo $pagination;
}

echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
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