<?php 
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) {
	$lhomeclsactive = 'class="open"';
	$thomeclsactive = 'class="heading-menu-active"';
} else { 
	$lhomeclsactive	= '';
	$thomeclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sale-orders")) {
	$lordsclsactive = 'class="open"';
	$tordsclsactive = 'class="heading-menu-active"';
} else { 
	$lordsclsactive = '';
	$tordsclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customers")) {
	$lcumclsactive = 'class="open"';
	$tcumclsactive = 'class="heading-menu-active"';
} else { 
	$lcumclsactive = '';
	$tcumclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "reports")) {
	$lrepsclsactive = 'class="open"';
	$trepsclsactive = 'class="heading-menu-active"';
} else { 
	$lrepsclsactive = '';
	$trepsclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "employees")) {
	$lempclsactive = 'class="open"';
	$tempclsactive = 'class="heading-menu-active"';
} else { 
	$lempclsactive = '';
	$tempclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales")) {
	$lsaleclsactive = 'class="open"';
	$tsaleclsactive = 'class="heading-menu-active"';
} else { 
	$lsaleclsactive = '';
	$tsaleclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "salereturns")) {
	$lrsaleinvclsactive = 'class="open"';
	$trsaleinvclsactive = 'class="heading-menu-active"';
} else { 
	$lrsaleinvclsactive = '';
	$trsaleinvclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice")) {
	$lsaleinvclsactive = 'class="open"';
	$tsaleinvclsactive = 'class="heading-menu-active"';
} else { 
	$lsaleinvclsactive = '';
	$tsaleinvclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-order")) {
	$lpurchaseorderclsactive = 'class="open"';
	$tpurchaseorderclsactive = 'class="heading-menu-active"';
} else { 
	$lpurchaseorderclsactive = '';
	$tpurchaseorderclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorpayments")) {
	$lpurchaseinvcclsactive = 'class="open"';
	$tpurchaseinvcclsactive = 'class="heading-menu-active"';
} else { 
	$lpurchaseinvcclsactive = '';
	$tpurchaseinvcclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments")) {
	$lcuspayclsactive = 'class="open"';
	$tcuspayclsactive = 'class="heading-menu-active"';
} else { 
	$lcuspayclsactive = '';
	$tcuspayclsactive = '';
}


//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "invoices")) {
	$linvsclsactive = 'class="open"';
	$tinvsclsactive = 'class="heading-menu-active"';
} else { 
	$linvsclsactive = '';
	$tinvsclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-order") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stocksreceives")) {
	$lposclsactive 	= 'class="open"';
	$lposvis		= 'style="display:block; visibility:visible;"';
	$tposclsactive 	= 'class="heading-menu-active"';
} else { 
	$lposclsactive 	= '';
	$lposvis		= '';
	$tposclsactive 	= '';
	
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items-cat") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendors")) {
	$lpurclsactive 	= 'class="open"';
	$lpurvis		= 'style="display:block; visibility:visible;"';
	$tpurclsactive 	= 'class="heading-menu-active"';
} else { 
	$lpurclsactive 	= '';
	$lpurvis		= '';
	$tpurclsactive 	= '';
	
}

//-----------------Sales -----------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sale-orders") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "salereturns")) {
	$lsalesclsactive 	= 'class="open"';
	$lsalesvis			= 'style="display:block; visibility:visible;"';
	$tsalesclsactive 	= 'class="heading-menu-active"';
} else { 
	$lsalesclsactive 	= '';
	$lsalesvis			= '';
	$tsalesclsactive 	= '';	
}


//-----------------Payments -----------------------

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorpayments")) {
	$lpayssclsactive 	= 'class="open"';
	$lpayssvis			= 'style="display:block; visibility:visible;"';
	$tpaysclsactive 	= 'class="heading-menu-active"';
} else { 
	$lpayssclsactive 	= '';
	$lpayssvis			= '';
	$tpaysclsactive 	= '';	
}

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerledger") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorledger") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stockledger")) { 
	$lledgersclsactive 	= 'class="open"';
	$lledgervis			= 'style="display:block; visibility:visible;"';
	$tledgerclsactive 	= 'class="heading-menu-active"';
} else { 
	$lledgersclsactive 	= '';
	$lledgervis			= '';
	$tledgerclsactive 	= '';
}

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "expense") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "expensecategory")) { 
	$lexpnsesclsactive 	= 'class="open"';
	$lexpnsevis			= 'style="display:block; visibility:visible;"';
	$texpnseclsactive 	= 'class="heading-menu-active"';
} else { 
	$lexpnsesclsactive 	= '';
	$lexpnsevis			= '';
	$texpnseclsactive 	= '';
}
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customercheques") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorpayments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorcheques") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "accounts") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerbalancesheet") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorbalancesheet")) { 
	$lpaysclsactive 	= 'class="open"';
	$lpaysvis			= 'style="display:block; visibility:visible;"';
	$tpaysclsactive 	= 'class="heading-menu-active"';
} else { 
	$lpaysclsactive 	= '';
	$lpaysvis			= '';
	$tpaysclsactive 	= '';
	
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "setting") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "administrators") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "company") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "office") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "bank") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "media") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "roles") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "ades") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "classes") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerslogin")) {
	$lsetclsactive 	= 'class="open"';
	$lsetvis		= 'style="display:block; visibility:visible;"';
	$tsetclsactive 	= 'class="heading-menu-active"';
} else { 
	$lsetclsactive 	= '';
	$lsetvis		= '';
	$tsetclsactive 	= '';
	
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "employees") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "designations") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "departments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "workshifts") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "leavecategory") ) {
	$lhrmclsactive 	= 'class="open"';
	$lhrmvis		= 'style="display:block; visibility:visible;"';
	$thrmclsactive 	= 'class="heading-menu-active"';
} else { 
	$lhrmclsactive 	= '';
	$lhrmvis		= '';
	$thrmclsactive 	= '';
	
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "holidays") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "employeeleaves") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "attendance") ) {
	$latndsclsactive 	= 'class="open"';
	$latndsvis			= 'style="display:block; visibility:visible;"';
	$tatndsclsactive 	= 'class="heading-menu-active"';
} else { 
	$latndsclsactive 	= '';
	$latndsvis			= '';
	$tatndsclsactive	= '';
}


//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) { 
	$lefttitlename 	= 'Dashboard';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-home"></i> Dashboard </h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "company")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Company</h2>';
	$lefttitlename 	= 'Manage Company';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "office")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Office</h2>';
	$lefttitlename 	= 'Manage Office';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Receipts</h2>';
	$lefttitlename 	= 'Customer Receipts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerledger")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Ledger</h2>';
	$lefttitlename 	= 'Customer Ledger';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorledger")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Vendor Ledger</h2>';
	$lefttitlename 	= 'Vendor Ledger';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stockledger")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Stock Ledger</h2>';
	$lefttitlename 	= 'Vendor Ledger';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customercheques")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Cheque Detail</h2>';
	$lefttitlename 	= 'Customer Cheque Detail';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorcheques")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Vendor Cheque Detail</h2>';
	$lefttitlename 	= 'Vendor Cheque Detail';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorpayments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Vendor Payments</h2>';
	$lefttitlename 	= 'Vendor Payments';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "bank")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Banks</h2>';
	$lefttitlename 	= 'Manage Banks';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "designations")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Designations</h2>';
	$lefttitlename 	= 'Manage Designations';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "leavecategory")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Leave Category</h2>';
	$lefttitlename 	= 'Manage Leave Category';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "departments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Departments</h2>';
	$lefttitlename 	= 'Manage Departments';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "workshifts")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calender"></i> Manage Work Shifts</h2>';
	$lefttitlename 	= 'Manage Work Shifts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "media")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Media</h2>';
	$lefttitlename 	= 'Manage Media';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Manage Items</h2>';
	$lefttitlename 	= 'Manage Items';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendors")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Vendors</h2>';
	$lefttitlename 	= 'Manage Vendors';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sale-orders")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Job Orders</h2>';
	$lefttitlename 	= 'Manage Job Orders';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-order")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Purchase Order</h2>';
	$lefttitlename 	= 'Manage Purchase Order';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-invoice")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Vendor Payments</h2>';
	$lefttitlename 	= 'Manage Vendor Payments';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "salereturns")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Manage Sales Return</h2>';
	$lefttitlename 	= 'Manage Sales Return';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Manage Sales</h2>';
	$lefttitlename 	= 'Manage Sales';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customers")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Customers</h2>';
	$lefttitlename 	= 'Manage Customers';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "invoices")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-credit-card"></i> Manage Invoices</h2>';
	$lefttitlename 	= 'Manage Invoices';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "employees")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Employees</h2>';
	$lefttitlename 	= 'Manage Employees';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "administrators")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Admins</h2>';
	$lefttitlename 	= 'Manage Admins';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "roles")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Roles</h2>';
	$lefttitlename 	= 'Manage Roles';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "expensecategory")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Expense Category</h2>';
	$lefttitlename 	= 'Expense Category';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "accounts")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Chart of Accounts</h2>';
	$lefttitlename 	= 'Chart of Accounts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "expense")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Manage Expense</h2>';
	$lefttitlename 	= 'Manage Expense';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerbalancesheet")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Balance Sheet</h2>';
	$lefttitlename 	= 'Customer Balance Sheet';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorbalancesheet")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Vendor Balance Sheet</h2>';
	$lefttitlename 	= 'Vendor Balance Sheet';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "holidays")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Manage Holidays</h2>';
	$lefttitlename 	= 'Manage Holidays';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "employeeleaves")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> Manage Employee Leaves</h2>';
	$lefttitlename 	= 'Manage Employee Leaves';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "attendance")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Daily Attendance</h2>';
	$lefttitlename 	= 'Daily Attendance';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "ades")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Ades</h2>';
	$lefttitlename 	= 'Manage Ades';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "classes")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Classes</h2>';
	$lefttitlename 	= 'Manage Classes';
}
 else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items-cat")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Items Category</h2>';
	$lefttitlename 	= 'Manage Items Category';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Manage Sales Invoice</h2>';
	$lefttitlename 	= 'Manage Sales Invoice';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stocksreceives")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Goods Received Note</h2>';
	$lefttitlename 	= 'Goods Received Note';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "reports")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Reports</h2>';
	$lefttitlename 	= 'Reports';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerslogin")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Customers Login</h2>';
	$lefttitlename 	= 'Manage Customers Login';
}
//----------------------------------------
echo '
<!-- Sidebar -->
<div class="sidebar">
<!--SIDE MENU - ONLOAD -->
<div class="sidebar-dropdown"><a href="#">'.$lefttitlename.'</a></div>
<ul id="nav" class="main-nav">
	<div class="nav_logo"> <img class="img-responsive" src="images/logo.png" alt=""> </div>
	<li class="nav_alternative">  
		<ul class="nav_alternative_controls" tabindex="-1" data-reactid=".1.0.1.0">
			<li class="url-link" data-link=""><i class="icon-file-text"></i></li>
			<li class="url-link" data-link=""><i class="icon-list-ul"></i> </li>
			<li class="url-link" data-link=""><i class="icon-time"></i></li>
			<li class="url-link" data-link=""><i class="icon-sitemap"></i></li>
			<li class="url-link" data-link=""><i class="icon-wrench"></i></li>
		</ul>
	</li>
	<li> <a href="dashboard.php" '.$lhomeclsactive.'> <i class="icon-home"></i> Dashboard<span class="pull-right"></span></a> </li> ';

//----------------------------------------
/*if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '2')) {
	echo '<li> <a href="invoices.php" '.$linvsclsactive.'> <i class="icon-credit-card"></i> Manage Invoices<span class="pull-right"></span></a> </li>';
}*/
//----------------------------------------
/*if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '4')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lpaysclsactive.'> <i class="icon-money"></i> Payments<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lpaysvis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '4')) { 
	echo '<li><a href="customerpayments.php">Customer Payments</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '5')) { 
	echo '<li><a href="customercheques.php">Customer Cheque Detail</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '23')) { 
	echo '<li><a href="customerbalancesheet.php">Customer Balance Sheet</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '6')) { 
	echo '<li><a href="vendorpayments.php">Vendor Payments</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '17')) { 
	echo '<li><a href="vendorcheques.php">Vendor Cheque Detail</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '24')) { 
	echo '<li><a href="vendorbalancesheet.php">Vendor Balance Sheet</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '22')) { 
	echo '<li><a href="accounts.php">Chart of Accounts</a></li>';
}

echo '	
		</ul>
	</li>';
}*/

//----------------------------------------
/*if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '9')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lexpnsesclsactive.'> <i class="icon-money"></i> Expense<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lexpnsevis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '20')) { 
	echo '<li><a href="expense.php">Manage Expense</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '21')) { 
	echo '<li><a href="expensecategory.php">Expense Category</a></li>';
}
echo '	
		</ul>
	</li>';
}
*/
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '7')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lledgersclsactive.'> <i class="icon-money"></i> Ledgers<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lledgervis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '7')) { 
	echo '<li><a href="customerledger.php">Customer Ledger</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) { 
	echo '<li><a href="vendorledger.php">Vendor Ledger</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '9')) { 
	echo '<li><a href="stockledger.php">Stock Ledger</a></li>';
}

echo '	
		</ul>
	</li>';
}

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '1')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lsalesclsactive.'> <i class="icon-gift"></i> Manage Sales<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lsalesvis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '1')) { 
	echo '<li><a href="sale-orders.php">Job Orders</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '2')) { 
	echo '<li><a href="sales-invoice.php">Sale Invoices</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '3')) { 
	echo '<li><a href="salereturns.php">Sales Return</a></li>';
}

echo '	
		</ul>
	</li>';
}


//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '4')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lpayssclsactive.'> <i class="icon-money"></i> Manage Payments<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lpayssvis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '6')) { 
	echo '<li><a href="customerpayments.php">Customer Receipts</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '5')) { 
	echo '<li><a href="vendorpayments.php">Vendor Payments</a></li>';
}

echo '	
		</ul>
	</li>';
}

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '2')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lposclsactive.'> <i class="icon-folder-open"></i> Purchases<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lposvis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '4')) { 
	echo '<li><a href="purchase-order.php">Purchase Orders</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '19')) { 
	echo '<li><a href="stocksreceives.php">Goods Received Note</a></li>';
}
echo '
		</ul>
	</li>';
}

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '6')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lpurclsactive.'> <i class="icon-folder-open"></i> Items<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lpurvis.'>';
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '12')) { 
	echo '<li><a href="items.php">Manage Items</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '13')) { 
	echo '<li><a href="items-cat.php">Manage Items Category</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '11')) { 
	echo '<li><a href="vendors.php">Manage Vendors</a></li>';
}
echo '
		</ul>
	</li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '2')) { 
	echo '<li> <a href="customers.php" '.$lcumclsactive.'> <i class="icon-group"></i> Manage Customers<span class="pull-right"></span></a> </li>';
}

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '9')) { 
	echo '<li> <a href="reports.php" '.$lrepsclsactive.'> <i class="icon-folder-open"></i> Reports<span class="pull-right"></span></a> </li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '8')) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lsetclsactive.'> <i class="icon-gears"></i> Setting<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lsetvis.'>';
//----------------------------------------
/*if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '12')) { 
	echo '<li><a href="media.php">Manage Media</a></li>';
}*/

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '14')) { 
	echo '<li><a href="classes.php">Manage Classes</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '15')) { 
	echo '<li><a href="company.php">Manage Company</a></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '16')) { 
	echo '<li><a href="ades.php">Manage ADES</a></li>';
}
	//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '26')) { 
	echo '<li><a href="customerslogin.php">Manage Customers Login</a></li>';
}
	
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 2)) { 
	echo '<li><a href="administrators.php">Manage Admins</a></li>';
}
//-------------------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1)) { 
		echo '
			<li><a href="roles.php">Manage Roles</a></li>
			';
}
//-------------------------------------------------
echo '
		</ul>
	</li>';
//-------------------------------------------------
}
//-------------------------------------------------
echo '
</ul>
<!--SIDE MENU - ONLOAD -->
</div>
<!-- Sidebar ends -->';
?>