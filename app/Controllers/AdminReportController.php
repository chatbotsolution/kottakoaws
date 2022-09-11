<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\SalesAgentModel;
use TCPDF;

class AdminReportController extends BaseController
{
    public $loginModel;
    public $salesagentModel;


    public function __construct(){
        helper("form");
        $this->loginModel = new SalesManagerModel();
        $this->salesagentModel = new SalesAgentModel();
        $this->session = session();
        require_once(APPPATH.'Helpers/tcpdf/tcpdf.php');
        
    }
  
  	public function newCustomer(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  $data["salesmanager"]=$this->loginModel->showSelectd();
      
                  $smcount = sizeof($data["salesmanager"]);

                  for($k=0;$k<$smcount;$k++){          
                    $totalsale =0;
                    $smid = $data["salesmanager"][$k]["salesManagerId"];      
                    $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                    $data["teamlead"] = $teamlead;
                    $cnt = sizeof($teamlead);

                    for($i=0;$i<$cnt;$i++){
                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                      $cnt1 = sizeof($data["salesagent"]);

                      for($j=0;$j<$cnt1;$j++){
                        $salid = $data["salesagent"][$j]["salesagentId"];
                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                        $salescount = sizeof($data['customer']);
                        $totalsale = $totalsale + $salescount;
                      } 
                    }      
                        $salessizee[] = $totalsale;
                        $data["salessize"] = $salessizee;

                  }
                        $datadatebetween[0] = $dtstrt;
                        $datadatebetween[1] = $endt;
                        $data['datadatebetween'] = $datadatebetween;
                        $data["link"]="secure/smreportdetails";
                        $data["typ"] =0;

                  return view('admin/newcustomer',$data);
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }

        $data["salesmanager"]=$this->loginModel->showSelectd();
      
      	$smcount = sizeof($data["salesmanager"]);
      
      	for($k=0;$k<$smcount;$k++){          
          $totalsale =0;
          $smid = $data["salesmanager"][$k]["salesManagerId"];      
          $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            } 
          }      
              $salessizee[] = $totalsale;
              $data["salessize"] = $salessizee;
          
        }
      		  $data["link"]="secure/smreportdetails";
              $data["typ"] =0;

        return view('admin/newcustomer',$data);
    }
  
  
    public function smreportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  
                  $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                  $data["teamlead"] = $teamlead;
                  $cnt = sizeof($teamlead);

                  for($i=0;$i<$cnt;$i++){
                    $totalsale =0;
                    $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                    $cnt1 = sizeof($data["salesagent"]);

                    for($j=0;$j<$cnt1;$j++){
                      $salid = $data["salesagent"][$j]["salesagentId"];
                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                      $salescount = sizeof($data['customer']);
                      $totalsale = $totalsale + $salescount;
                    } 

                     $salessizee[] = $totalsale;
                     $data["salessize"] = $salessizee;
                  }   
                  
                    $datadatebetween[0] = $dtstrt;
                    $datadatebetween[1] = $endt;
                    $data['datadatebetween'] = $datadatebetween;
                    $data["link"]="secure/tlreportdetails";
                    $data["typ"] =0;
                    $data["slctid"] = $id;

                return view('admin/smreportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
    
          $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $totalsale =0;
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            } 
            
             $salessizee[] = $totalsale;
             $data["salessize"] = $salessizee;
          }   
      		$data["link"]="secure/tlreportdetails";
            $data["typ"] =0;
            $data["slctid"] = $id;
     
        return view('admin/smreportdetails',$data);
      
    }
  
  
  	public function tlreportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  
                  $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);

                  $cnt1 = sizeof($data["salesagent"]);

                  for($j=0;$j<$cnt1;$j++){
                    $totalsale =0;
                    $salid = $data["salesagent"][$j]["salesagentId"];
                    $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                    $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                    $salescount = sizeof($data['customer']);
                    $totalsale = $totalsale + $salescount;

                    $salessizee[] = $totalsale;
                  } 


                   $data["salessize"] = $salessizee;  
                   $data["link"]="secure/sareportdetails";
                   $data["typ"] =0;
                   $data["slctid"] = $id;
                   $datadatebetween[0] = $dtstrt;
                   $datadatebetween[1] = $endt;
                   $data['datadatebetween'] = $datadatebetween;

                return view('admin/tlreportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
      
            
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $totalsale =0;
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
              
              $salessizee[] = $totalsale;
            } 
            
             
             $data["salessize"] = $salessizee;  
      		 $data["link"]="secure/sareportdetails";
             $data["typ"] =0;
             $data["slctid"] = $id;
      
      
     		
        return view('admin/tlreportdetails',$data);
      
    }
  
  
  	public function sareportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                  $data["slctid"] = $id;
                  $datadatebetween[0] = $dtstrt;
                  $datadatebetween[1] = $endt;
                  $data['datadatebetween'] = $datadatebetween;
                  $data["typ"] =0;

                return view('admin/sareportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
      
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
              $data["slctid"] = $id;
              $data["typ"] =0;
 
      
     
        return view('admin/sareportdetails',$data);
      
    }
  
  
  
  //*-------------------------------------------- Existing Customers -------------------------------------------------*//
  
  
  public function existingCustomer(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  $data["salesmanager"]=$this->loginModel->showSelectd();
      
                  $smcount = sizeof($data["salesmanager"]);

                  for($k=0;$k<$smcount;$k++){          
                    $totalsale =0;
                    $smid = $data["salesmanager"][$k]["salesManagerId"];      
                    $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                    $data["teamlead"] = $teamlead;
                    $cnt = sizeof($teamlead);

                    for($i=0;$i<$cnt;$i++){
                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                      $cnt1 = sizeof($data["salesagent"]);

                      for($j=0;$j<$cnt1;$j++){
                        $salid = $data["salesagent"][$j]["salesagentId"];
                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                        $salescount = sizeof($data['customer']);
                        $totalsale = $totalsale + $salescount;
                      } 
                    }      
                        $salessizee[] = $totalsale;
                        $data["salessize"] = $salessizee;

                  }
                        $datadatebetween[0] = $dtstrt;
                        $datadatebetween[1] = $endt;
                        $data['datadatebetween'] = $datadatebetween;
                        $data["link"]="secure/smextreportdetails";
                        $data["typ"] =1;

                  return view('admin/newcustomer',$data);
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }

        $data["salesmanager"]=$this->loginModel->showSelectd();
      
      	$smcount = sizeof($data["salesmanager"]);
      
      	for($k=0;$k<$smcount;$k++){          
          $totalsale =0;
          $smid = $data["salesmanager"][$k]["salesManagerId"];      
          $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            } 
          }      
              $salessizee[] = $totalsale;
              $data["salessize"] = $salessizee;
              $data["link"]="secure/smextreportdetails";
              $data["typ"] =1;
          
        }

        return view('admin/newcustomer',$data);
    }
  
  
    public function smextreportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  
                  $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                  $data["teamlead"] = $teamlead;
                  $cnt = sizeof($teamlead);

                  for($i=0;$i<$cnt;$i++){
                    $totalsale =0;
                    $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                    $cnt1 = sizeof($data["salesagent"]);

                    for($j=0;$j<$cnt1;$j++){
                      $salid = $data["salesagent"][$j]["salesagentId"];
                      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                      $salescount = sizeof($data['customer']);
                      $totalsale = $totalsale + $salescount;
                    } 

                     $salessizee[] = $totalsale;
                     $data["salessize"] = $salessizee;
                  }   
                    $data["link"]="secure/tlextreportdetails";
                    $data["typ"] =1;
                    $data["slctid"] = $id;
                  
                  	$datadatebetween[0] = $dtstrt;
                    $datadatebetween[1] = $endt;
                    $data['datadatebetween'] = $datadatebetween;

                return view('admin/smreportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
    
          $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
          $data["teamlead"] = $teamlead;
          $cnt = sizeof($teamlead);

          for($i=0;$i<$cnt;$i++){
            $totalsale =0;
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
            } 
            
             $salessizee[] = $totalsale;
             $data["salessize"] = $salessizee;
          }              
            
     		$data["link"]="secure/tlextreportdetails";
            $data["typ"] =1;
            $data["slctid"] = $id;
      
        return view('admin/smreportdetails',$data);
      
    }
  
  
  	public function tlextreportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  
                  $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);

                  $cnt1 = sizeof($data["salesagent"]);

                  for($j=0;$j<$cnt1;$j++){
                    $totalsale =0;
                    $salid = $data["salesagent"][$j]["salesagentId"];
                    $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                    $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                    $salescount = sizeof($data['customer']);
                    $totalsale = $totalsale + $salescount;

                    $salessizee[] = $totalsale;
                  } 


                   $data["salessize"] = $salessizee;  
                   $data["link"]="secure/saextreportdetails";
                   $data["typ"] =1;
                   $data["slctid"] = $id;
                   $datadatebetween[0] = $dtstrt;
                   $datadatebetween[1] = $endt;
                   $data['datadatebetween'] = $datadatebetween;

                return view('admin/tlreportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
      
            
            $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);

            $cnt1 = sizeof($data["salesagent"]);

            for($j=0;$j<$cnt1;$j++){
              $totalsale =0;
              $salid = $data["salesagent"][$j]["salesagentId"];
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
              $totalsale = $totalsale + $salescount;
              
              $salessizee[] = $totalsale;
            } 
            
             
             $data["salessize"] = $salessizee;  
      		 $data["link"]="secure/saextreportdetails";
      		 $data["typ"] =1;
      		 $data["slctid"] = $id;
     
        return view('admin/tlreportdetails',$data);
      
    }
  
  
  	public function saextreportdetails($id){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
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
                  
                  $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                  $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                  $data["slctid"] = $id;
                  $datadatebetween[0] = $dtstrt;
                  $datadatebetween[1] = $endt;
                  $data['datadatebetween'] = $datadatebetween;

                return view('admin/saextreportdetails',$data);
                  
                  
                }else{
                  $data['validations'] = $this->validator;
                }
            }
      
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
              $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
 			  $data["typ"] =1;
              $data["slctid"] = $id;
              
      
     
        return view('admin/saextreportdetails',$data);
      
    }
  
  
  //*---------------------------- Report Download ---------------------------------*//
  
  
  	public function customerdownload($type)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
                              <th colspan="4">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
									<th>Regd. Id</th>
                                    <th>Name</th>
                                    <th>Total Tag Activation</th>
                                  </tr>
                             </thead>
                                 <tbody>';
      							if($type == "new"){
      								$data["salesmanager"]=$this->loginModel->showSelectd();
      
                                    $smcount = sizeof($data["salesmanager"]);

                                    for($k=0;$k<$smcount;$k++){          
                                      $totalsale =0;
                                      $smid = $data["salesmanager"][$k]["salesManagerId"];      
                                      $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);

                                      for($i=0;$i<$cnt;$i++){
                                        $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                        $cnt1 = sizeof($data["salesagent"]);

                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                          $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        } 
                                      }      
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                    }
                                }else{
                                  
                                    $data["salesmanager"]=$this->loginModel->showSelectd();
                                    $smcount = sizeof($data["salesmanager"]);
                                    for($k=0;$k<$smcount;$k++){          
                                      $totalsale =0;
                                      $smid = $data["salesmanager"][$k]["salesManagerId"];      
                                      $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);
                                      for($i=0;$i<$cnt;$i++){
                                        $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);
                                        $cnt1 = sizeof($data["salesagent"]);
                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                          $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        } 
                                      }      
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                    }
                                  
                                }
      							
      
                                    $j=0;
                                    for($i=0;$i<$smcount;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['salesmanager'][$i]["RegdNum"].'</td>
                                                    <td>'.$data['salesmanager'][$i]["Fname"].' '.$data['salesmanager'][$i]["Lname"].'</td>
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
  
  
  		public function smdownload($type,$id)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
      							if($type == "new"){
      								$teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      } 

                                       $salessizee[] = $totalsale;
                                       $data["salessize"] = $salessizee;
                                    } 
                                }else{
                                  
                                    $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      } 

                                       $salessizee[] = $totalsale;
                                       $data["salessize"] = $salessizee;
                                    } 
                                  
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
  
  
        public function tldownload($type,$id)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
                              <th colspan="4">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
                                   <th>Regd. Id</th>
                                   <th>Name</th>
                                   <th>Total Tag Activation</th>
                               </tr>
                             </thead>
                                 <tbody>';
      							if($type == "new"){
      								$data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);
                                    $cnt1 = sizeof($data["salesagent"]);
                                    for($j=0;$j<$cnt1;$j++){
                                      $totalsale =0;
                                      $salid = $data["salesagent"][$j]["salesagentId"];
                                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                      $salescount = sizeof($data['customer']);
                                      $totalsale = $totalsale + $salescount;
                                      $salessizee[] = $totalsale;
                                    } 
                                     $data["salessize"] = $salessizee;
                                  
                                }else{
                                  
                                    $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);
                                    $cnt1 = sizeof($data["salesagent"]);
                                    for($j=0;$j<$cnt1;$j++){
                                      $totalsale =0;
                                      $salid = $data["salesagent"][$j]["salesagentId"];
                                      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0);
                                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                      $salescount = sizeof($data['customer']);
                                      $totalsale = $totalsale + $salescount;
                                      $salessizee[] = $totalsale;
                                    } 
                                     $data["salessize"] = $salessizee;  
                                  
                                }
      							
      
                                    $j=0;
                                    for($i=0;$i<$cnt1;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['salesagent'][$i]["salesAgentRegdNum"].'</td>
                                                    <td>'.$data['salesagent'][$i]["Fname"].' '.$data['salesagent'][$i]["Lname"].'</td>
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
  
  
  		public function sadownload($type,$id)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
      							if($type == "new"){                                  
      								$array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
                                    $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);                                  
                                }else{                                  
                                    $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0);
              						$data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);                                   
                                }
      							
      
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
  
  
  		public function sasrchdownload($type,$id,$fromdate,$tilldate)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
          						$endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                $rt = $fromdate.' 00:00:00';
                                $rte = $endt_ftr.' 00:00:00';
          
      							if($type == "new"){                                  
      								$array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                    $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);                                  
                                }else{                                  
                                    

                                    $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $id , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                    $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);                                  
                                }
      							
      
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
  
  
  		public function tlsrchdownload($type,$id,$fromdate,$tilldate)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
                              <th colspan="4">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
                                   <th>Regd. Id</th>
                                   <th>Name</th>
                                   <th>Total Tag Activation</th>
                               </tr>
                             </thead>
                                 <tbody>';
                                $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                $rt = $fromdate.' 00:00:00';
                                $rte = $endt_ftr.' 00:00:00';
          
      							if($type == "new"){
      								$data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);
                                    $cnt1 = sizeof($data["salesagent"]);
                                    for($j=0;$j<$cnt1;$j++){
                                      $totalsale =0;
                                      $salid = $data["salesagent"][$j]["salesagentId"];
                                      $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                      $salescount = sizeof($data['customer']);
                                      $totalsale = $totalsale + $salescount;
                                      $salessizee[] = $totalsale;
                                    } 
                                     $data["salessize"] = $salessizee;
                                  
                                }else{
                                  
                                    $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$id);
                                    $cnt1 = sizeof($data["salesagent"]);
                                    for($j=0;$j<$cnt1;$j++){
                                      $totalsale =0;
                                      $salid = $data["salesagent"][$j]["salesagentId"];
                                      $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                      $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                      $salescount = sizeof($data['customer']);
                                      $totalsale = $totalsale + $salescount;
                                      $salessizee[] = $totalsale;
                                    } 
                                     $data["salessize"] = $salessizee;  
                                  
                                }
      							
      
                                    $j=0;
                                    for($i=0;$i<$cnt1;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['salesagent'][$i]["salesAgentRegdNum"].'</td>
                                                    <td>'.$data['salesagent'][$i]["Fname"].' '.$data['salesagent'][$i]["Lname"].'</td>
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
  
  
  		public function smsrchdownload($type,$id,$fromdate,$tilldate)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
          
      							if($type == "new"){
      								$teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      } 

                                       $salessizee[] = $totalsale;
                                       $data["salessize"] = $salessizee;
                                    } 
                                }else{
                                  
                                    $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$id);  
                                    $data["teamlead"] = $teamlead;
                                    $cnt = sizeof($teamlead);

                                    for($i=0;$i<$cnt;$i++){
                                      $totalsale =0;
                                      $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                      $cnt1 = sizeof($data["salesagent"]);

                                      for($j=0;$j<$cnt1;$j++){
                                        $salid = $data["salesagent"][$j]["salesagentId"];
                                        $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                        $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                        $salescount = sizeof($data['customer']);
                                        $totalsale = $totalsale + $salescount;
                                      } 

                                       $salessizee[] = $totalsale;
                                       $data["salessize"] = $salessizee;
                                    } 
                                  
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
    
  
  		public function customersrchdownload($type,$fromdate,$tilldate)
        {
              if ((!isset($_SESSION['logged_usrid']))) {
                  return redirect()->to(base_url('adminLogin'));            
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
                              <th colspan="4">Tag Activation Report</th>
                             </tr>
                             <thead>
                                 <tr>
                                   <th>SL NO</th>
									<th>Regd. Id</th>
                                    <th>Name</th>
                                    <th>Total Tag Activation</th>
                                  </tr>
                             </thead>
                                 <tbody>';
                                $endt_ftr = date( 'Y-m-d', strtotime( $tilldate . ' +1 day' ) );
                                $rt = $fromdate.' 00:00:00';
                                $rte = $endt_ftr.' 00:00:00';
          
      							if($type == "new"){
      								$data["salesmanager"]=$this->loginModel->showSelectd();
      
                                    $smcount = sizeof($data["salesmanager"]);

                                    for($k=0;$k<$smcount;$k++){          
                                      $totalsale =0;
                                      $smid = $data["salesmanager"][$k]["salesManagerId"];      
                                      $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);

                                      for($i=0;$i<$cnt;$i++){
                                        $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);

                                        $cnt1 = sizeof($data["salesagent"]);

                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                          $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        } 
                                      }      
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                    }
                                }else{
                                  
                                    $data["salesmanager"]=$this->loginModel->showSelectd();
                                    $smcount = sizeof($data["salesmanager"]);
                                    for($k=0;$k<$smcount;$k++){          
                                      $totalsale =0;
                                      $smid = $data["salesmanager"][$k]["salesManagerId"];      
                                      $teamlead = $this->salesagentModel->viewspecific('teamlead','*','requestedById',$smid);  
                                      $data["teamlead"] = $teamlead;
                                      $cnt = sizeof($teamlead);
                                      for($i=0;$i<$cnt;$i++){
                                        $data["salesagent"] = $this->salesagentModel->viewspecific('salesagent','*','requestedById',$teamlead[$i]['teamleadId']);
                                        $cnt1 = sizeof($data["salesagent"]);
                                        for($j=0;$j<$cnt1;$j++){
                                          $salid = $data["salesagent"][$j]["salesagentId"];
                                          $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
                                          $data['customer'] = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
                                          $salescount = sizeof($data['customer']);
                                          $totalsale = $totalsale + $salescount;
                                        } 
                                      }      
                                          $salessizee[] = $totalsale;
                                          $data["salessize"] = $salessizee;
                                    }
                                  
                                }
      							
      
                                    $j=0;
                                    for($i=0;$i<$smcount;$i++){ 
                                      $j++;

                                         $html.='<tr nobr="true">
                                                    <td>'.$j.'</td>
                                                    <td>'.$data['salesmanager'][$i]["RegdNum"].'</td>
                                                    <td>'.$data['salesmanager'][$i]["Fname"].' '.$data['salesmanager'][$i]["Lname"].'</td>
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