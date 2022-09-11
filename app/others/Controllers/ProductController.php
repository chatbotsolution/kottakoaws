<?php

namespace App\Controllers;
use \App\Models\ProductModel;

class ProductController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new ProductModel();
        $this->session = session();
        
    }

    public function index()
    {
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        $data=[];
        $rules = [
            "prdclass"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Product CLass Is required ',
                ],
            ],
            "price"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Price Is required ',
                ],
            ],
            "initialamt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Initial Amount Is required ',
                ],
            ],
            "prdcode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Product Code Is required ',
                ],
            ],            
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $prdclass = $this->request->getVar('prdclass');
                $price = $this->request->getVar('price');
                $initialamt = $this->request->getVar('initialamt');   
                $prdcode = $this->request->getVar('prdcode');                        
                            
                $dtm = date("Y-m-d h:i:s");
                
                $data = ["fastagClass"=>$prdclass, "fastagprice"=>$price, "initialPayment"=>$initialamt, "prodctCode"=>$prdcode, "status"=>0, "datetime"=>$dtm];

                $loginData = $this->loginModel->loginDatainsert('product',$data);

                if($loginData){
                    $this->session->setTempdata('success','Product Added Successfully', 3);
                    return redirect()->to(base_url('secure/addProduct'));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                    return redirect()->to(base_url('secure/addProduct'));
                }     
            }else{
                $data['validations'] = $this->validator;
            }
        }

            $data["claassftag"]=$this->loginModel->distinctVal('fasttag','classoftag');
            
            return view('admin/addProduct',$data);
    }

    public function manageproduct(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $data=[];
        $data["productdata"]=$this->loginModel->findAll();
        
        
        return view('admin/manageproduct',$data);
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="product";
        $upclnm="productid";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Product Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/manageProduct')); 

            $data["productdata"]=$this->loginModel->findAll();
        
        return view('admin/manageproduct',$data);
    }
}

?>