<?php
ini_set('memory_limit', '-1');
require '../vendor/autoload.php'; // Dompdf autoloader
use Dompdf\Dompdf;
use Dompdf\Options;

ini_set('memory_limit', '-1');
include "../dbsetting/lms_vars_config.php";
include "../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../functions/login_func.php";
include "../functions/functions.php";

$conditions = array ( 
                            'select' 	=> 'e.date_remaining_payment, e.id_customer, c.customer_name, c.customer_personwhatsapp',
                            'join' 		=> "INNER JOIN ".CUSTOMERS." c ON c.customer_id = e.id_customer AND c.customer_status  = '1'",
                            'where'     => array( 
                                                'e.is_deleted' => 0 
                                            ), 
                            'search_by' 	=> ' AND e.estimate_status  NOT IN (1,2) AND e.date_remaining_payment = (
                                                                                                                        SELECT MAX(e2.date_remaining_payment)
                                                                                                                                FROM '.ESTIMATES.' e2
                                                                                                                                WHERE e2.id_customer = e.id_customer
                                                                                                                                AND e2.is_deleted = 0
                                                                                                                                AND e2.estimate_status NOT IN (1,2)
                                                                                                                    )  AND e.date_remaining_payment = CURDATE() + INTERVAL 3 DAY ',
                            'order_by' 		=> 'e.date_remaining_payment ASC',
                            'return_type' 	=> 'all' 
                        ); 
$Estimates 	= $dblms->getRows(ESTIMATES.' e', $conditions, $sql);

if(!empty($Estimates)) {
    foreach($Estimates as $row) {

        $mobilenum1 = convertPhoneNumber($row['customer_personwhatsapp']);
        
        $debitcreditconditions = array ( 
                                            'select' 	=> "SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '1' then ".PAYMENTS.".amount end) as TotalCredit, 
                                                            SUM(CASE WHEN ".PAYMENTS.".ledgerfor = '1' AND ".PAYMENTS.".debit_credit = '2' then ".PAYMENTS.".amount end) as TotalDebit",
                                            'where' 	=> array( 
                                                                ''.PAYMENTS.'.status' 	=> 1, 
                                                                ''.PAYMENTS.'.id_user' 	=> $row['id_customer'] 
                                                            ), 								
                                            'return_type' 	=> 'single' 
                                        ); 
        $valuedebit 	= $dblms->getRows(PAYMENTS, $debitcreditconditions);
        $openingbalance = ($valuedebit['TotalDebit'] - $valuedebit['TotalCredit']);
        

        if($mobilenum1 !='' &&  strlen($mobilenum1) == 12  && $openingbalance > 0) {


            $customerId = $row['id_customer'];

            $html = '';

            include "makepdf/customerledgerwa.php";

            // Recreate dompdf for each loop iteration
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);

            // Load and render
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $folderPath = __DIR__ . "/reports/";
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = "customerledger".$customerId."_" . time() . ".pdf";
            $filePath = $folderPath . $fileName;
            file_put_contents($filePath, $dompdf->output());
            // Send WhatsApp message

             $msgs = 'Payment Due Reminder 
Dear '.$row['customer_name'].',
This is a kind reminder that your payment is due on ('.date('F j, Y',strtotime($row['date_remaining_payment'])).').

Amount Due: Rs. '.number_format($openingbalance).'
Due Date: '.date('F j, Y',strtotime($row['date_remaining_payment'])).'
Attached is your Ledger Report.

We appreciate your prompt attention to pay this amount on a priority basis.

Regards,
Laural Publishers';

            // whatsapp message
            $datawa = array(
                                      'status'          => 0
                                    , 'dated'           => date("Y-m-d")
                                    , 'id_customer'     => $customerId
                                    , 'filepath'        => '/cronjobs/reports/' . $fileName
                                    , 'amount'          => $openingbalance
                                    , 'cellno'          => ($mobilenum1)
                                    , 'message_type'    => 2
                                    , 'message'         => $msgs
                            );
            $querywhtsapp = $dblms->Insert(WHATSAPP_MESSAGES, $datawa);
        }			

    } 
}
