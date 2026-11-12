<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$conditions = array ( 
								'select' 		=> ''.SALES_INVOICE.'.salesinvoice_id',
								'join' 			=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' 		=> array ( 
															''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
													 	), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.SALES_INVOICE.'.salesinvoice_id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Invoices 	= $dblms->getRows(SALES_INVOICE, $conditions);
//--------------------------------------------------
	$count 		= ($Invoices);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
if ($count > 0) {
//--------------------------------------------------
	$conditions = array ( 
								'select' 		=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, '.SALES_INVOICE.'.grand_total, 
													'.SALES_INVOICE.'.paid, '.SALES_INVOICE.'.balance, '.SALES_INVOICE.'.dated, '.SALES_INVOICE.'.total, 
													'.SALES_INVOICE.'.prev_balance, '.SALES_INVOICE.'.salesinvoice_status, '.JOB_ORDER.'.job_order_id,
													'.JOB_ORDER.'.job_order_status, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.id_company, '.CUSTOMERS.'.customer_cellno, '.SALES_INVOICE.'.dispatch_status',
								'join' 			=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' 		=> array ( 
															''.CUSTOMERS.'.customer_loginid' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) 
													 	), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.SALES_INVOICE.'.salesinvoice_id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Invoices 	= $dblms->getRows(SALES_INVOICE, $conditions);
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
	<th style="text-align:center;"> Invoice #</th>
	<th style="text-align:center;"> Dated </th>
	<th> Customer Name </th>
	<th style="text-align:center;"> INV. Total</th>
	<th style="text-align:center;"> Prv Balance</th>
	<th style="text-align:center;"> Advance</th>
	<th style="text-align:center;"> Balance</th>
	<th style="text-align:center;"> Status</th>
	<th style="text-align:center;"> Dispatch</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Invoices as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_saletypes($rowstd['salesinvoice_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$rowstd['salesinvoice_id'].'</td>
	<td style="text-align:center; width:90px;">'.$rowstd['salesinvoice_no'].'</td>
	<td style="width:90px;">'.$rowstd['dated'].' </td>
	<td>'.$rowstd['customer_name'].'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['total']).'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['prev_balance']).'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['paid']).'</td>
	<td style="width:100px;text-align:right;">'.number_format(($rowstd['total'] + $rowstd['prev_balance']) - $rowstd['paid']).'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center; width:80px;">';
	
	 	if($rowstd['dispatch_status'] == 1) {
			echo '<span class="btn btn-xs btn-purple">Dispatched</span>';
		} else {
			echo '';
		}
	
		echo '
	</td>
	<td style="text-align:center;">';

echo ' <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Invoice Detail</b>" data-src="saleinvoicview.php?id='.$rowstd['salesinvoice_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
		<a class="btn btn-xs btn-information" href="saleinvoiceprint.php?id='.$rowstd['salesinvoice_id'].'" target="_blank"><i class="icon-print"></i></a>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
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
	$pagination.= '<li><a href="sales-invoice.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sales-invoice.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="sales-invoice.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="sales-invoice.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="sales-invoice.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="sales-invoice.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="sales-invoice.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="sales-invoice.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sales-invoice.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="sales-invoice.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="sales-invoice.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="sales-invoice.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="sales-invoice.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="sales-invoice.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="sales-invoice.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="sales-invoice.php?page='.$next.$sqlstring.'">Next</a></li>';
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
}
