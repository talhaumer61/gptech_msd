<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '8')) { 
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Vendors Balance Report</title>
<style type="text/css">
body {
	font: normal normal normal 16px/15px  "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
    overflow: -moz-scrollbars-vertical; margin:0; color:#111;
}
h1 { font-size:28px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
h2 { font-size:20px; font-weight:bold; margin-bottom:3px; color:#111; text-transform:uppercase; text-align:center; text-decoration:underline; }
h3 { font-size:16px; font-weight:bold; color:#333; text-transform:uppercase; text-align:center; }
h4 { font-size:16px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }

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
  }
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
<script language="JavaScript1.2">
function openwindow() {
	window.open("stockledgerprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
}
</script>
</head>

<body>
<center>';
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
		<h4 style="margin-top:10px;font-weight:400;width:280px;">'.SITE_ADDRESS.'</h4>
	</td>
	<td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
	<span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br>
		Balance Report
	</td>
</tr>
<tr>
	<td colspan="2" height="2"> </td>
</tr>

</table>


<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
<tr>
	<td height="5" style="border:1px solid #111; text-align:center; font-size:16px;font-weight:700;padding:8px;padding-right:3px;">
		Date: '.date("F j, Y", strtotime($_POST['fromdate'])).' 
	</td>
	
</tr>
<tr>
	<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
		Vendors Balance Report
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
	<th style="text-align:left; font-weight:bold;">Vendor Name</th>
	<th style="text-align:left; font-weight:bold; ">Cell #</th>
	<th style="text-align:center; font-weight:bold;">Opening Balance</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
	//------------------------------------------------
	$payconditions = array ( 
								'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as totalpayable, 
												SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '2' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as totalpaid, 
												".VENDORS.".vendor_id, ".VENDORS.".vendor_name, ".VENDORS.".vendor_cellno",
								'join' 		=> "INNER JOIN ".VENDORS." ON ".VENDORS.".vendor_id =  ".PAYMENTS.".id_user",
								'not_equal' 	=> array( 
													''.PAYMENTS.'.id' => 0
												), 
								'search_by' 	=> "AND ".PAYMENTS.".dated <= '".date("Y-m-d", strtotime($_POST['fromdate']))."'",
								'group_by' 		=> ''.PAYMENTS.'.id_user',
								'order_by' 		=> 'totalpayable DESC ',
								'return_type' 	=> 'all' 
							); 
    $Payments 	= $dblms->getRows(PAYMENTS, $payconditions);

	
	
$srno = 0;
$totalbalance = 0;
//------------------------------------------------
foreach($Payments as $rowstd) {

//------------------------------------------------
$balance = ($rowstd['totalpayable']  - $rowstd['totalpaid']);


$srno++;
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td>'.$rowstd['vendor_name'].'</td>
	<td>'.$rowstd['vendor_cellno'].'</td>
	<td style="text-align:right; width:110px;">'.number_format($balance).'</td>
</tr>';
	$totalbalance = ($totalbalance + $balance);

} // end while loop
//--------------------------------------------------
echo '
</tbody>
<thead>
<tr>
	<th colspan="3" style="text-align:right;font-size:16px !important;"> Total Payable</th>
	<th style="text-align:right;font-size:16px !important;">'.number_format($totalbalance).'</th>
	
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
//--------------------------------------------------<br>
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
?>