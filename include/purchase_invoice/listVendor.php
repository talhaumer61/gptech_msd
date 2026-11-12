<?php 
//------------------------------------------------
if(!LMS_VIEW && !$vendor && !$srch && !isset($_GET['id'])) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.id_vendor
									FROM ".PURCHASE_INVOICE." i 
                                    INNER JOIN ".VENDORS." v ON v.vendor_id = i.id_vendor
									WHERE i.purchaseinvoice_id != '0' 
                                    GROUP BY i.id_vendor
									ORDER BY i.purchaseinvoice_id  ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.id_vendor, v.vendor_name, v.vendor_cellno, v.vendor_email
									FROM ".PURCHASE_INVOICE." i 
                                    INNER JOIN ".VENDORS." v ON v.vendor_id = i.id_vendor
									WHERE i.purchaseinvoice_id != '0' 
                                    GROUP BY i.id_vendor
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
	<th style="text-align:center;"> Vendor Name</th>
	<th style="text-align:center;"> Vendor Cell #</th>
	<th style="text-align:center;"> Vendor Email</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$srno++;
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td>'.$rowstd['vendor_name'].'</td>
	<td style="min-width:100px;">'.$rowstd['vendor_cellno'].' </td>
	<td style="min-width:100px;">'.$rowstd['vendor_email'].' </td>
	<td style="text-align:center;">
		<a class="btn btn-xs btn-info" href="purchase-invoice.php?vendor='.$rowstd['id_vendor'].'">
			<i class="icon-zoom-in"></i>
		</a>
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
