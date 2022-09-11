<?php

namespace App\Controllers;
use \App\Models\SalesAgentModel;
use CodeIgniter\Cookie\Cookie;
use TCPDF; 

class SalesAgentReportController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        helper('cookie');
        helper('payment');
        helper('fastag');
        $this->loginModel = new SalesAgentModel();
        $this->session = session();
        require_once(APPPATH.'Helpers/tcpdf/tcpdf.php');
        
    }

    public function newcustomer()
    {
      	  if ((!isset($_SESSION['salesagentId']))) {
              return redirect()->to(base_url('salesagentLogin'));            
          }
      
      
      if($this->request->getMethod() == "post"){
          
          if($this->request->getVar('getBaltel')){
            
            $mobileNum = $this->request->getVar('getBaltel');
            $data["fastag"] = GetBalance($mobileNum);
            $data1 = json_decode($data['fastag'])[1];
            $array = json_decode(json_encode($data1), true);
            $response = $array["BALANCEDETAILS"][0]["TOTALWALLETBALANCE"];
            
            echo $response;
            exit;
            
          }
      }
      
      $data=[];
      $fastag[] ="";
     
      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $_SESSION['salesagentId'] , 'salesagenttype' =>0);
      $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
      
      $cnt= sizeof($data['customer']);
      
      if($cnt == 0){
        $fstgdetls = [];
      }else {
        for($i=0;$i<$cnt;$i++){
            $fstgdetls[] = $this->loginModel->multiSrch('fasttag','*','barcode',$data['customer'][$i]["barcodeid"],'status',2);
        } 
      }
      
       $data['fstgdetls'] = $fstgdetls;     
      
       return view('salesagent/newcustomerreport',$data);
    }
  
    public function existingcustomer()
      {
            if ((!isset($_SESSION['salesagentId']))) {
                return redirect()->to(base_url('salesagentLogin'));            
            }
      
      
      		if($this->request->getMethod() == "post"){
          
          if($this->request->getVar('getBaltel')){
            
            $mobileNum = $this->request->getVar('getBaltel');
            $data["fastag"] = GetBalance($mobileNum);
            $data1 = json_decode($data['fastag'])[1];
            $array = json_decode(json_encode($data1), true);
            $response = $array["BALANCEDETAILS"][0]["TOTALWALLETBALANCE"];
            
            echo $response;
            exit;
            
          }
      }
      
      $data=[];
      $fastag[] ="";
     
      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $_SESSION['salesagentId'] , 'salesagentType' =>0);
      $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
      
      $cnt= sizeof($data['customer']);
      if($cnt == 0){
        $fstgdetls = [];
      }else {
        for($i=0;$i<$cnt;$i++){
          $fstgdetls[] = $this->loginModel->multiSrch('fasttag','*','barcode',$data['customer'][$i]["barcodeid"],'status',2);
        }
      }
       $data['fstgdetls'] = $fstgdetls;

        

         return view('salesagent/existingcustomerreport',$data);
      }
  
  
  	 public function downloadreportnewcustomer()
      {
            if ((!isset($_SESSION['salesagentId']))) {
                return redirect()->to(base_url('salesagentLogin'));            
            }
        


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                     // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
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
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="9">Tag Activation Report</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <td>Sl No</td>
                               <td>Customer Name</td>
                               <td>Customer Id</td>
                               <td>PAN Card Number</td>
                               <td>Vehicle/ Chassis Number</td>
                               <td>Mobile Number</td>
                               <td>Bar Code</td>
                               <td>Date Of Activation</td>
                               <td>Time Of Activation</td>
                           </tr>
                           </thead>
                           <tbody>';
                            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $_SESSION['salesagentId'] , 'salesagenttype' =>0);
                            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);

                            $cnt= sizeof($data['customer']);
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["pancarddetails"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
  
  
  	  public function downloadreportexestingcustomer()
      {
            if ((!isset($_SESSION['salesagentId']))) {
                return redirect()->to(base_url('salesagentLogin'));            
            }
        


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                     // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
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
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="8">Tag Activation Report</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <th>Sl No</th>
                               <th>Customer Name</th>
                               <th>Customer Id</th>
                               <th>Vehicle/ Chassis Number</th>
                               <th>Mobile Number</th>
                               <th>Bar Code</th>
                               <th>Date Of Activation</th>
                               <th>Time Of Activation</th>
                           </tr>
                           </thead>
                           <tbody>';
                            $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $_SESSION['salesagentId'] , 'salesagentType' =>0);
      						$data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);

                            $cnt= sizeof($data['customer']);
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
}

?>