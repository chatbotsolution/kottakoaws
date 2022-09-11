<?php

namespace App\Controllers;
use \App\Models\LoginModel;

class AdminDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        $this->loginModel = new loginModel();
        $this->session = session();
        
    }
    public function index()
    {

        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        } else {

        $data= [];
    
    
        return view('admin/dashboard',$data);
        }    
    }

    public function addpayment($id)
    {

        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        } else {

        $data= [];
        
            $rules = [
                "payamount"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Payment Amount Is Required',
                    ],
                ],
                "referencenum"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Refrence Number Is Required',
                    ],
                ],
                "modeofpay"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Mode Of Payment Is Required',
                    ],
                ],
                "dateofpay"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Date Of Payment Is Required',
                    ],
                ],
                "qntyordr"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Quantity Ordered Is Required',
                    ],
                ],
                "fastagprd"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Fastag Product  Is Required',
                    ],
                ],
            ];

            if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                   
                    $oemid = $this->request->getVar('oemid');
                    $payamount = $this->request->getVar('payamount');
                    $referencenum = $this->request->getVar('referencenum');
                    $modeofpay = $this->request->getVar('modeofpay');
                    $dateofpay = $this->request->getVar('dateofpay');
                    $qntyordr = $this->request->getVar('qntyordr');
                    $fastagprd = $this->request->getVar('fastagprd');

                        $dtm = date("Y-m-d h:i:s");
                        $datte = date("Y-m-d", strtotime($dateofpay));
                        
                        $data = ["paymentamount"=>$payamount,"refrencenumber"=>$referencenum,"modeofpayment"=>$modeofpay,"dateofpayment"=>$dateofpay,"quantityordered"=>$qntyordr,"fastagproduct"=>$fastagprd,"oemid"=>$oemid,"datetime"=>$dtm];
                        
                        $loginData = $this->loginModel->loginDatainsert('oempayments',$data);
                        

                        if($loginData){
                            $this->session->setTempdata('success','Payment Added Successfully', 3);
                            return redirect()->to(current_url());
                        }else{
                            $this->session->setTempdata('error','Sorry Unable To Add Payment', 3);
                            return redirect()->to(current_url());
                        }
                        return redirect()->to(base_url().'/secure/addpayment/'.$oemid);

                                
        
        
                }else{
                    $data['validations'] = $this->validator;
                }
            }
            $data['paymentfor'] = $this->loginModel->searchh('oem','*','oemid',$id);

            return view('admin/addpayment',$data);
        }
    }
}

?>