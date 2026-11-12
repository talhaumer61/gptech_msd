<?php 

//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * 
										FROM ".LEAVES." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY leave_name ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
	Total Records: ('.number_format(mysqli_num_rows($sqllms)).')
</div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr.#</th>
	<th> Name </th>
	<th style="text-align:center;"> Type </th>
	<th style="text-align:center;"> Per Year </th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
$srno++;
	$ctystatus = get_admstatus($rowstd['leave_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'edit' => '1'))) { 
	$bankname  	= '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Leave Type" data-height="350" data-width="100%" data-cls-peryear="'.$rowstd['leave_peryear'].'" data-cls-type="'.$rowstd['leave_type'].'" data-cls-name="'.$rowstd['leave_name'].'" data-cls-status="'.$rowstd['leave_status'].'" data-cls-id="'.$rowstd['leave_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
	$bankedit 	= '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Leave Type" data-height="350" data-width="100%" data-cls-peryear="'.$rowstd['leave_peryear'].'" data-cls-type="'.$rowstd['leave_type'].'" data-cls-name="'.$rowstd['leave_name'].'" data-cls-status="'.$rowstd['leave_status'].'" data-cls-id="'.$rowstd['leave_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  	= $rowstd['leave_name'];
	$bankedit 	= ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td style="min-width:250px;">'.$rowstd['leave_name'].'</td>
	<td style="width:70px; text-align:center;">'.get_leavetype($rowstd['leave_type']).'</td>
	<td style="width:70px; text-align:center;">'.$rowstd['leave_peryear'].'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '31', 'delete' => '1'))) { 
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="leavecategory.php?id='.$rowstd['leave_id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure want to delete?"> <i class="icon-trash"></i></a>';
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