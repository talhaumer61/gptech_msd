<?php
include "dbsetting/lms_vars_config.php";
include "dbsetting/classdbconection.php";
$dblms = new dblms();
include "functions/login_func.php";
include "functions/functions.php";
checkCpanelLMSALogin();

$conditions = array ( 
                        'select' 	=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
                                        '.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
                                        '.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name',
                        'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
                                        INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
                                        INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade ",
                        'where' 	=> array ( 
                                                  ''.ESTIMATES.'.voucher_no' => cleanvars($_GET['id'])
                                                , ''.ESTIMATES.'.is_deleted' => 0
                                            ), 
                        'limit' 		=> 1,
                        'return_type' 	=> 'single' 
                    ); 
$row 	= $dblms->getRows(ESTIMATES, $conditions);
// ONEBILL_PREFIX.$row['invoice_number'].
echo '
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Challan Form</title>
    <style type="text/css">
		body {overflow: -moz-scrollbars-vertical; margin:0; font-family: Arial, Helvetica, sans-serif, Calibri, "Calibri Light";  }
		@media all {
			.page-break	{ display: none; }
		}

		@media print {
			.page-break	{ display: block; page-break-before: always; }
			@page { 
				size: A4 landscape;
			margin: 0mm 4mm 2mm 4mm; 
			}
		}
		h1 { text-align:left; margin:0; margin-top:0; margin-bottom:0px; font-size:26px; font-weight:700; text-transform:uppercase; }
		.spanh1 { font-size:14px; font-weight:normal; text-transform:none; text-align:right; float:right; margin-top:0px; }
		h2 { text-align:left; margin:0; margin-top:0; margin-bottom:1px; font-size:22px; font-weight:700; text-transform:uppercase; }
		.spanh2 { font-size:20px; font-weight:700; text-transform:none; }
		h3 { text-align:center; margin:0; margin-top:0; margin-bottom:1px; font-size:19px; font-weight:700; text-transform:uppercase; padding: 0px; }
		h4 { 
			text-align:center; margin:0; margin-bottom:1px; font-weight:normal; font-size:13px; font-weight:700; word-spacing:0.1em;  
		}
		td { padding-bottom:4px; font-family: Arial, Helvetica, sans-serif, Calibri, "Calibri Light"; }
		.line1 { border:1px solid #333; width:100%; margin-top:2px; margin-bottom:5px; }
		.payable { border:2px solid #000; padding:2px; text-align:center; font-size:14px; }

		.paid:after
		{
			content:"PAID";
			
			position:absolute;
			top:30%;
			left:20%;
			z-index:1;
			font-family:Arial,sans-serif;
			-webkit-transform: rotate(-5deg); /* Safari */
			-moz-transform: rotate(-5deg); /* Firefox */
			-ms-transform: rotate(-5deg); /* IE */
			-o-transform: rotate(-5deg); /* Opera */
			transform: rotate(-5deg);
			font-size:250px;
			color:green;
			background:#fff;
			border:solid 4px yellow;
			padding:5px;
			border-radius:5px;
			zoom:1;
			filter:alpha(opacity=50);
			opacity:0.1;
			-webkit-text-shadow: 0 0 2px #c00;
			text-shadow: 0 0 2px #c00;
			box-shadow: 0 0 2px #c00;
		}
	</style>
    <link rel="shortcut icon" href="images/favicon/favicon.ico">

    <style type="text/css"></style>
    <style type="text/css" id="operaUserStyle"></style>
</head>

<body>
    <table width="99%" border="0" class="page " cellpadding="7" cellspacing="10" align="center"
        style="border-collapse:collapse; margin-top:0px;">
        <tbody>
            <tr>';
			if($feercord['status'] == 1) { 
				$clspaid = " paid";
			} else { 
				$clspaid = "";
			}
			$cpi = 0;
			for($ifee = 1; $ifee<=3; $ifee++){
				if($ifee<3){ 
					$rightborder = 'style="border-right:1px dashed #333;"';
				}else{ 
					$rightborder = '';
				}
				$cpi++;
				
				if($cpi==1) { 
					$copyfor = 'School';
				} elseif($cpi==2) { 
					$copyfor = 'Campus';
				}elseif($cpi==3) { 
					$copyfor = "Bank";
				}
				echo '
                <td width="341" '.$rightborder.' class="'.$clspaid.'">
                    <h4 style="text-align: right;">'.$copyfor.' Copy</h4>
                    <table style="border-collapse:collapse;  font-size:11px;" cellpadding="2" cellspacing="2" border="1"
                        width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4"><img src="images/invoice-logo1.jpg" style="width:80; height:70px; margin-top:0px;margin-right:10px"></td>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:12px; font-weight:bold; border:1px solid #333;">Issue Date</td>
                                <td style="text-align:center; font-size:12px; font-weight:bold;  border:1px solid #333;">'.date('d-m-Y', strtotime($row['issue_date'])).'</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:12px; font-weight:bold; border:1px solid #333;">Due Date</td>
                                <td style="text-align:center; font-size:12px; font-weight:bold;  border:1px solid #333;">'.date('d-m-Y', strtotime($row['expiry_date'])).'</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:12px; font-weight:bold; border:1px solid #333;">Estimate :</td>
                                <td style="text-align:center; font-size:12px; font-weight:bold;  border:1px solid #333;">'.$row['estimate_no'].'</td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear:both;"></div>
                    <div style="font-size:13px; margin-top:15px;">
                        <table style="border-collapse:collapse; border:1px solid #333;" width="100%" border="1">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="images//1-link.jpg"
                                            style="width:35px; height: 35px; vertical-align: middle; ">
                                    </td>
                                    <td style="font-size:14px; font-weight:600; padding:10px;">
                                        All Mobile Banking (1 Bill Invoice)
                                        <br>
                                        NA
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="images//ubl.png"
                                            style="width:35px; height: 35px; vertical-align: middle; ">
                                    </td>
                                    <td style="font-size:14px; font-weight:600; padding:10px;">
                                        UBL All Over Pakistan: (32 57 31 324)
                                        <br>
                                        '.$row['voucher_no'].'
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="font-size:13px; margin-top:15px;">
                        <table style="border-collapse:collapse; font-size:11px; width:100%; border:1px solid black;"
                            width="100%" border="1">
                            <tbody>
                                <tr>
                                    <th style="padding:3px; width:150px; text-align:right;">School Name</th>
                                    <th style="padding-left:10px;text-align:left;">'.$row['customer_name'].'</th>
                                </tr>
                                <tr>
                                    <th style="padding:3px; text-align:right;">Customer ID</th>
                                    <th style="padding-left:10px;text-align:left;"><span
                                            style="font-size:10px;"><u>'.$row['customer_code'].' </u></span></th>
                                </tr>
                                <tr>
                                    <th style="padding:3px; text-align:right;">ADE Name</th>
                                    <th style="padding-left:10px;text-align:left;">'.$row['ade_name'].'</th>
                                </tr>
                                <tr>
                                    <th style="padding:3px; text-align:right;">Cell No</th>
                                    <th style="padding-left:10px;text-align:left;">'.$row['ade_cellno'].'</th>
                                </tr>
                                <tr>
                                    <th style="padding:3px; text-align:right;">Company Name</th>
                                    <th style="padding-left:10px;text-align:left;">'.$row['company_name'].'</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="font-size:12px; margin-top:15px;">
                        <table style="border-collapse:collapse;  font-size:11px;" cellpadding="2" cellspacing="2"
                            border="1" width="100%">
                            <tbody>
                                <tr>
                                    <td
                                        style="text-align:center;  font-size:12px; font-weight:bold; border:2px solid #333;">Descriptions </td>
                                    <td
                                        style="text-align:right; font-size:11px; font-weight:bold; width:50px; border:2px solid #333;">Rs.</td>
                                </tr>
                                <tr>
                                    <td style="text-align:start; font-size:12px; font-weight:bold; border:1px solid #333;">Current Bill (Invoice No NA)</td>
                                    <td style="text-align:right; font-size:12px; font-weight:bold;  border:1px solid #333;">'.number_format($row['total_amount']).'</td>
                                </tr>
                                <tr>
                                    <td style="text-align:start; font-size:12px; font-weight:bold; border:1px solid #333;">Bank Charges</td>
                                    <td style="text-align:right; font-size:12px; font-weight:bold;  border:1px solid #333;">'.BANK_CHARGES.'</td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; font-size:12px; font-weight:bold; border:1px solid #333;">Total Payable Fee</td>
                                    <td style="text-align:right; font-size:12px; font-weight:bold;  border:1px solid #333;">'.number_format($row['total_amount'] + BANK_CHARGES).'</td>
                                </tr>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
					</div>
					<div style="font-size:12px; margin-top:15px;">
                        <table width="100%" border="0" style="border-collapse:collapse;" cellpadding="0"
                            cellspacing="5">
                            <tr>
                                <td style="text-align:start; font-size:12px; font-weight:bold;">Note How to Pay Through 1 Bill Invoice:</td>
                            </tr>
                            <tr>
                                <td>Go to payments and Bill Payments in the Banking App</td>
                            </tr>
                            <tr>
                                <td><span>Select 1BILL Invoice from Payment.</span></td>
                            </tr>
                            <tr>
                                <td><span>Select Consumer type as Non Beneficiary.</span></td>
                            </tr>
                            <tr>
                                <td><span>Enter Consumer Number and click on fetch bill.</span></td>
                            </tr>
                            <tr>
                                <td><span>Generate OTP and input to complete payment.</span></td>
                            </tr>
                        </table>
                    </div>
					<div style="font-size:12px; margin-top:70px;">
						<p style="text-align:right">Bank Sign & Stamp</p>
					</div>
                    <div style="clear:both;"></div>
                </td>';
			}
			echo '
            </tr>
        </tbody>
    </table>

    <script type="text/javascript" language="javascript1.2">
    <!--
    //Do print the page
    if (typeof(window.print) != "undefined") {
        window.print();
    }
    -->
    </script>
</body>

</html>';
?>