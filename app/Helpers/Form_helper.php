<?php

function show_form_error($validations,$field){
    if(isset($validations)){
        if($validations->hasError($field)){
            return $validations->getError($field);
        }else{
            return false;
        }
    }
}


function sendOTP($num,$userSMS){
$curl = curl_init();
$textUserSMS = urlencode($userSMS);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://103.233.76.120/api/mt/SendSMS?user=hitch&password=Orissa@123&senderid=KOBDPL&channel=Trans&DCS=0&flashsms=0&number='.$num.'&text='.$textUserSMS.'&route=1&peid=1001564060000071737&DLTTemplateId=1007165909965559265',
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
//echo $response;

}
?>