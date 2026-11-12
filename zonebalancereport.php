<?php 
include "dbsetting/lms_vars_config.php";
include "dbsetting/classdbconection.php";
$dblms = new dblms();
include "functions/login_func.php";
include "functions/functions.php";
checkCpanelLMSALogin();
echo '
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zone wise Balance Report</title>

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
		window.open("reportsales.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
	}
	</script>
</head>

<body>
	<center>';
		$sql2 	= "";
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
											'select' 		=> 'cm.company_id, cm.company_name, cm.company_code, ad.ade_name, ad.ade_whatsapp, ad.ade_email',
											'join' 			=> 'INNER JOIN '.ADES.' ad ON ad.ade_id = cm.id_ade',
											'where' 		=> array( 
																		'company_status' => '1'
																		,'company_id' 	 => $_GET['id']
																	), 
											'order_by' 		=> 'company_name ASC',
											'return_type' 	=> 'single' 
										); 
		
		$Company = $dblms->getRows(COMPANY. ' cm', $companyconditions);

		echo '
		<div style="width:850px !important; min-height:700px !important; " class="page">
			<table width="850" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

				<tr>
					<td width="58%" rowspan="5" valign="top">
						<img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px" align="left"> 
						<h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
						<h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
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
					<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
						'.$Company['company_name'].' Balance Report ('.get_admstatus($_GET['cstatus']).')
					</td>
				</tr>
				<tr>
					<td style="border:1px solid #111; height:40px; text-align:left;font-size:13px;padding:8px;margin-top:0px;">
						'.$Company['ade_name'].' ('.$Company['company_name'].')<br> '.$Company['ade_whatsapp'].'<br>'.$Company['ade_email'].'
					</td>
					
				</tr>

			</table>
			<table  style="width: 100%; border: 0px  dotted #000;">
				<tr>
					<td align="left" valign="top" colspan="2">';
							$srno = 0;
							$totaldebit        = 0;
							$totalcrdit        = 0;
							$openingtotaldebit = 0;
							$openingtotalcrdit = 0;
						echo '
						<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
							
						</table>
						<table class="datatable" style="margin:3px 0; width:100%;">
							<thead>
							<tr>
								<th style="text-align:center; width:50px; font-weight:bold;">Sr #</th>
								<th style="text-align:left; font-weight:bold; ">Customer Name</th>
								<th style="text-align:left; font-weight:bold; "  width="90px">Cell #</th>
								<th style="text-align:right; font-weight:bold;">Receivables</th>
							</tr>
							</thead>
							<tbody>';

								$conditions = array ( 
														'select' 	=> "c.customer_id, 
																	c.customer_name, 
																	c.customer_personcell, 
																	COALESCE(SUM(CASE 
																		WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
																		THEN p.amount 
																	END), 0) as totalreceivables, 
																	COALESCE(SUM(CASE 
																		WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
																		THEN p.amount 
																	END), 0) as totalpaid,
																	(COALESCE(SUM(CASE 
																		WHEN p.ledgerfor = '1' AND p.debit_credit = '2' 
																		THEN p.amount 
																	END), 0) 
																	- 
																	COALESCE(SUM(CASE 
																		WHEN p.ledgerfor = '1' AND p.debit_credit = '1' 
																		THEN p.amount 
																	END), 0)) as balance",

														'join' 		=> "LEFT JOIN ".PAYMENTS." p ON c.customer_id = p.id_user 
																		AND p.status = 1",

														'where' 	=> array(
															'c.id_company' => cleanvars($Company['company_id']),
															'c.customer_status'     => $_GET['cstatus'] 
														),

														'group_by' 		=> 'c.customer_id',
														'order_by' 		=> 'balance DESC',
														'return_type' 	=> 'all'
													); 

								$Payments = $dblms->getRows(CUSTOMERS. ' c', $conditions);

								
								foreach($Payments as $rowbalance) { 
									$balance = ($rowbalance['totalreceivables']  - $rowbalance['totalpaid']);

									$srno++;

									echo '
									<tr>
										<td style="text-align:center; width:50px;">'.$srno.'</td>
										<td>'.$rowbalance['customer_name'].'</td>
										<td>'. $rowbalance['customer_personcell'] .'</td>
										<td style="text-align:right; ">'.((($balance)>=0) ? number_format($balance) : '').'</td>
									</tr>';
									$totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
								}
								echo '
							</tbody>
							<thead>
								<tr>
									<th colspan="3" style="text-align:center;font-size:16px !important;"> Total Balance</th>
									<th style="text-align:right;font-size:16px !important;">'.number_format($totaldebit).'</th>
								</tr>
							</thead>
						</table>';
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

		echo '	
	</center>
</body>
</html>';