<?php 
//--------------- total customers --------------
	$sqllmstopcustomers = $dblms->querylms("SELECT COUNT(customer_id) as Totalcustomers 
													FROM ".CUSTOMERS." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' ");
	$valuetopcustomers  = mysqli_fetch_array($sqllmstopcustomers);
//--------------- total orders --------------
	$sqllmstoporders = $dblms->querylms("SELECT COUNT(order_id) as Totalorders 
												FROM ".ORDERS." 
												WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'");
	$valuetoporders  = mysqli_fetch_array($sqllmstoporders);
//--------------- total invoices --------------
	$sqllmstopinvoices = $dblms->querylms("SELECT COUNT(invoice_id) as Totalinvoices 
													FROM ".INVOICES." 
													WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'");
	$valuetopinvoices  = mysqli_fetch_array($sqllmstopinvoices);
echo '
<!--WI_STATS_TOP-->
<div class="row">
<!--my projects-->
	<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="orders.php">
		<div class="box-content dashboard-top-stats display-table no-border">
			<div class="col-xs-5 display-cell no-padding"> <i class="icon-folder-open dashboard-top-stats-icon bg-info"></i> </div>
			<div class="col-xs-7 display-cell no-padding">
				<div class="dashboard-top-stats-heading">Job Orders</div>
				<div class="dashboard-top-stats-value">'.number_format($valuetoporders['Totalorders']).'</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<!--my projects-->
<!--my tasks-->
	<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="invoices.php">
		<div class="box-content dashboard-top-stats display-table no-border">
			<div class="col-xs-5 display-cell no-padding"> <i class="icon-credit-card dashboard-top-stats-icon bg-success"></i> </div>
			<div class="col-xs-7 display-cell no-padding">
				<div class="dashboard-top-stats-heading">Invoices</div>
				<div class="dashboard-top-stats-value">'.number_format($valuetopinvoices['Totalinvoices']).'</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<!--my tasks end-->
<!--tickets-->
	<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="customers.php">
		<div class="box-content dashboard-top-stats display-table no-border">
			<div class="col-xs-5 display-cell no-padding"> <i class="icon-group dashboard-top-stats-icon bg-info"></i> </div>
			<div class="col-xs-7 display-cell no-padding">
				<div class="dashboard-top-stats-heading">Customers</div>
				<div class="dashboard-top-stats-value">'.number_format($valuetopcustomers['Totalcustomers']).'</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<!--tickets end-->
</div>
<!--WI_STATS_TOP-->';

?>