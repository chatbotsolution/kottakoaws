<?php

function npcei($vehicle){
        $dt = "NPCE".time();
                                   
        $url="http://158.69.38.192:8090/NPCITagstatus";
        
        $headers = array(
           "Accept: application/json",
           "Content-Type: application/json",
        );
        
        $ch = curl_init();
        $data_array= array(          
          "CPID" => "53",
          'AGENTID' => "70094",
          "INPUTTYPE" => "REGNO",
          "INPUT" => $vehicle,
          "REQID" => $dt
        );
        $dtt = json_encode($data_array);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        
        $resp = curl_exec($ch);
        
        if($e = curl_error($ch)){
          return $e;
          
        }else{
             return $resp;
        }
}  


function GetBalance($mobileNum){
                               
    $url="http://158.69.38.192:8090/GetBalance";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(          
      "CPID" => "53",
      'AGENTID' => "70094",      
      "MOBILENUMBER" => $mobileNum
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
} 

function GenerateOTP($mobileNum,$reqid){
                               
    $url="http://158.69.38.192:8090/GenerateOTP";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",
      "REQID"=> $reqid,      
      "MOBILENUMBER" => $mobileNum
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}

function OTPVerify($reqid,$mobileNum,$otp,$orgreqid){
                               
    $url="http://158.69.38.192:8090/OTPVerify";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",
      "REQID"=> $reqid,      
      "MOBILENUMBER" => $mobileNum,
      "OTP" => $otp,
      "ORGREQID" => $orgreqid
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}

function VerifyNSDLCustomer($reqid,$mobileNum,$orgreqid,$name,$panum,$dob){
    $url="http://158.69.38.192:8090/VerifyNSDLNCIFDEDUP";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",
      "REQID"=> $reqid,      
      "MOBILENUMBER" => $mobileNum,
      "ORGREQID" => $orgreqid,
      "FIRSTNAME" => $name,
      "LASTNAME" =>".",
      "PANNUMBER" =>$panum,
      "CUSTOMERTYPE" => "1",
      "DOB" =>$dob
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}

function VerifyCustomer($mobileNum){
    $url="http://158.69.38.192:8090/VerifyCustomer";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",     
      "MOBILENUMBER" => $mobileNum
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}

function GetStateCity($reqid,$pincode){
    $url="http://158.69.38.192:8090/GetStateCity";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",
      "REQID"=> $reqid,      
      "PINCODE" => $pincode
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}

function WalletCreation($reqid,$token,$orgreqid,$customersubtype,$crnnum,$mobilenumber,$panumber,$name,$dob,$gender,$ddress1,$address2,$address3,$pincode,$regionid,$satetid,$cityid,$regionname,$statename,$cityname,$addressproofnumber){
    $url="http://158.69.38.192:8090/WalletCreation";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();
    $data_array= array(  
      'AGENTID' => "70094",        
      "CPID" => "53",
      "REQID"=> $reqid,
      "TOKEN" => $token,
      "ORGREQID" => $orgreqid,
      "CUSTOMERTYPE" => "1",
      "CUSTOMERSUBTYPE" => $customersubtype,
      "CRNNUMBER" => $crnnum,
      "MOBILENUMBER" => $mobilenumber,
      "PANNUMBER" => $panumber,
      "FIRSTNAME" => $name,
      "LASTNAME" => ".",
      "DOB" => $dob,
      "GENDER" => $gender,
      "ADDRESS1" => $ddress1,
      "ADDRESS2" => $address2,
      "ADDRESS3" => $address3,
      "PINCODE" => $pincode,
      "REGIONID" => $regionid,
      "STATEID" => $satetid,
      "CITYID" => $cityid,
      "REGIONNAME" => $regionname,
      "STATENAME" => $statename,
      "CITYNAME" => $cityname,
      "ADDRESSPROOFTYPE" => "2",
      "ADDRESSPROOFNUMBER" => $addressproofnumber
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }
}


function addVehicle($tnid,$img){

    $url="http://158.69.38.192:8090/Addvehicle";
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    
    $ch = curl_init();

    $data_array= array(          
        "TRANSACTIONID"=> $tnid,
        "CPID"=> "53",
        "AGENTID"=> "70094",
        "MOBILENO"=> "9629742562",
        "CUSTOMERID"=> "100758",
        "ITEM"=>array(
                    "VEHICLECLASS"=> "12",
                    "VEHICLENO"=> "TN60AF0001",
                    "RCNO"=> "",
                    "CHASSISNO"=> "",
                    "ENGINENO"=> "",
                    "REGLOCATION"=> "",
                    "TAGID"=> "",
                    "COMMERCIALTYPE"=> "1",
                    "VEHICLEIMAGE"=> "",
                    "PARAM1"=> "1",
                    "MOBILENO2"=> "",
                    "PARAM3"=> "2",
                    "PARAM4" => "",
                    "PARAM5"=> "",
                    "MINIAMOUNT"=> "100.00",
                    "DEPOSITAMOUNT"=> "100.00",
                    "CARDCOST"=> "100.00",
                    "TOTAL"=> "300.00",
                    "SERIALNO"=> "607443-002-0511970",
                    "CBSCOST"=> "300.00",
                    "CPACCOUNTNO"=> "",
                    "CASATYPE"=> "2",
                    "AGENTTYPE"=>"1",
                    "DEALERCODE"=> "",
                    "RCBookUpload"=> $img
            )
    );
    
    $dtt = json_encode($data_array);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    $resp = curl_exec($ch);
    
    if($e = curl_error($ch)){
      return $e;
      
    }else{
         return $resp;
    }

}

function Topup($mobilenumber,$amount,$reqid){
  $url="http://158.69.38.192:8090/Topup";
  
  $headers = array(
     "Accept: application/json",
     "Content-Type: application/json",
  );
  
  $ch = curl_init();
  $data_array= array(  
    'AGENTID' => "70094",        
    "CPID" => "53",
    "TRANSACTIONID"=> $reqid,      
    "MOBILENUMBER" => $mobilenumber,
    "AMOUNT" => $amount
  );
  
  $dtt = json_encode($data_array);
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $dtt);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  
  $resp = curl_exec($ch);
  
  if($e = curl_error($ch)){
    return $e;
    
  }else{
       return $resp;
  }
}


    ?>