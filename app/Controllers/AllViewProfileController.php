<?php

namespace App\Controllers;
use \App\Models\AllViewProfileModel;

class SalesManagerProfileController extends BaseController
{
    public $profileModel;
    public $session;

    public function __construct(){
        helper("form");
        $this->profileModel = new AllViewProfileModel();
        $this->session = session();
        
    }
    
    public function viewProfile($viewtype,$viewid){
        if(!$this->session->has('logged_usrid')){
            return redirect()->to(base_url('adminLogin'));
        }

        $data= [];

        $data['profileData'] = $this->profileModel->showprofiledetails1($_SESSION["salesmanagerId"]);
        

        return view('salesmanager/Profile',$data);
    }

}
