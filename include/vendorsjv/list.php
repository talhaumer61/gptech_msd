<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	//--------------------------------------------------
	$conditions = array ( 
								  'select' 		=> 'id'
								, 'where' 		=> array( 
															  'is_deleted'  => 0
															, 'jv_type'     => 2
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'id DESC '
								, 'return_type' => 'count' 
						); 
    $Dontions 	= $dblms->getRows(JOURANALVOUCHERS, $conditions);

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
							  'select' 		=> '*'
							, 'where' 		=> array( 
														  'is_deleted' => 0
                                                        , 'jv_type'    => 2
													)
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> 'id DESC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						); 
    $Dontions 	= $dblms->getRows(JOURANALVOUCHERS, $conditions);
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
	<th style="text-align:center;">JV #</th>
	<th style="text-align:center;">Dated </th>
	<th>Detail </th>
	<th style="text-align:center;">Total Credits</th>
	<th style="text-align:center;">Total Debits</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Dontions as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_saletypes($rowstd['status']);
echo '
<tr>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$rowstd['id'].'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.$rowstd['jv_no'].'</td>
	<td style="width:90px;vertical-align: middle;">'.$rowstd['dated'].' </td>
	<td style="vertical-align: middle;">'.$rowstd['jv_details'].' </td>
	<td style="text-align:right;width:100px;vertical-align: middle;">'.number_format($rowstd['totalcredits']).'</td>
	<td style="text-align:right;width:100px;vertical-align: middle;">'.number_format($rowstd['totaldebits']).'</td>
	<td style="text-align:center; width:60px;vertical-align: middle;">'.$ctystatus.'</td>
	<td style="text-align:center;vertical-align: middle;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Vendor Journal Voucher</b>" data-src="vendorsjvsview.php?id='.$rowstd['id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '36', 'edit' => '1'))) { 
	
	
	if($rowstd['status'] != 3 || ($_SESSION['userlogininfo']['LOGINIDA']  == 2)) {
		echo '<a class="btn btn-xs btn-info" href="vendorsjv.php?id='.$rowstd['id'].'">
				<i class="icon-pencil"></i>
			</a>';
	}
}
echo '
		<a class="btn btn-xs btn-information" href="vendorsjvprint.php?id='.$rowstd['id'].'" target="_blank"><i class="icon-print"></i></a>
		<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('vendorsjv.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
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
