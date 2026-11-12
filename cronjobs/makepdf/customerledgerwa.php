<?php 

$logoPath = "https://msd.gptech.pk/images/invoice-logo1.jpg"; 
$Custconditions = array ( 
								'select' 		=> 'cs.*, cm.company_name, ad.ade_name, ad.ade_whatsapp, ad.ade_email',
								'join' 			=> 'INNER JOIN '.COMPANY.' cm ON cm.company_id = cs.id_company
													INNER JOIN '.ADES.' ad ON ad.ade_id = cm.id_ade',
								'where' 		=> array ( 
															'cs.customer_id' => $customerId
														), 
								'limit' 		=> 1,
								'return_type' 	=> 'single' 
							); 
$rowstd 	= $dblms->getRows(CUSTOMERS. ' cs', $Custconditions);
$html .= '
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Ledger</title>
    <style>
        body {
            font: normal normal normal 16px/15px "Calibri", Arial, sans-serif;
            margin:0; color:#111;
        }
        h1 { font-size:28px; font-weight:bold; margin-top:10px; color:#111; text-transform:uppercase; }
        h2 { font-size:20px; font-weight:bold; margin-bottom:3px; color:#111; text-transform:uppercase; text-align:center; text-decoration:underline; }
        h3 { font-size:18px; font-weight:bold; color:#333; text-transform:uppercase; text-align:center; }
        h4 { font-size:14px; font-weight:bold; margin-bottom:5px; margin-top:5px; color:#333; }
        table td.label { font-weight:bold; text-align:left; padding:2px; vertical-align:middle !important; }
        table.datatable { border: 1px solid #333; border-collapse: collapse; margin-top:10px; width:100%; }
        table.datatable td { border: 1px solid #888; padding:5px; font-size:15px; color:#000; }
        table.datatable th { border: 1px solid #888; padding:5px; background:#f4f4f4; font-size:14px; font-weight:600; }
        @page { margin: 1cm; }
        @page :first { margin-top: 1cm; }

        table.datatable {
            border: 1px solid #333;
            border-collapse: collapse;
            margin-top:10px;
            width:100%;
        }

        table.datatable td, table.datatable th {
            border: 1px solid #888;
            padding:5px;
            font-size:15px;
            color:#000;
        }

        table.datatable th {
            background:#f4f4f4;
            font-size:14px;
            font-weight:600;
        }

        /* ✅ Repeat table header & footer on new pages */
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }

        /* ✅ Avoid splitting table rows between pages */
        tr, td, th { page-break-inside: avoid; }

        /* ✅ Force page breaks when needed */
        .page-break { page-break-before: always; }
		.footer {
			position: fixed;
			bottom: 0;
			left: 0;
			right: 0;
			text-align: center;
			font-size: 12px;
			color: #666;
			border-top: 1px solid #ccc;
			padding: 5px 0;
		}
    </style>
</head>
<body>
    <div style="width:100%; min-height:700px;">
        <table width="100%" border="0" >
            <tr>
                <td width="58%" rowspan="5" valign="top">
                    <img src="' . $logoPath . '" style="height:70px; margin-top:0px; margin-right:10px; float:left;"> 
                    <h3 style="margin-top:10px; margin-bottom:0px; text-align:left; font-weight:900;">'.SITE_NAME.'</h3>
                    <h4 style="margin-top:10px; font-weight:400; width:90%;">'.SITE_ADDRESS.'</h4>
                </td>
                <td width="35%" valign="top" colspan="2" style="text-align:right; font-size:30px; font-weight:700; letter-spacing:3px; padding-right:0;">
                    <span style="font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span><br><br>
                    Customer Ledger
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse:collapse;" border="0">
		
            <tr>
                <td style="border:1px solid #111; text-align:center; font-size:14px; padding:8px; font-weight:700;">
                    School Name/Address 
                </td>
				<td style="border:1px solid #111; text-align:center; font-size:14px; padding:8px; font-weight:700;">
                    ADE Name/Address 
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #111; text-align:left; font-size:13px; padding:8px; width:50%;">
					'.$rowstd['customer_name'].'<br>'.$rowstd['customer_address'].'<br> '.$rowstd['customer_cellno'].'
                </td>
				<td style="border:1px solid #111; text-align:left; font-size:13px; padding:8px; width:50%;">
					'.$rowstd['ade_name'].' ('.$rowstd['company_name'].')<br> '.$rowstd['ade_whatsapp'].'<br>'.$rowstd['ade_email'].'
                </td>
            </tr>
        </table>

        <table class="datatable">
            <thead>
                <tr>
					<th style="text-align:center;">Sr #</th>
					<th style="text-align:left;">Date</th>
					<th style="text-align:left;">Invoice</th>
					<th style="text-align:left;">Detail</th>
					<th style="text-align:center;">Debit</th>
					<th style="text-align:center;">Credit</th>
					<th style="text-align:center;">Balance</th>
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
											'select' 	=> ''.SALES_INVOICE.'.id_customer, '.SALES_INVOICE.'.total',
											'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".SALES_INVOICE.".id_customer ",
											'where' => array( 
																''.SALES_INVOICE.'.salesinvoice_id' => cleanvars($rowbills['reference_no'])
															), 
											'limit' 		=> 1,
											'return_type' 	=> 'single' 
										); 
						$valueinvoice 	= $dblms->getRows(SALES_INVOICE, $conditions);
						
						if($rowbills['debit_credit'] == 2) {
							$debit 		= $valueinvoice['total'];
							$debitdisp 	= number_format($valueinvoice['total']);
						} else {
							$debit 		= 0;
							$debitdisp 	= '---';
						}

						if($valueinvoice['id_customer'] != $rowstd['customer_id']) { 
							$invoiceno = '<a href="'.SITE_URL.'/saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank" style="color:#f00;">'.$Invoiceno.'</a>';	
						} else {
							$invoiceno = '<a href="'.SITE_URL.'/saleinvoiceprint.php?id='.$rowbills['reference_no'].'" target="_blank">'.$Invoiceno.'</a>';
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
					
					$html .= '
					<tr>
						<td style="text-align:center; width:50px;">'.$srno.'</td>
						<td style="text-align:left; width:80px;">'.date('d/m/Y', strtotime(cleanvars($rowbills['dated']))).'</td>
						<td style="text-align:left;width:90px;">'.$invoiceno.'</td>
						<td style="text-align:left;">'.$remarks.'</td>
						<td style="text-align:right; width:90px;">'.$debitdisp.'</td>
						<td style="text-align:right; width:90px;">'.$creditdisp.'</td>
						<td style="text-align:right; width:90px;">'.number_format($balance).'</td>
					</tr>';
					
					$totalcredit 	= ($totalcredit+ $credit);
					$totaldebit 	= ($totaldebit+ $debit);
				}

				$html .= '
			</tbody>
            <tfoot>
				<tr>
					<th colspan="4" style="text-align:right; font-weight:bold;"> </th>
					<th style="text-align:right; font-weight:bold;background-color: bisque; font-size:16px !important;">'.number_format($totaldebit).'</th>
					<th style="text-align:right; font-weight:bold;background-color: darksalmon; font-size:16px !important;">'.number_format($totalcredit).'</th>
					<th style="text-align:right; font-weight:bold; font-size:16px !important;background-color: mistyrose; color:#f00;">'.number_format($balance).'</th>
				</tr>
            </tfoot>
        </table>
    </div>
	<div class="footer">
		This is a system-generated ledger report provided for record purposes only.
	</div>
</body>
</html>';
