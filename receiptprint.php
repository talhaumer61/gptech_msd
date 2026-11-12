<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
if($_SESSION['userlogininfo']['LOGINTYPE']  == 1) {  
//----------------------------------------

echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Receipt Print</title>
<style type="text/css">
body {
	font: normal normal normal 16px/15px  "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
    overflow: -moz-scrollbars-vertical; margin:0; color:#111;
}

h1 { font-size:28px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
h2 { font-size:20px; font-weight:bold; margin-bottom:3px; color:#111; text-transform:uppercase; text-align:center; text-decoration:underline; }
h3 { font-size:18px; font-weight:bold; margin-bottom:7px; margin-top:50px; color:#333; text-transform:uppercase; text-align:center;  }
h4 { font-size:16px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }

table td.label { font-weight:bold; margin: 0; text-align:left; padding:2px; vertical-align:middle !important; }

table.datatable { border: 1px solid #aaa; border-collapse: collapse; border-spacing: 0; }

table.datatable td { border: 1px solid #999; border-collapse:collapse; border-spacing: 0; padding:4px; font-size:13px; color:#000; }

table.datatable th { border: 1px solid #999; border-collapse:collapse; border-spacing: 0; padding:7px; background:#EEEEEE; color:#000;  }

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
	.noprint {
        display: none;
    }
}

</style>
<script language="JavaScript1.2">
function openwindow() {
	window.open("receiptprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
//------------------------------------------------
if(isset($_GET['id'])) {
	//----------------------------------------
	$sqllmspro  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid     
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.pay_type = '1' AND b.id = '".cleanvars($_GET['id'])."' LIMIT 1");
//----------------------------------------
	$rowstdpro = mysqli_fetch_array($sqllmspro);
	$orderdate = new DateTime($rowstdpro['dated']); 
if($rowstdpro['cheque_date'] != '0000-00-00') { 
	$chequedate = new DateTime($rowstdpro['cheque_date']); 
	$datecheque = $chequedate->format('d/m/Y'); 
} else {
	$datecheque = ''; 
}
if($rowstdpro['id_bank']) {
//------------------------------------------------
$sqllmsbank	= $dblms->querylms("SELECT bank_name FROM ".BANKS."
											 WHERE bank_id = '".$rowstdpro['id_bank']."' LIMIT 1");
$rowbank 	= mysqli_fetch_array($sqllmsbank);
$bankname	= ' ('.$rowbank['bank_name'].') ';
//------------------------------------------------
} else { 
	$bankname	= '';
}
//------------------------------------------------
$sqllmsadded	= $dblms->querylms("SELECT adm_fullname FROM ".ADMINS."
											 WHERE adm_id = '".$rowstdpro['id_added']."' LIMIT 1");
$rowadded = mysqli_fetch_array($sqllmsadded);
//------------------------------------------------
//----------------------------------------
echo '<div style="width:700px !important;" class="page">
<a href="customerpayments.php?id='.$rowstdpro['id'].'" class="noprint" style="color:#00F; font-weight:700;" target="_blank"> Edit</a>
<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px;">

<tr>
	<td width="58%" rowspan="3" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:203px; height:150px; margin-top:5px;" align="left"> 
	</td>
	<td width="24%" colspan="2" style="text-align:right; font-size:35px; font-weight:700;padding-right:0; padding-top:20px;">Payment Slip
	<div style="margin-top:50px; text-align:center; font-size:20px;">'.get_pptypes($rowstdpro['type']).'</div>
	</td>
</tr>
</table>

<div style="clear:both;"></div>
<div style="text-align:left;">
	<strong>Slip #:</strong> <span class="label label-info"> <u>'.$rowstdpro['slipno'].'</u></span>
	<span style="float:right;"><strong>Dated:</strong> <u> '.$orderdate->format('d/m/Y').' </u></span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>Customer Name:</strong> <span style="width:80%; border-bottom:1px solid #666; display:inline-block;margin-left:10px; text-align:left;"> '.$rowstdpro['customer_name'].'</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>Rupess:</strong> <span style="width:15%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.number_format($rowstdpro['amount']).' /</span>
	<strong>In words</strong> <span style="width:65%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> ( '.convert_number_to_words($rowstdpro['amount']).') </span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>in Cash / Bank Name Cheque No :</strong> <span style="width:230px; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.get_paytypes($rowstdpro['method']).' '.$bankname.$rowstdpro['cheque'].'</span>
	<strong>Cash Date</strong> <span style="width:20%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$datecheque.'</span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px; text-align:left;">
	<strong>Remarks :</strong> <span style="border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$rowstdpro['remarks'].'</span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px; text-align:left;">
	Received By : <span style="border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$rowadded['adm_fullname'].'</span>
</div>

<div style="clear:both;"></div>

<p style="border-top:1px solid #ccc; width:700px;   font-size:13px;">
	'.SITE_ADDRESS.'
</p>
</div>
<script type="text/javascript">
  setTimeout(function(){if (typeof(window.print) != "undefined") {
    window.print();
    window.close();
}}, 6500);
</script>';
//------------------------------------------------
}
//------------------------------------------------
if(isset($_GET['slipno'])) {
	//----------------------------------------
	$sqllmspro  = $dblms->querylms("SELECT *    
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_paid     
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."' 
										AND b.pay_type = '1' AND b.slipno = '".cleanvars($_GET['slipno'])."' LIMIT 1");
//----------------------------------------
	$rowstdpro = mysqli_fetch_array($sqllmspro);
	$orderdate = new DateTime($rowstdpro['dated']); 
if($rowstdpro['cheque_date'] != '0000-00-00') { 
	$chequedate = new DateTime($rowstdpro['cheque_date']); 
	$datecheque = $chequedate->format('d/m/Y'); 
} else {
	$datecheque = ''; 
}
//------------------------------------------------
if($rowstdpro['id_bank']) {
//------------------------------------------------
$sqllmsbank	= $dblms->querylms("SELECT bank_name FROM ".BANKS."
											 WHERE bank_id = '".$rowstdpro['id_bank']."' LIMIT 1");
$rowbank 	= mysqli_fetch_array($sqllmsbank);
$bankname	= ' ('.$rowbank['bank_name'].') ';
//------------------------------------------------
} else { 
	$bankname	= '';
}
//------------------------------------------------
$sqllmsadded	= $dblms->querylms("SELECT adm_fullname FROM ".ADMINS."
											 WHERE adm_id = '".$rowstdpro['id_added']."' LIMIT 1");
$rowadded = mysqli_fetch_array($sqllmsadded);
//----------------------------------------
echo '<div style="width:700px !important;" class="page">
<a href="customerpayments.php?id='.$rowstdpro['id'].'" class="noprint" style="color:#00F; font-weight:700;" target="_blank"> Edit</a>
<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px;">

<tr>
	<td width="58%" rowspan="3" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:203px; height:150px; margin-top:5px;" align="left"> <a href="javascript:window.print()" class="noprint"><img src="images/printer_icon.png" align="right"></a>
	</td>
	<td width="24%" colspan="2" style="text-align:right; font-size:35px; font-weight:700;padding-right:0; padding-top:20px;">Payment Slip
	<div style="margin-top:50px; text-align:center; font-size:20px;">'.get_pptypes($rowstdpro['type']).'</div>
	
	</td>
</tr>
</table>

<div style="clear:both;"></div>
<div style="text-align:left;">
	<strong>Slip #:</strong> <span class="label label-info"> <u>'.$rowstdpro['slipno'].'</u></span>
	<span style="float:right;"><strong>Dated:</strong> <u> '.$orderdate->format('d/m/Y').' </u></span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>Customer Name:</strong> <span style="width:80%; border-bottom:1px solid #666; display:inline-block;margin-left:10px; text-align:left;"> '.$rowstdpro['customer_name'].'</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>Rupess:</strong> <span style="width:15%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.number_format($rowstdpro['amount']).' /</span>
	<strong>In words</strong> <span style="width:65%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> ( '.convert_number_to_words($rowstdpro['amount']).') </span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px;text-align:left;">
	<strong>in Cash / Bank Name Cheque No :</strong> <span style="width:230px; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.get_paytypes($rowstdpro['method']).' '.$bankname.$rowstdpro['cheque'].'</span>
	<strong>Cash Date</strong> <span style="width:20%; display:inline-block; border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$datecheque.'</span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px; text-align:left;">
	<strong>Remarks :</strong> <span style="border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$rowstdpro['remarks'].'</span>
</div>

<div style="clear:both;"></div>
<div style="margin-top:20px; text-align:left;">
	Received By : <span style="border-bottom:1px solid #666;margin-left:10px;text-align:left;"> '.$rowadded['adm_fullname'].'</span>
</div>

<div style="clear:both;"></div>

<p style="border-top:1px solid #ccc; width:700px;   font-size:13px;">
	'.SITE_ADDRESS.'
</p>
</div>';
//------------------------------------------------
}

//----------------------------------
echo '	
</center>
</body>

</html>';
} else { 
	echo '<h1 style="text-align:center; color:red;">Sorry you have no right to print invoice</h1>';
}
//--------------------------------------------------
?>