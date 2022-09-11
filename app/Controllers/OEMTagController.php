<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;
use \App\Models\TeamLeadModel;
use TCPDF; 

class OEMTagController extends BaseController
{
    public $loginModel;
    public $teamleadmodel;
    public $productmodel;
    public $oemModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');
        $this->loginModel = new SalesAgentModel();
        $this->teamleadmodel = new TeamLeadModel();
        $this->productmodel = new ProductModel();
        $this->oemModel = new OemModel();
        $this->session = session();
        require_once(APPPATH.'Helpers/tcpdf/tcpdf.php');
        
    }

    public function activateexisting()
    {
      if ((!isset($_SESSION['oemid']))) {
              return redirect()->to(base_url('oemLogin'));            
          }
      
        $data= [];
        $rules = [
          "mobilenum"=>[
            'rules'=>'required',
            'errors'=>[
              'required'=>'Mobile Number Is required ',
            ],
          ],
        ];

        if($this->request->getMethod() == "post"){
          
          if($this->request->getVar('mobilenum')){
            if($this->validate($rules)){
              $vehicleNumber = $this->request->getVar('mobilenum');
              $data['customerverfctn'] = VerifyCustomer($vehicleNumber); 

            }else{
              $data['validations'] = $this->validator;
            }
          }

          if($this->request->getVar('shwclssTag')){
            $data['tgg'] = $this->loginModel->snglprddtls($this->request->getVar('shwclssTag'));
            $shwclssTag = $this->request->getVar('shwclssTag');
            $table="classofbarcode";
            $viewdata="*";
            $whrclm="fastagclass";
            $whrval=$data["tgg"][0]["fastagClass"];
            $data["barcodeclss"] = $this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
            $response='
                            <td>
                              <strong> Class Of Barcode </strong>                            
                                  <select class="form-control" name="barcodetyp" id="barcodetyp" onchange="shwsome(this.value);">
                                      <option value="">Select Class Of Barcode</option>';
                                      $cnt = count($data["barcodeclss"]);
                                      for($i=0;$i < $cnt; $i++){
                                        $response.='<option value="'.$data["barcodeclss"][$i]["classofbarcode"].'"> '.$data["barcodeclss"][$i]["classofbarcode"].' </option>';                                
                                      }
            		 $response.='</select>
                            </td>
                            <td>
                              <strong> Fastag Class </strong>
                                  <input type="text" name="fstagclss" id="fstagclss" Placeholder="Fastag Class" readonly="readonly" value="'.$data["tgg"][0]["fastagClass"].'" class="form-control mg-b-10">
                            </td>';

            echo $response;
            exit;
          }

          if($this->request->getVar('barcodetype')){
            $barcodetyp = $this->request->getVar('barcodetype');
            if($barcodetyp == "VC20"){
              $response='
                                       <td>
                                          <strong> Type </strong>
                                          <select class="form-control" name="typee" id="typee" required>
                                              <option value="Commercial"> Commercial </option>
                                          </select>
                                       </td>';
            }else if($barcodetyp == "VC4"){
              $response='
                                    <td>
                                        <strong> Type </strong>
                                        <select class="form-control" name="typee" id="typee" required>
                                            <option value="Non-Commercial"> Non-Commercial </option>
                                            <option value="Commercial"> Commercial </option>
                                        </select>
                                     </td>';
            }                

            echo $response;
            exit;
          }
        }

        $data['tagclass'] = $this->productmodel->distinctVal("fasttag","classoftag");
        $data['product'] = $this->loginModel->viewprdata($_SESSION['oemid']);
        $data['slctdfstg'] = $this->productmodel->multisearchFastagOEM($_SESSION['oemid']);
        return view('oem/activateexisting',$data);
    }
  
  
    public function activateexistingUsers()
      {
          if ((!isset($_SESSION['oemid']))) {
              return redirect()->to(base_url('oemLogin'));            
          }
      
              
                if($this->request->getMethod() == "post"){
                  if($this->request->getVar('custid')){
                      $custid = $this->request->getVar('custid');
                      $custnum = $this->request->getVar('custnum');
                      $custnme = $this->request->getVar('custnme');
                      $barcode = $this->request->getVar('barcode');
                      $prd = $this->request->getVar('prd');
                      $vehicleidtype = $this->request->getVar('vehicleidtype');
                      $vehiclenumber = strtoupper($this->request->getVar('vehiclenumber'));
                      $drivinglicence = $this->request->getFile('drivinglicence');
                      $barcodetyp = $this->request->getVar('barcodetyp');
                      $typee = $this->request->getVar('typee');
                      $fstagclss = $this->request->getVar('fstagclss');
                      $dtm = date('Y-m-d h:i:s');
                      $agntp = $this->request->getVar('agntp');
                      $ordrid =time();
                    
                    
                    $fstg = $this->loginModel->viewspecific('product','fastagprice','productid',$prd); 
                    $orderAmount = $fstg[0]['fastagprice']; 
                    $purchasenote = 'Tag Purchase For Vehicle'.$vehiclenumber;

                    //--------------------- Driving Licence Upload ----------------------------------------//

                    $drivinglicence = $this->request->getFile('drivinglicence');
                    if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
                      $newdrivinglicence = $drivinglicence->getRandomName();
                      if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
                           $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
                      }
                    }
                    
                    $databankdetails = ["productid"=>$prd,"classofBarcode" =>$barcodetyp,"vehicleType" =>$typee,"customername" =>$custnme,"mobileNumber" =>$custnum,"rcbook" =>$drivinglicencedat,"vehicleNumbertype" =>$vehicleidtype,"vehiclechasisnumber" =>$vehiclenumber,"salesagentId" =>$_SESSION['oemid'],"customerid" =>$custid,"agenttype" =>$agntp,"barcodeid" =>$barcode,"transactionstatus" =>1,"transactionid" =>$ordrid,"datetime" =>$dtm,"salesagentType" =>1];
                
                $loginData = $this->loginModel->loginDatainsert('tagactivationExistingUser',$databankdetails);
                
                 if($typee == "Non-Commercial"){
                    $typecmmrcl =2;
                  }else{
                    $typecmmrcl =1;
                  }


                    $tnid = time();
                    $mobnum = $custnum;
                    $custmrid = $custid;
                    $vehclclss = 4;
                    $vehclnum = $vehiclenumber;
                    $commercialtype = $typecmmrcl;            
                    $vehiclenumbertype = $vehicleidtype;            
                    $minamnt = "150.00";
                    $depositeamnt = "50.00";
                    $cardcost = "0.00";
                    $totalcost = "200.00";
                    $barcode = $barcode;
                    $agentype = $agntp;



                    $img_file = $drivinglicencedat;
                    $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));

                    $data['vehicledata'] = addVehicle($tnid,$mobnum,$custmrid,$vehclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
                     $data1 = json_decode($data['vehicledata'])[0];
                     $array = json_decode(json_encode($data1), true);

                    $table ='tagactivationExistingUser';
                    $upclnm ='transactionid';
                    $updtdata = [
                        'resultTag'=>$array['STATUS'],
                        'statusTag'=>$array['TAG'][0]['RESULT'],
                    ];
                    $updtid = $ordrid;
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    
                    $response = $array['TAG'][0]['RESULT'];  
                    echo $response;
                    exit;
                    
                  }                  
                  
               }
      
                   $data['tagclass'] = $this->productmodel->distinctVal("fasttag","classoftag");
                   $data['product'] = $this->loginModel->viewprdata($_SESSION['oemid']);
         		   $data['slctdfstg'] = $this->productmodel->multisearchFastagOEM($_SESSION['oemid']);
      
             return view('oem/activateexisting',$data);
      }
  
  
     public function newuseractivation(){
         if ((!isset($_SESSION['oemid']))) {
           return redirect()->to(base_url('oemLogin'));            
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
              
              $insertdata = ["productid"=>'',"classofBarcode"=>'',"vehicleType"=>'',"customername"=>'',"mobileNumber"=>$contactNumber,"pancarddetails"=>'',"drivingLicence"=>'',"rcbook"=>'',"vehicleNumbertype"=>'',"vehiclechasisnumber"=>'',"salesagentId"=>$_SESSION["oemid"],"salesagenttype"=>1,"orgreqid"=>'',"crnnumber"=>'',"tokennumber"=>'',"customerid"=>'',"dateofbirth"=>'',"agenttype"=>'',"barcodeid"=>'',"transactionstatus"=>1,"transactionid"=>'',"datetime"=>$dtm];
                
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
                   return redirect()->to(base_url('oem/newtagactivation'));
                  
                }else if($array['RESPONSECODE'] == 01){
                  
                  $this->session->setTempdata('error',$array['STATUS'], 3);
                  return redirect()->to(base_url('oem/newtagactivation'));
                  
                }else if($array['RESPONSECODE'] == 02){
                  $this->session->set('phnumberpresent',1);
                  $this->session->setTempdata('error',$array['STATUS'], 3);
                  return redirect()->to(base_url('oem/newtagactivation'));
                  
                }
              
            }else{
              $data['validations'] = $this->validator;
            }
        }
       
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['oemid'],5);
       
       return view('oem/tagactivationnew',$data);
     }
  
  
  	public function verifyotp(){
         if ((!isset($_SESSION['oemid']))) {
           return redirect()->to(base_url('oemLogin'));            
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
                return redirect()->to(base_url('oem/newtagactivation'));
              }else{
                
                $this->session->setTempdata('error',$array['STATUS'], 3);
                return redirect()->to(base_url('oem/newtagactivation'));
                
              }
              
              
            }else{
              $data['validations'] = $this->validator;
            }
        }
      
      $data['barcode'] = $this->oemModel->showfastag($_SESSION['oemid'],5);
       
       return view('oem/tagactivationnew',$data);
     }
  
  
  
  public function verifycustomer(){
    
     if ((!isset($_SESSION['oemid']))) {
           return redirect()->to(base_url('oemLogin'));            
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
                  'drivingLicence'=>$addrproofnum,
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
                          'rcbook'=>$addrproofnum,
                        ];
                        $updtid = $_SESSION["tagActivationId"];
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        
                        session()->remove('otpVerified');
                        $this->session->set('customerverified',1);
                        $this->session->setTempdata('success','Customer Verified Successfully', 3);
                        return redirect()->to(base_url('oem/newtagactivation'));
                        
                      }else{
                        session()->remove('otpVerified');
                        session()->remove('tagActivationId');
                        session()->remove('otpnumber');
                        $this->session->setTempdata('error',$array3['STATUS'], 3);
                        return redirect()->to(base_url('oem/newtagactivation'));
                      }
                      
                      
                    }else{
                      session()->remove('otpVerified');
                      session()->remove('tagActivationId');
                      session()->remove('otpnumber');
                      $this->session->setTempdata('error',$array2['STATUS'], 3);
                      return redirect()->to(base_url('oem/newtagactivation'));
                    }
                    
                  }else{
                    session()->remove('otpVerified');
                    session()->remove('tagActivationId');
                    session()->remove('otpnumber');
                    $this->session->setTempdata('error',$array1['STATUS'], 3);
                    return redirect()->to(base_url('oem/newtagactivation'));
                  }
                  
                  
                }else{
                    session()->remove('otpVerified');
                    session()->remove('tagActivationId');
                    session()->remove('otpnumber');
                  $this->session->setTempdata('error',$array['STATUS'], 3);
                  return redirect()->to(base_url('oem/newtagactivation'));
                }
                
                
              }else{
                $data['validations'] = $this->validator;
              }
          }
    
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['oemid'],5);       
       return view('oem/tagactivationnew',$data);
    
  }
  
     public function allotbarcode(){
         if ((!isset($_SESSION['oemid']))) {
           return redirect()->to(base_url('oemLogin'));            
         }
      
        $data= [];
      
        $rules = [
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
          ];
      
       if($this->request->getMethod() == "post"){
          
            if($this->validate($rules)){
              
              $barcode = $this->request->getVar('barcode');
              $vehicledatatype = $this->request->getVar('vehicledatatype');
              $vehclnum = strtoupper($this->request->getVar('vehclnum'));
              $vehicletype = $this->request->getVar('vehicletype');              
              $vehclcls = $this->request->getVar('vehclcls');
              
              
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
              $custmrid = $data["usedata"][0]["customerid"];
              $vehclclss = $vclclss;
              $commercialtype = $typecmmrcl;            
              $vehiclenumbertype = $vehicledatatype;            
              $minamnt = "150.00";
              $depositeamnt = "50.00";
              $cardcost = "0.00";
              $totalcost = "200.00";
              $barcode = $barcode;
              $agentype = $data["usedata"][0]["agenttype"];
              
              
              $data['vehicledata'] = addVehicle($tnid,$mobnum,$custmrid,$vehclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
              $data1 = json_decode($data['vehicledata'])[0];
              $array = json_decode(json_encode($data1), true);
                
                if($array['RESPONSECODE'] == 01){
                     $this->session->setTempdata('error',$array['STATUS'], 3);
                     return redirect()->to(base_url('oem/newtagactivation'));
                }else{
                  
                  
                        $table ='tagactivationinitial';
                        $upclnm ='initialId';
                        $updtdata = [
                          'vehicleType'=>$vehicletype,
                          'rcbook'=>$img_file,
                          'vehicleNumbertype'=>$vehicledatatype,
                          'vehiclechasisnumber'=>$vehclnum,
                          'barcodeid'=>$barcode,
                          'transactionstatus'=>0,
                          'txnstatus'=>"SUCCESS",
                          'responsecode'=>$array["TAG"][0]["RESULT"],
                          'responsestatus'=>$array['STATUS'],
                          'transactionid'=>$tnid,
                          'classofBarcode'=>$vehclcls,
                        ];
                        $updtid = $_SESSION["tagActivationId"];
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                        $dtm=date("Y-m-d h:i:s");
                  
                        $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcode);
                        $fatsagid = $salesagentdetails[0]['fasttagid'];

                        $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$_SESSION["tagActivationId"],"allotedtotype"=>4,"allotedby"=>$_SESSION['oemid'],"allotedbytype"=>5,"status"=>0,"datetime"=>$dtm];                
                        $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);
                  
                  
                      session()->remove('customerverified');
                      session()->remove('tagActivationId');
                      session()->remove('otpnumber');
                      $this->session->setTempdata('success','Tag Allocated Successfully', 3);
                }
              
            }else{
              $data['validations'] = $this->validator;
            }

       }
      
      
       $data['barcode'] = $this->oemModel->showfastag($_SESSION['oemid'],5);       
       return view('oem/tagactivationnew',$data);
    }  
  
  
  
  	public function verifyregstrnum(){
         if ((!isset($_SESSION['oemid']))) {
           return redirect()->to(base_url('oemLogin'));            
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
           "VehicleRC"=>'uploaded[VehicleRC]|max_size[VehicleRC,1024]|ext_in[VehicleRC,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
          ];
      
       if($this->request->getMethod() == "post"){
          
            if($this->validate($rules)){
              
              $fnamee = $this->request->getVar('fnamee');
              $lnamee = $this->request->getVar('lnamee');
              $mnum = $this->request->getVar('mnum');
              $vhclnum = $this->request->getVar('vhclnum');
              $VehicleRC = $this->request->getFile('VehicleRC');
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
              
              
              $tagupdateds = ["firstname"=>$fnamee,"lastname"=>$lnamee,"mobilenumbr"=>$mnum,"vehcllnumbr"=>$vhclnum,"vehcllrc"=>$newVehicleRC,"salesagentid"=>$_SESSION['oemid'],"allotedbarcode"=>'',"status"=>0,"datetime"=>$dtm,"updtdatetime"=>$dtm,"reqstbytype"=>1];                
              $loginData = $this->loginModel->loginDatainsert('requestRegisterednumber',$tagupdateds);

              session()->remove('phnumberpresent');
              $this->session->setTempdata('success','Request Send Successfully Waiting For Admin Approval', 3);
              return redirect()->to(base_url('oem/newtagactivation'));
              
            }else{
              $data['validations'] = $this->validator;
            }

       }
       
            
       return view('oem/tagactivationnew',$data);
    } 
  
  
  	public function downloadreportnewcustomer()
      {
             if ((!isset($_SESSION['oemid']))) {
                  return redirect()->to(base_url('oemLogin'));            
              }    


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                      //$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
                      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                      $pdf->SetDefaultMonospacedFont('helvetica');  
                      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                      $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                      $pdf->setPrintHeader(false);  
                      $pdf->setPrintFooter(false);  
                      $pdf->SetAutoPageBreak(TRUE, 10);  
                      $pdf->SetFont('helvetica', '', 12);
                      $pdf->AddPage();

                      $html='
                   <html lang="en">
                      <head>
                       <meta charset="utf-8">
                       <meta name="viewport" content="width=device-width, initial-scale=1">        
                       <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                       <title>Fastag</title>
                     </head>
                     <body style="font-family: \'Montserrat\';">  
                       <div class="container">                         
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="9">Tag Activation Report</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <td>Sl No</td>
                               <td>Customer Name</td>
                               <td>Customer Id</td>
                               <td>PAN Card Number</td>
                               <td>Vehicle/ Chassis Number</td>
                               <td>Mobile Number</td>
                               <td>Bar Code</td>
                               <td>Date Of Activation</td>
                               <td>Time Of Activation</td>
                           </tr>
                           </thead>
                           <tbody>';
                            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagenttype' =>1);
                            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);

                            $cnt= sizeof($data['customer']);

                            if($cnt == 0){
                              $fstgdetls = [];
                            }else {
                              for($i=0;$i<$cnt;$i++){
                                  $fstgdetls[] = $this->loginModel->multiSrch('fasttag','*','barcode',$data['customer'][$i]["barcodeid"],'status',2);
                              } 
                            }

                            $data['fstgdetls'] = $fstgdetls;

                            $cnt= sizeof($data['customer']);
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["pancarddetails"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
  
  
  	  public function downloadreportexestingcustomer()
      {
            if ((!isset($_SESSION['oemid']))) {
              return redirect()->to(base_url('oemLogin'));            
            }
        


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                     // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
                      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                      $pdf->SetDefaultMonospacedFont('helvetica');  
                      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                      $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                      $pdf->setPrintHeader(false);  
                      $pdf->setPrintFooter(false);  
                      $pdf->SetAutoPageBreak(TRUE, 10);  
                      $pdf->SetFont('helvetica', '', 12);
                      $pdf->AddPage();

                      $html='
                   <html lang="en">
                      <head>
                       <meta charset="utf-8">
                       <meta name="viewport" content="width=device-width, initial-scale=1">        
                       <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                       <title>Fastag</title>
                     </head>
                     <body style="font-family: \'Montserrat\';">  
                       <div class="container">                         
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="8">Tag Activation Report</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <th>Sl No</th>
                               <th>Customer Name</th>
                               <th>Customer Id</th>
                               <th>Vehicle/ Chassis Number</th>
                               <th>Mobile Number</th>
                               <th>Bar Code</th>
                               <th>Date Of Activation</th>
                               <th>Time Of Activation</th>
                           </tr>
                           </thead>
                           <tbody>';

                            $data=[];

                            $array = array('statusTag' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagentType' =>1);
                            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
                            $cnt= sizeof($data['customer']);
        
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
    
  
  	 public function downloadreportnewsrch($startdate,$endt)
      {
            if ((!isset($_SESSION['oemid']))) {
              return redirect()->to(base_url('oemLogin'));            
            }
        


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                     // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
                      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                      $pdf->SetDefaultMonospacedFont('helvetica');  
                      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                      $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                      $pdf->setPrintHeader(false);  
                      $pdf->setPrintFooter(false);  
                      $pdf->SetAutoPageBreak(TRUE, 10);  
                      $pdf->SetFont('helvetica', '', 12);
                      $pdf->AddPage();

                      $html='
                   <html lang="en">
                      <head>
                       <meta charset="utf-8">
                       <meta name="viewport" content="width=device-width, initial-scale=1">        
                       <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                       <title>Fastag</title>
                     </head>
                     <body style="font-family: \'Montserrat\';">  
                       <div class="container">                         
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="8">Tag Activation Report ( '.date("d-m-Y", strtotime($startdate)).' TILL '.date("d-m-Y", strtotime($endt)).')</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <th>Sl No</th>
                               <th>Customer Name</th>
                               <th>Customer Id</th>
                               <th>Vehicle/ Chassis Number</th>
                               <th>Mobile Number</th>
                               <th>Bar Code</th>
                               <th>Date Of Activation</th>
                               <th>Time Of Activation</th>
                           </tr>
                           </thead>
                           <tbody>';

                            $data=[];
       
                            $enddate = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                            $rt = $startdate.' 00:00:00';
                            $rte = $enddate.' 00:00:00';

                            $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagenttype' =>1,'datetime >=' => $rt,'datetime <=' => $rte);
                            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
       
                            $cnt= sizeof($data['customer']);
        
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
  
  
  	  public function downloadreportlstwek()
        {
              if ((!isset($_SESSION['oemid']))) {
                return redirect()->to(base_url('oemLogin'));            
              }

                        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                       // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                        $pdf->SetCreator(PDF_CREATOR);  
                        $pdf->SetTitle("Report Tag Activation");  
                        $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                        $pdf->SetDefaultMonospacedFont('helvetica');  
                        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                        $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                        $pdf->setPrintHeader(false);  
                        $pdf->setPrintFooter(false);  
                        $pdf->SetAutoPageBreak(TRUE, 10);  
                        $pdf->SetFont('helvetica', '', 12);
                        $pdf->AddPage();

                        $html='
                     <html lang="en">
                        <head>
                         <meta charset="utf-8">
                         <meta name="viewport" content="width=device-width, initial-scale=1">        
                         <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                         <title>Fastag</title>
                       </head>
                       <body style="font-family: \'Montserrat\';">  
                         <div class="container">                         
                           <table border="1" cellpadding="2" cellspacing="2" align="center">
                             <tr nobr="true">
                              <th colspan="8">Tag Activation Report Last Week Report</th>
                             </tr>
                             <thead>
                             <tr nobr="true">
                                 <th>Sl No</th>
                                 <th>Customer Name</th>
                                 <th>Customer Id</th>
                                 <th>Vehicle/ Chassis Number</th>
                                 <th>Mobile Number</th>
                                 <th>Bar Code</th>
                                 <th>Date Of Activation</th>
                                 <th>Time Of Activation</th>
                             </tr>
                             </thead>
                             <tbody>';

                              $data=[];

                              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagenttype' =>1);
                              $data['customer'] = $this->loginModel->viewspecificothh('tagactivationinitial','*',$array);

                              $cnt= sizeof($data['customer']);

                              $j=0;
                              for($i=0;$i<$cnt;$i++){ 
                                $j++;

                                   $html.='<tr nobr="true">
                                              <td>'.$j.'</td>
                                              <td>'.$data['customer'][$i]["customername"].'</td>
                                              <td>'.$data['customer'][$i]["customerid"].'</td>
                                              <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                              <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                              <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                              <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                              <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                           </tr>';                              
                              }

                   $html.=' </tbody>
                            </table>

                           <p style="height: 30px;"></p>

                           <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                               <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                           </div>
                       </div>
                      </body>
                      </html>';

                        //$pdf->writeHTML($html);
                        $pdf->writeHTML($html, true, false, true, false, '');
                        $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
        }
  
  
  		public function downloadreportextsrch($startdate,$endt)
      {
            if ((!isset($_SESSION['oemid']))) {
              return redirect()->to(base_url('oemLogin'));            
            }
        


                      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                     // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                      $pdf->SetCreator(PDF_CREATOR);  
                      $pdf->SetTitle("Report Tag Activation");  
                      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                      $pdf->SetDefaultMonospacedFont('helvetica');  
                      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                      $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                      $pdf->setPrintHeader(false);  
                      $pdf->setPrintFooter(false);  
                      $pdf->SetAutoPageBreak(TRUE, 10);  
                      $pdf->SetFont('helvetica', '', 12);
                      $pdf->AddPage();

                      $html='
                   <html lang="en">
                      <head>
                       <meta charset="utf-8">
                       <meta name="viewport" content="width=device-width, initial-scale=1">        
                       <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                       <title>Fastag</title>
                     </head>
                     <body style="font-family: \'Montserrat\';">  
                       <div class="container">                         
                         <table border="1" cellpadding="2" cellspacing="2" align="center">
                           <tr nobr="true">
                            <th colspan="8">Tag Activation Report ( '.date("d-m-Y", strtotime($startdate)).' TILL '.date("d-m-Y", strtotime($endt)).')</th>
                           </tr>
                           <thead>
                           <tr nobr="true">
                               <th>Sl No</th>
                               <th>Customer Name</th>
                               <th>Customer Id</th>
                               <th>Vehicle/ Chassis Number</th>
                               <th>Mobile Number</th>
                               <th>Bar Code</th>
                               <th>Date Of Activation</th>
                               <th>Time Of Activation</th>
                           </tr>
                           </thead>
                           <tbody>';

                            $data=[];
       
                            $enddate = date( 'Y-m-d', strtotime( $endt . ' +1 day' ) );

                            $rt = $startdate.' 00:00:00';
                            $rte = $enddate.' 00:00:00';

                            $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagenttype' =>1,'datetime >=' => $rt,'datetime <=' => $rte);
                            $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
       
                            $cnt= sizeof($data['customer']);
        
                            $j=0;
       						for($i=0;$i<$cnt;$i++){ 
                              $j++;
        
                                 $html.='<tr nobr="true">
                                            <td>'.$j.'</td>
                                            <td>'.$data['customer'][$i]["customername"].'</td>
                                            <td>'.$data['customer'][$i]["customerid"].'</td>
                                            <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                            <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                            <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                            <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                            <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                         </tr>';                              
                            }
       
                 $html.=' </tbody>
                          </table>

                         <p style="height: 30px;"></p>

                         <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                             <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                         </div>
                     </div>
                    </body>
                    </html>';

                      //$pdf->writeHTML($html);
                      $pdf->writeHTML($html, true, false, true, false, '');
                      $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
      }
  
  
  
  	  public function downloadreportlstwekext()
        {
              if ((!isset($_SESSION['oemid']))) {
                return redirect()->to(base_url('oemLogin'));            
              }

                        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //LANDSCAPE Mode
                       // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  //PORTRAIT Mode
                        $pdf->SetCreator(PDF_CREATOR);  
                        $pdf->SetTitle("Report Tag Activation");  
                        $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                        $pdf->SetDefaultMonospacedFont('helvetica');  
                        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                        $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                        $pdf->setPrintHeader(false);  
                        $pdf->setPrintFooter(false);  
                        $pdf->SetAutoPageBreak(TRUE, 10);  
                        $pdf->SetFont('helvetica', '', 12);
                        $pdf->AddPage();

                        $html='
                     <html lang="en">
                        <head>
                         <meta charset="utf-8">
                         <meta name="viewport" content="width=device-width, initial-scale=1">        
                         <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
                         <title>Fastag</title>
                       </head>
                       <body style="font-family: \'Montserrat\';">  
                         <div class="container">                         
                           <table border="1" cellpadding="2" cellspacing="2" align="center">
                             <tr nobr="true">
                              <th colspan="8">Tag Activation Report Last Week Report</th>
                             </tr>
                             <thead>
                             <tr nobr="true">
                                 <th>Sl No</th>
                                 <th>Customer Name</th>
                                 <th>Customer Id</th>
                                 <th>Vehicle/ Chassis Number</th>
                                 <th>Mobile Number</th>
                                 <th>Bar Code</th>
                                 <th>Date Of Activation</th>
                                 <th>Time Of Activation</th>
                             </tr>
                             </thead>
                             <tbody>';

                              $data=[];

                              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $_SESSION['oemid'] , 'salesagenttype' =>1);
                              $data['customer'] = $this->loginModel->viewspecificothh('tagactivationExistingUser','*',$array);

                              $cnt= sizeof($data['customer']);

                              $j=0;
                              for($i=0;$i<$cnt;$i++){ 
                                $j++;

                                   $html.='<tr nobr="true">
                                              <td>'.$j.'</td>
                                              <td>'.$data['customer'][$i]["customername"].'</td>
                                              <td>'.$data['customer'][$i]["customerid"].'</td>
                                              <td>'.$data['customer'][$i]["vehiclechasisnumber"].'</td>
                                              <td>'.$data['customer'][$i]["mobileNumber"].'</td>
                                              <td>'.$data['customer'][$i]["barcodeid"].'</td>
                                              <td>'.date("d-m-Y" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                              <td>'.date("h:i:sa" , strtotime($data['customer'][$i]["datetime"])).'</td>
                                           </tr>';                              
                              }

                   $html.=' </tbody>
                            </table>

                           <p style="height: 30px;"></p>

                           <div style="text-align: center;font-size: 10px;font-weight: 400;color: #696969;">
                               <span>*Downloaded on '.date("d-m-Y").' at '.date("h:i:s a").' .</span> <br>
                           </div>
                       </div>
                      </body>
                      </html>';

                        //$pdf->writeHTML($html);
                        $pdf->writeHTML($html, true, false, true, false, '');
                        $pdf->Output('Tag Activation Report '.date("d-m-Y h-i-s").'.pdf','D');
        }
  
}

?>