<?php

namespace App\Controllers;
use \App\Models\SalesAgentModel;

class TeamLeadDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){       
        $this->session = session(); 
        $this->loginModel = new SalesAgentModel();       
    }
    public function index()
    {

        if ((!isset($_SESSION['teamleadId']))) {

            return redirect()->to(base_url('teamleadLogin'));
            
        } else {

        $data= [];
          echo $_SESSION['teamleadId'];
            $endt_ftr = date( 'Y-m-d', strtotime( date("Y-m-d") . ' +1 day' ) );

            $rt = date("Y-m-d").' 00:00:00';
            $rte = $endt_ftr.' 00:00:00';
          
            $yestrdaystart = date( 'Y-m-d', strtotime( date("Y-m-d") . ' -1 day' ) );
            $yestrdstrt = $yestrdaystart.' 00:00:00';
          
            $yestrdayend = date("Y-m-d").' 00:00:00';
    	
          $saleagesnt =  $this->loginModel->showSelectdTeamAgent($_SESSION['teamleadId']);
          $sales=0;
          $activeagent =0;
          $yesterdayssales=0;
          $yesterdaysactiveagent =0;
          $lastweeksales=0;
          $lastweekactiveagent =0;
          
          for($i=0; $i < sizeof($saleagesnt); $i++){
              $salgentid = $saleagesnt[$i]["salesagentId"];
            // Todays Report
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salgentid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
            if($salescount != 0){
              $sales=$sales+$salescount;
              $activeagent =$activeagent+1;
            }
            
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salgentid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
            if($salescount != 0){
              $sales=$sales+1;
              $activeagent =$activeagent+1;
            }
            
           // Yesterdays Report
            
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salgentid , 'salesagentType' =>0,'datetime >=' => $yestrdstrt,'datetime <=' => $yestrdayend);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationExistingUser','*',$array);
              $salescount = sizeof($data['customer']);
            if($salescount != 0){
              $yesterdayssales=$yesterdayssales+$salescount;
              $yesterdaysactiveagent =$yesterdaysactiveagent+1;
            }
            
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salgentid , 'salesagenttype' =>0,'datetime >=' => $yestrdstrt,'datetime <=' => $yestrdayend);
              $data['customer'] = $this->loginModel->viewspecificoth('tagactivationinitial','*',$array);
              $salescount = sizeof($data['customer']);
            if($salescount != 0){
              $yesterdayssales=$yesterdayssales+$salescount;
              $yesterdaysactiveagent =$yesterdaysactiveagent+1;
            }
            
          // Last week Report
            
             $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $salgentid , 'salesagenttype' =>0);
             $data['customer'] = $this->loginModel->viewspecificothh('tagactivationinitial','*',$array);
             $salescount= sizeof($data['customer']);
            if($salescount != 0){
              $lastweeksales=$lastweeksales+$salescount;
              $lastweekactiveagent =$lastweekactiveagent+1;
            }
            
             $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $salgentid , 'salesagentType' =>0);
             $data['customer'] = $this->loginModel->viewspecificothh('tagactivationExistingUser','*',$array);
             $salescount= sizeof($data['customer']);
            if($salescount != 0){
              $lastweeksales=$lastweeksales+$salescount;
              $lastweekactiveagent =$lastweekactiveagent+1;
            }
          }
          
       //Fastag Count 
          
          $data['alloted'] = sizeof($this->loginModel->multiSrchnw("fastaginventory","*","allotedto",$_SESSION['teamleadId'],"allotedtotype",2,"status",1));
          $data['unalloted'] = sizeof($this->loginModel->multiSrchnw("fastaginventory","*","allotedto",$_SESSION['teamleadId'],"allotedtotype",2,"status",0));
          
        $data["todaysales"]=$sales;
        $data["todayactiveagent"]=$activeagent;
        $data["yesterdayssales"]=$yesterdayssales;
        $data["yesterdaysactiveagent"]=$yesterdaysactiveagent;
        $data["lastweeksales"]=$lastweeksales;
        $data["lastweekactiveagent"]=$lastweekactiveagent;
        $data["salesagent"]=sizeof($saleagesnt);
    
        return view('teamlead/dashboard',$data);
    }
}
}

?>