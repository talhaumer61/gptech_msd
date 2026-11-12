<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();

if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '7')) { 
//----------------------------------------
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Customer Ledger Print</title>
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
.table-blue-fotter{
    position: absolute;
    bottom: 0px;/* for bottom gap */
    left: 0px;
    width:100%;
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
	
@media print {
  .table-blue-fotter {
    position: fixed; /* <-- Key line */
    bottom: 0px;
    left: 0px;
    width: 100%;
  }


</style>
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<script language="JavaScript1.2">
function openwindow() {
	window.open("customerledgerprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
//------------------------------------------------
if(isset($_REQUEST['id_customer'])) {
//------------------------------------------------
	$fdated = date('Y-m-d', strtotime(cleanvars($_REQUEST['fromdate'])));
	$edated = date('Y-m-d', strtotime(cleanvars($_REQUEST['todate'])));
	//----------------------------------------
		//--------------------------------------------------
	$Custconditions = array ( 
								'select' 	=> '*',
								'join' 		=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade",
								'where' 	=> array( 
													''.CUSTOMERS.'.customer_id' => cleanvars($_REQUEST['id_customer'])
												), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowstd 	= $dblms->getRows(CUSTOMERS, $Custconditions);


	$customerAddress = '';
	if($rowstd['customer_address']){
		$customerAddress = '('.$rowstd['customer_address'].')';
	}
	
//--------------------------------------------
	

	
// get  credit Debit Payments of Customer
	$openingconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ledgerfor = '1'  AND debit_credit = '2' then amount end) as TotalDebit, 
												SUM(CASE WHEN ledgerfor = '1'  AND debit_credit = '1' then amount end) as TotalCredit",
								'where' 	=> array( 
													'id_user' 	=> cleanvars($_REQUEST['id_customer']),
													'status' 	=> 1
												), 
								'search_by' 	=> "AND dated <'".$fdated."'",
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $valuedebitcredit 	= $dblms->getRows(PAYMENTS, $openingconditions);

	
	
	$openingbalance = ($valuedebitcredit['TotalDebit'] - $valuedebitcredit['TotalCredit']);
//--------------------------------------------

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
//----------------------------------------
echo '<div style="width:700px !important; min-height:700px !important; " class="page">
<table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

<tr>
	<td width="58%" rowspan="5" valign="top">
		<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
		<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
		<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span>
		Customer Ledger
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		From:  '.$fdated.' - '.$edated.'
	</td>
	
</tr>
<tr>
	<td style="border:1px solid #111; height:25px; text-align:left;font-size:14px; font-weight:600;padding:8px;margin-top:0px;">
		'.$rowstd['customer_name'].' '.$customerAddress.'<br> '.$rowstd['customer_cellno'].'
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
	<th style="text-align:center; font-weight:bold; ">Date</th>
	<th style="text-align:center; font-weight:bold; ">Invoice #</th>
	<th style="text-align:left; font-weight:bold; ">Detail</th>
	<th style="text-align:center; font-weight:bold;">Debit</th>
	<th style="text-align:center; font-weight:bold;">Credit</th>
	<th style="text-align:center; font-weight:bold;">Balance</th>
</tr>
<tr>
	<th style="text-align:center; font-weight:bold; font-size:16px;" colspan="6">Opening Balance</th>
	<th style="text-align:right; font-weight:bold;font-size:16px;">'.number_format($openingbalance).'</th>
</tr>
</thead>
<tbody>';
$totalqty = 0;
//------------------------------------------------
$srno 			= 0;
$totalcredit 	= 0;
$totaldebit 	= 0;
$balance 		= 0;
$invoiceno		= '';
//------------------------------------------------
		$Payconditions = array ( 
								'select' 	=> 'dated, amount, reference_no, docs_types, debit_credit, remarks ',
								'where' 	=> array( 
													'id_user' 	=> cleanvars($_REQUEST['id_customer']),
													'ledgerfor' => 1
												), 
								'search_by' 	=> " AND (dated BETWEEN '".$fdated."' AND '".$edated."')",
								'order_by' 		=> ' dated ASC, id ASC',
								'return_type' 	=> 'all' 
							); 
    $Payments 	= $dblms->getRows(PAYMENTS, $Payconditions);

if(empty($Payments)) {
 echo '
<tr>
	<td style="text-align:center;" colspan="7"><h4 style="font-size:16px font-weight:600; color:#f00;">No detail found</h4></td>
</tr>';
} else {

foreach($Payments as $rowbills) {
//------------------------------------------------
$srno++;
if($rowbills['debit_credit'] == 2) {
	$debit 		= $rowbills['amount'];
	$debitdisp 	= number_format($rowbills['amount']);
} else {
	$debit 		= 0;
	$debitdisp 	= '---';
}
	
if($rowbills['debit_credit'] == 1) {
	$credit 	= $rowbills['amount'];
	$creditdisp = number_format($rowbills['amount']);
} else {
	$credit 	= 0;
	$creditdisp = '----';
}
$openingbalance = ($openingbalance + ($debit - $credit));
//------------------------------------------------
// sale invoice
if($rowbills['docs_types'] == 2) {
//------------------------------------------------
	if($rowbills['reference_no']<9) {
		$Invoiceno = 'INV-00000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<99) {
		$Invoiceno = 'INV-0000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<999) {
		$Invoiceno = 'INV-000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<9999) {
		$Invoiceno = 'INV-00'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<99999) {
		$Invoiceno = 'INV-0'.($rowbills['reference_no']);
	} else {
		$Invoiceno = 'INV-'.($rowbills['reference_no']);
	}
	
	$invoiceno = '<a href="saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$Invoiceno.'</a>';
	
}
// sales retuen	
if($rowbills['docs_types'] == 3) {
//------------------------------------------------
	
	if($rowbills['reference_no']<9) {
		$orderno = 'SR-00000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<99) {
		$orderno = 'SR-0000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<999) {
		$orderno = 'SR-000'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<9999) {
		$orderno = 'SR-00'.($rowbills['reference_no']);
	} else if($rowbills['reference_no']<99999) {
		$orderno = 'SR-0'.($rowbills['reference_no']);
	}else {
		$orderno = 'SR-'.($rowbills['reference_no']);
	}

	
	$invoiceno = '<a href="salesreturnprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$orderno.'</a>';
	
}
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center; width:50px;">'.$srno.'</td>
	<td style="text-align:left; width:80px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
	<td style="text-align:left; width:80px;">'.$invoiceno.'</td>
	<td style="text-align:left;">'.$rowbills['remarks'].'</td>
	<td style="text-align:right; width:80px;">'.$debitdisp.'</td>
	<td style="text-align:right; width:80px;">'.$creditdisp.'</td>
	<td style="text-align:right; width:100px;">'.number_format($openingbalance).'</td>
</tr>';
//------------------------------------------------
		$totalcredit 	= ($totalcredit+ $credit);
		$totaldebit 	= ($totaldebit+ $debit);
} // end while loop
} // end check records
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
	<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totaldebit).'</th>
	<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totalcredit).'</th>
	<th style="text-align:right; font-weight:bold; font-size:16px !important;background-color: mistyrose; color:#f00;">'.number_format($openingbalance).'</th>
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
</div>

<table class="" style="margin-top:50px;width:100%;">
  <tr>
    <td>
<div style="border-top:2px solid #000000; width:100%; font-size:13px; text-align:center;">
		<h3 style="margin-bottom:3px; margin-top:5px;">Thank you for your business!</h3>
		<span style="">'.SITE_ADDRESS.'</span>
		<div style="margin-bottom:15px; font-size:14px; text-align:left; ">
			<a href="https://gptech.pk" style="text-decoration:none;" target="_blank">Powered by: Green Professional Technologies</a>
			<span style="font-size:12px; float:right; margin-top:3px;margin-left:30px;">Printed date: '.date("m/d/Y").'</span> 
		</div>
	</div>
</div>
</td>
</tr>
</table>';
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
} else {
	echo '<h1 style="margin-top: 200px; color: #f00; font-weight: 600; text-align: center;">Sorry, you have no right to access this page</h1>';
	
}
//--------------------------------------------------
?>