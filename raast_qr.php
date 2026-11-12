<?php

include "dbsetting/lms_vars_config.php";
include "dbsetting/classdbconection.php";
$dblms = new dblms();
include "functions/login_func.php";
include "functions/functions.php";
checkCpanelLMSALogin();

$conditions = array ( 
                        'select' 	=> 'e.*, c.customer_id, c.customer_code, c.customer_name, c.customer_openingbalance, ad.ade_id, ad.ade_name, ad.ade_cellno, cm.company_id, cm.company_name',
                        'join' 		=> "INNER JOIN ".CUSTOMERS." c ON c.customer_id = e.id_customer 
                                        INNER JOIN ".COMPANY." cm ON cm.company_id =  c.id_company
                                        INNER JOIN ".ADES." ad ON ad.ade_id =  cm.id_ade ",
                        'where' 	=> array ( 
                                                  'e.voucher_no'        => cleanvars($_POST['challanNo'])
                                                , 'e.estimate_status'   => '6'
                                                , 'e.is_deleted'        => 0
                                            ), 
                        'limit' 		=> 1,
                        'return_type' 	=> 'single' 
                    ); 
$row 	= $dblms->getRows(ESTIMATES.' e', $conditions);

if($row && $row['expiry_date'] >= date('Y-m-d')) {

    include_once "functions/db_functions.php";
    $mainclass = new main();
    $qr = require_once 'dbsetting/qrapi_config.php';
    $qr = $qr['qr'];


    $qrCodeText = '';

    $consumerNumber = $row['voucher_no'];
    $consumerName   = $row['customer_name'];
    $amount         = (float)($row['total_amount']);
    $currency       = 'PKR';
    $expiryDateTime = date('Y-m-d 23:59:59', strtotime($row['expiry_date']));

    $result = $mainclass->get_qrchallan($consumerNumber, $consumerName, $amount, $currency, $expiryDateTime);

    if ($result !== false && (date('Y-m-d H:i:s') < date('Y-m-d H:i:00', strtotime($result['expirydatetime']))) && $result['status'] != 1) {
        $qrCodeText = $result['qrcode'];
    } else {
        $payload = json_encode([
              'consumerNumber'  => (int)$consumerNumber
            , 'consumerName'    => $consumerName
            , 'amount'          => (float)$amount
            , 'currency'        => $currency
            , 'expiryDateTime'  => $expiryDateTime
        ]);

        // ---- 3. Call the API ----
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $qr['endpoint_url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                  'appId: ' . $qr['appid']
                , 'secretKey: ' . $qr['secretkey']
                , 'publicKey: ' . $qr['publickey']
                , 'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            $errorMessage = 'Request failed: ' . $curlError;
        } else {
            $data = json_decode($response, true);

            if (!isset($data['code']) || $data['code'] != 200) {
                $errorMessage = $data['message'] ?? 'Unknown error from payment gateway.';
            } else {
                $responsedata = ($data['responsedata']);
                //echo  $responsedata;

                $qrCodeText = $data['qrCode'];
                $datalog = array(
                                      'status'          => 2
                                    , 'orderid'         => $responsedata['merchant']['orderid']
                                    , 'billno'          => $responsedata['transaction']['billnumber']
                                    , 'consumerno'      => $consumerNumber
                                    , 'consumername'    => $consumerName
                                    , 'amount'          => (float)$amount
                                    , 'currency'        => $currency
                                    , 'expirydatetime'  => $expiryDateTime
                                    , 'qrcode'          => $qrCodeText
                                    , 'responsecode'    => $responsedata['response']['code']
                                    , 'rsponsemsg'      => $responsedata['response']['description']
                                    , 'responsedata'    => json_encode($responsedata)
                                    , 'created_date'    => date('Y-m-d H:i:s')
                                );
                $querylog = $dblms->Insert("cms_qrchallans", $datalog);
            }
        }
    }

    echo '
    <!doctype html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width,initial-scale=1" />
            <title>RAAST QR Payment</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
            <link rel="shortcut icon" href="images/favicon/favicon.ico">
            <style>
                :root {
                    --bg: #0f172a;
                    --card: #0b1220;
                    --muted: #94a3b8;
                    --accent1: #7c3aed;
                    --accent2: #06b6d4;
                    --glass: rgba(255, 255, 255, 0.04);
                    --radius: 16px;
                }

                * {
                    box-sizing: border-box
                }

                html,
                body {
                    height: 100%;
                    margin: 0;
                    font-family: Inter, system-ui, Arial;
                    background: linear-gradient(180deg, #071025 0%, #071a2b 60%);
                    color: #e6eef8;
                }

                .wrap {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 28px;
                }

                .card {
                    width: auto;
                    max-width: 100%;
                    background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
                    border-radius: var(--radius);
                    padding: 28px;
                    box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
                    display: grid;
                    grid-template-columns: 1fr 360px;
                    gap: 24px;
                    align-items: start;
                    border: 1px solid rgba(255, 255, 255, 0.04);
                }

                .info {
                    padding: 18px;
                    border-radius: 12px;
                    background: linear-gradient(180deg, rgba(255, 255, 255, 0.01), rgba(255, 255, 255, 0.00));
                }

                .brand {
                    display: flex;
                    align-items: center;
                    gap: 14px
                }

                .school {
                    font-size: 18px;
                    font-weight: 700
                }

                .small {
                    color: var(--muted);
                    font-size: 13px
                }

                .meta {
                    display: flex;
                    gap: 12px;
                    flex-wrap: wrap;
                    margin-top: 16px
                }

                .meta .pill {
                    background: var(--glass);
                    padding: 10px 12px;
                    border-radius: 10px;
                    font-weight: 600;
                    font-size: 13px;
                    color: #dbeafe
                }

                .table {
                    margin-top: 20px;
                    border-radius: 12px;
                    overflow: hidden;
                    background: linear-gradient(180deg, rgba(255, 255, 255, 0.01), rgba(255, 255, 255, 0.00));
                    border: 1px solid rgba(255, 255, 255, 0.03)
                }

                .row {
                    display: flex;
                    padding: 14px 18px;
                    align-items: center
                }

                .row:nth-child(odd) {
                    background: rgba(255, 255, 255, 0.008)
                }

                .label {
                    flex: 0 0 150px;
                    color: var(--muted);
                    font-weight: 600
                }

                .value {
                    flex: 1;
                    font-weight: 700
                }

                .amount {
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    margin-top: 18px
                }

                .amount .big {
                    font-size: 28px;
                    font-weight: 800
                }

                .tag {
                    background: linear-gradient(90deg, var(--accent1), var(--accent2));
                    padding: 8px 12px;
                    border-radius: 10px;
                    font-weight: 700
                }

                .note {
                    margin-top: 12px;
                    color: var(--muted);
                    font-size: 13px
                }

                .qrcard {
                    padding: 18px;
                    border-radius: 12px;
                    background: linear-gradient(180deg, rgba(255, 255, 255, 0.015), rgba(255, 255, 255, 0.00));
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 14px;
                    border: 1px solid rgba(255, 255, 255, 0.03)
                }

                .qrcode {
                    width: 260px;
                    height: 260px;
                    border-radius: 14px;
                    padding: 14px;
                    background: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2)
                }

                .qrcode canvas {
                    border-radius: 6px
                }

                .paybtn {
                    display: flex;
                    gap: 10px;
                    width: 100%;
                    margin-top: 8px
                }

                .btn {
                    flex: 1;
                    padding: 12px 14px;
                    border-radius: 10px;
                    font-weight: 700;
                    border: 0;
                    cursor: pointer
                }

                .btn-cta {
                    background: linear-gradient(90deg, var(--accent2), var(--accent1));
                    color: #032;
                }

                .btn-alt {
                    background: transparent;
                    border: 1px solid rgba(255, 255, 255, 0.06);
                    color: var(--muted)
                }

                .small-muted {
                    font-size: 13px;
                    color: var(--muted);
                    text-align: center
                }

                @media (max-width:880px) {
                    .card {
                        grid-template-columns: 1fr;
                    }

                    .row {
                        display: flex;
                        flex-direction: column;
                        align-items: start;
                    }

                    .qrcode {
                        width: 260px;
                        height: 260px;
                        border-radius: 14px;
                        padding: 14px;
                        background: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2)
                    }

                    .card {
                        width: auto;
                        padding: 0;
                        gap: 0px;
                    }

                    .brand {
                        display: flex;
                        flex-direction: column;
                        align-items: start;
                        gap: 14px
                    }

                    .label {
                        flex: 0 0;
                    }
                }
                
                @media print {
                    body {
                        display: none !important;
                    }
                }
            </style>
        </head>

        <body>
            <div class="wrap">
                <div class="card" id="card">
                    <div class="info">
                        <div class="brand">
                            <img src="images/logo.png" alt="Laurel Publishers" style="width: 200px;" />
                            <div>
                                <div class="school">RAAST QR Payment</div>
                                <div class="small">Dated '.date('d-m-Y').'</div>
                            </div>
                        </div>

                        <div class="meta">
                            <div class="pill">Challan No: <span id="challanNo">'.$row['voucher_no'].'</span></div>
                            <div class="pill">Due Date: <strong id="dueDate">'.date('d-m-Y', strtotime($row['expiry_date'])).'</strong></div>
                            <div class="pill">Estimate: <strong id=""><span class="label label-warning" id="bns-status-badge">'.$row['estimate_no'].'</span></strong></div>
                        </div>

                        <div class="table">
                            <div class="row">
                                <div class="label">School Name</div>
                                <div class="value" id="studentName">'.$row['customer_name'].'</div>
                            </div>
                            <div class="row">
                                <div class="label">Registration No</div>
                                <div class="value" id="regNo">'.$row['customer_code'].'</div>
                            </div>
                            <div class="row">
                                <div class="label">ADE Name</div>
                                <div class="value" id="program">'.$row['ade_name'].' <br>('.$row['ade_cellno'].')</div>
                            </div>
                            <div class="row">
                                <div class="label">Company Name</div>
                                <div class="value" id="session">'.$row['company_name'].'</div>
                            </div>
                        </div>

                        <div class="amount">
                            <div>
                                <div class="small-muted">Total Payable</div>
                                <div class="big" id="amount">PKR '.number_format($amount).'</div>
                            </div>
                            <div class="tag">Pay by QR</div>
                        </div>
                    </div>

                    <div class="qrcard">
                        <div style="width:100%;display:flex;justify-content:space-between;align-items:center">
                            <div style="font-weight:700">Scan & Pay</div>
                            <div style="font-size:13px;color:var(--muted)">Secure • Instant</div>
                        </div>

                        <div class="qrcode" id="qrcode"></div>

                        <div class="small-muted">Scan the QR with your banking app to pay instantly. After payment, keep the transaction reference for records.</div>
                    </div>
                </div>
            </div>
            
            <script src="js/qrcode.min.js"></script>
            <script type="text/javascript" src="js/jquery/jquery.js"></script>

            <script>
                const qrCodeText = "'.$qrCodeText.'";

                if(qrCodeText) {
                    new QRCode(document.getElementById("qrcode"), {
                        text: qrCodeText,
                        width: 220,
                        height: 220,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
                
                document.addEventListener("keydown", function (e) { 
                    if((e.ctrlKey || e.metaKey) && e.key === "p") {
                        e.preventDefault();
                        alert("Printing is disabled on this page.");
                    }
                });
            </script>

            <script>
                let interval = setInterval(function() {
                    $.ajax({
                        url: "include/ajax/get_voucher_status.php",
                        type: "POST",
                        data: { challan: '.$row['voucher_no'].' },
                        dataType: "json",
                        success: function(response) {
                            console.log(response.status);
                            if(response.status == 7) {
                                clearInterval(interval);
                                window.location.href = "customerestimates.php";
                            }
                        }
                    });
                }, 3000);
            </script>

        </body>

    </html>';
    
} else {
    die('Invalid Challan');
}