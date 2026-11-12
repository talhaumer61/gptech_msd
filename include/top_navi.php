<?php 
echo '
<div class="page-head">
	'.$toptitlename.'
<!-- menu -->
<div class="heading-menu pull-right responsive-heading-tabs">
<ul>';
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '1')) { 
	echo '<li><div class="btn-group"> <a '.$tordsclsactive.' href="sale-orders.php" > <i class="icon-folder-open"></i> <span> Job Orders</span></a> </div></li>';
}
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '3')) { 
	echo '<li><div class="btn-group"> <a '.$tsaleinvclsactive.' href="sales-invoice.php"> <i class="icon-credit-card"></i> <span> Sale Invoices</span></a> </div></li>';
}
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '4')) { 
	echo '<li><div class="btn-group"> <a '.$tpaysclsactive.' href="customerpayments.php"> <i class="icon-money"></i> <span>Payments</span></a> </div></li>';
}
//----------------------------------------
if( ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '18')) { 
	echo '<li><div class="btn-group"> <a '.$tledgerclsactive.' href="customerledger.php"> <i class="icon-money"></i> <span>Customer Ledger</span></a> </div></li>';
}

//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) { 
	echo '<li><div class="btn-group"> <a '.$tpurchaseorderclsactive.' href="purchase-order.php"> <i class="icon-folder-open"></i> <span>Purchase Orders</span></a> </div></li>';
}

//----------------------------------------
echo '
	<li><div class="btn-group dropup"> <a class="" href="index.php?logout"> <i class="icon-off"></i> <span>Logout</span></a> </div></li>
</ul>
</div>
	<div class="clearfix"></div>
</div>';
?>