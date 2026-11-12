<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
if(($_SESSION['userlogininfo']['LOGINIDA'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINAFOR'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '34') || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '39')) {

    $conditions = array ( 
                            'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, '.CUSTOMERS.'.id_zone, 
                                            '.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
                                            '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
                            'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
                                            INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
                                            INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
                            'where' 	=>  array ( 
                                                    ''.ESTIMATES.'.estimate_id' 		=> cleanvars($_GET['id']),
                                                    // ''.ESTIMATES.'.estimate_status' 	=> '5'
                                                ), 
                            'search_by' =>  'AND '.ESTIMATES.'.estimate_status IN (4,6,7)',
                            'limit' 		=> 1,
                            'return_type' 	=> 'single' 
                        ); 
    $rowstd 	= $dblms->getRows(ESTIMATES, $conditions);

    // OPENING BALANCE
    $debitcreditconditions = array ( 
                                'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
                                                    SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit",
                                'join' 			=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user",
                                'where' 		=> array ( 
                                                              ''.PAYMENTS.'.status' => 1
                                                            , ''.PAYMENTS.'.id_user' => cleanvars($rowstd['customer_id'])
                                                        ), 
                                'return_type' 	=> 'single' 
                            ); 
    $valuedebitcrdit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);

    $openingbalance = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);

    // PERCENTAGE
	$percentage = ($rowstd['request_amount'] / ($rowstd['estimate_total'] + $openingbalance) * 100);


    // REQUEST PAYMENT REMARKS
	$requestremarksconditions = array ( 
                                            'select' 		=> ''.REQUEST_PAYMENT_REMARKS.'.*, '.ADMINS.'.adm_fullname',
                                            'join' 			=> "INNER JOIN ".ADMINS." ON ".ADMINS.".adm_id =  ".REQUEST_PAYMENT_REMARKS.".id_director",
                                            'where' 		=> array ( 
                                                                        ''.REQUEST_PAYMENT_REMARKS.'.id_estimate' => cleanvars($rowstd['estimate_id'])
                                                                        , ''.REQUEST_PAYMENT_REMARKS.'.is_deleted'  => '0'
                                                                    ), 
                                            'return_type' 	=> 'all' 
                                        ); 
    $valuerequestremarks 	= $dblms->getRows(REQUEST_PAYMENT_REMARKS, $requestremarksconditions);

    // Filter the data
    foreach ($valuerequestremarks as $remark) {
        if ($remark['id_director'] == 30) {
            $fieldOperation = $remark;
        } elseif ($remark['id_director'] == 34) {
            $services = $remark;
        } elseif ($remark['id_director'] == 2) {
            $finance = $remark;
        }
    }
    echo '
    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>Customer Request Payment Print</title>
        <style type="text/css">
            body {
                font: normal normal normal 16px/15px "Calibri", "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
                overflow: -moz-scrollbars-vertical;
                margin: 0;
                color: #111;
            }

            h1 {
                font-size: 28px;
                font-weight: bold;
                margin-top: 10px;
                color: #111;
                text-transform: uppercase;
            }

            h2 {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 3px;
                color: #111;
                text-transform: uppercase;
                text-align: center;
                text-decoration: underline;
            }

            h3 {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                text-align: center;
            }

            h4 {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 5px;
                margin-top: 5px;
                color: #333;
            }

            table td.label {
                font-weight: bold;
                margin: 0;
                text-align: left;
                padding: 2px;
                vertical-align: middle !important;
            }

            table.datatable {
                border: 1px solid #333;
                border-collapse: collapse;
                border-spacing: 0;
                margin-top: 10px;
            }

            table.datatable td {
                border: 1px solid #888;
                border-collapse: collapse;
                border-spacing: 0;
                padding: 5px;
                font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif;
                font-size: 15px;
                color: #000;
            }

            table.datatable th {
                border: 1px solid #888;
                border-collapse: collapse;
                border-spacing: 0;
                padding: 7px;
                background: #f4f4f4;
                font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif;
                font-size: 14px;
                font-weight: 600;
            }

            .table-blue-fotter {
                position: static;
                bottom: 0px;
                /* for bottom gap */
                left: 0px;
                width: 100%;
            }

            @page {

                margin-bottom: 20px;
                counter-increment: page;

                @bottom-right {
                    border-top: 1px solid #000000;
                    padding-right: 20px;
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
                    position: static;
                    /* <-- Key line */
                    bottom: 0px;
                    left: 0px;
                    width: 100%;
                }
            }
        </style>
        <link rel="shortcut icon" href="images/favicon/favicon.ico">
        <script language="JavaScript1.2">
            function openwindow() {
                window.open("ordersprint.php", "feechallan", "toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
            }
        </script>
        <style type="text/css"></style>
        <style type="text/css" id="operaUserStyle"></style>
    </head>

    <body>
        <center>
            <div style="width:700px !important; height:700px !important; " class="page">
                <table width="700" height="80" border="0" cellpadding="5" cellspacing="9" style="border-collapse:collapse;">

                    <tr>
                        <td width="50%" rowspan="5" valign="top">
                            <img src="images/invoice-lp.jpg" style="width:80; height:75px; margin-top:0px;margin-right:10px" align="left"> 
                            <h3 style="margin-top:10px;margin-bottom:0px;text-align:left;font-weight:900;">'.SITE_NAME.'</h3>
                            <h4 style="margin-top:10px;font-weight:400;width:90%;">'.SITE_ADDRESS.'</h4>
                        </td>
                        <td width="25%" colspan="2" style="text-align:right; font-size:30px; font-weight:700;letter-spacing:3px; padding-right:0;">
                        <span style="text-align:right; font-size:9px; padding-bottom:3px; color:#888;">'.date("F j, Y h:iA").'</span>
                            Credit Request
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" height="2"> </td>
                    </tr>
                </table>
                <table style="width: 100%; border: 0px  dotted #000;">
                    <tbody>
                        <tr>
                            <td align="left" valign="top" colspan="2">

                                <table class="datatable" style="margin:3px; width:100%;">
                                    <tbody>
                                        <tr>
                                            <th style="text-align:center; width:100px;">School Name</th>
                                            <td style="width:100px;">'. $rowstd['customer_name'].'</td>
                                            <th style="text-align:center; width:100px;">School code</th>
                                            <td style="text-align:center; width:100px;">'. $rowstd['customer_code'].'</td>
                                            <th style="text-align:center; width:100px;">Date</th>
                                            <td style="text-align:center; width:100px;">'.date('d.m.Y', strtotime($rowstd['estimate_date'])). '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align:center; width:100px;">Ad Name</th>
                                            <td style="text-align:center; width:100px;">'.$rowstd['ade_name']. '</td>
                                            <th style="text-align:center; width:100px;">Ad Cell No</th>
                                            <td style="text-align:center; width:100px;">'.$rowstd['ade_cellno'].'</td>
                                            <th style="text-align:center; width:100px;">Zone</th>
                                            <td style="text-align:left; width:100px;">'. $rowstd['company_name'].'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px; text-align: center;">Credit History Detail</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="height: 15px; text-align: center;">Total Previous Balance</th>
                                            <th colspan="2" style="height: 15px; text-align: end;">'.number_format($openingbalance).'</th>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="height: 15px; text-align: center;">Total Order Amount</th>
                                            <th colspan="2" style="height: 15px; text-align: end;">'.number_format($rowstd['estimate_total']).'</th>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="height: 15px; text-align: center;">Total Payable Amount</th>
                                            <th colspan="2" style="height: 15px; text-align: end;">'.number_format($rowstd['estimate_total'] + $openingbalance).'</th>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height: 15px; text-align: center;">Want To Pay Now</td>
                                            <td colspan="2" style="height: 15px; text-align: end;">'.number_format($rowstd['request_amount']).'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height: 15px; text-align: center;">Payment Percentage
                                            </td>
                                            <td colspan="2" style="height: 15px; text-align: end;">'.number_format($percentage,2).'%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height: 15px; text-align: center;">Remming Balance After
                                                Payment</td>
                                            <td colspan="2" style="height: 15px; text-align: end;">'.number_format(($rowstd['estimate_total'] + $openingbalance) - $rowstd['request_amount']).'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="height: 18px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height: 15px; text-align: center;">Date of Remming Payment(Entre By School at the time of request)</td>
                                            <td colspan="2" style="height: 15px; text-align: end;">'.date('d.m.Y', strtotime($rowstd['date_remaining_payment'])).'</td>
                                        </tr>
                                        <tr>
                                            <th colspan="6" style="height: 26px; text-align: center;">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" style="height: 26px; text-align:left;">Ikram Ghori </th>
                                            <td colspan="1" style="height: 26px; text-align:right;">'.($fieldOperation['amount'] ? 'Rs '.$fieldOperation['amount'] : '').'</td>
                                            <td colspan="4" style="height: 26px;">'.($fieldOperation['director_remarks'] ? $fieldOperation['director_remarks'].' / ' . date('d-m-Y H:i:s', strtotime($fieldOperation['date_added'])) : '').'</td>
                                        </tr>
                                        <tr>
                                            <th colspan="1" style="height: 26px; text-align:left;">Ali Mohiudeen </th>
                                            <td colspan="1" style="height: 26px; text-align:right;">'.($services['amount'] ? 'Rs '.$services['amount'] : '').'</td>
                                            <td colspan="4" style="height: 26px;">'.($services['director_remarks'] ? $services['director_remarks'].' / ' . date('d-m-Y H:i:s', strtotime($services['date_added'])) : '').'</td>
                                        </tr>
                                        <tr>
                                            <th colspan="1" style="height: 26px; text-align:left;">Dr Tariq Mehmood </th>
                                            <td colspan="1" style="height: 26px; text-align:right;">'.($finance['amount'] ? 'Rs '.$finance['amount'] : '').'</td>
                                            <td colspan="4" style="height: 26px;">'.($finance['director_remarks'] ? $finance['director_remarks'].' / ' . date('d-m-Y H:i:s', strtotime($finance['date_added'])) : '').'</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table-blue-fotter" style="margin-top: 80px;">
                                    <tbody>
                                        <tr>
                                            <th style="text-align: left;">Director Field Operation</th>
                                            <th style="text-align: left;">Director Services</th>
                                            <th style="text-align: right;">DD Finance</th>
                                            <th style="text-align: right;">Managing Director</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </center>

        <script type="text/javascript">
            // setTimeout(function(){if (typeof(window.print) != "undefined") {
            //     window.print();
            //     window.close();
            // }}, 3500);
        </script>
    </body>

    </html>';
} else {
	echo '<h1 style="margin-top: 100px; margin-bottom: 100px; color: orangered; font-weight: 600; text-align: center;">“Sorry, You are not allowed to access this page” </h1>';
	
}
?>