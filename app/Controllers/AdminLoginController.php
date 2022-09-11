<?php

namespace App\Controllers;
use \App\Models\LoginModel;

class AdminLoginController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('email');
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
                    
                        $admndta = $this->loginModel->searchh('admin','*','admin_id',1);
                        
                        $to = $admndta[0]['email'];
                        $from = "connect@kottakotabusinesses.com";
                        $subject ="Login Notification";
                        $message ="Some Tried To Login";
                        sendEMail($to,$from,$subject,$message);
                                
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
  
  
  
  	public function official(){
      
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
                        $retrndata = $this->loginModel->verifyUserid($userid,8);
        
                    if($retrndata){
                        $profileImage=$retrndata['image'];
                        
                      if($profileImage == "default"){
                         $profileImage ="default_user.jpg";
                      }else{
						 $profileImage = $profileImage;
                      }
                            
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
                                  $edit =1;
                                  $view =1;
                                  $fastag =1;
                                  $product =1;
                                  $users =1;
                                  $wallet =1;
                                  $pin =1;
                                  $banner =1;
                                  $report =1;
                                  $permissionletter =1;
                                  $vehclupdtrqst =1;
        			                
                                  echo"<pre>";
                                    print_r($retrndata['privilegetype']);
                                    print_r($retrndata['privilegemodule']);
                                  
                                    for($io =0; $io < sizeof(json_decode($retrndata['privilegetype'])); $io++){
                                      
                                       if(json_decode($retrndata['privilegetype'])[$io] =="edit"){
                                         $edit =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegetype'])[$io] =="view"){
                                         $view =0;
                                       }
                                      
                                    }
                                  
                                    for($ioi =0; $ioi < sizeof(json_decode($retrndata['privilegemodule'])); $ioi++){
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="fastag"){
                                         $fastag =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="product"){
                                         $product =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="users"){
                                         $users =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="wallet"){
                                         $wallet =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="pin"){
                                         $pin =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="banner"){
                                         $banner =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="report"){
                                         $report =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="permissionletter"){
                                         $permissionletter =0;
                                       }
                                      
                                       if(json_decode($retrndata['privilegemodule'])[$ioi] =="vehclupdtrqst"){
                                         $vehclupdtrqst =0;
                                       }
                                      
                                    }
                                  
                                  
                                    
                                  
                                  
                                    $this->session->set('module_edit',$edit);
                                    $this->session->set('module_view',$view);
                                    $this->session->set('module_fastag',$fastag);
                                    $this->session->set('module_product',$product);
                                    $this->session->set('module_users',$users);
                                    $this->session->set('module_wallet',$wallet);
                                    $this->session->set('module_pin',$pin);
                                    $this->session->set('module_banner',$banner);
                                    $this->session->set('module_report',$report);
                                  	$this->session->set('module_permissionletter',$permissionletter);
                                    $this->session->set('module_vehclupdtrqst',$vehclupdtrqst);
                                  
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
        
            return view('admin/officialogin',$data);
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
          
           $a= $_SESSION["logged_intype"];
            
            //session()->remove('logged_usrid');
            //session()->remove('logged_inid');
            //session()->remove('logged_intype');
            //session()->remove('login_data_id');
          session_destroy();
        }
      
          if($a == 8){
            return redirect()->to(base_url().'/officialLogin');
          }else{
            return redirect()->to(base_url().'/adminLogin');
          }
            
    }
}

?>