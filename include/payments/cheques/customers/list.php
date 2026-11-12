<?php 

//------------------------------------------------
if (!($Limit))   { $Limit = 100; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql13 $sql2 
										AND b.pay_type = '1' AND b.method = '3' ORDER BY b.id DESC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid   
										INNER JOIN ".BANKS." bk ON bk.bank_id = b.id_bank   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' $sql13 $sql2 
										AND b.pay_type = '1' AND b.method = '3' ORDER BY b.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<form name="frmMain" id="frmMain" method="post" action="#" OnSubmit="return CheckForm();">
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th> Sr.#</th>
	<th> Slip #</th>
	<th> Customer Name</th>
	<th> Cheque #</th>
	<th> Dated</th>
	<th> Clear Dated</th>
	<th> Bank</th>
	<th style="text-align:center;"> Amount</th>
	<th style="text-align:center;"> Status</th>
	<th style="text-align:center;">Clear</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
$srno++;
if($rowstd['cheque_cleardate'] != '0000-00-00') { 
	$cleardate = $rowstd['cheque_cleardate'];
} else { 
	$cleardate = '';
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '5', 'edit' => '1'))) {
	$payedit = '<a class="btn btn-xs btn-info edit-country-modal" data-toggle="modal" data-modal-window-title="Edit Customer Cheque" data-height="350" data-width="100%" data-com-dated="'.$rowstd['cheque_date'].'" data-com-paid="'.$rowstd['customer_name'].' ('.$rowstd['customer_cellno'].')" data-com-slipno="'.$rowstd['slipno'].'" data-com-amount="'.$rowstd['amount'].'" data-com-cheque="'.$rowstd['cheque'].'" data-com-chequedate="'.$rowstd['cheque_date'].'" data-com-bank="'.$rowstd['bank_name'].'" data-com-cleardate="'.$rowstd['cheque_cleardate'].'" data-cchqstatus="'.$rowstd['cheque_status'].'" data-com-remarks="'.$rowstd['cheque_remarks'].'" data-com-id="'.$rowstd['id'].'"  data-target="#editCountryModal"><i class="icon-pencil"></i></a> ';
if($rowstd['cheque_status'] != '1') { 
	$chekstatus = '<input id="payid[]" name="payid[]" type="checkbox" value="'.$rowstd['id'].'" class="checkbox-inline">';
} else { 
	$chekstatus = '';
}
} else { 
	$chekstatus = '';
	$payedit = '';
}

echo '
<tr>
	<td style="width:50px;">'.$srno.'</td>
	<td style="width:100px;">'.$rowstd['slipno'].'</td>
	<td>'.$rowstd['customer_name'].' '.$rowstd['customer_cellno'].'</td>
	<td>'.$rowstd['cheque'].'</td>
	<td>'.$rowstd['cheque_date'].'</td>
	<td>'.$cleardate.'</td>
	<td>'.$rowstd['bank_name'].'</td>
	<td style="text-align:right;">'.number_format($rowstd['amount']).'</td>
	<td style="text-align:center; width:100px;">'.get_cheques($rowstd['cheque_status']).'</td>
	<td style="text-align:center; width:30px;">'.$chekstatus.'</td>
	<td style="text-align:center;">'.$payedit.'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '5', 'edit' => '1'))) {
echo '
<tr><td colspan="15" style="text-align:right;"><button class="btn btn-info" name="submit_cleared" id="submit_cleared" type="submit" style="padding:5px 13px; font-size:12px;">Clear Cheques</button></td></tr>';
}
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" value="'.$srno.'">
</form>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="customercheques.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="customercheques.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="customercheques.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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