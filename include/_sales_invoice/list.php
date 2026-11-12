<?php 
//------------------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) {
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.salesinvoice_id
									FROM ".SALES_INVOICE." i
									INNER JOIN ".JOB_ORDER." jo ON jo.job_order_id = i.id_joborder  
									INNER JOIN ".CUSTOMERS." cs ON cs.customer_id = i.id_customer  
									WHERE i.salesinvoice_id != '0' 
									 ORDER BY i.salesinvoice_id  ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT i.salesinvoice_id,i.salesinvoice_no,i.grand_total,i.paid,i.balance,i.dated,
									i.salesinvoice_status, jo.job_order_id, jo.job_order_status, cs.customer_id, cs.customer_name, cs.id_company
									FROM ".SALES_INVOICE." i
									INNER JOIN ".JOB_ORDER." jo ON jo.job_order_id = i.id_joborder
									INNER JOIN ".CUSTOMERS." cs ON cs.customer_id = i.id_customer 
									WHERE i.salesinvoice_id != '0'  
									 ORDER BY i.salesinvoice_id ASC LIMIT ".($page-1)*$Limit .",$Limit");
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
	<th style="text-align:center;"> Invoice #</th>
	<th style="text-align:center;"> Dated </th>
	<th> Customer Name </th>
	<th style="text-align:center;"> Total</th>
	<th style="text-align:center;"> Advance</th>
	<th style="text-align:center;"> Balance</th>
	<th style="text-align:center;"> Status</th>
	<th style="text-align:center;"> Dispatch</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
	$srno++;
	$ctystatus = get_saletypes($rowstd['salesinvoice_status']);
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:center; width:70px;">'.$rowstd['salesinvoice_no'].'</td>
	<td style="width:90px;">'.$rowstd['dated'].' </td>
	<td>'.$rowstd['customer_name'].'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['grand_total']).'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['paid']).'</td>
	<td style="width:100px;text-align:right;">'.number_format($rowstd['grand_total'] - $rowstd['paid']).'</td>
	<td style="text-align:center; width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center; width:80px;">';
		if($rowstd['salesinvoice_status'] == 3) {	
			echo '
			<form class="form-vertical" style="float:right;" action="sales-invoice.php" method="POST">
			<input type="hidden" name="id_invoice" id="id_invoice" value="'.$rowstd['salesinvoice_id'].'">
			<input type="hidden" name="id_order" id="id_order" value="'.$rowstd['job_order_id'].'">
			<input type="hidden" name="id_customer" id="id_customer" value="'.$rowstd['customer_id'].'">
			<input type="hidden" name="id_company" id="id_company" value="'.$rowstd['id_company'].'">
			<button  type="submit" class="btn btn-xs btn-info" id="sale_dispatch" name="sale_dispatch" onclick="return confirm(\'Are you sure want to Dispatch this Order?\')" >Dispatch</button>
			</form>';
		} elseif($rowstd['salesinvoice_status'] == 4){
			echo '<span  class="btn btn-xs btn-success">Dispatched</span>';
		}
		echo '
	</td>
	<td style="text-align:center;">';
if($rowstd['salesinvoice_status'] != 3 && $rowstd['salesinvoice_status'] != 4) {	
	echo '<a class="btn btn-xs btn-info" href="sales-invoice.php?id='.$rowstd['salesinvoice_id'].'">
			<i class="icon-pencil"></i>
		</a>';
}
echo '
		<a class="btn btn-xs btn-info" href="saleinvoiceprint.php?id='.$rowstd['salesinvoice_id'].'" target="_blank"><i class="icon-print"></i></a>
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
	$Nav .= '<li><a href="sales-invoice.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="sales-invoice.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="sales-invoice.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
