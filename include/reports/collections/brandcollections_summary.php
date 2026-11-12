<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Brand wise Collection Summary</title>

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
	window.open("reportcollections.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
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

	if(($idbrand)) { 
		if($idbrand == 'all') {
			$sql2 	.= "";
		} else {
			//----------------------------------------
			$sql2 		.= " AND b.id_brand  = '".$idbrand."'";
		}
	}

echo '<div style="width:800px !important; min-height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:20px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Collection Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
		Brand wise Collection Summary
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
	<th style="text-align:left; font-weight:bold; ">Brand Name</th>';
foreach($pay_types as $listpmode) {
	echo '<th style="text-align:center; font-weight:bold;">'.$listpmode['name'].'</th>';
	
}
echo '
	<th style="text-align:center; font-weight:bold;">Total</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno = 0;
$grandtotal 				= 0;
$grandtotalBank 			= 0;
$grandtotalCash 			= 0;
$grandtotalAccountoffice 	= 0;
$grandtotalPayfast 			= 0;

if($idbrand == 'all') {
	foreach($brandnames as $listbrand) {
		
		///----------------------------------------------
		$conditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalpaid, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalBank, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '4' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalPayfast, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '2' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalCash,
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '3' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalAccountOffice ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' => cleanvars($listbrand['id']) ,
													''.PAYMENTS.'.status' 	=> 1 
												), 
							
								'search_by' 	=> " AND ".PAYMENTS.".docs_types IN (1,2,4,7)",
								'return_type' 	=> 'single'
							); 
		$rowbalance 	= $dblms->getRows(PAYMENTS, $conditions);


	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:40px;">'.$srno.'</td>
		<td><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=all&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.($listbrand['name']).'</a></td>
		<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=1&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to Bank view detail" target="_blank">'.number_format($rowbalance['totalBank']).'</a></td>
		<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=2&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to Cash view detail" target="_blank">'.number_format($rowbalance['totalCash']).'</a></td>
		<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=3&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to A/C Offic view detail" target="_blank">'.number_format($rowbalance['totalAccountOffice']).'</a></td>
		<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=4&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to A/C Offic view detail" target="_blank">'.number_format($rowbalance['totalPayfast']).'</a></td>
		<td style="text-align:right; width:110px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=all&idbrand='.$listbrand['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.number_format($rowbalance['totalpaid']).'</a></td>
	</tr>';
		$grandtotal 	= ($grandtotal + $rowbalance['totalpaid']);
		$grandtotalBank = ($grandtotalBank + $rowbalance['totalBank']);
		$grandtotalCash = ($grandtotalCash + $rowbalance['totalCash']);
		$grandtotalAccountoffice = ($grandtotalAccountoffice + $rowbalance['totalAccountOffice']);
		$grandtotalPayfast = ($grandtotalPayfast + $rowbalance['totalPayfast']);
	//------------------------------------------------
	} // end foreach loop
} else {
	$srno++;
			///----------------------------------------------
		$conditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalpaid, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalBank, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '4' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalPayfast, 
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '2' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalCash,
										SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".pay_mode = '3' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalAccountOffice ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' => cleanvars($idbrand) ,
													''.PAYMENTS.'.status' 	=> 1 
												), 

								'return_type' 	=> 'single'
							); 
		$rowbalance 	= $dblms->getRows(PAYMENTS, $conditions);

echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td><a href="reportcollections.php?reptype=brandcollections&repview=datewise&&pmode=allidbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.get_brandnames($idbrand).'</a></td>
	<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=1&idbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to Bank view detail" target="_blank">'.number_format($rowbalance['totalBank']).'</a></td>
	<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=2&idbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to Cash view detail" target="_blank">'.number_format($rowbalance['totalCash']).'</a></td>
	<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=3&idbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to A/C Offic view detail" target="_blank">'.number_format($rowbalance['totalAccountOffice']).'</a></td>
	<td style="text-align:right; width:100px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=4&idbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to A/C Offic view detail" target="_blank">'.number_format($rowbalance['totalPayfast']).'</a></td>
	<td style="text-align:right; width:110px;"><a href="reportcollections.php?reptype=brandcollections&repview=datewise&pmode=all&idbrand='.$idbrand.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.number_format($rowbalance['totalpaid']).'</a></td>
</tr>';
	$grandtotal 	= ($grandtotal + $rowbalance['totalpaid']);
	$grandtotalBank = ($grandtotalBank + $rowbalance['totalBank']);
	$grandtotalCash = ($grandtotalCash + $rowbalance['totalCash']);
	$grandtotalAccountoffice = ($grandtotalAccountoffice + $rowbalance['totalAccountOffice']);
	$grandtotalPayfast = ($grandtotalPayfast + $rowbalance['totalPayfast']);
//	$grandtotalopeningBalance = ($grandtotalopeningBalance + $openingbalance);
//------------------------------------------------
}
//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Received</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalBank).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalCash).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalAccountoffice).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotalPayfast).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotal).'</th>
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