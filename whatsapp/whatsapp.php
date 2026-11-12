<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://wa.hajanaone.com/api/send.php?apikey=e339201ceaf79cf4d4192da309d4b352&waid=10043&number=923014381660&message=Dear%20Shahzad%20Ahmad%0AKindly%20ensure%20to%20submit%20your%20child%20school%20fee%20payment%20before%20Due%20date%20to%20avoid%20any%20inconvenience.%20In%20case%20of%20non%20payment%20of%20school%20fee%20by%20due%20dated%2015-11-2023%2C%20students%20will%20not%20be%20allowed%20to%20sit%20in%20class.%20Fine%20Rs.300%20will%20be%20imposed%20with%20late%20fee.%0A%0A%20Your%20cooperation%20is%20highly%20appreciated.&type=text&media_url=&file_name=mydocument.pdf',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;