<?php 
//------------------------------------------------
if(($vendor || $srch) && !LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.purchaseinvoice_id
									FROM ".PURCHASE_INVOICE." i  
									INNER JOIN ".VENDORS." v ON v.vendor_id = i.id_vendor
									WHERE i.purchaseinvoice_id != '0' $sql2
									ORDER BY i.purchaseinvoice_id  ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.purchaseinvoice_id,i.purchaseinvoice_no,i.invoice_total,
									i.invoice_paid,i.invoice_balance,i.dated,i.invoice_grand, i.purchaseinvoice_status
									FROM ".PURCHASE_INVOICE." i 
									INNER JOIN ".VENDORS." v ON v.vendor_id = i.id_vendor
									WHERE i.purchaseinvoice_id != '0' $sql2
									ORDER BY i.purchaseinvoice_id ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
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
	<th style="text-align:center;"> Purchase Invoice #</th>
	<th> Purchase Invoice Dated </th>
	<th> Purchase Invoice Total</th>
	<th> Purchase Invoice Paid</th>
	<th> Purchase Invoice Pending</th>
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
	$ctystatus = get_payments($rowstd['purchaseinvoice_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:center; width:70px;">'.$rowstd['purchaseinvoice_no'].'</td>
	<td style="min-width:200px;">'.$rowstd['dated'].' </td>
	<td>'.$rowstd['invoice_total'].'</td>
	<td>'.$rowstd['invoice_paid'].'</td>
	<td>'.$rowstd['invoice_balance'].'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;">
		<!--
		<a class="btn btn-xs btn-info" href="purchase-invoice.php?id='.$rowstd['purchaseinvoice_id'].'">
			<i class="icon-pencil"></i>
		</a>
		-->
		<a class="btn btn-xs btn-danger"> <i class="icon-trash"></i></a>
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
	$Nav .= '<li><a href="purchase-invoice.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="purchase-invoice.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="purchase-invoice.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
}
