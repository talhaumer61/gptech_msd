<?php 

$logoPath = "https://msd.gptech.pk/images/invoice-logo1.jpg"; 
$companyconditions = array ( 
									'select' 		=> 'cm.company_id, cm.company_name, cm.company_code, ad.ade_name, ad.ade_whatsapp, ad.ade_email',
									'join' 			=> 'INNER JOIN '.ADES.' ad ON ad.ade_id = cm.id_ade',
									'where' 		=> array( 
																'company_status' => '1'
																,'company_id' 	 => $companyId
															), 
									'order_by' 		=> 'company_name ASC',
									'return_type' 	=> 'single' 
								); 

$Company = $dblms->getRows(COMPANY. ' cm', $companyconditions);


$html .= '
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Zone wise Balance Report</title>
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
                    Balance Report
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse:collapse;" border="0">
            <tr>
                <td style="border:1px solid #111; text-align:center; font-size:22px; padding:10px; font-weight:600;">
                    '.$Company['company_name'].' Balance Report
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #111; text-align:left; font-size:13px; padding:8px;">
                    '.$Company['ade_name'].' ('.$Company['company_name'].')<br> '.$Company['ade_whatsapp'].'<br>'.$Company['ade_email'].'
                </td>
            </tr>
        </table>

        <table class="datatable">
            <thead>
                <tr>
                    <th style="text-align:center; width:50px;">Sr #</th>
                    <th style="text-align:left;">Customer Name</th>
                    <th style="text-align:right;">Receivables</th>
                </tr>
            </thead>
			<tbody>';
				$srno = 0;
				$totaldebit        = 0;
				$totalcrdit        = 0;
				$openingtotaldebit = 0;
				$openingtotalcrdit = 0;

				$conditions = array ( 
										'select' 	=> "c.customer_id, 
													c.customer_name, 
													c.customer_cellno, 
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
											'c.customer_status'     => 1 // assuming you want only active customers
										),

										'group_by' 		=> 'c.customer_id',
										'order_by' 		=> 'balance DESC',
										'return_type' 	=> 'all'
									); 

				$Payments = $dblms->getRows(CUSTOMERS. ' c', $conditions);

				foreach($Payments as $rowbalance) { 
					$balance = ($rowbalance['totalreceivables']  - $rowbalance['totalpaid']);

					$srno++;

					$html .= '
					<tr>
						<td style="text-align:center;">'.$srno.'</td>
						<td>'.$rowbalance['customer_name'].'</td>
						<td style="text-align:right;">'.((($balance)>=0) ? number_format($balance) : '').'</td>
					</tr>';
					$totaldebit = ($totaldebit + ((($balance)>=0) ? $balance : 0));
				}

				$html .= '
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:center; font-size:16px;">Total Balance</th>
                    <th style="text-align:right; font-size:16px;">'.number_format($totaldebit).'</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
';
