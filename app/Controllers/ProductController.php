<?php

namespace App\Controllers;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;

class ProductController extends BaseController
{
    public $loginModel;
    public $salesagent;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new ProductModel();
        $this->salesagent = new SalesAgentModel();
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
          
          
            "minamount"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Minimum Amount Is required ',
                ],
            ],
            "depositamnt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Deposit Amount Is required ',
                ],
            ],
            "cardcost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Card Cost Is required ',
                ],
            ],
            "totalcost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Total Cost Is required ',
                ],
            ],
            "cbscost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'CBS Cost Is required ',
                ],
            ],
            "clsvehcl"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Class Of Vehicle Is required ',
                ],
            ],
        ];


        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $prdclass = $this->request->getVar('prdclass');
                $price = $this->request->getVar('price');
                $initialamt = $this->request->getVar('initialamt');   
                $prdcode = $this->request->getVar('prdcode'); 
                $minamount = $this->request->getVar('minamount');
                $depositamnt = $this->request->getVar('depositamnt');
                $cardcost = $this->request->getVar('cardcost');
                $totalcost = $this->request->getVar('totalcost');
                $cbscost = $this->request->getVar('cbscost');
                $clsvehcl = $this->request->getVar('clsvehcl');
                            
                $dtm = date("Y-m-d h:i:s");
                
                $data = ["fastagClass"=>$prdclass,"classofvehicle"=>$clsvehcl, "fastagprice"=>$price, "initialPayment"=>$initialamt, "prodctCode"=>$prdcode,"minamount"=>$minamount,"depositamnt"=>$depositamnt,"cardcost"=>$cardcost,"totalcost"=>$totalcost,"cbscost"=>$cbscost, "status"=>0, "datetime"=>$dtm];

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
            $data["classofvehicle"]=$this->loginModel->distinctVal('classofbarcode','classofbarcode');
            
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
  
  
    public function editproduct($id){
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
          
          
            "minamount"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Minimum Amount Is required ',
                ],
            ],
            "depositamnt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Deposit Amount Is required ',
                ],
            ],
            "cardcost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Card Cost Is required ',
                ],
            ],
            "totalcost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Total Cost Is required ',
                ],
            ],
            "cbscost"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'CBS Cost Is required ',
                ],
            ],
            "clsvehcl"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Class Of Vehicle Is required ',
                ],
            ],
        ];
      
      
      
      	if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $prdclass = $this->request->getVar('prdclass');
                $price = $this->request->getVar('price');
                $initialamt = $this->request->getVar('initialamt');   
                $prdcode = $this->request->getVar('prdcode'); 
                $minamount = $this->request->getVar('minamount');
                $depositamnt = $this->request->getVar('depositamnt');
                $cardcost = $this->request->getVar('cardcost');
                $totalcost = $this->request->getVar('totalcost');
                $cbscost = $this->request->getVar('cbscost');
                $clsvehcl = $this->request->getVar('clsvehcl');
                            
                $dtm = date("Y-m-d h:i:s");
              
              	$tablee="product";
                $upclnm="productid";
                $updtid=$id;
                $updtdata = ["fastagClass"=>$prdclass,"classofvehicle"=>$clsvehcl, "fastagprice"=>$price, "initialPayment"=>$initialamt, "prodctCode"=>$prdcode,"minamount"=>$minamount,"depositamnt"=>$depositamnt,"cardcost"=>$cardcost,"totalcost"=>$totalcost,"cbscost"=>$cbscost, "status"=>0, "datetime"=>$dtm];
                $nomineedtta = $this->salesagent->entry_update($tablee,$upclnm,$updtdata,$updtid);

                if($nomineedtta){
                    $this->session->setTempdata('success','Product Update Successfully', 3);
                    return redirect()->to(base_url('secure/editproduct/'.$id));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Update Try Again Later', 3);
                    return redirect()->to(base_url('secure/editproduct/'.$id));
                }     
            }else{
                $data['validations'] = $this->validator;
            }
        }
      
      
      $data["claassftag"]=$this->loginModel->distinctVal('fasttag','classoftag');
      $data['productdata'] = $this->salesagent->viewspecific('product','*','productid',$id);
      $data["classofvehicle"]=$this->loginModel->distinctVal('classofbarcode','classofbarcode');
      
      return view('admin/editproduct',$data);
      
    }
}

?>