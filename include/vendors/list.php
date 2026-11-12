<?php 
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 
//--------------------------------------------------
	$vendorconditions = array ( 
								  'select' 		=> 'vendor_id'
								, 'not_equal' 	=> array( 
															'vendor_id' => 0 
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'vendor_name ASC'
								, 'return_type' => 'count' 
							); 
    $Vendors 	= $dblms->getRows(VENDORS, $vendorconditions);

//--------------------------------------------------
	$count 		= ($Vendors);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

//--------------------------------------------------
if (($count) > 0) {
	
//--------------------------------------------------
	$vendorconditions = array ( 
								  'select' 		=> 'vendor_id, vendor_status, vendor_name, vendor_cellno, vendor_contactperson, 
													vendor_email, vendor_openingbalance, vendor_address, vendor_personcell, 
													vendor_personwhatsapp'
								, 'not_equal' 	=> array( 
														'vendor_id' => 0 
													)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'vendor_name ASC'
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
							); 
    $Vendors 	= $dblms->getRows(VENDORS, $vendorconditions);
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
	<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
		Total Records: ('.number_format($count).') 
		<input type="hidden" name="type" value="vendors">
		<input type="hidden" name="querystring" value="'.$sql2.'">
		<button type="submit" class="btn btn-info">Export</button>
	</form>
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th> Vendor Name</th>
	<th> Phone</th>
	<th> Email</th>
	<th style="text-align:right;"> Opening Balance</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
$srno = 0;
$totalbalance = 0;
//------------------------------------------------
foreach($Vendors as $rowstd) {

$srno++;
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['vendor_status']);
	
// Get Stock detail

	$sumconditions = array ( 
								'select' 	=> "SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '2' 
													AND ".PAYMENTS.".debit_credit = '1' 
													then ".PAYMENTS.".amount end
												) as totalpayable, 
												SUM(
													CASE WHEN ".PAYMENTS.".ledgerfor = '2' 
													AND ".PAYMENTS.".debit_credit = '2' 
													then ".PAYMENTS.".amount end
												) as totalpaid",
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id = ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.PAYMENTS.'.id_user' => cleanvars($rowstd['vendor_id']) 
												), 
								'return_type' 	=> 'single' 
							); 
    $rowspayable 	= $dblms->getRows(PAYMENTS, $sumconditions);
	

	
	$balance = ($rowspayable['totalpayable']  - $rowspayable['totalpaid']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'edit' => '1'))) { 
	
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Vendor" data-height="350" data-width="100%" data-com-status="'.$rowstd['vendor_status'].'" data-com-name="'.$rowstd['vendor_name'].'" data-com-phone="'.$rowstd['vendor_cellno'].'" data-com-contactperson="'.$rowstd['vendor_contactperson'].'" data-com-email="'.$rowstd['vendor_email'].'" data-com-balance="'.$rowstd['vendor_openingbalance'].'" data-com-address="'.$rowstd['vendor_address'].'" data-com-personcell="'.$rowstd['vendor_personcell'].'"  data-com-personwhatsapp="'.$rowstd['vendor_personwhatsapp'].'" data-com-id="'.$rowstd['vendor_id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td style="min-width:200px;">'.$rowstd['vendor_name'].' </td>
	<td>'.$rowstd['vendor_cellno'].'</td>
	<td>'.$rowstd['vendor_email'].'</td>
	<td style="width:130px; text-align:right;">'.number_format($balance).'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '11', 'delete' => '1'))) { 	
	echo '<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
}
echo ' <a class="btn btn-xs btn-information" href="vendorledgerprint.php?id='.$rowstd['vendor_id'].'" target="_blank" title="Print Ledger"><i class="icon-print"></i></a>
	</td>
</tr>';
	$totalbalance = ($totalbalance + $balance);
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="4" style="text-align:right;"> Total Receiveable</th>
	<th style="text-align:right; font-size:16px;">'.number_format($totalbalance).'</th>
	<th style="text-align:right;"></th>
	<th style="text-align:right;"></th>
</tr>
</thead>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('vendors.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}