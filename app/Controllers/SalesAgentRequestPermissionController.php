<?php

namespace App\Controllers;
use \App\Models\SalesAgentWalletModel;
use \App\Models\OemModel;
use \App\Models\SalesManagerModel;
use \App\Models\ProductModel;

class SalesAgentRequestPermissionController extends BaseController
{
  
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
  
  
  public function requestpermission()
  {
     
        if ((!isset($_SESSION['salesagentId']))) {

            return redirect()->to(base_url('salesagentLogin'));
            
        }else {
          
          
           

        $data = [];
          
    $rules = [
            "bankname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bank Name Is required ',
                ],
            ],
            "personname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Person Name Is required ',
                ],
            ],
            "fathername"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Fathers Name Is required ',
                ],
            ],
            "phoneno"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Phone Number Is required ',
                ],
            ], 
            "email"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Email Id Is required ',
                ],
            ],  
            "adhaar"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Adhaar Is required ',
                ],
            ],
            "panno"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN card number Is required ',
                ],
            ],  
            "address"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Address Is required ',
                ],
            ],
           "tollplazaname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'TollPlaza name Is required ',
                ],
            ],
        ];
    	  
       	 return view('salesagent/requestpermission', $data);
        //return view('salesagent/requestpermission',$data);
       }
    //return view('salesagent/requestpermission');
  }
  
 
}

?>