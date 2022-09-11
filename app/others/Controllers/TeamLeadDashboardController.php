<?php

namespace App\Controllers;

class TeamLeadDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){       
        $this->session = session();        
    }
    public function index()
    {

        if ((!isset($_SESSION['teamleadId']))) {

            return redirect()->to(base_url('teamleadLogin'));
            
        } else {

        $data= [];
    
    
        return view('teamlead/dashboard',$data);
    }
}
}

?>