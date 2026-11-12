<?php 

echo '
<div class="col-lg-4">
<!--WI_PINNED_PROJECT_NONE-->
<!--WI_TASKS_CHART-->
<div class="widget-content dashboard-widget">
<!--heading-->
	<div class="dashboard-panels-heading" style="font-weight:700;"> Graph </div>
<!--heading-->
	<div id="flot-dashboard-tasks" class="dashboard-chart-tasks"></div>
</div>
<!--WI_TASKS_CHART-->';
if($_SESSION['userlogininfo']['LOGINTYPE']  == 1) { 
//-----------------------------------
$sqllmstotalpayable  = $dblms->querylms("SELECT SUM(amount) AS Totalpayable      
											FROM ".CUSTOMERS_LEDGER." 
											WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
											AND ledgerfor = '1' AND pay_type = '2'");
$rowtotalpayable = mysqli_fetch_array($sqllmstotalpayable);
//-----------------------------------
	$sqllmstotalpaid 	= $dblms->querylms("SELECT SUM(amount) as Totalpaid
												FROM ".CUSTOMERS_LEDGER." 
												WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
												AND ledgerfor = '1' AND pay_type = '1'");
	$rowtotalpaid 		= mysqli_fetch_array($sqllmstotalpaid);

//-----------------------------------
$sqllmstodaypaid  = $dblms->querylms("SELECT SUM(amount) AS Todaypaid     
											FROM ".CUSTOMERS_LEDGER." 
											WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
											AND ledgerfor = '1' AND pay_type = '2' AND doc_type = '5' AND dated = '".date("Y-m-d")."'");
$rowtodaypaid = mysqli_fetch_array($sqllmstodaypaid);

//-----------------------------------
$sqllmsyesterdaypaid  = $dblms->querylms("SELECT SUM(amount) AS Yesterdaypaid     
											FROM ".CUSTOMERS_LEDGER." 
											WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
											AND ledgerfor = '1' AND pay_type = '2' AND doc_type = '5' 
											AND dated = '".date('Y-m-d',strtotime("-1 days"))."'");
$rowyesterdaypaid = mysqli_fetch_array($sqllmsyesterdaypaid);

//-----------------------------------
$sqllmsthismonthpaid  = $dblms->querylms("SELECT SUM(amount) AS Thismonthpaid     
											FROM ".CUSTOMERS_LEDGER." 
											WHERE id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
											AND ledgerfor = '1' AND pay_type = '2' AND doc_type = '5' 
											AND (dated BETWEEN '".date('Y-m-01')."' AND '".date('Y-m-d')."')");
$rowthismonthpaid = mysqli_fetch_array($sqllmsthismonthpaid);
//-----------------------------------
echo '
<!--INVOICES DUE-->
<div class="dashboard-pending-income bg-warning">
<!--permissions-->            
	<div class="income-total bg-warning-dark">
		<div><span class="currency">Rs </span><span class="amount">'.number_format($rowtotalpayable['Totalpayable']).'</span></div>
		<div class="income-description allcaps">Total Invoices</div>
	</div>
	<div class="income-breakdown bg-info">
		<div><span class="currency">Rs </span><span class="amount">'.number_format($rowtotalpaid['Totalpaid']).'</span></div>
		<div class="income-description allcaps">Total Payments</div>
	</div>
</div>
<!--INVOICES DUE-->
			
<!--WI_TIME_HISTORY-->
<div class="dashboard-time-history">
<!--permissions-->            
	<div class="each-time time-summary border-right bg-info text-white"> 
		Invoice Payments<span class="period period-today"> Today</span> <span class="hours">Rs '.number_format($rowtodaypaid['Todaypaid']).'</span> 
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> <span class="period allcaps"> Yesterday</span> 
		<span class="hours text-muted">Rs '.number_format($rowyesterdaypaid['Yesterdaypaid']).'</span> 
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> <span class="period allcaps"> This Month</span> 
		<span class="hours text-muted">Rs '.number_format($rowthismonthpaid['Thismonthpaid']).'</span> 
	</div>
</div>
<!--WI_TIME_HISTORY-->';
}
echo '
</div>
';
?>