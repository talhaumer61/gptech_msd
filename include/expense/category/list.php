<?php 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT cat_id, cat_status, cat_name, cat_detail  
										FROM ".EXPENSE_CATS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY cat_name ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
	Total Records: ('.number_format(mysqli_num_rows($sqllms)).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th> Name</th>
	<th> Detail</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
$srno++;
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['cat_status']);

//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '21', 'edit' => '1'))) { 
	$bankname  = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Expense Category" data-height="350" data-width="100%" data-com-status="'.$rowstd['cat_status'].'" data-com-name="'.$rowstd['cat_name'].'" data-com-detail="'.$rowstd['cat_detail'].'" data-com-id="'.$rowstd['cat_id'].'" data-target="#editCountryModal">'.$rowstd['cat_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Item" data-height="350" data-width="100%" data-com-status="'.$rowstd['cat_status'].'" data-com-name="'.$rowstd['cat_name'].'" data-com-detail="'.$rowstd['cat_detail'].'" data-com-id="'.$rowstd['cat_id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['cat_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td>'.$bankname.' </td>
	<td>'.$rowstd['cat_detail'].' </td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '21', 'delete' => '1'))) { 	
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
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}