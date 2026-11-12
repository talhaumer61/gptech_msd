<?php

$json       = file_get_contents('php://input');

// Log file
$logFile = $logDir . '/callback_' . date('Y-m-d') . '.txt';

// Get all request headers
if (function_exists('getallheaders')) {
    $headers = getallheaders();
} else {
    // Fallback for non-Apache servers
    $headers = [];
    foreach ($_SERVER as $key => $value) {
        if (strpos($key, 'HTTP_') === 0) {
            $name = str_replace('_', '-', substr($key, 5));
            $headers[$name] = $value;
        }
    }
}

$log = [
    'Date'          => date('Y-m-d H:i:s'),
    'Method'        => $_SERVER['REQUEST_METHOD'] ?? '',
    'URI'           => $_SERVER['REQUEST_URI'] ?? '',
    'IP'            => $_SERVER['REMOTE_ADDR'] ?? '',
    'User-Agent'    => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'Headers'       => $headers,
    'Raw Request'   => $json,
];

file_put_contents(
    $logFile,
    "\n==================================================\n" .
    json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n",
    FILE_APPEND | LOCK_EX
);

if (empty($json)) {
    http_response_code(400);
    echo json_encode([
        'status' => 400,
        'description' => 'No data received.'
    ]);
    exit();
}

$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'status' => 400,
        'description' => 'Invalid JSON.'
    ]);
    exit();
}

if($data['response']['code'] == 200) {

    $logd = [
        'code'          => $data['response']['code'],
        'description'   => $data['response']['description'],
        'paymentstatus' => $data['transaction']['paymentstatus'],
        'amount'        => $data['transaction']['amount'],
        'txnid'         => $data['transaction']['paymentmsgid'],
        'orderid'       => $data['merchant']['orderid'],
        'ChallanNo'     => $data['customer']['challanno'],
    ];


    $datalog = array (
                              'status'              => 1
                            , 'txn'                 => $data['transaction']['paymentmsgid']
                            , 'paidamount'          => $data['transaction']['amount']
                            , 'paiddatetime'		=> date('Y-m-d H:i:s')
                            , 'payload_response'	=> json_encode($data)
                     );
    $qryUpdate = $dblms->Update("cms_qrchallans", $datalog, "WHERE billno = '" . $data['transaction']['billnumber'] . "' ORDER BY id DESC LIMIT 1");


    $estconditions = array ( 
							  'select' 		=> ''.ESTIMATES.'.*, '.CUSTOMERS.'.customer_id, '.CUSTOMERS.'.customer_code, '.CUSTOMERS.'.customer_name, 
												'.CUSTOMERS.'.customer_openingbalance, '.ADES.'.ade_id, '.ADES.'.ade_name, 
												'.ADES.'.ade_cellno, '.COMPANY.'.company_id, '.COMPANY.'.company_name'
							, 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id = ".ESTIMATES.".id_customer 
												INNER JOIN ".COMPANY." ON ".COMPANY.".company_id =  ".CUSTOMERS.".id_company
												INNER JOIN ".ADES." ON ".ADES.".ade_id =  ".COMPANY.".id_ade "
							, 'where' 		=> array ( 
														  ''.ESTIMATES.'.voucher_no' 		=> cleanvars($data['customer']['challanno'])
														 ,''.ESTIMATES.'.is_deleted' 		=> '0'
														 ,''.ESTIMATES.'.estimate_status' 	=> '6'
													)
							, 'limit' 		=> 1
							, 'return_type' => 'single' 
						); 
    $rowestimate = $dblms->getRows(ESTIMATES, $estconditions);

    if($rowestimate){



        // LATEST JOB ORDER NO
        $conditions = array ( 
                                'select' 		=> 'job_order_id'
                                , 'where' 		=> array ( 
                                                            'is_placebycustomer' => 1 
                                                        )
                                , 'return_type' => 'count' 
                            ); 
        $SalesOrders = $dblms->getRows(JOB_ORDER, $conditions);
        $countorder  =  $SalesOrders;
            
        if($countorder<9) {
            $orderno = 'JC-00000'.($countorder+1);
        } else if($countorder<99) {
            $orderno = 'JC-0000'.($countorder+1);
        } else if($countorder<999) {
            $orderno = 'JC-000'.($countorder+1);
        } else if($countorder<9999) {
            $orderno = 'JC-00'.($countorder+1);
        } else if($countorder<99999) {
            $orderno = 'JC-0'.($countorder+1);
        } else {
            $orderno = 'JC-'.($countorder+1);
        }

        // CUSTOMER OPENING BALANCE
        $debitcreditconditions = array ( 
                                        'select' 		=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit, 
                                                            SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit"
                                        , 'join' 		=> "INNER JOIN ".CUSTOMERS." ON ".CUSTOMERS.".customer_id =  ".PAYMENTS.".id_user"
                                        , 'where' 		=> array ( 
                                                                    ''.PAYMENTS.'.status' => 1
                                                                    , ''.PAYMENTS.'.id_user' => cleanvars($rowestimate['customer_id'])
                                                                )
                                        , 'return_type' => 'single' 
                                    ); 
        $valuedebitcrdit = $dblms->getRows(PAYMENTS, $debitcreditconditions);
        $openingbalance  = ($valuedebitcrdit['TotalDebit'] - $valuedebitcrdit['TotalCredit']);


        $POconditions = array ( 
                                    'select' 		=> '*'
                                    , 'where' 		=> array( 
                                                                'id_estimate' => cleanvars($rowestimate['estimate_id'])
                                                            )
                                    , 'order_by' 	=> 'id ASC' 
                                    , 'return_type' => 'all' 
                            ); 
        $podetails 	= $dblms->getRows(ESTIMATES_DETAIL, $POconditions);

        
        $dataInv = array(
                                'job_order_status'	=> '2'
                            , 'is_placebycustomer'	=> 1
                            , 'id_ade'				=> cleanvars($rowestimate['ade_id'])
                            , 'id_customer'			=> cleanvars($rowestimate['id_customer'])	
                            , 'job_order_no'		=> cleanvars($orderno)
                            , 'dated'				=> date('Y-m-d')
                            , 'total'				=> cleanvars($rowestimate['estimate_total'])
                            , 'advance'				=> cleanvars($data['transaction']['amount'])
                            , 'sales_tax'			=> cleanvars(($rowestimate['estimate_total'] * 0.16))
                            , 'paid_date'			=> date('Y-m-d')
                            , 'paid_method'			=> 6
                            , 'deposit_slip'		=> cleanvars($data['transaction']['paymentmsgid'])
                            , 'id_company'			=> cleanvars($rowestimate['company_id'])
                            , 'id_added'			=> cleanvars($rowestimate['id_added'])
                            , 'date_added'			=> date('Y-m-d h:i:s')
                            , 'balance'				=> cleanvars($openingbalance + $rowestimate['estimate_total'])
                            , 'opening_balance'		=> cleanvars($openingbalance)
                            , 'grand_total'			=> cleanvars($openingbalance + $rowestimate['estimate_total'])
                            , 'remarks'				=> cleanvars($rowestimate['estimate_remarks'])							
                        );
                        
        $sqllmsInsert  = $dblms->Insert(JOB_ORDER , $dataInv);

        if($sqllmsInsert) { 
            $idOrder = $dblms->lastestid();
            
            foreach($podetails as $rowsdet) {
                
                $dataOrderDetail = array(
                                            'id_job_order'	=> cleanvars($idOrder)
                                            , 'id_company'		=> cleanvars($rowestimate['company_id'])
                                            , 'id_item'			=> cleanvars($rowsdet['id_item'])
                                            , 'unit_price'		=> cleanvars($rowsdet['unit_price'])
                                            , 'discount'		=> 0
                                            , 'total_price'		=> cleanvars($rowsdet['total_price'])
                                            , 'total_qty'		=> cleanvars($rowsdet['qty'])
                                        );
                $sqllmsInsertDetail  = $dblms->Insert(JOB_ORDER_DETAILS , $dataOrderDetail);
            } 

            // INVOICE AMOUNT
            $dataInvamount = array(
                                        'status'			=> '1'
                                        , 'ledgerfor'		=> '1'
                                        , 'docs_types'		=> '2'
                                        , 'id_user'			=> cleanvars($rowestimate['id_customer'])
                                        , 'reference_no'	=> cleanvars($idOrder)
                                        , 'dated'			=>  date('Y-m-d')
                                        , 'amount'			=> cleanvars($rowestimate['estimate_total'])
                                        , 'debit_credit'	=> '2'
                                        , 'remarks'			=> 'Sales Invoice'
                                        , 'date_added'		=> date("Y-m-d H:i:s")
                                    );

            $sqllmsInsertamount  = $dblms->Insert(PAYMENTS , $dataInvamount);

            // RECEIPT NO
            $year = substr(date('Y'), -2);
            $conReceipt = array ( 
                                    'select' 		=> "CONCAT('BR-".$year."', LPAD(
                                                            COALESCE(MAX(CAST(SUBSTRING(receipt_no, 6) AS UNSIGNED)), 0) + 1, 
                                                            5, '0')) 
                                                        AS next_receipt_no"
                                    , 'where' 		=> array ( 
                                                                'status ' => 1 
                                                            )
                                    , 'search_by' 	=> " AND receipt_no LIKE 'BR-".$year."%'"
                                    , 'return_type' => 'single' 
                                ); 
            $receipt_no = $dblms->getRows(PAYMENTS, $conReceipt);

            // INVOICE AMOUNT PAYMENT
            $dataInvPayment = array(
                                        'status'				=> '1'
                                        , 'ledgerfor'			=> '1'
                                        , 'docs_types'			=> '7'
                                        , 'id_cat'				=> '4'
                                        , 'receipt_no'			=> cleanvars($receipt_no['next_receipt_no'])	
                                        , 'id_user'				=> cleanvars($rowestimate['id_customer'])	
                                        , 'reference_no'		=> cleanvars($idOrder)
                                        , 'dated'				=> date('Y-m-d')
                                        , 'transaction_id'		=> cleanvars($data['transaction']['paymentmsgid'])
                                        , 'transaction_status'	=> 1
                                        , 'transaction_invoiceno'=> cleanvars($rowestimate['invoice_id'])
                                        , 'transaction_amount'	=> cleanvars($data['transaction']['amount'])
                                        , 'transaction_paiddate'=> date('Y-m-d')
                                        , 'response_detail'		=> json_encode($data)
                                        , 'amount'				=> cleanvars($data['transaction']['amount'])
                                        , 'debit_credit'		=> '1'
                                        , 'pay_mode'			=> 6
                                        , 'remarks'				=> get_doctype(7)
                                        , 'date_added'			=> date("Y-m-d H:i:s")								
                                );

            $sqllmsInsertPayment  = $dblms->Insert(PAYMENTS , $dataInvPayment);
            
            // UPDATE ESTIMATE STATUS
            $dataEstimate = array(
                                    'estimate_status'		=> 7
                                    , 'id_joborder'			=> cleanvars($idOrder)
                                    , 'joborder_no'			=> cleanvars($orderno)
                                    , 'voucher_status'		=> 2
                                    , 'voucher_amount'		=> $data['transaction']['amount'] 
                                    , 'voucher_paid_date'	=> date("Y-m-d H:i:s")
                                    , 'response_detail'		=> json_encode($data)
                                );
            $qryUpdateEstimate = $dblms->Update(ESTIMATES, $dataEstimate, "WHERE estimate_id = '".cleanvars($rowestimate['estimate_id'])."'");
            
        }
    }


    file_put_contents(
        $logFile,
        "\n==================================================\n" .
        json_encode($logd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n",
        FILE_APPEND | LOCK_EX
    );

}