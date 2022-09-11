<?php

namespace App\Controllers;
use \App\Models\SalesAgentModel;
use \App\Models\TeamLeadModel;
use \App\Models\ProductModel;
use CodeIgniter\Cookie\Cookie;
use \App\Models\SalesManagerModel;
use \App\Models\SalesAgentWalletModel;

class SalesAgentController extends BaseController
{
    public $loginModel;
    public $teamleadmodel;
    public $productmodel;
    public $salesmanager;
    public $walletModel;

    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        helper('cookie');
        helper('payment');
        helper('fastag');
        $this->loginModel = new SalesAgentModel();
        $this->teamleadmodel = new TeamLeadModel();
        $this->productmodel = new ProductModel();
        $this->salesmanager = new SalesManagerModel();
        $this->walletModel = new SalesAgentWalletModel();
        $this->session = session();
        
    }

    public function addSalesAgent()
    {
        if ((!isset($_SESSION['teamleadId']))) {

            return redirect()->to(base_url('teamleadLogin'));
            
        }
        $data=[];
        $rules = [
            "fname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'First Name Is required ',
                ],
            ],
            "email"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Id Is required ',
                ],
            ],
            "lname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Last Name Is required ',
                ],
            ],
            "contctnumprim"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Primary Contact Number Is required ',
                ],
            ],
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "tollncity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll And City Is required ',
                ],
            ],
            "accntnum"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Account Number Is required ',
                ],
            ],
            "ifsccode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'IFSC Code Is required ',
                ],
            ],
            "bankname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bank Name Is required ',
                ],
            ],
            "aadhrnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Aadhar Number Is required ',
                ],
            ],
            
            "statedt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'State Is required ',
                ],
            ],
            "citydt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'City Is required ',
                ],
            ],
            "pincodedt"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Pincode Is required ',
                ],
            ],
            "addresslndt1"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Address Line 1 Is required ',
                ],
            ],
            "addresslndt2"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Address Line 2 Is required ',
                ],
            ],
            "addresslndt3"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Address Line 3 Is required ',
                ],
            ],
            
            "aadharproof"=>'uploaded[aadharproof]|max_size[aadharproof,1024]|ext_in[aadharproof,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
            "pannum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Number Is required ',
                ],
            ],
            "panproof"=>'uploaded[panproof]|max_size[panproof,1024]|ext_in[panproof,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
            "nomefname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee First Name Is required ',
                ],
            ],
            "nomelname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Last Name is required ',
                ],
            ],
            "reltnwthmngr"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Relationship With Sales Manager Is required ',
                ],
            ],
            "nomecntctnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Contact Number Is required ',
                ],
            ],
            "producttollcity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll And City Name Is required ',
                ],
            ],
            "productcode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Product Is required ',
                ],
            ],
            "nomeidproof"=>'uploaded[nomeidproof]|max_size[nomeidproof,1024]|ext_in[nomeidproof,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
        ];

        if($this->request->getMethod() == "post"){
            
            if($this->validate($rules)){
               
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $contctnumsec = $this->request->getVar('contctnumsec');
                $tollnme = $this->request->getVar('tollnme');
                
                
                $tollncity = $this->request->getVar('tollncity');
                
                
                $accntnum = $this->request->getVar('accntnum');
                $ifsccode = $this->request->getVar('ifsccode');
                $bankname = $this->request->getVar('bankname');
                $aadhrnum = $this->request->getVar('aadhrnum');
                $aadharproof = $this->request->getFile('aadharproof');
                $pannum = $this->request->getVar('pannum');
                $panproof = $this->request->getFile('panproof');
                $drivinglicence = $this->request->getVar('drivinglicence');
                
                $nomefname = $this->request->getVar('nomefname');
                $nomelname = $this->request->getVar('nomelname');
                $reltnwthmngr = $this->request->getVar('reltnwthmngr');
                $nomecntctnum = $this->request->getVar('nomecntctnum');
                $nomeidproof = $this->request->getFile('nomeidproof');
                $email = $this->request->getVar('email');
                
                
                $statedt = $this->request->getVar('statedt');
                $citydt = $this->request->getVar('citydt');
                $pincodedt = $this->request->getVar('pincodedt');
                $addresslndt1 = $this->request->getVar('addresslndt1');
                $addresslndt2 = $this->request->getVar('addresslndt2');
                $addresslndt3 = $this->request->getVar('addresslndt3');

                $profileimg = $this->request->getFile('profileimg');
              
                $where = 'ContactPrimary  = "'.$contctnumprim.'" OR salesagentmailid = "'.$email.'" OR ContactSecondary = "'.$contctnumprim.'"';
                $duplct = $this->salesmanager->chkduplcate('salesagent',$where);
                
                $where1 = 'panCardNumber  = "'.$pannum.'"';
                $duplct1 = $this->salesmanager->chkduplcate('kycdetails',$where1);
                
            if(sizeof($duplct) == 0 AND sizeof($duplct1) == 0){

                $rndid =  strtoupper(random_string('numeric', 6));
                $regdId = "SA-".$rndid;

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/salesagent/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = "default";
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/salesagent/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                            echo $nomeidproof->getErrorString()."".$nomeidproof->getError();
                    }
                }

                if($this->request->getFile('drivingproof')){
                  $rules = [
                       "drivingproof"=>'uploaded[drivingproof]|max_size[drivingproof,1024]|ext_in[drivingproof,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
                    ];
                  $drivingproof = $this->request->getFile('drivingproof');
                    if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                        $newdrivingproof = $drivingproof->getRandomName();
                        if($drivingproof->move(FCPATH.'public/adminasset/img/salesagent/drivinglicence/',$newdrivingproof)){                           
                                $drivinglicenceproof = $newdrivingproof;
                        }
                    }else{
                            $newdrivingproof="";
                    }
                }

                if($this->request->getFile('panproof')){
                    if($panproof->isValid() && !$panproof->hasMoved()){
                        $newpanproof = $panproof->getRandomName();
                        if($panproof->move(FCPATH.'public/adminasset/img/salesagent/pancard/',$newpanproof)){                           
                                $pancardproof = $newpanproof;
                        }
                    }else{
                            echo $panproof->getErrorString()."".$panproof->getError();
                    }
                }

                if($this->request->getFile('aadharproof')){
                    if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                        $newaadharproof = $aadharproof->getRandomName();
                        if($aadharproof->move(FCPATH.'public/adminasset/img/salesagent/aadharcard/',$newaadharproof)){                           
                                $aadharcardproof = $newaadharproof;
                        }
                    }else{
                            echo $aadharproof->getErrorString()."".$aadharproof->getError();
                    }  
                }                       
                            
                    $dtm = date("Y-m-d h:i:s");

                    /*----------------------------Bank Details--------------------------------*/

                    $databankdetails = ["bankName"=>$bankname,"accountNumber"=>$accntnum,"IFSCCode"=>$ifsccode,"userType"=>2,"bankkycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('bankdetails',$databankdetails);
                    $bankid = $this->loginModel->db->insertID();

                    /*----------------------------KYC Details--------------------------------*/
                    
                    $datakycdetails = ["aadharNumber"=>$aadhrnum,"panCardNumber"=>$pannum,"drivingLicenceNumber"=>$drivinglicence,"aadharProof"=>$newaadharproof,"panCardProof"=>$newpanproof,"drivingLicenceProof"=>$newdrivingproof,"userType"=>3,"kycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('kycdetails',$datakycdetails);
                    $kycid = $this->loginModel->db->insertID();
                    
                    /*----------------------------- Nominee Details---------------------------*/

                    $dataNominee = ["firstName"=>$nomefname,"lastName"=>$nomelname,"relationWith"=>$reltnwthmngr,"contactNumber"=>$nomecntctnum,"idProof"=>$newnomeidproof,"userType"=>3,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('nomeedetails',$dataNominee);
                    $nomineeid = $this->loginModel->db->insertID();
                    
                    $data = ["salesagentmailid"=>$email,"salesAgentRegdNum"=>$regdId,"Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"toll&city"=>$tollncity,"allowedIdCreation"=>0,"ProfileImage"=>$profileImage,"bankdetailsid"=>$bankid,"nomineedetailsid"=>$nomineeid,"kycdetailsid"=>$kycid,"otp"=>'0',"status"=>'2',"datetime"=>$dtm,"requestedById"=>$_SESSION["teamleadId"],"pincode"=>$pincodedt,"state"=>$statedt,"city"=>$citydt,"addressline1"=>$addresslndt1,"addressline2"=>$addresslndt2,"addressline3"=>$addresslndt3];
                    $loginData = $this->loginModel->loginDatainsert('salesagent',$data);
                    $uid = $this->loginModel->db->insertID(); 

                    $cnt = sizeof($this->request->getVar('producttollcity'));

                    for($tolnm=0;$tolnm < $cnt; $tolnm++ ){
                        $tll = $this->request->getVar('producttollcity')[$tolnm];
                        $dataTollval = ["user_id"=>$uid, "tollorcityname"=>$tll, "userType"=>3,"datetime"=>$dtm];
                        $loginData = $this->loginModel->loginDatainsert('tollandcitypermitted',$dataTollval);
                    }
                    

                    if($loginData){
                        $count = sizeof($this->request->getVar('productcode'));
                        for($prdcd = 0;$prdcd < $count; $prdcd++){
                            $prdd = $this->request->getVar('productcode')[$prdcd];
                            $dataNominee = ["productid"=>$prdd,"userId"=>$uid,"userType"=>3,"status"=>0,"datetime"=>$dtm];
                            $loginData = $this->loginModel->loginDatainsert('selectproduct',$dataNominee);
                        }

                        $to=$email;
                        $from="hitchpayments@gmail.com";
                        $subject="Welcome to Hitchpay";
                        $message="Hi Sales Agent, <br> You have been registerd successfully. <br> Your registeration id is ".$regdId." <br> Regards <br> Hitchpay";
                        sendEMail($to,$from,$subject,$message);

                        $this->session->setTempdata('success','Sales Agent Add Request Sent Successfully', 3);
                        return redirect()->to(base_url('teamlead/addsalesagent'));
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                        return redirect()->to(base_url('teamlead/addsalesagent'));
                    }  
              	}else{
                   $this->session->setTempdata('error','User Already Exists', 3);
                   return redirect()->to(base_url('teamlead/addsalesagent'));
               }
            }else{
                $data['validations'] = $this->validator;
            }
        }

            $data["teamlead"]=$this->teamleadmodel->showprofiledetails1($_SESSION['teamleadId']);
            $data["teamleadtoll"]=$this->teamleadmodel->tollcityshow($_SESSION['teamleadId'],2);
            $data["teamleadmanagerprd"]=$this->teamleadmodel->viewprdata($_SESSION['teamleadId'],2);
            return view('teamlead/addsalesagent',$data);
    }


    public function manageSalesAgent(){
        $data=[];


        if(isset($_SESSION['salesmanagerId'])){

            $data["salesagent"]=$this->loginModel->showSelectdAgent($_SESSION['salesmanagerId']);
        
            return view('salesmanager/managesalesagent',$data);

        }else if(isset($_SESSION['teamleadId'])){

            $data["salesagent"]=$this->loginModel->showSelectdTeamAgent($_SESSION['teamleadId']);

            return view('teamlead/managesalesagent',$data);

        }else{
            return redirect()->to(base_url());
        }        
    }

    public function index(){
        if ((isset($_SESSION['salesagentId']))) {
            return redirect()->to(base_url('salesagent/dashboard'));            
        }
        

        $data= [];
        $rules = [
            "userName"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Name Is Required',
                ],
            ],
            "Password"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Password Is Required',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                            
                    $userid = $this->request->getVar('userName');
                    $password = $this->request->getVar('Password');
                    $pass = md5(sha1(md5(sha1($password))));
                    $retrndata = $this->loginModel->verifyUserid($userid,0);
    
                if($retrndata){
                    $profileImage=$retrndata['image'];
                        
                    if($pass == $retrndata['password']){                      
    
                            if($retrndata['status'] == 0){
    
                                if (!empty($_SERVER['HTTP_CLIENT_IP']))
                                {
                                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                                }
                                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                                {
                                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                }
                                else
                                {
                                    $ip = $_SERVER['REMOTE_ADDR'];
                                }
    
                                $dtm = date("Y-m-d h:i:s");
                                $tm = time();
    
                                $data = ["user_ip_add"=>$ip,'user_type'=>$retrndata['admin_type'],'login_id'=>$retrndata['admin_id'],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];
                                
                                $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                                $lid = $this->loginModel->db->insertID();
    
                                $this->session->set('logged_usrid',$retrndata['userid']);
                                $this->session->set('logged_inid',$retrndata['admin_id']);
                                $this->session->set('logged_intype',$retrndata['admin_type']);
                                $this->session->set('login_data_id',$lid);
                                $this->session->set('logged_img',$profileImage);
    
                                $usrrData = $this->loginModel->showUserdata($retrndata['userid'],$retrndata['admin_id'],$retrndata['admin_type']);
                                $retrndata1 = $this->loginModel->lastLogin($retrndata['admin_id']);
    
                                if($retrndata1 == false){
                                    $lstLogin="";
                                }else{
                                    $lstLogin=$retrndata1['datetime_login'];
                                }
    
                                $this->session->set('usrName',$usrrData['name']);
                                $this->session->set('usrLastLogin',$lstLogin);
    
    
                                return redirect()->to(base_url().'/secure/dashboard');
    
    
                            }else{
                                $this->session->setTempdata('error','Your Account Has Been Locked ! Contact Support', 3);
                                return redirect()->to(current_url());
                            } 
    
                        }else{
                            $this->session->setTempdata('error','Invalid Password', 3);
                            return redirect()->to(current_url());
                        }
                    }else{
                        $this->session->setTempdata('error','Invalid User Id', 3);
                        return redirect()->to(current_url());
                    }
    
    
            }else{
                $data['validations'] = $this->validator;
            }
        }

        return view('salesagent/index',$data);
    }

    public function sendotp(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $userid = $this->request->getVar('usrid');
               $otp = random_string('numeric', 4);

                $retrndata = $this->loginModel->findSelect($userid);
                if($retrndata){

                    $table ='salesagent';
                    $upclnm ='salesagentId';
                    $updtdata = [
                        'otp'=>$otp,
                    ];
                    $updtid = $retrndata["salesagentId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                        $to=$retrndata["salesagentmailid"];
                        $subject="OTP For Your Login";
                        $message="Hi, Your requested OTP is ".$otp;
                        $from="connect@kottakotabusinesses.com";
                        $sndmail = sendEMail($to,$from,$subject,$message);
                    
                    
                        $response='
                            <div class="row form-group">
                            <div class="col-md-10">
                                    <label for="uname" class="text-primary">OTP</label>
                                    <input type="text" id="otp" name="otp" placeholder="OTP" class="form-control">
                                    <span class="errmsg"><span class="otperrmsg"></span></span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <button type="button" onclick="login();" class="btn btn-primary">Login</button>
                                </div>  
                                <div class="col-md-6"> <span style="float:right;color:red;font-size:13px;font-weight:700;"> OTP Send To Registered Mail Id <br> Please Also Check Your Spam Box </span> </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="sendOtp();" class="btn btn-info btn-sm">Resend Otp</button>
                                </div>
                            </div>';
                        

                }else{
                    $response='invalid';
                }

                echo $response;
                exit;
            }

            if($this->request->getVar('loginusrid')){
                $loginusrid = $this->request->getVar('loginusrid');
                $usrotp = $this->request->getVar('usrotp');

                $retrndata = $this->loginModel->findSelect($loginusrid);
                                
                if($retrndata){
                    if($retrndata["status"] == 0){
                        
                        if($usrotp == $retrndata["otp"]){

                            $tablee ='salesagent';
                            $updtide = $retrndata["salesagentId"];
                            $updtdatae = [
                                'otp'=>null,
                            ];
                            $upclnme = 'salesagentId';
                            $this->loginModel->entry_update($tablee,$upclnme,$updtdatae,$updtide);

                            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                            {
                                $ip = $_SERVER['HTTP_CLIENT_IP'];
                            }
                            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                            {
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                            }
                            else
                            {
                                $ip = $_SERVER['REMOTE_ADDR'];
                            }

                            $dtm = date("Y-m-d h:i:s");
                            $tm = time();

                            $data = ["user_ip_add"=>$ip,'user_type'=>3,'login_id'=>$retrndata['salesagentId'],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];
                            
                            $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                            $lid = $this->loginModel->db->insertID();
                            if($retrndata["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $retrndata["ProfileImage"]; }

                            $profileImage = $prf;
                          
                          	
                          
                            $this->session->set('salesagentId',$retrndata['salesagentId']);
                            $this->session->set('logged_intype',3);
                            $this->session->set('login_data_id',$lid);
                            $this->session->set('logged_img',$profileImage);
                            
                            $retrndata1 = $this->loginModel->lastLogin($retrndata['salesagentId']);

                            if($retrndata1 == false){
                                $lstLogin="";
                            }else{
                                $lstLogin=$retrndata1['datetime_login'];
                            }
                            $usrnmm = $retrndata["Fname"].' '.$retrndata["Lname"];
                            $this->session->set('usrName',$usrnmm);
                            $this->session->set('usrLastLogin',$lstLogin);


                            $response="done";

                        }else{
                            $response="invalidotp";
                        }
                    }else{
                        $response="blocked";
                    }
                }else{
                    $response='invalid';
                }

                echo $response;
                exit;
            }
            
        }

        return view('salesagent/index',$data);

    }

    public function adminAproval(){
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }

        $data=[];

        $data["salesagent"] = $this->loginModel->requestshow();
        
        
        return view('admin/approvesalesagent',$data);
    }
  
  
    public function salesManagerAproval(){
          if ((!isset($_SESSION['salesmanagerId']))) {

              return redirect()->to(base_url('salesmanagerLogin'));

          }

          $data=[];

          $data["salesagent"] = $this->loginModel->showSelectdAgent($_SESSION['salesmanagerId']);
     


          return view('salesmanager/approvesalesagent',$data);
      }

    public function manageSalesAgentAdmin(){
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        
        $data=[];
      $pending =[];

        $data["salesagent"]=$this->loginModel->showSelectd();
      
      $cnt = sizeof($data["salesagent"]);
      
      for($i=0; $i < $cnt; $i++){
        $sid = $data["salesagent"][$i]["salesagentId"];
        $walletdata = $this->walletModel->getWalletbalance($sid,1);
         $credit =0;
         $debit =0;
         $cntwlt = sizeof($walletdata);
         for($j=0;$j<$cntwlt;$j++){
            if($walletdata[$j]["transactiontype"] == 1 and $walletdata[$j]["transactionstatus"] == 2){
              $credit = $credit + $walletdata[$j]["amount"];
            }else if($walletdata[$j]["transactiontype"] == 2 and $walletdata[$j]["transactionstatus"] == 2){
              $debit = $debit + $walletdata[$j]["amount"];
            }
         }
        $pndng = $credit - $debit;
        $pending[] = $pndng;
      }
      $data["pending"] = $pending;
      

        return view('admin/managesalesagent',$data);
    }

    public function logout()
    {
        
        $dtm = date("Y-m-d h:i:s");
        if($this->session->has('salesagentId')){
            
            $table ='login_data';
            $updtid = session()->get('login_data_id');
            $updtdata = [
                'date_logout'=>$dtm,
            ];
            $upclnm = 'login_data_id';
            $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            session()->remove('salesagentId');
            session()->remove('logged_img');
            session()->remove('logged_intype');
            session()->remove('login_data_id');
            session()->remove('usrName');
            session()->remove('usrLastLogin');
        }
            return redirect()->to(base_url().'/salesagentLogin');
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="salesagent";
        $upclnm="salesagentId";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Sales Agent Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/managesalesagent')); 

            $data["salesagent"]=$this->loginModel->showSelectd();
        
            return view('admin/managesalesagent',$data);
    }
  
  public function updateStatus1($idd,$val){
        if ((!isset($_SESSION['salesmanagerId']))) {

              return redirect()->to(base_url('salesmanagerLogin'));

          }

        $data=[];

        $table="salesagent";
        $upclnm="salesagentId";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Sales Agent Status Updated Successfully', 3);
            return redirect()->to(base_url('salesmanager/approvesalesagent')); 

            $data["salesagent"]=$this->loginModel->showSelectd();
        
            return view('salesmanager/approvesalesagent',$data);
    }

    public function viewoemProfile($idd){

        $data= [];

        $data['salesagent'] = $this->loginModel->showprofiledetails($idd);    

        $data['salesmanagerPrd'] = $this->loginModel->viewprdata($idd);
        $data['salesreqst1'] = $this->loginModel->requestindvshow($idd);

        if(isset($_SESSION['salesmanagerId'])){
            return view('salesmanager/viewsalesagent',$data);
        }else if(isset($_SESSION['teamleadId'])){
            return view('teamlead/viewsalesagent',$data);
        }else if(isset($_SESSION['logged_usrid'])){
            return view('admin/viewsalesagent',$data);
        }
        
    }

    public function editProfileAdmin($idd){

        $data= [];

        $rules = [
            "fname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'First Name Is required ',
                ],
            ],
            "lname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Last Name Is required ',
                ],
            ],
          "productcode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Product Is required ',
                ],
            ],
            "contctnumprim"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Primary Contact Number Is required ',
                ],
            ],
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "emailid"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Id Is required ',
                ],
            ],
            "noidcrtn"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Number Of Id Creation Is required ',
                ],
            ],
            "toll&city"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll Or City Is required ',
                ],
            ],
            "accntnum"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Account Number Is required ',
                ],
            ],
            "ifsccode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'IFSC Code Is required ',
                ],
            ],
            "bankname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bank Name Is required ',
                ],
            ],
            "aadhrnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Aadhar Number Is required ',
                ],
            ],
            "pannum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Number Is required ',
                ],
            ],
            "drivinglicence"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Driving Licence Is required ',
                ],
            ],
            "nomefname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee First Name Is required ',
                ],
            ],
            "nomelname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Last Name is required ',
                ],
            ],
            "reltnwthmngr"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Relationship With Sales Manager Is required ',
                ],
            ],
            "nomecntctnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Contact Number Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $contctnumsec = $this->request->getVar('contctnumsec');
                $emailid = $this->request->getVar('emailid');
                $regnofsale = $this->request->getVar('regnofsale');

                $noidcrtn = $this->request->getVar('noidcrtn');
                $tollndcity = $this->request->getVar('toll&city');
                
                $accntnum = $this->request->getVar('accntnum');
                $ifsccode = $this->request->getVar('ifsccode');
                $bankname = $this->request->getVar('bankname');
                $aadhrnum = $this->request->getVar('aadhrnum');
                $aadharproof = $this->request->getFile('aadharproof');
                $pannum = $this->request->getVar('pannum');
                $panproof = $this->request->getFile('panproof');
                $drivinglicence = $this->request->getVar('drivinglicence');
                $drivingproof = $this->request->getFile('drivingproof');
                $nomefname = $this->request->getVar('nomefname');
                $nomelname = $this->request->getVar('nomelname');
                $reltnwthmngr = $this->request->getVar('reltnwthmngr');
                $nomecntctnum = $this->request->getVar('nomecntctnum');
                $nomeidproof = $this->request->getFile('nomeidproof');
                $profileimg = $this->request->getFile('profileimg');

                $alldata = $this->loginModel->showprofiledetails1($idd);
              $dtm = date("Y-m-d h:i:s");
              
              
                if($this->request->getVar('productcode')){
                  
                  $selectedproduct = $this->loginModel->viewprdata($idd);
                //    echo sizeof($selectedproduct);
                             $this->loginModel->deletef($idd);
                   $prdidd = $this->request->getVar('productcode');
                   $cntpid = sizeof($this->request->getVar('productcode'));
                  
                  for($pid=0;$pid < $cntpid;$pid++){
                    
                    $pdd = $prdidd[$pid];
                    $dataNominee = ["productid"=>$pdd,"userId"=>$idd,"userType"=>3,"status"=>0,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('selectproduct',$dataNominee);
                    
                  }

                }
                

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/salesagent/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = $alldata["ProfileImage"];
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/salesagent/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                                 $nomineeproof = $alldata["idProof"];
                    }
                }

                if($this->request->getFile('drivingproof')){
                    if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                        $newdrivingproof = $drivingproof->getRandomName();
                        if($drivingproof->move(FCPATH.'public/adminasset/img/salesagent/drivinglicence/',$newdrivingproof)){                           
                                $drivinglicenceproof = $newdrivingproof;
                        }
                    }else{
                                $drivinglicenceproof = $alldata["drivingLicenceProof"];
                    }
                }

                if($this->request->getFile('panproof')){
                    if($panproof->isValid() && !$panproof->hasMoved()){
                        $newpanproof = $panproof->getRandomName();
                        if($panproof->move(FCPATH.'public/adminasset/img/salesagent/pancard/',$newpanproof)){                           
                                $pancardproof = $newpanproof;
                        }
                    }else{
                                $pancardproof = $alldata["panCardProof"];
                    }
                }

                if($this->request->getFile('aadharproof')){
                    if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                        $newaadharproof = $aadharproof->getRandomName();
                        if($aadharproof->move(FCPATH.'public/adminasset/img/salesagent/aadharcard/',$newaadharproof)){                           
                                $aadharcardproof = $newaadharproof;
                        }
                    }else{
                                $aadharcardproof = $alldata["aadharProof"];
                    }  
                }                       
                            
                    

                    /*----------------------------Bank Details--------------------------------*/
                    $tablee="bankdetails";
                    $upclnm="bankDetailsId";
                    $updtid=$alldata["bankdetailsid"];
                    $updtdata = ["bankName"=>$bankname,"accountNumber"=>$accntnum,"IFSCCode"=>$ifsccode,"datetime"=>$dtm];
                    $bnkdtta = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);

                    /*----------------------------KYC Details--------------------------------*/
                    
                    $tablee="kycdetails";
                    $upclnm="kycdetailsid";
                    $updtid=$alldata["kycdetailsid"];
                    $updtdata = ["aadharNumber"=>$aadhrnum,"panCardNumber"=>$pannum,"drivingLicenceNumber"=>$drivinglicence,"aadharProof"=>$aadharcardproof,"panCardProof"=>$pancardproof,"drivingLicenceProof"=>$drivinglicenceproof,"datetime"=>$dtm];
                    $kycdtta = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    
                    /*----------------------------- Nominee Details---------------------------*/
                    $tablee="nomeedetails";
                    $upclnm="nameeDetailsId";
                    $updtid=$alldata["nomineedetailsid"];
                    $updtdata = ["firstName"=>$nomefname,"lastName"=>$nomelname,"relationWith"=>$reltnwthmngr,"contactNumber"=>$nomecntctnum,"idProof"=>$nomineeproof,"datetime"=>$dtm];
                    $nomineedtta = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);

                    $tablee="salesagent";
                    $upclnm="salesagentId";
                    $updtid=$alldata["salesagentId"];
                    $updtdata = ["salesagentmailid"=>$emailid,"toll&city"=>$tollndcity,"allowedIdCreation"=>$noidcrtn,"Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"region"=>$regnofsale,"ProfileImage"=>$profileImage,"datetime"=>$dtm];
                    $salesagent = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    

                        $this->session->setTempdata('success','Sales Agent Profile Updated Successfully', 3);
                        return redirect()->to(base_url('secure/editsalesagent/'.$alldata["salesagentId"].''));
                    

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['editprofileData'] = $this->loginModel->showprofiledetails($idd); 
        $data['selectedproduct'] = $this->loginModel->viewprdata($idd);
        $data['product'] = $this->loginModel->viewspecific('product','*','status',0);
        
        return view('admin/editsalesagent',$data);

    }

    public function ncpitag(){

        $data= [];
        $rules = [
            "vehicleNumber"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Vehicle Registration Number Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $vehicleNumber = $this->request->getVar('vehicleNumber');
                    $data['npceiresponse'] = npcei($vehicleNumber);  
              
            }else{
                $data['validations'] = $this->validator;
            }
        }

        return view('salesagent/ncpitag',$data);
    }

    public function fastagInventory(){
        if ((!isset($_SESSION['salesagentId']))) {
            return redirect()->to(base_url('salesagentLogin'));            
        }

        $data= [];        

        $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesagentId'],3);     
        
        return view('salesagent/fastag',$data);

    }

    public function stats(){

             $orderId = $this->request->getVar('orderId');
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
                
            }

        $data =[];
        $salesagentdetails = $this->loginModel->getSalesagent($orderId);
        $retrndata1 = $this->loginModel->lastLogin($salesagentdetails[0]['salesagentId']);
        if($salesagentdetails[0]["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $salesagentdetails[0]["ProfileImage"]; }

        $profileImage = $prf;
        $this->session->set('salesagentId',$salesagentdetails[0]['salesagentId']);
        $this->session->set('logged_intype',3);
        $this->session->set('login_data_id',$retrndata1['login_data_id']);
        $this->session->set('logged_img',$profileImage);
        $this->session->set('setTagactivationId',$orderId);

        if($retrndata1 == false){
            $lstLogin="";
        }else{
            $lstLogin=$retrndata1['datetime_login'];
        }

        $usrnmm = $salesagentdetails[0]["Fname"].' '.$salesagentdetails[0]["Lname"];
        $this->session->set('usrName',$usrnmm);
        $this->session->set('usrLastLogin',$lstLogin);
        return view('salesagent/paymentstatus',$data);
    }
  
  
/*---------------------------------  Tag Activation New User ------------------------------*/
  
  
    public function tagActivation(){
        if ((!isset($_SESSION['salesagentId']))) {
            return redirect()->to(base_url('salesagentLogin'));            
        }
      
      
        $data= []; 
      
      
        if($this->request->getMethod() == "post"){

            if($this->request->getVar('barcodetype')){
                $barcodetyp = $this->request->getVar('barcodetype');
                if($barcodetyp == "VC20"){
                    $response='
                            <div class="col-sm-2"> Type </div>
                            <div class="col-sm-10">
                                <select class="form-control" name="typee" id="typee" style="width:50%;">
                                    <option value="Commercial"> Commercial </option>
                                </select>
                            </div>';
                }else if($barcodetyp == "VC4"){
                    $response='
                            <div class="col-sm-2"> Type </div>
                            <div class="col-sm-10">
                                <select class="form-control" name="typee" id="typee" style="width:50%;">
                                    <option value="Non-Commercial"> Non-Commercial </option>
                                    <option value="Commercial"> Commercial </option>
                                </select>
                            </div>';
                }                

                echo $response;
                exit;
            }
          
          

            if($this->request->getVar('shwclssTag')){
                
                $data['tgg'] = $this->loginModel->snglprddtls($this->request->getVar('shwclssTag'));

                $shwclssTag = $this->request->getVar('shwclssTag');
                $table="classofbarcode";
                $viewdata="*";
                $whrclm="fastagclass";
                $whrval=$data["tgg"][0]["fastagClass"];
                $data["barcodeclss"] = $this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
                
                $cnt = count($data["barcodeclss"]);
                
                $response='
                            <label class="col-sm-2 col-form-label"> Fastag Class <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="fstagclss" id="fstagclss" Placeholder="Fastag Class" readonly="readonly" value="'.$data["tgg"][0]["fastagClass"].'" class="form-control mg-b-10" style="max-width:50%;">                                
                                <span id="fstgcls" class="errmsg" style="float:none;"></span>
                                </div>
                            <label class="col-sm-2 col-form-label">Class Of Barcode</label>
                            <div class="col-sm-10 sgt">                            
                                <select class="form-control" name="barcodetyp" id="barcodetyp" style="width:50%;" onchange="shwsome(this.value);">
                                    <option value="">Select Class Of Barcode</option>';
                                    
                                        for($i=0;$i < $cnt; $i++){
                                            $response.='<option value="'.$data["barcodeclss"][$i]["classofbarcode"].'"> '.$data["barcodeclss"][$i]["classofbarcode"].' </option>';                                
                                        }
                    $response.='</select>
                                <span class="errmsg clstg1" style="text-align:left;"></span>
                                <span id="clsbrcd" class="errmsg" style="float:none;"></span>
                            </div>
                            <div id="ss" class="row" style="float:left;width:100%;margin-left:0px;margin-bottom:10px !important;"></div>                          
                            <label class="col-sm-2 col-form-label"> Customer Name <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="custname" id="custname" Placeholder="Customer Name" class="form-control mg-b-10" style="max-width:50%;">   
                                <span id="cusnm" class="errmsg" style="float:none;"></span>                             
                            </div>
                            <label class="col-sm-2 col-form-label"> Customer Contact Number <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" onkeypress="if(this.value.length == 10){ return false; }" name="mobilenumber" id="mobilenumber" Placeholder="Contact Number" class="form-control mg-b-10" style="max-width:50%;">                                
                                <span id="mobnum" class="errmsg" style="float:none;"></span>
                                </div>
                                
                            <label class="col-sm-2 col-form-label"> Vehicle Data Type <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control mg-b-10" style="max-width:50%;" name="vehicleidtype" id="vehicleidtype">
                                    <option value="1"> Vehicle Number </option>
                                    <option value="2"> Chassis Number </option>
                                </select>
                                <span id="vehicleidtyp" class="errmsg" style="float:none;"></span>
                            </div>  
                            <label class="col-sm-2 col-form-label"> Vehicle Number / Chassis Number <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" style="text-transform:uppercase;max-width:50%;" name="vehiclenumber" id="vehiclenumber" Placeholder="Vehicle Number / Chassis Number" class="form-control mg-b-10" style="max-width:50%;">                                
                                <span id="vehclnm" class="errmsg" style="float:none;"></span>
                            </div>  
                            <label class="col-sm-2 col-form-label"> PAN Card Number <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" style="text-transform:uppercase;max-width:50%;" name="pancardnum" id="pancardnum" Placeholder="PAN Card Number" class="form-control mg-b-10" style="max-width:50%;">     
                                <span id="pannum" class="errmsg" style="float:none;"></span>                           
                            </div>  
                            <label class="col-sm-2 col-form-label"> Driving Licence <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" style="text-transform:uppercase;max-width:50%;" name="rcbok" id="rcbok" Placeholder="Driving Licence" class="form-control mg-b-10" style="max-width:50%;">     
                                <span id="rcbook" class="errmsg" style="float:none;"></span>                           
                            </div>
                            <label class="col-sm-2 col-form-label"> RC Book Image <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" style="text-transform:uppercase;max-width:50%;" name="drivinglicence" id="drivinglicence" title="RC Book Image" class="form-control mg-b-10" style="max-width:50%;">     
                                <span id="drvlcnc" class="errmsg" style="float:none;"></span>                           
                            </div>
                            <label class="col-sm-2 col-form-label"> Date Of Birth <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="date" style="text-transform:uppercase;max-width:50%;" name="dob" id="dob" Placeholder="Date Of Birth" class="form-control mg-b-10" style="max-width:50%;">     
                                <span id="dbo" class="errmsg" style="float:none;"></span>                           
                            </div>
                            <div class="col-md-12">                                            
                                <input type="button" class="btn btn-main-primary" id="submit_frm" style="width:10%;" value="Make Payment">
                            </div>
                ';               

                echo $response;
                exit;
            }
          
          

            if($this->request->getVar('fstagclss')){

                $fstagclsssub = $this->request->getVar('fstagclss');
                $barcodetypsub = $this->request->getVar('barcodetyp');
                $custnamesub = $this->request->getVar('custname');
                $mobilenumbersub = $this->request->getVar('mobilenumber');
                $vehiclenumbersub = $this->request->getVar('vehiclenumber');
                $pancardnumsub = $this->request->getVar('pancardnum');
                $typee = $this->request->getVar('typee');
                $prd = $this->request->getVar('prd');
              $vehicleidtype = $this->request->getVar('vehicleidtype');
                $dtm = date('Y-m-d h:i:s');
              $dob = $this->request->getVar('dob');
              $rcbok = $this->request->getVar('rcbok');
                //$postdata = array("custnamesub"=>$custnamesub, "mobilenumbersub"=>$mobilenumbersub, "vehiclenumbersub"=>$vehiclenumbersub, "pancardnumsub"=>$pancardnumsub);
                

                $fstg = $this->loginModel->viewspecific('product','fastagprice','productid',$prd); 
                $salesagentdetails = $this->loginModel->viewspecific('salesagent','salesagentmailid','salesagentId',$_SESSION['salesagentId']);
                $orderId = time();
                $orderAmount = $fstg[0]['fastagprice']; 
                $purchasenote = 'Tag Purchase For Vehicle'.$vehiclenumbersub;
              
                //--------------------- Driving Licence Upload ----------------------------------------//
              
              	$drivinglicence = $this->request->getFile('drivinglicence');
                if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
                  $newdrivinglicence = $drivinglicence->getRandomName();
                  if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
                       $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
                  }
                }
                
                $databankdetails = ["productid"=>$prd,"classofBarcode"=>$barcodetypsub,"vehicleType"=>$typee,"rcbook"=>$rcbok,"mobileNumber"=>$mobilenumbersub,"drivingLicence"=>$drivinglicencedat,"vehicleNumbertype"=>$vehicleidtype,"vehiclechasisnumber"=>strtoupper($vehiclenumbersub),"salesagentId"=>$_SESSION['salesagentId'],"transactionstatus"=>1,"transactionid"=>$orderId,"datetime"=>$dtm,"pancarddetails"=>strtoupper($pancardnumsub),"customername"=>$custnamesub,"dateofbirth"=>$dob];
                $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$databankdetails);
                $bankid = $this->loginModel->db->insertID();  
                $this->session->set('setTagactivationId',$orderId); 
                $this->session->set('paymentstatus','failed');        
                
                    $salesmailid = $salesagentdetails[0]['salesagentmailid'];
                    $returnurl=base_url().'/salesagent/paymentstatus';
                    $notifyurl=base_url().'/salesagent/paymentstatus';
               
              $postdata = array("appId"=>'19350339ee25ac9bdf7c97d3f6305391', "orderId"=>$orderId, "orderAmount"=>$orderAmount, "orderCurrency"=>'INR', "orderNote"=>$purchasenote, "customerName"=>$custnamesub, "customerPhone"=>$mobilenumbersub, "customerEmail"=>$salesmailid, "returnUrl"=>$returnurl, "notifyUrl"=>$notifyurl);
                $signature = generateSignature($postdata);

                    echo makePayment($orderId,$orderAmount,$purchasenote,$salesmailid,$custnamesub,$mobilenumbersub,$returnurl,$signature,$notifyurl);
                    exit;

            }
          
          

            if($this->request->getVar('edttid')){

                $salesagentdetails = $this->loginModel->viewspecific('tagactivationinitial','*','initialId',$this->request->getVar('edttid'));

                $response='
                  <div class="col-md-12">
                    <form action ="<?= base_url(); ?>/teamlead/addsalesagent" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name<span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="fname" id="fname" value="'.$salesagentdetails[0]['customername'].'" Placeholder="Name" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg" id="errmsg1" style="text-align:left;"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="Contact Number" id="contc" value="'.$salesagentdetails[0]['mobileNumber'].'" Placeholder="Contact Number" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg" id="errmsg2" style="text-align:left;"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">PAN Card Details<span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="hidden" value="'.$this->request->getVar('edttid').'" name="editidd">
                                <input type="text" name="contctnumsec" value="'.$salesagentdetails[0]['pancarddetails'].'" id="pncdr" Placeholder="PAN Card Details" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg" id="errmsg3" style="text-align:left;"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="button" class="btn btn-info btn-md" onclick="updt(\''.$this->request->getVar('edttid').'\');"> UPDATE </button>
                        </div>
                    </form>
                   </div>';



                echo $response;
                exit;

            }
          
          
          

            if($this->request->getVar('editiddd')){
                $editiddd = $this->request->getVar('editiddd');
                $nammee = $this->request->getVar('nammee');
                $contctnum = $this->request->getVar('contctnum');
                $pncdr = $this->request->getVar('pncdr');

                $table ='tagactivationinitial';
                $upclnm ='initialId';
                $updtdata = [
                    'customername'=>$nammee,
                    'mobileNumber'=>$contctnum,
                    'pancarddetails'=>$pncdr,
                ];
                $updtid = $editiddd;
                $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            }
          
          
          

            if($this->request->getVar('checkPayment')){               

               $orderId =  $_SESSION["setTagactivationId"];
               $salesagentid = $_SESSION['salesagentId'];

               $trnsdtl = $this->loginModel->multiSrch('tagactivationinitial','*','transactionid',$orderId,'salesagentId',$salesagentid);
               if($trnsdtl[0]['transactionstatus'] == 1){
                    $response='Failed';
               }else if($trnsdtl[0]['transactionstatus'] == 0){
                    $response='reload';
               }                    

               echo $response;
              
               exit;
            }
          
          

            if($this->request->getVar('contactSndotp')){
                $contactSndotp = $this->request->getVar('contactSndotp');
                $data['otpdata'] = GenerateOTP($contactSndotp,time());
                
                $data1 = json_decode($data['otpdata'])[0];
                $array = json_decode(json_encode($data1), true);

                if($array['RESPONSECODE'] == 00){
                    $table ='tagactivationinitial';
                    $upclnm ='transactionid';
                    $updtdata = [
                        'orgreqid'=>$array['ORGREQID'],
                    ];
                    $updtid = $_SESSION["setTagactivationId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                }
            }
          
          
          

            if($this->request->getVar('ottpdata')){

                $salesagentdetails = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$_SESSION["setTagactivationId"]);

                $ottpdata = $this->request->getVar('ottpdata');
                $otpmobile = $salesagentdetails[0]['mobileNumber'];
                $orgreqid = $salesagentdetails[0]['orgreqid'];
                $reqid = time();

                $data['otpverify'] = OTPVerify($reqid,$otpmobile,$ottpdata,$orgreqid);
              
                $data1 = json_decode($data['otpverify'])[0];
                $array = json_decode(json_encode($data1), true);
              
              

                if($array['RESPONSECODE'] == 00){
                  
                    $salesagentdetails = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$_SESSION["setTagactivationId"]);
                    $salesgnt = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION["salesagentId"]);

                    $ddob = date("Y/m/d", strtotime($salesagentdetails[0]['dateofbirth']));

                    $pincode = $salesgnt[0]['pincode'];

                    $otpmobile = $salesagentdetails[0]['mobileNumber'];
                    $orgreqid = $salesagentdetails[0]['orgreqid'];
                    $name = $salesagentdetails[0]['customername'];
                    $pancarddetails = strtolower($salesagentdetails[0]['pancarddetails']);

                    $data['customerverification'] = VerifyNSDLCustomer(time(),$otpmobile,$orgreqid,$name,$pancarddetails,$ddob);
                 
                    $data1 = json_decode($data['customerverification'])[0];
                    $array = json_decode(json_encode($data1), true);

                    $customersubtype = $array['CUSTOMERSUBTYPE'];

                    if($array['RESPONSECODE'] == 00){

                        $table ='tagactivationinitial';
                        $upclnm ='transactionid';
                        $updtdata = [
                            'crnnumber'=>$array['CRN'],
                            'tokennumber'=>$array['TOKENNO'],
                        ];
                        $updtid = $_SESSION["setTagactivationId"];
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                        $data['datastatecity'] = GetStateCity(time(),$pincode);

                        $data2 = json_decode($data['datastatecity'])[0];
                        $array1 = json_decode(json_encode($data2), true);

                        $sateid = $array1['STATEID'];
                        $statename = $array1['STATENAME'];
                        $cityid = $array1['CITYID'];
                        $cityname = $array1['CITYNAME'];
                        $regionid = $array1['REGIONID'];
                        $regionname = $array1['REGIONNAME'];
                        $countryname = $array1['COUNTRYNAME'];

                        $gender = 1;
                        $ddress1="Odisha";
                        $address2="Odisha";
                        $address3="Odisha";
                        $addressproofnumber= $salesagentdetails[0]['rcbook'];
                        $addressprooftype= 2;

                       $data["walletcreated"] = WalletCreation(time(),$array['TOKENNO'],$orgreqid,$customersubtype,$array['CRN'],$otpmobile,$pancarddetails,$name,$ddob,$gender,$ddress1,$address2,$address3,$pincode,$regionid,$sateid,$cityid,$regionname,$statename,$cityname,$addressproofnumber,$addressprooftype);
                      
                       $data2 = json_decode($data['walletcreated'])[0];
                       $array2 = json_decode(json_encode($data2), true);

                        $table ='tagactivationinitial';
                        $upclnm ='transactionid';
                        $updtdata = [
                            'customerid'=>$array2['CUSTOMERID'],
                        ];
                        $updtid = $_SESSION["setTagactivationId"];
                        $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                        if($array2['RESPONSECODE'] == 00){
                            $data["customerVerification"] = VerifyCustomer($otpmobile);
                          
                            $data2 = json_decode($data['customerVerification'])[0];
                            $array2 = json_decode(json_encode($data2), true);
                            $agentype = $array2['AGENTTYPE'];

                            $table ='tagactivationinitial';
                            $upclnm ='transactionid';
                            $updtdata = [
                                'agenttype'=>$array2['AGENTTYPE'],
                            ];
                            $updtid = $_SESSION["setTagactivationId"];
                            $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                            $this->session->setTempdata('success',$array2['STATUS'], 3);
                        }else{
                           $this->session->setTempdata('error','Try Again Later', 3);
                        }

                    }else if($array['RESPONSECODE'] == 01){
                        $this->session->setTempdata('error',$array['STATUS'], 3);
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Process Your Request', 3);
                    }
                }
              
                
            }

            if($this->request->getVar('dob')){

                $rules = [
                    "dob"=>[
                        'rules'=>'required',
                        'errors'=>[
                            'required'=>'Date Of Birth Is Required',
                        ],
                    ],
                ];
                if($this->request->getMethod() == "post"){
                    if($this->validate($rules)){
                        $vehicleNumber = $this->request->getVar('vehicleNumber');
                            $data['npceiresponse'] = npcei($vehicleNumber);                    
                    }else{
                        $data['validations'] = $this->validator;
                    }
                }

            }
          
          
          if($this->request->getVar('barcode')){
            
             $barcode = $this->request->getVar('barcode');
            
            
                $orderId =  $_SESSION["setTagactivationId"];
                $salesagentid = $_SESSION['salesagentId'];

                $dtta = $this->loginModel->multiSrch('tagactivationinitial','*','transactionid',$orderId,'salesagentId',$salesagentid);
              
              //echo $dtta[0]["drivingLicence"];
            
              if($dtta[0]["vehicleType"] == "Non-Commercial"){
                $typecmmrcl =2;
              }else{
                $typecmmrcl =1;
              }
            
            
              $tnid = time();
              $mobnum = $dtta[0]["mobileNumber"];
              $custmrid = $dtta[0]["customerid"];
              $vehclclss = 4;
              $vehclnum = $dtta[0]["vehiclechasisnumber"];
              $commercialtype = $typecmmrcl;            
              $vehiclenumbertype = $dtta[0]["vehicleNumbertype"];            
              $minamnt = "100.00";
              $depositeamnt = "50.00";
              $cardcost = "100.00";
              $totalcost = "250.00";
              $barcode = $barcode;
              $agentype = $dtta[0]["agenttype"];
            
             $img_file = $dtta[0]["drivingLicence"];
             $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($img_file));
             
              $data["vehicleData"] = addVehicle($tnid,$mobnum,$custmrid,$vehclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
            
              $data2 = json_decode($data['vehicleData'])[0];
                $array2 = json_decode(json_encode($data2), true);
                
                if($array2['RESPONSECODE'] == 00 && $array2['ERRORCODE'] != 1){
                  
                    
                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                        'barcodeid'=>$barcode,
                    ];
                    $updtid = $idd;
                  
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                  
                    $this->session->setTempdata('success',$array2['STATUS'], 3);
                  
                }else if($array2['ERRORCODE'] == 1){
                  
                    $this->session->setTempdata('error',$array2['RESULT'], 3);
                  
                }else{
                  
                    $this->session->setTempdata('error',$array2['STATUS'], 3);
                }
            
              return redirect()->to(base_url('salesagent/tagactivation'));
            
          }

            if($this->request->getVar('ddob')){

                //$ddob = date("Y/m/d", strtotime($this->request->getVar('ddob')));
              

                $salesagentdetails = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$_SESSION["setTagactivationId"]);
                $salesgnt = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION["salesagentId"]);
              
              	$ddob = date("Y/m/d", strtotime($salesagentdetails[0]['dateofbirth']));

                $pincode = $salesgnt[0]['pincode'];

                $otpmobile = $salesagentdetails[0]['mobileNumber'];
                $orgreqid = $salesagentdetails[0]['orgreqid'];
                $name = $salesagentdetails[0]['customername'];
                $pancarddetails = strtolower($salesagentdetails[0]['pancarddetails']);

                $data['customerverification'] = VerifyNSDLCustomer(time(),$otpmobile,$orgreqid,$name,$pancarddetails,$ddob);
                $data1 = json_decode($data['customerverification'])[0];
                $array = json_decode(json_encode($data1), true);

                $customersubtype = $array['CUSTOMERSUBTYPE'];

                if($array['RESPONSECODE'] == 00){
                    
                    $table ='tagactivationinitial';
                    $upclnm ='transactionid';
                    $updtdata = [
                        'crnnumber'=>$array['CRN'],
                        'tokennumber'=>$array['TOKENNO'],
                    ];
                    $updtid = $_SESSION["setTagactivationId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                    $data['datastatecity'] = GetStateCity(time(),$pincode);
                  
                    $data2 = json_decode($data['datastatecity'])[0];
                    $array1 = json_decode(json_encode($data2), true);

                    $sateid = $array1['STATEID'];
                    $statename = $array1['STATENAME'];
                    $cityid = $array1['CITYID'];
                    $cityname = $array1['CITYNAME'];
                    $regionid = $array1['REGIONID'];
                    $regionname = $array1['REGIONNAME'];
                    $countryname = $array1['COUNTRYNAME'];

                    $gender = 1;
                    $ddress1="Odisha";
                    $address2="Odisha";
                    $address3="Odisha";
                    $addressproofnumber="";

                   $data["walletcreated"] = WalletCreation(time(),$array['TOKENNO'],$orgreqid,$customersubtype,$array['CRN'],$otpmobile,$pancarddetails,$name,$ddob,$gender,$ddress1,$address2,$address3,$pincode,$regionid,$sateid,$cityid,$regionname,$statename,$cityname,$addressproofnumber);
                   $data2 = json_decode($data['walletcreated'])[0];
                   $array2 = json_decode(json_encode($data2), true);

                    $table ='tagactivationinitial';
                    $upclnm ='transactionid';
                    $updtdata = [
                        'customerid'=>$array2['CUSTOMERID'],
                    ];
                    $updtid = $_SESSION["setTagactivationId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                    if($array2['RESPONSECODE'] == 00){
                        $data["customerVerification"] = VerifyCustomer($otpmobile);
                        $data2 = json_decode($data['customerVerification'])[0];
                        $array2 = json_decode(json_encode($data2), true);
                        $agentype = $array2['AGENTTYPE'];
                      
                      $table ='tagactivationinitial';
                      $upclnm ='transactionid';
                      $updtdata = [
                          'agenttype'=>$array2['AGENTTYPE'],
                      ];
                      $updtid = $_SESSION["setTagactivationId"];
                      $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                      
                        echo "done";
                        exit;
                    }else{
                        echo"notdone";
                        exit;
                    }
                    
                }else if($array['RESPONSECODE'] == 01){
                    echo'invalidpan';
                    exit;
                }else{
                    echo'Sorry';
                    exit;
                }                
            }
        }

           
        if(isset($_SESSION["setTagactivationId"]) && $_SESSION['paymentstatus'] == "success"){
            $orderId =  $_SESSION["setTagactivationId"];
            $salesagentid = $_SESSION['salesagentId'];

            $data['somedata'] = $this->loginModel->multiSrch('tagactivationinitial','*','transactionid',$orderId,'salesagentId',$salesagentid);
        }    

        $data['tagclass'] = $this->productmodel->distinctVal("fasttag","classoftag");
        $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
          $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
        
        return view('salesagent/tagactivation',$data);
    }
  
  
  
  
  
  /*------------------------------------------ Alloting tag to new user ------------------------------- */    
    public function activatepending()
    {
        if ((!isset($_SESSION['salesagentId']))) {
            return redirect()->to(base_url('salesagentLogin'));            
        }
      
           $data =[];
          
      
           $data["teamleadmanagerprd"]=$this->teamleadmodel->createdCust($_SESSION['salesagentId']);
      
           $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
      
           return view('salesagent/activatependingtag',$data);
    }
  
  

  
    public function allotTags($idd)
      {
          if ((!isset($_SESSION['salesagentId']))) {
              return redirect()->to(base_url('salesagentLogin'));            
          }
      		

             $data =[];
             $data['somedata'] = $this->loginModel->multiSrch('tagactivationinitial','*','initialId',$idd,'salesagentId',$_SESSION['salesagentId']);
      
      
              if($this->request->getMethod() == "post"){

                    $barcode = $this->request->getVar('barcode');
                
                
                
                if($data['somedata'][0]["vehicleType"] == "Non-Commercial"){
                  $typecmmrcl =1;
                }else{
                  $typecmmrcl =2;
                }
                
                $tnid = time();
                $mobnum = $data['somedata'][0]["mobileNumber"];
                $custmrid = $data['somedata'][0]["customerid"];
                $vehclclss = 4;
                $vehclnum = $data['somedata'][0]["vehiclechasisnumber"];
                $commercialtype = $typecmmrcl;            
                $vehiclenumbertype = $data['somedata'][0]["vehicleNumbertype"];            
                $minamnt = "100.00";
                $depositeamnt = "50.00";
                $cardcost = "100.00";
                $totalcost = "250.00";
                $barcode = $barcode;
                $agentype = $data['somedata'][0]["agenttype"];
                

                $img_file = $data['somedata'][0]["drivingLicence"];
                $rcb = base64_encode(file_get_contents($img_file));
                $rcb = "data:image/png;base64,".$rcb;
                

                $data["vehicleData"] = addVehicle($tnid,$mobnum,$custmrid,$vehclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcb);                
                
                $data2 = json_decode($data['vehicleData'])[0];
                $array2 = json_decode(json_encode($data2), true);
                
                if($array2['RESPONSECODE'] == 00 && $array2['ERRORCODE'] != 1){
                  
                    
                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                        'barcodeid'=>$barcode,
                    ];
                    $updtid = $idd;
                  
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                  
                    $this->session->setTempdata('success',$array2['STATUS'], 3);
                  
                }else if($array2['ERRORCODE'] == 1){
                  
                    $this->session->setTempdata('error',$array2['RESULT'], 3);
                  
                }else{
                  
                    $this->session->setTempdata('error',$array2['STATUS'], 3);
                }         
                
                   
                    
              }

             
             $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);

             return view('salesagent/allotpendingtag',$data);
      }
  
  
  
  /*-------------------------------------   Alloting the fastag to the existing -----------------------------*/
  
  
  
    public function activateexisting()
      {
          if ((!isset($_SESSION['salesagentId']))) {
              return redirect()->to(base_url('salesagentLogin'));            
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
                            <strong> Class Of Vehicle </strong>                            
                                <select class="form-control" name="barcodetyp" id="barcodetyp" onchange="shwsome(this.value);">
                                    <option value="">Select Class Of Vehicle</option>';
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
                                      <select class="form-control" name="typee" id="typee">
                                          <option value="Commercial"> Commercial </option>
                                      </select>
                                   </td>';
                      }else if($barcodetyp == "VC4"){
                          $response='
                                  <td>
                                      <strong> Type </strong>
                                      <select class="form-control" name="typee" id="typee">
                                          <option value="Non-Commercial"> Non-Commercial </option>
                                          <option value="Commercial"> Commercial </option>
                                      </select>
                                   </td>';
                      }else{
                          $response='
                                  <td>
                                      <strong> Type </strong>
                                      <select class="form-control" name="typee" id="typee">
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
                   $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
         		   $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
                   $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
                   $data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
             return view('salesagent/activateexisting',$data);
      }
  
  
      public function activateexistingUsers()
      {
          if ((!isset($_SESSION['salesagentId']))) {
              return redirect()->to(base_url('salesagentLogin'));            
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
                    $salesagentdetails = $this->loginModel->viewspecific('salesagent','salesagentmailid','salesagentId',$_SESSION['salesagentId']);
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
                    
                    $databankdetails = ["productid"=>$prd,"classofBarcode" =>$barcodetyp,"vehicleType" =>$typee,"customername" =>$custnme,"mobileNumber" =>$custnum,"rcbook" =>$drivinglicencedat,"vehicleNumbertype" =>$vehicleidtype,"vehiclechasisnumber" =>$vehiclenumber,"salesagentId" =>$_SESSION['salesagentId'],"customerid" =>$custid,"agenttype" =>$agntp,"barcodeid" =>$barcode,"transactionstatus" =>1,"transactionid" =>$ordrid,"datetime" =>$dtm,"salesagentType" =>0];
                
                $loginData = $this->loginModel->loginDatainsert('tagactivationExistingUser',$databankdetails);                
                $bankid = $this->loginModel->db->insertID();  
                
                
                    
              	if($typee == "Non-Commercial"){
                  $typecmmrcl =2;
                }else{
                  $typecmmrcl =1;
                }

                if($barcodetyp == "VC4"){
                  $vclclss = 4;
                }else if($barcodetyp == "VC20"){
                  $vclclss = 20;
                }else{
                  $vclclss = 4;
                }

                $tnid = $ordrid;
                $mobnum = $custnum;
                $custname = $custnme;
                $custmrid = $custid;
                $vehclclss = $vclclss;
                $vehclnum = $vehiclenumber;
                $commercialtype = $typecmmrcl;            
                $vehiclenumbertype = $vehicleidtype;            
                $minamnt = "100.00";
                $depositeamnt = "50.00";
                $cardcost = "100.00";
                $totalcost = "250.00";
                $barcode = $barcode;
                $agentype = $agntp;
                $dtm = date("Y-m-d h:i:s");
                    
                    
                    
                    
                $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($drivinglicencedat));
              
              	$data['vehicledata'] = addVehicle($tnid,$mobnum,$custmrid,$vclclss,$vehclnum,$commercialtype,$vehiclenumbertype,$minamnt,$depositeamnt,$cardcost,$totalcost,$barcode,$agentype,$rcbook);
                $data1 = json_decode($data['vehicledata'])[0];
                $array = json_decode(json_encode($data1), true);
              
                   
              
                if($array['RESPONSECODE'] == 01){
           echo $response = '
                    <div class="alert alert-danger alert-dismissible fade show">'.$array['STATUS'].'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                   </div>';
                  exit;
                }else{                  
                  
                  $table ='tagactivationExistingUser';
                  $upclnm ='existinguserid';
                  $updtdata = [
                      'resultTag'=>$array['STATUS'],
                      'statusTag'=>$array['TAG'][0]['RESULT'],
                      'transactionstatus'=>0,
                  ];
                  $updtid = $bankid;
                  $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                  

                  $dtm=date("Y-m-d h:i:s");
                  if($array["TAG"][0]["RESULT"] == 230201){
                    $insertdata = ["payerid" => $_SESSION['salesagentId'], "payertype" =>1, "amount" => $orderAmount, "transactionid" => $ordrid, "transactiontype" => 2, "transactionstatus" => 2,"txn" => "SUCCESS","datetime"=>$dtm];               
                    $loginData = $this->loginModel->loginDatainsert('wallet',$insertdata);
                    
                    $salesagentdetails = $this->loginModel->viewspecific('fasttag','*','barcode',$barcode);
                    $fatsagid = $salesagentdetails[0]['fasttagid'];

                    $table1 ='fastaginventory';
                    $upclnm1 ='fasttagid';
                    $updtdata1 = [                          
                      'status'=>1,
                    ];
                    $updtid1 = $fatsagid;
                    $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);

                    $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$bankid,"allotedtotype"=>4,"allotedby"=>$_SESSION['salesagentId'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);


                    session()->remove('setTagactivationId');
                  
                    $stss="Fastag Activated Successfully";
                  }else{
                    $stss=$array["TAG"][0]["RESULT"];
                  }
                  
          echo $response = '
                   <div class="alert alert-success alert-dismissible fade show">'.$stss.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                   </div>';
                  exit;  
                 
                  }                  
                  
               }
             }
      
                   $data['tagclass'] = $this->productmodel->distinctVal("fasttag","classoftag");
                   $data['product'] = $this->loginModel->viewprdata($_SESSION['salesagentId']);
         		   $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
                   $data['slctdfstg'] = $this->productmodel->multisearchFastag($_SESSION['salesagentId']);
                    return view('salesagent/activateexisting',$data);
      }
  
  
      public function statsindividual(){

             $orderId = $this->request->getVar('orderId');
        
        
        	$data =[];
            $salesagentdetails = $this->loginModel->getSalesagentindividual($orderId);
            $retrndata1 = $this->loginModel->lastLogin($salesagentdetails[0]['salesagentId']);
            if($salesagentdetails[0]["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $salesagentdetails[0]["ProfileImage"]; }

            $profileImage = $prf;
            $this->session->set('salesagentId',$salesagentdetails[0]['salesagentId']);
            $this->session->set('logged_intype',3);
            $this->session->set('login_data_id',$retrndata1['login_data_id']);
            $this->session->set('logged_img',$profileImage);
            $this->session->set('setTagactivationId',$orderId);
        
        

            if($retrndata1 == false){
                $lstLogin="";
            }else{
                $lstLogin=$retrndata1['datetime_login'];
            }

            $usrnmm = $salesagentdetails[0]["Fname"].' '.$salesagentdetails[0]["Lname"];
            $this->session->set('usrName',$usrnmm);
            $this->session->set('usrLastLogin',$lstLogin);
        
        	$trnsts = $this->request->getVar('txStatus');
            $orderId = $this->request->getVar('orderId');
            $orderAmount = $this->request->getVar('orderAmount');
            $referenceId = $this->request->getVar('referenceId');
            $paymentMode = $this->request->getVar('paymentMode');
            $signature = $this->request->getVar('signature');
            $dtm=date("Y-m-d h:i:s");
            $databankdetails = ["refrenceid"=>$referenceId,"paymentmode"=>$paymentMode,"paymentamount"=>$orderAmount,"orderid"=>$orderId,"signature"=>$signature,"transactionstatus"=>$trnsts,"datetime"=>$dtm];
            $loginData = $this->loginModel->loginDatainsert('paymentstatus',$databankdetails);
        
        
            if($this->request->getVar('txStatus') == "SUCCESS"){               
                

                $table ='tagactivationExistingUser';
                $upclnm ='transactionid';
                $updtdata = [
                    'transactionstatus'=>0,
                ];
                $updtid = $orderId;
                $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              
                $orderId =  $_SESSION["setTagactivationId"];
                $salesagentid = $_SESSION['salesagentId'];

                $dtta = $this->loginModel->multiSrch('tagactivationExistingUser','*','transactionid',$orderId,'salesagentId',$salesagentid);
              
              //echo $dtta[0]["drivingLicence"];
            
              if($dtta[0]["vehicleType"] == "Non-Commercial"){
                $typecmmrcl =1;
              }else{
                $typecmmrcl =2;
              }
            
            
              $tnid = time();
              $mobnum = $dtta[0]["mobileNumber"];
              $custmrid = $dtta[0]["customerid"];
              $vehclclss = 4;
              $vehclnum = $dtta[0]["vehiclechasisnumber"];
              $commercialtype = $typecmmrcl;            
              $vehiclenumbertype = $dtta[0]["vehicleNumbertype"];            
              $minamnt = "100.00";
              $depositeamnt = "50.00";
              $cardcost = "100.00";
              $totalcost = "250.00";
              $barcode = $dtta[0]["barcodeid"];
              $agentype = $dtta[0]["agenttype"];
              
              
              
                $img_file = $dtta[0]["rcbook"];
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
                $updtid = $orderId;
                $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);   
              

                $dtm=date("Y-m-d h:i:s");

                $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcode);
                $fatsagid = $salesagentdetails[0]['fasttagid'];        
              

                $table1 ='fastaginventory';
                $upclnm1 ='fasttagid';
                $updtdata1 = [                          
                  'status'=>1,
                ];
                $updtid1 = $fatsagid;
                $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);

                $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$dtta[0]["initialId"],"allotedtotype"=>4,"allotedby"=>$_SESSION['salesagentId'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);
              
              
                session()->remove('setTagactivationId');
                $this->session->setTempdata('Success','Tag Activated Successfully', 3);
                return redirect()->to(base_url('salesagent/tagactivationexisting'));
            }else{
              
              $table ='tagactivationExistingUser';
              $upclnm ='transactionid';
              $updtdata = [
                'transactionstatus'=>0,
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              $table ='tagactivationExistingUser';
              $upclnm ='transactionid';
              $updtdata = [
                'txnstatus'=>$this->request->getVar('txStatus'),
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);    

              session()->remove('setTagactivationId');
              
              $this->session->setTempdata('error','Payment Was Not Successfully', 3);
              return redirect()->to(base_url('salesagent/tagactivationexisting'));
              
            }

        
        
        return view('salesagent/paymentstatusindividual',$data);
    }
  
  	public function satagreqst(){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanagerLogin'));            
        }

        $data= [];
       
        //$data['oemreqst'] =  $this->loginModel->viewspecific('fastagrequest','*','requestedbytype',1);
        $data['oemreqst'] = $this->loginModel->multiSrch('fastagrequest','*','requestedbytype',1,'requestedtoid',$_SESSION['salesmanagerId']);
      
         $cnt = sizeof($data['oemreqst']);
       if($cnt !=0){
      
          for($i=0;$i< $cnt; $i++){
             $oemname[] = $this->loginModel->viewspecific('salesagent','*','salesagentId',$data['oemreqst'][$i]["requestedbyid"]);
          }
       }else{
             $oemname =[];
       }

          $data['oemdata'] = $oemname;
      
        return view('salesmanager/salesagenttagrequest',$data);
    }
  
  	public function updaterequestStatus($idd,$val){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanager/dashboard'));            
        }

        $data=[];

        $table="fastagrequest";
        $upclnm="fastagrequestid";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','SalesAgent Status Updated Successfully', 3);
            return redirect()->to(base_url('salesmanager/tagrequest'));
    }
  
  
}

?>