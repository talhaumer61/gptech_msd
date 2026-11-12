<?php 

//--------------------------------------------	
	// get All list

	$listconditions = array ( 
								'select' 		=> 'role_id, role_status, role_name, role_type',
								'not_equal' 	=> array ( 
															'role_id' => 0 
														), 

								'search_by' 	=> $sql2,
								'order_by' 		=> 'role_name ASC',
								'return_type' 	=> 'all' 
							); 
    $Rolelist 	= $dblms->getRows(ROLES,  $listconditions);
//--------------------------------------------------
if (!empty($Rolelist)) {
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin:10px;"> 
	Total Records: ('.number_format(count($Rolelist)).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:700; text-align:center;"> Sr.#</th>
	<th style="font-weight:700;"> Role Name</th>
	<th style="font-weight:700;"> Under Role</th>
	<th style="font-weight:700; text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
foreach($Rolelist as $rowstd) {
//------------------------------------------------
	$srno++;
$bcatstatus = get_admstatus($rowstd['role_status']);

echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td style="min-width:250px;"><a class="links-blue edit-bcat-modal" data-toggle="modal" data-modal-window-title="Edit Book Category" data-height="350" data-width="100%" data-cat-name="'.$rowstd['role_name'].'" data-cat-status="'.$rowstd['role_status'].'" data-cat-type="'.$rowstd['role_type'].'" data-cat-id="'.$rowstd['role_id'].'" data-target="#editBcatModal">'.$rowstd['role_name'].'</a> </td>
	<td style="text-align:left; width:150px;">'.get_roletypes($rowstd['role_type']).'</td>
	<td style="text-align:center; width:50px;" >'.$bcatstatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-info edit-bcat-modal" data-toggle="modal" data-modal-window-title="Edit Book Category" data-height="350" data-width="100%" data-cat-name="'.$rowstd['role_name'].'" data-cat-status="'.$rowstd['role_status'].'" data-cat-type="'.$rowstd['role_type'].'" data-cat-id="'.$rowstd['role_id'].'" data-target="#editBcatModal"><i class="icon-pencil"></i></a>
		<button class="btn btn-xs btn-danger ajax-delete-record" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?" data-popconfirm-placement="left" data-mysql-record-id="2" data-mysql-record-id4="1" data-mysql-table-name="tasks" data-ajax-url=""> <i class="icon-trash"></i></button>
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
