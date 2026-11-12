<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'id' 	=> cleanvars($_GET['id'])
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $rowstdpro 	= $dblms->getRows(STOCKS_TAKING, $conditions);

	$orderdate = new DateTime($rowstdpro['taking_date']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Stock Taking Detail</title>
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
	<td><strong>ST #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['taking_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="stockstakingprint.php?id='.$rowstdpro['id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>
<tr>	
	<td  width="20%"><strong>Dated:</strong></td>
	<td colspan="3">'.$orderdate->format('d/m/Y').'</td>
</tr>
<tr>
	<td><strong>Taking By:</strong></td>
	<td colspan="3">'.$rowstdpro['taking_by'].'</td>
</tr>
<tr>
	<td><strong>Remarks:</strong></td>
	<td colspan="3">'.$rowstdpro['remarks'].'</td>
</tr>
</tbody>
</table> 


<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
		<tr>
			<th style="text-align:center;vertical-align: middle;" rowspan="2">Sr. #</th>
			<th style="text-align:left;vertical-align: middle;" rowspan="2">Items </th>
			<th style="text-align:center;" colspan="2">System Stock</th>
			<th style="text-align:center;" colspan="2">Physically stock</th>
			<th style="text-align:center;" colspan="2">Difference</th>
		</tr>
			
		<tr>
			<th style="text-align:center;width:80px;">QTY</th>
			<th style="text-align:center;width:120px;">Amount</th>
			<th style="text-align:center;width:80px;">QTY</th>
			<th style="text-align:center;width:120px;">Amount</th>
			<th style="text-align:center;width:80px;">QTY</th>
			<th style="text-align:center;width:100px;">Amount</th>
		</tr>
	</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.STOCKS_TAKINGDETAIL.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCKS_TAKINGDETAIL.".id_item",
								'where' => array( 
													''.STOCKS_TAKINGDETAIL.'.id_taking' => cleanvars($_GET['id'])
												), 
								'order_by' 		=> ''.STOCKS_TAKINGDETAIL.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(STOCKS_TAKINGDETAIL, $Odconditions);

	foreach($Orderdetail as $rowbills) { 
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	
	<td style="text-align:left;">'.$rowbills['item_code'].' - '.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:70px;">
		'.number_format($rowbills['system_stock']).'
	</td>
	<td style="text-align:right; width:100px;">
		'.number_format($rowbills['system_stockamount']).'
	</td>
	<td style="text-align:right; width:70px;">
		'.number_format($rowbills['physically_stock']).'
	</td>
	<td style="text-align:right; width:100px;">
		'.number_format($rowbills['physically_stockamount']).'
	</td>
	<td style="text-align:right; width:70px;">
		'.number_format($rowbills['system_stock'] - $rowbills['physically_stock']).'
	</td>
	<td style="text-align:right; width:100px;">
		'.number_format($rowbills['system_stockamount'] - $rowbills['physically_stockamount']).'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="2" style="text-align:right; font-weight:bold;">Grand Total: </th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_systemstock']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_systemstockamount']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_physicallystock']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_physicallyamount']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_systemstock'] - $rowstdpro['total_physicallystock']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['total_systemstockamount'] - $rowstdpro['total_physicallyamount']).'</th>
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