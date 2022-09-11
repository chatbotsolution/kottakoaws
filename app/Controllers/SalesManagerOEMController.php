<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;

class SalesManagerOEMController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new SalesManagerModel();
        $this->session = session();
        
    }

    public function index()
    {
        if ((!isset($_SESSION['salesmanagerId']))) {

            return redirect()->to(base_url('salesmanagerLogin'));
            
        }
        $data=[];
        $rules = [
            "compnyname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Company Name Is required ',
                ],
            ],
            "tradename"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Trade Name Is required ',
                ],
            ],
            "gstnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'GST Number Is required ',
                ],
            ],
            "pancardnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Card Number Is required ',
                ],
            ],
            "spocnumber"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Number Is required ',
                ],
            ],
            "spocdetails"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Details Is required ',
                ],
            ],
            "gmcontact"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'GM Contact Is required ',
                ],
            ],
            "gmname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'GM Name Is required ',
                ],
            ],
            "hodcity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Head Office City Is required ',
                ],
            ],
            "noofbranch"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Branches Is required ',
                ],
            ],
            "manufacturer"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Manufacturer Is required ',
                ],
            ],
            "spoceml"=>[
                  'rules'=>'required|valid_email',
                  'errors'=>[
                      'required'=>'SPOC Email Id Is required ',
                  ],
              ],
            "gmeml"=>[
                  'rules'=>'required|valid_email',
                  'errors'=>[
                      'required'=>'GM Email Id Is required ',
                  ],
              ],
            "gstcertificate"=>'uploaded[gstcertificate]|max_size[gstcertificate,1024]|ext_in[gstcertificate,jpg,jpeg,JPEG,JPG,pdf,PDF]',
            
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $compnyname = $this->request->getVar('compnyname');
                $tradename = $this->request->getVar('tradename');
                $gstnum = $this->request->getVar('gstnum');   
                $pancardnum = $this->request->getVar('pancardnum');
                $spocnumber = $this->request->getVar('spocnumber');
                $spocdetails = $this->request->getVar('spocdetails'); 
                $gmcontact = $this->request->getVar('gmcontact'); 
                $brandLogo = $this->request->getFile('gstcertificate'); 
                $manufacturer = $this->request->getVar('manufacturer');
                $noofbranch = $this->request->getVar('noofbranch');
                $hodcity = $this->request->getVar('hodcity');
                $gmname = $this->request->getVar('gmname'); 
              
              	$spoceml = $this->request->getVar('spoceml');
                $gmeml = $this->request->getVar('gmeml');

                    if($brandLogo->isValid() && !$brandLogo->hasMoved()){
                        $newbrandLogo = $brandLogo->getRandomName();
                        if($brandLogo->move(FCPATH.'public/adminasset/oemdocument/',$newbrandLogo)){                           
                            
                                $dtm = date("Y-m-d h:i:s");
                                
                                $data = ["companyname"=>$compnyname,"manufacturer"=>$manufacturer,"noofbranch"=>$noofbranch,"hodcity"=>$hodcity,"tradename"=>$tradename,"gstnumber"=>$gstnum,"pancardnumber"=>$pancardnum,"spocnumber"=>$spocnumber,"spocdetails"=>$spocdetails,"gmcontact"=>$gmcontact,"gmname"=>$gmname,"gstcertificate"=>$newbrandLogo,"status"=>'2',"datetime"=>$dtm,"requestbyid"=>$_SESSION['salesmanagerId'],"gmemail"=>$gmeml,"spocemail"=>$spoceml];

                                $loginData = $this->loginModel->loginDatainsert('oem',$data);

                                if($loginData){
                                    $this->session->setTempdata('success','Request Send Successfully', 3);
                                    return redirect()->to(base_url('salesmanager/requestoem'));
                                }else{
                                    $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                                    return redirect()->to(base_url('salesmanager/requestoem'));
                                }     
                        }
                    }else{
                            echo $brandLogo->getErrorString()."".$brandLogo->getError();
                    }
            }else{
                $data['validations'] = $this->validator;
            }
        }

        $table1="manufacturer";
        $viewdata1="manufactureid ,manufacturername,status";
        $whrclm1="status";
        $whrval1=0;
        $data["manufacturer"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);
            return view('salesmanager/requestoem',$data);
    }

    public function viewoem(){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanagerLogin'));            
        }
        $data=[];

        $table="oem";
        $viewdata="companyname,tradename,gstnumber,status,oemid";
        $whrclm="requestbyid";
        $whrval=$_SESSION['salesmanagerId'];
        $data["oemrequest"]=$this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
              
        return view('salesmanager/viewrequestedoem',$data);
    }

    public function viewoemid($viewid){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanagerLogin'));            
        }
        $data=[];

        $vidd = json_decode(base64_decode($viewid));

        $table="oem";
        $viewdata="companyname,tradename,gstnumber,pancardnumber,spocnumber,spocdetails,gmcontact,gstcertificate,status,datetime,oemid";
        $whrclm="oemid";
        $whrval=$vidd;
        $data["oemrequest"]=$this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
        if($data["oemrequest"] == false){
            $this->session->setTempdata('error','Invalid User', 3);
            return redirect()->to(base_url('salesmanager/viewrequestedoem'));  
        }

        return view('salesmanager/viewrequestedoemdetails',$data);
    }
}

?>