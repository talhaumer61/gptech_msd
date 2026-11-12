<?php 
//--------------------------------------
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
			
	$conditions = array ( 
								'select' 		=> ''.PAYMENTS_SCHEDULE.'.id',
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS_SCHEDULE.".id_user",
								'where' 		=> array( 
															  ''.PAYMENTS_SCHEDULE.'.user_type' => 1 
															, ''.PAYMENTS_SCHEDULE.'.is_deleted' => 0 
														), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PAYMENTS_SCHEDULE.'.id DESC ',
								'return_type' 	=> 'count' 
							); 
    $Returns 	= $dblms->getRows(PAYMENTS_SCHEDULE, $conditions);

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
								'select' 		=> ''.PAYMENTS_SCHEDULE.'.*, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.customer_cellno',
								'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS_SCHEDULE.".id_user",
								'where' 		=> array( 
															  ''.PAYMENTS_SCHEDULE.'.user_type' => 1 
															, ''.PAYMENTS_SCHEDULE.'.is_deleted' => 0 
														), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.PAYMENTS_SCHEDULE.'.id DESC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Returns 	= $dblms->getRows(PAYMENTS_SCHEDULE, $conditions);
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:red; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th> Dated</th>
	<th> Customer</th>
	<th style="text-align:center;">Grand Total</th>
	<th style="text-align:center;"> Installments</th>
	<th style="width:80px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	$srno = 0;
//------------------------------------------------
foreach($Returns as $rowstd) {
//------------------------------------------------
	$srno++;

	$orderdate = new DateTime($rowstd['date_added']); 
//------------------------------------------------
	
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;vertical-align:middle; text-align:center;">'.$srno.'</td>
	<td style="width:90px;vertical-align:middle;">'.$orderdate->format('d/m/Y').' </td>
	<td style="vertical-align:middle;">'.$rowstd['customer_name'].' ('.($rowstd['customer_cellno']).')</td>
	<td style="width:120px;vertical-align:middle; text-align:right;">'.number_format($rowstd['totalamount']).'</td>
	<td style="width:70px;vertical-align:middle; text-align:center;">'.number_format($rowstd['totalinsts']).'</td>
	<td style="text-align:center;vertical-align:middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '38', 'edit' => '1'))) { 

	echo '<a class="btn btn-xs btn-info" href="customerspaymentschedule.php?id='.$rowstd['id'].'"><i class="icon-pencil"></i></a> ';
	
}
echo '<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Customer Payment Schedule Detail</b>" data-src="customerspaymentscheduleview.php?id='.$rowstd['id'].'" href="#"><i class="icon-zoom-out"></i></a> 
		<!--a class="btn btn-xs btn-information" href="salesreturnprint.php?id='.$rowstd['id'].'" target="_blank"><i class="icon-print"></i></a--> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '38', 'delete' => '1'))) { 
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
	echo $Pagination->get_Paginator('customerspaymentschedule.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);

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