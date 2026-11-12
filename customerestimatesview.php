<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$conditions = array ( 
								'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_email, '.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, 
												'.ADES.'.ade_name, '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
								'where' 	=> array ( 
														  ''.ESTIMATES.'.estimate_id' 	=> cleanvars($_GET['id'])
													), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstdpro 	= $dblms->getRows(ESTIMATES, $conditions);
	
	$orderdate = new DateTime($rowstdpro['estimate_date']); 
//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Customer Estimate Detail</title>
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
	<td><strong>Estimate #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstdpro['estimate_no'].'</span>
		<span style="float:right;">
			<a class="btn btn-xxs btn-info" href="customerestimatesprint.php?id='.$rowstdpro['estimate_id'].'" target="_blank"><i class="icon-print"></i></a>
		</span>
	</td> 
</tr>
<tr>	
	<td  width="20%"><strong>Dated:</strong></td>
	<td colspan="3">'.$orderdate->format('d/m/Y').'</td>
</tr>
<tr>
	<td><strong>Customer Name:</strong></td>
	<td colspan="3">'.$rowstdpro['customer_name'].' '.$rowstdpro['customer_cellno'].'</td>
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
	$POconditions = array ( 
							  'select' 		=> ''.ESTIMATES_DETAIL.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name'
							, 'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".ESTIMATES_DETAIL.".id_item"
							, 'where' 		=> array( 
															''.ESTIMATES_DETAIL.'.id_estimate' => cleanvars($_GET['id'])
													)
							, 'order_by' 	=> ''.ESTIMATES_DETAIL.'.id ASC' 
							, 'return_type' => 'all' 
						); 
    $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

	foreach($podetails as $rowbills) {
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:center; width:80px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:80px;">
		'.number_format($rowbills['qty']).'
	</td>
	<td style="text-align:right; width:80px;">
		'.number_format($rowbills['unit_price']).'
	</td>

	<td style="text-align:right; width:100px;">
		'.number_format($rowbills['total_price']).'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="5" style="text-align:right; font-weight:bold;">Grand Total: </th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstdpro['estimate_total']).'</th>
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