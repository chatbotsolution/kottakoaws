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
$secretKey = "e6cbc3a48d1ddaa503572f42f1a29a427b159c27";
$hash_hmac = hash_hmac('sha256', $data, $secretKey, true) ;
$computedSignature = base64_encode($hash_hmac);
if ($signature == $computedSignature) {
    $_SESSION['paymentstatus'] = 'success';

 ?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
	<link href='cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css' rel='stylesheet' type='text/css'>
	<link href='maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>hitchpayments - Payment recharge page</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/logo.png">
	<!-- <style>
		@import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
		@import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
	</style> -->
	<link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
	<script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
	<script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
	<style type="text/css">
		table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 2px;
  text-align: center;
  padding: 10px;

}
.site-footer{
	margin-top:-5%;
}

 table tr:nth-child(even){background-color: #f2f2f2;}
}

table tr:hover {background-color: #ddd;}

table th {
  padding-top: 5px;
  padding-bottom: 5px;
  padding: 10px;
  text-align: center;
  color: black;
  background-color:#64E986;
}
.site-header__title{
	font-size: 4.5rem !important;
}
.site-header{
	margin-top:-40px
}
@media only screen and (max-width: 700px) {
  table {
     margin-left: -10px !important;
  }
  .site-header{
	margin-top:35%;
}
  .site-header__title{
	font-size: 2.5rem !important;
}



}

	</style>
</head>
<body>
	<header class="site-header" id="header" >
		<h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
	</header>

	<div class="main-content">
		<i class="fa fa-check main-content__checkmark" id="checkmark"></i>
		<p class="main-content__body" data-lead-id="main-content-body">Your order placed successfully</p><br>
		<button class="btn btn-success">Back to Homepage</button>
	</div>
</body>
</html>

<?php
  
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