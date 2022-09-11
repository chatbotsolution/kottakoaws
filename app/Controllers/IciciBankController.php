<?php
namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\ProductModel;
use \App\Models\SalesAgentModel;
use \App\Models\TeamLeadModel;
use \App\Models\SalesAgentWalletModel;

class IciciBankController extends BaseController
{
    public $loginModel;
    public $teamleadmodel;
    public $productmodel;
    public $oemModel;
    public $walletModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');      
        helper('payment');
        $this->loginModel = new SalesAgentModel();
        $this->teamleadmodel = new TeamLeadModel();
        $this->productmodel = new ProductModel();
        $this->oemModel = new OemModel(); 
        $this->walletModel = new SalesAgentWalletModel();   
        $this->session = session();
        
    }
  
  
    public function requestid(){
      
      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }
      
      
      $data= [];
      
      $rules = [
              "otp"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                  'required'=>'OTP Is required ',
                ],
              ],
              
              
              "sattedtt"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'State Is required ',
                ],
              ],
              "cityydt"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'City Is required ',
                ],
              ],
              "pincodeedt"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                  'required'=>'Pincode Is required ',
                ],
              ],
              "addrrssln1"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address Line 1 Is required ',
                ],
              ],
              "addrrssln2"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address Line 2 Is required ',
                ],
              ],
              "addrrssln3"=>[
                'rules'=>'required',
                'errors'=>[
                  'required'=>'Address Line 3 Is required ',
                ],
              ],
              
        	  "selfie"=>'uploaded[selfie]|max_size[selfie,1024]|ext_in[selfie,png,gif,jpg,jpeg,PNG,JPEG,JPG]',
            ];
        
      
      if($this->request->getMethod() == "post"){
          
          
        if($this->request->getVar('verfyotp')){
           $verfyotp = $this->request->getVar('verfyotp');
          
           $icicirequestid = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$_SESSION['salesagentId']);
           
           $ottp = $icicirequestid[0]['otp'];
           
           if($verfyotp == $ottp){
               $response="verified";
           }else{
               $response="invalidotp";
           }
          
          echo $response;
          exit;
        }
        
        
        if($this->request->getVar('getottp')){
           $getottp = $this->request->getVar('getottp');
          
           $otp = rand(1111,9999);
          
           $icicirequestid = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$_SESSION['salesagentId']);
           $salesagentdtt = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
          
            if(sizeof($icicirequestid) == 0){
              
				$insertdata = ["salesagentid" =>$_SESSION['salesagentId'], "selfie" =>"", "otp" =>$otp, "iciciagentid" =>"", "status" =>3, "datetime" =>date("Y-m-d h:i:s")];
                $loginData = $this->loginModel->loginDatainsert('icicirequestid',$insertdata);
                $lastinsertid = $this->loginModel->db->insertID();
                $this->session->setTempdata('sendid',$lastinsertid, 3);
              
            }else{
				
              $table ='icicirequestid';
              $upclnm ='salesagentid';
              $updtdata = [                          
                'otp'=>$otp,
              ];
              $updtid = $_SESSION['salesagentId'];
              $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid); 
              
            }
             
             $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
             $userMobile=$salesagentdtt[0]['ContactPrimary'];
             $send=sendOTP($userMobile,$userSMS);
             
              $response="send";
          
          echo $response;
          exit;
        }
        
        
        if($this->validate($rules)){
          
          $icicirequestid = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$_SESSION['salesagentId']);
          $dbotp =  $icicirequestid[0]['otp'];
          $otp = $this->request->getVar('otp');
          
        $sattedtt = $this->request->getVar('sattedtt');
        $cityydt = $this->request->getVar('cityydt');
        $pincodeedt = $this->request->getVar('pincodeedt');
        $addrrssln1 = $this->request->getVar('addrrssln1');
        $addrrssln2 = $this->request->getVar('addrrssln2');
        $addrrssln3 = $this->request->getVar('addrrssln3');
          
          if($dbotp == $otp){
              
              
            $table ='salesagent';
            $upclnm ='salesagentId';
            $updtdata = [
                'state' => $sattedtt,
                'city' => $cityydt,
                'pincode' => $pincodeedt,
                'addressline1' => $addrrssln1,
                'addressline2' => $addrrssln2,
                'addressline3' => $addrrssln3,
            ];
            $updtid = $_SESSION['salesagentId'];
            $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            	$selfie = $this->request->getFile('selfie');
                if($selfie->isValid() && !$selfie->hasMoved()){
                  $newselfie = $selfie->getRandomName();
                  if($selfie->move(FCPATH.'public/selfie',$newselfie)){     
                    $selfe = base_url().'/public/selfie/'.$newselfie;                           
                  }
                }
            
                $table ='icicirequestid';
                $upclnm ='salesagentid';
                $updtdata = [                          
                  'otp'=>'',
                  'selfie'=>$selfe,
                  'status' =>1,
                ];
                $updtid = $_SESSION['salesagentId'];
                $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid); 
            
                if($loginData){
                  $this->session->setTempdata('success','Request Send Successfully', 3);
                  return redirect()->to(base_url('salesagent/requestid'));
                }else{
                  $this->session->setTempdata('error','Unable To Send Request', 3);
                  return redirect()->to(base_url('salesagent/requestid'));
                }
            
          }else{
            
                $this->session->setTempdata('error','Invalid OTP ', 3);
                return redirect()->to(base_url('salesagent/requestid'));
          }
          
          
            
        }else{
          $data['validations'] = $this->validator;
        } 
        
      }
      
      $data["salesagent"] = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
      $data['icicirequestid'] = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$_SESSION['salesagentId']);
      
      return view('salesagent/requestid',$data);
    }
  
  
  
  	public function adminrequestid(){
      
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
      }
      
      
      $data= [];
      
      if($this->request->getMethod() == "post"){
        
        
        if($this->request->getVar('shwdatafr')){
           $shwdatafr = $this->request->getVar('shwdatafr');
          
           $icicirequestid = $this->loginModel->viewspecific('icicirequestid','*','requestid',$shwdatafr);
           $salesagent = $this->loginModel->viewspecific('salesagent','*','salesagentId',$icicirequestid[0]['salesagentid']);
           
           $response='
                       <table class="table table-bordered">
                         <tr>
                            <td style="font-weight:700;"> Salesagent Regd Id <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['salesAgentRegdNum'].' </span> </td>
                            <td style="font-weight:700;"> </td>
                         </tr>
                         
                         <tr>
                            <td style="font-weight:700;"> Salesagent First Name <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['Fname'].' </span> </td>
                            <td style="font-weight:700;"> Salesagent Last Name <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['Lname'].' </span> </td>
                         </tr>
                         <tr>
                            <td style="font-weight:700;"> State <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['state'].' </span> </td>
                            <td style="font-weight:700;"> City <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['city'].' </span> </td>
                         </tr>
                         <tr>
                            <td style="font-weight:700;"> Email <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['salesagentmailid'].' </span> </td>
                            <td style="font-weight:700;"> Mobile <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['ContactPrimary'].' </span> </td>
                         </tr>
                         <tr>
                            <td style="font-weight:700;"> Pincode <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['pincode'].' </span> </td>
                            <td style="font-weight:700;"> Address Line 1 <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['addressline1'].' </span> </td>
                         </tr>
                         <tr>
                            <td style="font-weight:700;"> Address Line 2 <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['addressline2'].' </span> </td>
                            <td style="font-weight:700;"> Address Line 3 <span style="float: right;font-weight: 500;font-size: 14px;"> '.$salesagent[0]['addressline3'].' </span> </td>
                         </tr>
                         
                         <tr>
                            <td style="font-weight:700;"> Selfie <span style="float: right;font-weight: 500;font-size: 14px;"> <img src="'.$icicirequestid[0]['selfie'].'" style="width:170px;"> </span> </td>
                            <td style="font-weight:700;"> Request Date / Time <span style="float: right;font-weight: 500;font-size: 14px;"> '.date('d-m-Y / h:i:s', strtotime($icicirequestid[0]['datetime'])).' </span> </td>
                         </tr>
                         <tr>
                            <td> 
                                <button class="btn btn-sm btn-success" onclick="acpt(\''.$icicirequestid[0]['requestid'].'\',\'0\');"> ACCEPT </button>
                                <button class="btn btn-sm btn-danger" onclick="acpt(\''.$icicirequestid[0]['requestid'].'\',\'1\');"> DECLINE </button>
                            </td>
                            <td>  </td>
                         </tr>
                       </table>
                     ';
          
          echo $response;
          exit;
        }
        
        
        if($this->request->getVar('updtid')){
           $updtid = $this->request->getVar('updtid');
           $updtval = $this->request->getVar('updtval');
          
           if($updtval == 0){
             
             $response='
                       <div class="modal-header">
                          <h5 class="modal-title">Approve Id Request</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="'.base_url().'/secure/requestid"  method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateForm()" ?>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" style="font-weight: 500">Remark</label>
                              <div class="col-sm-10">
                                <input type="text" name="remark" id="remark" value="" Placeholder="Remark" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg rem" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" style="font-weight: 500">ICICI Generated Id</label>
                              <div class="col-sm-10">
                                <input type="text" name="generatedid" id="generatedid" value="" Placeholder="ICICI Generated Id" class="form-control mg-b-10" style="max-width:50%;">
                                <input type="hidden" name="upddttiidd" id="upddttiidd" value="'.$updtid.'" Placeholder="ICICI Generated Id" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg ici" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">APPROVE</button>
                              </div>
                            </div>
                          </form> 
                        </div>';
             
           }else{
             
             $response='
                       <div class="modal-header">
                          <h5 class="modal-title">Decline Id Request</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="'.base_url().'/secure/requestid"  method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateFormdecline()" ?>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" style="font-weight: 500">Remark</label>
                              <div class="col-sm-10">
                                <input type="text" name="remarkk" id="remarkk" value="" Placeholder="Remark" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg remarkkt" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" style="font-weight: 500">Screenshot</label>
                              <div class="col-sm-10">
                                <input type="file" name="screenshot" id="screenshot" Placeholder="screenshot" class="form-control mg-b-10" style="max-width:50%;">
                                <input type="hidden" name="upddttiidd" id="upddttiidd" value="'.$updtid.'" Placeholder="ICICI Generated Id" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg screenshott" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">                                
                                 <button type="submit" class="btn btn-primary">DECLINE</button> 
                              </div>
                            </div>
                          </form>
                        </div>';
             
           }
            
          
          echo $response;
          exit;
        }
        
        
        if($this->request->getVar('generatedid')){
          
          $remark = $this->request->getVar('remark');
          $generatedid = $this->request->getVar('generatedid');
          $upddttiidd = $this->request->getVar('upddttiidd');
          
          $adm = $this->loginModel->viewspecific('admin','*','userid',$_SESSION['logged_usrid']);
          
          $table ='icicirequestid';
          $upclnm ='requestid';
          $updtdata = [                          
            'iciciagentid'=>$generatedid,
            'remarks'=>$remark,
            'status' =>0,
            'adminapprovalid'=>$adm[0]['admin_user_id'],
          ];
          $updtid = $upddttiidd;
          $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
            $this->session->setTempdata('success','Approved Successfully', 3);
            return redirect()->to(base_url('secure/requestid'));            
            echo $response;
            exit;
        }
        
        if($this->request->getVar('remarkk')){
          
          $remark = $this->request->getVar('remarkk');
          $upddttiidd = $this->request->getVar('upddttiidd');
          
          
          $screenshot = $this->request->getFile('screenshot');
          if($screenshot->isValid() && !$screenshot->hasMoved()){
            $newscreenshot = $screenshot->getRandomName();
            if($screenshot->move(FCPATH.'public/icicibank/',$newscreenshot)){     
              $scrn = base_url().'/public/icicibank/'.$newscreenshot;                           
            }
          }
          
          $table ='icicirequestid';
          $upclnm ='requestid';
          $updtdata = [                          
            'iciciagentid'=>$scrn,
            'remarks'=>$remark,
            'status' =>2,
          ];
          $updtid = $upddttiidd;
          $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
            $this->session->setTempdata('success','Declined Successfully', 3);
            return redirect()->to(base_url('secure/requestid')); 
            echo $response;
            exit;
        }
        
      }
      
      
      $data['icicirequestid'] = $this->loginModel->viewspecific('icicirequestid','*','status',1);
      
      if(sizeof($data['icicirequestid']) != 0){
      
        for($i=0;$i < sizeof($data['icicirequestid']); $i++){

          $data['icicirequestid'][$i]['salesagentid'];
          $sales = $this->loginModel->viewspecific('salesagent','*','salesagentId',$data['icicirequestid'][$i]['salesagentid']);
          $salesagent[] =  $sales;
          $teamleads = $this->loginModel->viewspecific('teamlead','*','teamleadId',$sales[0]['requestedById']);
          $teamlead[] = $teamleads;
          $salesmanagers = $this->loginModel->viewspecific('salesmanager','*','salesManagerId',$teamleads[0]['requestedById']);
          $salesmanager[] = $salesmanagers;

        }
      }else{
        $salesagent[] = "";
        $teamlead[] = "";
        $salesmanager[] = "";
      }
      
      $data['salesagent'] = $salesagent;
      $data['teamlead'] = $teamlead;
      $data['salesmanager'] = $salesmanager;
      
      return view('admin/requestid',$data);
    }
  
  
  	public function adminwallet(){
      
      if ((!isset($_SESSION['logged_usrid']))) {
        return redirect()->to(base_url('adminLogin'));            
      }
      
      
      $data= [];
      
      $rules = [
              "otp"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                  'required'=>'OTP Is required ',
                ],
              ],
        	  "selfie"=>'uploaded[selfie]|max_size[selfie,1024]|ext_in[selfie,png,gif,jpg,jpeg,PNG,JPEG,JPG]',
            ];
        
      
      if($this->request->getMethod() == "post"){ 
        
        if($this->request->getVar('walletid')){
          
          $walletid = $this->request->getVar('walletid');
          $walletdata = $this->loginModel->viewspecific('iciciwallet','*','iciciwalletid',$walletid);
          $salesagentidd = $walletdata[0]['salesagentid'];
          
          $reqstdata = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$salesagentidd);
          $adm = $this->loginModel->viewspecific('admin','*','userid',$_SESSION['logged_usrid']);
          $salsagntt = $this->loginModel->viewspecific('salesagent','*','salesagentId',$salesagentidd);
          
          $response='
                     <table class="table table-bordered">
                       <tr>
                          <td style="font-weight:700;"> Transaction Id <span style="float: right;font-weight: 500;font-size: 14px;"> '.$walletdata[0]['transactionid'].' </span> </td>
                          <td style="font-weight:700;"> Admin Id <span style="float: right;font-weight: 500;font-size: 14px;"> '.$adm[0]['admin_user_id'].' </span> </td>
                       </tr>
                       <tr>
                          <td style="font-weight:700;">Salesagent Registration Id <span style="float: right;font-weight: 500;font-size: 14px;">'.$salsagntt[0]['salesAgentRegdNum'].'</span> </td>
                          <td style="font-weight:700;">Request Date / Time <span style="float: right;font-weight: 500;font-size: 14px;"> '.date("d-m-Y / h:i:s", strtotime($walletdata[0]['datetime'])).' </span> </td>
                       </tr>
                       <tr>
                          <td style="font-weight:700;">ICICI Id <span style="float: right;font-weight: 500;font-size: 14px;">'.$reqstdata[0]['iciciagentid'].'</span> </td>
                          <td style="font-weight:700;">Paymentgateway Name <span style="float: right;font-weight: 500;font-size: 14px;"> '.$walletdata[0]['paymentgatewayname'].' </span> </td>
                       </tr>
                       <tr>
                          <td>
                            <button class="btn btn-sm btn-success" onclick="acpt(\''.$walletdata[0]['iciciwalletid'].'\',\'0\');"> Accept </button>
                            <button class="btn btn-sm btn-danger" onclick="acpt(\''.$walletdata[0]['iciciwalletid'].'\',\'1\');"> Decline </button>
                          </td>
                          <td></td>
                       </tr>
                     </table>
                    ';
          
          
          echo $response;
          exit;
          
        }
        
        
        if($this->request->getVar('updtid')){
           $updtid = $this->request->getVar('updtid');
           $updtval = $this->request->getVar('updtval');
          
           if($updtval == 0){
             
             $response='
                       <div class="modal-header">
                          <h5 class="modal-title">Approve Wallet Amount</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="'.base_url().'/secure/iciciwallet"  method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateForm()" ?>
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label" style="font-weight: 500">Amount In ICICI Before Addition</label>
                              <div class="col-sm-8">
                                <input type="text" name="amountbfr" id="amountbfr" value="" Placeholder="Amount In ICICI Before Addition" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg amntbfr" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label" style="font-weight: 500">Amount In ICICI After Addition</label>
                              <div class="col-sm-8">
                                <input type="text" name="amountaftr" id="amountaftr" value="" Placeholder="Amount In ICICI After Addition" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg amntaftr" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label" style="font-weight: 500">Remark</label>
                              <div class="col-sm-8">
                                <input type="text" name="remark" id="remark" value="" Placeholder="Remark" class="form-control mg-b-10" style="max-width:50%;">
                                <input type="hidden" name="upddttiidd" id="upddttiidd" value="'.$updtid.'" Placeholder="ICICI Generated Id" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg remrk" style="text-align:left;"> </span>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">APPROVE</button>
                              </div>
                            </div>
                          </form> 
                        </div>';
             
           }else{
             
             $response='
                       <div class="modal-header">
                          <h5 class="modal-title">Decline Id Request</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="'.base_url().'/secure/iciciwallet"  method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateFormdecline()" ?>
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" style="font-weight: 500">Remark</label>
                              <div class="col-sm-10">
                                <input type="text" name="remarkk" id="remarkk" value="" Placeholder="Remark" class="form-control mg-b-10" style="max-width:50%;">
                                <span class="errmsg remarkkt" style="text-align:left;"> </span>
                                <input type="hidden" name="upddttiidd" id="upddttiidd" value="'.$updtid.'" Placeholder="ICICI Generated Id" class="form-control mg-b-10" style="max-width:50%;">
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">                                
                                 <button type="submit" class="btn btn-primary">DECLINE</button> 
                              </div>
                            </div>
                          </form>
                        </div>';
             
           }
            
          
          echo $response;
          exit;
        }
        
        
        if($this->request->getVar('amountbfr')){
          
          $upddttiidd = $this->request->getVar('upddttiidd');
          
          $amountbfr = $this->request->getVar('amountbfr');
          $amountaftr = $this->request->getVar('amountaftr');
          $remark = $this->request->getVar('remark');
          $dtm=date('Y-m-d h:i:s');
          
          $adm = $this->loginModel->viewspecific('admin','*','userid',$_SESSION['logged_usrid']);
          
          $table ='iciciwallet';
          $upclnm ='iciciwalletid';
          $updtdata = [                          
            'amountinicici'=>$amountbfr,
            'amounticiciafteraddition'=>$amountaftr,
            "remark"=>$remark,
            'status' =>0,
            "approveddatetime"=>$dtm,
            'approvedbyid'=>$adm[0]['admin_user_id'],
          ];
          $updtid = $upddttiidd;
          $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
            $this->session->setTempdata('success','Wallet Balance Added Successfully', 3);
            return redirect()->to(base_url('secure/iciciwallet'));            
            echo $response;
            exit;
        }
        
        
        if($this->request->getVar('remarkk')){
          
          $upddttiidd = $this->request->getVar('upddttiidd');
          
          $remarkk = $this->request->getVar('remarkk');
          $dtm=date('Y-m-d h:i:s');
          
          $adm = $this->loginModel->viewspecific('admin','*','userid',$_SESSION['logged_usrid']);
          
          $table ='iciciwallet';
          $upclnm ='iciciwalletid';
          $updtdata = [
            "remark"=>$remarkk,
            'status' =>4,
            "approveddatetime"=>$dtm,
            'approvedbyid'=>$adm[0]['admin_user_id'],
          ];
          $updtid = $upddttiidd;
          $loginData=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
          
            $this->session->setTempdata('success','Wallet Balance Declined Successfully', 3);
            return redirect()->to(base_url('secure/iciciwallet'));            
            echo $response;
            exit;
        }
        
        
      }
      
      
      $data['wallet'] = $this->loginModel->vweAll('iciciwallet');
      
      if(sizeof($data['wallet']) != 0){
      
        for($i=0;$i < sizeof($data['wallet']); $i++){

          $sales = $this->loginModel->viewspecific('salesagent','*','salesagentId',$data['wallet'][$i]['salesagentid']);
          $salesagent[] =  $sales;
        }
        
      }else{
        $salesagent[] = "";
      }
      
      $data['salesagent'] = $salesagent;
      
      return view('admin/iciciwallet',$data);
    }
  
  
  
  	function salesagentwallet(){
      
      if ((!isset($_SESSION['salesagentId']))) {
        return redirect()->to(base_url('salesagentLogin'));            
      }
      
      
      $data =[];
      
      $rules = [
              "amount"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                  'required'=>'Amount Is required ',
                ],
              ],
            ];
        
      
      if($this->request->getMethod() == "post"){
        
        
        if($this->request->getVar('chk')){
          
          $chk = $this->request->getVar('chk');
          
          $stsdata = $this->loginModel->viewspecific('iciciwallet','*','transactionid',$_SESSION['ordrrid']);
          
          $sts = $stsdata[0]['status'];
          
          if($sts == 0){
            $response="done";
          }else{
            $response="sorry";
          }
          
          echo $response;
          exit;
          
        }
        
        
        
                  
        if($this->validate($rules)){
          
          $salesagentdetails = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);
          
          $orderId = time();
          $dtm=date("Y-m-d h:i:s");
          $orderAmount = $this->request->getVar('amount');
          $purchasenote = "Adding Money To ICICI Wallet";
          $custname=$salesagentdetails[0]['Fname'].' '.$salesagentdetails[0]['Lname'];
          $mobnum=$salesagentdetails[0]['ContactPrimary'];
          $salesmailid=$salesagentdetails[0]['salesagentmailid'];
          $returnurl=base_url().'/salesagent/walletnotification';
          $notifyurl=base_url().'/salesagent/walletnotification';

          $walletdata = ["salesagentid" =>$_SESSION['salesagentId'], "amount" =>$orderAmount, "transactionid" =>$orderId, "paymentgatewayname" =>"Cashfree", "amountinicici" =>"", "amounticiciafteraddition" =>"", "remark" =>"", "status" =>3, "datetime" =>$dtm, "approveddatetime" =>$dtm, "approvedbyid" =>""];                
          $loginData = $this->loginModel->loginDatainsert('iciciwallet',$walletdata);

          $postdata = array("appId"=>'19350339ee25ac9bdf7c97d3f6305391', "orderId"=>$orderId, "orderAmount"=>$orderAmount, "orderCurrency"=>'INR', "orderNote"=>$purchasenote, "customerName"=>$custname, "customerPhone"=>$mobnum, "customerEmail"=>$salesmailid, "returnUrl"=>$returnurl, "notifyUrl"=>$notifyurl);
          $signature = generateSignature($postdata);

          echo $payment = makePayment($orderId,$orderAmount,$purchasenote,$salesmailid,$custname,$mobnum,$returnurl,$signature,$notifyurl); 
          
          exit;

        }else{
          $data['validations'] = $this->validator;
        }
        
      }      
      
      //edit here
      //$data = [];
      //$iciciwalletdata = $this
      
         $data["iciciwallettransaction"] = $this->loginModel->viewspecific('iciciwallet','*','salesagentid',$_SESSION['salesagentId']);
         $data['icicirequestid'] = $this->loginModel->viewspecific('icicirequestid','*','salesagentid',$_SESSION['salesagentId']);
      
         return view('salesagent/iciciwallet',$data);
      
    }
  
  
  
  	public function walletnotification(){

            $orderId = $this->request->getVar('orderId');       
        
        	$data =[];      
            $salesagentdetails = $this->walletModel->iciciwalletbal($orderId);
            $retrndata1 = $this->loginModel->lastLogin1($salesagentdetails[0]['salesagentId']);
           
      
            if($salesagentdetails[0]["ProfileImage"] =="default"){ $prf="default_user.jpg";}else{ $prf = $salesagentdetails[0]["ProfileImage"]; }

            $profileImage = $prf;
            $this->session->set('salesagentId',$salesagentdetails[0]['salesagentId']);
            $this->session->set('logged_intype',3);
            $this->session->set('login_data_id',$retrndata1['login_data_id']);
            $this->session->set('logged_img',$profileImage);
            $this->session->set('setTagactivationId',$orderId);
        
        

            if($retrndata1 == false){
                $lstLogin="";
            }else{
                $lstLogin=$retrndata1['datetime_login'];
            }

            $usrnmm = $salesagentdetails[0]["Fname"].' '.$salesagentdetails[0]["Lname"];
            $this->session->set('usrName',$usrnmm);
            $this->session->set('usrLastLogin',$lstLogin);
        
        	$trnsts = $this->request->getVar('txStatus');
            $orderId = $this->request->getVar('orderId');
            $orderAmount = $this->request->getVar('orderAmount');
            $referenceId = $this->request->getVar('referenceId');
            $paymentMode = $this->request->getVar('paymentMode');
            $signature = $this->request->getVar('signature');
            $dtm=date("Y-m-d h:i:s");
            $databankdetails = ["refrenceid"=>$referenceId,"paymentmode"=>$paymentMode,"paymentamount"=>$orderAmount,"orderid"=>$orderId,"signature"=>$signature,"transactionstatus"=>$trnsts,"datetime"=>$dtm];
            $loginData = $this->loginModel->loginDatainsert('paymentstatus',$databankdetails);
              
            $this->session->set('ordrrid',$orderId);
        
            if($this->request->getVar('txStatus') == "SUCCESS"){               
                
              $table ='iciciwallet';
              $upclnm ='transactionid';
              $updtdata = [
                'txn'=>$this->request->getVar('txStatus'),
                'status'=>1,
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);              
              
              $this->session->setTempdata('success','Money Debited Successfully Waiting For Approval', 3);
              return redirect()->to(base_url('salesagent/iciciwalletpaymentsuccess'));
              
            }else{
              
              $table ='iciciwallet';
              $upclnm ='transactionid';
              $updtdata = [
                'txn'=>$this->request->getVar('txStatus'),
                'status'=>2,
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              $this->session->setTempdata('error','Payment Was Not Successfully', 3);
              return redirect()->to(base_url('salesagent/iciciwalletpaymentfailed'));
              
            }
    }
  
  
  
  	public function failtagactive(){
      $data=[];

        return view('salesagent/iciciwalletfail',$data);
    }

    public function successtagactive(){
      $data=[];

        return view('salesagent/iciciwalletsuccess',$data);
    }
               
          	
}

?>