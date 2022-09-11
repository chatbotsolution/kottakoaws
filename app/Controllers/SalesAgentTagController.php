<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;
use \App\Models\TeamLeadModel;
use \App\Models\SalesAgentWalletModel;

class SalesAgentTagController extends BaseController
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
  
  
    public function newuseractivation(){
         if ((!isset($_SESSION['salesagentId']))) {
           return redirect()->to(base_url('salesagentLogin'));            
         }
      
        $data= [];
        $rules = [
          "contactNumber"=>[
            'rules'=>'required|numeric|max_length[10]|min_length[10]',
            'errors'=>[
              'required'=>'Contact Number Is required ',
            ],
          ],
        ];
       
        $dtm = date('Y-m-d h:i:s');

        if($this->request->getMethod() == "post"){
          
            if($this->validate($rules)){
              
              $contactNumber = $this->request->getVar('contactNumber');
              
              $insertdata = ["productid"=>'',"classofBarcode"=>'',"vehicleType"=>'',"customername"=>'',"mobileNumber"=>$contactNumber,"pancarddetails"=>'',"drivingLicence"=>'',"rcbook"=>'',"vehicleNumbertype"=>'',"vehiclechasisnumber"=>'',"salesagentId"=>$_SESSION["salesagentId"],"salesagenttype"=>0,"orgreqid"=>'',"crnnumber"=>'',"tokennumber"=>'',"customerid"=>'',"dateofbirth"=>'',"agenttype"=>'',"barcodeid"=>'',"transactionstatus"=>1,"transactionid"=>'',"datetime"=>$dtm];
                
                $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$insertdata);
                $lastinsertid = $this->loginModel->db->insertID();
                $this->session->set('tagActivationId',$lastinsertid);
                
                $data['otpdata'] = GenerateOTP($contactNumber,time());                
                $data1 = json_decode($data['otpdata'])[0];
                $array = json_decode(json_encode($data1), true);
              
              
                if($array['RESPONSECODE'] == 00){ 
                  
                  
                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                        'orgreqid'=>$array['ORGREQID'],
                    ];
                    $updtid = $_SESSION["tagActivationId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                   $this->session->set('otpVeryfy',1);
                   $this->session->set('otpnumber',$contactNumber);
                   $this->session->setTempdata('success','OTP Send Successfully. OTP Valid for 3 Min', 3);
                   return redirect()->to(base_url('salesagent/newtagactivation'));
                  
                }else if($array['RESPONSECODE'] == 01){
                  
                  $this->session->setTempdata('error',$array['STATUS'], 3);
                  return redirect()->to(base_url('salesagent/newtagactivation'));
                  
                }else if($array['RESPONSECODE'] == 02){
                  $this->session->set('phnumberpresent',1);
                  $this->session->setTempdata('error',$array['STATUS'], 3);
                  return redirect()->to(base_url('salesagent/newtagactivation'));
                  
                }
              
            }else{
              $data['validations'] = $this->validator;
            }
        }
       
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);     
       $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
       $data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
      
       return view('salesagent/tagactivationnew',$data);
     }
  
  public function verifyotp(){
         if ((!isset($_SESSION['salesagentId']))) {
           return redirect()->to(base_url('salesagentLogin'));            
         }
      
        $data= [];
        $rules = [
          "otpreceived"=>[
            'rules'=>'required|numeric',
            'errors'=>[
              'required'=>'OTP Is required ',
            ],
          ],
        ];
       
        $dtm = date('Y-m-d h:i:s');

        if($this->request->getMethod() == "post"){
          
            if($this->validate($rules)){
              
              $otpreceived = $this->request->getVar('otpreceived');
              
              $data['usedata'] = $this->oemModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION['tagActivationId']);
              
              $otpmobile = $_SESSION['otpnumber'];
              $orgreqid = $data["usedata"][0]["orgreqid"];
              $reqid = time();

              $data['otpverify'] = OTPVerify($reqid,$otpmobile,$otpreceived,$orgreqid);
              $data1 = json_decode($data['otpverify'])[0];
              $array = json_decode(json_encode($data1), true);
              
              if($array['RESPONSECODE'] == 00){
                
                session()->remove('otpVeryfy');
                $this->session->set('otpVerified',1);
                $this->session->setTempdata('success','OTP Verified Successfully', 3);
                return redirect()->to(base_url('salesagent/newtagactivation'));
              }else{
                
                $this->session->setTempdata('error',$array['STATUS'], 3);
                if($array['STATUS'] == "OTP Time Limit Exceeded"){ session()->remove('otpVeryfy');session()->remove($_SESSION["otpnumber"]);session()->remove($_SESSION["tagActivationId"]);}
                return redirect()->to(base_url('salesagent/newtagactivation'));
                
              }
              
              
            }else{
              $data['validations'] = $this->validator;
            }
        }
      
      $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);
      $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
       
       return view('salesagent/tagactivationnew',$data);
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

                  $firstname = $this->request->getVar('firstname');
                  $lastname = $this->request->getVar('lastname');
                  $panumber = $this->request->getVar('panumber');
                  $dob = $this->request->getVar('dob');
                  $gender = $this->request->getVar('gender');
                  $pincode = $this->request->getVar('pincode');
                  $ddress1 = $this->request->getVar('addr1');
                  $address2 = $this->request->getVar('addr2');
                  $address3 = $this->request->getVar('addr3');
                  $addresstype = $this->request->getVar('addresstype');
                  $addrproofnum = $this->request->getVar('addrproofnum');
                  $name = $firstname.' '.$lastname;

                  $table ='tagactivationinitial';
                  $upclnm ='initialId';
                  $updtdata = [
                    'customername'=>$name,
                    'pancarddetails'=>$panumber,
                    'dateofbirth'=>$dob,
                  ];
                  $updtid = $_SESSION["tagActivationId"];
                  $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                  $salesagentdetails = $this->oemModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION['tagActivationId']);


                  $otpmobile = $salesagentdetails[0]['mobileNumber'];
                  $orgreqid = $salesagentdetails[0]['orgreqid'];                
                  $pancarddetails = $panumber;
                  $ddob = date("Y/m/d", strtotime($dob));

                  $data['customerverification'] = VerifyNSDLCustomer(time(),$otpmobile,$orgreqid,$name,$pancarddetails,$ddob);
                  $data1 = json_decode($data['customerverification'])[0];
                  $array = json_decode(json_encode($data1), true);

                  if($array['RESPONSECODE'] == 00){

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                      'tokennumber'=>$array['TOKENNO'],
                      'crnnumber'=>$array['CRN'],
                    ];
                    $updtid = $_SESSION["tagActivationId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);


                    $data['datastatecity'] = GetStateCity(time(),$pincode);
                    $data2 = json_decode($data['datastatecity'])[0];
                    $array1 = json_decode(json_encode($data2), true);

                    if($array1['RESPONSECODE'] == 00){

                      $salesagentdetails = $this->oemModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION['tagActivationId']);


                      $satetid = $array1['STATEID'];
                      $statename = $array1['STATENAME'];
                      $cityid = $array1['CITYID'];
                      $cityname = $array1['CITYNAME'];
                      $regionid = $array1['REGIONID'];
                      $regionname = $array1['REGIONNAME'];
                      $countryname = $array1['COUNTRYNAME'];

                      $reqid = time();
                      $token = $salesagentdetails[0]['tokennumber'];
                      $orgreqid = $salesagentdetails[0]['orgreqid'];
                      $customersubtype = $array['CUSTOMERSUBTYPE'];
                      $crnnum = $salesagentdetails[0]['crnnumber'];
                      $mobilenumber = $salesagentdetails[0]['mobileNumber'];
                      $panumber = $salesagentdetails[0]['pancarddetails'];
                      $name = $salesagentdetails[0]['customername'];
                      $dob = $ddob;
                      $data["walletcreated"]=WalletCreation($reqid,$token,$orgreqid,$customersubtype,$crnnum,$mobilenumber,$panumber,$name,$dob,$gender,$ddress1,$address2,$address3,$pincode,$regionid,$satetid,$cityid,$regionname,$statename,$cityname,$addrproofnum,$addresstype);                    
                      $data2 = json_decode($data['walletcreated'])[0];
                      $array2 = json_decode(json_encode($data2), true);

                      if($array2['RESPONSECODE'] == 00){

                        $data["customerVerification"] = VerifyCustomer($mobilenumber);                          
                        $data3 = json_decode($data['customerVerification'])[0];
                        $array3 = json_decode(json_encode($data3), true);

                        if($array3['RESPONSECODE'] == 00){

                          $table ='tagactivationinitial';
                          $upclnm ='initialId';
                          $updtdata = [
                            'agenttype'=>$array3['AGENTTYPE'],
                            'customerid'=>$array3['CUSTOMERID'],
                            'drivingLicence'=>$addrproofnum,
                            'vehicleNumbertype'=>$addresstype,
                          ];
                          $updtid = $_SESSION["tagActivationId"];
                          $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                          session()->remove('otpVerified');
                          $this->session->set('customerverified',1);
                          $this->session->setTempdata('success','Customer Verified Successfully', 3);
                          return redirect()->to(base_url('salesagent/newtagactivation'));

                        }else{
                          session()->remove('otpVerified');
                          session()->remove('tagActivationId');
                          session()->remove('otpnumber');
                          $this->session->setTempdata('error',$array3['STATUS'], 3);
                          return redirect()->to(base_url('salesagent/newtagactivation'));
                        }


                      }else{
                        session()->remove('otpVerified');
                        session()->remove('tagActivationId');
                        session()->remove('otpnumber');
                        $this->session->setTempdata('error',$array2['STATUS'], 3);
                        return redirect()->to(base_url('salesagent/newtagactivation'));
                      }

                    }else{
                      session()->remove('otpVerified');
                      session()->remove('tagActivationId');
                      session()->remove('otpnumber');
                      $this->session->setTempdata('error',$array1['STATUS'], 3);
                      return redirect()->to(base_url('salesagent/newtagactivation'));
                    }


                  }else{
                    session()->remove('otpVerified');
                    session()->remove('tagActivationId');
                    session()->remove('otpnumber');
                    $this->session->setTempdata('error',$array['STATUS'], 3);
                    return redirect()->to(base_url('salesagent/newtagactivation'));
                  }


                }else{
                  $data['validations'] = $this->validator;
                }
            }
         $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
         $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);       
         return view('salesagent/tagactivationnew',$data);

    }
  
  
       public function allotbarcode(){
         if ((!isset($_SESSION['salesagentId']))) {
           return redirect()->to(base_url('salesagentLogin'));            
         }
      
        $data= [];
      
        $rules = [          
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
            "vehclnum"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Number / Chassis Number Is required ',
              ],
            ],
            "vehicletype"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Type Is required ',
              ],
            ],
          	"vehclcls"=>[
              'rules'=>'required',
              'errors'=>[
                'required'=>'Vehicle Class Is required ',
              ],
            ],
          "rcbook"=>'uploaded[rcbook]|max_size[rcbook,5024]|ext_in[rcbook,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
          ];
      
       if($this->request->getMethod() == "post"){
         
         if($this->validate($rules)){
          
            if($this->request->getVar('barcode')){            

               // $data['vehicledata11'] = npcei($this->request->getVar('vehclnum'));
              //  $data11 = json_decode($data['vehicledata11'])[0];
              //  $array1 = json_decode(json_encode($data11), true);
              //  if($array1['NPCIVehicleDetails'][0]['BANKID'] == 607469){
                  
              //    $this->session->setTempdata('error',"This Vehicle Is Already Registered With Kotak", 3);
               //   return redirect()->to(base_url('salesagent/newtagactivation'));  
                  
             //   }else{
              
              $barcode = $this->request->getVar('barcode');
              $vehicledatatype = $this->request->getVar('vehicledatatype');
              $vehclnum = strtoupper($this->request->getVar('vehclnum'));
              $vehicletype = $this->request->getVar('vehicletype');
              $prd = $this->request->getVar('prd');
              $vehclcls = $this->request->getVar('vehclcls');
              
              
              $productdetails = $this->oemModel->viewspecific('product','*','productid',$prd);
              
              $fastagprice = $productdetails[0]['fastagprice'];
              $fastagClass = $productdetails[0]['fastagClass'];
              
              
              //--------------------- RC Book Upload ----------------------------------------//

              $drivinglicence = $this->request->getFile('rcbook');
              if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
                $newdrivinglicence = $drivinglicence->getRandomName();
                if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
                  $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
                }
              }
              $orderId = time();
              
              
              $table ='tagactivationinitial';
              $upclnm ='initialId';
              $updtdata = [
                'vehicleType'=>$vehicletype,
                'rcbook'=>$drivinglicencedat,
                'vehicleNumbertype'=>$vehicledatatype,
                'vehiclechasisnumber'=>$vehclnum,
                'barcodeid'=>$barcode,
                'transactionid' =>$orderId,
                'classofBarcode' =>$vehclcls,
                'productid' => $prd,
              ];
                          
              $updtid = $_SESSION["tagActivationId"];
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              $img_file = $drivinglicencedat;
              $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));
              
              $data['usedata'] = $this->oemModel->viewspecific('tagactivationinitial','*','initialId',$_SESSION['tagActivationId']);
              
              if($vehicletype == "Non-Commercial"){
                $typecmmrcl =2;
              }else{
                $typecmmrcl =1;
              }
              
              if($vehclcls == "VC4"){
                $vclclss = 4;
              }else if($vehclcls == "VC20"){
                $vclclss = 20;
              }else{
                $vclclss = 4;
              }
              
              $tnid = time();
              $mobnum = $data["usedata"][0]["mobileNumber"];
              $custname = $data["usedata"][0]["customername"];
              $custmrid = $data["usedata"][0]["customerid"];
              $vehclclss = $vehclcls;
              $vehclnum = $vehclnum;
              $commercialtype = $typecmmrcl;            
              $vehiclenumbertype = $vehicledatatype;            
              $minamnt = "100.00";
              $depositeamnt = "50.00";
              $cardcost = "100.00";
              $totalcost = "250.00";
              $barcode = $barcode;
              $agentype = $data["usedata"][0]["agenttype"];
              $dtm = date("Y-m-d h:i:s");
              
              
              $insertdata = ["mobnum"=>$mobnum,"custmrid"=>$custmrid,"vehclclss"=>$fastagClass,"vehclnum"=>$vehclnum,"commercialtype"=>$commercialtype,"vehiclenumbertype"=>$vehiclenumbertype,"minamnt"=>$minamnt,"depositeamnt"=>$depositeamnt,"cardcost"=>$cardcost,"totalcost"=>$totalcost,"barcode"=>$barcode,"agentype"=>$agentype,"rcbook"=>json_encode($rcbook),"tagactivationid"=>$_SESSION["tagActivationId"],"datetime"=>$dtm];               
              $loginData = $this->loginModel->loginDatainsert('temproryVehicledata',$insertdata);
              
                $salesdetailsagent = $this->oemModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
                $salesmailid = $salesdetailsagent[0]['salesagentmailid'];
              
                $img_file = $data["usedata"][0]["rcbook"];
                $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));
              
              	$data['vehicledata'] = addVehicle($tnid,$mobnum,$custmrid,$vclclss,$vehclnum,$typecmmrcl,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
                $data1 = json_decode($data['vehicledata'])[0];
                $array = json_decode(json_encode($data1), true);
              
                   
              
                if($array['RESPONSECODE'] == 01){
                     $this->session->setTempdata('error',$array['STATUS'], 3);
                     return redirect()->to(base_url('salesagent/newtagactivation'));
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
                  }else{
                    $stss=$array["TAG"][0]["RESULT"];
                  }

                  session()->remove('customerverified');
                  session()->remove('tagActivationId');
                  session()->remove('otpnumber');
                  $this->session->setTempdata('success',$stss, 3);
                  
                  return redirect()->to(base_url('salesagent/newtagactivation'));
                }
         //   }
           }
         }else{
           $data['validations'] = $this->validator;
         }
         
       }
       
       $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);       
       return view('salesagent/tagactivationnew',$data);
    } 
  
  
    public function paymentstatus(){
      
      $orderId = $this->request->getVar('orderId');
        
        
        	$data =[];
            $salesagentdetails = $this->loginModel->getSalesagentindividual1($orderId);
      
            
            if($salesagentdetails[0]["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $salesagentdetails[0]["ProfileImage"]; }
      
            $tgactv = $this->loginModel->lastLogin($salesagentdetails[0]['salesagentId']);

            $profileImage = $prf;
            $this->session->set('salesagentId',$salesagentdetails[0]['salesagentId']);
            $this->session->set('logged_intype',3);
            $this->session->set('login_data_id',1);
            $this->session->set('logged_img',$profileImage);
            $this->session->set('setTagactivationId',$orderId);
     
            if($tgactv == false){
                $lstLogin="";
            }else{
                $lstLogin=$tgactv['datetime_login'];
            }

            $usrnmm = $salesagentdetails[0]["Fname"].' '.$salesagentdetails[0]["Lname"];
            $this->session->set('usrName',$usrnmm);
            $this->session->set('usrLastLogin',$lstLogin);
        
        
            if($this->request->getVar('txStatus') == "SUCCESS"){
                
                $trnsts = $this->request->getVar('txStatus');
                $orderId = $this->request->getVar('orderId');
                $orderAmount = $this->request->getVar('orderAmount');
                $referenceId = $this->request->getVar('referenceId');
                $paymentMode = $this->request->getVar('paymentMode');
                $signature = $this->request->getVar('signature');
                $dtm=date("Y-m-d h:i:s");
                $databankdetails = ["refrenceid"=>$referenceId,"paymentmode"=>$paymentMode,"paymentamount"=>$orderAmount,"orderid"=>$orderId,"signature"=>$signature,"transactionstatus"=>$trnsts,"datetime"=>$dtm];
                $loginData = $this->loginModel->loginDatainsert('paymentstatus',$databankdetails);

                $table ='tagactivationinitial';
                $upclnm ='transactionid';
                $updtdata = [
                    'transactionstatus'=>0,
                ];
                $updtid = $orderId;
                $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              
                $orderId =  $_SESSION["setTagactivationId"];
                $salesagentid = $_SESSION['salesagentId'];

                $dtta = $this->loginModel->multiSrch('tagactivationinitial','*','transactionid',$orderId,'salesagentId',$salesagentid);
              
              //echo $dtta[0]["drivingLicence"];
            
              if($dtta[0]["vehicleType"] == "Non-Commercial"){
                $typecmmrcl =1;
              }else{
                $typecmmrcl =2;
              }
            	
              if($dtta[0]["classofBarcode"] == "VC4"){
                $vclclss = 4;
              }else if($dtta[0]["classofBarcode"] == "VC20"){
                $vclclss = 20;
              }else{
                $vclclss = 4;
              }
            
              $tnid = time();
              $mobnum = $dtta[0]["mobileNumber"];
              $custmrid = $dtta[0]["customerid"];
              $vehclclss = $vclclss;
              $vehclnum = $dtta[0]["vehiclechasisnumber"];
              $commercialtype = $typecmmrcl;            
              $vehiclenumbertype = $dtta[0]["vehicleNumbertype"];            
              $minamnt = "150.00";
              $depositeamnt = "50.00";
              $cardcost = "0.00";
              $totalcost = "200.00";
              $barcode = $dtta[0]["barcodeid"];
              $agentype = $dtta[0]["agenttype"];
              
              
              
                $img_file = $dtta[0]["rcbook"];
                $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));
              
              	$data['vehicledata'] = addVehicle($tnid,$mobnum,$custmrid,$vehclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
                 $data1 = json_decode($data['vehicledata'])[0];
                 $array = json_decode(json_encode($data1), true);
                 
              
                if($array['RESPONSECODE'] == 01){
                     $this->session->setTempdata('error',$array['STATUS'], 3);
                     return redirect()->to(base_url('salesagent/newtagactivation'));
                }else{
                  
                  
                        $table ='tagactivationinitial';
                        $upclnm ='transactionid';
                        $updtdata = [                          
                          'transactionstatus'=>0,
                          'txnstatus'=>$this->request->getVar('txStatus'),
                        ];
                        $updtid = $orderId;
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                        $table1 ='fastaginventory';
                        $upclnm1 ='fasttagid';
                        $updtdata1 = [                          
                          'status'=>1,
                        ];
                        $updtid1 = $fatsagid;
                        $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);
                  
                        $dtm=date("Y-m-d h:i:s");
                  
                        $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcode);
                        $fatsagid = $salesagentdetails[0]['fasttagid'];

                        $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$dtta[0]["initialId"],"allotedtotype"=>4,"allotedby"=>$_SESSION['salesagentId'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                        $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);
                  
                  
                      session()->remove('customerverified');
                      session()->remove('tagActivationId');
                      session()->remove('otpnumber');
                      $this->session->setTempdata('success',$array['STATUS'], 3);
                      return redirect()->to(base_url('salesagent/newtagactivation'));
                }
            }else{
              
              $table ='tagactivationinitial';
              $upclnm ='transactionid';
              $updtdata = [
                'txnstatus'=>$this->request->getVar('txStatus'),
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              session()->remove('customerverified');
              session()->remove('tagActivationId');
              session()->remove('otpnumber');
              $this->session->setTempdata('error','Payment Was Not Successfully', 3);
              return redirect()->to(base_url('salesagent/newtagactivation'));
              
            }
      
            $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
            $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);  
             
            return view('salesagent/tagactivationnew',$data);      
    }
  
  
  
  	public function verifyregstrnum(){
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

              session()->remove('phnumberpresent');
              $this->session->setTempdata('success','Request Send Successfully Waiting For Admin Approval', 3);
              return redirect()->to(base_url('salesagent/newtagactivation'));
              
            }else{
              $data['validations'] = $this->validator;
            }

       }
       
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['salesagentId'],3);     
       $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
       $data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
      
       return view('salesagent/tagactivationnew',$data);
    }
  
  
    public function cancelTrans(){
      if($this->request->getMethod() == "post"){ 

          session()->remove('otpVeryfy');
          session()->remove('otpVerified');
          session()->remove('customerverified');
          session()->remove('phnumberpresent');

          exit;
      }
  }
  
  
  public function failtagactive(){
    $data=[];
    
      return view('salesagent/sorryunabletoactivate',$data);
  }
  
  public function successtagactive(){
    $data=[];
    
      return view('salesagent/fastagactivatesuccessfully',$data);
  }
  
  public function successv2active(){
    $data=[];
    
      return view('salesagent/successfullysendv2request',$data);
  }
  
}

?>