<?php
error_reporting(E_ALL);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://hub.uol.edu.pk:9010/sap/opu/odata/sap/ZAKH_SRV/userInfoSet?$format=json&$filter=(Universityregistration eq \'70000002\')',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic QkFDS19VU0VSOlNhcEAxMjM0NTY3',
    'Cookie: SAP_SESSIONID_ERP_500=WlEbRfbhARV1Ylj9kzLcD56Q4VVy9hHulTRh5VUAswI%3d; sap-usercontext=sap-client=500'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

//echo $response;

$requestResponse = json_decode($response, true);
echo($requestResponse);


