<?php

function sendEMail($to,$from,$subject,$message){
    $email = \Config\Services::email();

    $email->setFrom($from, 'Hitch Payments');
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($message);

    if($email->send()){
        return true;
    }else{
        return false;
    }
}

?>