<?php
ini_set('memory_limit', '-1');
include "../dbsetting/lms_vars_config.php";
include "../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../functions/login_func.php";
include "../functions/functions.php";
$conditions = array (
                                    'select' 		=> '*'
                                , 'where' 		=> array (
                                                                 'status' => 0
                                                                ,'message_type' => 2
                                                        )
                                , 'order_by' 	=> " dated ASC"
                                , 'return_type'  => 'all'
                    );
$messagelist 	= $dblms->getRows(WHATSAPP_MESSAGES,  $conditions);

foreach ($messagelist as $listwa) :

    $url = 'https://msd.gptech.pk' . $listwa['filepath'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
                                        CURLOPT_URL              => WA_MEDIA_URL,
                                        CURLOPT_RETURNTRANSFER   => true,
                                        CURLOPT_ENCODING         => '',
                                        CURLOPT_MAXREDIRS        => 10,
                                        CURLOPT_TIMEOUT          => 0,
                                        CURLOPT_FOLLOWLOCATION   => true,
                                        CURLOPT_HTTP_VERSION     => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST    => 'POST',
                                        CURLOPT_POSTFIELDS      => array(
                                                                              'api_key'     => WA_APPKEY
                                                                            , 'sender'      => WA_SENDER
                                                                            , 'number'      => $listwa['cellno']
                                                                            , 'media_type'  => 'document'
                                                                            , 'caption'     => $listwa['message']
                                                                            , 'url'         => $url
                                                                        ),
                                    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $responseArray = json_decode($response, true);
    if($responseArray['status'] == 1) {
        $status = 1;
        $file = $_SERVER['DOCUMENT_ROOT'] . $listwa['filepath'];

        if (file_exists($file)) {
            unlink($file);
        } 
    } else {
        $status = 3;
    }

    
    $data = array (
                            'status' =>  $status
                    );

    $qryUpdate = $dblms->Update(WHATSAPP_MESSAGES, $data, "id = '".($listwa['id'])."'");


endforeach;