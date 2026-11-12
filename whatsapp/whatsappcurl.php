<?php 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://wasecure.whatsappcloudapis.com/api/create-message',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
  'appkey' => 'e6b5d1c7-3ea6-417c-bbde-dd5ede94c83a',
  'authkey' => 'CkAaijy1YUXZUAdL5kKKj1vY834kSPXqRIo2vpNmzTM6l2oCIc',
  'to' => '923130000299',
  'template_id' => '1716101248893045',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;