<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	
	$conditions = array ( 
								'select' 	=> ''.PURCHASE_ORDER.'.*, '.VENDORS.'.vendor_name, '.VENDORS.'.vendor_cellno, '.VENDORS.'.vendor_email',
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
								'where' => array( 
													''.PURCHASE_ORDER.'.purchase_order_id' 	=> cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(PURCHASE_ORDER, $conditions);

	$orderdate = new DateTime($rowstdpro['dated']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Purchase Order Detail</title>
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
	<td><strong>PO #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['po_order_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="purchaseorderprint.php?id='.$rowstdpro['purchase_order_id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>
<tr>	
	<td  width="20%"><strong>Dated:</strong></td>
	<td colspan="3">'.$orderdate->format('d/m/Y').'</td>
</tr>
<tr>
	<td><strong>Vendor Name:</strong></td>
	<td colspan="3">'.$rowstdpro['vendor_name'].' '.$rowstdpro['vendor_cellno'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Item Code</th>
	<th style="text-align:left; font-weight:bold;">Item Name</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Unit Price</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$poconditions = array ( 
								'select' 	=> ''.PURCHASE_ORDER_DETAILS.'.unit_price, '.PURCHASE_ORDER_DETAILS.'.total_price,
												'.PURCHASE_ORDER_DETAILS.'.qty, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id =  ".PURCHASE_ORDER_DETAILS.".id_item",
								'where' => array( 
													''.PURCHASE_ORDER_DETAILS.'.id_po' 	=> cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.PURCHASE_ORDER_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $podetails 	= $dblms->getRows(PURCHASE_ORDER_DETAILS, $poconditions);

	foreach($podetails as $rowbills) {
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:center; width:80px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:60px;">
		'.number_format($rowbills['qty']).'
	</td>
	<td style="text-align:right; width:90px;">
		'.number_format($rowbills['unit_price'], 2).'
	</td>
	<td style="text-align:right; width:90px;">
		'.number_format($rowbills['total_price'], 2).'
	</td>
</tr>';
		
		$totalqty = ($totalqty + $rowbills['qty']);
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;"></td>
	<td style="text-align:center; width:80px;"></td>
	<td style="text-align:right; font-weight:600; color:#00f;">Total Quantity</td>
	<td style="text-align:center; width:60px; color:orangered; font-weight:600; font-size:14px;">
		'.number_format($totalqty).'
	</td>
	<td style="text-align:right; width:90px;"></td>
	<td style="text-align:right; width:90px;"></td>
</tr>
</tbody>
<thead>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Total: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total'], 2).'</th>
</tr>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Prv Balance: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['opening_balance'], 2).'</th>
</tr>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Total Amount: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['grand_total'], 2).'</th>
</tr>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Advance: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['advance'], 2).'</th>
</tr>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Balance: </th>
	<th colspan="4" style="text-align:right; font-weight:bold;">'.number_format(($rowstdpro['grand_total'] - $rowstdpro['advance'])).'</th>
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