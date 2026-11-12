<?php 

//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT e.id, e.status, e.id_cat, e.dated, e.voucher, e.bill_no, e.amount, e.note, c.cat_id, c.cat_name  
										FROM ".EXPENSES." e 
										INNER JOIN ".EXPENSE_CATS." c ON c.cat_id  = e.id_cat 
										WHERE e.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY e.id DESC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT e.id, e.status, e.id_cat, e.dated, e.voucher, e.bill_no, e.amount, e.note, c.cat_id, c.cat_name  
										FROM ".EXPENSES." e 
										INNER JOIN ".EXPENSE_CATS." c ON c.cat_id  = e.id_cat 
										WHERE e.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql2 
										ORDER BY e.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div class="navbar-form navbar-right form-small" style="font-weight:700; color:blue; margin-right:10px;"> 
	Total Records: ('.number_format($count).')
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;"> Voucher</th>
	<th style="text-align:center;"> Bill #</th>
	<th> Dated</th>
	<th> Category</th>
	<th style="text-align:right;"> Amount</th>
	<th style="text-align:center;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$ctystatus = get_payments($rowstd['status']);
	$orderdate = new DateTime($rowstd['dated']); 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '20', 'edit' => '1'))) { 
	$bankname  = $rowstd['dated'];
	$bankedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Expense" data-height="350" data-width="100%" data-com-status="'.$rowstd['status'].'" data-com-dated="'.$rowstd['dated'].'" data-com-cat="'.$rowstd['id_cat'].'" data-com-voucher="'.$rowstd['voucher'].'" data-com-billno="'.$rowstd['bill_no'].'" data-com-amount="'.$rowstd['amount'].'" data-com-note="'.$rowstd['note'].'" data-com-id="'.$rowstd['id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
} else { 
	$bankname  = $rowstd['dated'];
	$bankedit = ' ';
}
echo '
<tr>
	<td style="width:70px;text-align:center;">'.$rowstd['voucher'].'</td>
	<td style="width:70px;text-align:center;">'.$rowstd['bill_no'].'</td>
	<td style="width:100px;">'.$orderdate->format('d/m/Y').' </td>
	<td>'.$rowstd['cat_name'].'</td>
	<td style="width:100px; text-align:right;">'.number_format($rowstd['amount']).'</td>
	<td style="width:50px; text-align:center;">'.$ctystatus.'</td>
	<td style="text-align:center;">'.$bankedit;
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '20', 'delete' => '1'))) { 
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="expense.php?id='.$rowstd['id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a> ';
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