<?php 

//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 100; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//--------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.ADES.'.ade_id',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".ADES.".id_company",
								'not_equal' => array( 
													''.ADES.'.ade_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.ADES.'.ade_name ASC ',
								'return_type' 	=> 'count' 
							); 
    $Ades 	= $dblms->getRows(ADES, $conditions);
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
								'select' 	=> ''.ADES.'.ade_id, '.ADES.'.ade_code, '.ADES.'.ade_status, '.ADES.'.ade_name, '.ADES.'.ade_cellno, 
												'.ADES.'.ade_whatsapp, '.ADES.'.ade_cnic, '.ADES.'.ade_email, '.ADES.'.ade_address, 
												'.ADES.'.id_company, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".ADES.".id_company",
								'not_equal' => array( 
													''.ADES.'.ade_id' => 0 
												), 
								'search_by' 	=> $sql2,
								'order_by' 		=> ''.ADES.'.ade_name ASC ',
								'start' 		=> ($page-1)*$Limit,
								'limit' 		=> $Limit,
								'return_type' 	=> 'all' 
							); 
    $Ades 	= $dblms->getRows(ADES, $conditions);
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
	<th> ADE Name</th>
	<th> Cell #</th>
	<th> Whatsapp #</th>
	<th> Email</th>
	<th> CNIC</th>
	<th> Company</th>
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
	$ctystatus = get_admstatus($rowstd['ade_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'edit' => '1'))) { 
	$bankname  = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-status="'.$rowstd['ade_status'].'" data-com-name="'.$rowstd['ade_name'].'" data-com-cellno="'.$rowstd['ade_cellno'].'" data-com-cnic="'.$rowstd['ade_cnic'].'" data-com-whatsapp="'.$rowstd['ade_whatsapp'].'" data-com-email="'.$rowstd['ade_email'].'" data-com-code="'.$rowstd['ade_code'].'" data-com-address="'.$rowstd['ade_address'].'" data-com-company="'.$rowstd['id_company'].'" data-com-id="'.$rowstd['ade_id'].'" data-target="#editCountryModal">'.$rowstd['ade_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer" data-height="350" data-width="100%" data-com-status="'.$rowstd['ade_status'].'" data-com-name="'.$rowstd['ade_name'].'" data-com-cellno="'.$rowstd['ade_cellno'].'" data-com-cnic="'.$rowstd['ade_cnic'].'" data-com-whatsapp="'.$rowstd['ade_whatsapp'].'" data-com-email="'.$rowstd['ade_email'].'" data-com-code="'.$rowstd['ade_code'].'" data-com-address="'.$rowstd['ade_address'].'" data-com-company="'.$rowstd['id_company'].'" data-com-id="'.$rowstd['ade_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['ade_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td style="min-width:250px;">'.$rowstd['ade_name'].' </td>
	<td>'.$rowstd['ade_cellno'].'</td>
	<td>'.$rowstd['ade_whatsapp'].'</td>
	<td>'.$rowstd['ade_email'].'</td>
	<td>'.$rowstd['ade_cnic'].'</td>
	<td>'.$rowstd['company_name'].'</td>
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
	$pagination.= '<li><a href="customers.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customers.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="customers.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="customers.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="customers.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="customers.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="customers.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="customers.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customers.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="customers.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="customers.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="customers.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="customers.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="customers.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="customers.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="customers.php?page='.$next.$sqlstring.'">Next</a></li>';
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
