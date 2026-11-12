<?php 
echo '
<div class="page-head">
	'.$toptitlename.'
	<!-- menu -->
	<div class="heading-menu pull-right responsive-heading-tabs">
		<ul>
			<li style="background-color:green ;">
				<div class="btn-group"> 
					<a href="customerestimates.php?view=add" style="font-weight:600;" > <i class="icon-shopping-cart"></i> <span> Place your books order</span></a> 
				</div>
			</li>
			<li style="background-color:green;">
				<div class="btn-group"> 
					<a '.$topayclsactive.' href="customerpaynow.php" style="font-weight:600;" > <i class="icon-money"></i> <span> Online Payment</span></a> 
				</div>
			</li>
			<li><div class="btn-group"> <a '.$tordsclsactive.' href="sale-orders.php" > <i class="icon-folder-open"></i> <span> Job Orders</span></a> </div></li>
			<li><div class="btn-group"> <a '.$tsaleclsactive.' href="sales-invoice.php"> <i class="icon-credit-card"></i> <span> Sale Invoices</span></a> </div></li>
			<li><div class="btn-group"> <a '.$tempclsactive.' href="customerledger.php"> <i class="icon-money"></i> <span>My Ledger</span></a> </div></li>
			<li><div class="btn-group"> <a href="myaccount.php" style="font-size:13px;"> <i class="icon-user"></i> <span>My Account</span></a> </div></li>';
			if(!empty($_SESSION['rollback_url'])){
				echo '<li><div class="btn-group dropup"> <a class="" href="index.php?logout"> <i class="fa fa-refresh"></i> <span>Switch Back</span></a> </div></li>';
			}
			echo '
			<li><div class="btn-group dropup"> <a class="" href="index.php?logout"> <i class="icon-off"></i> <span>Logout</span></a> </div></li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>';
