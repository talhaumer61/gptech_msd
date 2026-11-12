<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
								'select' 		=> '*',
								
								'where' 		=> array( 
														'package_id' => cleanvars($_GET['id'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(PACKAGES, $conditions);
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Sale Package Detail</title>
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
	<td style="width:150px;"><strong>Backpack #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['package_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="backpacksprint.php?id='.$rowstdpro['package_id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>

<tr>
	<td><strong>Backpack Name:</strong></td>
	<td colspan="3">'.$rowstdpro['package_name'].'</td>
</tr>
<tr>
	<td><strong>Class:</strong></td>
	<td colspan="3">'.get_classnames($rowstdpro['id_class']).'</td>
</tr>
<tr>
	<td><strong>Brand:</strong></td>
	<td colspan="3">'.get_brandnames($rowstdpro['id_brand']).'</td>
</tr>
<tr>
	<td><strong>Backpack Detail:</strong></td>
	<td colspan="3">'.$rowstdpro['package_detail'].'</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold; width:50px;">Sr #</th>
	<th style="text-align:left; font-weight:bold;width:100px; ">Item Code</th>
	<th style="text-align:left; font-weight:bold;">Item Name</th>
	<th style="text-align:center; font-weight:bold; width:90px;">Unit Price</th>
	<th style="text-align:center; font-weight:bold; width:70px;">QTY</th>
	<th style="text-align:center; font-weight:bold; width:90px;">Unit Total</th>
</tr>
</thead>
<tbody>';
$totalqty 	 = 0;
$totalamount = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.PACKAGES_DETAIL.'.*, '.ITEMS.'.item_id, 
												'.ITEMS.'.item_code, '.ITEMS.'.item_name, '.ITEMS.'.item_pricesale',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".PACKAGES_DETAIL.".id_item",
								'where' => array( 
													''.PACKAGES_DETAIL.'.id_package' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.PACKAGES_DETAIL.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(PACKAGES_DETAIL, $Odconditions);

	foreach($Orderdetail as $rowbills) { 
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;">'.$srno.'</td>
	<td style="text-align:center; ">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; ">'.number_format($rowbills['item_pricesale']).'</td>
	<td style="text-align:center; ">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:center; ">'.number_format($rowbills['qty'] * $rowbills['item_pricesale']).'</td>
</tr>';
		$totalamount = ($totalamount + ($rowbills['qty'] * $rowbills['item_pricesale']));
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th style="text-align:right; font-weight:bold;" colspan="4">Grand Total</th>
	<th style="text-align:center; font-weight:bold;">'.number_format($rowstdpro['package_qty']).'</th>
	<th style="text-align:center; font-weight:bold;">'.number_format($totalamount).'</th>
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