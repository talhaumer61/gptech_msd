<?php 

if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.id, b.status, b.id_account, b.pay_type, b.billno, b.dated, b.id_added, b.id_office, 
										b.slipno, b.amount, b.method, b.type, b.cheque, b.cheque_date, b.cheque_status, b.cheque_cleardate, 
										b.cheque_remarks, b.id_bank, b.remarks, b.id_company, b.date_added, c.customer_name, c.customer_cellno, 
										b.id_paid, ac.account_name     
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid   
										INNER JOIN ".ACCOUNTS." ac ON ac.account_id = b.id_account   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										AND b.pay_type = '1' ORDER BY b.slipno DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllms);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT b.id, b.status, b.id_account, b.pay_type, b.billno, b.dated, b.id_added, b.id_office, 
										b.slipno, b.amount, b.method, b.type, b.cheque, b.cheque_date, b.cheque_status, b.cheque_cleardate, 
										b.cheque_remarks, b.id_bank, b.remarks, b.id_company, b.date_added, c.customer_name, c.customer_cellno, 
										b.id_paid, ac.account_name     
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid   
										INNER JOIN ".ACCOUNTS." ac ON ac.account_id = b.id_account   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										AND b.pay_type = '1' ORDER BY b.slipno DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th style="text-align:center;"> Dated</th>
	<th style="text-align:center;"> Slip #</th>
	<th> Customer Name</th>
	<th> Account</th>
	<th style="text-align:center;"> Amount</th>
	<th> Method</th>
	<th style="text-align:center;"> Type</th>
	<th> Received by:</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
$srno++;
$orderdate = new DateTime($rowstd['dated']); 

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
<tr>
	<td style="width:40px;vertical-align:middle; text-align:center;">'.$srno.'</td>
	<td style="width:80px;vertical-align:middle;">'.$orderdate->format('d/m/Y').'</td>
	<td style="width:60px;vertical-align:middle; text-align:center;">'.$rowstd['slipno'].'</td>
	<td style="vertical-align:middle;">'.$rowstd['customer_name'].' '.$rowstd['customer_cellno'].'</td>
	<td style="width:100px;vertical-align:middle;">'.$rowstd['account_name'].'</td>
	<td style="text-align:right;vertical-align:middle; width:80px;">'.number_format($rowstd['amount']).'</td>
	<td style="width:80px; vertical-align:middle;text-align:center;">'.get_paytypes($rowstd['method']).'</td>
	<td style="width:100px;vertical-align:middle; text-align:center;">'.get_pptypes($rowstd['type']).'</td>
	<td style="width:120px;vertical-align:middle;">'.$addedby.'</td>
	<td style="text-align:center;vertical-align:middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'edit' => '1'))) {
	echo '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-dated="'.$rowstd['dated'].'" data-com-account="'.$rowstd['id_account'].'" data-com-paid="'.$rowstd['id_paid'].'" data-com-slipno="'.$rowstd['slipno'].'" data-com-amount="'.$rowstd['amount'].'" data-com-method="'.$rowstd['method'].'"  data-com-ptype="'.$rowstd['type'].'" data-com-cheque="'.$rowstd['cheque'].'" data-com-chequedate="'.$rowstd['cheque_date'].'" data-com-bank="'.$rowstd['id_bank'].'" data-com-remarks="'.$rowstd['remarks'].'" data-com-id="'.$rowstd['id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
}
echo ' <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Payment Receipt #: '.$rowstd['slipno'].'  Detail</b>" data-src="receiptview.php?id='.$rowstd['id'].'" href="#"><i class="icon-zoom-out"></i></a> 
	<a class="btn btn-xs btn-info" href="receiptprint.php?id='.$rowstd['id'].'" target="_blank"><i class="icon-print"></i></a> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '4', 'delete' => '1'))) { 
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="customerpayments.php?id='.$rowstd['id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a> ';
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
	$pagination.= '<li><a href="customerpayments.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customerpayments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {

				$pagination.= '<li><a href="customerpayments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="customerpayments.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="customerpayments.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="customerpayments.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="customerpayments.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="customerpayments.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customerpayments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="customerpayments.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="customerpayments.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="customerpayments.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="customerpayments.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="customerpayments.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customerpayments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="customerpayments.php?page='.$next.$sqlstring.'">Next</a></li>';
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