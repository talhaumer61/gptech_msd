<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Date Wise Collection Detail</title>

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

	if(($pmode)) { 
		if($pmode == 'all') {
			$sql2 	.= "";
		} else {
			//----------------------------------------
			$sql2 		.= " AND c.id_zone  = '".$pmode."'";
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
		Collection Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>

<table  style="width: 100%; border: 0px  dotted #000;">
<tr>
	<td align="left" valign="top" colspan="2">';
//------------------------------------------------


	echo '
	<h2 style="text-align:left;">Collection Mode: <u>'.get_paytypes($pmode).'</u><span style="float:right; font-size:16px;">Dated: '.date("F j, Y", strtotime($dated)).'</span></h2>
	<table class="datatable" style="margin:3px 0; width:100%;">
	<thead>
	<tr>
		<th style="text-align:center; font-weight:bold;">Sr #</th>
		<th style="text-align:center; font-weight:bold;">Receipt #</th>
		<th style="text-align:left; font-weight:bold; ">Customer Name</th>
		<th style="text-align:center; font-weight:bold; ">Collection Mode</th>
		<th style="text-align:center; font-weight:bold;">Received</th>
	</tr>
	</thead>
	<tbody>';
	$srno = 0;
	$grandtotal 	= 0;
			///----------------------------------------------
		$conditions = array ( 
								'select' 	=> "".CUSTOMERS.".customer_id, ".CUSTOMERS.".customer_name, ".CUSTOMERS.".customer_code, ".PAYMENTS.".id_user,  
												".PAYMENTS.".id, ".PAYMENTS.".amount, ".PAYMENTS.".receipt_no, ".PAYMENTS.".remarks, ".PAYMENTS.".pay_mode",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.PAYMENTS.'.pay_mode' 	=> cleanvars($pmode) ,
													''.PAYMENTS.'.status' 		=> 1 ,
													''.PAYMENTS.'.ledgerfor' 	=> 1 ,
													''.PAYMENTS.'.debit_credit' => 1 ,
													''.PAYMENTS.'.dated' 		=> ($dated)  
												), 
								'search_by' 	=> " AND ".PAYMENTS.".docs_types IN (1,2,4,7)",
								'order_by' 		=> "".CUSTOMERS.".customer_name",
								'return_type' 	=> 'all'
							); 
		$Payments 	= $dblms->getRows(PAYMENTS, $conditions);
		
		foreach($Payments as $rowbalance) {
			$srno++;
	//------------------------------------------------
		

echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:left; width:90px;">'.$rowbalance['receipt_no'].'</td>
	<td>'.$rowbalance['customer_name'].'</a></td>
	<td style="text-align:center; width:110px;">'.get_paytypes($rowbalance['pay_mode']).'</td>
	<td style="text-align:right; width:100px;">'.number_format($rowbalance['amount']).'</td>
</tr>';
	$grandtotal = ($grandtotal + $rowbalance['amount']);
		} 
	// end while loop
echo '</tbody>
<thead>
	<tr>
		<th colspan="4" style="text-align:right;font-size:16px !important;"> Total Received</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($grandtotal).'</th>
	</tr>
</thead>
</table>';
//------------------------------------------------

//--------------------------------------------------
echo '

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