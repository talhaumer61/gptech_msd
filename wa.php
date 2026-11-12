<?php
require_once("dbsetting/lms_vars_config.php");

$curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL             => WA_URL,
//     CURLOPT_RETURNTRANSFER  => true,
//     CURLOPT_ENCODING        => '',
//     CURLOPT_MAXREDIRS       => 10,
//     CURLOPT_TIMEOUT         => 0,
//     CURLOPT_FOLLOWLOCATION  => true,
//     CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST   => 'POST',
//     CURLOPT_POSTFIELDS      => array(
//                                           'api_key' => WA_APPKEY
//                                         , 'sender'  => WA_SENDER
//                                         , 'number'  => '923041847080'
//                                         , 'message' => 'Test WA Message'
//                                     ),
// ));

curl_setopt_array($curl, array(
    CURLOPT_URL             => 'https://whatsapp.metasquad.info/send-media',
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_ENCODING        => '',
    CURLOPT_MAXREDIRS       => 10,
    CURLOPT_TIMEOUT         => 0,
    CURLOPT_FOLLOWLOCATION  => true,
    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST   => 'POST',
    CURLOPT_POSTFIELDS      => array(
                                          'api_key' => WA_APPKEY
                                        , 'sender'  => WA_SENDER
                                        , 'number'  => '923041847080'
                                        , 'media_type'  => 'document'
                                        , 'caption' => 'Test WA Message'
                                        , 'url' => 'https://msd.gptech.pk/login/images/support.png'
                                    ),
));

$response = curl_exec($curl);
echo $response;
curl_close($curl);
$responseArray = json_decode($response, true);
