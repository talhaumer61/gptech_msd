<?php 
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 
//--------------------------------------------------
	$catconditions = array ( 
								  'select' 		=> 'cat_id'
								, 'not_equal' 	=> array( 
															'cat_id' => 0 
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'cat_name ASC'
								, 'return_type' => 'count' 
							); 
    $Category 	= $dblms->getRows(PAYMENTS_CATEGORY, $catconditions);

//--------------------------------------------------
	$count 		= ($Category);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------

if (($count) > 0) {
//--------------------------------------------------
	$catconditions = array ( 
								  'select' 		=> 'cat_id, cat_name, cat_status, cat_detail'
								, 'not_equal' 	=> array( 
														'cat_id' => 0 
													)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> 'cat_name ASC '
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
						); 
    $Category 	= $dblms->getRows(PAYMENTS_CATEGORY, $catconditions);
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
	<th style=""> Category Name</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
//------------------------------------------------
foreach($Category as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_admstatus($rowstd['cat_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="">'.$rowstd['cat_name'].'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;"> ';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1) { 
	if($rowstd['cat_id'] != 1) {
	echo  '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Item" data-height="350" data-width="100%" 
		data-cat-id 		= 	"'.$rowstd['cat_id'].'"
		data-cat-name 		= 	"'.$rowstd['cat_name'].'"
		data-cat-status 	= 	"'.$rowstd['cat_status'].'"
		data-cat-detail 	= 	"'.$rowstd['cat_detail'].'"
		data-target="#editCountryModal">
			<i class="icon-pencil"></i>
		</a> ';
	}
}
echo '
		<a class="btn btn-xs btn-danger"> 
		<i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
	echo $Pagination->get_Paginator('paymentscategory.php', $count, $Limit, $lastpage, $page, $adjacents, $next, $prev, $sqlstring, $lpm1);
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
