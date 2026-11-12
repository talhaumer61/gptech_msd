<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Donations / Gifts Dispatched Report</title>

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
	window.open("reportdispatches.php", "reportdispatches","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
	$sql2 	= "";
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

echo '<div style="width:900px !important; min-height:700px !important; " class="page">
<table width="900" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:20px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Dispatch Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:20px;padding:5px;margin-top:0px; font-weight:600;">
		Donations / Gifts Dispatched Report
	</td>
</tr>

<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		Date: '.date("d-m-Y", strtotime($datefrom)).' - '.date("d-m-Y", strtotime($dateto)).'
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
	<th style="text-align:center; font-weight:bold;">Date</th>
	<th style="text-align:center; font-weight:bold;">DG #</th>
	<th style="text-align:left; font-weight:bold; ">Customer Name</th> 
	<th style="text-align:center; font-weight:bold;">Dispatch Via</th>
	<th style="text-align:right; font-weight:bold;">Amount</th>
	<th style="text-align:center; font-weight:bold;">Dispatch Detail</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno 						= 0;
$grandtotalSales			= 0;
$grandtotalSalesQty			= 0;
$grandtotalReturn			= 0;
$grandtotalReturnQty		= 0;
$grandtotalCGS				= 0;

	$conditions = array ( 
								'select' 	=> ''.DONATIONGIFTS.'.*',
								'where' 	=> array( 
													  ''.DONATIONGIFTS.'.dispatch_status' => 1 
												), 
								'search_by' 	=> " AND ".DONATIONGIFTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)",
								'order_by' 		=> ''.DONATIONGIFTS.'.dated ASC',
								'return_type' 	=> 'all' 
						); 
    $Invoices 	= $dblms->getRows(DONATIONGIFTS, $conditions);

	$total = 0;
	foreach($Invoices as $rowsSale) {
		$total +=  $rowsSale['total'];
		$srno++;
		if($rowsSale['dispatchvia']) {
			$dispatchvia = get_dispatchvia($rowsSale['dispatchvia']);
		} else {
			$dispatchvia = '';
		}
		//------------------------------------------------
		echo '
			<tr>
				<td style="text-align:center; width:40px;">'.$srno.'</td>
				<td style="text-align:center; width:70px;">'.$rowsSale['dated'].'</td>
				<td style="text-align:center; width:90px;">'.$rowsSale['pr_no'].'</td>
				<td>'.$rowsSale['customer_name'].' - '.$rowsSale['customer_cell'].'</td>
				<td style="text-align:center; width:90px;">'.$dispatchvia.'</td>
				<td style="text-align:right; width:90px;">'.number_format($rowsSale['total']).'</td>
				<td style="text-align:left;">
					Dispatch #: '.$rowsSale['dispatchno'].', Bilty #: '.$rowsSale['biltyno'].', Dispatch To: '.$rowsSale['dispatchto'].'-'.$rowsSale['dispatchcellno'].' ('.$rowsSale['dispatchaddress'].')
				</td>
			</tr>';
	}

//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="5" style="text-align:right;"> Grand Total</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($total).'</th>
		<th style="text-align:right;"></th>
	</tr>
</thead>

</table>

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