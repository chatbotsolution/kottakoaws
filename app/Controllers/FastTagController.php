<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;
use \App\Models\OemModel;
use \App\Models\SalesAgentWalletModel;
use \App\Models\ProductModel;

class FastTagController extends BaseController
{
    public $loginModel;
    public $oemModel;
    public $walletModel;
    public $productModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        helper('cookie');
        helper('payment');
        helper('fastag');
        $this->loginModel = new SalesManagerModel();
        $this->oemModel = new OemModel(); 
        $this->walletModel = new SalesAgentWalletModel(); 
        $this->productModel = new ProductModel();
        $this->session = session();
        
    }

    public function index()
    {
        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        }
        $data=[];
        $rules = [
            "tagid"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Tag Id Is required ',
                ],
            ],
            "classoftag"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Class Of Tag Is required ',
                ],
            ],
            "barcode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bar Code Is required ',
                ],
            ],
            "tid"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'TID Is required ',
                ],
            ],
            "bank"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bank Is required ',
                ],
            ],
            
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $tagid = $this->request->getVar('tagid');
                $classoftag = $this->request->getVar('classoftag');
                $barcode = $this->request->getVar('barcode'); 
                $bank = $this->request->getVar('bank'); 
                $tid = $this->request->getVar('tid');                   
                            
                    $dtm = date("Y-m-d h:i:s");
              
                    $whrdata = array(
                        'tagid'   => $tagid
                      );
              
                      $whrdata1 = array(
                                'barcode' => $barcode
                      );
                    
              
                    if(sizeof( $this->loginModel->ftchmulti('fasttag','*',$whrdata)) == 0 && sizeof( $this->loginModel->ftchmulti('fasttag','*',$whrdata1)) == 0){
                      
                      $data = ["barcode"=>$barcode,"tagid"=>$tagid,"classoftag"=>$classoftag,"status"=>'0',"datetime"=>$dtm,"tid"=>$tid,"bankname"=>$bank];
                      $loginData = $this->loginModel->loginDatainsert('fasttag',$data);
                      $uid = $this->loginModel->db->insertID(); 

                      if($loginData){
                          $this->session->setTempdata('success','Fast Tag Added Successfully', 3);
                          return redirect()->to(base_url('secure/addfastag'));
                      }else{
                          $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                          return redirect()->to(base_url('secure/addfastag'));
                      }
                      
                    }else{
                      
                          $this->session->setTempdata('error','Bar Code / Tag Id Already Exists', 3);
                          return redirect()->to(base_url('secure/addfastag'));
                      
                    }
                    
                        

            }else{
                $data['validations'] = $this->validator;
            }
        }


            return view('admin/addfasttag',$data);
    }


    public function uploadCSV(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $data=[];
        $dtm=date("Y-m-d h:i:s");
        if($this->request->getMethod() == "post"){
            $input = $this->validate([
                'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
            ]);
                if (!$input) {
                    $data['validations'] = $this->validator;
                }else{
                  $bank = $this->request->getVar('bank');

                  $file = $this->request->getFile('file');

                    if ($file->isValid() && ! $file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(FCPATH.'public/adminasset/fasttag/', $newName);
                        $file = fopen(FCPATH.'public/adminasset/fasttag/'.$newName,"r");
                        $i = 0;
                        $numberOfFields = 4; 
                        $importData_arr = array();
                        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields){
                        $importData_arr[$i]['tagid'] = $filedata[0];
                        $importData_arr[$i]['tid'] = $filedata[1];
                        $importData_arr[$i]['barcode'] = $filedata[2];
                        $importData_arr[$i]['classoftag'] = $filedata[3];
                       // $importData_arr[$i]['classoftag'] = $filedata[4];
                        }
                        $i++;
                        }
                        fclose($file);
                        $count = 0;
                        print_r($importData_arr);
                        foreach($importData_arr as $userdata){
                          if($userdata["barcode"] !="" and $userdata["tagid"] !=""){
                            $data = ["barcode"=>$userdata["barcode"],"tagid"=>$userdata["tagid"],"classoftag"=>$userdata["classoftag"],"status"=>'0',"datetime"=>$dtm,"tid"=>$userdata["tid"],"bankname"=>$bank];
                            $loginData = $this->loginModel->loginDatainsert('fasttag',$data);
                          }
                        }

                        $this->session->setTempdata('success','Fast Tag Added Successfully', 3);
                        return redirect()->to(base_url('secure/addfastag'));
                    }else{
                        $this->session->setTempdata('error','Sorry Unable To Add Try Again Later', 3);
                        return redirect()->to(base_url('secure/addfastag'));
                    }
                
                
                }
        }

        return view('admin/addfasttag',$data);
    }

    public function managefasttag(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
        $dtm = date("Y-m-d h:i:s");
        $table="salesmanager";
        $viewdata="salesManagerId,Fname,Lname,RegdNum";
        $whrclm="status";
        $whrval=0;
        $data["salsmngr"]=$this->loginModel->viewspecific($table,$viewdata,$whrclm,$whrval);

        $tableo="oem";
        $viewdatao="*";
        $whrclmo="status";
        $whrvalo=0;
        $data["oem"]=$this->loginModel->viewspecific($tableo,$viewdatao,$whrclmo,$whrvalo);
     

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('fastagid')){
                
                $trnsid = time().date('Y').date('m');
                
                $response='
                <div class="modal-header">
                    <h5 class="modal-title">Allocate Fastag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" form-group row">
                    <div id="mdg" class="col-md-12"></div>
                        <div class="col-sm-3 col-form-label">
                            Select Sales Manager
                            <input type="hidden" id="fastatgidd" value="'.$this->request->getVar('fastagid').'">
                            <input type="hidden" name="fastatgiddad" value="'.$this->request->getVar('fastagid').'">
                            <input type="hidden" id="trnsid" name="trnsid" value="'.$trnsid.'">
                            <input type="number" id="moblenumm" name="moblenumm" class="form-control" hidden>
                            <input type="text" id="type" name="type" value="1" class="form-control" hidden>
                        </div>
                        <div class="col-md-9 shwhrr">
                            <select class="form-control" style="width:60%;" id="salesmanagerfstg" name="salesmanagerfstg" onchange="shwnumberverify(this.value);">
                                <option value="">Select Sales Manager</option>';
                                $cnt = count($data["salsmngr"]);
                              for($i=0;$i<$cnt;$i++){
                                  $shw = $data["salsmngr"][$i]["Fname"].' '.$data["salsmngr"][$i]["Lname"].' ( '.$data["salsmngr"][$i]["RegdNum"].' )';
                         $response.='<option value="'.$data["salsmngr"][$i]["salesManagerId"].'">'.$shw.'</option>';
                              }  
                                
                $response.='</select>
                            <span class="errmsg" style="text-align:left;" id="ermid"></span>
                        </div>
                    </div>
                    <div class="form-group row fgtr">
                       <div class="col-sm-3 col-form-label">
                            OTP
                        </div>
                        <div class="col-md-9">
                            <input type="number" id="ottp" name="ottp" class="form-control" style="width:50%;" placeholder="Enter OTP">
                            <span class="btnspace">
                               <button type="button" class="btn btn-info" onclick="sendotp();" style="position: absolute;top: 0px;left: 325px;padding: 10px;border-radius: 0px 4px 4px 0px;"> SEND OTP </button>
                            </span>
                            <span class="errmsg otppsndt"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="allot();">Allot Tag</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                ';

                echo $response;
                exit;
            }

            if($this->request->getVar('fasttagid')){
                $fasttagid = $this->request->getVar('fasttagid');
                $salesmngis = $this->request->getVar('salesmngis');
                
                $data = ["fasttagid"=>$fasttagid,"allotedto"=>$salesmngis,"allotedtotype"=>1,"allotedby"=>0,"allotedbytype"=>0,"status"=>'0',"datetime"=>$dtm];
                $loginData = $this->loginModel->loginDatainsert('fastaginventory',$data);
                if($loginData){
                    $table="fasttag";
                    $upclnm="fasttagid";
                    $updtdata = [
                        'status'=>2,
                    ];
                    $updtid=$fasttagid;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        $response="done";
                }else{
                    $response="sorry";
                }

                echo $response;
                exit;
            }

            /*if($this->request->getVar('fasttagid')){
                $fasttagid = $this->request->getVar('fasttagid');
                $salesmngis = $this->request->getVar('salesmngis');
                
                $data = ["fasttagid"=>$fasttagid,"allotedto"=>$salesmngis,"allotedtotype"=>1,"allotedby"=>0,"allotedbytype"=>0,"status"=>'0',"datetime"=>$dtm];
                $loginData = $this->loginModel->loginDatainsert('fastaginventory',$data);
                if($loginData){
                    $table="fasttag";
                    $upclnm="fasttagid";
                    $updtdata = [
                        'status'=>2,
                    ];
                    $updtid=$fasttagid;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                        $response="done";
                }else{
                    $response="sorry";
                }

                echo $response;
                exit;
            }*/

            if($this->request->getVar('typ')){

                if($this->request->getVar('typ') == 1){

                    $response='
                            <select class="form-control" style="width:60%;" name="salesmanagerfstg" onchange="shwnumberverify(this.value);">
                            <option value=""> SELECT SALES MANAGER </option>';
                                    $cnt = count($data["salsmngr"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["salsmngr"][$i]["Fname"].' '.$data["salsmngr"][$i]["Lname"].' ( '.$data["salsmngr"][$i]["RegdNum"].' )';
                            $response.='<option value="'.$data["salsmngr"][$i]["salesManagerId"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>';

                }else if($this->request->getVar('typ') == 5){

                    $response='
                            <select class="form-control" style="width:60%;" name="salesmanagerfstg" onchange="shwnumberverify(this.value);">
                            <option value=""> SELECT OEM </option>';
                                    $cnt = count($data["oem"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["oem"][$i]["companyname"];
                            $response.='<option value="'.$data["oem"][$i]["oemid"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>';

                }

                echo $response;
                exit;

            }

            if($this->request->getVar('ad')){

                $cnt = sizeof($this->request->getVar('values'));
                for($i=0; $i <$cnt; $i++){
                    $datavall[] = $this->request->getVar('values')[$i];
                }
                $dataa = base64_encode(json_encode($datavall));
                $trnsid = time().date('Y').date('m');
                $rt = json_encode($this->request->getVar('values'));
                $dataaq = ["agenttype"=>0, "agentid"=>0, "tag"=>$rt, "transactionid"=>$trnsid, "status"=>0,"datetime"=>$dtm,"otp"=>0];
                $rttyt = $this->loginModel->loginDatainsert('tagtransaction',$dataaq);

                $response='
                <form action="'.base_url().'/secure/managefasttag" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Fastag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" form-group row">
                        <div id="mdg" class="col-md-12"></div>
                            <div class="col-sm-3 col-form-label">
                                Select Type
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" style="width:60%;" name="type" id="type" onchange="shwtyp(this.value);">
                                     <option value="1"> Sales Manager </option>
                                     <option value="5"> OEM </option>
                                </select>
                                <span class="errmsg" style="text-align:left;" id="ermid"></span>
                            </div>
                            <div class="col-sm-3 col-form-label">
                                Select Sales Manager
                                <input type="hidden" name="fastatgiddad" value="'.$dataa.'">
                                <input type="hidden" id="trnsid" name="trnsid" value="'.$trnsid.'">
                                <input type="number" id="moblenumm" name="moblenumm" class="form-control" hidden>
                            </div>
                            <div class="col-md-9 shwhrr">
                                <select class="form-control" style="width:60%;" id="salesmanagerfstg" name="salesmanagerfstg" onchange="shwnumberverify(this.value);">
                                <option value="">Select Sales Manager</option>';
                                    $cnt = count($data["salsmngr"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["salsmngr"][$i]["Fname"].' '.$data["salsmngr"][$i]["Lname"].' ( '.$data["salsmngr"][$i]["RegdNum"].' )';
                            $response.='<option value="'.$data["salsmngr"][$i]["salesManagerId"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>
                                <span class="errmsg" style="text-align:left;" id="ermid"></span>
                            </div>
                        </div>
                        <div class="form-group row fgtr">
                           <div class="col-sm-3 col-form-label">
                                OTP
                            </div>
                            <div class="col-md-9">
                                <input type="number" id="ottp" name="ottp" class="form-control" style="width:50%;" placeholder="Enter OTP">
                                <span class="btnspace">
                                   <button type="button" class="btn btn-info" onclick="sendotp();" style="position: absolute;top: 0px;left: 325px;padding: 10px;border-radius: 0px 4px 4px 0px;"> SEND OTP </button>
                                </span>
                                <span class="errmsg otppsndt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="tagbtnn" disabled>Allot Tag</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                    ';

                    echo $response;
                exit;
            }
          
          
          	if($this->request->getVar('salesagentidotp')){
                $salesagentidotp = $this->request->getVar('salesagentidotp');
                $transctnid = $this->request->getVar('transctnid');
                $typeee = $this->request->getVar('typeee');
                
                $table="tagtransaction";
                $upclnm="transactionid";
                $updtdata = [
                    'agentid'=>$salesagentidotp,
                    'agenttype'=>$typeee,
                ];
                $updtid=$transctnid;
                $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid); 
                        
                if($typeee == 1){
                    
                    $salesagent = $this->loginModel->viewspecific('salesmanager','*','salesManagerId',$salesagentidotp);
                    $response = $salesagent[0]['ContactPrimary'];
                    
                }else if($typeee == 5){
                    
                    $salesagent = $this->loginModel->viewspecific('oem','*','oemid',$salesagentidotp);
                    $response = $salesagent[0]['gmcontact'];
                        
                }
                
                

                echo $response;
                exit;
            }
            
            
            if($this->request->getVar('transctnidddvrfy')){
                $transctnidddvrfy = $this->request->getVar('transctnidddvrfy');
                $moblnnummvrfy = $this->request->getVar('moblnnummvrfy');
                $otppvrfy = $this->request->getVar('otppvrfy');
                
                $otppdta = $this->loginModel->viewspecific('tagtransaction','*','transactionid',$transctnidddvrfy);
                //print_r($otppdta);
                $ottp = $otppdta[0]['otp'];
                
                if($otppvrfy == $ottp){
                    
                    $table="tagtransaction";
                    $upclnm="transactionid";
                    $updtdata = [
                        'otp'=>0,
                        'status'=>1,
                    ];
                    $updtid=$transctnidddvrfy;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    $response="verified";
                }else{
                    
                    $table="tagtransaction";
                    $upclnm="transactionid";
                    $updtdata = [
                        'otp'=>0,
                        'status'=>2,
                    ];
                    $updtid=$transctnidddvrfy;
                    $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                    
                    $response="invalidotp";
                }
                
                

                echo $response;
                exit;
            }
            
            
            if($this->request->getVar('transctniddd')){
                $transctniddd = $this->request->getVar('transctniddd');
                $moblnnumm = $this->request->getVar('moblnnumm');
                $salesmanagerfstg = $this->request->getVar('salesmanagerfstg');
                
                $remainingtag = $this->loginModel->viewspecific('maxallowedtagnum','*','usertype',1);
                $maxallowedtag = $remainingtag[0]['max_allowed_tag'];
                $where = array("allotedto"  => $salesmanagerfstg,"allotedtotype"=>"1","status"=>0);
                $salesmanager = $this->loginModel->chkduplcate('fastaginventory',$where);
                
                
                
                if(sizeof($salesmanager) > $maxallowedtag){
                   echo $response ="Max Allowed Tag Already Reached";
                   exit;
                }
                    
                $otp = random_string('numeric', 6);
                
                $table="tagtransaction";
                $upclnm="transactionid";
                $updtdata = [
                    'otp'=>$otp,
                ];
                $updtid=$transctniddd;
                $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                
                $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
                $send=sendOTP($moblnnumm,$userSMS);
                
                $response="send";

                echo $response;
                exit;
            }
            
              
            if($this->request->getVar('searchvalue')){ 
             $this->request->getVar('searchvalue');              
                   
                  $likebarcode =  $this->loginModel->fastaglike($this->request->getVar('searchvalue'));
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

                        if($likk["status"] == 0){
                          $sts="Active";
                          $btn = '<a href="'.base_url().'/secure/updtfasttag/'.$likk["fasttagid"].'/1"> <button class="btn btn-sm btn-danger" title="Block Fast Tag"> Block </button> </a>';
                          $btn1='<button class="btn btn-sm btn-info" onclick="allot_tag(\''.$likk["fasttagid"].'\');"> Allot Fastag </button>';
                          $btn2="";
                        }else if($likk["status"] == 1){
                          $sts="Blocked";
                          $btn='<a href="'.base_url().'/secure/updtfasttag/'.$likk["fasttagid"].'/0"> <button class="btn btn-sm btn-primary" title="Un-Block Fast Tag"> Un-Block </button> </a>';
                          $btn1="";
                          $btn2="";
                        }else if($likk["status"] == 2){
                          $sts="Allocated";
                          $btn='';
                          $btn1="";  
                          $btn2='<button class="btn btn-sm btn-warning" title="Transaction Details" onclick="showdetailstrns(\''.$likk["fasttagid"].'\');"> Show Details </button>';
                        }else{
                          $sts="";
                          $btn="";
                          $btn1="";
                          $btn2="";
                        }
                        
                        $response='
                             <tr>
                               <td>
                                 <div id="itemForm">';
                                   if($likk["status"] == 0){ 
                                 $response.='<input type="checkbox" name="checkedtogive" id="checkedtogive'.$likk["fasttagid"].'" value="'.$likk["fasttagid"].'">';
                                   }else{ 
                                 $response.='<input type="checkbox" disabled="disabled">';
                                   }  
                           $response.=$i.
                                 '</div>
                                 </td>
							     <td>'.$likk["bankname"].'</td>
                                 <td>'.$likk["barcode"].'</td>
                                 <td>'.$likk["tagid"].'</td>
							     <td>'.$likk["tid"].'</td>
                                 <td>'.$likk["classoftag"].'</td>
                                 <td>'.$sts.'</td>
                                 <td>'.$btn.' '.$btn1.' '.$btn2.'</td>
                                 </tr>
                        ';
						echo $response;
                      }
                    }              
                      
                      exit;
            }
          
          
          	if($this->request->getVar('firstnum')){                
                   
                  $firstnum =  $this->request->getVar('firstnum');
                  $lastnum =  $this->request->getVar('lastnum');
              		
                  $frstnum="607469-".$firstnum;
                  $lastnum="607469-".$lastnum;
              
              
              
                  $likebarcode =  $this->loginModel->barcodeadvsrch($frstnum,$lastnum);
                  
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

                        if($likk["status"] == 0){
                          $sts="Active";
                          $btn = '<a href="'.base_url().'/secure/updtfasttag/'.$likk["fasttagid"].'/1"> <button class="btn btn-sm btn-danger" title="Block Fast Tag"> Block </button> </a>';
                          $btn1='<button class="btn btn-sm btn-info" onclick="allot_tag(\''.$likk["fasttagid"].'\');"> Allot Fastag </button>';
                          $btn2="";
                        }else if($likk["status"] == 1){
                          $sts="Blocked";
                          $btn='<a href="'.base_url().'/secure/updtfasttag/'.$likk["fasttagid"].'/0"> <button class="btn btn-sm btn-primary" title="Un-Block Fast Tag"> Un-Block </button> </a>';
                          $btn1="";
                          $btn2="";
                        }else if($likk["status"] == 2){
                          $sts="Allocated";
                          $btn='';
                          $btn1="";  
                          $btn2='<button class="btn btn-sm btn-warning" title="Transaction Details" onclick="showdetailstrns(\''.$likk["fasttagid"].'\');"> Show Details </button>';
                        }else{
                          $sts="";
                          $btn="";
                          $btn1="";
                          $btn2="";
                        }
                        
                        $response='
                             <tr>
                               <td>
                                 <div id="itemForm">';
                                   if($likk["status"] == 0){ 
                                 $response.='<input type="checkbox" name="checkedtogive" id="checkedtogive'.$likk["fasttagid"].'" value="'.$likk["fasttagid"].'">';
                                   }else{ 
                                 $response.='<input type="checkbox" disabled="disabled">';
                                   }  
                           $response.=$i.
                                 '</div>
                                 </td>
							     <td>'.$likk["bankname"].'</td>
                                 <td>'.$likk["barcode"].'</td>
                                 <td>'.$likk["tagid"].'</td>
							     <td>'.$likk["tid"].'</td>
                                 <td>'.$likk["classoftag"].'</td>
                                 <td>'.$sts.'</td>
                                 <td>'.$btn.' '.$btn1.' '.$btn2.'</td>
                                 </tr>
                        ';
						echo $response;
                      }
                    }              
                      
                      exit;
            }

            if($this->request->getVar('fastatgiddad')){
                  $fstg = $this->request->getVar('fastatgiddad');
                  $type = $this->request->getVar('type');
                  $salesmanagerfstg = $this->request->getVar('salesmanagerfstg');

                  $cnt = sizeof(json_decode(base64_decode($fstg)));
              
                  
                  for($i=0; $i< $cnt; $i++){
                    $val = json_decode(base64_decode($fstg))[$i];

                    $data = ["fasttagid"=>$val,"allotedto"=>$salesmanagerfstg,"allotedtotype"=>$type,"allotedby"=>0,"allotedbytype"=>0,"status"=>'0',"datetime"=>$dtm];
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$data);
                    if($loginData){
                        $table="fasttag";
                        $upclnm="fasttagid";
                        $updtdata = [
                            'status'=>2,
                        ];
                        $updtid=$val;
                        $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);                        
                            
                    }else{
                       $this->session->setTempdata('error','Sorry Unable To Allot Try Again Later', 3);
                       return redirect()->to(base_url('secure/managefasttag'));
                    }
                 } 
              
                $this->session->setTempdata('success','Fastag Alloted Successfully', 3);
                return redirect()->to(base_url('secure/managefasttag'));
          }
          
          if($this->request->getVar('trnsidshw')){            
            
            $tagtrnshistory = $this->loginModel->viewspecific('fastaginventory','*','fasttagid',$this->request->getVar('trnsidshw'));
            
            $response='
                
                	<div class="modal-header">
                      Transaction History
                    </div>
                    <div class="modal-body">';
            
            $cnt = sizeof($tagtrnshistory);
            for($i=0;$i < $cnt; $i++){
              
              if($tagtrnshistory[$i]['allotedtotype'] == 1){
                $usrtyp = "Sales Manager";
              }else if($tagtrnshistory[$i]['allotedtotype'] == 2){
                $usrtyp = "Team Lead";
              }else if($tagtrnshistory[$i]['allotedtotype'] == 3){
                $usrtyp = " Fiels Sales Executive";
              }else if($tagtrnshistory[$i]['allotedtotype'] == 4){
                $usrtyp = "Customer";
              }else if($tagtrnshistory[$i]['allotedtotype'] == 5){
                $usrtyp = "OEM";
              }else{
                $usrtyp = "NA";
              }             
              
              
              if($tagtrnshistory[$i]['allotedtotype'] == 1){
                
                $salesmng = $this->loginModel->viewspecific('salesmanager','*','salesManagerId',$tagtrnshistory[$i]['allotedto']);
                 if($salesmng[0]["status"] == 0){
                    $sts ="Active";
                  }else{
                    $sts ="Blocked";
                  }
                
                $response.='
                      <div class="row nc" style="padding-top: 10px;background: #ededed;border: 1px solid #dbdbdb;">
                        <div class="col-md-6">
                           <p> User Type <span> '.$usrtyp.' </span> </p>											
                        </div>
                        <div class="col-md-6">											
                        </div>
                        <div class="col-md-6">
                           <p> Regd Number <span> '.$salesmng[0]["RegdNum"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Name <span> '.$salesmng[0]["Fname"].' '.$salesmng[0]["Lname"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Contact Number <span> '.$salesmng[0]["ContactPrimary"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Email <span> '.$salesmng[0]["salesmngremailid"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Region Of Sale <span> '.$salesmng[0]["regionOfSale"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Profile Status <span> '.$sts.' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Tag Allot Date / Time <span> '.$salesmng[0]["datetime"].' </span> </p>											
                        </div>
					  </div>
                          ';
               
                
              }
              
              if($tagtrnshistory[$i]['allotedtotype'] == 2){
                
                $salesmng = $this->loginModel->viewspecific('teamlead','*','teamleadId',$tagtrnshistory[$i]['allotedto']);
                 if($salesmng[0]["status"] == 0){
                    $sts ="Active";
                  }else{
                    $sts ="Blocked";
                  }
                
                $response.='
                      <div class="row nc" style="padding-top: 10px;background: #ededed;border: 1px solid #dbdbdb;margin-top:10px;">
                        <div class="col-md-6">
                           <p> User Type <span> '.$usrtyp.' </span> </p>											
                        </div>
                        <div class="col-md-6">											
                        </div>
                        <div class="col-md-6">
                           <p> Regd Number <span> '.$salesmng[0]["TleadRegdNum"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Name <span> '.$salesmng[0]["Fname"].' '.$salesmng[0]["Lname"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Contact Number <span> '.$salesmng[0]["ContactPrimary"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Email <span> '.$salesmng[0]["teamleademailid"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Region Of Sale <span> '.$salesmng[0]["region"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Profile Status <span> '.$sts.' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Tag Allot Date / Time <span> '.$salesmng[0]["datetime"].' </span> </p>											
                        </div>
					  </div>
                          ';
               
                
              }
              
              if($tagtrnshistory[$i]['allotedtotype'] == 3){
                
                $salesmng = $this->loginModel->viewspecific('salesagent','*','salesagentId',$tagtrnshistory[$i]['allotedto']);
                 if($salesmng[0]["status"] == 0){
                    $sts ="Active";
                  }else{
                    $sts ="Blocked";
                  }
                
                $response.='
                      <div class="row nc" style="padding-top: 10px;background: #ededed;border: 1px solid #dbdbdb;margin-top:10px;">
                        <div class="col-md-6">
                           <p> User Type <span> '.$usrtyp.' </span> </p>											
                        </div>
                        <div class="col-md-6">											
                        </div>
                        <div class="col-md-6">
                           <p> Regd Number <span> '.$salesmng[0]["salesAgentRegdNum"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Name <span> '.$salesmng[0]["Fname"].' '.$salesmng[0]["Lname"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Contact Number <span> '.$salesmng[0]["ContactPrimary"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Email <span> '.$salesmng[0]["salesagentmailid"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Region Of Sale <span> '.$salesmng[0]["region"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Profile Status <span> '.$sts.' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Tag Allot Date / Time <span> '.$salesmng[0]["datetime"].' </span> </p>											
                        </div>
					  </div>
                          ';
               
                
              }
              
              if($tagtrnshistory[$i]['allotedtotype'] == 5){
                
                $salesmng = $this->loginModel->viewspecific('oem','*','oemid',$tagtrnshistory[$i]['allotedto']);
                 if($salesmng[0]["status"] == 0){
                    $sts ="Active";
                  }else{
                    $sts ="Blocked";
                  }
                
                $response.='
                      <div class="row nc" style="padding-top: 10px;background: #ededed;border: 1px solid #dbdbdb;margin-top:10px;">
                        <div class="col-md-6">
                           <p> User Type <span> '.$usrtyp.' </span> </p>											
                        </div>
                        <div class="col-md-6">											
                        </div>
                        <div class="col-md-6">
                           <p> Company name <span> '.$salesmng[0]["companyname"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Trade Name <span> '.$salesmng[0]["tradename"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> GST Number <span> '.$salesmng[0]["gstnumber"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> GM Name <span> '.$salesmng[0]["gmname"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> GM Contact <span> '.$salesmng[0]["gmcontact"].' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Profile Status <span> '.$sts.' </span> </p>											
                        </div>
                        <div class="col-md-6">
                           <p> Tag Allot Date / Time <span> '.$salesmng[0]["datetime"].' </span> </p>											
                        </div>
					  </div>
                          ';
               
                
              }
              
            }
            
            
            $response.='            
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>';
            

            echo $response;
            exit;
          }
          
          
        }
        $data=[];
        
      $paginateData = $this->loginModel->select('*')
                           ->where('status !=', 3)
                           ->orderBy('fasttagid', 'DESC')    			
                           ->paginate(100);
      //$this->loginModel->orderBy('fasttagid', 'DESC')->paginate(100)
      	$data = [
            'fastag' => $paginateData,
            'pager' => $this->loginModel->pager
        ];
      
      $fastaglastdata=[]; 
      $cnt = sizeof($data["fastag"]);
      
      for($i=0;$i < $cnt; $i++){
        $fstgid = $data["fastag"][$i]["fasttagid"].'<br>';
        $fastaglastdata[] = $this->loginModel->getLastFastag($fstgid);
      }
      
      $data["fastaglastdata"] = $fastaglastdata;
       
        
        return view('admin/managefasttag',$data);
    }
  
  
  	public function managefasttagspecific($type){
      if ((!isset($_SESSION['logged_usrid']))) {
        return redirect()->to(base_url('adminLogin'));            
      }
      
      $data =[];
      
      if($type == 'allocated'){
        $shwval = 2;
      }else if($type == 'unallocated'){
        $shwval= 0;
      }
      
      $paginateData = $this->loginModel->select('*')
         ->where('status', $shwval)
         ->orderBy('fasttagid', 'DESC')    			
         ->paginate(100);
      
     $data = [
       'fastag' => $paginateData,
       'pager' => $this->loginModel->pager
     ];     
      
      
      $data['type'] = $type;
      
      return view('admin/managefasttagspecific',$data);
    }

    public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="fasttag";
        $upclnm="fasttagid";
        $updtdata = [
            'status'=>$val,
        ];
        $updtid=$idd;
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            $this->session->setTempdata('success','Fast Tag Status Updated Successfully', 3);
            return redirect()->to(base_url('secure/managefasttag')); 

        $data["fastag"]=$this->loginModel->findAll();
        
        return view('admin/managefasttag',$data);
    }

    public function classofbarcode(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];
        $rules = [
              "prdclass"=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Product Class Is required ',
                  ],
              ],
              "barcodeclass"=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Barcode Class Is required ',
                  ],
              ],
              "vehicletype"=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Vehicle Type Is required ',
                  ],
              ],
              "toshowinapplication"=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'To Show In Application Is required ',
                  ],
              ],

          ];
      	
        if($this->request->getMethod() == "post"){
          
          if($this->request->getVar('updateid')){
            
            $updateid = $this->request->getVar('updateid');
            $updatedata = $this->request->getVar('updatedata');
            
            $table="classofbarcode";
            $upclnm="classofbarcodeid ";
            $updtdata = [
              'status'=>$updatedata,
            ];
            $updtid=$updateid;
            $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

            exit;
          }
          
          
          if($this->validate($rules)){
            
            $prdclass = $this->request->getVar('prdclass');
            $barcodeclass = $this->request->getVar('barcodeclass');
            $vehicletype = $this->request->getVar('vehicletype');    
            $toshowinapplication = $this->request->getVar('toshowinapplication'); 

            $dtm = date("Y-m-d h:i:s");

              $data = ["fastagclass"=>$prdclass, "classofbarcode"=>$barcodeclass, "typeofvehicle"=>$vehicletype, "datetime"=>$dtm, "status"=>0,"toshowinapplication"=>$toshowinapplication];
              $loginData = $this->loginModel->loginDatainsert('classofbarcode',$data);

              if($loginData){
                $this->session->setTempdata('success','Class Of Barcode Added Successfully', 3);
                return redirect()->to(base_url('secure/classofbarcode'));
              }else{
                $this->session->setTempdata('error','Sorry Unable To Add Class Of Barcode  Try Again Later', 3);
                return redirect()->to(base_url('secure/classofbarcode'));
              }            
            
          }else{
            $data['validations'] = $this->validator;
          }
          
        }
      
        $table="classofbarcode";
        $viewdata="*";
        $whrclm="status !=";
        $whrval=2;
        $data["barcode"]=$this->loginModel-> viewspecific($table,$viewdata,$whrclm,$whrval);
      
        $data["claassftag"]=$this->productModel->distinctVal('fasttag','classoftag');
        
        return view('admin/classofbarcode',$data);
    }
  
  
  
  	public function returntag(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];
        
        if($this->request->getMethod() == "post"){
             if($this->request->getVar('add')){
                      $rollbackid = base64_encode(json_encode($this->request->getVar('rollbackid')));
                      
        $response='
                    <form action ="'.base_url().'/secure/returntag" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                      <div class="modal-header">
                        <h5 class="modal-title">Confirm Roll Back</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are You Sure To Roll Back</p>
                        <input type="hidden" value="'.$rollbackid.'" name="rollbakcnfrm">
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      </div>
                    </form>
                  ';
                      
                      echo $response;
                      exit;
             }
             
             
             if($this->request->getVar('rollbakcnfrm')){
                 $dtm = date("Y-m-d h:i:s");
                      $rollbackid = json_decode(base64_decode($this->request->getVar('rollbakcnfrm')));
                      $cnt = sizeof($rollbackid);
                      
                      for($i=0;$i< $cnt; $i++){
                          
                          $tableo="fastaginventory";
                          $viewdatao="*";
                          $whrclmo="fasttagid";
                          $whrvalo= $rollbackid[$i];
                          $fstginv=$this->loginModel->viewspecific($tableo,$viewdatao,$whrclmo,$whrvalo);
                          
                          $cnt1 = sizeof($fstginv);
                          
                          for($j=0;$j< $cnt1; $j++){
                              $data = ["fasttagid"=>$fstginv[$j]['fasttagid'],"allotedto"=>$fstginv[$j]['allotedto'],"allotedtotype"=>$fstginv[$j]['allotedtotype'],"allotedby"=>$fstginv[$j]['allotedby'],"allotedbytype"=>$fstginv[$j]['allotedbytype'],"alloteddatetime"=>$fstginv[$j]['datetime'],"datetime"=>$dtm];
                              $loginData = $this->loginModel->loginDatainsert('fastagreturninventory',$data);
                          }
                          
                          
                          $table="fasttag";
                          $upclnm="fasttagid";
                          $updtdata = [
                              'status'=>0,
                          ];
                          $updtid=$rollbackid[$i];
                          $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                          
                          
                         $delete = $this->loginModel->deleteentry('fastaginventory','fasttagid',$rollbackid[$i]);
                      }
                      if($delete){
                         $this->session->setTempdata('success','Fastag Rolledback Successfully', 3);
                         return redirect()->to(base_url('secure/returntag'));
                     }else{
                         $this->session->setTempdata('error','Sorry Unabe To Rolledback Fastag', 3);
                         return redirect()->to(base_url('secure/returntag'));
                     }
             }
          
             
             if($this->request->getVar('searchvalue')){              
                   
                  $likebarcode =  $this->loginModel->fastaglike($this->request->getVar('searchvalue'));
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

                        $response='
                             <tr>
                                 <td>'.$i.'</td>
							     <td>'.$likk["bankname"].'</td>
                                 <td>'.$likk["barcode"].'</td>
                                 <td>'.$likk["tagid"].'</td>
							     <td>'.$likk["tid"].'
                                 <input type="hidden" value="'.$likk["fasttagid"].'" name="tagsrollback'.$likk["fasttagid"].'">
                                 </td>
                                 <td> <button class="allocated-button btn btn-sm btn-info" onclick="rollback(\''.$likk["fasttagid"].'\');"> Rollback </button> </td>
                             </tr>
                        ';
						echo $response;
                      }
                    }              
                      
                      exit;
            }
        }
        
      
      	$paginateData = $this->loginModel->select('*')
         ->where('status', 2)			
         ->paginate(100);
      
      
         //$paginateData = $this->loginModel->select('fasttag.fasttagid,fasttag.bankname,fasttag.barcode,fasttag.tagid,fasttag.tid,fasttag.classoftag,fasttag.status,fasttag.datetime,fastaginventory.allotedtotype')
          //->join('fastaginventory', 'fastaginventory.fasttagid = fasttag.fasttagid')  
          //->where('fasttag.status',2)
         // ->where('fastaginventory.allotedtotype !=',4)
         // ->paginate(100);
     
      
         $data = [
           'barcode' => $paginateData,
           'pager' => $this->loginModel->pager
         ];
      
      
        
        return view('admin/returntag',$data);
    }
  
  
  
     public function regstrdnumfstg(){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];
        
        if($this->request->getMethod() == "post"){
             if($this->request->getVar('allotbarcodeforid')){
               $allotbarcodeforid = $this->request->getVar('allotbarcodeforid');               
               $datad = $this->loginModel->viewspecific('requestRegisterednumber','*','reqstregdnumid',$allotbarcodeforid);
               if($this->request->getVar('reqsttyp') == 0){
                  $salesagnt = $this->loginModel->sortfastag($datad[0]['salesagentid'],3,0);
               }else{
                  $salesagnt = $this->loginModel->sortfastag($datad[0]['salesagentid'],5,0);
               }
               
               $response='
               
               			<div class="modal-header">
                          <h5 class="modal-title"> Allot Barcode </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action ="'.base_url().'/secure/regstrdnumfstg" method="post" autocomplete="off" enctype=\'multipart/form-data\'>
                          <div class="modal-body">
                            <div class="form-group row utg">
                                <label class="col-sm-2 col-form-label">Product</label>
                                  <div class="col-sm-10">
                                    <select class="form-control" name="barcodetoallot" id="barcodetoallot" style="width:50%;" onchange="shwClassTag(this.value);">
                                        <option value=""> Select Barcode </option>
                                        ';
               
               							foreach($salesagnt as $rtt){
                                         $response.='<option value="'.$rtt["barcode"].'">'.$rtt["barcode"].'</option>';
                                        }
               
               
               $response.='         </select>
                                    <input type="hidden" name="reqstregdnumid" value="'.$allotbarcodeforid.'">
                                    <input type="hidden" name="regstrtotype" value="'.$this->request->getVar('reqsttyp').'">
                                  </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Allot </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </form>                  
                      ';
               
               echo $response;
               exit;
               
               
             }
          
          
            if($this->request->getVar('reqstregdnumid')){
              $reqstregdnumid = $this->request->getVar('reqstregdnumid');
              
              $allocationdata = $this->loginModel->viewspecific('requestRegisterednumber','*','reqstregdnumid',$reqstregdnumid);
              $barcodetoallot = $allocationdata[0]["allotedbarcode"];
               
                  
                  if($this->request->getVar('regstrtotype') == 1){
                    
                    $dtm=date("Y-m-d h:i:s");
                  
                    $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcodetoallot);
                    $fatsagid = $salesagentdetails[0]['fasttagid'];

                    $table1 ='fastaginventory';
                    $upclnm1 ='fasttagid';
                    $updtdata1 = [                          
                      'status'=>1,
                    ];
                    $updtid1 = $fatsagid;
                    $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);  
                    $reqstregdnumid = $this->request->getVar('reqstregdnumid');
                    $datad = $this->loginModel->viewspecific('requestRegisterednumber','*','reqstregdnumid',$reqstregdnumid);
                    $name = $datad[0]['firstname'].' '.$datad[0]['lastname'];


                    $databankdetails = ["productid"=>'',"classofBarcode"=>'',"vehicleType"=>'',"rcbook"=>$datad[0]['vehcllnumbr'],"mobileNumber"=>$datad[0]['mobilenumbr'],"drivingLicence"=>'',"vehicleNumbertype"=>1,"vehiclechasisnumber"=>$datad[0]['vehcllnumbr'],"salesagentId"=>$datad[0]['salesagentid'],"transactionstatus"=>0,"transactionid"=>'',"datetime"=>$dtm,"pancarddetails"=>'',"customername"=>$name,"dateofbirth"=>'',"salesagenttype"=>1,"barcodeid"=>$barcodetoallot];
                    $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$databankdetails);
                    $bankid = $this->loginModel->db->insertID(); 

                    $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$bankid,"allotedtotype"=>4,"allotedby"=>$datad[0]['salesagentid'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);

                    $table ='requestRegisterednumber';
                    $upclnm ='reqstregdnumid';
                    $updtdata = [
                        'status'=>1,
                        'allotedbarcode'=>$barcodetoallot,
                    ];
                    $updtid = $this->request->getVar('reqstregdnumid');
                    $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);


                    $this->session->setTempdata('success','Barcode Alloted Successfully', 3);
                    return redirect()->to(base_url('secure/regstrdnumfstg'));
                    
                  }else if($this->request->getVar('regstrtotype') == 0){
                  
                  $tnid = time();
                  
                  $reqstregdnumid = $this->request->getVar('reqstregdnumid');
                  $datad = $this->loginModel->viewspecific('requestRegisterednumber','*','reqstregdnumid',$reqstregdnumid);
                  
                  $wallatdetails = $this->walletModel->getWalletbalance($datad[0]['salesagentid'],'1');
                  $cnt = sizeof($wallatdetails);
                  
                  if($cnt == 0){
                    
                    $this->session->setTempdata('error','User Dosent Have Sufficient Balance', 3);
                    return redirect()->to(base_url('secure/regstrdnumfstg'));
                    
                  }else{
                    $credit=0;
                    $debit=0;
                    foreach($wallatdetails as $wallet):

                    if($wallet["transactiontype"] == 1){
                      $credit = $credit + $wallet["amount"];
                    }else if($wallet["transactiontype"] == 2){
                      $debit = $debit + $wallet["amount"];
                    }

                    endforeach;
                    
                    $pending = $credit - $debit;
                    
                    if($pending < 200){
                      $this->session->setTempdata('error','User Dosent Have Sufficient Balance', 3);
                      return redirect()->to(base_url('secure/regstrdnumfstg'));                      
                    }else if($pending >= 200){
                                      
                  
                  $name = $datad[0]['firstname'].' '.$datad[0]['lastname'];

                  $dtm=date("Y-m-d h:i:s");
                  
                  $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcodetoallot);
                  $fatsagid = $salesagentdetails[0]['fasttagid'];

                  $table1 ='fastaginventory';
                  $upclnm1 ='fasttagid';
                  $updtdata1 = [                          
                    'status'=>1,
                  ];
                  $updtid1 = $fatsagid;
                  $upt=$this->loginModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);                  
                  

                  $databankdetails = ["productid"=>$datad[0]['product'],"classofBarcode"=> $datad[0]['vehicleclass'],"vehicleType"=>$datad[0]['vehicletype'],"rcbook"=>$datad[0]['vehcllnumbr'],"mobileNumber"=>$datad[0]['mobilenumbr'],"drivingLicence"=>'',"vehicleNumbertype"=>$datad[0]['vehicledatatype'],"vehiclechasisnumber"=>$datad[0]['vehcllnumbr'],"salesagentId"=>$datad[0]['salesagentid'],"transactionstatus"=>0,"transactionid"=>'',"datetime"=>$dtm,"pancarddetails"=>'',"customername"=>$name,"dateofbirth"=>'',"salesagenttype"=>0,"barcodeid"=>$barcodetoallot,"txnstatus"=>'SUCCESS',"responsecode"=>230201,"responsestatus"=> 'SUCCESS'];
                  $loginData = $this->loginModel->loginDatainsert('tagactivationinitial',$databankdetails);
                  $bankid = $this->loginModel->db->insertID(); 

                  $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$bankid,"allotedtotype"=>4,"allotedby"=>$datad[0]['salesagentid'],"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                  $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);

                  $insertdata = ["payerid" => $datad[0]['salesagentid'], "payertype" =>1, "amount" => 200, "transactionid" => $tnid, "transactiontype" => 2, "transactionstatus" => 2,"txn" => "SUCCESS","datetime"=>$dtm];               
                  $loginData = $this->loginModel->loginDatainsert('wallet',$insertdata);
                  
                  
                  $table ='requestRegisterednumber';
                  $upclnm ='reqstregdnumid';
                  $updtdata = [
                      'status'=>1,
                      'allotedbarcode'=>$barcodetoallot,
                  ];
                  $updtid = $this->request->getVar('reqstregdnumid');
                  $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
                  
                  
                  $this->session->setTempdata('success','Barcode Alloted Successfully', 3);
                  return redirect()->to(base_url('secure/regstrdnumfstg'));

                 }
                }
               }
            }          
        }
          
          
        
        $paginateData = $this->loginModel->viewspecific('requestRegisterednumber','*','status',0);
      
         $data = [
           'barcode' => $paginateData,
           'pager' => $this->loginModel->pager
         ];
               
        return view('admin/regstrdnumfstg',$data);
    }  
          
          	
}

?>