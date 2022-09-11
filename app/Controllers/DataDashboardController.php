<?php

namespace App\Controllers;
use \App\Models\LoginModel;
use \App\Models\SalesAgentModel;
use \App\Models\SalesManagerModel;
use \App\Models\AllViewProfileModel;

class DataDashboardController extends BaseController
{
    public $loginModel;
    public $salesagentModel;
    public $smModel;
    public $allModel;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new LoginModel();
        $this->salesagentModel = new SalesAgentModel();
        $this->smModel = new SalesManagerModel();
        $this->allModel = new AllViewProfileModel();
        $this->session = session();
        
    }

    public function newusrdata()
    {
      
      if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        
        $data=[];
        
        if($this->request->getMethod() == "post"){
        
            if($this->request->getVar('srchval')){
                
                  $likebarcode =  $this->smModel->vehiclenumberlike('tagactivationinitial',$this->request->getVar('srchval'));
                  $cnt = sizeof($likebarcode);
                      if($cnt == 0){
							$response='
                               <tr>
                                 <td colspan="8"> No Data Found..</td>
                               </tr>                            
                            ';
                        echo $response;
                      }else{
                        $i=0;
                        foreach($likebarcode as $likk){
                        $i++;
                        
                        $salesagentId =$likk["salesagentId"];
                        
                        $salsagnt = $this->smModel->viewspecific('salesagent','*','salesagentId',$salesagentId);
                        
                        $tlid = $salsagnt[0]['requestedById'];
                        $tmlead = $this->smModel->viewspecific('teamlead','*','teamleadId',$tlid);
                        $smid = $tmlead[0]['requestedById'];
                        $smdta = $this->smModel->viewspecific('salesmanager','*','salesManagerId',$smid);
                        
                        $response='
                             <tr>
                                <td>'.$i.'</td>
                                <td>'.$smdta[0]["Fname"].' '.$smdta[0]["Lname"].'</td>
                                <td>'.$tmlead[0]["Fname"].' '.$tmlead[0]["Lname"].'</td>
                                <td>'.$likk["customername"].'</td>
                                <td>'.$likk["mobileNumber"].'</td>
                                <td>'.$likk["pancarddetails"].'</td>
                                <td>';
                                    if($likk["vehicleNumbertype"] == 1){
                                         $response.='Vehicle Regd. Number';
                                    }else if($likk["vehicleNumbertype"] == 2){
                                         $response.='Chassis Number';
                                    }else{
                                         $response.='NA';
                                    }
                    $response.='</td>
                                <td>'.$likk["vehiclechasisnumber"].'</td>
                                <td>'.$likk["classofBarcode"].'</td>
                                <td>'.$likk["transactionid"].'</td>
                                <td>'.date("d-m-Y / h:i:s", strtotime($likk["datetime"])).'</td>
                                <td>'.$salsagnt[0]["salesAgentRegdNum"].'</td>
                                <td>'.$salsagnt[0]["Fname"].' '.$salsagnt[0]["Lname"].'</td>
                                <td>'.$likk["responsecode"].'</td>
                                <td>';
                                    if($likk["responsecode"] == 230201){
                                         $response.='Success';
                                    }else{
                                         $response.='Failed';
                                    }
                    $response.='</td>
                              </tr>
                        ';
						echo $response;
                      }
                    }              
                      
                      exit;
        }
        }
      
      	
      	$paginateData = $this->loginModel->select('tagactivationinitial.responsestatus,tagactivationinitial.responsecode,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.orgreqid,tagactivationinitial.customerid,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,tagactivationinitial.responsestatus,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname,salesmanager.Fname as smfrst,salesmanager.Lname as smlst,teamlead.Fname as tlfrst,teamlead.Lname as tllst')
          ->join('salesagent', 'salesagent.salesagentId = tagactivationinitial.salesagentId')      
          ->join('teamlead', 'teamlead.teamleadId = salesagent.requestedById')
          ->join('salesmanager', 'salesmanager.salesManagerId = teamlead.requestedById')      
         // ->where('tagactivationinitial.salesagenttype',0)
          ->orderBy('initialId DESC')
          ->paginate(100);
          
        //  $this->loginModel->srchallnewusr()
      
         $data = [
           'usrs' => $paginateData,
           'pager' => $this->loginModel->pager
         ];
        
        //$data["usrs"] = $this->loginModel->srchallnewusr();      
      
        return view('admin/datadashboardnewuser',$data);
    }
  
  
  	public function existingusrdata()
    {
      
      if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
      
        $data=[];
        
        if($this->request->getMethod() == "post"){
        
            if($this->request->getVar('srchval')){
                
                  $likebarcode =  $this->smModel->vehiclenumberlike('tagactivationExistingUser',$this->request->getVar('srchval'));
                  $cnt = sizeof($likebarcode);
                      if($cnt == 0){
							$response='
                               <tr>
                                 <td colspan="8"> No Data Found..</td>
                               </tr>                            
                            ';
                        echo $response;
                      }else{
                        $i=0;
                        foreach($likebarcode as $likk){
                        $i++;
                        
                        $salesagentId =$likk["salesagentId"];
                        
                        $salsagnt = $this->smModel->viewspecific('salesagent','*','salesagentId',$salesagentId);
                        
                        $tlid = $salsagnt[0]['requestedById'];
                        $tmlead = $this->smModel->viewspecific('teamlead','*','teamleadId',$tlid);
                        $smid = $tmlead[0]['requestedById'];
                        $smdta = $this->smModel->viewspecific('salesmanager','*','salesManagerId',$smid);
                        
                        $response='
                             <tr>
                                <td>'.$i.'</td>
                                <td>'.$smdta[0]["Fname"].' '.$smdta[0]["Lname"].'</td>
                                <td>'.$tmlead[0]["Fname"].' '.$tmlead[0]["Lname"].'</td>
                                <td>'.$likk["customername"].'</td>
                                <td>'.$likk["mobileNumber"].'</td>
                                <td>';
                                    if($likk["vehicleNumbertype"] == 1){
                                         $response.='Vehicle Regd. Number';
                                    }else if($likk["vehicleNumbertype"] == 2){
                                         $response.='Chassis Number';
                                    }else{
                                         $response.='NA';
                                    }
                    $response.='</td>
                                <td>'.$likk["vehiclechasisnumber"].'</td>
                                <td>'.$likk["classofBarcode"].'</td>
                                <td>'.$likk["transactionid"].'</td>
                                <td>'.date("d-m-Y / h:i:s", strtotime($likk["datetime"])).'</td>
                                <td>'.$salsagnt[0]["salesAgentRegdNum"].'</td>
                                <td>'.$salsagnt[0]["Fname"].' '.$salsagnt[0]["Lname"].'</td>
                                <td>'.$likk["statusTag"].'</td>
                                <td>';
                                    if($likk["statusTag"] == 230201){
                                         $response.='Success';
                                    }else{
                                         $response.='Failed';
                                    }
                    $response.='</td>
                              </tr>
                        ';
						echo $response;
                      }
                    }              
                      
                      exit;
        }
        }
      
        //$data["usrs"] = $this->loginModel->srchallexistingusr();  
        
        
        $paginateData = $this->allModel->select('tagactivationExistingUser.resultTag,tagactivationExistingUser.statusTag,tagactivationExistingUser.classofBarcode,tagactivationExistingUser.vehicleType,tagactivationExistingUser.customername,tagactivationExistingUser.mobileNumber,tagactivationExistingUser.vehicleNumbertype,tagactivationExistingUser.vehiclechasisnumber,tagactivationExistingUser.salesagentId,tagactivationExistingUser.customerid,tagactivationExistingUser.barcodeid,tagactivationExistingUser.transactionstatus,tagactivationExistingUser.transactionid,tagactivationExistingUser.datetime,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname,salesmanager.Fname as smfrst,salesmanager.Lname as smlst,teamlead.Fname as tlfrst,teamlead.Lname as tllst')
          ->join('salesagent', 'salesagent.salesagentId = tagactivationExistingUser.salesagentId')      
          ->join('teamlead', 'teamlead.teamleadId = salesagent.requestedById')
          ->join('salesmanager', 'salesmanager.salesManagerId = teamlead.requestedById')
          ->orderBy('existinguserid DESC')
          ->paginate(100);
      
         $data = [
           'usrs' => $paginateData,
           'pager' => $this->allModel->pager
         ];

        return view('admin/datadashboardexistinguser',$data);
    }
          	
}

?>