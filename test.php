<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

require_once "Mail.php";

$host = "ssl://smtp.gmail.com";
$username = "technology@hitchpayments.com";
$password = "Sambit@123";
$port = "465";
$to = "kumarkonthenet@gmail.com";
$email_from = "donotreply@kottakotabusinesses.com";
$email_subject = "Test Email from kottakota:" ;
$email_body = "Hi test message" ;
$email_address = "donotreply@kottakotabusinesses.com";

$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
$mail = $smtp->send($to, $headers, $email_body);


if (PEAR::isError($mail)) {
echo("<p>" . $mail->getMessage() . "</p>");
} else {
echo("<p>Message successfully sent!</p>");
}
?>
