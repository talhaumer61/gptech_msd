<?php 
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT bank_id, bank_status, bank_phone, bank_name, bank_email, bank_address  
										FROM ".BANKS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY bank_name ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT bank_id, bank_status, bank_phone, bank_name, bank_email, bank_address  
										FROM ".BANKS." 
										WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY bank_name ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:5px;"> 
	Total Records: ('.number_format($count).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr #</th>
	<th> Bank Name</th>
	<th> Phone</th>
	<th> Email</th>
	<th> Address</th>
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
	$ctystatus = get_admstatus($rowstd['bank_status']);
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '14', 'edit' => '1'))) {  
	$bankname = '<a class="links-blue edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Company" data-height="350" data-width="100%" data-com-status="'.$rowstd['bank_status'].'" data-com-name="'.$rowstd['bank_name'].'" data-com-phone="'.$rowstd['bank_phone'].'" data-com-email="'.$rowstd['bank_email'].'" data-com-address="'.$rowstd['bank_address'].'" data-com-id="'.$rowstd['bank_id'].'" data-target="#editCountryModal">'.$rowstd['bank_name'].'</a> ';
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Company" data-height="350" data-width="100%" data-com-status="'.$rowstd['bank_status'].'" data-com-name="'.$rowstd['bank_name'].'" data-com-phone="'.$rowstd['bank_phone'].'" data-com-email="'.$rowstd['bank_email'].'" data-com-address="'.$rowstd['bank_address'].'" data-com-id="'.$rowstd['bank_id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname = $rowstd['bank_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td style="min-width:250px;">'.$bankname.' </td>
	<td>'.$rowstd['bank_phone'].'</td>
	<td>'.$rowstd['bank_email'].'</td>
	<td>'.$rowstd['bank_address'].'</td>
	<td style="width:60px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '14', 'delete' => '1'))) {  
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
	$Nav .= '<li><a href="bank.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="bank.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="bank.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
