<?php 
//------------------------------------------------
if (!($Limit))   { $Limit = 100; }  
if ($page == "") { $page  = 1;  } 

//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> ''.CITIES.'.city_id'
							, 'join' 		=> "INNER JOIN ".DISTRICTS." ON ".DISTRICTS.".district_id =  ".CITIES.".id_district"
							, 'where' 		=> array( 
													''.CITIES.'.is_deleted' => 0 
												)
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> ''.CITIES.'.city_name ASC'
							, 'return_type' => 'count' 
						); 
    $Cities 	= $dblms->getRows(CITIES, $conditions);

//--------------------------------------------------
	$count 		   = ($Cities);
	$NumberOfPages = ceil($count/$Limit);
//--------------------------------------------------
if ($count> 0) {
	
//--------------------------------------------------
	$conditions = array ( 
							  'select' 		=> ''.CITIES.'.city_id, '.CITIES.'.city_status, '.CITIES.'.city_name,
												'.CITIES.'.city_code, '.CITIES.'.city_ordering, '.CITIES.'.id_district,
												'.DISTRICTS.'.district_name, '.DISTRICTS.'.district_code'
							, 'join' 		=> "INNER JOIN ".DISTRICTS." ON ".DISTRICTS.".district_id =  ".CITIES.".id_district"
							, 'where' 		=> array( 
														''.CITIES.'.is_deleted' => 0 
													)
							, 'search_by' 	=> $sql2
							, 'order_by' 	=> ''.CITIES.'.city_name ASC '
							, 'start' 		=> ($page-1)*$Limit
							, 'limit' 		=> $Limit
							, 'return_type' => 'all' 
						); 
    $Cities 	= $dblms->getRows(CITIES, $conditions);
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
	<th> City Name</th>
	<th style="text-align:center;">Disrtict</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
//------------------------------------------------
foreach($Cities as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_admstatus($rowstd['city_status']);
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$srno.'</td>
	<td style="min-width:200px;vertical-align: middle;">'.$rowstd['city_name'].' </td>
	<td style="text-align:left;width:250px;vertical-align: middle;">'.$rowstd['district_name'].'</td>
	<td style="text-align:center; width:60px; vertical-align: middle;">'.$ctystatus.'</td>
	<td style="text-align:center; vertical-align: middle;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '32', 'edit' => '1'))) { 
echo '	
	<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Company" data-height="350" data-width="100%" data-com-status="'.$rowstd['city_status'].'"  data-com-name="'.$rowstd['city_name'].'" data-com-district="'.$rowstd['id_district'].'" data-com-id="'.$rowstd['city_id'].'"  data-target="#editCountryModal" ><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '32', 'delete' => '1'))) { 	
	echo ' <a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>';
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
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="cities.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="cities.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="cities.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
