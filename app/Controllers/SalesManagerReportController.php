<?php

namespace App\Controllers;
use \App\Models\SalesAgentModel;
  use \App\Models\ReportModel;
use CodeIgniter\Cookie\Cookie;
use TCPDF;

class SalesManagerReportController extends BaseController
{
    public $loginModel;
    public $reportModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        helper('cookie');
        helper('payment');
        helper('fastag');
        $this->loginModel = new SalesAgentModel();
        $this->reportModel = new ReportModel();
        $this->session = session();
        require_once(APPPATH.'Helpers/tcpdf/tcpdf.php');
        
    }

    public function smteamleadreport()
      {
            if ((!isset($_SESSION['salesmanagerId']))) {
                return redirect()->to(base_url('salesmanagerLogin'));            
            }

        $data=[];
        
        $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
        $data["teamlead"] = $teamlead;
        $cnt = sizeof($teamlead);
        
        for($i=0;$i<$cnt;$i++){
          $totalsale =0;
          $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);
          
          $cnt1 = sizeof($data["salesagent"]);
          
          for($j=0;$j<$cnt1;$j++){
            $salid = $data["salesagent"][$j]["salesagentId"];
            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
            $salescount = sizeof($data['customer']);
            $totalsale = $totalsale + $salescount;
          }       
            $salessizee[] = $totalsale;
            $data["salessize"] = $salessizee;
        }
        
        $data["typp"] = 0;
         return view('salesmanager/teamleadreport',$data);
    }
  
  
  	public function newcustomertl($id)
      {
            if ((!isset($_SESSION['salesmanagerId']))) {
                return redirect()->to(base_url('salesmanagerLogin'));            
            }

        $data=[];

         $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

          $cnt= sizeof($data["salesagent"]);

          for($i=0;$i<$cnt;$i++){
            $salid = $data["salesagent"][$i]["salesagentId"];
            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
            $salescount = sizeof($data['customer']);
            $salessize[] = $salescount;
          }
           $data["salessize"] = $salessize;
           $data["rqstby"] = $id;
           $data["typp"] = 0;
      
      // exit;

         return view('salesmanager/newcustomertl',$data);
      }
  
  
  
  	public function individualagentreport($id)
      {
            if ((!isset($_SESSION['salesmanagerId']))) {
                return redirect()->to(base_url('salesmanagerLogin'));            
            }

        $data=[];
        $fastag[]="";

        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
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
         $data["rqstby"] = $id;
         $data["typp"] = 0;

         return view('salesmanager/newcustomerreportindividual',$data);
      }
  
  
  	  public function individualagentreportexisting($id)
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
          $fastag[]="";

          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagentType' =>0);
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
           $data["rqstby"] = $id;
           $data["typp"] = 1;

           return view('salesmanager/existingcustomerreportindividual',$data);
        }
  
  
  
  	  public function existingtl()
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];

          $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $totalsale =0;
            $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            }       
              $salessizee[] = $totalsale;
              $data["salessize"] = $salessizee;
          }
			
          $data["typp"] = 1;

           return view('salesmanager/teamleadreport',$data);
      }
  
  
  
  	 public function existingcustomertl($id)
      {
            if ((!isset($_SESSION['salesmanagerId']))) {
                return redirect()->to(base_url('salesmanagerLogin'));            
            }

        $data=[];

         $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

          $cnt= sizeof($data["salesagent"]);
       if($cnt >0){

          for($i=0;$i<$cnt;$i++){
            $salid = $data["salesagent"][$i]["salesagentId"];
            $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
            $salescount = sizeof($data['customer']);
            $salessize[] = $salescount;
          }
       }else{
         	$salessize=[];
       }
           $data["salessize"] = $salessize;
           $data["rqstby"] = $id;
           $data["typp"] = 1;
      
      // exit;

         return view('salesmanager/newcustomertl',$data);
      }
  
  
  	public function downloadtl()
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }
      
                        $data=[];
                        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                       // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                           <table border="1" cellpadding="2" cellspacing="2" align="center">
                             <tr nobr="true">
                              <th colspan="5">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
									<th>Regd. Id</th>
                                    <th>Name</th>
                                    <th>Target</th>
                                    <th>Total Tag Activation</th>
                                  </tr>
                             </thead>
                                 <tbody>';
      
      								$teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      }       
                                        $salessizee[] = $totalsale;
                                        $data["salessize"] = $salessizee;
                                    }
      
                                    $j=0;
                                    for($i=0;$i<$cnt;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['teamlead'][$i]["TleadRegdNum"].'</td>
                                                    <td>'.$data['teamlead'][$i]["Fname"].' '.$data['teamlead'][$i]["Lname"].'</td>
                                                    <td>'.$data['teamlead'][$i]["target"].'</td>
                                                    <td>'.$data["salessize"][$i].'</td>
                                                 </tr>';                              
                                    }

                         $html.='</tbody>
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
  
  
  
  		public function downloadexttl()
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="5">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                     <th>SL NO</th>
                                      <th>Regd. Id</th>
                                      <th>Name</th>
                                      <th>Target</th>
                                      <th>Total Tag Activation</th>
                                    </tr>
                               </thead>
                                   <tbody>';

                                      $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);

                                      for($i=0;$i<$cnt;$i++){
                                        $totalsale =0;
                                        $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                        $cnt1 = sizeof($data["salesagent"]);

                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
                                          $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        }       
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                      }

                                      $j=0;
                                      for($i=0;$i<$cnt;$i++){ 
                                        $j++;

                                           $html.='<tr nobr="true">
                                                      <td>'.$j.'</td>
                                                      <td>'.$data['teamlead'][$i]["TleadRegdNum"].'</td>
                                                      <td>'.$data['teamlead'][$i]["Fname"].' '.$data['teamlead'][$i]["Lname"].'</td>
                                                      <td>'.$data['teamlead'][$i]["target"].'</td>
                                                      <td>'.$data["salessize"][$i].'</td>
                                                   </tr>';                              
                                      }

                           $html.='</tbody>
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
  
  
  		public function downloadindvtl($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="6">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                     <th>SL NO</th>
                                     <th>Regd. Id</th>
                                     <th>Name</th>
                                     <th>Contact</th>
                                     <th>Total Tag Activated</th>
                                     <th>Status</th>
                                   </tr>
                               </thead>
                                   <tbody>';

                                      $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

                                      $cnt= sizeof($data["salesagent"]);

                                      for($i=0;$i<$cnt;$i++){
                                        $salid = $data["salesagent"][$i]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $salessize[] = $salescount;
                                      }
                                       $data["salessize"] = $salessize;

                                      $j=0;
                                      for($i=0;$i<$cnt;$i++){ 
                                        $j++;

                                        if($data["salesagent"][$i]["status"] == 0){
                                          $sts="Active";
                                        }else if($data["salesagent"][$i]["status"] == 1){
                                          $sts="Blocked";
                                        }else if($data["salesagent"][$i]["status"] == 2){
                                          $sts="Request Pending";
                                        }else if($data["salesagent"][$i]["status"] == 3){
                                          $sts="Request Rejected";
                                        }

                                           $html.='<tr nobr="true">
                                                      <td>'.$j.'</td>
                                                      <td>'.$data["salesagent"][$i]["salesAgentRegdNum"].'</td>
                                                      <td>'.$data["salesagent"][$i]["Fname"].' '.$data['salesagent'][$i]["Lname"].'</td>
                                                      <td>'.$data["salesagent"][$i]["ContactPrimary"].'</td>
                                                      <td>'.$data["salessize"][$i].'</td>
                                                      <td>'.$sts.'</td>
                                                   </tr>';                              
                                      }

                           $html.='</tbody>
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
  
  
  
  		 public function downloadindvtlexisting($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="6">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                     <th>SL NO</th>
                                     <th>Regd. Id</th>
                                     <th>Name</th>
                                     <th>Contact</th>
                                     <th>Total Tag Activated</th>
                                     <th>Status</th>
                                   </tr>
                               </thead>
                                   <tbody>';

                                      $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

                                      $cnt= sizeof($data["salesagent"]);

                                      for($i=0;$i<$cnt;$i++){
                                        $salid = $data["salesagent"][$i]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
                                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $salessize[] = $salescount;
                                      }
                                       $data["salessize"] = $salessize;

                                      $j=0;
                                      for($i=0;$i<$cnt;$i++){ 
                                        $j++;

                                        if($data["salesagent"][$i]["status"] == 0){
                                          $sts="Active";
                                        }else if($data["salesagent"][$i]["status"] == 1){
                                          $sts="Blocked";
                                        }else if($data["salesagent"][$i]["status"] == 2){
                                          $sts="Request Pending";
                                        }else if($data["salesagent"][$i]["status"] == 3){
                                          $sts="Request Rejected";
                                        }

                                           $html.='<tr nobr="true">
                                                      <td>'.$j.'</td>
                                                      <td>'.$data["salesagent"][$i]["salesAgentRegdNum"].'</td>
                                                      <td>'.$data["salesagent"][$i]["Fname"].' '.$data['salesagent'][$i]["Lname"].'</td>
                                                      <td>'.$data["salesagent"][$i]["ContactPrimary"].'</td>
                                                      <td>'.$data["salessize"][$i].'</td>
                                                      <td>'.$sts.'</td>
                                                   </tr>';                              
                                      }

                           $html.='</tbody>
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
  
  
  		public function downloadreportindvl($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="9">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                      <th>SL NO</th>
                                      <th>Customer Name</th>
                                      <th>Customer Id</th>
                                      <th>PAN Card Number</th>
                                      <th> Vehicle/ Chassis Number </th>
                                      <th>Mobile Number</th>
                                      <th>Bar Code</th>
                                      <th>Date Of Activation</th>
                                      <th>Time Of Activation</th>
                                   </tr>
                               </thead>
                                   <tbody>';

                                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
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

                           $html.='</tbody>
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
  
  
  
  		 public function downloadreportindvlext($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="8">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                      <th>SL NO</th>
                                      <th>Customer Name</th>
                                      <th>Customer Id</th>
                                      <th> Vehicle/ Chassis Number </th>
                                      <th>Mobile Number</th>
                                      <th>Bar Code</th>
                                      <th>Date Of Activation</th>
                                      <th>Time Of Activation</th>
                                   </tr>
                               </thead>
                                   <tbody>';

                                      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagentType' =>0);
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

                           $html.='</tbody>
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
  
  
  
  
  		public function searchdata($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

            $data=[];
            $rules = [
                "dtstrt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Start Date Is required ',
                    ],
                ],
                "endt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'End Date Is required ',
                    ],
                ],
            ];

            if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                    $dtstrt = $this->request->getVar('dtstrt');
                    $endt = $this->request->getVar('endt');
                    $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                    $rt = $dtstrt.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';

                    $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                    $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);

                    $cnt= sizeof($data['customer']);

                    if($cnt == 0){
                      $fstgdetls = [];
                    }else {
                      for($i=0;$i<$cnt;$i++){
                          $fstgdetls[] = $this->loginModel->multiSrch('fasttag','*','barcode',$data['customer'][$i]["barcodeid"],'status',2);
                      } 
                    }

                  $datadatebetween[0] = $dtstrt;
                  $datadatebetween[1] = $endt;
                  $data['datadatebetween'] = $datadatebetween;

                     $data['fstgdetls'] = $fstgdetls;
                     $data["rqstby"] = $id;
                    return view('salesmanager/newcustomerreportindividual',$data);

                }else{
                    $data['validations'] = $this->validator;
                }
            }


            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
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
             $data["rqstby"] = $id;
            

             return view('salesmanager/newcustomerreportindividual',$data);
          }
  
  
  		  public function downloadreportextcustomerindvdate($id,$fromdate,$tilldate)
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
           
           
          


                        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                       // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                        $pdf->SetCreator(PDF_CREATOR);  
                        $pdf->SetTitle("Tag Activation Report");  
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
                                    $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );

                                    $rt = $fromdate.' 00:00:00';
                                    $rte = $endt_ftr.' 00:00:00';          


                                    $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
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

                         $html.='</tbody>
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
  
  
  		public function newcustomersrch($id)
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
            $rules = [
                "dtstrt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Start Date Is required ',
                    ],
                ],
                "endt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'End Date Is required ',
                    ],
                ],
            ];

            if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                    $dtstrt = $this->request->getVar('dtstrt');
                    $endt = $this->request->getVar('endt');
                    $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                    $rt = $dtstrt.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';
                  
                  
                  	$data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);

                    $cnt= sizeof($data["salesagent"]);

                    for($i=0;$i<$cnt;$i++){
                      $salid = $data["salesagent"][$i]["salesagentId"];
                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                      $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                      $salescount = sizeof($data['customer']);
                      $salessize[] = $salescount;
                    }
                      $data["salessize"] = $salessize;
      
                      $datadatebetween[0] = $dtstrt;
                      $datadatebetween[1] = $endt;
                      $data['datadatebetween'] = $datadatebetween;
                  
                  	  $data["rqstby"] = $id;
                      $data["typp"] = 0;
                 

                     return view('salesmanager/newcustomertl',$data);
                  
                }else{
                    $data['validations'] = $this->validator;
                }
            }

          	$data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);      
            $cnt= sizeof($data["salesagent"]);

            for($i=0;$i<$cnt;$i++){
              $salid = $data["salesagent"][$i]["salesagentId"];
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
              $salessize[] = $salescount;
            }
             $data["salessize"] = $salessize;
             $data["rqstby"] = $id;
             $data["typp"] = 0;
      

           return view('salesmanager/newcustomertl',$data);
        }
  
  		
  
  		public function downloadreportnewcustomerdate($id,$fromdate,$tilldate)
          {
            if ((!isset($_SESSION['salesmanagerId']))) {
              return redirect()->to(base_url('salesmanagerLogin'));            
            }


                    $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );

                    $rt = $fromdate.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';
                  
                  
                  	$data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);

                    $cnt= sizeof($data["salesagent"]);

                    for($i=0;$i<$cnt;$i++){
                      $salid = $data["salesagent"][$i]["salesagentId"];
                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                      $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                      $salescount = sizeof($data['customer']);
                      $salessize[] = $salescount;
                    }
                     $data["salessize"] = $salessize;



            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
            // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
            $pdf->SetCreator(PDF_CREATOR);  
            $pdf->SetTitle("Report Field Sales Executive");  
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
                                          <th colspan="5">Tag Activation Report</th>
                                         </tr>
                                         <thead>
                                         <tr nobr="true">
                                             <th>SL NO</th>
                                             <th>Regd. Id</th>
                                             <th>Name</th>
                                             <th>Contact</th>
                                             <th>Total Tag Activated</th>
                                         </tr>
                                         </thead>
                                         <tbody>';
                                            $cnt= sizeof($data["salesagent"]);
                                            $j=0;
                                            for($i=0;$i<$cnt;$i++){ 
                                              $j++;

                                              $html.='<tr nobr="true">
                                                          <td>'.$j.'</td>
                                                          <td>'.$data["salesagent"][$i]["salesAgentRegdNum"].'</td>
                                                          <td>'.$data["salesagent"][$i]["Fname"].' '.$data["salesagent"][$i]["Lname"].'</td>
                                                          <td>'.$data["salesagent"][$i]["ContactPrimary"].'</td>
                                                          <td>'.$data["salessize"][$i].'</td>
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
  
  
      public function searchh()
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
        
          $rules = [
                "dtstrt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Start Date Is required ',
                    ],
                ],
                "endt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'End Date Is required ',
                    ],
                ],
            ];
        
        if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                  
                    $dtstrt = $this->request->getVar('dtstrt');
                    $endt = $this->request->getVar('endt');
                    $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                    $rt = $dtstrt.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';
                  
                  $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                  $data["teamlead"] = $teamlead;
                  $cnt = sizeof($teamlead);

                  for($i=0;$i<$cnt;$i++){
                    $totalsale =0;
                    $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                    $cnt1 = sizeof($data["salesagent"]);

                    for($j=0;$j<$cnt1;$j++){
                      $salid = $data["salesagent"][$j]["salesagentId"];
                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                      $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                      $salescount = sizeof($data['customer']);
                      $totalsale = $totalsale + $salescount;
                    }       
                      $salessizee[] = $totalsale;
                      $data["salessize"] = $salessizee;
                  }

                      $data["typp"] = 0;
                      $datadatebetween[0] = $dtstrt;
                      $datadatebetween[1] = $endt;
                      $data['datadatebetween'] = $datadatebetween;
                 

                     return view('salesmanager/teamleadreport',$data);
                  
                  
                }else{
                    $data['validations'] = $this->validator;
                }
            }

          $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $totalsale =0;
            $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            }       
              $salessizee[] = $totalsale;
              $data["salessize"] = $salessizee;
          }

          $data["typp"] = 0;
           return view('salesmanager/teamleadreport',$data);
      }
  
  
  	  public function searchhdownload($fromdate,$tilldate)
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }
      
                        $data=[];
                        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                       // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                           <table border="1" cellpadding="2" cellspacing="2" align="center">
                             <tr nobr="true">
                              <th colspan="5">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
									<th>Regd. Id</th>
                                    <th>Name</th>
                                    <th>Target</th>
                                    <th>Total Tag Activation</th>
                                  </tr>
                             </thead>
                                 <tbody>';
        
                                    $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );

                                    $rt = $fromdate.' 00:00:00';
                                    $rte = $endt_ftr.' 00:00:00';
      
      								$teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      }       
                                        $salessizee[] = $totalsale;
                                        $data["salessize"] = $salessizee;
                                    }
      
                                    $j=0;
                                    for($i=0;$i<$cnt;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['teamlead'][$i]["TleadRegdNum"].'</td>
                                                    <td>'.$data['teamlead'][$i]["Fname"].' '.$data['teamlead'][$i]["Lname"].'</td>
                                                    <td>'.$data['teamlead'][$i]["target"].'</td>
                                                    <td>'.$data["salessize"][$i].'</td>
                                                 </tr>';                              
                                    }

                         $html.='</tbody>
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
  
  
  
  		public function searchhext()
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
        
          $rules = [
                "dtstrt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Start Date Is required ',
                    ],
                ],
                "endt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'End Date Is required ',
                    ],
                ],
            ];
        
        if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                  
                    $dtstrt = $this->request->getVar('dtstrt');
                    $endt = $this->request->getVar('endt');
                    $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                    $rt = $dtstrt.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';

                    $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                    $data["teamlead"] = $teamlead;
                    $cnt = sizeof($teamlead);

                    for($i=0;$i<$cnt;$i++){
                      $totalsale =0;
                      $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                      $cnt1 = sizeof($data["salesagent"]);

                      for($j=0;$j<$cnt1;$j++){
                        $salid = $data["salesagent"][$j]["salesagentId"];
                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                        $salescount = sizeof($data['customer']);
                        $totalsale = $totalsale + $salescount;
                      }       
                        $salessizee[] = $totalsale;
                        $data["salessize"] = $salessizee;
                    }
                  	
                  	  $data["typp"] = 1;
                      $datadatebetween[0] = $dtstrt;
                      $datadatebetween[1] = $endt;
                      $data['datadatebetween'] = $datadatebetween;
                 

                     return view('salesmanager/teamleadreport',$data);
                  
                }else{
                  $data['validations'] = $this->validator;
                }
        }
          
          
                    $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                    $data["teamlead"] = $teamlead;
                    $cnt = sizeof($teamlead);

                    for($i=0;$i<$cnt;$i++){
                      $totalsale =0;
                      $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                      $cnt1 = sizeof($data["salesagent"]);

                      for($j=0;$j<$cnt1;$j++){
                        $salid = $data["salesagent"][$j]["salesagentId"];
                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                        $salescount = sizeof($data['customer']);
                        $totalsale = $totalsale + $salescount;
                      }       
                        $salessizee[] = $totalsale;
                        $data["salessize"] = $salessizee;
                    }
                  	

                    $data["typp"] = 1;

             return view('salesmanager/teamleadreport',$data);
        }
  
  
  		public function individualagentreportexistingext($id)
        {
              if ((!isset($_SESSION['salesmanagerId']))) {
                  return redirect()->to(base_url('salesmanagerLogin'));            
              }

          $data=[];
          $fastag[]="";
          
          $rules = [
                "dtstrt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Start Date Is required ',
                    ],
                ],
                "endt"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'End Date Is required ',
                    ],
                ],
            ];
        
        if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                  
                    $dtstrt = $this->request->getVar('dtstrt');
                    $endt = $this->request->getVar('endt');
                    $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                    $rt = $dtstrt.' 00:00:00';
                    $rte = $endt_ftr.' 00:00:00';
                  
                  
                  $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
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
                   $data["rqstby"] = $id;
                   $data["typp"] = 1;
                   $datadatebetween[0] = $dtstrt;
                   $datadatebetween[1] = $endt;
                   $data['datadatebetween'] = $datadatebetween;
                
                   return view('salesmanager/existingcustomerreportindividual',$data);
                
                }else{
                  $data['validations'] = $this->validator;
                }
        }

          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagentType' =>0);
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
           $data["rqstby"] = $id;
           $data["typp"] = 1;

           return view('salesmanager/existingcustomerreportindividual',$data);
        }
  
  
  		public function downloadreportinext($id,$fromdate,$tilldate)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="8">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                      <th>SL NO</th>
                                      <th>Customer Name</th>
                                      <th>Customer Id</th>
                                      <th> Vehicle/ Chassis Number </th>
                                      <th>Mobile Number</th>
                                      <th>Bar Code</th>
                                      <th>Date Of Activation</th>
                                      <th>Time Of Activation</th>
                                   </tr>
                               </thead>
                                   <tbody>';
          
          							  $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                      $rt = $fromdate.' 00:00:00';
                                      $rte = $endt_ftr.' 00:00:00';

                                      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
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

                           $html.='</tbody>
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
  
  
  		 public function existingcustomertlext($id)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

             $data=[];
             $rules = [
                  "dtstrt"=>[
                      'rules'=>'required',
                      'errors'=>[
                          'required'=>'Start Date Is required ',
                      ],
                  ],
                  "endt"=>[
                      'rules'=>'required',
                      'errors'=>[
                          'required'=>'End Date Is required ',
                      ],
                  ],
              ];

          if($this->request->getMethod() == "post"){
                  if($this->validate($rules)){

                      $dtstrt = $this->request->getVar('dtstrt');
                      $endt = $this->request->getVar('endt');
                      $endt_ftr = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                      $rt = $dtstrt.' 00:00:00';
                      $rte = $endt_ftr.' 00:00:00';
                    
                      $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

                      $cnt= sizeof($data["salesagent"]);
                   if($cnt >0){

                      for($i=0;$i<$cnt;$i++){
                        $salid = $data["salesagent"][$i]["salesagentId"];
                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                        $salescount = sizeof($data['customer']);
                        $salessize[] = $salescount;
                      }
                   }else{
                        $salessize=[];
                   }
                       $data["salessize"] = $salessize;
                       $data["rqstby"] = $id;
                       $data["typp"] = 1;
                       $datadatebetween[0] = $dtstrt;
                       $datadatebetween[1] = $endt;
                       $data['datadatebetween'] = $datadatebetween;
                    
                    return view('salesmanager/newcustomertl',$data);
                    
                  }else{
                    $data['validations'] = $this->validator;
                  }
        }

             $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

              $cnt= sizeof($data["salesagent"]);
           if($cnt >0){

              for($i=0;$i<$cnt;$i++){
                $salid = $data["salesagent"][$i]["salesagentId"];
                $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0);
                $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                $salescount = sizeof($data['customer']);
                $salessize[] = $salescount;
              }
           }else{
                $salessize=[];
           }
               $data["salessize"] = $salessize;
               $data["rqstby"] = $id;
               $data["typp"] = 1;

          // exit;

             return view('salesmanager/newcustomertl',$data);
          }
  
  
  		  public function downloadindvtlexistingdwn($id,$fromdate,$tilldate)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="6">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                     <th>SL NO</th>
                                     <th>Regd. Id</th>
                                     <th>Name</th>
                                     <th>Contact</th>
                                     <th>Total Tag Activated</th>
                                     <th>Status</th>
                                   </tr>
                               </thead>
                                   <tbody>';
                                      
                                      $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                      $rt = $fromdate.' 00:00:00';
                                      $rte = $endt_ftr.' 00:00:00';

                                      $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($id);     

                                      $cnt= sizeof($data["salesagent"]);

                                      for($i=0;$i<$cnt;$i++){
                                        $salid = $data["salesagent"][$i]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                        $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $salessize[] = $salescount;
                                      }
                                       $data["salessize"] = $salessize;

                                      $j=0;
                                      for($i=0;$i<$cnt;$i++){ 
                                        $j++;

                                        if($data["salesagent"][$i]["status"] == 0){
                                          $sts="Active";
                                        }else if($data["salesagent"][$i]["status"] == 1){
                                          $sts="Blocked";
                                        }else if($data["salesagent"][$i]["status"] == 2){
                                          $sts="Request Pending";
                                        }else if($data["salesagent"][$i]["status"] == 3){
                                          $sts="Request Rejected";
                                        }

                                           $html.='<tr nobr="true">
                                                      <td>'.$j.'</td>
                                                      <td>'.$data["salesagent"][$i]["salesAgentRegdNum"].'</td>
                                                      <td>'.$data["salesagent"][$i]["Fname"].' '.$data['salesagent'][$i]["Lname"].'</td>
                                                      <td>'.$data["salesagent"][$i]["ContactPrimary"].'</td>
                                                      <td>'.$data["salessize"][$i].'</td>
                                                      <td>'.$sts.'</td>
                                                   </tr>';                              
                                      }

                           $html.='</tbody>
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
  
  
  		  public function searchhdownloadext($fromdate,$tilldate)
          {
                if ((!isset($_SESSION['salesmanagerId']))) {
                    return redirect()->to(base_url('salesmanagerLogin'));            
                }

                          $data=[];
                          $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                         // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
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
                             <table border="1" cellpadding="2" cellspacing="2" align="center">
                               <tr nobr="true">
                                <th colspan="5">Tag Activation Report</th>
                               </tr>
                               <thead>
                                   <tr>
                                     <th>SL NO</th>
                                      <th>Regd. Id</th>
                                      <th>Name</th>
                                      <th>Target</th>
                                      <th>Total Tag Activation</th>
                                    </tr>
                               </thead>
                                   <tbody>';
                                      $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                      $rt = $fromdate.' 00:00:00';
                                      $rte = $endt_ftr.' 00:00:00';

                                      $teamlead = $this->loginModel->viewspecific('teamlead','*','requestedById',$_SESSION['salesmanagerId']);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);

                                      for($i=0;$i<$cnt;$i++){
                                        $totalsale =0;
                                        $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                        $cnt1 = sizeof($data["salesagent"]);

                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                          $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        }       
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                      }

                                      $j=0;
                                      for($i=0;$i<$cnt;$i++){ 
                                        $j++;

                                           $html.='<tr nobr="true">
                                                      <td>'.$j.'</td>
                                                      <td>'.$data['teamlead'][$i]["TleadRegdNum"].'</td>
                                                      <td>'.$data['teamlead'][$i]["Fname"].' '.$data['teamlead'][$i]["Lname"].'</td>
                                                      <td>'.$data['teamlead'][$i]["target"].'</td>
                                                      <td>'.$data["salessize"][$i].'</td>
                                                   </tr>';                              
                                      }

                           $html.='</tbody>
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