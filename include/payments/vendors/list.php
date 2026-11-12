<?php 
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	
//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.PAYMENTS.'.id',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													  ''.PAYMENTS.'.ledgerfor' 		=> 2 
													, ''.PAYMENTS.'.debit_credit' 	=> 2 
												), 
								'search_by' 	=> $sql2." AND ".PAYMENTS.".docs_types IN(1,7)",
								'order_by' 		=> ''.PAYMENTS.'.dated DESC ',
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
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													  ''.PAYMENTS.'.ledgerfor' 		=> 2 
													, ''.PAYMENTS.'.debit_credit' 	=> 2 
												), 
								'search_by' 	=> $sql2." AND ".PAYMENTS.".docs_types IN(1,7)",
								'order_by' 		=> ''.PAYMENTS.'.dated DESC ',
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
	<th style=" text-align:left;"> Receipt #</th>
	<th> Vendor Name</th>
	<th style="text-align:center;"> Amount</th>
	<th style=" text-align:center;">Method</th>
	<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
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

		/*$systemslip 	= $mainclass->get_systemslipno(2,2);
	
		$dataupload = array (
							  	'systemslip_no'	=> $systemslip
							);

	//Execute Update Query
		$sqllmsupload  = $dblms->Update(PAYMENTS , $dataupload , " WHERE id = '".$rowstd['id']."'");*/
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td style="width:80px; text-align:center;">'.$orderdate->format('d/m/Y').'</td>
	<td style="width:100px; text-align:center;">'.$rowstd['systemslip_no'].'</td>
	<td style="width:150px; text-align:left;">'.$rowstd['receipt_no'].'</td>
	<td>'.$rowstd['vendor_name'].' '.$rowstd['vendor_cellno'].'</td>	
	<td style="text-align:right;width:80px;">'.number_format($rowstd['amount']).'</td>
	<td style="width:90px;text-align:center;">'.get_paytypes($rowstd['pay_mode']).'</td>
	<td style="text-align:center;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '6', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-vendors="'.$rowstd['vendor_name'].' '.$rowstd['vendor_cellno'].'"  data-com-dated="'.$rowstd['dated'].'" data-com-paid="'.$rowstd['id_user'].'" data-com-receiptno="'.$rowstd['receipt_no'].'" data-com-amount="'.number_format($rowstd['amount']).'" data-com-method="'.$rowstd['pay_mode'].'"  data-com-referenceno="'.$rowstd['reference_no'].'" data-com-bank="'.$rowstd['id_bank'].'" data-com-remarks="'.$rowstd['remarks'].'" data-com-id="'.$rowstd['id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
}
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
	echo $Pagination->get_Paginator('vendorpayments.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}