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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && LMS_VIEW == 'payment_request')) {
	$lpayreqclsactive = 'class="open"';
} else { 
	$lpayreqclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && LMS_VIEW == 'challan_generated')) {
	$lchallanclsactive = 'class="open"';
} else { 
	$lchallanclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "donationgifts")) {
	$ldogfclsactive = 'class="open"';
	$tdogfclsactive = 'class="heading-menu-active"';
} else { 
	$ldogfclsactive = '';
	$tdogfclsactive = '';
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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "newreports")) {
	$lnewrepsclsactive = 'class="open"';
	$tnewrepsclsactive = 'class="heading-menu-active"';
} else { 
	$lnewrepsclsactive = '';
	$tnewrepsclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "complaints")) {
	$lcompclsactive = 'class="open"';
	$tcompclsactive = 'class="heading-menu-active"';
} else { 
	$lcompclsactive = '';
	$tcompclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "callfollowups")) {
	$lcallclsactive = 'class="open"';
	$tcallclsactive = 'class="heading-menu-active"';
} else { 
	$lcallclsactive = '';
	$tcallclsactive = '';
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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stockstaking")) {
	$lstaksclsactive = 'class="open"';
	$tstaksclsactive = 'class="heading-menu-active"';
} else { 
	$lstaksclsactive = '';
	$tstaksclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-order") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stocksreceives") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchasereturns")) {
	$lposclsactive 	= 'class="open"';
	$lposvis		= 'style="display:block; visibility:visible;"';
	$tposclsactive 	= 'class="heading-menu-active"';
} else { 
	$lposclsactive 	= '';
	$lposvis		= '';
	$tposclsactive 	= '';
	
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "backpacks") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items-cat") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendors")) {
	$lpurclsactive 	= 'class="open"';
	$lpurvis		= 'style="display:block; visibility:visible;"';
	$tpurclsactive 	= 'class="heading-menu-active"';
} else { 
	$lpurclsactive 	= '';
	$lpurvis		= '';
	$tpurclsactive 	= '';
	
}

//-----------------Sales -----------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sale-orders") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "salereturns") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerorders") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && !LMS_VIEW)) {
	$lsalesclsactive 	= 'class="open"';
	$lsalesvis			= 'style="display:block; visibility:visible;"';
	$tsalesclsactive 	= 'class="heading-menu-active"';
} else { 
	$lsalesclsactive 	= '';
	$lsalesvis			= '';
	$tsalesclsactive 	= '';	
}


//-----------------Payments -----------------------

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customeronlinepayments") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerspaymentschedule") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorpayments")) {
	$lpayssclsactive 	= 'class="open"';
	$lpayssvis			= 'style="display:block; visibility:visible;"';
	$tpaysclsactive 	= 'class="heading-menu-active"';
} else { 
	$lpayssclsactive 	= '';
	$lpayssvis			= '';
	$tpaysclsactive 	= '';	
}

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerledger") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendorledger") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stockledger") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "journalvouchers")) { 
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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "setting") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "crs") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "administrators") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "company") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "office") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "bank") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "media") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "roles") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "ades") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "classes") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerslogin") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "advancepaymentsetting") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "districts") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "cities") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "paymentscategory")) {
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
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Zone</h2>';
	$lefttitlename 	= 'Manage Zone';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "office")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list-ul"></i> Manage Office</h2>';
	$lefttitlename 	= 'Manage Office';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Receipts</h2>';
	$lefttitlename 	= 'Customer Receipts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customeronlinepayments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Online Receipts</h2>';
	$lefttitlename 	= 'Customer Online Receipts';
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
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage MSD Estimates</h2>';
	$lefttitlename 	= 'Manage MSD Estimates';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase-order")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Purchase Order</h2>';
	$lefttitlename 	= 'Manage Purchase Order';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchasereturns")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Purchase Returns</h2>';
	$lefttitlename 	= 'Manage Purchase Returns';
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
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "crs")) {
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Customer Representatives</h2>';
	$lefttitlename 	= 'Manage Customer Representatives';
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
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "newreports")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> New Reports</h2>';
	$lefttitlename 	= 'New Reports';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "complaints")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Complaints</h2>';
	$lefttitlename 	= 'Complaints';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "callfollowups")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-phone"></i> Call Follow-ups</h2>';
	$lefttitlename 	= 'Call Follow-ups';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerslogin")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Manage Customers Login</h2>';
	$lefttitlename 	= 'Manage Customers Login';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "donationgifts")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-gift"></i> Manage Donations / Gifts</h2>';
	$lefttitlename 	= 'Manage Donations / Gifts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "stockstaking")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-gift"></i> Manage Stocks Taking</h2>';
	$lefttitlename 	= 'Manage Stocks Taking';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "advancepaymentsetting")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-gift"></i> Advance Payment Setting</h2>';
	$lefttitlename 	= 'Advance Payment Setting';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerorders")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-gift"></i> Customers Online Orders</h2>';
	$lefttitlename 	= 'Customers Online Orders';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "cities")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-globe"></i> Manage Cities</h2>';
	$lefttitlename 	= 'Manage Cities';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "districts")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-globe"></i> Manage Districts</h2>';
	$lefttitlename 	= 'Manage Districts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && !LMS_VIEW)) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-folder-open"></i> Customers Estimates</h2>';
	$lefttitlename 	= 'Customers Estimates';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && LMS_VIEW == 'payment_request')) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-credit-card"></i> Payment Request</h2>';
	$lefttitlename 	= 'Customers Estimates';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates" && LMS_VIEW == 'challan_generated')) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-credit-card"></i> Challan Generated</h2>';
	$lefttitlename 	= 'Customers Estimates';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "journalvouchers")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-folder-open"></i> Manage Journal Vouchers</h2>';
	$lefttitlename 	= 'Manage Journal Vouchers';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "paymentscategory")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-folder-open"></i> Manage Payments Category</h2>';
	$lefttitlename 	= 'Manage Payments Category';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerspaymentschedule")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-money"></i> Customers Payments Schedule</h2>';
	$lefttitlename 	= 'Customers Payments Schedule';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "backpacks")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="fa fa-folder-open"></i> Manage Backpacks</h2>';
	$lefttitlename 	= 'Backpacks';
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
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '36')) { 
		echo '<li><a href="journalvouchers.php">Journal Vouchers</a></li>';
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
		echo '<li><a href="sale-orders.php">MSD Estimates</a></li>';
	}
		if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '34')) { 
		echo '<li><a href="customerestimates.php">Customers Estimates</a></li>';
	}
//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '1')) { 
		echo '<li><a href="customerorders.php">Customers Online Orders</a></li>';
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
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '39')) { 
	$countconditions = array ( 
								'select' 		=> ''.ESTIMATES.'.estimate_id'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer"
							, 'where' 		=> array( 
														'is_deleted' => 0 
													)
							, 'search_by' 	=> 'AND '.ESTIMATES.'.estimate_status IN (4)'
							, 'order_by' 	=> ''.ESTIMATES.'.estimate_id DESC '
							, 'return_type' => 'count' 
						); 
	$count 	= $dblms->getRows(ESTIMATES, $countconditions);
	echo '<li> <a href="customerestimates.php?view=payment_request" '.$lpayreqclsactive.'> <i class="icon-credit-card"></i> Payment Request<span class="pull-right badge">'.($count <= '0' ? '0' : $count ).'</span></a> </li>';
}

//----------------------------------------
if(in_array($_SESSION['userlogininfo']['LOGINIDA'], [2, 825])) { 
	echo '<li> <a href="customerestimates.php?view=challan_generated" '.$lchallanclsactive.'> <i class="icon-credit-card"></i> Challan Generated<span class="pull-right"></span></a> </li>';
}

//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '28')) { 
	echo '<li> <a href="donationgifts.php" '.$ldogfclsactive.'> <i class="icon-gift"></i> Donations / Gifts<span class="pull-right"></span></a> </li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '29')) { 
	echo '<li> <a href="stockstaking.php" '.$lstaksclsactive.'> <i class="icon-suitcase"></i> Stocks Taking<span class="pull-right"></span></a> </li>';
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
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '35')) { 
		echo '<li><a href="customeronlinepayments.php">Customer Online Receipts</a></li>';
	}
//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '5')) { 
		echo '<li><a href="vendorpayments.php">Vendor Payments</a></li>';
	}
//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '38')) { 
		echo '<li><a href="customerspaymentschedule.php">Customers Payment Schedules</a></li>';
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
	
//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '27')) { 
		echo '<li><a href="purchasereturns.php">Manage Purchase Returns</a></li>';
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
		echo '<li><a href="backpacks.php">Manage Backpacks</a></li>';
	}
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
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '9')) { 
	echo '<li> <a href="newreports.php" '.$lnewrepsclsactive.'> <i class="icon-folder-open"></i> New Reports<span class="pull-right"></span></a> </li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'type', '8')) {
	echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lsetclsactive.'> <i class="icon-gears"></i> Setting<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lsetvis.'>';
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '31')) { 
		echo '<li><a href="advancepaymentsetting.php">Advance Payment Settings</a></li>';
	}
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '14')) { 
		echo '<li><a href="classes.php">Manage Classes</a></li>';
	}
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '15')) { 
		echo '<li><a href="company.php">Manage Zone</a></li>';
	}
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '16')) { 
		echo '<li><a href="ades.php">Manage ADES</a></li>';
	}
    //----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '16')) {
		echo '<li><a href="crs.php">Customer Representatives</a></li>';
	}
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '26')) { 
		echo '<li><a href="customerslogin.php">Manage Customers Login</a></li>';
	}
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '32')) { 
		echo '<li><a href="cities.php">Manage Cities</a></li>';
	}
	//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '33')) { 
		echo '<li><a href="districts.php">Manage Districts</a></li>';
	}//----------------------------------------
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '37')) { 
		echo '<li><a href="paymentscategory.php">Manage Payments Category</a></li>';
	}
	
	
	
	//----------------------------------------
	if(($_SESSION['userlogininfo']['LOGINIDA'] == 2)) { 
		echo '<li><a href="administrators.php">Manage Admins</a></li>';
	}
	//-------------------------------------------------
	if(($_SESSION['userlogininfo']['LOGINIDA'] == 1)) { 
		echo '<li><a href="roles.php">Manage Roles</a></li>';
	}
	//-------------------------------------------------
	echo '
		</ul>
	</li>';
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '40')) { 
		$queryTasks  = $dblms->querylms("SELECT c.complaint_id
											FROM ".COMPLAINTS." c
											WHERE c.is_deleted != 1
											AND c.complaint_status != 3");
		$count 		   = mysqli_num_rows($queryTasks);

		echo '<li> <a href="complaints.php" '.$lcompclsactive.'> <i class="icon-envelope"></i> Complaints <span class="pull-right"></span><span class="pull-right badge">'.($count <= '0' ? '0' : $count ).'</span></a></li>';
	}
	if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '41')) { 
		
		echo '<li> <a href="callfollowups.php" '.$lcallclsactive.'> <i class="icon-phone"></i> Call Follow-ups <span class="pull-right"></span></a></li>';
	}
}
echo '
</ul>
<!--SIDE MENU - ONLOAD -->
</div>
<!-- Sidebar ends -->';
?>