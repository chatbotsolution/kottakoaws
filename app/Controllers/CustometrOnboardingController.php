<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;
use \App\Models\TeamLeadModel;
use \App\Models\SalesAgentWalletModel;

class CustometrOnboardingController extends BaseController
{
    public $loginModel;
    public $teamleadmodel;
    public $productmodel;
    public $oemModel;
    public $walletModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');      
        helper('payment');
        $this->loginModel = new SalesAgentModel();
        $this->teamleadmodel = new TeamLeadModel();
        $this->productmodel = new ProductModel();
        $this->oemModel = new OemModel(); 
        $this->walletModel = new SalesAgentWalletModel();   
        $this->session = session();
        
    }
  
  
    public function customeronboarding(){
      
      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }
      
      
      $data= [];
      
      $rules = [
              "contactnumber"=>[
                'rules'=>'required|numeric|max_length[10]|min_length[10]',
                'errors'=>[
                  'required'=>'Contact Number Is required ',
                ],
              ],
              "fastagbank"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Fastag Bank Is required ',
                ],
              ],
              "barcode"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Barcode Is required ',
                ],
              ],
              "vehicledatatype"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Vehicle Data Type Is required ',
                ],
              ],
              "vehclnum"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Vehicle Number / Chassis Number Is required ',
                ],
              ],
            ];
        
      
      if($this->request->getMethod() == "post"){
        
        
        if($this->request->getVar('bankname')){
           $bankname = $this->request->getVar('bankname');
           $fastag = $this->loginModel->showfastagbank($_SESSION['salesagentId'],3,$bankname);
           $response="<option value=''> SELECT BARCODE </option>";
             foreach($fastag as $fastag){
               $response.="<option value='".$fastag["barcode"]."'> ".$fastag["barcode"]." </option>";
             }
          
          echo $response;
          exit;
        }
        
        
        
        
        
        if($this->request->getVar('cancl')){
            
           session()->remove('tagActivationId');
           session()->remove('showUserform');
           
           return redirect()->to(base_url('salesagent/customeronboarding'));
        }
        
        
        if($this->request->getVar('productid')){
           $productid = $this->request->getVar('productid');
           $classofbarcode = $this->loginModel->getClassofbarcode($productid);
           $response="<option value=''> SELECT CLASS OF BARCODE </option>";
             foreach($classofbarcode as $classofbarcode){
               $response.="<option value='".$classofbarcode["classofbarcode"]."'> ".$classofbarcode["toshowinapplication"]." </option>";
             }
          
          echo $response;
          exit;
        }        
          
        if($this->request->getVar('classofbarcodesearch')){
           $classofbarcode = $this->request->getVar('classofbarcodesearch');
           $vehicletype = $this->loginModel->getClassofbarcodespecific($classofbarcode);
           $response="<option value=''> SELECT VEHICLE TYPE </option>";
             foreach($vehicletype as $vehicletype){
               $response.="<option value='".$vehicletype["typeofvehicle"]."'> ".$vehicletype["typeofvehicle"]." </option>";
             }
          
          echo $response;
          exit;
        }
        
        
        if($this->validate($rules)){
          
          session()->remove('tagActivationId');
          session()->remove('showUserform');
          
          $contactnumber = $this->request->getVar("contactnumber");
          $fastagbank = $this->request->getVar("fastagbank");
          $barcode = $this->request->getVar("barcode");
          $vehicledatatype = $this->request->getVar("vehicledatatype");
          $vehclnum = strtoupper($this->request->getVar("vehclnum"));
          $dtm = date("Y-m-d h:i:s");
          $reqid= time();
          
          
          $insertdata = ["productid"=>"","classofBarcode"=>"","vehicleType"=>"","customername"=>'',"mobileNumber"=>$contactnumber,"pancarddetails"=>'',"drivingLicence"=>'',"rcbook"=>'',"vehicleNumbertype"=>$vehicledatatype,"vehiclechasisnumber"=>$vehclnum,"salesagentId"=>$_SESSION["salesagentId"],"salesagenttype"=>0,"orgreqid"=>'',"crnnumber"=>'',"tokennumber"=>'',"customerid"=>'',"dateofbirth"=>'',"agenttype"=>'',"barcodeid"=>$barcode,"transactionstatus"=>1,"transactionid"=>'',"datetime"=>$dtm];
                
          $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$insertdata);
          $lastinsertid = $this->loginModel->db->insertID(); 
          
          $npceidata = npcei($vehclnum);
          $npceiedata = json_decode($npceidata)[0];
          $npceiarray = json_decode(json_encode($npceiedata), true);
          
         // echo"<pre>";
        //  print_r($npceidata);
        //  exit;
          
              
          if($npceiarray['RESPONSECODE'] == 00 AND $npceiarray['STATUS'] == "Success"){
             if($npceiarray["NPCIVehicleDetails"][0]["BANKID"] == 607469){
                // Already registered message
                $this->session->setTempdata('error','Vehicle Already Registered', 3);
                return redirect()->to(base_url('salesagent/customeronboarding'));
             }else{
               
               /*-------------------------VERIFY OTP END-----------------------------*/
               
               $data['customerverfctn'] = VerifyCustomer($vehclnum); 
               $customervrfy = json_decode($data['customerverfctn'])[0];
               $customervrfyarray = json_decode(json_encode($customervrfy), true);
               
               if($customervrfyarray["RESPONSECODE"] == 01){
                 // Will go to New User
                 $getotp = GenerateOTP($contactnumber,$reqid);
                 $getotpdata = json_decode($getotp)[0];
                 $getotparray = json_decode(json_encode($getotpdata), true);

                  if($getotparray['RESPONSECODE'] == 02){

                    // Will go to existing User
                     $this->session->set('tagActivationId',$lastinsertid);
                    // $this->session->setTempdata('error','Vehicle Already Registered', 3);
                     return redirect()->to(base_url('salesagent/existingcustomeronboarding'));

                  }else if($getotparray['RESPONSECODE'] == 00){

                    // Will go to New User
                      $table ='tagactivationinitial';
                      $upclnm ='initialId';
                      $updtdata = [
                        'orgreqid'=>$getotparray['ORGREQID'],
                      ];
                      $updtid = $lastinsertid;
                      $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                      $this->session->set('tagActivationId',$lastinsertid);

                      $this->session->setTempdata('success','OTP Send Successfully. OTP Valid for 3 Min', 3);
                      return redirect()->to(base_url('salesagent/newcustomeronboarding'));

                  }else if($getotparray['RESPONSECODE'] == 01){

                     // Failure
                      $this->session->setTempdata('error',$getotparray['STATUS'], 3);
                      return redirect()->to(base_url('salesagent/customeronboarding'));
                  }
               }else if($customervrfyarray["RESPONSECODE"] == 00){
                 
                 $this->session->set('tagActivationId',$lastinsertid);
                 //$this->session->setTempdata('error','Vehicle Already Registered', 3);
                 return redirect()->to(base_url('salesagent/existingcustomeronboarding'));
                 
               }else{
                 // Failure
                 $this->session->setTempdata('error',$getotparray['STATUS'], 3);
                 return redirect()->to(base_url('salesagent/customeronboarding'));
               }
               
               
               /*-------------------------VERIFY OTP END-----------------------------*/
             }
            
          }else if($npceiarray['RESPONSECODE'] == 01 AND $npceiarray['STATUS'] == "FAILURE"){
            
          
            $data['customerverfctn'] = VerifyCustomer($vehclnum); 
            $customervrfy = json_decode($data['customerverfctn'])[0];
            $customervrfyarray = json_decode(json_encode($customervrfy), true);

            if($customervrfyarray["RESPONSECODE"] == 01){
            
                   $getotp = GenerateOTP($contactnumber,$reqid);
                   $getotpdata = json_decode($getotp)[0];
                   $getotparray = json_decode(json_encode($getotpdata), true);

                    if($getotparray['RESPONSECODE'] == 02){

                      // Will go to existing User
                       $this->session->set('tagActivationId',$lastinsertid);
                       return redirect()->to(base_url('salesagent/requestcustomeronboarding'));

                    }else if($getotparray['RESPONSECODE'] == 00){

                      // Will go to New User
                        $table ='tagactivationinitial';
                        $upclnm ='initialId';
                        $updtdata = [
                          'orgreqid'=>$getotparray['ORGREQID'],
                        ];
                        $updtid = $lastinsertid;
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        $this->session->set('tagActivationId',$lastinsertid);

                        $this->session->setTempdata('success','OTP Send Successfully . Valid For 3 Min', 3);
                        return redirect()->to(base_url('salesagent/newcustomeronboarding'));

                    }else if($getotparray['RESPONSECODE'] == 01){

                       // Failure
                        $this->session->setTempdata('error',$getotparray['STATUS'], 3);
                        return redirect()->to(base_url('salesagent/customeronboarding'));
                    }
            
            
            }else if($customervrfyarray["RESPONSECODE"] == 00){

              $this->session->set('tagActivationId',$lastinsertid);
             // $this->session->setTempdata('error','Vehicle Already Registered', 3);
              return redirect()->to(base_url('salesagent/existingcustomeronboarding'));

            }else{
              // Failure
              $this->session->setTempdata('error',$getotparray['STATUS'], 3);
              return redirect()->to(base_url('salesagent/customeronboarding'));
            }
            
            
          } 
            
        }else{
          $data['validations'] = $this->validator;
        }
        
        
        
        
      }
      
      
      $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      
      return view('salesagent/customeronboarding',$data);
    }
  
  
    public function newcustomeronboarding(){
      
      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }
      
      $data= [];
      
      $rules = [
              "otp"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'OTP Is required ',
                ],
              ],
            ];
      
      
    
      
      if($this->request->getMethod() == "post"){      
        
        if($this->validate($rules)){
          
           $tagActivationId = $_SESSION["tagActivationId"];
          
           $tagactivationdata = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$tagActivationId);
          
           $mobileNum = $tagactivationdata[0]["mobileNumber"];
           $orgreqid = $tagactivationdata[0]["orgreqid"];
           $otp = $this->request->getVar("otp");
           $reqid= time();
          
          
           $otpvarify = OTPVerify(time(),$mobileNum,$otp,$orgreqid);
          
           $otpverifydata = json_decode($otpvarify)[0];
           $otpverifyarray = json_decode(json_encode($otpverifydata), true);
          
           if($otpverifyarray['RESPONSECODE'] == 00){    
             
             $this->session->set('showUserform',1);
             $this->session->setTempdata('success',$otpverifyarray['STATUS'], 3);
             return redirect()->to(base_url('salesagent/newcustomeronboarding'));
             
           }else{

             $this->session->setTempdata('error',$otpverifyarray['STATUS'], 3);
            
             if($otpverifyarray['STATUS'] == "OTP Time Limit Exceeded"){
                session()->remove('tagActivationId');
                $this->session->setTempdata('error',$otpverifyarray['STATUS'], 3);
                return redirect()->to(base_url('salesagent/newcustomeronboarding'));
             }
             return redirect()->to(base_url('salesagent/newcustomeronboarding'));

           }        
          
        }else{
          $data['validations'] = $this->validator;
        }
        
        
      }
      
      if(!isset($_SESSION["tagActivationId"])){
          return redirect()->to(base_url('salesagent/customeronboarding'));
      }
      
      
      $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      $data['pincode'] = $this->loginModel->viewspecific('pincode','*','status',0);
      return view('salesagent/newcustomeronboarding',$data);
    }
  
  
  
    public function verifycustomer(){
      
        if ((!isset($_SESSION['salesagentId']))) {
          return redirect()->to(base_url('salesagentLogin'));            
        }

        $data= [];
      
      	$rules = [
              "firstname"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'First Name Is required ',
                ],
              ],
              "lastname"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Last Name Is required ',
                ],
              ],
              "panumber"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'PAN Number Is required ',
                ],
              ],
              "dob"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Date Of Birth Is required ',
                ],
              ],
              "gender"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Gender Is required ',
                ],
              ],
              "pincode"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Pincode Is required ',
                ],
              ],
              "addr1"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address 1 Is required ',
                ],
              ],
              "addr2"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address 2 Is required ',
                ],
              ],
              "addr3"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address 3 Is required ',
                ],
              ],
              "addresstype"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address Proof Is required ',
                ],
              ],
              "addrproofnum"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address Proof Number Is required ',
                ],
              ],
            ];
        
        if($this->request->getMethod() == "post"){      
        
        if($this->validate($rules)){ 
          
          $firstname = $this->request->getVar("firstname");
          $lastname = $this->request->getVar("lastname");
          $panumber = $this->request->getVar("panumber");
          $dob = $this->request->getVar("dob");
          $gender = $this->request->getVar("gender");
          $pincode = $this->request->getVar("pincode");
          $addr1 = $this->request->getVar("addr1");
          $addr2 = strtoupper($this->request->getVar("addr2"));
          $addr3 = $this->request->getVar("addr3");
          $addresstype = $this->request->getVar("addresstype");
          $addrproofnum = strtoupper($this->request->getVar("addrproofnum"));
          $dtm = date("Y-m-d h:i:s");
          $reqid= time();
          
          $customername = $firstname.' '.$lastname;
          
          
          $table ='tagactivationinitial';
          $upclnm ='initialId';
          $updtdata = [
            'customername' =>$customername,
            'pancarddetails' =>$panumber,
            'drivingLicence' =>$addrproofnum,
            'dateofbirth'=>$dob,
          ];

          $updtid = $_SESSION["tagActivationId"];
          $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
          
          $tagActivationId = $_SESSION["tagActivationId"];
          $tagactivationdata = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$tagActivationId);
          
          $mobileNum = $tagactivationdata[0]["mobileNumber"];
          $orgreqid = $tagactivationdata[0]["orgreqid"];
          $classofBarcode = $tagactivationdata[0]["classofBarcode"];
          $vehicleType = $tagactivationdata[0]["vehicleType"];
          
          $vehicleNumbertype = $tagactivationdata[0]["vehicleNumbertype"];
          $vehiclechasisnumber = $tagactivationdata[0]["vehiclechasisnumber"];
          $barcodeid = $tagactivationdata[0]["barcodeid"];
          $productid = $tagactivationdata[0]["productid"];
          
          
          /*---------------------------- NSDL VERIFICATION ------------------------------*/
          
          $ddob = date("Y/m/d", strtotime($dob));
          
          
                  $data['customerverification'] = VerifyNSDLCustomer(time(),$mobileNum,$orgreqid,$customername,$panumber,$ddob);
                  $data1 = json_decode($data['customerverification'])[0];
                  $array = json_decode(json_encode($data1), true);

                  if($array['RESPONSECODE'] == 00){
                    
                    /*-----------------From Here------------------------*/
                    
                    		 $table ='tagactivationinitial';
                             $upclnm ='initialId';
                             $updtdata = [
                               'tokennumber'=>$array['TOKENNO'],
                               'crnnumber'=>$array['CRN'],
                             ];
                             $updtid = $_SESSION["tagActivationId"];
                             $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    		 $customersubtype = $array['CUSTOMERSUBTYPE'];
                             $crn = $array['CRN'];


                             $data['datastatecity'] = GetStateCity(time(),$pincode);
                             $data2 = json_decode($data['datastatecity'])[0];
                             $array1 = json_decode(json_encode($data2), true);

                             if($array1['RESPONSECODE'] == 00){

                               $satetid = $array1['STATEID'];
                               $statename = $array1['STATENAME'];
                               $cityid = $array1['CITYID'];
                               $cityname = $array1['CITYNAME'];
                               $regionid = $array1['REGIONID'];
                               $regionname = $array1['REGIONNAME'];
                               $countryname = $array1['COUNTRYNAME'];

                               $reqid = time();
                               $data["walletcreated"]=WalletCreation(time(),$array['TOKENNO'],$orgreqid,$customersubtype,$crn,$mobileNum,$panumber,$customername,$ddob,$gender,$addr1,$addr2,$addr3,$pincode,$regionid,$satetid,$cityid,$regionname,$statename,$cityname,$addrproofnum,$addresstype);                    
                               $data2 = json_decode($data['walletcreated'])[0];
                               $array2 = json_decode(json_encode($data2), true);

                               if($array2['RESPONSECODE'] == 00){

                                 $data["customerVerification"] = VerifyCustomer($mobileNum);                          
                                 $data3 = json_decode($data['customerVerification'])[0];
                                 $array3 = json_decode(json_encode($data3), true);

                                 if($array3['RESPONSECODE'] == 00){

                                   $table ='tagactivationinitial';
                                   $upclnm ='initialId';
                                   $updtdata = [
                                     'agenttype'=>$array3['AGENTTYPE'],
                                     'customerid'=>$array3['CUSTOMERID'],
                                   ];
                                   $updtid = $_SESSION["tagActivationId"];
                                   $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
							
                                   
                                    session()->remove('showUserform');
                                    $this->session->set('customerverified',1);
                                    $this->session->setTempdata('success','Customer Verified Successfully', 3);
                                    return redirect()->to(base_url('salesagent/newcustomeronboarding'));
                                   
                                 }else{
                                   
                                   
                                   $table ='tagactivationinitial';
                                   $upclnm ='initialId';
                                   $updtdata = [
                                     'txnstatus'=>'SUCCESS',
                                     'responsecode'=>$array3['STATUS'],
                                     'responsestatus'=>$array3['RESPONSECODE'],
                                   ];
                                   $updtid = $_SESSION["tagActivationId"];
                                   $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                                   
                                   
                                   session()->remove('tagActivationId');
                                   session()->remove('showUserform');
                                   $this->session->setTempdata('error',$array3['STATUS'], 3);
                                   return redirect()->to(base_url('salesagent/failedtagactivation'));
                                 }


                               }else{
                                 
                                 $table ='tagactivationinitial';
                                 $upclnm ='initialId';
                                 $updtdata = [
                                   'txnstatus'=>'SUCCESS',
                                   'responsecode'=>$array2['STATUS'],
                                   'responsestatus'=>$array2['RESPONSECODE'],
                                 ];
                                 $updtid = $_SESSION["tagActivationId"];
                                 $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                                 
                                 session()->remove('tagActivationId');
                                 session()->remove('showUserform');
                                 $this->session->setTempdata('error',$array2['STATUS'], 3);
                                 return redirect()->to(base_url('salesagent/failedtagactivation'));
                               }

                             }else{
                               
                               $table ='tagactivationinitial';
                               $upclnm ='initialId';
                               $updtdata = [
                                 'txnstatus'=>'SUCCESS',
                                 'responsecode'=>$array1['STATUS'],
                                 'responsestatus'=>$array1['RESPONSECODE'],
                               ];
                               $updtid = $_SESSION["tagActivationId"];
                               $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                               
                               
                               session()->remove('tagActivationId');
                               session()->remove('showUserform');
                               $this->session->setTempdata('error',$array1['STATUS'], 3);
                               return redirect()->to(base_url('salesagent/failedtagactivation'));
                             }
                    
                    
                    /*-----------------Till Here------------------------*/
                    
                    
                  }else{
                    session()->remove('tagActivationId');
                    session()->remove('showUserform');
                    $this->session->setTempdata('error',$array['STATUS'], 3);
                    return redirect()->to(base_url('salesagent/failedtagactivation'));
                  }
           
            
        }else{
          $data['validations'] = $this->validator;
          
        }
      }
      
      
      
      $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      $data['pincode'] = $this->loginModel->viewspecific('pincode','*','status',0);
      return view('salesagent/newcustomeronboarding',$data);
    }
  
  
  
  	public function allotbarcode(){
         if ((!isset($_SESSION['salesagentId']))) {
           return redirect()->to(base_url('salesagentLogin'));            
         }
      
        $data= [];
      
        $rules = [          
          "product"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Product Is required ',
              ],
            ],
            "classofbarcode"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Class Of Barcode Is required ',
              ],
            ],
            "vehicletype"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Type Is required ',
              ],
            ],
          "rcbook"=>'uploaded[rcbook]|max_size[rcbook,5024]|ext_in[rcbook,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
          ];
      
       if($this->request->getMethod() == "post"){
         
         if($this->validate($rules)){
              
              $product = $this->request->getVar('product');
              $classofbarcode = $this->request->getVar('classofbarcode');
              $vehicletype = strtoupper($this->request->getVar('vehicletype')); 
              $orderId = time();
                       
              
              $productdetails = $this->oemModel->viewspecific('product','*','productid',$product);
              
              $fastagprice = $productdetails[0]['fastagprice'];
              $fastagClass = $productdetails[0]['fastagClass'];
              $minamnt = $productdetails[0]["minamount"];
              $depositeamnt = $productdetails[0]["depositamnt"];
              $cardcost = $productdetails[0]["cardcost"];
              $totalcost = $productdetails[0]["totalcost"];
              
              $vchldtls = $this->oemModel->viewspecific('classofbarcode','*','toshowinapplication',$classofbarcode);
              
              $classofbarcode = $vchldtls[0]["fastagclass"];
              
              
              //--------------------- RC Book Upload ----------------------------------------//

              $drivinglicence = $this->request->getFile('rcbook');
              if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
                $newdrivinglicence = $drivinglicence->getRandomName();
                if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
                  $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
                }
              }
              
              $img_file = $drivinglicencedat;
              $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));
              
              //--------------------- RC Book Upload END ----------------------------------------//
              
              
              
              $table ='tagactivationinitial';
              $upclnm ='initialId';
              $updtdata = [
                'vehicleType'=>$vehicletype,
                'rcbook'=>$drivinglicencedat,
                'transactionid' =>$orderId,
                'classofBarcode' =>$classofbarcode,
                'productid' => $product,
              ];
                          
              $updtid = $_SESSION["tagActivationId"];
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              
              if($vehicletype == "Non-Commercial"){
                $typecmmrcl =1;
              }else{
                $typecmmrcl =2;
              }
              
              $data["usedata"] = $this->oemModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION["tagActivationId"]);
              
              $mobnum = $data["usedata"][0]["mobileNumber"];
              $custmrid = $data["usedata"][0]["customerid"];
              $vehclnum = $data["usedata"][0]["vehiclechasisnumber"];         
              $vehiclenumbertype = $data["usedata"][0]["vehicleNumbertype"];              
              $barcode = $data["usedata"][0]["barcodeid"];
              $agentype = $data["usedata"][0]["agenttype"];
              
              $custname = $data["usedata"][0]["customername"]; 
              $dtm = date("Y-m-d h:i:s");
              
                $salesdetailsagent = $this->oemModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
                $salesmailid = $salesdetailsagent[0]['salesagentmailid'];
           
           
              
              	$data['vehicledata'] = addVehicle($orderId,$mobnum,$custmrid,$classofbarcode,$vehclnum,$typecmmrcl,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
                $data1 = json_decode($data['vehicledata'])[0];
                $array = json_decode(json_encode($data1), true);
              
                   
              
                if($array['RESPONSECODE'] == 01){
                     $this->session->setTempdata('error',$array['STATUS'], 3);
                     return redirect()->to(base_url('salesagent/failedtagactivation'));
                }else{                  
                  
                  $table ='tagactivationinitial';
                  $upclnm ='transactionid';
                  $updtdata = [                          
                    'transactionstatus'=>0,
                    'txnstatus'=>"SUCCESS",
                    "responsecode"=>$array["TAG"][0]["RESULT"],
                    "responsestatus"=>$array['STATUS'],
                  ];
                  $updtid = $orderId;
                  $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                  

                  $dtm=date("Y-m-d h:i:s");
				  if($array["TAG"][0]["RESULT"] == 230201){
                    $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcode);
                    $fatsagid = $salesagentdetails[0]['fasttagid'];

                    $table1 ='fastaginventory';
                    $upclnm1 ='fasttagid';
                    $updtdata1 = [                          
                      'status'=>1,
                    ];
                    $updtid1 = $fatsagid;
                    $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);

                    $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$data["usedata"][0]["initialId"],"allotedtotype"=>4,"allotedby"=>$_SESSION['salesagentId'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);

                    $insertdata = ["payerid" => $_SESSION['salesagentId'], "payertype" =>1, "amount" => $fastagprice, "transactionid" => $orderId, "transactiontype" => 2, "transactionstatus" => 2,"txn" => "SUCCESS","datetime"=>$dtm];               
                    $loginData = $this->loginModel->loginDatainsert('wallet',$insertdata);
					
                  
                    $stss="Fastag Activated Successfully";
                    
                    session()->remove('customerverified');
                    session()->remove('tagActivationId');
                    $this->session->setTempdata('success',$stss, 3);

                    return redirect()->to(base_url('salesagent/successtagactivation'));

                  }else{
                    $stss=$array["TAG"][0]["RESULT"];
                    
                    session()->remove('customerverified');
                    session()->remove('tagActivationId');
                    $this->session->setTempdata('error',$stss, 3);

                    return redirect()->to(base_url('salesagent/failedtagactivation'));

                  }

                  
                }
           
         }else{
           $data['validations'] = $this->validator;
         }
         
       }
       
        $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
        $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
        $data['pincode'] = $this->loginModel->viewspecific('pincode','*','status',0);
        return view('salesagent/newcustomeronboarding',$data);
    } 
  
  
    public function existingcustomeronboarding(){

      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }

      $data= [];
      $rules = [          
          "product"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Product Is required ',
              ],
            ],
            "classofbarcode"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Class Of Barcode Is required ',
              ],
            ],
            "vehicletype"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Type Is required ',
              ],
            ],
          "rcbook"=>'uploaded[rcbook]|max_size[rcbook,5024]|ext_in[rcbook,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
       ];
    
      
      if($this->request->getMethod() == "post"){   
          
          
        if($this->request->getVar('productid')){
           $productid = $this->request->getVar('productid');
           $classofbarcode = $this->loginModel->viewspecific('product','*','productid',$productid);
           $classofvehicle = $classofbarcode[0]["classofvehicle"];
           
           $vehicleclassofbarcode = $this->loginModel->viewspecificdstnt('classofbarcode','toshowinapplication','classofbarcode',$classofvehicle);
           
           $response="<option value=''> SELECT CLASS OF BARCODE </option>";
             foreach($vehicleclassofbarcode as $classofbarcode){
               $response.="<option value='".$classofbarcode["toshowinapplication"]."'> ".$classofbarcode["toshowinapplication"]." </option>";
             }
          
          echo $response;
          exit;
        } 
        
        
        if($this->request->getVar('classofbarcodesearch')){
           $classofbarcode = $this->request->getVar('classofbarcodesearch');
           $vehicletype = $this->loginModel->viewspecific('classofbarcode','*','toshowinapplication',$classofbarcode);
           
           //$vehicletype = $this->loginModel->getClassofbarcodespecific($classofbarcode);
           $response="<option value=''> SELECT VEHICLE TYPE </option>";
             foreach($vehicletype as $vehicletype){
               $response.="<option value='".$vehicletype["typeofvehicle"]."'> ".$vehicletype["typeofvehicle"]." </option>";
             }
          
          echo $response;
          exit;
        }
        
        if($this->validate($rules)){
          
          $product = $this->request->getVar('product');
          $classofbarcode = $this->request->getVar('classofbarcode');
          $vehicletype = strtoupper($this->request->getVar('vehicletype')); 
          $orderId = time();

          $productdetails = $this->oemModel->viewspecific('product','*','productid',$product);

          $fastagprice = $productdetails[0]['fastagprice'];
          $fastagClass = $productdetails[0]['fastagClass'];
          $minamnt = $productdetails[0]["minamount"];
          $depositeamnt = $productdetails[0]["depositamnt"];
          $cardcost = $productdetails[0]["cardcost"];
          $totalcost = $productdetails[0]["totalcost"];


          //--------------------- RC Book Upload ----------------------------------------//

          $drivinglicence = $this->request->getFile('rcbook');
          if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
            $newdrivinglicence = $drivinglicence->getRandomName();
            if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
              $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
            }
          }

          $img_file = $drivinglicencedat;
          $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));

          //--------------------- RC Book Upload END ----------------------------------------//
          
          
          $table ='tagactivationinitial';
          $upclnm ='initialId';
          $updtdata = [
            'vehicleType'=>$vehicletype,
            'rcbook'=>$drivinglicencedat,
            'transactionid' =>$orderId,
            'classofBarcode' =>$classofbarcode,
            'productid' => $product,
          ];

          $updtid = $_SESSION["tagActivationId"];
          $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);


          if($vehicletype == "Non-Commercial"){
            $typecmmrcl =2;
          }else{
            $typecmmrcl =1;
          }
          
          
    /*----------------------- START HERE --------------------------*/ 
          
          $tagActivationId = $_SESSION["tagActivationId"];
          $tagactivationdata = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$tagActivationId);
          $mobileNum = $tagactivationdata[0]["mobileNumber"];
          $orgreqid = $tagactivationdata[0]["orgreqid"];
          $barcodeid = $tagactivationdata[0]["barcodeid"];
          $vehiclechasisnumber = $tagactivationdata[0]["vehiclechasisnumber"];
          $vehicleNumbertype = $tagactivationdata[0]["vehicleNumbertype"];
          $vehicleType = $tagactivationdata[0]["vehicleType"];
          
          if($vehicleType == "Non-Commercial"){
            $typecmmrcl =2;
          }else{
            $typecmmrcl =1;
          }

          $data["customerVerification"] = VerifyCustomer($mobileNum);                          
          $data3 = json_decode($data['customerVerification'])[0];
          $array3 = json_decode(json_encode($data3), true);
          
          $table ='tagactivationinitial';
          $upclnm ='initialId';
          $updtdata = [                          
            'customerid'=>$array3['CUSTOMERID'],
            'agenttype'=>$array3['AGENTTYPE'],
            'customername'=>$array3['CUSTOMERNAME'],
          ];
          $updtid = $_SESSION["tagActivationId"];
          $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
          $customerid = $array3['CUSTOMERID'];
          $agntyp = $array3['AGENTTYPE'];


          $data['vehicledata'] = addVehicle($orderId,$mobileNum,$customerid,$classofbarcode,$vehiclechasisnumber,$typecmmrcl,$vehicleNumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcodeid,$agntyp,$rcbook);
          $data1 = json_decode($data['vehicledata'])[0];
          $array = json_decode(json_encode($data1), true);

          if($array['RESPONSECODE'] == 01){

            $table ='tagactivationinitial';
            $upclnm ='initialId';
            $updtdata = [                          
              'transactionstatus'=>0,
              'txnstatus'=>"SUCCESS",
              "responsecode"=>$array["TAG"][0]["RESULT"],
              "responsestatus"=>$array['STATUS'],
            ];
            $updtid = $_SESSION["tagActivationId"];
            $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('error',$array['STATUS'], 3);
            return redirect()->to(base_url('salesagent/failedtagactivation'));
          }else{                  

            $table ='tagactivationinitial';
            $upclnm ='initialId';
            $updtdata = [                          
              'transactionstatus'=>0,
              'txnstatus'=>"SUCCESS",
              "responsecode"=>$array["TAG"][0]["RESULT"],
              "responsestatus"=>$array['STATUS'],
            ];
            $updtid = $_SESSION["tagActivationId"];
            $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                  

            $dtm=date("Y-m-d h:i:s");

            if($array["TAG"][0]["RESULT"] == 230201){
              $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcodeid);
              $fatsagid = $salesagentdetails[0]['fasttagid'];

              $table1 ='fastaginventory';
              $upclnm1 ='fasttagid';
              $updtdata1 = [                          
                'status'=>1,
              ];
              $updtid1 = $fatsagid;
              $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);

              $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$_SESSION["tagActivationId"],"allotedtotype"=>4,"allotedby"=>$_SESSION['salesagentId'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
              $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);

              $insertdata = ["payerid" => $_SESSION['salesagentId'], "payertype" =>1, "amount" => $fastagprice, "transactionid" => $orderId, "transactiontype" => 2, "transactionstatus" => 2,"txn" => "SUCCESS","datetime"=>$dtm];               
              $loginData = $this->loginModel->loginDatainsert('wallet',$insertdata);


              $stss="Fastag Activated Successfully";
              
              session()->remove('tagActivationId');
              session()->remove('showUserform');
              $this->session->setTempdata('success',$stss, 3);

              return redirect()->to(base_url('salesagent/successtagactivation'));
              
            }else{
              $stss=$array["TAG"][0]["RESULT"];
              session()->remove('tagActivationId');
              session()->remove('showUserform');
              $this->session->setTempdata('success',$stss, 3);

              return redirect()->to(base_url('salesagent/failedtagactivation'));
            }

            
          } 

      /*----------------------- END HERE --------------------------*/
        }else{
          $data['validations'] = $this->validator;

        }
        
      }
      
      if(!isset($_SESSION["tagActivationId"])){
          return redirect()->to(base_url('salesagent/customeronboarding'));
      }
      $tagActivationId = $_SESSION["tagActivationId"];
      $tagactivationdata = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$tagActivationId);
      
      
      $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      $data['pincode'] = $this->loginModel->viewspecific('pincode','*','status',0);
      return view('salesagent/existingcustomeronboarding',$data);
    }
  
  
  
    public function requestcustomeronboarding(){
      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }

      $data= [];
      $rules = [
            "fnamee"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'First Name Is required ',
              ],
            ],
            "lnamee"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Last Name Is required ',
              ],
            ],
            "mnum"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Mobile Number Is required ',
              ],
            ],
            "vhclnum"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Number Is required ',
              ],
            ],
            "prd"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Product Is required ',
              ],
            ],
            "barcode"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Barcode Is required ',
              ],
            ],
            "vehicledatatype"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Data Type Is required ',
              ],
            ],
            "vehclcls"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Class Is required ',
              ],
            ],
            "vehicletype"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Type Is required ',
              ],
            ],
           "VehicleRC"=>'uploaded[VehicleRC]|max_size[VehicleRC,1024]|ext_in[VehicleRC,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
          ];
      
       if($this->request->getMethod() == "post"){
           
           
           if($this->request->getVar('productid')){
               $productid = $this->request->getVar('productid');
               $product = $this->loginModel->viewspecific('product','*','productid',$productid);
               
               $classofbarcode = $this->loginModel->viewspecificdstnt('classofbarcode','classofbarcode,toshowinapplication','fastagclass',$product[0]['fastagClass']);
               
               $response="<option value=''> SELECT CLASS OF BARCODE </option>";
                 foreach($classofbarcode as $classofbarcode){
                   $response.="<option value='".$classofbarcode["toshowinapplication"]."'> ".$classofbarcode["toshowinapplication"]." </option>";
                 }
              
              echo $response;
              exit;
            }
            
            
            if($this->request->getVar('reqststs')){
               $product = $this->loginModel->viewspecific('requestRegisterednumber','*','reqstregdnumid',$_SESSION["rqstidddd"]);
               $status = $product[0]['status'];
               
               $response = $status;
              
              echo $response;
              exit;
            }
            
            
            if($this->request->getVar('classofbarcodesearch')){
               $classofbarcode = $this->request->getVar('classofbarcodesearch');
               $vehicletype = $this->loginModel->getClassofbarcodespecificnwe($classofbarcode);
               $response="<option value=''> SELECT VEHICLE TYPE </option>";
                 foreach($vehicletype as $vehicletype){
                   $response.="<option value='".$vehicletype["typeofvehicle"]."'> ".$vehicletype["typeofvehicle"]." </option>";
                 }
              
              echo $response;
              exit;
            }
          
            if($this->validate($rules)){
              
              $fnamee = $this->request->getVar('fnamee');
              $lnamee = $this->request->getVar('lnamee');
              $mnum = $this->request->getVar('mnum');
              $vhclnum = $this->request->getVar('vhclnum');
              $VehicleRC = $this->request->getFile('VehicleRC');
              
              
              $prd = $this->request->getVar('prd');
              $barcode = $this->request->getVar('barcode');
              $vehicledatatype = $this->request->getVar('vehicledatatype');
              $vehclcls = $this->request->getVar('vehclcls');
              $vehicletype = $this->request->getVar('vehicletype');
              $dtm=date("Y-m-d h:i:s");
              
              if($this->request->getFile('VehicleRC')){
                if($VehicleRC->isValid() && !$VehicleRC->hasMoved()){
                  $newVehicleRC = $VehicleRC->getRandomName();
                  if($VehicleRC->move(FCPATH.'public/drivinglicence/',$newVehicleRC)){                           
                    $VehicleRC = $newVehicleRC;
                  }
                }else{
                  $profileImage = "default";
                }
              }
              
              
              $tagupdateds = ["firstname"=>$fnamee,"lastname"=>$lnamee,"mobilenumbr"=>$mnum,"vehcllnumbr"=>$vhclnum,"vehcllrc"=>$newVehicleRC,"salesagentid"=>$_SESSION['salesagentId'],"allotedbarcode"=>$barcode,"status"=>0,"datetime"=>$dtm,"updtdatetime"=>$dtm,"product"=>$prd,"vehicledatatype"=>$vehicledatatype,"vehicleclass"=>$vehclcls,"vehicletype"=>$vehicletype];                
              $loginData = $this->loginModel->loginDatainsert('requestRegisterednumber',$tagupdateds);
              $lastinsertid = $this->loginModel->db->insertID(); 
              $this->session->set('rqstidddd',$lastinsertid);

              session()->remove('tagActivationId');
              session()->remove('showUserform');
              $this->session->setTempdata('success','Request Send Successfully Waiting For Admin Approval', 3);
              return redirect()->to(base_url('salesagent/successv2activation'));
              
            }else{
              $data['validations'] = $this->validator;
            }

       }
      
      
      $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);     
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      $data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
      $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);           
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
      $data['pincode'] = $this->loginModel->viewspecific('pincode','*','status',0);
      $data['usrdata'] = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION["tagActivationId"]);
      
      return view('salesagent/requestcustomeronboarding',$data);
    }

              
          	
}

?>