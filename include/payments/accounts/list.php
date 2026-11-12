<?php 

//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT e.account_id, e.account_status, e.account_name, e.account_no, e.id_bank, e.account_bankaddress, 
										e.account_balance, b.bank_id, b.bank_name  
										FROM ".ACCOUNTS." e 
										INNER JOIN ".BANKS." b ON b.bank_id  = e.id_bank  
										WHERE e.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY e.account_name ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT e.account_id, e.account_status, e.account_name, e.account_no, e.id_bank, e.account_bankaddress, 
										e.account_balance, b.bank_id, b.bank_name  
										FROM ".ACCOUNTS." e 
										INNER JOIN ".BANKS." b ON b.bank_id  = e.id_bank  
										WHERE e.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY e.account_name ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Sr. #</th>
	<th> Account Name</th>
	<th> Account #</th>
	<th> Bank</th>
	<th style="text-align:right;">Balance</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_admstatus($rowstd['account_status']);
$srno++;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '22', 'edit' => '1'))) { 
	$bankname  = $rowstd['account_name'];
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Chart of Account" data-height="350" data-width="100%" data-com-status="'.$rowstd['account_status'].'" data-com-name="'.$rowstd['account_name'].'" data-com-bank="'.$rowstd['id_bank'].'" data-com-accno="'.$rowstd['account_no'].'" data-com-address="'.$rowstd['account_bankaddress'].'" data-com-balance="'.$rowstd['account_balance'].'" data-com-id="'.$rowstd['account_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['account_name'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srno.'</td>
	<td>'.$bankname.' </td>
	<td>'.$rowstd['account_no'].'</td>
	<td>'.$rowstd['bank_name'].'</td>
	<td style="width:150px; text-align:right;">'.number_format($rowstd['account_balance']).'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '22', 'delete' => '1'))) { 
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
	$Nav .= '<li><a href="expense.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="expense.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="expense.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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