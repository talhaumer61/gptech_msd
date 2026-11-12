<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$sqllmspro  = $dblms->querylms("SELECT *  
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
										AND b.invoice_id = '".cleanvars($_GET['id'])."' LIMIT 1");
//----------------------------------------
	$rowstd = mysqli_fetch_array($sqllmspro);
if($rowstd['invoice_gsttotal']) { 
	$gst = $rowstd['invoice_gsttotal'];
} else { 
	$gst = '';
}
if($rowstd['invoice_ntntotal']) { 
	$ntn = $rowstd['invoice_ntntotal'];
} else { 
	$ntn = '';
}
	$gstntn = ($gst + $ntn);
$invsdate = new DateTime($rowstd['invoice_dated']); 
if($_SESSION['userlogininfo']['LOGINTYPE']  == 1) {  
	$invprint = ' <a class="btn btn-xxs btn-info" href="invoiceprint.php?id='.$rowstd['invoice_id'].'" target="_blank"><i class="icon-print"></i></a>';
} else { 
	$invprint = '';
}

//------------------------------------------------
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Invoice Detail</title>
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
	<td><strong>Invoice #:</strong></td>
	<td colspan="3"><span class="label label-info">'.$rowstd['invoice_no'].'</span>
		<span style="float:right;">
			'.$invprint.'
		</span>
	</td> 
</tr>
<tr>	
	<td  width="15%"><strong>Dated:</strong></td>
	<td>'.$invsdate->format('d/m/Y').'</td>
	<td width="15%"><strong>Customer:</strong></td>
	<td>'.$rowstd['customer_name'].' '.substr($rowstd['customer_cellno'],0,-3).'...</td>
</tr>
</tbody>
</table> 
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold; width:60px;">Job #</th>
	<th style="text-align:left; font-weight:bold; ">Description</th>
	<th style="text-align:left; font-weight:bold;">Media</th>
	<th style="text-align:center; font-weight:bold;">Width</th>
	<th style="text-align:center; font-weight:bold;">Height</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Sqft</th>
	<th style="text-align:center; font-weight:bold;">Rate</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".INVOICE_DETAILS." iv 
												INNER JOIN ".ITEMS." m ON m.item_id = iv.id_item  
												WHERE iv.id_invoice = '".cleanvars($_GET['id'])."' ORDER BY iv.id ASC");
	$countrows = mysqli_num_rows($sqllmsbills);
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;">'.$rowbills['id_order'].'</td>
	<td style="text-align:left;">'.$rowbills['item'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:65px;">'.$rowbills['width'].'</td>
	<td style="text-align:center; width:60px;">'.$rowbills['height'].'</td>
	<td style="text-align:center; width:40px;">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:right; width:40px;">'.$rowbills['sqft'].'</td>
	<td style="text-align:right; width:40px;">'.$rowbills['rate'].'</td>
	<td style="text-align:right;">'.number_format($rowbills['amount']).'</td>
</tr>';

//------------------------------------------------
} // end while loop
//--------------------------------------------------
echo '
<tr>
	<td colspan="8" style="text-align:right; font-weight:700;">Total</td>	
	<td style="text-align:right;">'.number_format($rowstd['invoice_total']).'</td>
</tr>';
if($gstntn) {
echo '
<tr>
	<td colspan="8" style="text-align:right; font-weight:700;">TAX</td>	
	<td style="text-align:right;">'.number_format($gstntn).'</td>
</tr>';
}
echo '
<tr>
	<td colspan="8" style="text-align:right; font-weight:700;">Grand Total</td>	
	<td style="text-align:right;">'.number_format($rowstd['invoice_grand']).'</td>
</tr>';
if($_GET['addedby']) {
echo '
<tr>
	<td colspan="8" style="text-align:right; font-weight:700;">Made by:</td>	
	<td style="text-align:left;">'.$_GET['addedby'].'</td>
</tr>';
}
if($_GET['office']) {
echo '
<tr>
	<td colspan="8" style="text-align:right; font-weight:700;">Location:</td>	
	<td style="text-align:left;">'.$_GET['office'].'</td>
</tr>';
}
echo '
</tbody>
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