<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;
use TCPDF; 

class OEMdownloadController extends BaseController
{
    public $loginModel;
    public $oemModel;
    public $productmodel;
    public $salesagentModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');
        $this->loginModel = new SalesManagerModel();
        $this->oemModel = new OemModel();
        $this->productmodel = new ProductModel();
        $this->salesagentModel = new SalesAgentModel();
        $this->session = session();
        require_once(APPPATH.'Helpers/tcpdf/tcpdf.php');
        
    }
  
  public function fitmenchallan($idd){
     if ((!isset($_SESSION['oemid']))) {
       return redirect()->to(base_url('oemLogin'));            
     }
    $data= [];
    error_reporting(0);
    $iddusr=$idd;
    $data['customer'] = $this->salesagentModel->salesAgentreport($iddusr);
    $dtm=date("Y-m-d h:i:s");
    
    $prsnt = $this->salesagentModel->multiSrch('chllnndrecpt','*','customerid',$idd,'customertype',1);
   
    if(sizeof($prsnt) == 0){
      
    $rndid =  strtoupper(random_string('numeric', 8));
    $chlnm = "HIPY-".$rndid.'-'.substr(time(),2);
    $recpt = $rndid;
      
    $dataNominee = ["customerid"=>$idd, "customertype"=>1, "challannumber"=>$chlnm, "receiptnumber"=>$recpt, "datetime"=>$dtm];
    $loginData = $this->loginModel->loginDatainsert('chllnndrecpt',$dataNominee);
      
    }else{
      $chlnm= $prsnt[0]["challannumber"];
    }    
    
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Fitmen Challan");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    
    $html='
 <html lang="en">
    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">        
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
     <title>Fastag</title>
   </head>
   <body style="font-family: \'Montserrat\';">  
     <div class="container">
     
       <table>
         <tr>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/fastag.png" alt="Fastag" align="left" style="margin-top: 30px;" height="90px" width="130px"></td>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/kotak.png" alt="Kotak" height="100px" width="170px" align="right" style="margin-top: 30px;"></td>
         </tr>
       </table>  
       
       <h3 style="text-decoration: underline; text-align:center; font-weight: 500;font-size: 22px;">
           Proof of fitment of FASTag
       </h3>
       
         <table align="left" style="padding: 5px 5px;">
           <tr>
             <td>Fitment Challan Number</td>
             <td>'.$chlnm.'</td>
           </tr>
           <tr>
             <td style="height: 30px;">Dated '.date("d-m-Y" , strtotime($data['customer'][0]['datetime'])).'</td>
             <td style="height: 30px;">Time '.date("h:i:s" , strtotime($data['customer'][0]['datetime'])).'</td>
           </tr>
         </table>
         
       <p style="height: 50px"></p>
       
       <table width="500px" height="500px" align="center" style="border:1px solid black; padding: 5px 5px;">
         <tr>
           <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">FASTag Details</th>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> TID </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['tid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> TAG ID </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['tagid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Barcode Number </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['barcodeid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Banks Issuer Name </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['bankname'].' Bank </td>
         </tr>
       </table>
       
       
       
       
       
       <p style="height: 30px"></p>
       
       <table width="500px" height="200px" align="center" style="border:1px solid black; padding: 5px 5px;">
           <tr>
             <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Vehicle Details</th> 
           </tr>
           <tr>
             <td style="padding-left: 2px; font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Vehicle Registration No : </li> </ul>  </td>';
                 if($data['customer'][0]['vehicleNumbertype'] == 1){
           $vahiclenumber=$data['customer'][0]['vehiclechasisnumber'];
                       $chasisnumber='NA';
                 }else if($data['customer'][0]['vehicleNumbertype'] == 2){
                       $vahiclenumber='NA';
                       $chasisnumber=$data['customer'][0]['vehiclechasisnumber'];
                 }else{
                       $vahiclenumber='NA';
                       $chasisnumber='NA';
                 }
    $html.='<td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;"> '.$vahiclenumber.' </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> <span style="color: red;">*</span>Vehicle No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$vahiclenumber.'</td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> <span style="color: red;">*</span>Chassis No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$chasisnumber.'</td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> Engine No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;"> NA </td>
           </tr>
       </table>
       
       <p style="height: 30px;"></p>
       
       <table align="right"> 
               <tr>
                   <td style="color: black; font-weight: 500; height: 30px;">Stamp and Signature of</td>
               </tr>
               <tr>
                   <td style="color: black; font-weight: 500; height: 30px;">or</td>
               </tr>
               <tr>
                   <td style="color: black; font-weight: 500; height: 100px;">Signature of Customer</td>
               </tr>
       </table>
       
       <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
           <span>*Fields marked(*) are mandatory information to be provided in the challan.</span> <br>
           <span>*Vehicle owner shall be responsible affixing FASTag applied through online channels.</span>
       </div>
   </div>
  </body>
  </html>';
    
    //$pdf->writeHTML($html);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('FitmenChallan '.$data['customer'][0]['vehiclechasisnumber'].'.pdf','D');
    
    
   // $table1="manufacturer";
  //  $viewdata1="manufactureid ,manufacturername,status";
  //  $whrclm1="status";
  //  $whrval1=0;
  //  $data["manufacturer"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);
   // return view('oem/downloadfitmenchallan',$data);
  }
  
  
  ///////////////////////////////////////////////
  ////////////////////////////////////////////////
  
  //the below function is for the fitmenchallanreceipt
  
  ////////////////////////////////////////
  //////////////////////////////////////////
  //////////////////////////////////////////////
  public function fitmenchallanreceipt($idd){ // this is fitmenchallanreceipt() ....................
     if ((!isset($_SESSION['oemid']))) {
       return redirect()->to(base_url('oemLogin'));            
     }
    $data= [];
    error_reporting(0);
    $iddusr=$idd;
    $data['customer'] = $this->salesagentModel->salesAgentreportoem($iddusr);
    
    $dtm=date("Y-m-d h:i:s");
    
    $prsnt = $this->salesagentModel->multiSrch('chllnndrecpt','*','customerid',$idd,'customertype',1);
   
    if(sizeof($prsnt) == 0){
      
    $rndid =  strtoupper(random_string('numeric', 8));
    $chlnm = "HIPY-".$rndid.'-'.substr(time(),2);
    $recpt = $rndid;
      
    $dataNominee = ["customerid"=>$idd, "customertype"=>1, "challannumber"=>$chlnm, "receiptnumber"=>$recpt, "datetime"=>$dtm];
    $loginData = $this->loginModel->loginDatainsert('chllnndrecpt',$dataNominee);
      
    }else{
      $recpt= $prsnt[0]["receiptnumber"];
    }
    
    
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Fitmen Challan");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    
    $html='
 <html lang="en">
    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">        
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
     <title>Fastag</title>
   </head>
   <body style="font-family: \'Montserrat\';">  
     <div class="container">
     
       <table>
         <tr>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/fastag.png" alt="Fastag" align="left" height="90px" width="130px"></td>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/kotak.png" alt="Kotak" height="100px" width="170px" align="right"></td>
         </tr>
       </table>  
       
      
         <table align="left" style="padding: 5px 5px;">
           <tr>
             <td>Dear Customer</td>
           </tr>
           <tr>
             <td>Thank you for using KOTAK Bank Services.</td> 
           </tr>
         </table>
    
       <hr style="border: 2px solid black;">
       
       	  <div>
              <div>
                  <label style="font-weight: bold;">Receipt No :</label>
                  <span style="font-weight: 500;">'.$recpt.'</span>
              </div>
              <div>
                  <label style="font-weight: bold;">Date</label>
                  <span style="font-weight: 500;"> '.date("d-m-Y" , strtotime($data['customer'][0]['datetime'])).' </span>
              </div>
          </div>
       
       <table width="500px" height="500px" align="center" style="border:1px solid black; padding: 5px 10px;">
         <tr>
           <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Receipt Details</th>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Manufacturer Name</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['manufacturername'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Dealer Name :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['companyname'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Customer Name :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['customername'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Vehicle Number :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['vehiclechasisnumber'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Barcode :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['barcodeid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Tag ID :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['tagid'].'</td>
         </tr>
       </table>
       
       <p style="height: 10px;"></p>
       
       <table width="500px" height="200px" align="center" style="border:1px solid black; padding: 5px 10px;">
           <tr>
             <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Amount Breakdown</th> 
           </tr>
           <tr>
             <td style="padding-left: 2px; font-weight: 500; font-size: 11px;width:180px; text-align:left;">Issuance Fees :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 100.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Security Deposit :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 50.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Initial Topup :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 150.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">P.S.Fees :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 200.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Total Amount :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 500.00 </td>
           </tr>
       </table>
       <p style="height: 5px;"></p>
       	<div>
        	<span style="font-size: 10px;">Note :  GST is included in Tag Issuance Fee and is paid by end customer directly to the KOTAK Bank.</span>
        </div>
       
       <hr style="border: 2px solid black;">
       
       <div style="font-size: 10px;color: #696969; text-align:center">
        <span style="text-decoration: underline;font-size: 15px;">FASTag Support</span>
        <p><span>*</span>Account recharge may take maximum upto 30 mins to effect.</p>
        <p><span>*</span>Pass usage is subject to validity period at pass enabled plazas only.</p>
        <p><span>*</span>Running account is valid across all FASTag enabled plazas.</p>
       </div>
       
       
   </div>
  </body>
  </html>';
    
    //$pdf->writeHTML($html);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Receipt '.$data['customer'][0]['vehiclechasisnumber'].'.pdf','D');
    
  }
  
  
  
  
  
  public function fitmenchallanexisting($idd){
     if ((!isset($_SESSION['oemid']))) {
       return redirect()->to(base_url('oemLogin'));            
     }
    $data= [];
    error_reporting(0);
    $iddusr=$idd;
    $data['customer'] = $this->salesagentModel->salesAgentreportext($iddusr);
    
    $dtm=date("Y-m-d h:i:s");
    
    $prsnt = $this->salesagentModel->multiSrch('chllnndrecpt','*','customerid',$idd,'customertype',2);
   
    if(sizeof($prsnt) == 0){
      
    $rndid =  strtoupper(random_string('numeric', 8));
    $chlnm = "HIPY-".$rndid.'-'.substr(time(),2);
    $recpt = $rndid;
      
    $dataNominee = ["customerid"=>$idd, "customertype"=>2, "challannumber"=>$chlnm, "receiptnumber"=>$recpt, "datetime"=>$dtm];
    $loginData = $this->loginModel->loginDatainsert('chllnndrecpt',$dataNominee);
      
    }else{
      $chlnm= $prsnt[0]["challannumber"];
    }    
    
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Fitmen Challan");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    
    $html='
 <html lang="en">
    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">        
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
     <title>Fastag</title>
   </head>
   <body style="font-family: \'Montserrat\';">  
     <div class="container">
     
       <table>
         <tr>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/fastag.png" alt="Fastag" align="left" style="margin-top: 30px;" height="90px" width="130px"></td>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/kotak.png" alt="Kotak" height="100px" width="170px" align="right" style="margin-top: 30px;"></td>
         </tr>
       </table>  
       
       <h3 style="text-decoration: underline; text-align:center; font-weight: 500;font-size: 22px;">
           Proof of fitment of FASTag
       </h3>
       
         <table align="left" style="padding: 5px 5px;">
           <tr>
             <td>Fitment Challan Number</td>
             <td>'.$chlnm.'</td>
           </tr>
           <tr>
             <td style="height: 30px;">Dated '.date("d-m-Y" , strtotime($data['customer'][0]['datetime'])).'</td>
             <td style="height: 30px;">Time '.date("h:i:s" , strtotime($data['customer'][0]['datetime'])).'</td>
           </tr>
         </table>
         
       <p style="height: 50px"></p>
       
       <table width="500px" height="500px" align="center" style="border:1px solid black; padding: 5px 5px;">
         <tr>
           <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">FASTag Details</th>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> TID </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['tid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> TAG ID </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['tagid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Barcode Number </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['barcodeid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Banks Issuer Name </li> </ul> </td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$data['customer'][0]['bankname'].' Bank </td>
         </tr>
       </table>
       
       
       
       
       
       <p style="height: 30px"></p>
       
       <table width="500px" height="200px" align="center" style="border:1px solid black; padding: 5px 5px;">
           <tr>
             <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Vehicle Details</th> 
           </tr>
           <tr>
             <td style="padding-left: 2px; font-weight: 500; font-size: 11px;width:180px;"> <ul> <li> Vehicle Registration No : </li> </ul>  </td>';
                 if($data['customer'][0]['vehicleNumbertype'] == 1){
           $vahiclenumber=$data['customer'][0]['vehiclechasisnumber'];
                       $chasisnumber='NA';
                 }else if($data['customer'][0]['vehicleNumbertype'] == 2){
                       $vahiclenumber='NA';
                       $chasisnumber=$data['customer'][0]['vehiclechasisnumber'];
                 }else{
                       $vahiclenumber='NA';
                       $chasisnumber='NA';
                 }
    $html.='<td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;"> '.$vahiclenumber.' </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> <span style="color: red;">*</span>Vehicle No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$vahiclenumber.'</td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> <span style="color: red;">*</span>Chassis No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;">'.$chasisnumber.'</td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;"><ul> <li> Engine No :</li> </ul> </td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:right;"> NA </td>
           </tr>
       </table>
       
       <p style="height: 30px;"></p>
       
       <table align="right"> 
               <tr>
                   <td style="color: black; font-weight: 500; height: 30px;">Stamp and Signature of</td>
               </tr>
               <tr>
                   <td style="color: black; font-weight: 500; height: 30px;">or</td>
               </tr>
               <tr>
                   <td style="color: black; font-weight: 500; height: 100px;">Signature of Customer</td>
               </tr>
       </table>
       
       <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
           <span>*Fields marked(*) are mandatory information to be provided in the challan.</span> <br>
           <span>*Vehicle owner shall be responsible affixing FASTag applied through online channels.</span>
       </div>
   </div>
  </body>
  </html>';
    
    //$pdf->writeHTML($html);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('FitmenChallan '.$data['customer'][0]['vehiclechasisnumber'].'.pdf','D');
    
    
   // $table1="manufacturer";
  //  $viewdata1="manufactureid ,manufacturername,status";
  //  $whrclm1="status";
  //  $whrval1=0;
  //  $data["manufacturer"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);
   // return view('oem/downloadfitmenchallan',$data);
  }
  
  
  ///////////////////////////////////////////////
  ////////////////////////////////////////////////
  
  //the below function is for the fitmenchallanreceipt
  
  ////////////////////////////////////////
  //////////////////////////////////////////
  //////////////////////////////////////////////
  public function fitmenchallanreceiptexisting($idd){ // this is fitmenchallanreceipt() ....................
     if ((!isset($_SESSION['oemid']))) {
       return redirect()->to(base_url('oemLogin'));            
     }
    $data= [];
    error_reporting(0);
    $iddusr=$idd;
    $data['customer'] = $this->salesagentModel->salesAgentreportoemext($iddusr);
    
    $dtm=date("Y-m-d h:i:s");
    
    $prsnt = $this->salesagentModel->multiSrch('chllnndrecpt','*','customerid',$idd,'customertype',2);
   
    if(sizeof($prsnt) == 0){
      
    $rndid =  strtoupper(random_string('numeric', 8));
    $chlnm = "HIPY-".$rndid.'-'.substr(time(),2);
    $recpt = $rndid;
      
    $dataNominee = ["customerid"=>$idd, "customertype"=>2, "challannumber"=>$chlnm, "receiptnumber"=>$recpt, "datetime"=>$dtm];
    $loginData = $this->loginModel->loginDatainsert('chllnndrecpt',$dataNominee);
      
    }else{
      $recpt= $prsnt[0]["receiptnumber"];
    }
    
    
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Fitmen Challan");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    
    $html='
 <html lang="en">
    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">        
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
     <title>Fastag</title>
   </head>
   <body style="font-family: \'Montserrat\';">  
     <div class="container">
     
       <table>
         <tr>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/fastag.png" alt="Fastag" align="left" height="90px" width="130px"></td>
           <td> <img src="'.base_url().'/public/pdfdownloadinmage/kotak.png" alt="Kotak" height="100px" width="170px" align="right"></td>
         </tr>
       </table>  
       
      
         <table align="left" style="padding: 5px 5px;">
           <tr>
             <td>Dear Customer</td>
           </tr>
           <tr>
             <td>Thank you for using KOTAK Bank Services.</td> 
           </tr>
         </table>
    
       <hr style="border: 2px solid black;">
       
       	  <div>
              <div>
                  <label style="font-weight: bold;">Receipt No :</label>
                  <span style="font-weight: 500;">'.$recpt.'</span>
              </div>
              <div>
                  <label style="font-weight: bold;">Date</label>
                  <span style="font-weight: 500;"> '.date("d-m-Y" , strtotime($data['customer'][0]['datetime'])).' </span>
              </div>
          </div>
       
       <table width="500px" height="500px" align="center" style="border:1px solid black; padding: 5px 10px;">
         <tr>
           <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Receipt Details</th>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Manufacturer Name</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['manufacturername'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Dealer Name :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['companyname'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Customer Name :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['customername'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Vehicle Number :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['vehiclechasisnumber'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Barcode :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['barcodeid'].'</td>
         </tr>
         <tr>
           <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Tag ID :</td>
           <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;">'.$data['customer'][0]['tagid'].'</td>
         </tr>
       </table>
       
       <p style="height: 10px;"></p>
       
       <table width="500px" height="200px" align="center" style="border:1px solid black; padding: 5px 10px;">
           <tr>
             <th style="text-align:center; font-size: 15px; border-bottom: 1px solid black; height: 30px;">Amount Breakdown</th> 
           </tr>
           <tr>
             <td style="padding-left: 2px; font-weight: 500; font-size: 11px;width:180px; text-align:left;">Issuance Fees :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 100.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Security Deposit :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 50.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Initial Topup :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 150.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">P.S.Fees :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 200.00 </td>
           </tr>
           <tr>
             <td style="font-weight: 500; font-size: 11px;width:180px;text-align:left;">Total Amount :</td>
             <td style="font-weight: 500; font-size: 11px;width:320px;text-align:left;"> Rs. 500.00 </td>
           </tr>
       </table>
       <p style="height: 5px;"></p>
       	<div>
        	<span style="font-size: 10px;">Note :  GST is included in Tag Issuance Fee and is paid by end customer directly to the KOTAK Bank.</span>
        </div>
       
       <hr style="border: 2px solid black;">
       
       <div style="font-size: 10px;color: #696969; text-align:center">
        <span style="text-decoration: underline;font-size: 15px;">FASTag Support</span>
        <p><span>*</span>Account recharge may take maximum upto 30 mins to effect.</p>
        <p><span>*</span>Pass usage is subject to validity period at pass enabled plazas only.</p>
        <p><span>*</span>Running account is valid across all FASTag enabled plazas.</p>
       </div>
       
       
   </div>
  </body>
  </html>';
    
    //$pdf->writeHTML($html);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Receipt '.$data['customer'][0]['vehiclechasisnumber'].'.pdf','D');
    
  }


    
}

?>