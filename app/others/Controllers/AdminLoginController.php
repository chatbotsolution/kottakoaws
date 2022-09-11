<?php

namespace App\Controllers;
use \App\Models\LoginModel;

class AdminLoginController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        $this->loginModel = new loginModel();
        $this->session = session();
        
    }
    public function index()
    {

        if ((isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('/secure/dashboard'));
            
        } else {

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
        
            return view('admin/index',$data);
        }
    }

    public function logout()
    {
        
        $dtm = date("Y-m-d h:i:s");
        if($this->session->has('logged_usrid')){
            
            $table ='login_data';
            $uom_id = session()->get('login_data_id');
            $data = [
                'date_logout'=>$dtm,
            ];
            $updtid = 'login_data_id';
            $this->loginModel->entry_update($table,$uom_id,$data,$updtid);
            
            session()->remove('logged_usrid');
            session()->remove('logged_inid');
            session()->remove('logged_intype');
            session()->remove('login_data_id');
        }
            return redirect()->to(base_url().'/adminLogin');
    }
}

?>