<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> 'id'
							, 'where' 		=> array( 
														'is_deleted' => 0 
													)
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> 'id DESC'
							, 'return_type' => 'count' 
						); 
    $Stocks 	= $dblms->getRows(STOCKS_TAKING, $conditions);

//--------------------------------------------------
	$count 		   = ($Stocks);
	$NumberOfPages = ceil($count/$Limit);
	
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
						 	 'select' 		=> '*'
							,'where' 		=> array( 
													'is_deleted' => 0 
												) 
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> 'id DESC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						); 
    $Stocks 	= $dblms->getRows(STOCKS_TAKING, $conditions);
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
	<th style="text-align:center;">DG #</th>
	<th style="text-align:center;">Dated </th>
	<th>Taking By </th>
	<th style="text-align:center;">System Stock </th>
	<th style="text-align:center;">Physically Stock </th>
	<th style="text-align:center;">Difference</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Stocks as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_complete($rowstd['status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$rowstd['id'].'</td>
	<td style="text-align:center; width:90px;">'.$rowstd['taking_no'].'</td>
	<td style="width:90px;">'.$rowstd['taking_date'].' </td>
	<td >'.$rowstd['taking_by'].' </td>
	<td style="text-align:left;width:120px;">'.number_format($rowstd['total_systemstock']).' ('.number_format($rowstd['total_systemstockamount']).')</td>
	<td style="text-align:left;width:120px;">'.number_format($rowstd['total_physicallystock']).' ('.number_format($rowstd['total_physicallyamount']).')</td>
	<td style="text-align:left;width:120px;">'.number_format($rowstd['total_systemstock'] - $rowstd['total_physicallystock']).' ('.number_format($rowstd['total_systemstockamount'] - $rowstd['total_physicallyamount']).')</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Dontion / Gift Order Detail</b>" data-src="stockstakingview.php?id='.$rowstd['id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '29', 'edit' => '1'))) { 
	
	if($rowstd['status'] != 1 || ($_SESSION['userlogininfo']['LOGINIDA']  == 2)) {
		echo '<a class="btn btn-xs btn-info" href="stockstaking.php?id='.$rowstd['id'].'">
				<i class="icon-pencil"></i>
			</a>';
	}
}
echo '
		<a class="btn btn-xs btn-info" href="stockstakingprint.php?id='.$rowstd['id'].'" target="_blank"><i class="icon-print"></i></a>
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
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="stockstaking.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="stockstaking.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="stockstaking.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
} 
	echo $Nav;
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
