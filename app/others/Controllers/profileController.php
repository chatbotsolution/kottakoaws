<?php

namespace App\Controllers;
use \App\Models\ProfileModel;

class profileController extends BaseController
{
    public $profileModel;
    public $session;

    public function __construct(){
        helper("form");
        $this->profileModel = new ProfileModel();
        $this->session = session();
        
    }

    public function editProfile(){
        if(!$this->session->has('logged_usrid')){
            return redirect()->to(base_url('adminLogin'));
        }

        $data= [];

        $rules = [
            "uname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Name Is required ',
                ],
            ],
            "uemail"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Email Is required ',
                ],
            ],
            "ucontact"=>[
                'rules'=>'required|numeric|min_length[10]|max_length[10]',
                'errors'=>[
                    'required'=>'User Contact Number Is required ',
                ],
            ],
            "userId"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'User Id Is required ',
                ],
            ],            
        ];

        if($this->request->getMethod() == "post"){

            if($this->validate($rules)){

                $dtm = date("Y-m-d h:i:s");
                $uname = $this->request->getVar('uname');
                $uemail = $this->request->getVar('uemail');
                $pass = $this->request->getVar('Upassword');
                $password = md5(sha1(md5(sha1($pass))));
                $ConfirmPass = $this->request->getVar('ConfirmPass'); 
                $newPass = md5(sha1(md5(sha1($ConfirmPass))));  
                $userId = $this->request->getVar('userId'); 
                $profilr =$this->request->getFile('profilr'); 
                
                $tablee="admin";
                $selct="userid,password,image";
                $typ="admin_id";
                $idd="1";
                $newdata = $this->profileModel->ftchAdminData($tablee,$selct,$typ,$idd);

                if($newdata['password'] == $password){
                    $profileImage=$newdata["image"];
                    if($profilr){
                        $validated = $this->validate([
                            'profilr' => [
                                'uploaded[profilr]',
                                'mime_in[profilr,image/jpg,image/jpeg,image/gif,image/png,image/PNG,image/JPG,image/JPEG]',
                                'max_size[profilr,1024]',
                            ],
                        ]);
                  
                        if ($validated) {                    
                            $newprofilr = $profilr->getRandomName();
                            if($profilr->move(FCPATH.'public/adminasset/img/faces/',$newprofilr)){     
                                $profileImage=$newprofilr; 
                                $oldImage= $newdata["image"];
                                unlink("public/adminasset/img/faces/".$oldImage);                        
                            }
                        }                
                    }

                    if($this->request->getVar('ConfirmPass')){
                        $data1 = [
                            'userid' =>$userId,
                            'name' =>$this->request->getVar('uname'),
                            'email' =>$this->request->getVar('uemail'),
                            'contact_number' =>$this->request->getVar('ucontact'),                            
                            'password' =>$newPass,
                            'datetime' =>$dtm,
                            'image'=>$profileImage,
                        ];
                    }else{
                        $data1 = [
                            'userid' =>$userId,
                            'name' =>$this->request->getVar('uname'),
                            'email' =>$this->request->getVar('uemail'),
                            'contact_number' =>$this->request->getVar('ucontact'),
                            'datetime' =>$dtm,
                            'image'=>$profileImage,
                        ];
                    }

                    if($this->profileModel->updtAdminData($data1)){
                        $this->session->set('logged_img',$profileImage);
                        $this->session->setTempdata('success','User Updated Successfully', 3);
                        return redirect()->to(base_url('/secure/editProfile'));
                    }

                }else{
                    $this->session->setTempdata('error','Invalid Present Password', 3);
                    return redirect()->to(base_url('/secure/editProfile'));
                }
            }else{
                $data['validations'] = $this->validator;
            }
        }


        $data['profileData'] = $this->profileModel->findAdminData();
        return view('admin/editProfile',$data);

    }
    
    public function viewProfile(){
        if(!$this->session->has('logged_usrid')){
            return redirect()->to(base_url('adminLogin'));
        }

        $data= [];

        $tablee="admin";
        $selct="userid,name,email,contact_number,image";
        $typ="admin_id";
        $idd="1";
        $data["profile"] = $this->profileModel->ftchAdminData($tablee,$selct,$typ,$idd);

        return view('admin/Profile',$data);
    }

}
