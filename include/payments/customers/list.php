<?php 
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	
//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.PAYMENTS.'.id',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													  ''.PAYMENTS.'.ledgerfor' 	=> 1
													, ''.PAYMENTS.'.debit_credit' => 1 
												), 
								'search_by' 	=> $sql2,
								'not_in' 		=> " AND ".PAYMENTS.".docs_types NOT IN(3,6)",
								'order_by' 		=> ''.PAYMENTS.'.id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Payments 	= $dblms->getRows(PAYMENTS, $conditions);

//--------------------------------------------------
	$count 		= ($Payments);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> '*',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													''.PAYMENTS.'.ledgerfor' 	=> 1, 
													''.PAYMENTS.'.debit_credit' => 1 
												), 
								'search_by' 	=> $sql2,
								'not_in' 		=> " AND ".PAYMENTS.".docs_types NOT IN(3,6)",
								'order_by' 		=> ''.PAYMENTS.'.id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Payments 	= $dblms->getRows(PAYMENTS, $conditions);
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style=" text-align:center;"> Sr.#</th>
	<th style=" text-align:center;"> Dated</th>
	<th style=" text-align:center;"> System Slip #</th>
	<th style=" text-align:center;"> Receipt #</th>
	<th> Customer Name</th>
	<th style="text-align:center;"> Amount</th>
	<th style=" text-align:center;">Method</th>
	<th style=" text-align:center;">Slip</th>
	<th style=" text-align:center;">Added Date</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
//------------------------------------------------
foreach($Payments as $rowstd) {
//------------------------------------------------
$srno++;
$orderdate = new DateTime($rowstd['dated']); 
//------------------------------------------------
	if($rowstd['attachment']) {
		$dispatchslip =  '<a class="btn btn-xs btn-info" href="uploads/customerreceipts/'.$rowstd['attachment'].'" target="_blank"> View Slip </a>';
	} else {
		$dispatchslip =  '';
	}
    $bankname = '';
    if($rowstd['pay_mode'] == 1){
        $bankname .= '<div style="font-size: 10px;text-align:left; color: #888;">'.get_bankAccounts($rowstd['id_account']).'</div>';
    }
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center; vertical-align: middle;">'.$srno.'</td>
	<td style="width:80px; text-align:center;vertical-align: middle;">'.$orderdate->format('d/m/Y').'</td>
	<td style="width:100px; text-align:center;vertical-align: middle;">'.$rowstd['systemslip_no'].'</td>
	<td style="width:80px; text-align:center;vertical-align: middle;">'.$rowstd['receipt_no'].'</td>
	<td style="vertical-align: middle;">'.$rowstd['customer_name'].' '.$rowstd['customer_cellno'].'</td>	
	<td style="text-align:right;width:80px;vertical-align: middle;">'.number_format($rowstd['amount']).'</td>
	<td style="width:120px;text-align:center;vertical-align: middle;">'.get_paytypes($rowstd['pay_mode']). $bankname.'</td>
	<td style="text-align:center;width:80px;vertical-align: middle;">'.$dispatchslip.'</td>
	<td style="text-align:center;width:100px;vertical-align: middle;color: #888; font-size: 12px;">'.date('Y-m-d h:i:s', strtotime(cleanvars($rowstd['date_added']))).'</td>
	<td style="text-align:center;vertical-align: middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'edit' => '1'))) { 
	if($rowstd['docs_types'] == 12) {
		echo '<a class="btn btn-xs btn-info edit-creditnote-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-name="'.$rowstd['customer_code'].' - '.$rowstd['customer_name'].'" data-com-cellno="'.$rowstd['customer_cellno'].'" data-com-amount="'.$rowstd['amount'].'" data-com-pmode="'.$rowstd['pay_mode'].'" data-com-receipt="'.$rowstd['receipt_no'].'" data-com-date="'.$rowstd['dated'].'" data-com-reference="'.$rowstd['reference_no'].'" data-com-idcat="'.$rowstd['id_cat'].'" data-com-id="'.$rowstd['id'].'" data-target="#editCreditNoteModal"><i class="icon-pencil"></i></a> ';
	} else {
		echo '<a class="btn btn-xs btn-info" href=customerpayments.php?id='.$rowstd['id'].'><i class="icon-pencil"></i></a> ';	
	}
	
}
echo '<a class="btn btn-xs btn-information" href="customerpaymentprint.php?slipid='.$rowstd['systemslip_no'].'" target="_blank"><i class="icon-print"></i></a> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'delete' => '1'))) { 
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
	echo $Pagination->get_Paginator('customerpayments.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
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