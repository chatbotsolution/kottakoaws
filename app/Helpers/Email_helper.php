<?php

function sendEMail($to,$from,$subject,$message){
    $email = \Config\Services::email();
    
    $config['protocol'] = 'sendmail';
    $config['mailPath'] = '/usr/sbin/sendmail';
    $config['charset']  = 'iso-8859-1';
    $config['wordWrap'] = true;
    $config['mailtype'] = 'html';
    $config['smtp_crypto'] = 'ssl';
    $config['charset'] = 'utf-8';
    $config['priority'] = '1';
    
    $email->initialize($config);

    $email->setFrom($from, 'KOTTAKOTA BUSINESSES');
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