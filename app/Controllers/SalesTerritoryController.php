<?php

namespace App\Controllers;
use \App\Models\LoginModel;

class SalesTerritoryController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('email');
        $this->loginModel = new loginModel();
        $this->session = session();
    
        
    }
    public function salesterritory()
    {

        if ((!isset($_SESSION['logged_usrid']))) {
           return redirect()->to(base_url('adminLogin'));            
      }
      $dtm = date("Y-m-d h:i:s");
        
        
        if($this->request->getVar('type')){
              
              $type = $this->request->getVar('type');
              
              if($type == "city"){
                  $response='<input type="text" id="ccity" name="ccity" class="form-control mr-2" placeholder="City">';
                  $response.='<input type="text" id="cdistrict" name="cdistrict" class="form-control mr-2" placeholder="District">';
                  $response.='<input type="submit" value="Add Territories" class="btn btn-info">';
              }else{
                  $response='<input type="text" class="form-control mr-2" name="tplazacode" id="tplazacode" placeholder="Enter Plaza Code">';
                  $response.='
                    <select name="ttype" id="ttype" class="form-control mr-2">
                         <option value="">Select Type</option>
                         <option value="Conc">Conc</option>
                         <option value="PF">PF</option>
                         <option value="DBFOT">DBFOT</option>
                         <option value="BOT">BOT</option>
                    </select>
                  ';//<input type="text" class="form-control mr-2" placeholder="Enter Type">
                  $response.='
                    <select name="tplazatype" id="tplazatype" class="form-control mr-2">
                         <option value="">Select Plaza Type</option>
                         <option value="National">National</option>
                         <option value="State">State</option>
                         <option value="MoRTH">MoRTH</option>
                    </select>
                  ';//<input type="text" class="form-control mr-2" placeholder="Enter Plaza Type">
                  $response.='<input type="text" name="tplazacity" id="tplazacity"  class="form-control mr-2" placeholder="Enter Plaza City">';
                 // $response.='<input type="text" class="form-control mr-2" placeholder="Enter Plaza State">';
                  $response.='<input type="text" name="tconcess" id="tconcess"  class="form-control mr-2" placeholder="Enter Concessionaire">';
                  $response.='<input type="text" name="tplazaname" id="tplazaname"  class="form-control mr-2" placeholder="Enter Plaza Name">';
                  //$response.='<input type="file" name="file" title="Upload CSV File" class="form-control mt-2 mr-2" style="max-width:20%;">';
                  $response.='<input type="submit" value="Add Territories" class="btn btn-info mt-2">';
              }
              
              
              echo $response;
              exit;
              
        }
        
        if($this->request->getVar('ccity')){
            
            $state = $this->request->getVar('state');
            $cityortoll = $this->request->getVar('cityortoll');
            $ccity = $this->request->getVar('ccity');
            $cdistrict = $this->request->getVar('cdistrict');
          
            $data = ["tollorcity" =>0, "plazacode" =>'', "type" =>'', "plazatype" =>'', "plazacity" =>$ccity, "plazastate" =>$state, "plazadistrict" =>$cdistrict, "concessionaire" =>'', "plazaname" =>'', "status" =>0, "datetime" =>$dtm];
            $loginData = $this->loginModel->loginDatainsert('tollplaza',$data);
            
            if($loginData){
                $this->session->setTempdata('success','City Added Successfully', 3);
                return redirect()->to(current_url());
            }else{
                $this->session->setTempdata('error','Sorry Unable To Add City', 3);
                return redirect()->to(current_url());
            }
            
            exit;
        }
        
        
        if($this->request->getVar('tplazacode')){
            
            $state = $this->request->getVar('state');
            $cityortoll = $this->request->getVar('cityortoll');
            
            $tplazacode = $this->request->getVar("tplazacode");
            $ttype = $this->request->getVar("ttype");
            $tplazatype = $this->request->getVar("tplazatype");
            $tplazacity = $this->request->getVar("tplazacity");
            $tconcess = $this->request->getVar("tconcess");
            $tplazaname = $this->request->getVar("tplazaname");
            
            $data = ["tollorcity" =>1, "plazacode" =>$tplazacode, "type" =>$ttype, "plazatype" =>$tplazatype, "plazacity" =>$tplazacity, "plazastate" =>$state, "plazadistrict" =>'', "concessionaire" =>$tconcess, "plazaname" =>$tplazaname, "status" =>0, "datetime" =>$dtm];
            $loginData = $this->loginModel->loginDatainsert('tollplaza',$data);
            
            if($loginData){
                $this->session->setTempdata('success','Toll Added Successfully', 3);
                return redirect()->to(current_url());
            }else{
                $this->session->setTempdata('error','Sorry Unable To Add Toll', 3);
                return redirect()->to(current_url());
            }
            
            exit;
        }
        
        
    	return view('admin/salesterritory');
    }
    
    public function uploadCSV() {
        if ((!isset($_SESSION['logged_usrid']))) {
           return redirect()->to(base_url('adminLogin'));            
        }
        
        
        // echo "we are working";
        return view('admin/salesterritory');
    }
    
    public function managesalesterritory () {
        if ((!isset($_SESSION['logged_usrid']))) {
           return redirect()->to(base_url('adminLogin'));            
        }
        
        return view('admin/managesalesterritory');
    }




}//controller end
  
  
  
  
  
  