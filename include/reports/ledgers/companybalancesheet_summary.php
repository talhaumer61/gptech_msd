<?php 
echo '
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Company wise Balance Sheet Summary</title>

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
		border: 1px solid #888; border-collapse:collapse; border-spacing: 0; padding:5px; background:#f4f4f4; 
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
	$Addedconditions = array ( 
								'select' 		=> 'adm_fullname',
								'where' 		=> array( 
														'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
													), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
    $rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);

	$companyconditions = array ( 
									'select' 		=> 'company_id, company_name, company_code ',
									'where' 		=> array( 
																'company_status' => '1'
															), 
									'order_by' 		=> 'company_name ASC',
									'return_type' 	=> 'all' 
								); 

	if(!empty($idcompany) && !in_array('all', $idcompany)) { 
		$companyconditions['search_by'] = ' AND company_id IN ('.implode(',', $idcompany).')';
	}

	$Company = $dblms->getRows(COMPANY, $companyconditions);

	if(!empty($idbrand) && !in_array('all', $idbrand)) { 
		$brands = " AND ".CUSTOMERS.".id_brand  IN (".implode(',', $idbrand).")";
	}



echo '<div style="width:850px !important; min-height:700px !important; " class="page">
<table width="100%" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

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
		Company wise Balance Sheet Summary
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
		<th rowspan="2" style="text-align:center; width:50px; font-weight:bold;">Sr #</th>
		<th rowspan="2" style="text-align:left; font-weight:bold; ">Company Name</th>
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
//------------------------------------------------
$srno = 0;
$totaldebit = 0;
$totalcrdit = 0;
$openingtotaldebit = 0;
$openingtotalcrdit = 0;
	foreach($Company as $listcompany) {
		
		$sumconditions = array(
								'select'     => "
									COALESCE(SUM(CASE 
										WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
										AND p.dated < '".date("Y-m-d", strtotime($datefrom))."' 
									THEN p.amount END), 0) as openingTotalDebit, 

									COALESCE(SUM(CASE 
										WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
										AND p.dated < '".date("Y-m-d", strtotime($datefrom))."' 
									THEN p.amount END), 0) as openingTotalCredit, 

									COALESCE(SUM(CASE 
										WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
										AND p.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) 
														AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  
									THEN p.amount END), 0) as totalreceivables, 

									COALESCE(SUM(CASE 
										WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
										AND p.dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) 
														AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  
									THEN p.amount END), 0) as totalpaid
								",

								'join'       => "LEFT JOIN ".PAYMENTS." p 
												ON cs.customer_id = p.id_user 
												AND p.status = '1'",

								'where'      => array(
													'cs.id_company'      => cleanvars($listcompany['company_id']),
													'cs.customer_status' => '1'
												),

								'group_by'   => 'cs.customer_id',
								'return_type'=> 'all'
							);

		$rowsreceivables = $dblms->getRows(CUSTOMERS.' cs', $sumconditions);

		// initialise company totals
		$companyOpeningDebit  = 0;
		$companyOpeningCredit = 0;
		$companyReceivable    = 0;
		$companyPayable       = 0;

		foreach($rowsreceivables as $receivable){

			$openingbalance = ($receivable['openingTotalDebit'] - $receivable['openingTotalCredit']);
			$balance        = $openingbalance + ($receivable['totalreceivables'] - $receivable['totalpaid']);

			// separate receivable/payable per customer
			if ($balance >= 0) {
				$companyReceivable += $balance;   // receivables
			} else {
				$companyPayable += abs($balance); // payables
			}

			// also handle opening balances separately
			if ($openingbalance >= 0) {
				$companyOpeningDebit += $openingbalance;
			} else {
				$companyOpeningCredit += abs($openingbalance);
			}
		}

		// now show one row per company
		$srno++;
		echo '
		<tr>
			<td style="text-align:center;">'.$srno.'</td>
			<td><a href="reportledgers.php?reptype=companybalancesheet&repview=detail&idcompany='.$listcompany['company_id'].'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.($listcompany['company_name']).'</a></td>

			<td style="text-align:right;">'.(($companyOpeningDebit > 0) ? number_format($companyOpeningDebit) : '').'</td>
			<td style="text-align:right;">'.(($companyOpeningCredit > 0) ? number_format($companyOpeningCredit) : '').'</td>
			<td style="text-align:right;">'.(($companyReceivable > 0) ? number_format($companyReceivable) : '').'</td>
			<td style="text-align:right;">'.(($companyPayable > 0) ? number_format($companyPayable) : '').'</td>
		</tr>';

		// grand totals across all companies
		$totaldebit         += $companyReceivable;
		$totalcrdit         += $companyPayable;
		$openingtotaldebit  += $companyOpeningDebit;
		$openingtotalcrdit  += $companyOpeningCredit;
		
	}
	
echo '
</tbody>
<thead>
	<tr>
		<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Balance</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($openingtotalcrdit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totaldebit).'</th>
		<th style="text-align:right;font-size:16px !important;">'.number_format($totalcrdit).'</th>
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