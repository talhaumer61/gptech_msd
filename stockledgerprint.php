<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '9')) { 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Stock Ledger Print</title>
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
	window.open("stockledgerprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
//------------------------------------------------
if($_GET['id']) {
//------------------------------------------------
//------------------------------------------------
	$Itemconditions = array ( 
								  'select' 		=> '*'
								, 'where' 		=> array( 
															'item_id' => cleanvars($_GET['id'])
														)
								, 'limit' 			=> 1
								, 'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(ITEMS, $Itemconditions);


//------------------------------------------------
	$Addedconditions = array ( 	
								  'select' 			=> 'adm_fullname'
								, 'where' 			=> array( 
																'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
															) 
								, 'limit' 			=> 1
								, 'return_type' 	=> 'single' 
							); 
    $rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);
//----------------------------------------
echo '<div style="width:750px !important; min-height:700px !important; " class="page">
<table width="750" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Stock Ledger
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="10" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
		Item Name 
	</td>
	
</tr>
<tr>
	<td style="border:1px solid #111; height:40px; text-align:left;font-size:14px;font-weight:700;padding:8px;margin-top:0px;">
		'.$rowstd['item_code'].' - '.$rowstd['item_name'].'
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
	<th style="text-align:center; font-weight:bold;">Reference #</th>
	<th style="text-align:left; font-weight:bold; ">Date</th>
	<th style="text-align:left; font-weight:bold; ">Detail</th>
	<th style="text-align:center; font-weight:bold;">Stock IN</th>
	<th style="text-align:center; font-weight:bold;">Stock Out</th>
	<th style="text-align:center; font-weight:bold;">Balance</th>
</tr>
</thead>
<tbody>';

$totalqty = 0;
//------------------------------------------------
$srno 			= 0;
$totalstockIN 	= 0;
$totastockOut 	= 0;
$balance 		= 0;
//------------------------------------------------
	$stockconditions = array ( 
								  'select' 		=> '*'
								, 'where' 		=> array( 
															'id_item' => cleanvars($_GET['id'])
														) 
								, 'order_by' 	=> 'grn_date ASC'
								, 'return_type' => 'all' 
							); 
    $Stocks 		= $dblms->getRows(STOCK, $stockconditions);

	foreach($Stocks as $rowbills) {
//------------------------------------------------
		$srno++;
		if($rowbills['stock_type'] == 1) {
			$qtyin 		= $rowbills['qty'];
			$debitdisp 	= number_format($rowbills['qty']);
		} else {
			$qtyin 		= 0;
			$debitdisp 	= '---';
		}

		if($rowbills['stock_type'] == 2) {
			$qtyout 	= $rowbills['qty'];
			$creditdisp = number_format($rowbills['qty']);
		} else {
			$qtyout 	= 0;
			$creditdisp = '----';
		}
	
		$balance = ($balance + ($qtyin - $qtyout));
		
// links
	if($rowbills['stock_type'] == 1 && $rowbills['reference_type'] == 4) { 
		
		$viewlinks 		= '';
		$customername  	= $rowbills['remarks'];
	}else if($rowbills['reference_type'] == 5) { 
		
		$viewlinks 		= '<a href="stockstakingprint.php?id='.$rowbills['grn_id'].'" target="_blank">'.$rowbills['grn'].'</a>';
		$customername  	= $rowbills['remarks'];
	}else if($rowbills['stock_type'] == 1 && $rowbills['reference_type'] == 1) { 
		$Grnconditions = array ( 
							  'select' 		=> ''.VENDORS.'.vendor_name'
							, 'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_ORDER.".id_vendor"
							, 'where' 		=> array( 
														''.PURCHASE_ORDER.'.purchase_order_id' 	=> cleanvars($rowbills['reference_no']) 
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    	$rowstdpro 	= $dblms->getRows(PURCHASE_ORDER, $Grnconditions);
		$viewlinks 		= '<a href="stocksreceivesprint.php?grn='.$rowbills['grn_id'].'" target="_blank">'.$rowbills['grn'].'</a>';
		$customername  	= $rowstdpro['vendor_name'];
	
	} else if($rowbills['stock_type'] == 2 && $rowbills['reference_type'] == 2) {
		
		$Invconditions = array ( 
								  'select' 		=> ''.SALES_INVOICE.'.salesinvoice_id, '.SALES_INVOICE.'.salesinvoice_no, 
													'.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer"
								, 'where' 		=> array( 
														''.SALES_INVOICE.'.salesinvoice_id' => cleanvars($rowbills['reference_no'])
														)
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$valueinvoice 	= $dblms->getRows(SALES_INVOICE, $Invconditions);
		if($valueinvoice>1) {
			$viewlinks 		= '<a href="saleinvoiceprint.php?id='.$valueinvoice['salesinvoice_id'].'" target="_blank">'.$valueinvoice['salesinvoice_no'].'</a>';
			$customername 	= $valueinvoice['customer_name'];
		} else {
			$viewlinks 		= '';
			$customername 	= '';
		}
	} else if($rowbills['stock_type'] == 1 && $rowbills['reference_type'] == 3) {
		
		$Rtnconditions = array ( 
								  'select' 		=> ''.SALES_RETURNS.'.job_order_id, '.SALES_RETURNS.'.job_order_no, 
													'.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_name'
								, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_RETURNS.".id_customer"
								, 'where' 		=> array( 
														''.SALES_RETURNS.'.job_order_id' => cleanvars($rowbills['reference_no'])
														)
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$valuereturn 	= $dblms->getRows(SALES_RETURNS, $Rtnconditions);
		$viewlinks 		= '<a href="salesreturnprint.php?id='.$valuereturn['job_order_id'].'" target="_blank">'.$valuereturn['job_order_no'].'</a>';
		$customername 	= $valuereturn['customer_name'];
	} else if($rowbills['stock_type'] == 2 && ($rowbills['reference_type'] == 10 || $rowbills['reference_type'] == 11)) { 
		$dgconditions 	= array ( 
									  'select' 		=> 'pr_id, pr_no, customer_name, customer_cell'
									, 'where' 		=> array( 
																'pr_id' => cleanvars($rowbills['reference_no'])
														) 
									, 'limit' 		=> 1
									, 'return_type' => 'single' 
								); 
    	$valuedg 		= $dblms->getRows(DONATIONGIFTS, $dgconditions);
		
		$viewlinks 		= '<a href="donationgiftsprint.php?id='.$valuedg['pr_id'].'" target="_blank">'.$valuedg['pr_no'].'</a>';
		$customername 	= $valuedg['customer_name'];
	} else if($rowbills['stock_type'] == 2 && ($rowbills['reference_type'] == 8)) { 
		$preturnconditions = array ( 
								  'select' 		=> ''.PURCHASE_RETURNS.'.pr_no, '.PURCHASE_RETURNS.'.pr_id, '.VENDORS.'.vendor_name'
								, 'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PURCHASE_RETURNS.".id_vendor"
								, 'where' 		=> array ( 
															''.PURCHASE_RETURNS.'.pr_id' 	=> cleanvars($rowbills['reference_no'])
														)
								, 'limit' 		=> 1
								, 'return_type' => 'single' 
							); 
		$rowpreturn 	= $dblms->getRows(PURCHASE_RETURNS, $preturnconditions);
		
		$viewlinks 		= '<a href="purchasesreturnprint.php?id='.$rowpreturn['pr_id'].'" target="_blank">'.$rowpreturn['pr_no'].'</a>';
		$customername 	= $rowpreturn['vendor_name'];
	} else {
		$viewlinks 		= '';
		$customername  	= '';
	}
		
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:left; width:80px;">'.$viewlinks.'</td>
	<td style="text-align:left; width:90px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['grn_date']))).'</td>
	<td style="text-align:left;">'.$customername.'</td>
	<td style="text-align:right; width:70px;">'.$debitdisp.'</td>
	<td style="text-align:right; width:70px;">'.$creditdisp.'</td>
	<td style="text-align:right; width:70px;">'.number_format($balance).'</td>
</tr>';
//------------------------------------------------
		$totalstockIN 	= ($totalstockIN+ $qtyin);
		$totastockOut 	= ($totastockOut+ $qtyout);
} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
	<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totalstockIN).'</th>
	<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totastockOut).'</th>
	<th style="text-align:right; font-weight:bold; font-size:16px !important;background-color: mistyrose; color:#f00;">'.number_format($balance).'</th>
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
//--------------------------------------------------
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
//--------------------------------------------------
?>