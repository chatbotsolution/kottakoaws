<?php

namespace App\Controllers;
use \App\Models\SalesAgentWalletModel;
use \App\Models\OemModel;
use \App\Models\SalesManagerModel;
use \App\Models\ProductModel;

class SalesAgentDashboardController extends BaseController
{
    public $loginModel;
    public $walletModel;
    public $oemModel;
    public $productmodel;

    public function __construct(){  
      helper("form");
        helper('text');
        helper('fastag');
        $this->session = session(); 
        $this->walletModel = new SalesAgentWalletModel();  
        $this->oemModel = new OemModel();
        $this->loginModel = new SalesManagerModel();
        $this->productmodel = new ProductModel();
    }
    public function index()
    {

        if ((!isset($_SESSION['salesagentId']))) {

            return redirect()->to(base_url('salesagentLogin'));
            
        } else {
          
          
           // $this->session->set('customerverified',1);

        $data= [];
    
        $data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
        $data["banner"] = $this->loginModel->viewspecific('salesagentBanner','*','status',0);
          
        return view('salesagent/dashboard',$data);
       }
    }
  
  
  
  	public function requestfastag()
    {
        if ((!isset($_SESSION['salesagentId']))) {

            return redirect()->to(base_url('salesagentLogin'));
            
        }
        $data=[];
        $rules = [
            "prdclass"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Fastag Class Is required ',
                ],
            ],
            "nofatag"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Fastag Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $prdclass = $this->request->getVar('prdclass');
                $nofatag = $this->request->getVar('nofatag');                           
                            
                $dtm = date("Y-m-d h:i:s");
              	
              	$salsagentdata = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
              
                
                $data = ["numberoffastag"=>$nofatag,"classoftag"=>$prdclass,"requestedbyid"=>$_SESSION["salesagentId"],"status"=>0,"datetime"=>$dtm,"requestedbytype"=>1,"requestedtoid"=>$salsagentdata[0]["requestedById"]];

                $loginData = $this->loginModel->loginDatainsert('fastagrequest',$data);

                if($loginData){
                    $this->session->setTempdata('success','Fastag Request Send Successfully', 3);
                    return redirect()->to(base_url('salesagent/requestfastag'));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Send Try Again Later', 3);
                    return redirect()->to(base_url('salesagent/requestfastag'));
                } 
            }else{
                $data['validations'] = $this->validator;
            }
        }
      
        $data["claassftag"]=$this->productmodel->distinctVal('fasttag','classoftag');
        $data["oemreqst"]=$this->oemModel->multiSrch('fastagrequest','*','requestedbytype',1,'requestedbyid',$_SESSION['salesagentId']);

            return view('salesagent/requestfastag',$data);
    }
  
  
  public function fsebanner(){
    
    $data=[];
    
    $rules = [
            "bnrname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Banner Name Is required ',
                ],
            ],
            'bannerimage' => [
                'label' => 'Banner Image',
                'rules' => 'uploaded[bannerimage]'
                    . '|ext_in[bannerimage,png,gif,jpg,jpeg,PNG,JPEG,JPG]'
                    . '|max_size[bannerimage,10024]',
            ],
        ];

        if($this->request->getMethod() == "post"){
          
            if($this->request->getVar('blockid')){
                $blockid = $this->request->getVar('blockid');
              
                $table="salesagentBanner";
                $upclnm="bannerid";
                $updtdata = [
                    'status'=>$this->request->getVar('blockval'),
                ];
                $updtid=$blockid;
                $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                exit;
            }
          
          
          
            if($this->validate($rules)){
                $bnrname = $this->request->getVar('bnrname');
                $bannerimage = $this->request->getFile('bannerimage');                           
                            
                $dtm = date("Y-m-d h:i:s");
              	
              	if($this->request->getFile('bannerimage')){
                    if($bannerimage->isValid() && !$bannerimage->hasMoved()){
                        $newbannerimage = $bannerimage->getRandomName();
                        if($bannerimage->move(FCPATH.'public/banner/',$newbannerimage)){                           
                                $bannerimg = base_url().'/public/banner/'.$newbannerimage;
                        }
                    }else{
                                $bannerimage->getErrorString()."".$bannerimage->getError();
                    }
                }
              
               
                $data = ["bannerimage"=>$bannerimg, "bannername"=>$bnrname, "status"=>0, "datetime"=>$dtm];

                $loginData = $this->loginModel->loginDatainsert('salesagentBanner',$data);

                if($loginData){
                    $this->session->setTempdata('success','Banner Added Successfully', 3);
                    return redirect()->to(base_url('secure/fsebanner'));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Add Banner Try Again Later', 3);
                    return redirect()->to(base_url('secure/fsebanner'));
                } 
            }else{
                $data['validations'] = $this->validator;
            }
        }
    
    $data["banner"] = $this->loginModel->viewspecific('salesagentBanner','*','status !=',3);
    return view('admin/fsebanner',$data);
  }
  
  
  
}

?>