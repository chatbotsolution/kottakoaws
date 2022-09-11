<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;

class SalesManagerController extends BaseController
{
    public $loginModel;
    public $email;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        $this->loginModel = new SalesManagerModel();
        $this->session = session();
        $email = \Config\Services::email();
        
    }

    public function addSalesManager()
    {
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        $data=[];
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
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "regnofsale"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Region Of Sale Is required ',
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
            "aadharproof"=>'uploaded[aadharproof]|max_size[aadharproof,1024]|ext_in[aadharproof,png,gif,jpg,jpeg,PNG,JPEG,JPG]',
            "pannum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Number Is required ',
                ],
            ],
            "panproof"=>'uploaded[panproof]|max_size[panproof,1024]|ext_in[panproof,png,gif,jpg,jpeg,PNG,JPEG,JPG]',
            "drivinglicence"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Driving Licence Is required ',
                ],
            ],
            "drivingproof"=>'uploaded[drivingproof]|max_size[drivingproof,1024]|ext_in[drivingproof,png,gif,jpg,jpeg,PNG,JPEG,JPG]',
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
            "email"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Id Is required ',
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
                $regnofsale = $this->request->getVar('regnofsale');
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
                $email = $this->request->getVar('email');
                $nomeidproof = $this->request->getFile('nomeidproof');

                $profileimg = $this->request->getFile('profileimg');

                $rndid =  strtoupper(random_string('numeric', 6));
                $regdId = "SM-".$rndid;

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/salesmanager/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = "default";
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/salesmanager/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                            echo $nomeidproof->getErrorString()."".$nomeidproof->getError();
                    }
                }

                if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                    $newdrivingproof = $drivingproof->getRandomName();
                    if($drivingproof->move(FCPATH.'public/adminasset/img/salesmanager/drivinglicence/',$newdrivingproof)){                           
                             $drivinglicenceproof = $newdrivingproof;
                    }
                }else{
                        echo $drivingproof->getErrorString()."".$drivingproof->getError();
                }

                if($panproof->isValid() && !$panproof->hasMoved()){
                    $newpanproof = $panproof->getRandomName();
                    if($panproof->move(FCPATH.'public/adminasset/img/salesmanager/pancard/',$newpanproof)){                           
                             $pancardproof = $newpanproof;
                    }
                }else{
                        echo $panproof->getErrorString()."".$panproof->getError();
                }

                if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                    $newaadharproof = $aadharproof->getRandomName();
                    if($aadharproof->move(FCPATH.'public/adminasset/img/salesmanager/aadharcard/',$newaadharproof)){                           
                             $aadharcardproof = $newaadharproof;
                    }
                }else{
                        echo $aadharproof->getErrorString()."".$aadharproof->getError();
                }                         
                            
                    $dtm = date("Y-m-d h:i:s");

                    /*----------------------------Bank Details--------------------------------*/

                    $databankdetails = ["bankName"=>$bankname,"accountNumber"=>$accntnum,"IFSCCode"=>$ifsccode,"userType"=>1,"bankkycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('bankdetails',$databankdetails);
                    $bankid = $this->loginModel->db->insertID();

                    /*----------------------------KYC Details--------------------------------*/
                    
                    $datakycdetails = ["aadharNumber"=>$aadhrnum,"panCardNumber"=>$pannum,"drivingLicenceNumber"=>$drivinglicence,"aadharProof"=>$newaadharproof,"panCardProof"=>$newpanproof,"drivingLicenceProof"=>$newdrivingproof,"userType"=>1,"kycStatus"=>0,"kycDatetime"=>$dtm,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('kycdetails',$datakycdetails);
                    $kycid = $this->loginModel->db->insertID();
                    
                    /*----------------------------- Nominee Details---------------------------*/

                    $dataNominee = ["firstName"=>$nomefname,"lastName"=>$nomelname,"relationWith"=>$reltnwthmngr,"contactNumber"=>$nomecntctnum,"idProof"=>$newnomeidproof,"userType"=>1,"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('nomeedetails',$dataNominee);
                    $nomineeid = $this->loginModel->db->insertID();
                    
                    $data = ["RegdNum"=>$regdId,"Fname"=>$fname,"Lname"=>$lname,"salesmngremailid"=>$email,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"regionOfSale"=>$regnofsale,"ProfileImage"=>$profileImage,"bankdetailsid"=>$bankid,"nomineedetailsid"=>$nomineeid,"kycdetailsid"=>$kycid,"otp"=>'0',"status"=>'0',"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('salesmanager',$data);
                    $uid = $this->loginModel->db->insertID(); 

                    if($loginData){
                        $count = sizeof($this->request->getVar('productcode'));
                        for($prdcd = 0;$prdcd < $count; $prdcd++){
                            $prdd = $this->request->getVar('productcode')[$prdcd];
                            $dataNominee = ["productid"=>$prdd,"userId"=>$uid,"userType"=>1,"status"=>0,"datetime"=>$dtm];
                            $loginData = $this->loginModel->loginDatainsert('selectproduct',$dataNominee);
                        }

                        $to=$email;
                        $from="hitchpayments@gmail.com";
                        $subject="Welcome to Hitchpay";
                        $message="Hi, <br> You have been registerd successfully. <br> Your registeration id is ".$regdId." <br> Regards <br> Hitchpay";
                        sendEMail($to,$from,$subject,$message);
                        $this->session->setTempdata('success','Sales Manager Added Successfully', 3);
                        return redirect()->to(base_url('secure/addsalesmanager'));
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                        return redirect()->to(base_url('secure/addsalesmanager'));
                    }    

            }else{
                $data['validations'] = $this->validator;
            }
        }
        $table="product";
        $viewdata="productid,prodctCode";
        $whrclm="status";
        $whrval=0;
            $data["prdcdd"] = $this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
            
            return view('admin/addsalesmanager',$data);
    }


    public function manageSalesManager(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $data=[];

        $data["salesmanager"]=$this->loginModel->showSelectd();

        return view('admin/managesalesmanager',$data);
    }

    public function index(){
        if ((isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanager/dashboard'));            
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

        return view('salesmanager/index',$data);
    }

    public function sendotp(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $userid = $this->request->getVar('usrid');
                $otp = random_string('numeric', 4);

                $retrndata = $this->loginModel->findSelect($userid);
                
                if($retrndata){

                    $table ='salesmanager';
                    $upclnm ='salesManagerId';
                    $updtdata = [
                        'otp'=>$otp,
                    ];
                    $updtid = $retrndata["salesManagerId"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

                        $to=$retrndata["salesmngremailid"];
                        $subject="OTP For Your Login";
                        $message="Hi, <br> Your requested OTP is ".$otp;
                        $from="hitchpayments@gmail.com";
                        $sndmail = sendEMail($to,$from,$subject,$message);
                        if($sndmail == true){                    
                    
                        $response='
                            <div class="row form-group">
                            <div class="col-md-10">
                                    <label for="uname" class="text-primary">OTP</label>
                                    <input type="text" id="otp" name="otp" placeholder="OTP" class="form-control">
                                    <span class="errmsg"><span class="otperrmsg"></span></span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <button type="button" onclick="login();" class="btn btn-primary">Login</button>
                                </div>                    
                            </div>';
                        }else{
                            $response="sorry";
                        }
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

                            $tablee ='salesmanager';
                            $updtide = $retrndata["salesManagerId"];
                            $updtdatae = [
                                'otp'=>null,
                            ];
                            $upclnme = 'salesManagerId';
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

                            $data = ["user_ip_add"=>$ip,'user_type'=>1,'login_id'=>$retrndata['salesManagerId'],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];
                            
                            $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                            $lid = $this->loginModel->db->insertID();

                            if($retrndata["ProfileImage"] == "default"){
                                $profileImage = "default_user.jpg";
                            }else{
                                $profileImage = $retrndata["ProfileImage"];
                            }

                            

                            $this->session->set('salesmanagerId',$retrndata['salesManagerId']);
                            $this->session->set('logged_intype',1);
                            $this->session->set('login_data_id',$lid);
                            $this->session->set('logged_img',$profileImage);
                            
                            $retrndata1 = $this->loginModel->lastLogin($retrndata['salesManagerId']);

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

        return view('salesmanager/index',$data);

    }

    public function logout()
    {
        
        $dtm = date("Y-m-d h:i:s");
        if($this->session->has('salesmanagerId')){
            
            $table ='login_data';
            $updtid = session()->get('login_data_id');
            $updtdata = [
                'date_logout'=>$dtm,
            ];
            $upclnm = 'login_data_id';
            $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            session()->remove('salesmanagerId');
            session()->remove('logged_img');
            session()->remove('logged_intype');
            session()->remove('login_data_id');
            session()->remove('usrName');
            session()->remove('usrLastLogin');
        }
            return redirect()->to(base_url().'/salesmanagerLogin');
    }


    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="salesmanager";
        $upclnm="salesManagerId";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Sales Manager Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/managesalesmanager')); 

            $data["salesmanager"]=$this->loginModel->showSelectd();

            return view('admin/managesalesmanager',$data);
    }

    public function viewsalesmanagerProfile($idd){

        $data= [];

        $data['profileData'] = $this->loginModel->showprofiledetails1($idd);
        
        $data["salesmanagerPrd"]=$this->loginModel->viewprdata($idd);       
        

        return view('admin/viewsalesmanager',$data);
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
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "regnofsale"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Region Of Sale Is required ',
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
                $tollnme = $this->request->getVar('tollnme');
                $regnofsale = $this->request->getVar('regnofsale');
                             
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

                $alldata = $this->loginModel->showprofiledetails1($this->request->getVar('uppddtid'));
                

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/salesmanager/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = $alldata["ProfileImage"];
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/salesmanager/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                                 $nomineeproof = $alldata["idProof"];
                    }
                }

                if($this->request->getFile('drivingproof')){
                    if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                        $newdrivingproof = $drivingproof->getRandomName();
                        if($drivingproof->move(FCPATH.'public/adminasset/img/salesmanager/drivinglicence/',$newdrivingproof)){                           
                                $drivinglicenceproof = $newdrivingproof;
                        }
                    }else{
                                $drivinglicenceproof = $alldata["drivingLicenceProof"];
                    }
                }

                if($this->request->getFile('panproof')){
                    if($panproof->isValid() && !$panproof->hasMoved()){
                        $newpanproof = $panproof->getRandomName();
                        if($panproof->move(FCPATH.'public/adminasset/img/salesmanager/pancard/',$newpanproof)){                           
                                $pancardproof = $newpanproof;
                        }
                    }else{
                                $pancardproof = $alldata["panCardProof"];
                    }
                }

                if($this->request->getFile('aadharproof')){
                    if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                        $newaadharproof = $aadharproof->getRandomName();
                        if($aadharproof->move(FCPATH.'public/adminasset/img/salesmanager/aadharcard/',$newaadharproof)){                           
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
                    
                    $tablee="salesmanager";
                    $upclnm="salesManagerId";
                    $updtid=$alldata["salesManagerId"];
                    $updtdata = ["Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"regionOfSale"=>$regnofsale,"ProfileImage"=>$profileImage,"datetime"=>$dtm];
                    $salesagent = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    

                        $this->session->setTempdata('success','Sales Manager Profile Updated Successfully', 3);
                        return redirect()->to(base_url('secure/managesalesmanager/'.$alldata["salesManagerId"].''));
                    

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['editprofileData'] = $this->loginModel->showprofiledetails($idd);
     
        
        return view('admin/editsalesmanager',$data);

    }

    public function fastagInventory(){
        if ((!isset($_SESSION['salesmanagerId']))) {
            return redirect()->to(base_url('salesmanagerLogin'));            
        }

        $data= [];

        $dtm = date("Y-m-d h:i:s");
        $table="teamlead";
        $viewdata="*";
        $whrdata = array(
            'requestedById' => $_SESSION['salesmanagerId'],
            'status'   => 0
          );
        $data["teamlead"]=$this->loginModel->ftchmulti($table,$viewdata,$whrdata);

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
                            Select Team Lead
                            <input type="hidden" id="fastatgidd" value="'.$this->request->getVar('fastagid').'">
                            <input type="hidden" id="invntid" value="'.$this->request->getVar('invntid').'">
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" style="width:60%;" id="salesmanager">
                                <option value="">Select Team Lead</option>';
                                $cnt = count($data["teamlead"]);
                              for($i=0;$i<$cnt;$i++){
                                  $shw = $data["teamlead"][$i]["Fname"].' '.$data["teamlead"][$i]["Lname"].' ( '.$data["teamlead"][$i]["TleadRegdNum"].' )';
                         $response.='<option value="'.$data["teamlead"][$i]["teamleadId"].'">'.$shw.'</option>';
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
                
                $data = ["fasttagid"=>$fasttagid,"allotedto"=>$salesmngis,"allotedtotype"=>2,"allotedby"=>$_SESSION['salesmanagerId'],"allotedbytype"=>1,"status"=>'0',"datetime"=>$dtm];
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
        }
        

        $data['fastag'] = $this->loginModel->showfastag($_SESSION['salesmanagerId'],1);     
        
        return view('salesmanager/fastag',$data);

    }
}

?>