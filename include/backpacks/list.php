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
								  'select' 		=> ''.PACKAGES_DETAIL.'.id'
								, 'join' 		=> "INNER JOIN ".PACKAGES." ON ".PACKAGES.".package_id = ".PACKAGES_DETAIL.".id_package 
													INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PACKAGES_DETAIL.".id_item"
								, 'where' 		=> array( 
															  ''.PACKAGES.'.is_deleted' => 0 
														)
								, 'search_by' 	=> $sql2
								, 'group_by' 	=> ''.PACKAGES_DETAIL.'.id_package'
								, 'order_by' 	=> ''.PACKAGES.'.id_class ASC '
								, 'return_type' => 'count' 
						); 
    $Packages 	= $dblms->getRows(PACKAGES_DETAIL, $conditions);
//--------------------------------------------------
	$count 		= ($Packages);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
if (($count) > 0) {
//--------------------------------------------------
	$conditions = array ( 
								  'select' 		=> ''.PACKAGES.'.package_id, '.PACKAGES.'.package_status, '.PACKAGES.'.package_no, 
								  					'.PACKAGES.'.package_name, '.PACKAGES.'.package_detail, '.PACKAGES.'.id_brand, '.PACKAGES.'.id_class, 
													'.PACKAGES.'.package_items, '.PACKAGES.'.package_qty, SUM('.PACKAGES_DETAIL.'.qty * '.ITEMS.'.item_pricesale) as PackageTotal'
								, 'join' 		=> "INNER JOIN ".PACKAGES." ON ".PACKAGES.".package_id = ".PACKAGES_DETAIL.".id_package 
													INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PACKAGES_DETAIL.".id_item"
								, 'where' 		=> array( 
															''.PACKAGES.'.is_deleted' => 0 
														)
								, 'search_by' 	=> $sql2
								, 'group_by' 	=> ''.PACKAGES_DETAIL.'.id_package'
								, 'order_by' 	=> ''.PACKAGES.'.id_class ASC'
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
						); 
    $Packages 	= $dblms->getRows(PACKAGES_DETAIL, $conditions);
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
	<th style="text-align:center;">Backpack #</th>
	<th>Backpack Name </th>
	<th style="text-align:left;">Class</th>
	<th style="text-align:left;">Brand</th>
	<th style="text-align:center; width:100px;"> Total Items</th>
	<th style="text-align:center; width:100px;"> Total QTY</th>
	<th style="text-align:center; width:130px;"> Backpack Amount</th>
	<th style="text-align:center; width:60px;"> Status</th>
	<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Packages as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_admstatus($rowstd['package_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$srno.'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.$rowstd['package_no'].'</td>
	<td style="vertical-align: middle;">'.$rowstd['package_name'].' </td>
	<td style="width:150px;vertical-align: middle;">'.get_classnames($rowstd['id_class']).'</td>
	<td style="vertical-align: middle;">'.get_brandnames($rowstd['id_brand']).'</td>
	<td style="text-align:center;vertical-align: middle;">'.number_format($rowstd['package_items']).'</td>
	<td style="text-align:center;vertical-align: middle;">'.number_format($rowstd['package_qty']).'</td>
	<td style="text-align:center;vertical-align: middle;">'.number_format($rowstd['PackageTotal']).'</td>
	<td style="text-align:center; vertical-align: middle;">'.$ctystatus.'</td>
	<td style="text-align:center;vertical-align: middle;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Sale Package Detail</b>" data-src="backpacksview.php?id='.$rowstd['package_id'].'" href="#"><i class="icon-zoom-out"></i></a> ';
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '28', 'edit' => '1'))) { 
	
		echo '<a class="btn btn-xs btn-info" href="backpacks.php?id='.$rowstd['package_id'].'">
				<i class="icon-pencil"></i>
			</a>';
	
}
echo '
		<a class="btn btn-xs btn-information" href="backpacksprint.php?id='.$rowstd['package_id'].'" target="_blank"><i class="icon-print"></i></a>
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
	echo $Pagination->get_Paginator('backpacks.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
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
