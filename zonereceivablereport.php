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
	<script type="text/javascript" src="js/jquery/jquery.js"></script>
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
						Receivable Report
					</td>
				</tr>
				<tr>
					<td colspan="2" height="2"> </td>
				</tr>

			</table>
			<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
				<tr>
					<td style="border:1px solid #111; height:25px; text-align:center;font-size:22px;padding:5px;margin-top:0px; font-weight:600;">
						Zone Wise Receivable Report
					</td>
				</tr>
			</table>
			<table  style="width: 100%; border: 0px  dotted #000;">
				<tr>
					<td align="left" valign="top" colspan="2">
						<table  style="float:left;width: 100%;border-collapse:collapse;margin-top:10px" align="left" border="0"  >
							
						</table>
						<table id="receivableTable" class="datatable" style="margin:3px 0; width:100%;">
							<thead>
							<tr>
								<th style="text-align:center;"> Sr #</th>
								<th style="text-align:center;"> Code</th>
								<th> Name</th>
								<th>ADE</th>
								<th>Number Of Schools</th>
								<th>Total Receivable</th>
							</tr>
							</thead>
							<tbody>';

								$conditions = array ( 
														'select' 	=> 'cm.company_id, cm.company_status, cm.company_name, cm.id_ade, cm.company_address, cm.company_code,
																		ad.ade_name, ad.ade_whatsapp, ad.ade_email,
																		COUNT(cs.customer_id) as schools',
														'join' 		=> "LEFT JOIN ".ADES." ad ON ad.ade_id = cm.id_ade
																		LEFT JOIN ".CUSTOMERS." cs ON cs.id_company =  cm.company_id AND cs.customer_status  = '".$_GET['cstatus']."'",
														'not_equal' => array( 
																			'cm.company_id' => 0 
																		), 
														'group_by' 		=> 'cs.id_company',
														'order_by' 		=> 'cm.company_name ASC ',
														'return_type' 	=> 'all' 
													); 
								$Company 	= $dblms->getRows(COMPANY.' cm', $conditions);

								$srno = 0;
								$totalschools = 0;
								$totalbalance = 0;

								foreach($Company as $rowstd) {
									
									$zonebalance = 0;
				
									$sumconditions = array(
																'select'     => "COALESCE(SUM(CASE 
																						WHEN p.ledgerfor = '1' AND p.debit_credit = '2' THEN p.amount 
																					END), 0) as totalreceivables, 
																					COALESCE(SUM(CASE 
																						WHEN p.ledgerfor = '1' AND p.debit_credit = '1' THEN p.amount 
																					END), 0) as totalpaid",
																'join'       => "LEFT JOIN " . PAYMENTS . " p ON cs.customer_id = p.id_user AND p.status = '1'",
																'where'      => array(
																							'cs.customer_status' => $_GET['cstatus'],
																							'cs.id_company'      => $rowstd['company_id']
																						),
																'group_by'   => 'cs.customer_id',
																'return_type'=> 'all'
															);

									$rowsreceivables 	= $dblms->getRows(CUSTOMERS. ' cs', $sumconditions);
									
									foreach($rowsreceivables as $receivable){
										$zbalance = ($receivable['totalreceivables']  - $receivable['totalpaid']);
										if ($zbalance >= 0) {
											$zonebalance += $zbalance;
										}

									}



									$srno++;
									$ctystatus = get_admstatus($rowstd['company_status']);
									$totalschools += $rowstd['schools'];
									$totalbalance += $zonebalance;

									echo '
									<tr>
										<td style="text-align:center; width:50px;">'.$srno.'</td>
										<td style="text-align:center; width:70px;">'.$rowstd['company_code'].'</td>
										<td style="min-width:250px;">'.$rowstd['company_name'].' </td>
										<td>'.$rowstd['ade_name'].'</td>
										<td style="text-align:center;vertical-align: middle;">'.$rowstd['schools'].'</td>
										<td style="text-align:right;vertical-align: middle;">'.number_format($zonebalance).'</td>
									</tr>';
									$totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
								}
								echo '
							</tbody>
							<thead>
								<tr>
									<th colspan="4" style="text-align:center;font-size:16px !important;"> Total Balance</th>
									<th style="text-align:center;">'.$totalschools.'</th>
									<th style="text-align:right;">'.number_format($totalbalance).'</th>
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
</html>
';
?>
<script>
	$(document).ready(function () {
		let table = $('#receivableTable tbody');

		let rows = table.find('tr').get();

		rows.sort(function (a, b) {
			// Get total receivable value from 6th column (index 5)
			let keyA = parseFloat($(a).children('td').eq(5).text().replace(/,/g, '')) || 0;
			let keyB = parseFloat($(b).children('td').eq(5).text().replace(/,/g, '')) || 0;

			return keyB - keyA; // DESCENDING ORDER
		});

		// Re-append and update Sr #
		$.each(rows, function (index, row) {
			$(row).find('td').eq(0).text(index + 1); // Update Sr #
			table.append(row);
		});
	});

</script>
