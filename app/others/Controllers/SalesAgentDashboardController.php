<?php

namespace App\Controllers;

class SalesAgentDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){       
        $this->session = session();        
    }
    public function index()
    {

        if ((!isset($_SESSION['salesagentId']))) {

            return redirect()->to(base_url('salesagentLogin'));
            
        } else {

        $data= [];
    
    
        return view('salesagent/dashboard',$data);
    }
}
}

?>