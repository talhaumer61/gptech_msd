<?php 
//------------------------------------------------
if (!($Limit))   { $Limit = 100; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------

	$conditions = array ( 
								  'select' 		=> ''.ADMINS.'.adm_id'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_loginid =  ".ADMINS.".adm_id"
								, 'where' 		=> array ( 
															''.ADMINS.'.adm_logintype' => 2
														)
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> ''.ADMINS.'.adm_fullname ASC'
								, 'return_type' => 'count' 
						); 
    $Adminslist = $dblms->getRows(ADMINS,  $conditions);
//--------------------------------------------------
	$count 		   = ($Adminslist);
	$NumberOfPages = ceil($count/$Limit);

//--------------------------------------------------
if (($count) > 0) { 
	//------------------------------------------------
	$conditions = array ( 
								  'select' 		=> '*'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_loginid =  ".ADMINS.".adm_id"
								, 'where' 		=> array ( 
															''.ADMINS.'.adm_logintype' => 2
														) 
								, 'search_by' 	=> $sql2
								, 'order_by' 	=> ''.ADMINS.'.adm_fullname ASC'
								, 'start' 		=> ($page-1)*$Limit
								, 'limit' 		=> $Limit
								, 'return_type' => 'all' 
						); 
    $Adminslist = $dblms->getRows(ADMINS, $conditions);

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
	<th>Login Name</th>
	<th> Full Name</th>
	<th> Cell</th>
	<th> Email</th>
	<th> Whatsapp</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
if($page ==1) { $srno = 0; } else {	$srno = ($Limit * ($page-1)); }
//------------------------------------------------
foreach($Adminslist as $rowstd) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_admstatus($rowstd['adm_status']);
//------------------------------------------------

echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td>'.$rowstd['adm_username'].'</td>
	<td style="min-width:200px;">'.$rowstd['customer_name'].' </td>
	<td>'.$rowstd['customer_personcell'].'</td>
	<td>'.$rowstd['customer_email'].'</td>
	<td>'.$rowstd['customer_personwhatsapp'].'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;">';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '10', 'edit' => '1'))) { 
echo '<a class="btn btn-xs btn-info edit-adm-modal" data-toggle="modal" data-modal-window-title="Edit User" data-height="350" data-width="100%" data-adstats="'.$rowstd['adm_status'].'" data-adtype="'.$rowstd['adm_type'].'" data-adm-user="'.$rowstd['adm_username'].'" data-adm-fullname="'.$rowstd['customer_name'].'" data-adm-email="'.$rowstd['customer_email'].'" data-adm-phone="'.$rowstd['customer_personcell'].'" data-adm-personwhatsapp="'.$rowstd['customer_personwhatsapp'].'" data-adm-office="'.$rowstd['id_office'].'" data-adm-company="'.$rowstd['id_company'].'" data-adm-customerid="'.$rowstd['customer_id'].'" data-adm-id="'.$rowstd['adm_id'].'" data-target="#editAdmModal"><i class="icon-pencil"></i></a> ';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '10', 'delete' => '1'))) { 	
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
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="customerslogin.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="customerslogin.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="customerslogin.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
