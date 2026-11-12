<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
								'select' 	=> '*',
								'join' 		=> "INNER JOIN ".PURCHASE_ORDER." ON ".PURCHASE_ORDER.".purchase_order_id = ".STOCK.".reference_no 
												INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor",
								'where' => array( 
													''.STOCK.'.grn_id' 		=> cleanvars($_GET['grn']) 
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(STOCK, $conditions);

	$orderdate = new DateTime($rowstdpro['grn_date']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Goods Received Note Detail</title>
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
	<td><strong>GRN #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['grn'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="stocksreceivesprint.php?grn='.$rowstdpro['grn_id'].'" target="_blank"><i class="icon-print"></i></a>
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
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$stockconditions = array ( 
								'select' 	=> '*',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCK.".id_item",
								'where' => array( 
													''.STOCK.'.grn_id' 			=> cleanvars($_GET['grn']) ,
													''.STOCK.'.reference_type' 	=> 1 ,
													''.STOCK.'.stock_type' 		=> 1 
												), 
								'order_by' 		=> ''.STOCK.'.id ASC ',
								'return_type' 	=> 'all' 
							); 
    $Stocks 	= $dblms->getRows(STOCK, $stockconditions);

	foreach($Stocks as $rowbills) {
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:center; width:80px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:100px;">'.number_format($rowbills['qty']).'</td>
</tr>';
		
	$totalqty = ($totalqty + $rowbills['qty']);
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="3" style="text-align:right; font-weight:bold;">Total Quantity: </th>
	<th style="text-align:center; font-weight:bold; font-size:16px;">'.number_format($totalqty).'</th>
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