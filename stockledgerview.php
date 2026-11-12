<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//------------------------------------------------
	$Itemconditions = array ( 
								'select' 	=> '*',
								'where' 	=> array( 
													'item_id' => cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(ITEMS, $Itemconditions);

//------------------------------------------------
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
	<td width="150"><strong>Item Name:</strong></td>
	<td colspan="3">'.$rowstdpro['item_code'].' - '.$rowstdpro['item_name'].' </td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:center; font-weight:bold;">GRN</th>
	<th style="text-align:left; font-weight:bold; ">Date</th>
	<th style="text-align:left; font-weight:bold; ">Detail</th>
	<th style="text-align:center; font-weight:bold;">Stock IN</th>
	<th style="text-align:center; font-weight:bold;">Stock Out</th>
	<th style="text-align:center; font-weight:bold;">Balance</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno 			= 0;
$totalstockIN 	= 0;
$totastockOut 	= 0;
$balance 		= 0;
	//------------------------------------------------
	$stockconditions = array ( 
								'select' 	=> '*',
								'where' 	=> array( 
													'id_item' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ' grn_date ASC',
								'return_type' 	=> 'all' 
							); 
    $Stocks 		= $dblms->getRows(STOCK, $stockconditions);

	foreach($Stocks as $rowbills) {
//------------------------------------------------
$srno++;
if($rowbills['stock_type'] == 1) {
	$qtyin 		= $rowbills['qty'];
	$debitdisp 	= number_format($rowbills['qty']);
} else {
	$qtyin 		= 0;
	$debitdisp 	= '---';
}
	
if($rowbills['stock_type'] == 2) {
	$qtyout 	= $rowbills['qty'];
	$creditdisp = number_format($rowbills['qty']);
} else {
	$qtyout 	= 0;
	$creditdisp = '----';
}
$balance = ($balance + ($qtyin - $qtyout));
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:center; width:100px;">'.$rowbills['grn'].'</td>
	<td style="text-align:left; width:100px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['grn_date']))).'</td>
	<td style="text-align:left;">'.$rowbills['remarks'].'</td>
	<td style="text-align:center; width:100px;">'.$debitdisp.'</td>
	<td style="text-align:right; width:100px;">'.$creditdisp.'</td>
	<td style="text-align:right; width:100px;">'.number_format($balance).'</td>
</tr>';
//------------------------------------------------
		$totalstockIN 	= ($totalstockIN+ $qtyin);
		$totastockOut 	= ($totastockOut+ $qtyout);
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
	<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totalstockIN).'</th>
	<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totastockOut).'</th>
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