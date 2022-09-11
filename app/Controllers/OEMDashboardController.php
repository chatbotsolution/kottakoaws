<?php

namespace App\Controllers;

class OEMDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){       
        $this->session = session();        
    }
    public function index()
    {

        if ((!isset($_SESSION['oemid']))) {

            return redirect()->to(base_url('oemLogin'));
            
        } else {

        $data= [];
    
    
        return view('oem/dashboard',$data);
    }
}
}

?>