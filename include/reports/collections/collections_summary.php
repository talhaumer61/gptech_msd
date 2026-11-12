<?php 
echo '
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cash / Bank Collection Summary</title>

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

		$idcompany = is_array($idcompany) ? $idcompany : [$idcompany];
		if(!empty($idcompany) && !in_array('all', $idcompany)) { 
			$companyconditions['search_by'] = ' AND company_id IN ('.implode(',', $idcompany).')';
		}
		
		$Company = $dblms->getRows(COMPANY, $companyconditions);

		// if(!empty($idcompany) && !in_array('all', $idcompany)) { 
		// 	$companies = " AND ".CUSTOMERS.".id_company  IN (".implode(',', $idcompany).")";
		// }

		if(!empty($idbrand) && !in_array('all', $idbrand)) { 
			$brands = " AND ".CUSTOMERS.".id_brand  IN (".implode(',', $idbrand).")";
		}

		echo '
		<div style="width:700px !important; min-height:700px !important; " class="page">
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
						Cash / Bank Collection Summary
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
										<th style="text-align:left; font-weight:bold; width:380px;">Zone Name</th>';
										foreach($pay_types as $listpmode) {
											if($pmode == 'all' || $pmode == $listpmode['id']) {
												echo '<th style="text-align:right; font-weight:bold; ">'.($listpmode['name']).'</th>';
											}
										}
										echo '<th style="text-align:center; font-weight:bold;">Total</th>
									</tr>
								</thead>
								<tbody>';

									$srno = 0;
									$grandtotal 	= 0;
									foreach($Company as $listcompany) {
										
										

										$srno++;
									
										echo '
										<tr>
											<td style="text-align:center; width:50px;">'.$srno.'</td>
											<td><a href="reportcollections.php?reptype=collections&repview=detail&pmode='.$pmode.'&datefrom='.date("Y-m-d", strtotime($datefrom)).'&dateto='.date("Y-m-d", strtotime($dateto)).'&idcompany='.cleanvars($listcompany['company_id']).'&idbrand='.implode(',', $idbrand).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.($listcompany['company_name']).'</a></td>';
											
											$total = 0;
											foreach($pay_types as $listpmode) {
												if($pmode == 'all' || $pmode == $listpmode['id']) {

													$conditions = array ( 
																			'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' AND ".PAYMENTS.".dated BETWEEN CAST('".date("Y-m-d", strtotime($datefrom))."' AS DATE) AND CAST('".date("Y-m-d", strtotime($dateto))."' AS DATE)  then ".PAYMENTS.".amount end) as totalpaid ",
																			'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
																			'where' 	=> array( 
																									''.PAYMENTS.'.pay_mode' 		=> cleanvars($listpmode['id']) ,
																									''.PAYMENTS.'.status' 			=> 1 
																								, ''.CUSTOMERS.'.id_company' 	=> cleanvars($listcompany['company_id'])
																								, ''.CUSTOMERS.'.customer_status'=> 1
																								), 

																			'search_by' 	=> " AND ".PAYMENTS.".docs_types IN (1,2,4,7) ".$brands.$companies."",
																			'return_type' 	=> 'single'
																		); 
													$rowbalance 	= $dblms->getRows(PAYMENTS, $conditions);		
													echo '<td style="text-align:right; width:110px;">'.number_format($rowbalance['totalpaid']).'</td>';
													$total = ($total + $rowbalance['totalpaid']);

													if($pmode == 'all'){
														$pmodeamounts[$listpmode['id']] = isset($pmodeamounts[$listpmode['id']]) ? $pmodeamounts[$listpmode['id']] + $rowbalance['totalpaid'] : $rowbalance['totalpaid'];
													}else{
														$pmodeamounts[$listpmode['id']] = isset($pmodeamounts[$listpmode['id']]) ? $pmodeamounts[$listpmode['id']] + $rowbalance['totalpaid'] : $rowbalance['totalpaid'];
													}
												}
											}
											echo '
											<td style="text-align:right; width:110px;">'.number_format($total).'</td>
										</tr>';
										$grandtotal = ($grandtotal + $total);

									} 
									echo '
								</tbody>
								<thead>
									<tr>
										<th colspan="2" style="text-align:right;font-size:16px !important;"> Total Received</th>';
										foreach($pay_types as $listpmode) {
											if($pmode == 'all' || $pmode == $listpmode['id']) {
												echo '<th style="text-align:right;font-size:16px !important;">'.number_format($pmodeamounts[$listpmode['id']]).'</th>';
											}
										}
										echo '<th style="text-align:right;font-size:16px !important;"><a href="reportcollections.php?reptype=collections&repview=detail&pmode=all&datefrom='.date("Y-m-d", strtotime($datefrom)).'&&dateto='.date("Y-m-d", strtotime($dateto)).'" style="text-decoration: none; color:inherit;" title="click to view detail" target="_blank">'.number_format($grandtotal).'</a></th>
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
<script type="text/javascript">
// setTimeout(function(){if (typeof(window.print) != "undefined") {
//     window.print();
//     window.close();
// }}, 3500);
</script>
</html>';