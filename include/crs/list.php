<?php 

//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//--------------------------------------------------
	$conditions = array ( 
								'select' 	    => ''.CRS.'.crs_id',
								'where'         => array(
													        ''.CRS.'.is_deleted' => 0
												        ),
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.CRS.'.crs_name ASC ',
								'return_type' 	=> 'count' 
							); 
    $Ades 	= $dblms->getRows(CRS, $conditions);
//------------------------------------------------

//--------------------------------------------------
	$count 		= ($Ades);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
if (($count) > 0) {
		
//--------------------------------------------------
	$conditions = array ( 
								'select' 	    => ''.CRS.'.*',
								'where'         => array(
													        ''.CRS.'.is_deleted' => 0
												        ),
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.CRS.'.crs_name ASC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Ades 	= $dblms->getRows(CRS, $conditions);
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr # </th>
	<th>  Name</th>
	<th> Mobile #</th>
	<th> Whatsapp #</th>
	<th> Email</th>
	<th> Designation</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
if($page ==1) { $srno = 0; } else { $srno = ($Limit * ($page-1));  }
//------------------------------------------------
foreach($Ades as $rowstd) {
//------------------------------------------------
$srno++;
	$ctystatus = get_admstatus($rowstd['crs_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'edit' => '1'))) { 
	$bankname  = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-status="'.$rowstd['crs_status'].'" data-com-name="'.$rowstd['crs_name'].'" data-com-cellno="'.$rowstd['crs_mobile'].'" data-com-designation="'.$rowstd['crs_designation'].'" data-com-whatsapp="'.$rowstd['crs_whatsapp'].'" data-com-email="'.$rowstd['crs_email'].'" data-com-id="'.$rowstd['crs_id'].'" data-target="#editCountryModal">'.$rowstd['crs_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-status="'.$rowstd['crs_status'].'" data-com-name="'.$rowstd['crs_name'].'" data-com-cellno="'.$rowstd['crs_mobile'].'" data-com-designation="'.$rowstd['crs_designation'].'" data-com-whatsapp="'.$rowstd['crs_whatsapp'].'" data-com-email="'.$rowstd['crs_email'].'" data-com-id="'.$rowstd['crs_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['crs_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td style="min-width:250px;">'.$rowstd['crs_name'].' </td>
	<td>'.$rowstd['crs_mobile'].'</td>
	<td>'.$rowstd['crs_whatsapp'].'</td>
	<td>'.$rowstd['crs_email'].'</td>
	<td>'.$rowstd['crs_designation'].'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'delete' => '1'))) { 
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
	$pagination.= '<li><a href="crs.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="crs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="crs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="crs.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="crs.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="crs.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="crs.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="crs.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="crs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="crs.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="crs.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="crs.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="crs.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="crs.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="crs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="crs.php?page='.$next.$sqlstring.'">Next</a></li>';
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
