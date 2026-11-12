<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINAFOR'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '2')) { 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sale Invoice Print</title>
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

        margin-bottom: 20px;
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
	if(($_SESSION['userlogininfo']['LOGINAFOR'] == 2)) {
		$sql2 = " AND ".CUSTOMERS.".customer_loginid = ".cleanvars($_SESSION['userlogininfo']['LOGINIDA']);
	} else {
		$sql2 = "";
	}
	
	$conditions = array ( 
								'select' 		=> ''.SALES_INVOICE.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name, 
													'.CUSTOMERS.'.customer_openingbalance, '.CUSTOMERS.'.customer_cellno, '.CUSTOMERS.'.customer_address, '.CUSTOMERS.'.customer_invoicelogo, 
													'.JOB_ORDER.'.job_order_id, '.JOB_ORDER.'.job_order_status, '.JOB_ORDER.'.job_order_no, 
													'.JOB_ORDER.'.opening_balance',
								'join' 			=> "INNER JOIN ".JOB_ORDER." ON ".JOB_ORDER.".job_order_id =  ".SALES_INVOICE.".id_joborder 
													INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer",
								'where' 		=> array( 
															''.SALES_INVOICE.'.salesinvoice_id' => cleanvars($_GET['id'])
														), 
								'search_by' 	=> $sql2,
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowInvoice 	= $dblms->getRows(SALES_INVOICE, $conditions);
	
if(empty($rowInvoice)) {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, no result found” </h1>';
} else {	

	$customerAddress = '';
	if($rowInvoice['customer_address']){
		$customerAddress = '('.$rowInvoice['customer_address'].')';
	}
	
	if($rowInvoice['remarks']) {
		$remarks = '<p style="font-size:12px; text-align:left;">Remarks: '.$rowInvoice['remarks'].'</p>';
	} else {
		$remarks = '';
	}
	if($rowInvoice['customer_invoicelogo'] == 2) {
		$invoicelogo 	= 'invoice-lp.jpg';
		$invoiceheading = 'Laurel Publishers';
	} else {
		$invoicelogo 	= 'invoice-logo1.jpg';
		$invoiceheading = SITE_NAME;
	}
	
//----------------------------------------
echo '<div style="width:700px !important; height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/'.$invoicelogo.'" style="width:80; height:75px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.$invoiceheading.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="25%" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span>
		SALES ORDER
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
		S.O. No: 
	</td>
</tr>
<tr>
	<td style="border:1px solid #111; text-align:center; font-size:12px;padding:3px;">
		'.date("F j, Y", strtotime($rowInvoice['dated'])).'
	</td>
	<td style="border:1px solid #111; text-align:center; font-size:14px;padding:3px;">
		'.$rowInvoice['job_order_no'].'
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
	<td style="border:1px solid #111; height:40px; text-align:left;font-size:14px;padding:8px;margin-top:0px;">
		'.$rowInvoice['customer_name'].' '.$customerAddress.'<br> '.$rowInvoice['customer_cellno'].'
	</td>
	
</tr>
</table>
<table  style="float:right;width:212px;border:1px solid #111;border-collapse:collapse;margin-top:10px" align="right" border="0"  >
<tr>
	<td style="text-align:left;  font-size:12px;padding:8px;margin-top:0px;">
		<span>Receipt # </span> '.$rowInvoice['salesinvoice_no'].'
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
<tr height="30">
	<th style="text-align:center; font-weight:bold;">Sr.#</th>
	<th style="text-align:center; font-weight:bold;">Item Code</th>
	<th style="text-align:center; font-weight:bold;">Item Name</th>
	<th style="text-align:center; font-weight:bold;">QTY</th>
	<th style="text-align:center; font-weight:bold;">Unit Price</th>
	<th style="text-align:center; font-weight:bold;">Discount %</th>
	<th style="text-align:center; font-weight:bold;">Total Price</th>
</tr>';
$totalqty = 0;
//------------------------------------------------
$srno = 0;
//------------------------------------------------
	$Odconditions = array ( 
								'select' 		=> ''.SALES_INVOICE_DETAILS.'.*, '.ITEMS.'.item_code, '.ITEMS.'.item_name',
								'join' 			=> "INNER JOIN ".ITEMS." ON ".ITEMS.".item_id = ".SALES_INVOICE_DETAILS.".id_item",
								'where' 		=> array( 
															''.SALES_INVOICE_DETAILS.'.id_salesinvoice' => cleanvars($_GET['id'])
														), 
								'order_by' 		=> ''.SALES_INVOICE_DETAILS.'.id ASC',
								'return_type' 	=> 'all' 
							); 
    $Orderdetail 	= $dblms->getRows(SALES_INVOICE_DETAILS, $Odconditions);

	foreach($Orderdetail as $rowbills) {
//------------------------------------------------
$srno++;
	if($rowbills['discount']) {
		$discountvalue = round(($rowbills['discount']*$rowbills['unit_price'])/100);
	}
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:40px;">'.$srno.'</td>
	<td style="text-align:left; width:70px;">'.$rowbills['item_code'].'</td>
	<td style="text-align:left;">'.$rowbills['item_name'].'</td>
	<td style="text-align:center; width:40px;">
		'.($rowbills['qty']).'
	</td>
	<td style="text-align:right; width:65px;">
		'.number_format($rowbills['unit_price']).'
	</td>
	<td style="text-align:center; width:70px;">
		'.number_format($rowbills['discount']).'
	</td>
	<td style="text-align:right; width:65px;">
		'.number_format($rowbills['total']).'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//--------------------------------------------------
if(count($Orderdetail) <14) { 
//------------------------------------------------
for($ij = count($Orderdetail); $ij <=14; $ij++) { 
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
	<td style="text-align:right;">&nbsp;</td>
</tr>';
//------------------------------------------------
}
}
echo '
<tr>
	<th colspan="5" style="text-align:center;">Grand Total</th>
	<th colspan="2" style="text-align:right;">'.number_format($rowInvoice['total']).'</th>
</tr>
</table>
<table style="margin:2px 0 3px 0; width:400px; float:left;">
<tr>
	<td style="font-size:13px !important;"><b>Note:</b>
		'.INVOICE_NOTE.'
	</td>
</tr>
</table>
<table class="datatable" style="margin:10px 0 3px 0; width:270px; float:right;">
<tr>
	<th style="font-weight:700; text-align:right; border-bottom:0 !important;">Previous Balalnce: </th>
	<th style="font-weight:700;text-align:right; width:50%;">'.number_format($rowInvoice['prev_balance']).' </th>
</tr>
<tr>
	<td style="font-weight:700; text-align:right; border-bottom:0 !important;">Freight Charges: </td>
	<td style="font-weight:700;text-align:right;">'.number_format($rowInvoice['freight_charges']).' </td>
</tr>
<tr>
	<td style="font-weight:700; text-align:right; border-bottom:0 !important;">Total Amount: </td>
	<td style="font-weight:700;text-align:right; width:50%;">'.number_format(($rowInvoice['total'] + $rowInvoice['prev_balance'] + $rowInvoice['freight_charges']) ).' </td>
</tr>
<tr>
	<td style="font-weight:700; text-align:right; border-bottom:0 !important;">Advance: </td>
	<td style="font-weight:700;text-align:right; width:50%;">'.number_format($rowInvoice['paid']).' </td>
</tr>
<tr>
	<th style="font-weight:700; text-align:right; border-bottom:0 !important;">Total Receiveable: </th>
	<th style="font-weight:700;text-align:right; width:50%;">'.number_format(($rowInvoice['total']  + $rowInvoice['prev_balance'] + $rowInvoice['freight_charges']) - $rowInvoice['paid']).' </td>
</tr>
</table>
</td>
</tr>
</table>
'.$remarks.'
<div style="text-align:left; margin-top:100px; font-size:16px; font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; width:850px;">
	<span style="border-top:1px solid #111;">Prepared By:</span>
	<span style="border-top:1px solid #111; margin-left:34%;">Issued By:</span>
	<span style="border-top:1px solid #111;float:right;">Received By:</span>
</div>
<div style="border-top:2px solid #000000; width:100%;  bottom: 1px;  font-size:13px; text-align:center;">
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