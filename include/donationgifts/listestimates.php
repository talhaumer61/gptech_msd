<?php 
//------------------------------------------------
if(LMS_VIEW == 'estimates' && !isset($_GET['id']) && !isset($_GET['idestimate'])) {

//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	//--------------------------------------------------
	$conditions = array ( 
								  'select' 		=> 'd.pr_id'
                                , 'join' 		=> "LEFT JOIN ".CRS." c ON c.crs_id =  d.id_crs"
								, 'not_equal' 	=> array( 
																'd.pr_id' => 0
														)
								, 'search_by' 	=> " AND d.estimate_no != '' ".$sql2
								, 'order_by' 	=> 'd.pr_id DESC '
								, 'return_type' => 'count' 
						);
    $Dontions 	= $dblms->getRows(DONATIONGIFTS ." d" , $conditions);

//--------------------------------------------------
	$count 		= ($Dontions);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'd.pr_id, d.pr_no, d.total, d.customer_name, d.dated, d.pr_status, d.customer_cell,
												d.estimate_no, d.dispatch_status, d.customer_email, d.customer_address, d.id_crs, c.crs_name'
                            , 'join' 		=> "LEFT JOIN ".CRS." c ON c.crs_id =  d.id_crs"
                            , 'not_equal' 	=> array(
														'd.pr_id' => 0
													)
							, 'search_by' 	=> " AND d.estimate_no != '' ".$sql2
							, 'order_by' 	=> 'd.pr_id DESC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						);
    $Dontions 	= $dblms->getRows(DONATIONGIFTS ." d" , $conditions);
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
	<th style="text-align:center;">EST #</th>
	<th style="text-align:center;">Dated </th>
	<th>Customer Name </th>
	<th>Customer Cell </th>
	<th>Customer Address </th>
	<th>CRS </th>
	<th style="text-align:center;">Total</th>
	<th style="text-align:center;"> Status</th>
	<th style="text-align:center;"> DG #</th>
	<th style="width:80px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Dontions as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_saletypes($rowstd['pr_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$rowstd['pr_id'].'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.$rowstd['estimate_no'].'</td>
	<td style="width:90px;vertical-align: middle;">'.$rowstd['dated'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_name'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_cell'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['customer_address'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['crs_name'].' </td>
	<td style="text-align:right;width:100px;vertical-align: middle;">'.number_format($rowstd['total']).'</td>
	<td style="text-align:center; width:60px;vertical-align: middle;">'.$ctystatus.'</td>
	<td style="text-align:center; width:60px;vertical-align: middle;">';
	if($rowstd['pr_no']) {
		$joborder = '<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>>Dontion / Gift Order Detail</b>" data-src="donationgiftsview.php?id='.$rowstd['pr_id'].'" href="#">'.$rowstd['pr_no'].'</a>';
		$editbtn = ' ';
	} else {
		$joborder = '';
		$editbtn = '<a class="btn btn-xs btn-info" href="donationgifts.php?idestimate='.$rowstd['pr_id'].'"><i class="icon-pencil"></i></a>';
	}
	
	echo $joborder.'
	</td>
	<td style="text-align:center;vertical-align: middle;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Dontion / Gift Order Detail</b>" data-src="donationgiftsview.php?id='.$rowstd['pr_id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 
		echo $editbtn;
}
echo '
		<a class="btn btn-xs btn-information" href="donationgiftsestimateprint.php?id='.$rowstd['pr_id'].'" target="_blank"><i class="icon-print"></i></a>
		
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('donationgifts.php?view=estimates', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
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
