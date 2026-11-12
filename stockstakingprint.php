<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINAFOR'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '29')) { 
//----------------------------------------
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Stocks Taking Print</title>
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

@page {

        margin-bottom: 40px;
        counter-increment: page;

        @bottom-right {
            border-top: 1px solid #000000;
            padding-right:20px;
            font-size: 12px !important;
            content: "Page " counter(page) " of " counter(pages);
        }
        @bottom-left {
            content: "Footer content goes here.";
            border-top: 1px solid #000000;
        }

    }

</style>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<script language="JavaScript1.2">
function openwindow() {
	window.open("ordersprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
//------------------------------------------------
if(isset($_GET['id'])) {
//------------------------------------------------
	$conditions = array ( 
							  'select' 		=> '*'
							, 'where' 		=> array( 
														'id' => cleanvars($_GET['id'])
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $rowstd 	= $dblms->getRows(STOCKS_TAKING, $conditions);


	
	if(empty($rowstd)) {
		echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, no result found” </h1>';
	} else {
//------------------------------------------------
	$Addedconditions = array ( 
								'select' 		=> 'adm_fullname',
								'where' 		=> array( 
															'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);
//----------------------------------------
echo '<div style="width:700px !important; height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="25%" colspan="2" style="text-align:right; font-size:18px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span>
		STOCKS TAKING
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
		ST. No: 
	</td>
	
	
</tr>
<tr>
	<td style="border:1px solid #111; text-align:center; font-size:12px;padding:3px;">
		'.date("F j, Y", strtotime($rowstd['taking_date'])).'
	</td>
	<td style="border:1px solid #111; text-align:center; font-size:14px;padding:3px;">
		'.$rowstd['taking_no'].'
	</td>
</tr>
';

echo'
</table>

<table  style="float:left;width: 400px;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="10" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
		Taking By
	</td>
	
</tr>
<tr>
	<td style="border:1px solid #111; height:40px; text-align:left;font-size:14px;padding:8px;margin-top:0px;">
		'.$rowstd['taking_by'].'
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
<thead>
		<tr>
			<th style="text-align:center;vertical-align: middle;" rowspan="2">Sr. #</th>
			<th style="text-align:left;vertical-align: middle;" rowspan="2">Items </th>
			<th style="text-align:center;" colspan="2">System Stock</th>
			<th style="text-align:center;" colspan="2">Physically stock</th>
			<th style="text-align:center;" colspan="2">Difference</th>
		</tr>
			
		<tr>
			<th style="text-align:center;width:50px;">QTY</th>
			<th style="text-align:center;width:70px;">Amount</th>
			<th style="text-align:center;width:50px;">QTY</th>
			<th style="text-align:center;width:70px;">Amount</th>
			<th style="text-align:center;width:50px;">QTY</th>
			<th style="text-align:center;width:70px;">Amount</th>
		</tr>
	</thead>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno 		 = 0;
$totaldiffer = 0;
$totalamount = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 	=> ''.STOCKS_TAKINGDETAIL.'.*, '.ITEMS.'.item_id, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 		=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".STOCKS_TAKINGDETAIL.".id_item",
								'where' => array( 
													''.STOCKS_TAKINGDETAIL.'.id_taking' => cleanvars($rowstd['id'])
												), 
								'order_by' 		=> ''.STOCKS_TAKINGDETAIL.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail = $dblms->getRows(STOCKS_TAKINGDETAIL, $Odconditions);

	foreach($Orderdetail as $rowbills) {
//------------------------------------------------
$srno++;
	$stockdiffer = ($rowbills['physically_stock'] - $rowbills['system_stock']);
	$amountiffer = ($rowbills['physically_stockamount'] - $rowbills['system_stockamount']);
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	
	<td style="text-align:left;">'.$rowbills['item_code'].' - '.$rowbills['item_name'].'</td>
	<td style="text-align:center;">
		'.number_format($rowbills['system_stock']).'
	</td>
	<td style="text-align:right;">
		'.number_format($rowbills['system_stockamount']).'
	</td>
	<td style="text-align:right;">
		'.number_format($rowbills['physically_stock']).'
	</td>
	<td style="text-align:right;">
		'.number_format($rowbills['physically_stockamount']).'
	</td>
	<td style="text-align:right;">
		'.number_format($stockdiffer).'
	</td>
	<td style="text-align:right;">
		'.number_format($rowbills['physically_stockamount'] - $rowbills['system_stockamount']).'
	</td>
</tr>';
if($stockdiffer>0) {
	$totaldiffer = ($totaldiffer + ($stockdiffer));
}
if($amountiffer>0) {
	$totalamount = ($totalamount + ($amountiffer));
}
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if(count($Orderdetail) <14) { 
//------------------------------------------------
for($ij = count($Orderdetail); $ij <=14; $ij++) { 
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
	<td style="text-align:right;">&nbsp;</td>
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
</tbody>
<thead>
<tr>
	<th colspan="2" style="text-align:right; font-weight:bold;">Grand Total: </th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstd['total_systemstock']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstd['total_systemstockamount']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstd['total_physicallystock']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($rowstd['total_physicallyamount']).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($totaldiffer).'</th>
	<th style="text-align:right; font-weight:bold;">'.number_format($totalamount).'</th>
</tr>
</thead>
</table>

	</td>
</tr>
<tr>
  <td valign="bottom" align="left">
<table  border="0" style="margin:100px 0 0 0; width:130px;">
<tr>
	<td align="center" style="font-weight:500;">'.$rowdesigner['adm_fullname'].'</td>
</tr>
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #111;">Prepared By</td>
</tr>
</table>
	</td>
	<td valign="bottom" align="right">
<table  border="0" style="margin:20px 0 0 0; width:130px;">
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #111;">Director</td>
</tr>
</table>

	</td>
</tr>
</table>
<div style="border-top:2px solid #000000; width:88%;  bottom: 1px;  font-size:13px; text-align:center;">
		<h3 style="margin-bottom:3px; margin-top:5px;">Thank you for your business!</h3>
		<span style="">'.SITE_ADDRESS.'</span>
		<div style="margin-bottom:15px; font-size:14px; text-align:left; ">
			<a href="https://gptech.pk" style="text-decoration:none;" target="_blank">Powered by: Green Professional Technologies</a>
			<span style="font-size:12px; float:right; margin-top:3px;margin-left:30px;">Printed date: '.date("m/d/Y").'</span> 
		</div>
	</div>
</div>';
//------------------------------------------------
	}  // end if result found 
} // end id check 

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
//--------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
?>