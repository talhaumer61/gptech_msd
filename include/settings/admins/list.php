<?php 
if(!isset($_GET['id']) && !LMS_VIEW) {
//------------------------------------------------
		// get All list

	$listconditions = array ( 
								'select' 		=> '*',
								'where' 		=> array ( 
															'adm_logintype' => 1
														), 
								'not_equal' 	=> array ( 
															'adm_id' => 1
														), 

								'search_by' 	=> $sql2,
								'order_by' 		=> 'adm_fullname ASC',
								'return_type' 	=> 'all' 
							); 
    $Adminslist 	= $dblms->getRows(ADMINS,  $listconditions);

//--------------------------------------------------
if (!empty($Adminslist) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:5px;"> 
	Total Records: ('.number_format(count($Adminslist)).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th> Full Name</th>
	<th> Login ID/ Email</th>
	<th> Phone #</th>
	<th> Email</th>
	<th style="text-align:center;"> Admin Type</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Adminslist as $rowstd) {
//------------------------------------------------
$srno++;
$admstatus = get_admstatus($rowstd['adm_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'edit' => '1'))) {  
	$bankname = '<a class="links-blue" href="administrators.php?id='.$rowstd['adm_id'].'">'.$rowstd['adm_fullname'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-adm-modal" data-toggle="modal" data-modal-window-title="Edit User" data-height="350" data-width="100%" data-adstats="'.$rowstd['adm_status'].'" data-adtype="'.$rowstd['adm_type'].'" data-adm-user="'.$rowstd['adm_username'].'" data-adm-fullname="'.$rowstd['adm_fullname'].'" data-adm-email="'.$rowstd['adm_email'].'" data-adm-phone="'.$rowstd['adm_phone'].'" data-adm-office="'.$rowstd['id_office'].'" data-adm-company="'.$rowstd['id_company'].'" data-adm-id="'.$rowstd['adm_id'].'" data-target="#editAdmModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname = $rowstd['adm_fullname'];
	$bankedit = ' ';
}
//--------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="min-width:120px;">'.$bankname.' </td>
	<td style="min-width:120px;">'.$rowstd['adm_username'].'</td>
	<td>'.$rowstd['adm_phone'].'</td>
	<td>'.$rowstd['adm_email'].'</td>
	<td style="text-align:left; width:60px;">'.get_admtypes($rowstd['adm_type']).'</td>
	<td style="text-align:center; width:60px;">'.$admstatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || ($_SESSION['userlogininfo']['LOGINIDA'] == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'delete' => '1'))) {  
	echo '<button class="btn btn-xs btn-danger ajax-delete-record" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?" data-popconfirm-placement="left" data-mysql-record-id="2" data-mysql-record-id4="1" data-mysql-table-name="tasks" data-ajax-url=""> <i class="icon-trash"></i></button>';
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
