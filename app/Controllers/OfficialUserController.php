<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;

class OfficialUserController extends BaseController
{
    public $loginModel;
    public $email;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new SalesManagerModel();
        $this->session = session();
        $email = \Config\Services::email();
        
    }

    public function addOfficialUsers()
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
                    'required'=>'Contact Number Is required ',
                ],
            ],
            "email"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Is required ',
                ],
            ], 
            "usrid"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Id Is required ',
                ],
            ],  
            "pass"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Password Is required ',
                ],
            ],
            "privilege"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'At Least One Privilege Is required ',
                ],
            ],  
            "module"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'At Least One Module Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $usrid = $this->request->getVar('usrid');
                $email = $this->request->getVar('email');  
                $pass = $this->request->getVar('pass');
              
                $privilege = $this->request->getVar('privilege');  
                $module = $this->request->getVar('module');
              
                $privilegetype = [];
                $privilegemodule = [];
              
                for($i=0;$i < sizeof($privilege); $i++){
                  $privilegetype[] = $privilege[$i];
                }
                $privileget = json_encode($privilegetype);
              
                for($j=0;$j < sizeof($module); $j++){
                  $privilegemodule[] = $module[$j];
                }                
                $privilegem = json_encode($privilegemodule);

                $profileimg = $this->request->getFile('profileimg');

                $table="admin";
                $viewdata="userid";
                $whrclm="userid";
                $whrval=$usrid;
                $usrdata = $this->loginModel->viewspecific1($table,$viewdata,$whrclm,$whrval);
                
                if($usrdata <= 0){
				
                $lastdataiddd = $this->loginModel->lastdata('admin');
                $lastuseradmid = 'ADM-KOT-'.substr($lastdataiddd[0]['admin_user_id'],8)+1;                  
                  
                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/users/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = "default";
                    }
                }                       
                            
                    $dtm = date("Y-m-d h:i:s");
                    $name = $fname.' '.$lname;
                    
                    $data = ["userid"=>$usrid,"password" =>md5(sha1(md5(sha1($pass)))), "name"=>$name, "email"=>$email,"contact_number"=>$contctnumprim, "image"=>$profileImage, "otp"=>0, "admin_type"=>8, "datetime"=>$dtm, "status"=>0,"privilegetype"=>$privileget,"privilegemodule"=>$privilegem,"admin_user_id"=>$lastuseradmid];
                    $loginData = $this->loginModel->loginDatainsert('admin',$data);
                    $uid = $this->loginModel->db->insertID(); 

                    if($loginData){
                        $this->session->setTempdata('success','User Added Successfully', 3);
                        return redirect()->to(base_url('secure/addofficialuser'));
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                        return redirect()->to(base_url('secure/addofficialuser'));
                    }    
                }else{
                    $this->session->setTempdata('error','User Already Exists', 3);
                    return redirect()->to(base_url('secure/addofficialuser'));
                }
            }else{
                $data['validations'] = $this->validator;
            }
        }


            return view('admin/addOfficialuser',$data);
    }


    public function manageusers(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $data=[];
        $table="admin";
        $viewdata="`admin_id`, `userid`, `password`, `name`, `email`, `contact_number`, `image`, `otp`, `admin_type`, `datetime`, `status`";
        $whrclm="admin_type";
        $whrval=8;
        $data["users"]=$this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
        

        return view('admin/manageusers',$data);
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="admin";
        $upclnm="admin_id";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','User Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/manageofficialuser')); 

            $table="admin";
            $viewdata="`admin_id`, `userid`, `password`, `name`, `email`, `contact_number`, `image`, `otp`, `admin_type`, `datetime`, `status`";
            $whrclm="admin_type";
            $whrval=8;
            $data["users"]=$this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);
            

            return view('admin/manageusers',$data);
    }

    public function updtPass(){

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('changePassid')){

                $response='
                <div class="modal-header">
                                <h5 class="modal-title">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <span id="shwlrt">
                                </span>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">New Password<span style="color: red">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" id="password" value="" Placeholder="New Password" class="form-control mg-b-10">
                                        <span class="errmsg" id="pass" style="text-align:left;"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm Password<span style="color: red">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="confirmpassword" id="confirmpassword" value="" Placeholder="Confirm Password" class="form-control mg-b-10">
                                        <span class="errmsg" id="cnfrmpass" style="text-align:left;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="updtPass(\''.$_POST["changePassid"].'\');">Update Password</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>';

                echo $response;
                exit;

            }

            if($this->request->getVar('updtidd')){
                $updtidd = $_POST["updtidd"];
                $password = $_POST["password"];
                $confirmpassword = $_POST["confirmpassword"];

                if($confirmpassword != $password){
                    $response="sorry";
                }else{

                    $table="admin";
                    $upclnm="admin_id";
                    $updtdata = [
                        'password'=>md5(sha1(md5(sha1($password)))),
                    ];
                    $updtid=$updtidd;
                    $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                        $response="done";
                }
                echo $response;
                exit;
            }

            
        }

    }

    public function editOfficialUsers($id)
    {
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        $data=[];
        $rules = [
            "fname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Name Is required ',
                ],
            ],           
            "contctnumprim"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Contact Number Is required ',
                ],
            ],
            "email"=>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required'=>'Email Is required ',
                ],
            ], 
            "usrid"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Id Is required ',
                ],
            ],         
        ];

        if($this->request->getMethod() == "post"){
            
            if($this->validate($rules)){
                $fname = $this->request->getVar('fname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $usrid = $this->request->getVar('usrid');
                $email = $this->request->getVar('email');
                $profileimg = $this->request->getFile('profileimg');

                $table1="admin";
                $viewdata1="admin_id,userid,name,email,contact_number,image,admin_type,datetime,status";
                $whrclm1="admin_id";
                $whrval1=$id;
                $usrdata = $this->loginModel->viewspecific1($table1,$viewdata1,$whrclm1,$whrval1);
                $dtm = date("Y-m-d h:i:s");
                
                
                if($usrdata != 0){
                    
                if($this->request->getFile('profileimg')){                    
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/users/profileimage/',$newprofileimg)){                           
                            $table="admin";
                            $upclnm="admin_id";
                            $updtdata = [
                                'userid'=>$usrid,
                                'name'=>$fname, 
                                'email'=>$email,
                                'contact_number'=>$contctnumprim,
                                'image'=>$newprofileimg, 
                                'datetime'=>$dtm, 
                                'status'=>0,
                            ];
                            $updtid=$id;
                            $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        }
                    }else{
                        $table="admin";
                        $upclnm="admin_id";
                        $updtdata = [
                            "userid"=>$usrid, 
                            "name"=>$fname,
                            "email"=>$email,
                            "contact_number"=>$contctnumprim,
                            "datetime"=>$dtm, 
                            "status"=>0,
                        ];
                        $updtid=$id;
                        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    }
                }   
                        $this->session->setTempdata('success','User Updated Successfully', 3);
                        return redirect()->to(base_url('secure/editofficialusers/'.$id.''));    
                }else{
                    $this->session->setTempdata('error','Sorry Try Again Later', 3);
                    return redirect()->to(base_url('secure/editofficialusers/'.$id.''));
                }
            }else{
                $data['validations'] = $this->validator;
            }
        }

        if($id == 1){
            return redirect()->to(base_url('secure/manageofficialuser'));
        }

        $table1="admin";
        $viewdata1="admin_id,userid,name,email,contact_number,image,admin_type,datetime,status";
        $whrclm1="admin_id";
        $whrval1=$id;
        $data["users"]=$this->loginModel->viewspecific($table1,$viewdata1,$whrclm1,$whrval1);

            return view('admin/editofficialuser',$data);
    }
}

?>