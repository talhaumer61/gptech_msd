<?php 
echo '
<div class="col-lg-4">
<div class="widget" style="margin-top:0px;">
<div class="widget-content widget-content-project slimScrollAdminProjectTimeline" style="padding-top:7px;">
<!--heading-->
<div class="dashboard-panels-heading" style="font-weight:700;"> Latest Invoices </div>
<!--heading-->
<!--WI_PROJECT_EVENTS-->
<div class="project-info-tabs project-details">
<ul class="timeline">
<!--left event-->';
	$sqllmsinvoices  = $dblms->querylms("SELECT * 
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										ORDER BY b.invoice_id DESC LIMIT 15");
//------------------------------------------------
while($rowinvoices = mysqli_fetch_array($sqllmsinvoices)) { 

if($_SESSION['userlogininfo']['LOGINTYPE']  == 1) {  
	$invprint = ' <span style="float:right;"><a class="btn btn-xs btn-info" href="invoiceprint.php?id='.$rowinvoices['invoice_id'].'" target="_blank"><i class="icon-print"></i></a></span>';
	$modalwindow = '<a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Invoice Detail</b>" data-src="invoiceview.php?id='.$rowinvoices['invoice_id'].'" href="#">Invoice #: '.$rowinvoices['invoice_id'].'</a>';
} else { 
	$invprint = '';
	$modalwindow = '<a class="links-blue">Invoice #: '.$rowinvoices['invoice_id'].'</a>';
}
//------------------------------------------------
echo '
<li>
	<div class="tl-circ bg-info"><i class="icon-credit-card"></i></div>
	<div class="timeline-panel">
		<div class="tl-heading">
			<div><strong>'.$modalwindow.'</strong> '.$invprint.'</div>
			<div><small class="text-muted"><i class="icon-time"></i> '.$rowinvoices['invoice_dated'].'</small></div>
			<div><strong>'.$rowinvoices['customer_name'].' ('.substr($rowinvoices['customer_cellno'], 0, -3).'...)</strong></div>
		</div>
		<div class="tl-body">
			<div><i class="icon-money"></i>: '.number_format($rowinvoices['invoice_grand']).'</div>
		</div>
	</div>
</li>';
}
echo '
<!--right event-->
</ul>
<!--wi_no_timeline-->
<!--wi_no_timeline-->
</div>
<!--WI_PROJECT_EVENTS-->
</div>
</div>
</div>
<!--TIMELINE END-->';
?>