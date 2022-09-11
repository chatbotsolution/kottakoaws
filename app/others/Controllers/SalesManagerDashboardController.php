<?php

namespace App\Controllers;

class SalesManagerDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){       
        $this->session = session();        
    }
    public function index()
    {

        if ((!isset($_SESSION['salesmanagerId']))) {

            return redirect()->to(base_url('salesmanagerLogin'));
            
        } else {

        $data= [];
    
    
        return view('salesmanager/dashboard',$data);
    }
}
}

?>