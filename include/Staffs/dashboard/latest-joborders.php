<?php 
echo '
<!--- latest 20 Job Orders --->
<div class="col-lg-6">
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
    <th style="font-weight:bold; font-size:14px;" colspan="6">Latest Job Orders</th>
</tr>
<tr>
	<th style="font-weight:bold;font-size:12px;text-align:center;width:70px;">Order #</th>
	<th style="font-weight:bold;font-size:12px;text-align:center;width:80px;">Dated</th>
	<th style="font-weight:bold;font-size:12px;">Customer Name</th>
	<th style="font-weight:bold;font-size:12px; width:60px; text-align:center;">Total</th>
	<th style="font-weight:bold;font-size:12px; width:60px; text-align:center;">Status</th>
	<th style="width:35px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';

foreach($LatedstSalesOrders as $latesjo) { 
	$orderdate = new DateTime($latesjo['dated']); 
	echo '
	<tr>
		<td>'.$latesjo['job_order_no'].'</td>
		<td style="text-align:center;">'.$orderdate->format('d/m/Y').'</td>
		<td style="text-align:left;">'.$latesjo['customer_name'].' ('.($latesjo['customer_cellno']).')</td>
		<td style="text-align:right;">'.number_format($latesjo['total']).'</td>
		<td style="text-align:center;">'.get_orders($latesjo['job_order_status']).'</td>
		<td style="text-align:center;">
			<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Job Order Detail</b>" data-src="orderview.php?id='.$latesjo['job_order_id'].'" href="#"><i class="icon-zoom-out"></i></a> 
		</td>
	</tr>';
}

echo '
</tbody>
</table>
</div>
</div>
</div>
<!--- End latest 20 Job Orders --->';