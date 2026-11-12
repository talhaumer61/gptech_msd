<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '6')) { 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Customer Payment Slip Print</title>
<style type="text/css">
body {
	font: normal normal normal 16px/15px  "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
    overflow: -moz-scrollbars-vertical; margin:0; color:#111;
}
h1 { font-size:25px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
h2 { font-size:18px; font-weight:bold; margin:0px; color:#111; text-transform:uppercase; text-align:center; }
h3 { font-size:15px; font-weight:bold; color:#333; text-transform:uppercase; text-align:center; }
h4 { font-size:14px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }


table td.label { font-weight:bold; margin: 0; text-align:left; padding:2px; vertical-align:middle !important; }

table.datatable { border: 1px solid #333; border-collapse: collapse; border-spacing: 0; margin-top:10px; }

table.datatable td { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:4px; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:14px; color:#000; 
}

table.datatable th { 
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:5px; background:#f4f4f4; 
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:14px;  
}
.t {
	transform-origin: bottom left;
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
	line-height: 1.5;
}
#t9_1{left:281px;bottom:873px;letter-spacing:0.15px;}
#tb_1{left:482px;bottom:873px;letter-spacing:0.2px;word-spacing:-0.02px;}
#t8_1{left:151px;bottom:873px;letter-spacing:0.11px;word-spacing:0.04px;}
.s1_1{font-size:15px;font-family:Calibri_7b;color:#000;}
#ta_1{left:381px;bottom:873px;letter-spacing:0.2px;}
@page {

        margin-bottom: 20px;
        margin-top: 20px;
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
if(isset($_GET['slipid'])) {
//------------------------------------------------
	$conditions = array ( 
								'select' 	=> ''.PAYMENTS.'.pay_mode, '.PAYMENTS.'.dated, SUM('.PAYMENTS.'.amount) as totalamount, 
												'.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.CUSTOMERS.'.customer_cellno, 
												'.CUSTOMERS.'.customer_address, '.CUSTOMERS.'.customer_invoicelogo',
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' => array( 
													''.PAYMENTS.'.systemslip_no' => cleanvars($_GET['slipid']), 
													''.PAYMENTS.'.ledgerfor' 	=> 1, 
													''.PAYMENTS.'.debit_credit' => 1 
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowInvoice 	= $dblms->getRows(PAYMENTS, $conditions);
	
	
if(empty($rowInvoice)) {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, no result found” </h1>';
} else {	

	$customerAddress = '';
	
	if($rowInvoice['customer_invoicelogo'] == 2) {
		$invoicelogo 	= 'invoice-lp.jpg';
		$invoiceheading = 'Laurel Publishers';
	} else {
		$invoicelogo 	= 'invoice-logo1.jpg';
		$invoiceheading = SITE_NAME;
	}
	$marintop = '';
for($ij =1; $ij<=3; $ij++) {
	if($ij>1) {
		$marintop .= " margin-top:15px; padding-top:15px; border-top:2px dashed #888;";
	}
	if($ij == 1) {
		$copyfor = 'Customer Copy';
	} elseif($ij == 2) {
		$copyfor = 'Accounts Copy';
	} else {
		$copyfor = 'File Copy';
	}
//----------------------------------------
echo '<div style="width:750px !important; '.$marintop.'" class="page">
<table width="100%" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">
	<tr>
		<td valign="top" align="center">
			<img src="images/'.$invoicelogo.'" style="width:80; height:70px; margin-top:0px;" align="left"> 
			<h1 style="margin-top:10px;margin-bottom:0px;text-align:center;font-weight:600;">SALES & CREDIT CONTROL DEPARTMENT</h1>
			<h4 style="margin-top:10px;font-weight:400;text-align:center;">'.SITE_ADDRESS.'</h4>
			<h4 style="margin-top:0px;font-weight:400;text-align:center;">'.MSD_CELLNO.'</h4>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">
	<tr>
		<td valign="top" style="width:200px;"> Date: <span style="border-bottom:1px solid #222;">'. date("d/m/Y", strtotime($rowInvoice['dated'])).'</span></td>
		<td valign="top" style="text-align:center;"><h2>RECEIPT VOUCHER</h2></td>
		<td valign="top" style="width:200px;text-align:right;"> Receipt No.<span style="border-bottom:1px solid #222;">CP-2400097</span></td>
	</tr>
</table>

<table width="100%" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse; margin-top:5px;">
	<tr>
		<td valign="top" style="font-weight:600;"> Customer Name: <span style="border-bottom:1px solid #222;font-weight:400;">'. $rowInvoice['customer_name'].'</span></td>
		<td valign="top" style="width:200px; font-weight:600;text-align:right;">('.$copyfor.')</td>
	</tr>
</table>

<table style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:100%;">
<tr height="30">
	<th style="text-align:center; font-weight:bold;">Sr.#</th>
	<th style="text-align:center; font-weight:bold;">Detail</th>
	<th style="text-align:center; font-weight:bold;">Amount</th>
</tr>';

//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">1</td>
	<td style="text-align:left;">Recovery (Old Balance)</td>
	<td style="text-align:right; width:100px;">
		'.number_format($rowInvoice['totalamount']).'
	</td>
</tr>
<tr>
	<td style="text-align:center;">2</td>
	<td style="text-align:left;"> Current Bill Payment</td>
	<td style="text-align:right;">
		
	</td>
</tr>
<tr>
	<td style="text-align:center;">3</td>
	<td style="text-align:left;"> Adcvance Payment</td>
	<td style="text-align:right;">
		
	</td>
</tr>
<tr>
	<td style="text-align:center;">4</td>
	<td style="text-align:left;"> Others</td>
	<td style="text-align:right;">
	
	</td>
</tr>';
//--------------------------------------------------
echo '
<tr>
	<th colspan="2" style="text-align:right;">Total</th>
	<th style="text-align:right;">'.number_format($rowInvoice['totalamount']).'</th>
</tr>
</table>
<span style="font-weight:400;">Paid Mode: <b>'.get_paytypes($rowInvoice['pay_mode']).'</b></span>
</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse; margin-top:5px;">
	<tr>
		<td valign="top"> Memo: <div style="border-bottom:1px solid #222; margin-left:10%;">  </div></td>
		<td valign="top" style="width:200px;">Ref: #<div style="border-bottom:1px solid #222; margin-left:18%;">  </div></td>
	</tr>
</table>

</div>';
}
//------------------------------------------------
}  // end count check 
	
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