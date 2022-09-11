<?php

function generateSignature($postData){
  $secretKey = "e6cbc3a48d1ddaa503572f42f1a29a427b159c27";
 ksort($postData);
 $signatureData = "";
 foreach ($postData as $key => $value){
      $signatureData .= $key.$value;
 }
 $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
 $signature = base64_encode($signature);
 return $signature;
}

function makePayment($orderId,$orderAmount,$purchasenote,$salesmailid,$custnamesub,$mobilenumbersub,$returnurl,$signature,$notifyurl){
  $curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.cashfree.com/api/v1/order/create',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('appId' => '19350339ee25ac9bdf7c97d3f6305391',
                                        'secretKey' => 'e6cbc3a48d1ddaa503572f42f1a29a427b159c27',
                                        'orderId' => $orderId,
                                        'orderAmount' => $orderAmount,
                                        'orderCurrency' => 'INR',
                                        'orderNote' => $purchasenote,
                                        'customerEmail' => $salesmailid,
                                        'customerName' => $custnamesub,
                                        'customerPhone' => $mobilenumbersub,
                                        'returnUrl' => $returnurl,
                                        'signature' => $signature,
                                        'notifyUrl' => $notifyurl),
          ));
          $response = curl_exec($curl);
          curl_close($curl);
          echo $response;
}

?>