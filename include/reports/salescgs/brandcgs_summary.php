<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Brand Wise Report Sale & CGS Summary</title>

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
	font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:14px; font-weight:600;  
}

@page {
  margin: 1cm; // margin for each printed piece of paper
}

@page :first {
  margin-top: 1cm; // top margin for first page of paper
}

@media print {
  body {
    margin: 0; // 
  }
}

</style>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<script language="JavaScript1.2">
function openwindow() {
	window.open("reportsalescgs.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
	$sql2 	= "";
//------------------------------------------------
	$sqllmsdesigner  = $dblms->querylms("SELECT adm_fullname 
											FROM ".ADMINS."
											WHERE adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowdesigner 	= mysqli_fetch_array($sqllmsdesigner);

	if(($idbrand)) { 
		if($idbrand == 'all') {
			$sql2 	.= "";
		} else {
			//----------------------------------------
			$sql2 		.= " AND b.id_brand  = '".$idbrand."'";
		}
	}

echo '<div style="width:700px !important; min-height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:20px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		CGS Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
		Brand Wise Report Sale & CGS Summary
	</td>
</tr>
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		Date: '.date("F j, Y", strtotime($datefrom)).' - '.date("F j, Y", strtotime($dateto)).'
	</td>
</tr>

</table>



<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">

<table class="datatable" style="margin:3px 0; width:100%;">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Brand Name</th> 
	<th style="text-align:center; font-weight:bold;">Total Sales</th>
	<th style="text-align:center; font-weight:bold;">Return</th>
	<th style="text-align:center; font-weight:bold;">Net Sales</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno = 0;
$grandtotalSales 			= 0;
$grandtotalReturn			= 0;
$grandtotalNetSales			= 0;
$grandtotalReceived 		= 0;
$grandtotalQTY 				= 0;

if($idbrand == 'all') { 
	foreach($brandnames as $listbrand) {
		
		
		/// total sales
		$sqllmstotalSales  = $dblms->querylms("SELECT SUM(b.total) as totalSales 
										FROM ".SALES_INVOICE." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer 
										WHERE  b.salesinvoice_id != '0' 
										AND b.salesinvoice_status IN(3,5) 
										AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) 
										AND c.id_brand  = '".cleanvars($listbrand['id'])."' ");
		$rowtotalsales = mysqli_fetch_array($sqllmstotalSales);
		if(isset($rowtotalsales['totalSales'])) {
			$totalSales = $rowtotalsales['totalSales'];
		} else {
			$totalSales = 0;
		}
		
		/// total sales Return
		$sqllmsSalesReturn  = $dblms->querylms("SELECT SUM(b.deducation_amount) as totalReturn 
										FROM ".SALES_RETURNS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer 
										WHERE  b.job_order_id != '0' 
										AND b.job_order_status IN(3,5) 
										AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) 
										AND c.id_brand  = '".cleanvars($listbrand['id'])."' ");
		$rowsalesreturn = mysqli_fetch_array($sqllmsSalesReturn);
		if(isset($rowsalesreturn['totalReturn'])) {
			$totalReturn = $rowsalesreturn['totalReturn'];
		} else {
			$totalReturn = 0;
		}
		
		
		/// total received
		$sqllmsreceived  = $dblms->querylms("SELECT 
										SUM(CASE WHEN b.ledgerfor = '1' AND b.debit_credit = '1' AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then b.amount end) as totalReceived  
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_user 
										WHERE c.id_brand = '".cleanvars($listbrand['id'])."' 
										AND b.status = '1' ");
		$rowreceived = mysqli_fetch_array($sqllmsreceived);
		
			// check stock
		$sqllmstotalINOUT  = $dblms->querylms("SELECT SUM(CASE WHEN b.stock_type = '2' then b.qty end) as TotalOutQTY, 
													  SUM(CASE WHEN b.stock_type = '1' AND b.reference_type = '3'  then b.qty end) as TotalReturnQTY 
											FROM ".STOCK." b 
											INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_user 
											WHERE b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)
											AND c.id_brand  = '".cleanvars($listbrand['id'])."'");
		$resulttotalInOut = mysqli_fetch_array($sqllmstotalINOUT);

		$actualqty = ($resulttotalInOut['TotalOutQTY'] - $resulttotalInOut['TotalReturnQTY']);


	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:40px;">'.$srno.'</td>
		<td><a href="#" style="text-decoration: none; color:inherit;" title="click to view detail">'.($listbrand['name']).'</a></td>
		<td style="text-align:right; width:100px;">'.number_format($totalSales).'</td>
		<td style="text-align:right; width:100px;">'.number_format($totalReturn).'</td>
		<td style="text-align:right; width:100px;">'.number_format($totalSales-$totalReturn).'</td>
	</tr>';
		$grandtotalSales 		= ($grandtotalSales + $totalSales);
		$grandtotalReturn		= ($grandtotalReturn + $totalReturn);
		$grandtotalNetSales 	= ($grandtotalNetSales + ($totalSales-$totalReturn));
		$grandtotalReceived 	= ($grandtotalReceived + $rowreceived['totalReceived']);
		$grandtotalQTY  		= ($grandtotalQTY  + $actualqty);
	//------------------------------------------------
	} // end foreach loop
} else {
	$srno++;
			
		/// total sales
		$sqllmstotalSales  = $dblms->querylms("SELECT SUM(b.total) as totalSales 
										FROM ".SALES_INVOICE." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer 
										WHERE  b.salesinvoice_id != '0' 
										AND b.salesinvoice_status IN(3,5) 
										AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) 
										AND c.id_brand  = '".cleanvars($idbrand)."' ");
		$rowtotalsales = mysqli_fetch_array($sqllmstotalSales);
		if(isset($rowtotalsales['totalSales'])) {
			$totalSales = $rowtotalsales['totalSales'];
		} else {
			$totalSales = 0;
		}
		
		/// total sales Return
		$sqllmsSalesReturn  = $dblms->querylms("SELECT SUM(b.deducation_amount) as totalReturn 
										FROM ".SALES_RETURNS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_customer 
										WHERE  b.job_order_id != '0' 
										AND b.job_order_status IN(3,5) 
										AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) 
										AND c.id_brand  = '".cleanvars($idbrand)."' ");
		$rowsalesreturn = mysqli_fetch_array($sqllmsSalesReturn);
		if(isset($rowsalesreturn['totalReturn'])) {
			$totalReturn = $rowsalesreturn['totalReturn'];
		} else {
			$totalReturn = 0;
		}
		
		
		/// total received
		$sqllmsreceived  = $dblms->querylms("SELECT 
										SUM(CASE WHEN b.ledgerfor = '1' AND b.debit_credit = '1' AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then b.amount end) as totalReceived  
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_user 
										WHERE c.id_brand = '".cleanvars($idbrand)."' 
										AND b.status = '1' ");
		$rowreceived = mysqli_fetch_array($sqllmsreceived);
		
			// check stock
		$sqllmstotalINOUT  = $dblms->querylms("SELECT SUM(CASE WHEN b.stock_type = '2' then b.qty end) as TotalOutQTY, 
													  SUM(CASE WHEN b.stock_type = '1' AND b.reference_type = '3'  then b.qty end) as TotalReturnQTY 
											FROM ".STOCK." b 
											INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_user 
											WHERE b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)
											AND c.id_brand  = '".cleanvars($idbrand)."'");
		$resulttotalInOut = mysqli_fetch_array($sqllmstotalINOUT);

		$actualqty = ($resulttotalInOut['TotalOutQTY'] - $resulttotalInOut['TotalReturnQTY']);


	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:40px;">'.$srno.'</td>
		<td><a href="#" style="text-decoration: none; color:inherit;" title="click to view detail">'.get_brandnames($idbrand).'</a></td>
		<td style="text-align:right; width:100px;">'.number_format($totalSales).'</td>
		<td style="text-align:right; width:100px;">'.number_format($totalReturn).'</td>
		<td style="text-align:right; width:100px;">'.number_format($totalSales-$totalReturn).'</td>
	</tr>';
		$grandtotalSales 		= ($grandtotalSales + $totalSales);
		$grandtotalReturn		= ($grandtotalReturn + $totalReturn);
		$grandtotalNetSales 	= ($grandtotalNetSales + ($totalSales-$totalReturn));
		$grandtotalReceived 	= ($grandtotalReceived + $rowreceived['totalReceived']);
		$grandtotalQTY  		= ($grandtotalQTY  + $actualqty);
//------------------------------------------------
}


	/// Get average Purchase Price
		$sqllmsPurchaseAvgs  = $dblms->querylms("SELECT 
										ROUND(AVG(d.unit_price),0) AS AVgPrice 
										FROM ".PURCHASE_ORDER_DETAILS." d 
										INNER JOIN ".PURCHASE_ORDER." po ON po.purchase_order_id = d.id_po 
										AND po.po_status  = '1'  
										AND po.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)");
		$rowpurchaseAgv  = mysqli_fetch_array($sqllmsPurchaseAvgs);

		$costgoodsold = ($grandtotalQTY * $rowpurchaseAgv['AVgPrice']);

//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Grand Total</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalReturn).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalNetSales).'</th>
	</tr>
	<tr>
		<th colspan="3" style="text-align:right;font-size:16px !important;"> Total Received</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalReceived).'</th>
	</tr>
	<tr>
		<th colspan="3" style="text-align:right;font-size:16px !important;"> Total Receivable</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalNetSales - $grandtotalReceived).'</th>
	</tr>
	<tr>
		<th colspan="3" style="text-align:right;font-size:16px !important;"> Cost of Good Sold (of Sold Item)</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($costgoodsold).'</th>
	</tr>
	<tr>
		<th colspan="3" style="text-align:right;font-size:16px !important;"> Gross Profit</th>
		<th colspan="2" style="text-align:right;font-size:16px !important;">'.number_format($grandtotalSales - $costgoodsold).'</th>
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
</div>';


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