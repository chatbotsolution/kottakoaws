<?php

namespace App\Controllers;
use \App\Models\OemModel;

class OEMVehicleNoUpdateController extends BaseController
{
    public $loginModel;


    public function __construct(){ 
      helper("form");
        $this->loginModel = new OemModel();  
        $this->session = session();        
    }
    public function index()
    {    
      
          if ((!isset($_SESSION['oemid']))) {

              return redirect()->to(base_url('oemLogin'));

          } else {

          $data= [];
          $rules = [
            "chassisnumber"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Chassis Number Is required ',
              ],
            ],
            "rcbook"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle RC Is required ',
              ],
            ],
            "contactnum"=>[
              'rules'=>'required|numeric|max_length[10]|min_length[10]',
              'errors'=>[
                'required'=>'Contact Number Is required ',
              ],
            ],
            "rcupload"=>'uploaded[rcupload]|max_size[rcupload,1024]|ext_in[rcupload,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
          ];
            
            $dtm=date("Y-m-d h:i:s");
            
          if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
              $chassisnumber = $this->request->getVar('chassisnumber');
              $rcbook = $this->request->getVar('rcbook');
              $contactnum = $this->request->getVar('contactnum');
              
              $rcupload = $this->request->getFile('rcupload');
              
              if($rcupload->isValid() && !$rcupload->hasMoved()){
                $newrcupload = $rcupload->getRandomName();
                if($rcupload->move(FCPATH.'public/drivinglicence',$newrcupload)){     
                  $rcuploadata = base_url().'/public/drivinglicence/'.$newrcupload;                           
                }
              }else{
                $this->session->setTempdata('error','Unable To Process Request', 3);
                return redirect()->to(base_url('oem/vehiclenoupdate'));
              }
              
              
              $datainsrt = ["chassisnumber"=>$chassisnumber, "vehiclerc"=>$rcbook, "vehicleuploadrc"=>$rcuploadata,"contactnumber"=>$contactnum, "agentid"=>$_SESSION['oemid'], "agenttype"=>4, "datetime"=>$dtm, "status"=>2];                
              $loginData = $this->loginModel->loginDatainsert('vehiclenumberupdate',$datainsrt);
              
              $this->session->setTempdata('success','Vehicle Number Update Request Send Successfully', 3);
              return redirect()->to(base_url('oem/vehiclenoupdate'));

            }else{
              $data['validations'] = $this->validator;
            }
          }


          return view('oem/vehiclenoupdate',$data);
      }
	}
  
  
    public function viewdata(){
        if ((!isset($_SESSION['oemid']))) {
            return redirect()->to(base_url('oemLogin'));
       }
      
       $data=[];
       $data["fastag"] = $this->loginModel->multiSrch('vehiclenumberupdate','*','agentid',$_SESSION['oemid'],'agenttype',4);
       return view('oem/vehiclenoupdateview',$data);
    }
  
    public function viewupdtata(){
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));
       }
      
       $data=[];
      
      if($this->request->getMethod() == "post"){
        if($this->request->getVar('updtid')){

          $updtval = $this->request->getVar('updtval');
          $updtid = $this->request->getVar('updtid');
          
          $table ='vehiclenumberupdate';
          $upclnm ='vehicleupdateid';
          $updtdata = [
            'status'=>$updtval,
          ];
          $updtid = $updtid;
          $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid); 
          
          $response='    
            <div class="alert alert-success alert-dismissible fade show">Data Updated Successfully
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            ';

          echo $response;
          exit;

        }
      }

       $data["fastag"] = $this->loginModel->viewspecific('vehiclenumberupdate','*','status',2);
       return view('admin/vehicleupdatereqst',$data);
    }
  
}

?>