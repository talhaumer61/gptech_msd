<?php 
echo '
<div class="col-lg-6">
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">

<table class="table">
<thead>
<tr>
    <th style="font-weight:bold; font-size:14px;" colspan="6">Latest Invoices</th>
</tr>
<tr>
	<th style="font-weight:bold;font-size:12px;text-align:center;width:85px;">Invoice #</th>
	<th style="font-weight:bold;font-size:12px;text-align:center;width:80px;">Dated</th>
	<th style="font-weight:bold;font-size:12px;">Customer Name</th>
	<th style="font-weight:bold;font-size:12px; width:60px; text-align:center;">Total</th>
	<th style="font-weight:bold;font-size:12px; width:60px; text-align:center;">Status</th>
	<th style="width:35px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';

foreach($LatestInvoices as $latestInv) { 
	$invoicedate = new DateTime($latestInv['dated']); 
	echo '
	<tr>
		<td>'.$latestInv['salesinvoice_no'].'</td>
		<td style="text-align:center;">'.$invoicedate->format('d/m/Y').'</td>
		<td style="text-align:left;">'.$latestInv['customer_name'].'</td>
		<td style="text-align:right;">'.number_format($latestInv['total']).'</td>
		<td style="text-align:center;">'. get_saletypes($latestInv['salesinvoice_status']).'</td>
		<td style="text-align:center;">
			<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Job Order Detail</b>" data-src="saleinvoicview.php?id='.$latestInv['salesinvoice_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
		</td>
	</tr>';
}

echo '
</tbody>
</table>
</div>
</div>
<!-- End Admission Inquiries-->
</div>';