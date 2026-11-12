<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '19')) { 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Goods Received Note Print</title>
<style type="text/css">
body {
	font: normal normal normal 16px/15px  "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
    overflow: -moz-scrollbars-vertical; margin:0; color:#111;
}
h1 { font-size:28px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
h2 { font-size:20px; font-weight:bold; margin-bottom:3px; color:#111; text-transform:uppercase; text-align:center; text-decoration:underline; }
h3 { font-size:18px; font-weight:bold; color:#333; text-transform:uppercase; text-align:center; }
h4 { font-size:14px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }


table td.label { font-weight:bold; margin: 0; text-align:left; padding:2px; vertical-align:middle !important; }

table.datatable { border: 1px solid #333; border-collapse: collapse; border-spacing: 0; margin-top:10px; }

table.datatable td { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:5px; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:15px; color:#000; 
}

table.datatable th { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:7px; background:#f4f4f4; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:14px;  
}

@page { margin: 0cm; width:99% !important; } /* All margins set to 2cm */

@page :first { margin-top: 1cm    /* Top margin on first page 10cm */ }

@media all {
	.page-break	{ display: none; }
}
@media print {
    .page-break	{ display: block; page-break-before: always; }
	@page {
        size: A4 portrait;
    }
}

</style>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<script language="JavaScript1.2">
function openwindow() {
	window.open("stocksreceivesprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
//------------------------------------------------
if($_GET['grn']) {
//------------------------------------------------
		
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
    $rowPurchase 	= $dblms->getRows(STOCK, $conditions);
	
	$vendorAddress = '';
	if($rowPurchase['vendor_address']){
		$vendorAddress = '<br>'.$rowPurchase['vendor_address'];
	}
//------------------------------------------------
/*	$sqllmsdesigner  = $dblms->querylms("SELECT adm_fullname 
											FROM ".ADMINS."
											WHERE adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowdesigner 	= mysqli_fetch_array($sqllmsdesigner);*/
//----------------------------------------
echo '<div style="width:700px !important; height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:5px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:3px;font-weight:400;width:90%;">'.SITE_ADDRESS.'<br>'.MSD_CELLNO.'</h4>
	</td>
	<td width="25%" colspan="2" style="text-align:right; font-size:28px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span>
		GRN DETAILS
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>
<tr>
	<td height="10" style="border:1px solid #111; text-align:center; font-size:14px;font-weight:700;padding:0px;padding-right:3px;">
		Dated: 
	</td>
	<td height="10" style="border:1px solid #111; text-align:center; font-size:14px; font-weight:700; padding:0px; padding-right:3px;">
		GRN No: 
	</td>
</tr>
<tr>
	<td style="border:1px solid #111; text-align:center; font-size:12px;padding:3px;">
		'.date("F j, Y", strtotime($rowPurchase['grn_date'])).'
	</td>
	<td style="border:1px solid #111; text-align:center; font-size:14px;padding:3px;">
		'.$rowPurchase['grn'].'
	</td>
</tr>
</table>

<table  style="float:left;width: 400px;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="10" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
		Name/Address 
	</td>
	
</tr>
<tr>
	<td style="border:1px solid #111; height:40px; text-align:left;font-size:12px;padding:8px;margin-top:0px;">
		'.$rowPurchase['vendor_name'].' '.$vendorAddress.'<br> '.$rowPurchase['vendor_cellno'].'
	</td>
	
</tr>
</table>
<table  style="float:right;width:212px;border:1px solid #111;border-collapse:collapse;margin-top:10px" align="right" border="0"  >
<tr>
	<td style="text-align:left;  font-size:12px;padding:8px;margin-top:0px;">
		<span>Receipt # </span>
	</td>
	
</tr>
<tr>
	<td style="text-align:left;  font-size:12px;padding:8px;margin-top:0px;">
		<span>Book # </span>
	</td>
	
</tr>
<tr>
	<td style="text-align:left;  font-size:12px;padding:8px;margin-top:0px;">
		<span> Date: # </span>
	</td>
	
</tr>
</table>
<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:100%;">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr.#</th>
	<th style="text-align:center; font-weight:bold;">Item Code</th>
	<th style="text-align:left; font-weight:bold;">Item Name</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Unit Price</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</thead>';
$totalqty = 0;
$grandtotal = 0;
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
	<td style="text-align:center; width:70px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:60px;">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:center; width:70px;">'.number_format($rowbills['unitprice']).'</td>
	<td style="text-align:center; width:80px;">'.number_format($rowbills['qty'] * $rowbills['unitprice']).'</td>
	
</tr>';

$totalqty = ($totalqty + $rowbills['qty']);
$grandtotal = ($grandtotal + ($rowbills['qty'] * $rowbills['unitprice']));
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if(count($Stocks) <14) { 
//------------------------------------------------
for($ij = count($Stocks); $ij <=14; $ij++) { 
//------------------------------------------------
echo 
'
<tr>
	<td style="text-align:center;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
</tr>';
//------------------------------------------------
}
}
echo '
<tr>
	<th colspan="3" style="text-align:right;">Total Quantity</th>
	<th style="text-align:center;">'.number_format($totalqty).'</th>
	<th style="text-align:center;"></th>
	<th style="text-align:center;">'.number_format($grandtotal).'</th>
</tr>
</table>

</td>
</tr>
</table>

<div style="border-top:2px solid #000000; width:88%; position: fixed; bottom: 1px;  font-size:13px; text-align:center;">
		<h3 style="margin-bottom:3px; margin-top:5px;">Thank you for your business!</h3>
		<span style="">'.SITE_ADDRESS.'</span>
		<div style="margin-bottom:15px; font-size:14px; text-align:left; ">
			<a href="https://gptech.pk" style="text-decoration:none;" target="_blank">Powered by: Green Professional Technologies</a>
			<span style="font-size:12px; float:right; margin-top:3px;margin-left:30px;">Printed date: '.date("m/d/Y").'</span> 
		</div>
	</div>
</div>
</div>';
//------------------------------------------------
}

//----------------------------------
echo '	
</center>
</body>
<script type="text/javascript">
// setTimeout(function(){if (typeof(window.print) != "undefined") {
//     window.print();
//     window.close();
// }}, 3500);
</script>
</html>';
	
}else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
//--------------------------------------------------
?>