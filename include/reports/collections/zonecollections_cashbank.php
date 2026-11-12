<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cash / Bank Collection Zone Wise Summary</title>

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
	$sqllmsdesigner  = $dblms->querylms("SELECT adm_fullname 
											FROM ".ADMINS."
											WHERE adm_id = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowdesigner 	= mysqli_fetch_array($sqllmsdesigner);


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
		Zone wise Cash / Bank Collection Summary
	</td>
</tr>

</table>

<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">
	<h2 style="text-align:left;">Zone: <u>'.get_zonenames($idzone).'</u><span style="float:right; font-size:16px;">Date: '.date("M j, Y", strtotime($datefrom)).' - '.date("M j, Y", strtotime($dateto)).'</span></h2>
<table class="datatable" style="margin:3px 0; width:100%;">
<thead>
<tr>
	<th style="text-align:center; font-weight:bold;">Sr #</th>
	<th style="text-align:left; font-weight:bold; ">Collection Mode</th>
	<th style="text-align:center; font-weight:bold;">Received</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srno = 0;
$grandtotal 	= 0;

	foreach($pay_types as $listpmode) {
		
		///----------------------------------------------
		$sqllmsbalance  = $dblms->querylms("SELECT 
										SUM(CASE WHEN b.ledgerfor = '1' AND b.debit_credit = '1' AND b.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then b.amount end) as totalpaid 
										FROM ".PAYMENTS." b 
										INNER JOIN ".CUSTOMERS." c ON c.customer_id = b.id_user 
										WHERE b.pay_mode  = '".cleanvars($listpmode['id'])."' 
										AND c.id_zone = '".cleanvars($idzone)."' 
										AND b.docs_types IN (1,2,4,7)
										AND b.status = '1' ");
		$rowbalance = mysqli_fetch_array($sqllmsbalance);		

	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:50px;">'.$srno.'</td>
		<td><a href="reportcollections.php?reptype=zonecollections&repview=detail&idzone='.$idzone.'&pmode='.$listpmode['id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.($listpmode['name']).'</a></td>
		<td style="text-align:right; width:110px;">'.number_format($rowbalance['totalpaid']).'</td>
	</tr>';
	$grandtotal = ($grandtotal + $rowbalance['totalpaid']);
	//------------------------------------------------
	} // end foreach loop

//--------------------------------------------------
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Received</th>
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