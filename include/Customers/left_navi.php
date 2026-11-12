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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpaynow")) {
	$lopayclsactive = 'class="open"';
	$topayclsactive = 'class="heading-menu-active"';
} else { 
	$lopayclsactive = '';
	$topayclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments")) {
	$lcumclsactive = 'class="open"';
	$tcumclsactive = 'class="heading-menu-active"';
} else { 
	$lcumclsactive = '';
	$tcumclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerledger")) {
	$lempclsactive = 'class="open"';
	$tempclsactive = 'class="heading-menu-active"';
} else { 
	$lempclsactive = '';
	$tempclsactive = '';
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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice")) {
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
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates")) {
	$lestmsclsactive = 'class="open"';
	$testmsclsactive = 'class="heading-menu-active"';
} else { 
	$lestmsclsactive = '';
	$testmsclsactive = '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) { 
	$lefttitlename 	= 'Dashboard';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-home"></i> Dashboard </h2>';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpayments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Customer Receipts</h2>';
	$lefttitlename 	= 'Customer Receipts';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerledger")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> My Ledger</h2>';
	$lefttitlename 	= 'My Ledger';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "complaints")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-envelope"></i> Complaints</h2>';
	$lefttitlename 	= 'Complaints';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sale-orders")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Job Orders</h2>';
	$lefttitlename 	= 'Manage Job Orders';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sales-invoice")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-gift"></i> Manage Invoices</h2>';
	$lefttitlename 	= 'Manage Invoices';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerestimates")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> Manage Estimates</h2>';
	$lefttitlename 	= 'Manage Estimates';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "customerpaynow")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-money"></i> Online Payments</h2>';
	$lefttitlename 	= 'Online Payments';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "myaccount")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-user"></i> Manage Profile</h2>';
	$lefttitlename 	= 'Manage Profile';
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
	<li> <a href="dashboard.php" '.$lhomeclsactive.'> <i class="icon-home"></i> Dashboard<span class="pull-right"></span></a> </li> 
	<li> <a href="customerestimates.php" '.$lestmsclsactive.'> <i class="icon-calendar"></i> Estimates<span class="pull-right"></span></a> </li> 
	<!-- li> <a href="sale-orders.php" '.$lordsclsactive.'> <i class="icon-gift"></i> Job Orders<span class="pull-right"></span></a> </li--> 
	<li> <a href="sales-invoice.php" '.$lsaleclsactive.'> <i class="icon-credit-card"></i> Sale Invoices<span class="pull-right"></span></a> </li>
	<li> <a href="customerledger.php" '.$lempclsactive.'> <i class="icon-money"></i> My Ledger<span class="pull-right"></span></a> </li>
	<li> <a href="complaints.php" '.$lcompclsactive.'> <i class="icon-envelope"></i> Complaints <span class="pull-right"></span></a> </li>';
//-------------------------------------------------
echo '
</ul>
<!--SIDE MENU - ONLOAD -->
</div>
<!-- Sidebar ends -->';
