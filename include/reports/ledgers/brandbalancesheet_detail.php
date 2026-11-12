<?php 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Brand wise Balance Sheet Detail</title>

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
	border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:3px; background:#f4f4f4; 
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
	window.open("reportledgers.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
	$sql2 	= "";
//------------------------------------------------
	$Addedconditions = array ( 
								'select' 	=> 'adm_fullname',
								'where' 	=> array( 
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
			$sql2 		.= " AND c.id_brand  = '".$idbrand."'";
		}
	}

echo '<div style="width:850px !important; min-height:700px !important; " class="page">
<table width="850" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Balance Sheet
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
		Brand wise Balance Sheet Detail
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
	<td align="left" valign="top" colspan="2">';
//------------------------------------------------

if($idbrand == 'all') {
	$grandtotalBalance 	= 0;
    $grandtotaldebit = 0;
    $grandtotalcrdit = 0;
    $grandopeningtotaldebit = 0;
    $grandopeningtotalcrdit = 0;
	foreach($brandnames as $listbrand) {
$srno = 0;

        $totaldebit = 0;
        $totalcrdit = 0;
        $openingtotaldebit = 0;
        $openingtotalcrdit = 0;
echo '
	<h2 style="text-align:left;">Brand: '.get_brandnames($listbrand['id']).'</h2>
	<table class="datatable" style="margin:3px 0; width:100%;">
	<thead>
	<tr>
		<th rowspan="2" style="text-align:center; width:50px; font-weight:bold;">Sr #</th>
		<th rowspan="2" style="text-align:left; font-weight:bold; ">Customer Name</th>
		<th colspan="2" style="text-align:center; font-weight:bold;width:110px;">
			Opening Balance<div style="font-size:11px;">('.date("M j, Y", strtotime($datefrom)).')</div>
		</th>
		<th colspan="2" style="text-align:center; font-weight:bold;width:110px;">Closing Balance</th>
	</tr>
	<tr>
		<th style="text-align:center; font-weight:bold;">Receivables</th>
		<th style="text-align:center; font-weight:bold;">Payables</th>
		<th style="text-align:center; font-weight:bold;">Receivables</th>
		<th style="text-align:center; font-weight:bold;">Payables</th>
	</tr>
	</thead>
	<tbody>';
		
		///----------------------------------------------
		
		$conditions = array ( 
								'select' 	=> "".CUSTOMERS.".customer_id, ".CUSTOMERS.".customer_name, ".CUSTOMERS.".customer_cellno, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1'  AND ".PAYMENTS.".debit_credit = '2' AND ".PAYMENTS.".dated <'".date("Y-m-d", strtotime($datefrom))."' then ".PAYMENTS.".amount end) as openingTotalDebit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1'  AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated<'".date("Y-m-d", strtotime($datefrom))."' then ".PAYMENTS.".amount end) as openingTotalCredit,
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) then ".PAYMENTS.".amount end) as totalreceivables, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) then ".PAYMENTS.".amount end) as totalpaid ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' 	=> cleanvars($listbrand['id']),
													''.PAYMENTS.'.status' 		=> 1
												), 
								'group_by' 		=> ''.PAYMENTS.'.id_user',
								'order_by' 		=> ''.CUSTOMERS.'.customer_name',
								'return_type' 	=> 'all'
							); 
		$Payments 	= $dblms->getRows(PAYMENTS, $conditions);
		

		foreach($Payments as $rowbalance) {
			$openingbalance = ($rowbalance['openingTotalDebit'] - $rowbalance['openingTotalCredit']);
			$balance = ($openingbalance + ($rowbalance['totalreceivables']  - $rowbalance['totalpaid']));

	$srno++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="text-align:center; width:50px;">'.$srno.'</td>
		<td><a href="customercustomledgerprint.php?id_customer='.$rowbalance['customer_id'].'&fromdate='.date("Y-m-d", strtotime($datefrom)).'&todate='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.$rowbalance['customer_name'].'</a></td>
		<td style="text-align:right;">'.((($openingbalance)>=0) ? number_format($openingbalance) : '').'</td>
        <td style="text-align:right;">'.((($openingbalance)<0) ? number_format(ltrim($openingbalance,'-')) : '').'</td>
        <td style="text-align:right; ">'.((($balance)>=0) ? number_format($balance) : '').'</td>
        <td style="text-align:right; ">'.((($balance)<0) ? number_format(ltrim($balance,'-')) : '').'</td>
	</tr>';
            $totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
            $totalcrdit = ($totalcrdit + ((($balance)<0) ? ltrim($balance,'-') : 0));
            $openingtotaldebit = ($openingtotaldebit + ((($openingbalance)>=0) ? $openingbalance : 0));
            $openingtotalcrdit = ($openingtotalcrdit + ((($openingbalance)<0) ? ltrim($openingbalance,'-') : 0));
		}
	echo '</tbody>
<thead>
    <tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Balance</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotalcrdit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totalcrdit).'</th>
	</tr>
</thead>
</table>';
        $grandtotaldebit        = ( $grandtotaldebit + $totaldebit);
        $grandtotalcrdit        = ($grandtotalcrdit + $totalcrdit);
        $grandopeningtotaldebit = ($grandopeningtotaldebit + $openingtotaldebit);
        $grandopeningtotalcrdit = ($grandopeningtotalcrdit + $openingtotalcrdit);
	//------------------------------------------------
	} // end foreach loop
echo '
<table class="datatable" style="margin:10px 0; width:100%;">
	<thead>
	<tr>
		<th style="text-align:left; font-weight:bold; font-size:20px;">Grand Total</th>
		<th style="text-align:right; width:110px;font-weight:bold;font-size:20px;">'.number_format($grandopeningtotaldebit).'</th>
		<th style="text-align:right; width:110px;font-weight:bold;font-size:20px;">'.number_format($grandopeningtotalcrdit).'</th>
		<th style="text-align:right; width:110px;font-weight:bold;font-size:20px;">'.number_format($grandtotaldebit).'</th>
		<th style="text-align:right; width:110px;font-weight:bold;font-size:20px;">'.number_format($grandtotalcrdit).'</th>
	</tr>
	</thead>
</table>';
} else {

	echo '
	<h2 style="text-align:left;">Brand: '.get_brandnames($idbrand).'</h2>
	<table class="datatable" style="margin:3px 0; width:100%;">
	<thead>
	<tr>
		<th rowspan="2" style="text-align:center; width:50px; font-weight:bold;">Sr #</th>
		<th rowspan="2" style="text-align:left; font-weight:bold; ">Customer Name</th>
		<th colspan="2" style="text-align:center; font-weight:bold;width:110px;">
			Opening Balance<div style="font-size:11px;">('.date("M j, Y", strtotime($datefrom)).')</div>
		</th>
		<th colspan="2" style="text-align:center; font-weight:bold;width:110px;">Closing Balance</th>
	</tr>
	<tr>
		<th style="text-align:center; font-weight:bold;">Receivables</th>
		<th style="text-align:center; font-weight:bold;">Payables</th>
		<th style="text-align:center; font-weight:bold;">Receivables</th>
		<th style="text-align:center; font-weight:bold;">Payables</th>
	</tr>
	</thead>
	<tbody>';
	$srno = 0;
$grandtotalBalance 	= 0;
    $totaldebit = 0;
    $totalcrdit = 0;
    $openingtotaldebit = 0;
    $openingtotalcrdit = 0;
			///----------------------------------------------
		$conditions = array ( 
								'select' 	=> "".CUSTOMERS.".customer_id, ".CUSTOMERS.".customer_name, ".CUSTOMERS.".customer_cellno, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' AND ".PAYMENTS.".dated <'".date("Y-m-d", strtotime($datefrom))."' then ".PAYMENTS.".amount end) as openingTotalDebit, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated <'".date("Y-m-d", strtotime($datefrom))."' then ".PAYMENTS.".amount end) as openingTotalCredit,
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) then ".PAYMENTS.".amount end) as totalreceivables, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE) then ".PAYMENTS.".amount end) as totalpaid ",
								'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
								'where' 	=> array( 
													''.CUSTOMERS.'.id_brand' 	=> cleanvars($idbrand),
													''.PAYMENTS.'.status' 		=> 1
												), 
								'group_by' 		=> ''.PAYMENTS.'.id_user',
								'order_by' 		=> ''.CUSTOMERS.'.customer_name',
								'return_type' 	=> 'all'
							); 
		$Payments 	= $dblms->getRows(PAYMENTS, $conditions);

		foreach($Payments as $rowbalance) {
		$openingbalance = ($rowbalance['openingTotalDebit'] - $rowbalance['openingTotalCredit']);
		$balance = ($openingbalance + ($rowbalance['totalreceivables']  - $rowbalance['totalpaid']));
			$srno++;
	//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; ">'.$srno.'</td>
	<td><a href="customercustomledgerprint.php?id_customer='.$rowbalance['customer_id'].'&fromdate='.date("Y-m-d", strtotime($datefrom)).'&todate='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.$rowbalance['customer_name'].'</a></td>
	<td style="text-align:right;">'.((($openingbalance)>=0) ? number_format($openingbalance) : '').'</td>
	<td style="text-align:right;">'.((($openingbalance)<0) ? number_format(ltrim($openingbalance,'-')) : '').'</td>
	<td style="text-align:right; ">'.((($balance)>=0) ? number_format($balance) : '').'</td>
	<td style="text-align:right; ">'.((($balance)<0) ? number_format(ltrim($balance,'-')) : '').'</td>
</tr>';
	$grandtotalBalance = ($grandtotalBalance + $balance);
            $totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
            $totalcrdit = ($totalcrdit + ((($balance)<0) ? ltrim($balance,'-') : 0));
            $openingtotaldebit = ($openingtotaldebit + ((($openingbalance)>=0) ? $openingbalance : 0));
            $openingtotalcrdit = ($openingtotalcrdit + ((($openingbalance)<0) ? ltrim($openingbalance,'-') : 0));
		} 
	// end while loop
echo '</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Balance</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotalcrdit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totalcrdit).'</th>
	</tr>
</thead>
</table>';
//------------------------------------------------
}
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