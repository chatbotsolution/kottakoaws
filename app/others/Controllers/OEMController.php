<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;

class OEMController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');
        $this->loginModel = new SalesManagerModel();
        $this->oemModel = new OemModel();
        $this->productmodel = new ProductModel();
        $this->session = session();
        
    }

    public function index()
    {
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        $data=[];
        $rules = [
            "compnyname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Company Name Is required ',
                ],
            ],
            "tradename"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Trade Name Is required ',
                ],
            ],
            "gstnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'GST Number Is required ',
                ],
            ],
            "pancardnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Card Number Is required ',
                ],
            ],
            "spocnumber"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Number Is required ',
                ],
            ],
            "spocdetails"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Details Is required ',
                ],
            ],
            "gmcontact"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'GM Contact Is required ',
                ],
            ],
            "gmname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'GM Name Is required ',
                ],
            ],
            "hodcity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Head Office City Is required ',
                ],
            ],
            "noofbranch"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Branches Is required ',
                ],
            ],
            "manufacturer"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Manufacturer Is required ',
                ],
            ],
            "gstcertificate"=>'uploaded[gstcertificate]|max_size[gstcertificate,1024]|ext_in[gstcertificate,jpg,jpeg,JPEG,JPG,pdf,PDF]',
            
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $compnyname = $this->request->getVar('compnyname');
                $tradename = $this->request->getVar('tradename');
                $gstnum = $this->request->getVar('gstnum');   
                $pancardnum = $this->request->getVar('pancardnum');
                $spocnumber = $this->request->getVar('spocnumber');
                $spocdetails = $this->request->getVar('spocdetails'); 
                $gmcontact = $this->request->getVar('gmcontact'); 
                $gmname = $this->request->getVar('gmname');
                $brandLogo = $this->request->getFile('gstcertificate');   
                
                $manufacturer = $this->request->getVar('manufacturer');
                $noofbranch = $this->request->getVar('noofbranch');
                $hodcity = $this->request->getVar('hodcity');

                    if($brandLogo->isValid() && !$brandLogo->hasMoved()){
                        $newbrandLogo = $brandLogo->getRandomName();
                        if($brandLogo->move(FCPATH.'public/adminasset/oemdocument/',$newbrandLogo)){                           
                            
                                $dtm = date("Y-m-d h:i:s");
                                
                                $data = ["companyname"=>$compnyname,"manufacturer"=>$manufacturer,"noofbranch"=>$noofbranch,"hodcity"=>$hodcity,"tradename"=>$tradename,"gstnumber"=>$gstnum,"pancardnumber"=>$pancardnum,"spocnumber"=>$spocnumber,"spocdetails"=>$spocdetails,"gmcontact"=>$gmcontact,"gmname"=>$gmname,"gstcertificate"=>$newbrandLogo,"status"=>'0',"datetime"=>$dtm,"requestbyid"=>0];

                                $loginData = $this->loginModel->loginDatainsert('oem',$data);

                                if($loginData){
                                    $this->session->setTempdata('success','OEM Added Successfully', 3);
                                    return redirect()->to(base_url('secure/addoem'));
                                }else{
                                    $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                                    return redirect()->to(base_url('secure/addoem'));
                                }     
                        }
                    }else{
                            echo $brandLogo->getErrorString()."".$brandLogo->getError();
                    }
            }else{
                $data['validations'] = $this->validator;
            }
        }

        $table1="manufacturer";
        $viewdata1="manufactureid ,manufacturername,status";
        $whrclm1="status";
        $whrval1=0;
        $data["manufacturer"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);
            return view('admin/addoem',$data);
    }

    public function managemanageoem(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $data=[];
        $data["oemdata"]=$this->loginModel->vweAll("oem");
        
        return view('admin/manageoem',$data);
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="oem";
        $upclnm="oemid";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','OEM Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/manageoem')); 

            $data["oemdata"]=$this->loginModel->vweAll("oem");
        
            return view('admin/manageoem',$data);
    }

    public function viewoemProfile($idd){

        $data= [];

        $data['oem'] = $this->loginModel->showprofiledetailsoem($idd);
       
        $data['oempayments'] =  $this->loginModel->searchh('oempayments','*','oemid',$idd);
        
        if($data['oem']['requestbyid'] != 0){
            $data['reqstby'] = $this->loginModel->oemReqstmanager($data['oem']['requestbyid']);
        }

        return view('admin/viewoem',$data);
    }

    public function editProfileAdmin($idd){

        $data= [];

        $rules = [
            "compnyname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Company Name Is required ',
                ],
            ],
            "tradename"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Trade Name Is required ',
                ],
            ],
            "gstnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'GST Number Is required ',
                ],
            ],
            "pancardnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Card Number Is required ',
                ],
            ],
            "spocnumber"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Number Is required ',
                ],
            ],
            "spocdetails"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'SPOC Details Is required ',
                ],
            ],
            "gmcontact"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'GM Contact Is required ',
                ],
            ],
            "hodcity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Head Office City Is required ',
                ],
            ],
            "noofbranch"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Branches Is required ',
                ],
            ],
            "manufacturer"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Manufacturer Is required ',
                ],
            ],            
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $compnyname = $this->request->getVar('compnyname');
                $tradename = $this->request->getVar('tradename');
                $gstnum = $this->request->getVar('gstnum');   
                $pancardnum = $this->request->getVar('pancardnum');
                $spocnumber = $this->request->getVar('spocnumber');
                $spocdetails = $this->request->getVar('spocdetails'); 
                $gmcontact = $this->request->getVar('gmcontact'); 
                $brandLogo = $this->request->getFile('gstcertificate');   
                
                $manufacturer = $this->request->getVar('manufacturer');
                $noofbranch = $this->request->getVar('noofbranch');
                $hodcity = $this->request->getVar('hodcity');

                $alldata = $this->loginModel->showprofiledetailsoem($idd);
                if($this->request->getFile('gstcertificate')){
                    if($brandLogo->isValid() && !$brandLogo->hasMoved()){
                        $newbrandLogo = $brandLogo->getRandomName();
                        if($brandLogo->move(FCPATH.'public/adminasset/oemdocument/',$newbrandLogo)){                           
                            $gstcrtfct = $newbrandLogo;     
                        }
                    }else{
                            $gstcrtfct = $alldata["gstcertificate"]; 
                    }
                }
                $dtm = date("Y-m-d h:i:s");

                    $tablee="oem";
                    $upclnm="oemid";
                    $updtid=$alldata["oemid"];
                    $updtdata = ["companyname"=>$compnyname,"manufacturer"=>$manufacturer,"noofbranch"=>$noofbranch,"hodcity"=>$hodcity,"tradename"=>$tradename,"gstnumber"=>$gstnum,"pancardnumber"=>$pancardnum,"spocnumber"=>$spocnumber,"spocdetails"=>$spocdetails,"gmcontact"=>$gmcontact,"gstcertificate"=>$gstcrtfct,"datetime"=>$dtm];
                    $salesagent = $this->loginModel->entry_update($tablee,$upclnm,$updtdata,$updtid);

                        $this->session->setTempdata('success','OEM Profile Updated Successfully', 3);
                        return redirect()->to(base_url('secure/editoem/'.$alldata["oemid"].''));
                    

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['editprofileData'] = $this->loginModel->showprofiledetailsoem($idd);
        $table1="manufacturer";
        $viewdata1="manufactureid ,manufacturername,status";
        $whrclm1="status";
        $whrval1=0;
        $data["manufacturer"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);
        
        return view('admin/editoem',$data);

    }

    public function oemAproval(){
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }

        $data=[];

        $data["oemdata"] = $this->loginModel->requestshow();
        
        return view('admin/approveoem',$data);
    }

    public function login(){
        if ((isset($_SESSION['oemid']))) {
            return redirect()->to(base_url('oem/dashboard'));            
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

        return view('oem/index',$data);
    }

    public function sendotp(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $userid = $this->request->getVar('usrid');
                $otp = random_string('numeric', 4);

                $retrndata = $this->oemModel->findSelect($userid);
                
                if($retrndata){

                    $table ='oem';
                    $upclnm ='oemid';
                    $updtdata = [
                        'otp'=>$otp,
                    ];
                    $updtid = $retrndata["oemid"];
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                 
                    
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
                    $response='invalid';
                }

                echo $response;
                exit;
            }

            if($this->request->getVar('loginusrid')){
                $loginusrid = $this->request->getVar('loginusrid');
                $usrotp = $this->request->getVar('usrotp');

                $retrndata = $this->oemModel->findSelect($loginusrid);
                                
                if($retrndata){
                    if($retrndata["status"] == 0){
                        
                        if($usrotp == $retrndata["otp"]){

                            $tablee ='oem';
                            $updtide = $retrndata["oemid"];
                            $updtdatae = [
                                'otp'=>null,
                            ];
                            $upclnme = 'oemid';
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

                            $data = ["user_ip_add"=>$ip,'user_type'=>5,'login_id'=>$retrndata['oemid'],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];
                            
                            $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                            $lid = $this->loginModel->db->insertID();
                            if($retrndata["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $retrndata["ProfileImage"]; }

                            $profileImage = $prf;

                            $this->session->set('oemid',$retrndata['oemid']);
                            $this->session->set('logged_intype',5);
                            $this->session->set('login_data_id',$lid);
                            $this->session->set('logged_img',$profileImage);
                            
                            $retrndata1 = $this->loginModel->lastLogin($retrndata['oemid']);

                            if($retrndata1 == false){
                                $lstLogin="";
                            }else{
                                $lstLogin=$retrndata1['datetime_login'];
                            }
                            $usrnmm = $retrndata["companyname"];
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

        return view('oem/ncpitag',$data);
    }

    public function logout(){
        
        $dtm = date("Y-m-d h:i:s");
        if($this->session->has('oemid')){
            
            $table ='login_data';
            $updtid = session()->get('login_data_id');
            $updtdata = [
                'date_logout'=>$dtm,
            ];
            $upclnm = 'login_data_id';
            $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            session()->remove('oemid');
            session()->remove('logged_img');
            session()->remove('logged_intype');
            session()->remove('login_data_id');
            session()->remove('usrName');
            session()->remove('usrLastLogin');
        }
            return redirect()->to(base_url().'/oemLogin');
    }

    public function fastagInventory(){
        if ((!isset($_SESSION['oemid']))) {
            return redirect()->to(base_url('oemid'));            
        }

        $data= [];        

        $data['fastag'] = $this->loginModel->showfastag($_SESSION['oemid'],5);     
        
        return view('oem/fastag',$data);

    }

    public function tagActivation(){
        if ((!isset($_SESSION['oemid']))) {
            return redirect()->to(base_url('oemLogin'));            
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
                                    <option value="Commercial"> Commercial </option>
                                    <option value="Non-Commercial"> Non-Commercial </option>
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
                            <div class="col-md-12">                                            
                                <input type="button" class="btn btn-main-primary" style="width:10%;" onclick="validateSubmit();" value="Make Payment">
                            </div>
                ';               

                echo $response;
                exit;
            }

            if($this->request->getVar('fstagclsssub')){

                $fstagclsssub = $this->request->getVar('fstagclsssub');
                $barcodetypsub = $this->request->getVar('barcodetypsub');
                $custnamesub = $this->request->getVar('custnamesub');
                $mobilenumbersub = $this->request->getVar('mobilenumbersub');
                $vehiclenumbersub = $this->request->getVar('vehiclenumbersub');
                $pancardnumsub = $this->request->getVar('pancardnumsub');
                $typee = $this->request->getVar('typee');
                $prd = $this->request->getVar('prd');
                $dtm = date('Y-m-d h:i:s');
                $postdata = array("custnamesub"=>$custnamesub, "mobilenumbersub"=>$mobilenumbersub, "vehiclenumbersub"=>$vehiclenumbersub, "pancardnumsub"=>$pancardnumsub);
                $signature = generateSignature($postdata);

                $fstg = $this->loginModel->viewspecific('product','fastagprice','productid',$prd); 
                $salesagentdetails = $this->loginModel->viewspecific('salesagent','salesagentmailid','salesagentId',$_SESSION['salesagentId']);
                $orderId = time();
                $orderAmount = $fstg[0]['fastagprice']; 
                $purchasenote = 'Tag Purchase For Vehicle'.$vehiclenumbersub;
                
                $databankdetails = ["productid"=>$prd,"classofBarcode"=>$barcodetypsub,"vehicleType"=>$typee,"mobileNumber"=>$mobilenumbersub,"vehiclechasisnumber"=>strtoupper($vehiclenumbersub),"salesagentId"=>$_SESSION['salesagentId'],"transactionstatus"=>1,"transactionid"=>$orderId,"datetime"=>$dtm,"pancarddetails"=>strtoupper($pancardnumsub),"customername"=>$custnamesub];
                $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$databankdetails);
                $bankid = $this->loginModel->db->insertID();  
                $this->session->set('setTagactivationId',$orderId); 
                $this->session->set('paymentstatus','failed');        
                
                    $salesmailid = $salesagentdetails[0]['salesagentmailid'];
                    $returnurl=base_url().'/salesagent/paymentstatus';
                    $notifyurl=base_url().'/salesagent/paymentstatus';

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

            if($this->request->getVar('ddob')){

                $ddob = date("Y/m/d", strtotime($this->request->getVar('ddob')));

                $salesagentdetails = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$_SESSION["setTagactivationId"]);
                $salesgnt = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION["salesagentId"]);

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
        // $tnid = time();
        // $img_file = 'https://hitchpayments.com/assets/images/logo.png';
        // $img = base64_encode(file_get_contents($img_file));
        // echo $img;

        // echo addVehicle($tnid,$img);
        // exit;

           
        if(isset($_SESSION["setTagactivationId"]) && $_SESSION['paymentstatus'] == "success"){
            $orderId =  $_SESSION["setTagactivationId"];
            $salesagentid = $_SESSION['salesagentId'];

            $data['somedata'] = $this->loginModel->multiSrch('tagactivationinitial','*','transactionid',$orderId,'salesagentId',$salesagentid);
        }    

        $data['tagclass'] = $this->productmodel->distinctVal("fasttag","classoftag");
        $data['product'] = $this->loginModel->viewprdata($_SESSION['oemid']);
        
        return view('oem/tagactivation',$data);
    }

    public function requestfastag()
    {
        if ((!isset($_SESSION['oemid']))) {

            return redirect()->to(base_url('oemLogin'));
            
        }
        $data=[];
        $rules = [
            "prdclass"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Fastag Class Is required ',
                ],
            ],
            "nofatag"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Fastag Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $prdclass = $this->request->getVar('prdclass');
                $nofatag = $this->request->getVar('nofatag');                           
                            
                $dtm = date("Y-m-d h:i:s");
                
                $data = ["numberoffastag"=>$nofatag,"classoftag"=>$prdclass,"requestedbyid"=>$_SESSION["oemid"],"status"=>0,"datetime"=>$dtm];

                $loginData = $this->loginModel->loginDatainsert('fastagrequest',$data);

                if($loginData){
                    $this->session->setTempdata('success','Fastag Request Send Successfully', 3);
                    return redirect()->to(base_url('oem/requestfastag'));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Send Try Again Later', 3);
                    return redirect()->to(base_url('oem/requestfastag'));
                } 
            }else{
                $data['validations'] = $this->validator;
            }
        }


        $data["claassftag"]=$this->productmodel->distinctVal('fasttag','classoftag');
        $data["oemreqst"]=$this->oemModel->viewspecific('fastagrequest','*','requestedbyid',$_SESSION["oemid"]);

            return view('oem/requestfastag',$data);
    }


    public function topup(){
        if ((!isset($_SESSION['oemid']))) {
            return redirect()->to(base_url('oemLogin'));            
        }

        $data=[];
        $rules = [
            "mobnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Mobile Number Is required ',
                ],
            ],
            "topupamt"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Topup Amount Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $mobnum = $this->request->getVar('mobnum');
                $topupamt = $this->request->getVar('topupamt'); 
                $reqid = time();                          
                            
                $data['topupdata'] = Topup($mobnum,$topupamt,$reqid);

                $data1 = json_decode($data['topupdata'])[0];
                $array = json_decode(json_encode($data1), true);

                if($array['RESPONSECODE'] == 00){
                    $this->session->setTempdata('success','Fastag Topup Successfull', 3);
                    return redirect()->to(base_url('oem/topup'));
                }else{
                    $this->session->setTempdata('error','Sorry Unable To Send Try Again Later', 3);
                    return redirect()->to(base_url('oem/topup'));
                }
            }else{
                $data['validations'] = $this->validator;
            }
        }

        return view('oem/topup',$data);
    }
}

?>