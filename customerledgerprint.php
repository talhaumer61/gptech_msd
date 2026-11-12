<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINAFOR'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '7')) { 
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
				window.open("customerledgerprint.php", "feechallan","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
			}
		</script>
	</head>

	<body>
		<center>';

			if(isset($_GET['id'])  || ($_SESSION['userlogininfo']['LOGINAFOR'] == 2)) {
				
				if(isset($_GET['id'])) {
					$sql2 = " AND ".CUSTOMERS.".customer_id = ".cleanvars($_GET['id']);
				} elseif(($_SESSION['userlogininfo']['LOGINAFOR'] == 2)) {
					$sql2 = " AND ".CUSTOMERS.".customer_loginid = ".cleanvars($_SESSION['userlogininfo']['LOGINIDA']);
				}
				
				$Custconditions = array ( 
											'select' 		=> '*',
											'join' 			=> "INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
																INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade",
											'not_equal' 	=> array ( 
																		''.CUSTOMERS.'.customer_id' => 0
																	), 
											'search_by' 	=> $sql2,
											'limit' 		=> 1,
											'return_type' 	=> 'single' 
										); 
				$rowstd 	= $dblms->getRows(CUSTOMERS, $Custconditions);
				


				$customerAddress = '';
				if($rowstd['customer_address']){
					$customerAddress = '('.$rowstd['customer_address'].')';
				}
				
				$Addedconditions = array ( 
											'select' 		=> 'adm_fullname',
											'where' 		=> array( 
																		'adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
																	), 
											'limit' 		=> 1,
											'return_type' 	=> 'single' 
										); 
				$rowdesigner 	= $dblms->getRows(ADMINS, $Addedconditions);
				
				echo '
				<div style="width:700px !important; min-height:700px !important; " class="page">
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
							<td height="10" width="60%" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
								Name/Address 
							</td>
							<td height="10" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
								'.$rowstd['company_name'].' 
							</td>
							<td height="10" style="border:1px solid #111; text-align:left; font-size:14px;font-weight:700;padding:8px;padding-right:3px;">
								'.$rowstd['ade_name'].' 
							</td>
							
						</tr>
						<tr>
							<td style="border:1px solid #111; height:40px; text-align:left;font-size:12px;padding:8px;margin-top:0px;" colspan="3">
								'.$rowstd['customer_name'].' '.$customerAddress.'<br> '.$rowstd['customer_cellno'].' / '.$rowstd['customer_contactperson'].'
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
											<th style="text-align:left; font-weight:bold; ">Date</th>
											<th style="text-align:left; font-weight:bold; ">Invoice</th>
											<th style="text-align:left; font-weight:bold; ">Detail</th>
											<th style="text-align:center; font-weight:bold;">Debit</th>
											<th style="text-align:center; font-weight:bold;">Credit</th>
											<th style="text-align:center; font-weight:bold;">Balance</th>
										</tr>
									</thead>
									<tbody>';
										$totalqty = 0;

										$srno 			= 0;
										$totalcredit 	= 0;
										$totaldebit 	= 0;
										$balance 		= 0;
										$invoiceno		= '';

										$Payconditions = array ( 
																	'select' 		=> ''.PAYMENTS.'.id, '.PAYMENTS.'.dated, '.PAYMENTS.'.amount, '.PAYMENTS.'.reference_no, 
																						'.PAYMENTS.'.receipt_no, '.PAYMENTS.'.docs_types, '.PAYMENTS.'.debit_credit, '.PAYMENTS.'.remarks',
																	'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
																	'where' 		=> array ( 
																								  ''.PAYMENTS.'.ledgerfor' => 1
																								, ''.PAYMENTS.'.id_user' => $rowstd['customer_id'] 
																							), 
																	'order_by' 		=> ''.PAYMENTS.'.dated ASC',
																	'return_type' 	=> 'all' 
																); 
										$Payments 	= $dblms->getRows(PAYMENTS, $Payconditions);
						


										foreach($Payments as $rowbills) {
											
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
											
											// sale invoice
											if($rowbills['docs_types'] == 2) {

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
												
												
												$conditions = array ( 
																	'select' 	=> ''.SALES_INVOICE.'.id_customer, '.SALES_INVOICE.'.total, '.SALES_INVOICE.'.freight_charges',
																	'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer ",
																	'where' => array( 
																						''.SALES_INVOICE.'.salesinvoice_id' => cleanvars($rowbills['reference_no'])
																					), 
																	'limit' 		=> 1,
																	'return_type' 	=> 'single' 
																); 
												$valueinvoice 	= $dblms->getRows(SALES_INVOICE, $conditions);
												
												if($rowbills['debit_credit'] == 2) {
													$debit 		= ($valueinvoice['total'] + $valueinvoice['freight_charges']);
													$debitdisp 	= number_format(($valueinvoice['total'] + $valueinvoice['freight_charges']));
												} else {
													$debit 		= 0;
													$debitdisp 	= '---';
												}

												if($valueinvoice['id_customer'] != $rowstd['customer_id']) { 
												/*	$dataInvamount = array(
																			'id_user' => $valueinvoice['id_customer'] 							
																		);

													$qryUpdatePayment = $dblms->Update(PAYMENTS, $dataInvamount, " WHERE id = '".$rowbills['id']."'");*/
													$invoiceno = '<a href="saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank" style="color:#f00;">'.$Invoiceno.'</a>';	
												} else {
													$invoiceno = '<a href="saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$Invoiceno.'</a>';
												}

												

											} else if($rowbills['docs_types'] == 3) {
												// sales retuen	

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

											} else if($rowbills['docs_types'] == 13) {
												// sales retuen	

													if($rowbills['reference_no']<9) {
														$orderno = 'JV-00000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99) {
														$orderno = 'JV-0000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<999) {
														$orderno = 'JV-000'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<9999) {
														$orderno = 'JV-00'.($rowbills['reference_no']);
													} else if($rowbills['reference_no']<99999) {
														$orderno = 'JV-0'.($rowbills['reference_no']);
													}else {
														$orderno = 'JV-'.($rowbills['reference_no']);
													}

													$invoiceno = '<a href="journalvoucherssprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$orderno.'</a>';

											} else {
												$invoiceno = $rowbills['receipt_no'];
											}
											if($rowbills['remarks']) {
												$remarks = $rowbills['remarks'];
											} else {
												$remarks = get_doctype($rowbills['docs_types']);
											}
											
											$balance = ($balance + ($debit - $credit));
											
											echo '
											<tr>
												<td style="text-align:center; width:50px;">'.$rowbills['id'].'</td>
												<td style="text-align:left; width:80px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
												<td style="text-align:left;width:80px;">'.$invoiceno.'</td>
												<td style="text-align:left;">'.$remarks.'</td>
												<td style="text-align:right; width:90px;">'.$debitdisp.'</td>
												<td style="text-align:right; width:90px;">'.$creditdisp.'</td>
												<td style="text-align:right; width:90px;">'.number_format($balance).'</td>
											</tr>';
											
											$totalcredit 	= ($totalcredit+ $credit);
											$totaldebit 	= ($totaldebit+ $debit);
										}

										echo '
									</tbody>
									<thead>
										<tr>
											<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
											<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totaldebit).'</th>
											<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totalcredit).'</th>
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

			}

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
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
?>