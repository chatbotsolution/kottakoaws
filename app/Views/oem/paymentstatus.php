<?php
 //echo json_encode($_POST);

$orderId = $_POST["orderId"];
$orderAmount = $_POST["orderAmount"];
$referenceId = $_POST["referenceId"];
$txStatus = $_POST["txStatus"];
$paymentMode = $_POST["paymentMode"];
$txMsg = $_POST["txMsg"];
$txTime = $_POST["txTime"];
$signature = $_POST["signature"];
$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
$secretKey = "5fc31787a8824b4fe884719c801a53957356587c";
$hash_hmac = hash_hmac('sha256', $data, $secretKey, true) ;
$computedSignature = base64_encode($hash_hmac);
if ($signature == $computedSignature) {
    $_SESSION['paymentstatus'] = 'success';
   echo "<h1>Your order is successfully confirmed!</h1>";
 } else {
    $this->session->set('paymentstatus','failed');
   echo "<h1>Something went wrong</h1>";

}


 ?>

<script>
  setTimeout(function() {
      window.close()
  }, 5000);
</script>
