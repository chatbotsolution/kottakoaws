<?php

namespace App\Controllers;
use \App\Models\TeamLeadModel;
use \App\Models\SalesManagerModel;
  use \App\Models\FastagInventoryModel;

class TeamLeadController extends BaseController
{
    public $loginModel;
    public $fastaginventory;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        $this->loginModel = new TeamLeadModel();
        $this->salesModel = new SalesManagerModel();
        $this->fastaginventory = new FastagInventoryModel();
        $this->session = session();
        
    }

    public function addTeamLead()
    {
        if ((!isset($_SESSION['salesmanagerId']))) {

            return redirect()->to(base_url('salesmanagerLogin'));
            
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
            "noidcrtn"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Id Creation Is required ',
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
            "regnsale"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Region Of Sale is required ',
                ],
            ],
            "nopermitted"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Permitted Number is required ',
                ],
            ],
            "nomecntctnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Contact Number Is required ',
                ],
            ],
            "nomeidproof"=>'uploaded[nomeidproof]|max_size[nomeidproof,1024]|ext_in[nomeidproof,png,gif,jpg,jpeg,PNG,JPEG,JPG,pdf,PDF]',
            "productcode"=>'required',
        ];

        if($this->request->getMethod() == "post"){

            if($this->request->getVar('showtype')){
                $response='<label class="col-sm-2 col-form-label">No Of ';
                if($this->request->getVar('showtype') == "Toll"){
                        $response.='Toll';
                }else{
                        $response.='City';
                }
                $response.=' Permitted <span style="color: red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" onkeyup="showbox(this.value);" name="nopermitted" Placeholder="Number Permitted" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg" style="text-align:left;">';
                                   if(isset($validations)){
                        $response.=' show_form_error('.$validations.',\'reltnwthmngr\')'; 
                                   }
            $response.='        </span>
                            </div>';
                echo $response;
                exit;
            }

            if($this->request->getVar('showng')){
                
               $cnt = $this->request->getVar('showval');

                if($cnt != 0){
                    $j=1;
                    for($i=0; $i<$cnt; $i++){
                        $response='<label class="col-sm-2 col-form-label">Toll '.$j.'<span style="color: red">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nopermittedval[]" Placeholder="Permitted Toll '.$j.'" class="form-control mg-b-10" style="max-width:50%;">
                                    </div>';
                        echo $response;
                        $j++;
                    }
                }else{
                    echo $response="";
                }
            
                exit;
            }


            if($this->validate($rules)){
              
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $contctnumsec = $this->request->getVar('contctnumsec');
                
                
                $tollncity = $this->request->getVar('tollncity');
                $noidcrtn = $this->request->getVar('noidcrtn');
                
                
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
                $regnsale = $this->request->getVar('regnsale');
                $email = $this->request->getVar('email');
                $teamldtarget = $this->request->getVar('teamldtarget');

                $profileimg = $this->request->getFile('profileimg');
                $nopermttedd = $this->request->getVar('nopermitted'); 
              
                $where = 'ContactPrimary  = "'.$contctnumprim.'" OR teamleademailid = "'.$email.'" OR ContactSecondary = "'.$contctnumprim.'"';
                $duplct = $this->salesModel->chkduplcate('teamlead',$where);
                
                $where1 = 'panCardNumber  = "'.$pannum.'"';
                $duplct1 = $this->salesModel->chkduplcate('kycdetails',$where1);
                
                
                if(sizeof($duplct) == 0 AND sizeof($duplct1) == 0){

                $rndid =  strtoupper(random_string('numeric', 6));
                $regdId = "TL-".$rndid;

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/teamlead/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = "default";
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/teamlead/nomeedata/',$newnomeidproof)){                           
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
                      if($drivingproof->move(FCPATH.'public/adminasset/img/teamlead/drivinglicence/',$newdrivingproof)){                           
                               $drivinglicenceproof = $newdrivingproof;
                      }
                  }else{
                          $newdrivingproof="";
                  }
              }

                if($panproof->isValid() && !$panproof->hasMoved()){
                    $newpanproof = $panproof->getRandomName();
                    if($panproof->move(FCPATH.'public/adminasset/img/teamlead/pancard/',$newpanproof)){                           
                             $pancardproof = $newpanproof;
                    }
                }else{
                        echo $panproof->getErrorString()."".$panproof->getError();
                }

                if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                    $newaadharproof = $aadharproof->getRandomName();
                    if($aadharproof->move(FCPATH.'public/adminasset/img/teamlead/aadharcard/',$newaadharproof)){                           
                             $aadharcardproof = $newaadharproof;
                    }
                }else{
                        echo $aadharproof->getErrorString()."".$aadharproof->getError();
                }                         
                            
                    $dtm = date("Y-m-d h:i:s");

                    /*----------------------------Bank Details--------------------------------*/

                    $databankdetails = ["bankName"=>$bankname,"accountNumber"=>$accntnum,"IFSCCode"=>$ifsccode,"userType"=>2,"bankkycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('bankdetails',$databankdetails);
                    $bankid = $this->loginModel->db->insertID();

                    /*----------------------------KYC Details--------------------------------*/
                    
                    $datakycdetails = ["aadharNumber"=>$aadhrnum,"panCardNumber"=>$pannum,"drivingLicenceNumber"=>$drivinglicence,"aadharProof"=>$newaadharproof,"panCardProof"=>$newpanproof,"drivingLicenceProof"=>$newdrivingproof,"userType"=>2,"kycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('kycdetails',$datakycdetails);
                    $kycid = $this->loginModel->db->insertID();
                    
                    /*----------------------------- Nominee Details---------------------------*/

                    $dataNominee = ["firstName"=>$nomefname,"lastName"=>$nomelname,"relationWith"=>$reltnwthmngr,"contactNumber"=>$nomecntctnum,"idProof"=>$newnomeidproof,"userType"=>2,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('nomeedetails',$dataNominee);
                    $nomineeid = $this->loginModel->db->insertID();
                    
                    $data = ["target"=>$teamldtarget,"teamleademailid"=>$email,"numoftollandcity"=>$nopermttedd,"region"=>$regnsale,"TleadRegdNum"=>$regdId,"Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"toll&city"=>$tollncity,"allowedIdCreation"=>$noidcrtn,"ProfileImage"=>$profileImage,"bankdetailsid"=>$bankid,"nomineedetailsid"=>$nomineeid,"kycdetailsid"=>$kycid,"otp"=>'0',"status"=>'2',"datetime"=>$dtm,"requestedById"=>$_SESSION["salesmanagerId"]];
                    $loginData = $this->loginModel->loginDatainsert('teamlead',$data);
                    $uid = $this->loginModel->db->insertID(); 

                    $cnt = sizeof($this->request->getVar('nopermittedval'));

                    for($tolnm=0;$tolnm < $cnt; $tolnm++ ){
                        $tll = $this->request->getVar('nopermittedval')[$tolnm];
                        $dataTollval = ["user_id"=>$uid, "tollorcityname"=>$tll, "userType"=>2,"datetime"=>$dtm];
                        $loginData = $this->loginModel->loginDatainsert('tollandcitypermitted',$dataTollval);
                    }
                    

                    if($loginData){
                        $count = sizeof($this->request->getVar('productcode'));
                        for($prdcd = 0;$prdcd < $count; $prdcd++){
                            $prdd = $this->request->getVar('productcode')[$prdcd];
                            $dataNominee = ["productid"=>$prdd,"userId"=>$uid,"userType"=>2,"status"=>0,"datetime"=>$dtm];
                            $loginData = $this->loginModel->loginDatainsert('selectproduct',$dataNominee);
                        }

                        $to=$email;
                        $from="hitchpayments@gmail.com";
                        $subject="Welcome to Hitchpay";
                        $message="Hi Teamlead, <br> You have been registerd successfully. <br> Your registeration id is ".$regdId." <br> Regards <br> Hitchpay";
                        sendEMail($to,$from,$subject,$message);

                        $this->session->setTempdata('success','Team Lead Add Request Sent Successfully', 3);
                        return redirect()->to(base_url('salesmanager/addteamlead'));
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                        return redirect()->to(base_url('salesmanager/addteamlead'));
                    }   
                }else{
                   $this->session->setTempdata('error','User Already Exists', 3);
                   return redirect()->to(base_url('salesmanager/addteamlead'));
               }

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['salesmanagerprd'] = $this->salesModel->viewprdata($_SESSION['salesmanagerId']);
            return view('salesmanager/addteamlead',$data);
    }


    public function manageTeamLead(){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanagerLogin'));            
        }
        $data=[];

        $data["teamlead"]=$this->loginModel->showSelectdManager($_SESSION['salesmanagerId']);

        return view('salesmanager/manageteamlead',$data);
    }

    public function index(){
        if ((isset($_SESSION['teamleadId']))) {
            return redirect()->to(base_url('teamlead/dashboard'));            
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

        return view('teamlead/index',$data);
    }

    public function sendotp(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $userid = $this->request->getVar('usrid');
                $otp = random_string('numeric', 4);

                $retrndata = $this->loginModel->findSelect($userid);
                if($retrndata){

                    $table ='teamlead';
                    $upclnm ='teamleadId';
                    $updtdata = [
                        'otp'=>$otp,
                    ];
                    $updtid = $retrndata["teamleadId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                        $to=$retrndata["teamleademailid"];
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
                                <div class="col-md-2">
                                    <button type="button" onclick="sendOtp();" class="btn btn-info btn-sm">Resend OTP</button>
                                </div>
                            </div>';
                      //  }else{
                       //     $response="sorry";
                        //}

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

                            $tablee ='teamlead';
                            $updtide = $retrndata["teamleadId"];
                            $updtdatae = [
                                'otp'=>null,
                            ];
                            $upclnme = 'teamleadId';
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

                            $data = ["user_ip_add"=>$ip,'user_type'=>2,'login_id'=>$retrndata['teamleadId'],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];
                            
                            $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                            $lid = $this->loginModel->db->insertID();

                            if($retrndata["ProfileImage"] == "default"){
                                $profileImage = "default_user.jpg";
                            }else{
                                $profileImage = $retrndata["ProfileImage"];
                            }

                            $this->session->set('teamleadId',$retrndata['teamleadId']);
                            $this->session->set('logged_intype',2);
                            $this->session->set('login_data_id',$lid);
                            $this->session->set('logged_img',$profileImage);
                            
                            $retrndata1 = $this->loginModel->lastLogin($retrndata['teamleadId']);

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

        return view('teamlead/index',$data);

    }

    public function adminAproval(){
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }

        $data=[];

        $data["teamleaddata"] = $this->loginModel->requestshow();
        
        return view('admin/approveteamlead',$data);
    }

    public function manageTeamLeadAdmin(){
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }

        $data=[];

        $data["teamlead"]=$this->loginModel->showSelectd();

        return view('admin/manageteamlead',$data);
    }

    public function viewteamleadProfile($idd){

        $data= [];

        $data['profileData'] = $this->loginModel->showprofiledetails1($idd);
        $data['tollorcityData'] = $this->loginModel->tollcityshow($idd,2); 
        $iidd = $data['profileData']['teamleadId'];
        $data['teamleadprd'] = $this->loginModel->viewprdata($iidd);
        $uidd = $data['profileData']['requestedById']; 
        $data['salesmngrdta'] = $this->salesModel->showprofiledetails1($uidd); 
        if ((isset($_SESSION['salesmanagerId']))) {
            return view('salesmanager/viewteamlead',$data);            
        }else{
            return view('admin/viewteamlead',$data);
        }      

        
    }

    public function shwprdd(){

        if($this->request->getVar('showtype')){

        }
        
        
        

        return view('admin/viewteamlead',$data);
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="teamlead";
        $upclnm="teamleadId";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Sales Manager Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/approveteamlead')); 

            $data["salesmanager"]=$this->loginModel->showSelectd();

            return view('admin/managesalesmanager',$data);
    }

    public function updateStatus1($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="teamlead";
        $upclnm="teamleadId";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Sales Manager Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/manageteamlead')); 

            $data["salesmanager"]=$this->loginModel->showSelectd();

            return view('admin/managesalesmanager',$data);
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
            "contctnumprim"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Primary Contact Number Is required ',
                ],
            ],
            "productcode"=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Product Is required ',
                  ],
              ],
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "noidcrtn"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Id Creation Is required ',
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
            "emailidd"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Id Is required ',
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
          
           if($this->request->getVar('removeidd')){
             
             $removeidd = $this->request->getVar('removeidd');
             
             $delete = $this->loginModel->deletetll($removeidd);
             
             echo $delete;
             exit;
             
           }
             
             
             
             
            if($this->validate($rules)){
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $contctnumsec = $this->request->getVar('contctnumsec');              
                $tollncity = $this->request->getVar('tollncity');
                $noidcrtn = $this->request->getVar('noidcrtn'); 
                $emailidd = $this->request->getVar('emailidd'); 
                
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

                $alldata = $this->loginModel->showprofiledetails1($this->request->getVar('idd'));
              	$dtm = date("Y-m-d h:i:s");
              
              
                if($this->request->getVar('productcode')){

                     $selectedproduct = $this->loginModel->viewprdata($idd);                
                  //    echo sizeof($selectedproduct);
                               $this->loginModel->deletef($idd);
                     $prdidd = $this->request->getVar('productcode');
                     $cntpid = sizeof($this->request->getVar('productcode'));

                    for($pid=0;$pid < $cntpid;$pid++){

                      $pdd = $prdidd[$pid];
                      $dataNominee = ["productid"=>$pdd,"userId"=>$idd,"userType"=>2,"status"=>0,"datetime"=>$dtm];
                      $loginData = $this->loginModel->loginDatainsert('selectproduct',$dataNominee);

                    }

                  }
              
              
              	  if($this->request->getVar('alltname')){
                         $alltname = $this->request->getVar('alltname');
                         $cntpid = sizeof($this->request->getVar('alltname'));
                    
                    for($allid=0;$allid < $cntpid;$allid++){

                      $tllnm = $alltname[$allid];
                      if($tllnm != ""){
                        
                         $datatllct = ["user_id" =>$idd, "tollorcityname" =>$tllnm, "userType" =>2, "datetime" =>$dtm];
                         $loginData = $this->loginModel->loginDatainsert('tollandcitypermitted',$datatllct);
                      }
                    }
                  }

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/teamlead/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = $alldata["ProfileImage"];
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/teamlead/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                                 $nomineeproof = $alldata["idProof"];
                    }
                }

                if($this->request->getFile('drivingproof')){
                    if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                        $newdrivingproof = $drivingproof->getRandomName();
                        if($drivingproof->move(FCPATH.'public/adminasset/img/teamlead/drivinglicence/',$newdrivingproof)){                           
                                $drivinglicenceproof = $newdrivingproof;
                        }
                    }else{
                                $drivinglicenceproof = $alldata["drivingLicenceProof"];
                    }
                }

                if($this->request->getFile('panproof')){
                    if($panproof->isValid() && !$panproof->hasMoved()){
                        $newpanproof = $panproof->getRandomName();
                        if($panproof->move(FCPATH.'public/adminasset/img/teamlead/pancard/',$newpanproof)){                           
                                $pancardproof = $newpanproof;
                        }
                    }else{
                                $pancardproof = $alldata["panCardProof"];
                    }
                }

                if($this->request->getFile('aadharproof')){
                    if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                        $newaadharproof = $aadharproof->getRandomName();
                        if($aadharproof->move(FCPATH.'public/adminasset/img/teamlead/aadharcard/',$newaadharproof)){                           
                                $aadharcardproof = $newaadharproof;
                        }
                    }else{
                                $aadharcardproof = $alldata["aadharProof"];
                    }  
                }                       
                            
                    $dtm = date("Y-m-d h:i:s");

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
                    
                    $tablee="teamlead";
                    $upclnm="teamleadId";
                    $updtid=$alldata["teamleadId"];
                    $updtdata = ["Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"toll&city"=>$tollncity,"allowedIdCreation"=>$noidcrtn,"ProfileImage"=>$profileImage,"datetime"=>$dtm,"teamleademailid"=>$emailidd];
                    $salesagent = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);

                        $this->session->setTempdata('success','Team Lead Profile Updated Successfully', 3);
                        return redirect()->to(base_url('secure/editteamlead/'.$alldata["teamleadId"].''));
                    

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['editprofileData'] = $this->loginModel->showprofiledetails($idd);
        $data['selectedproduct'] = $this->loginModel->viewprdata($idd);
        $data['product'] = $this->loginModel->viewspecific('product','*','status',0);
        $data['permitedtllcty'] = $this->loginModel->tollcityshow($idd,2);
        
        return view('admin/editteamlead',$data);

    }

    public function logout()
    {
        
        $dtm = date("Y-m-d h:i:s");
        if($this->session->has('teamleadId')){
            
            $table ='login_data';
            $updtid = session()->get('login_data_id');
            $updtdata = [
                'date_logout'=>$dtm,
            ];
            $upclnm = 'login_data_id';
            $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            session()->remove('teamleadId');
            session()->remove('logged_img');
            session()->remove('logged_intype');
            session()->remove('login_data_id');
            session()->remove('usrName');
            session()->remove('usrLastLogin');
        }
            return redirect()->to(base_url().'/teamleadLogin');
    }

    public function fastagInventory(){
        if ((!isset($_SESSION['teamleadId']))) {
            return redirect()->to(base_url('teamleadLogin'));            
        }

        $data= [];

        $dtm = date("Y-m-d h:i:s");
        $table="salesagent";
        $viewdata="*";
        $whrdata = array(
            'requestedById' => $_SESSION['teamleadId'],
            'status'   => 0
          );
        $data["teamlead"]=$this->salesModel->ftchmulti($table,$viewdata,$whrdata);

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('fastagid')){
                $response='
                <div class="modal-header">
                    <h5 class="modal-title">Allocate Fastag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" form-group row">
                    <div id="mdg" class="col-md-12"></div>
                        <div class="col-sm-3 col-form-label">
                            Select Sales Agent
                            <input type="hidden" id="fastatgidd" value="'.$this->request->getVar('fastagid').'">
                            <input type="hidden" id="invntid" value="'.$this->request->getVar('invntid').'">
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" style="width:60%;" id="salesmanager">
                                <option value="">Select Sales Agent</option>';
                                $cnt = count($data["teamlead"]);
                              for($i=0;$i<$cnt;$i++){
                                  $shw = $data["teamlead"][$i]["Fname"].' '.$data["teamlead"][$i]["Lname"].' ( '.$data["teamlead"][$i]["salesAgentRegdNum"].' )';
                         $response.='<option value="'.$data["teamlead"][$i]["salesagentId"].'">'.$shw.'</option>';
                              }  
                                
                $response.='</select>
                            <span class="errmsg" style="text-align:left;" id="ermid"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="allot();">Allot Tag</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                ';

                echo $response;
                exit;
            }

            if($this->request->getVar('fasttagid')){
                $fasttagid = $this->request->getVar('fasttagid');
                $salesmngis = $this->request->getVar('salesmngis');
                $invntid = $this->request->getVar('invntid');
                
                $data = ["fasttagid"=>$fasttagid,"allotedto"=>$salesmngis,"allotedtotype"=>3,"allotedby"=>$_SESSION['teamleadId'],"allotedbytype"=>2,"status"=>'0',"datetime"=>$dtm];
                $loginData = $this->loginModel->loginDatainsert('fastaginventory',$data);
                if($loginData){
                    $table="fastaginventory";
                    $upclnm="inventoryid";
                    $updtdata = [
                        'status'=>1,
                    ];
                    $updtid=$invntid;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        $response="done";
                }else{
                    $response="sorry";
                }

                echo $response;
                exit;
            }
          
          /*--------------------------frm Here----------------------------*/
          
          if($this->request->getVar('ad')){

                $cnt = sizeof($this->request->getVar('values'));
                for($i=0; $i <$cnt; $i++){
                    $datavall[] = $this->request->getVar('values')[$i];
                    $dataval1[] = $this->request->getVar('invntid')[$i];
                }
                $dataa = base64_encode(json_encode($datavall));
                $trnsid = time().date('Y').date('m');
                $dataa1 = base64_encode(json_encode($dataval1));
                
                $trnsid = time().date('Y').date('m');
                $rt = json_encode($this->request->getVar('values'));
                $dataaq = ["agenttype"=>4, "agentid"=>0, "tag"=>$rt, "transactionid"=>$trnsid, "status"=>0,"datetime"=>$dtm,"otp"=>0];
                $rttyt = $this->loginModel->loginDatainsert('tagtransaction',$dataaq);

                $response='
                <form action="'.base_url().'/teamlead/fastaginventory" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Fastag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" form-group row">
                        <div id="mdg" class="col-md-12"></div>
                            <div class="col-sm-3 col-form-label">
                                Select Sales Agent
                                <input type="hidden" name="fastatgiddad" value="'.$dataa.'">
                                <input type="hidden" name="invntid" value="'.$dataa1.'">
                                <input type="hidden" id="trnsid" name="trnsid" value="'.$trnsid.'">
                                <input type="number" id="moblenumm" name="moblenumm" class="form-control" hidden>
                                
                            </div>
                            <div class="col-md-9 shwhrr">
                                <select class="form-control" style="width:60%;" id="salesmanagerfstg" name="salesmanagerfstg" onchange="shwnumberverify(this.value);">
                                  <option value=""> Select Sales Agent</option>';
                                    $cnt = count($data["teamlead"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["teamlead"][$i]["Fname"].' '.$data["teamlead"][$i]["Lname"].' ( '.$data["teamlead"][$i]["salesAgentRegdNum"].' )';
                         $response.='<option value="'.$data["teamlead"][$i]["salesagentId"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>
                                <span class="errmsg" style="text-align:left;" id="ermid"></span>
                            </div>
                        </div>
                        <div class="form-group row fgtr">
                           <div class="col-sm-3 col-form-label">
                                OTP
                            </div>
                            <div class="col-md-9">
                                <input type="number" id="ottp" name="ottp" class="form-control" style="width:50%;" placeholder="Enter OTP">
                                <span class="btnspace">
                                   <button type="button" class="btn btn-info" onclick="sendotp();" style="position: absolute;top: 0px;left: 325px;padding: 10px;border-radius: 0px 4px 4px 0px;"> SEND OTP </button>
                                </span>
                                <span class="errmsg otppsndt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="tagbtnn" disabled>Allot Tag</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                    ';

                    echo $response;
                exit;
            }




            if($this->request->getVar('salesagentidotp')){
                
                $salesagentidotp = $this->request->getVar('salesagentidotp');
                $transctnid = $this->request->getVar('transctnid');
                
                $table="tagtransaction";
                $upclnm="transactionid";
                $updtdata = [
                    'agentid'=>$salesagentidotp,
                ];
                $updtid=$transctnid;
                $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid); 
                   
                $salesagent = $this->loginModel->viewspecific('salesagent','*','salesagentId',$salesagentidotp);
                $response = $salesagent[0]['ContactPrimary'];
                
                echo $response;
                exit;
            }
            
            
            if($this->request->getVar('transctniddd')){
                $transctniddd = $this->request->getVar('transctniddd');
                $moblnnumm = $this->request->getVar('moblnnumm');
                $salesmanagerfstg = $this->request->getVar('salesmanagerfstg');
                
                $remainingtag = $this->loginModel->viewspecific('maxallowedtagnum','*','usertype',3);
                $maxallowedtag = $remainingtag[0]['max_allowed_tag'];
                
                $where = array("allotedto"  => $salesmanagerfstg,"allotedtotype"=>"3","status"=>0);
                $salesmanager = $this->salesModel->chkduplcate('fastaginventory',$where);
                
                
                
                if(sizeof($salesmanager) > $maxallowedtag){
                   echo $response ="Max Allowed Tag Already Reached";
                   exit;
                }
                    
                $otp = random_string('numeric', 6);
                
                $table="tagtransaction";
                $upclnm="transactionid";
                $updtdata = [
                    'otp'=>$otp,
                ];
                $updtid=$transctniddd;
                $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                
                $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
                $send=sendOTP($moblnnumm,$userSMS);
                
                $response="send";

                echo $response;
                exit;
            }
            
            
            if($this->request->getVar('transctnidddvrfy')){
                $transctnidddvrfy = $this->request->getVar('transctnidddvrfy');
                $moblnnummvrfy = $this->request->getVar('moblnnummvrfy');
                $otppvrfy = $this->request->getVar('otppvrfy');
                
                $otppdta = $this->loginModel->viewspecific('tagtransaction','*','transactionid',$transctnidddvrfy);
                $ottp = $otppdta[0]['otp'];
                
                if($otppvrfy == $ottp){
                    
                    $table="tagtransaction";
                    $upclnm="transactionid";
                    $updtdata = [
                        'otp'=>0,
                        'status'=>1,
                    ];
                    $updtid=$transctnidddvrfy;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    $response="verified";
                }else{
                    
                    $table="tagtransaction";
                    $upclnm="transactionid";
                    $updtdata = [
                        'otp'=>0,
                        'status'=>2,
                    ];
                    $updtid=$transctnidddvrfy;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    $response="invalidotp";
                }
                
                

                echo $response;
                exit;
            }


          
          
           if($this->request->getVar('fastatgiddad')){
                 $fstg = $this->request->getVar('fastatgiddad');
                 $salesmanagerfstg = $this->request->getVar('salesmanagerfstg');
                 $invntid = $this->request->getVar('invntid');
             

                  $cnt = sizeof(json_decode(base64_decode($fstg)));
             
                  
                  for($i=0; $i< $cnt; $i++){
                    $val = json_decode(base64_decode($fstg))[$i];
                    $val1 = json_decode(base64_decode($invntid))[$i];

                    $data = ["fasttagid"=>$val,"allotedto"=>$salesmanagerfstg,"allotedtotype"=>3,"allotedby"=>$_SESSION['teamleadId'],"allotedbytype"=>2,"status"=>'0',"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$data);
                    if($loginData){
                        $table="fastaginventory";
                        $upclnm="inventoryid";
                        $updtdata = [
                            'status'=>1,
                        ];
                        $updtid=$val1;
                        $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                             
                    }else{
                       $this->session->setTempdata('error','Sorry Unable To Allot Try Again Later', 3);
                       return redirect()->to(base_url('teamlead/fastaginventory'));
                    }
                  }
             		
             	       $this->session->setTempdata('success','Fastag Alloted Successfully', 3);
                       return redirect()->to(base_url('teamlead/fastaginventory'));
            }
          
          
          
          
          if($this->request->getVar('searchvalue')){                
                   $id=$_SESSION['teamleadId'];
                   $typ =1;
                   $sts =0;
                  $likebarcode = $this->salesModel->fastaglikeManager($this->request->getVar('searchvalue'),$_SESSION['teamleadId'],2); 
                  $cnt=sizeof($likebarcode);
                                   
                      if($cnt == 0){
							$response='
                               <tr>
                                 <td colspan="8"> No Data Found..</td>
                               </tr>                            
                            ';
                        echo $response;
                      }else{                         
                        
                        $i=0;
                        foreach($likebarcode as $likk){
                                                  
                        $i++;

                        if($likk["status"] == 0){
                          $sts="Active";
                          $btn1='<button class="btn btn-sm btn-info" onclick="allot_tag(\''.$likk["fasttagid"].'\',\''.$likk["inventoryid"].'\');"> Allot Fastag </button>';                          
                        }else if($likk["status"] == 1){
                          $sts="Allocated";
                          $btn1="";
                        }else{
                          $sts="";
                          $btn1="";
                        }
                          
                        $response='
                             <tr>
                               <td>
                                 <div id="itemForm">';
                                   if($likk["status"] == 0){ 
                                 $response.='<input type="checkbox" name="checkedtogive" id="checkedtogive'.$likk["fasttagid"].'" value="'.$likk["fasttagid"].'">
                                             <input type="hidden" name="invntid" id="'.$likk["fasttagid"].'" value="'.$likk["inventoryid"].'">';
                                   }else{ 
                                 $response.='<input type="checkbox" disabled="disabled">';
                                   }  
                           $response.=$i.
                                 '</div>
                                 </td>
                                 <td>'.$likk["barcode"].'</td>
                                 <td>'.$likk["tagid"].'</td>
                                 <td>'.$likk["classoftag"].'</td>
                                 <td>'.$sts.'</td>
                                 <td>'.$btn1.'</td>
                                 </tr>
                        ';
						
                          echo $response;
                    }   
                  
                 }
                      
                      exit;
            }
          
          
          
          
          if($this->request->getVar('firstnum')){                
                   
                  $firstnum =  $this->request->getVar('firstnum');
                  $lastnum =  $this->request->getVar('lastnum');
              		
                  $frstnum="607469-".$firstnum;
                  $lastnum="607469-".$lastnum;
              
              
              
                  $likebarcode =  $this->salesModel->barcodeadvsrch($frstnum,$lastnum); 
            
                  $cnt = sizeof($likebarcode);
            
            
                      if($cnt == 0){
							$response='
                               <tr>
                                 <td colspan="8"> No Data Found..</td>
                               </tr>                            
                            ';
                        echo $response;
                      }else{
                        $i=0;
                        foreach($likebarcode as $likk){
                          $indvsrch = $this->salesModel->barcdeSrchIndv($likk["fasttagid"],$_SESSION['teamleadId'],2);
                          
                         if(count($indvsrch) !=0){
                             foreach($indvsrch as $lk); 
                            $i++;

                            if($lk["status"] == 0){
                              $sts="Active";
                              $btn1='<button class="btn btn-sm btn-info" onclick="allot_tag(\''.$likk["fasttagid"].'\');"> Allot Fastag </button>';
                            }else if($lk["status"] == 1){
                              $sts="Blocked";
                              $btn1="";
                            }else if($lk["status"] == 2){
                              $sts="Allocated";
                              $btn1="";                                                    
                            }else{
                              $sts="";
                              $btn1="";
                            }

                            $response='
                                 <tr>
                                   <td>
                                     <div id="itemForm">';
                                       if($lk["status"] == 0){ 
                                     $response.='<input type="checkbox" name="checkedtogive" id="checkedtogive'.$likk["fasttagid"].'" value="'.$likk["fasttagid"].'">
                                             <input type="hidden" name="invntid" id="'.$likk["fasttagid"].'" value="'.$lk["inventoryid"].'">';
                                       }else{ 
                                     $response.='<input type="checkbox" disabled="disabled">';
                                       }  
                               $response.=$i.
                                     '</div>
                                     </td>
                                     <td>'.$likk["barcode"].'</td>
                                     <td>'.$likk["tagid"].'</td>
                                     <td>'.$likk["classoftag"].'</td>
                                     <td>'.$sts.'</td>
                                     <td>'.$btn1.'</td>
                                     </tr>
                            ';
                            echo $response;
                         }
                          
                      }
                    }              
                      
                      exit;
            }
           
        
      
      
      /*--------------------------Till Here---------------------------------------------------*/
          
        }
        
		$paginateData = $this->fastaginventory->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag')
         ->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid')
         ->where('fastaginventory.allotedto',$_SESSION['teamleadId'])
         ->where('fastaginventory.allotedtotype',2)   			
         ->paginate(100);
      
       $data = [
         'fastag' => $paginateData,
         'pager' => $this->fastaginventory->pager
       ]; 
      
      //  $data['fastag'] = $this->loginModel->showfastag($_SESSION['teamleadId'],2);     
        
        return view('teamlead/fastag',$data);

    }
  
  
  	public function managefasttagspecific($type){
      if ((!isset($_SESSION['teamleadId']))) {
        return redirect()->to(base_url('teamleadLogin'));            
      }
      
      $data =[];
      
      if($type == 'allocated'){
        $shwval = 1;
      }else if($type == 'unallocated'){
        $shwval= 0;
      }
      
     // $data['fastag'] = $this->loginModel->sortfastag($_SESSION['salesmanagerId'],1,$shwval);
      
      $paginateData = $this->fastaginventory->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag')
         ->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid')
         ->where('fastaginventory.allotedto',$_SESSION['teamleadId'])
         ->where('fastaginventory.allotedtotype',2)   
         ->where('fastaginventory.status',$shwval)
         ->paginate(100);      
      
      
     $data = [
       'fastag' => $paginateData,
       'pager' => $this->fastaginventory->pager
     ]; 
      
      
      $data['type'] = $type;
      
      return view('teamlead/managefasttagspecific',$data);
    }

}

?>