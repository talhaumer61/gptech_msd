<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	
	$Custconditions = array ( 
								'select' 	=> 'c.customer_name, c.customer_cellno, c.customer_email, c.customer_address, ad.ade_name, ad.ade_cellno',
								'join' 		=> "INNER JOIN ".COMPANY." cm ON cm.company_id =  c.id_company
												LEFT JOIN ".ADES." ad ON ad.ade_id =  cm.id_ade",
								'where' 	=> array( 
													'c.customer_id' => cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(CUSTOMERS.' c', $Custconditions);
	
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Customer Ledger Detail</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.png">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element, #tawkchat-minified-container { border:0 !important; }
</style>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp">
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12">
<table class="table table-bordered table-hover">
<tbody>
<tr>
	<td width="150"><strong>Customer Name:</strong></td>
	<td colspan="3"> '.$rowstdpro['customer_name'].'</td>
</tr>
<tr>
	<td><strong>Cell #:</strong></td>
	<td>'.$rowstdpro['customer_cellno'].'</td>
	<td><strong>Email Address:</strong></td>
	<td>'.$rowstdpro['customer_email'].'</td>
</tr>
<tr>
	<td><strong>Ade:</strong></td>
	<td colspan="3">'.$rowstdpro['ade_name'].'</td>
</tr>
</tr>
<tr>
	<td><strong>Contact Person:</strong></td>
	<td>'.$rowstdpro['ade_name'].'</td>
	<td><strong>Contact #:</strong></td>
	<td>'.$rowstdpro['ade_cellno'].'</td>
</tr>
<tr>
	<td><strong>Address:</strong></td>
	<td colspan="3">'.$rowstdpro['customer_address'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Date</th>
	<th style="text-align:left; font-weight:bold; ">Detail</th>
	<th style="text-align:center; font-weight:bold;">Debit</th>
	<th style="text-align:center; font-weight:bold;">Credit</th>
	<th style="text-align:center; font-weight:bold;">Balance</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;

$srno 			= 0;
$totalcredit 	= 0;
$totaldebit 	= 0;
$balance 		= 0;

	$paymentconditions = array ( 
								'select' 	=> 'dated, amount, debit_credit, remarks, docs_types',
								'where' 	=> array( 
													'id_user' 	=> cleanvars($_GET['id']),
													'ledgerfor' => 1
												), 
								'order_by' 		=> ' dated ASC',
								'return_type' 	=> 'all' 
							); 
    $Payments 		= $dblms->getRows(PAYMENTS, $paymentconditions);


	foreach($Payments as $rowbills) {
		
$srno++;
if($rowbills['debit_credit'] == 2) {
	$debit 		= $rowbills['amount'];
	$debitdisp 	= number_format($rowbills['amount']);
} else {
	$debit 		= 0;
	$debitdisp 	= '---';
}
	
if($rowbills['debit_credit'] == 1) {
	$credit 	= $rowbills['amount'];
	$creditdisp = number_format($rowbills['amount']);
} else {
	$credit 	= 0;
	$creditdisp = '----';
}
$balance = ($balance + ($debit - $credit));

echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:left; width:100px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
	<td style="text-align:left;">'.($rowbills['remarks'] ? $rowbills['remarks'] : get_doctype($rowbills['docs_types'])).'</td>
	<td style="text-align:right; width:120px;">'.$debitdisp.'</td>
	<td style="text-align:right; width:120px;">'.$creditdisp.'</td>
	<td style="text-align:right; width:120px;">'.number_format($balance).'</td>
</tr>';

		$totalcredit 	= ($totalcredit+ $credit);
		$totaldebit 	= ($totaldebit+ $debit);
}

echo '
</tbody>
<thead>
<tr>
	<th colspan="3" style="text-align:right; font-weight:bold;"> </th>
	<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totaldebit).'</th>
	<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totalcredit).'</th>
	<th style="text-align:right; font-weight:bold; font-size:16px !important;background-color: mistyrose; color:#f00;">'.number_format($balance).'</th>
</tr>

</thead>
</table>
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>