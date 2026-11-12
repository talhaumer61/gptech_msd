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
                            'select' 	=> 'cm.company_id, cm.company_status, cm.company_name, cm.id_ade, cm.company_address, cm.company_code,
                                            ad.ade_name, ad.ade_whatsapp, ad.ade_email,
                                            COUNT(cs.customer_id) as schools',
                            'join' 		=> "LEFT JOIN ".ADES." ad ON ad.ade_id = cm.id_ade
                                            LEFT JOIN ".CUSTOMERS." cs ON cs.id_company =  cm.company_id AND cs.customer_status  = '1'",
                            'not_equal' => array( 
                                                'cm.company_id' => 0 
                                            ), 
                            'group_by' 		=> 'cs.id_company',
                            'order_by' 		=> 'cm.company_name ASC ',
                            'return_type' 	=> 'all' 
                        ); 
$Company 	= $dblms->getRows(COMPANY.' cm', $conditions);


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
                                                            'cs.customer_status' => '1',
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

    $mobilenum1 = convertPhoneNumber($rowstd['ade_whatsapp']);

    if($mobilenum1 !='' &&  strlen($mobilenum1) == 12 ) {

        $companyId = $rowstd['company_id'];

        $html = '';

        include "makepdf/zonebalancereportwa.php";

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

        $fileName = "zone_balance_report".$companyId."_" . time() . ".pdf";
        $filePath = $folderPath . $fileName;
        file_put_contents($filePath, $dompdf->output());
        // Send WhatsApp message

        $msgs = 'Dear '.$rowstd['ade_name'].',
Please find below the summary of receivables for your zone ('.$rowstd['company_name'].') this week.

Total Customers: '.$rowstd['schools'].'
Total Receivables: Rs. '.number_format($zonebalance).'
Attached is your zone-wise summary report.
Kindly review the report and take necessary follow-up actions with the concerned schools.

Regards,
Laural Publishers';
        // whatsapp message
        $datawa = array(
                                  'status'          => 0
                                , 'dated'           => date("Y-m-d")
                                , 'id_company'      => $rowstd['company_id']
                                , 'id_ade'          => $rowstd['id_ade']
                                , 'filepath'        => '/cronjobs/reports/' . $fileName
                                , 'amount'          => $zonebalance
                                , 'cellno'          => ($mobilenum1)
                                , 'message_type'    => 1
                                , 'message'         => $msgs
                        );
        $querywhtsapp = $dblms->Insert(WHATSAPP_MESSAGES, $datawa);
    }			

} 