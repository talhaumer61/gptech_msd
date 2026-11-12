<?php 
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.invoice_id, b.invoice_no, b.invoice_advance, b.invoice_dated, b.id_office, b.id_added, b.invoice_total,
										b.invoice_gsttotal, b.invoice_ntntotal, b.invoice_grand, c.customer_name, c.customer_cellno   
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY b.invoice_id DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllms);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.invoice_id, b.invoice_no, b.invoice_advance, b.invoice_dated, b.id_office, b.id_added, b.invoice_total,
										b.invoice_gsttotal, b.invoice_ntntotal, b.invoice_grand, c.customer_name, c.customer_cellno  
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY b.invoice_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered">
<thead>
<tr>
	<th> Invoice #</th>
	<th> Dated</th>
	<th> Customer</th>
	<th style="text-align:center;"> Total</th>
	<th style="text-align:center;"> GST </th>
	<th style="text-align:center;"> NTN </th>
	<th style="text-align:center;"> Advance </th>
	<th style="text-align:center;"> Grand Total</th>
	<th style="text-align:left;">Made by</th>
	<th style="width:110px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	//$ctystatus = get_payments($rowstd['invoice_status']);
//------------------------------------------------
$invsdate = new DateTime($rowstd['invoice_dated']); 
//------------------------------------------------
if($rowstd['invoice_advance']) { 
	$advance = number_format($rowstd['invoice_advance']);
} else { 
	$advance = '';
}
//------------------------------------------------
	$sqllmsledger  = $dblms->querylms("SELECT id_invpay FROM ".CUSTOMERS_LEDGER." 
													WHERE id_invpay = '".cleanvars($rowstd['invoice_id'])."' 
													  	AND pay_type 	= '2' 
													  	AND doc_type 	= '5'  
													  	AND ledgerfor 	= '1' ");
if(mysqli_num_rows($sqllmsledger)>0) { 
	$bgcolor = ' ';
} else { 
	$bgcolor = ' style="background-color:#FC6;"';
}
//------------------------------------------------
	if($rowstd['id_added']) {
		$sqllmsadded = $dblms->querylms("SELECT adm_fullname FROM ".ADMINS." WHERE adm_id = '".cleanvars($rowstd['id_added'])."' LIMIT 1 ");
		$valueadded	= mysqli_fetch_array($sqllmsadded);
		$addedby = $valueadded['adm_fullname'];
	} else { 
		$addedby = $valueadded['adm_fullname'];
	}
//------------------------------------------------
echo '
<tr '.$bgcolor.'>
	<td style="width:70px;vertical-align:middle; text-align:center;">'.$rowstd['invoice_no'].'</td>
	<td style="width:80px;vertical-align:middle;">'.$invsdate->format('d/m/Y').' </td>
	<td style="vertical-align:middle;">'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)</td>
	<td style="text-align:right;vertical-align:middle; width:70px;">'.number_format($rowstd['invoice_total']).'</td>
	<td style="text-align:right;vertical-align:middle; width:50px;">'.number_format($rowstd['invoice_gsttotal']).'</td>
	<td style="text-align:right;vertical-align:middle; width:50px;">'.number_format($rowstd['invoice_ntntotal']).'</td>
	<td style="text-align:right;vertical-align:middle; width:60px;">'.($advance).'</td>
	<td style="text-align:right;vertical-align:middle; width:90px;">'.number_format($rowstd['invoice_grand']).'</td>
	<td style="text-align:left;vertical-align:middle; width:120px;">'.$addedby.'</td>
	<td style="text-align:center;vertical-align:middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="invoices.php?id='.$rowstd['invoice_id'].'"><i class="icon-pencil"></i></a> ';
}
echo '
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Invoice #: '.$rowstd['invoice_id'].'  Detail</b>" data-src="invoiceview.php?id='.$rowstd['invoice_id'].'&addedby='.$addedby.'&office=" href="#"><i class="icon-zoom-out"></i></a> 
		<a class="btn btn-xs btn-purple" href="invoiceprint.php?view=letterhead&id='.$rowstd['invoice_id'].'" target="_blank"><i class="icon-print"></i></a> 
		<a class="btn btn-xs btn-info" href="invoiceprint.php?id='.$rowstd['invoice_id'].'" target="_blank"><i class="icon-print"></i></a> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'delete' => '1'))) {  
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="invoices.php?id='.$rowstd['invoice_id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a> ';
}
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
	$pagination.= '<li><a href="invoices.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="invoices.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="invoices.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="invoices.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="invoices.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="invoices.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="invoices.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="invoices.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="invoices.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="invoices.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="invoices.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="invoices.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="invoices.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="invoices.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="invoices.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="invoices.php?page='.$next.$sqlstring.'">Next</a></li>';
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