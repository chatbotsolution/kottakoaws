<?php

namespace App\Controllers;
use \App\Models\SalesManagerModel;

class FastTagController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        $this->loginModel = new SalesManagerModel();
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
                'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
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
                            $data = ["barcode"=>$userdata["barcode"],"tagid"=>$userdata["tagid"],"classoftag"=>$userdata["classoftag"],"status"=>'0',"datetime"=>$dtm,"tid"=>$userdata["tid"],"bankname"=>$bank];
                            $loginData = $this->loginModel->loginDatainsert('fasttag',$data);
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
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" style="width:60%;" id="salesmanager">
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

            if($this->request->getVar('typ')){

                if($this->request->getVar('typ') == 1){

                    $response='
                            <select class="form-control" style="width:60%;" name="salesmanagerfstg">';
                                    $cnt = count($data["salsmngr"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["salsmngr"][$i]["Fname"].' '.$data["salsmngr"][$i]["Lname"].' ( '.$data["salsmngr"][$i]["RegdNum"].' )';
                            $response.='<option value="'.$data["salsmngr"][$i]["salesManagerId"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>';

                }else if($this->request->getVar('typ') == 5){

                    $response='
                            <select class="form-control" style="width:60%;" name="salesmanagerfstg">';
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
                                <select class="form-control" style="width:60%;" name="type" onchange="shwtyp(this.value);">
                                     <option value="1"> Sales Agent </option>
                                     <option value="5"> OEM </option>
                                </select>
                                <span class="errmsg" style="text-align:left;" id="ermid"></span>
                            </div>
                            <div class="col-sm-3 col-form-label">
                                Select Sales Manager
                                <input type="hidden" name="fastatgiddad" value="'.$dataa.'">
                            </div>
                            <div class="col-md-9 shwhrr">
                                <select class="form-control" style="width:60%;" name="salesmanagerfstg">';
                                    $cnt = count($data["salsmngr"]);
                                for($i=0;$i<$cnt;$i++){
                                    $shw = $data["salsmngr"][$i]["Fname"].' '.$data["salsmngr"][$i]["Lname"].' ( '.$data["salsmngr"][$i]["RegdNum"].' )';
                            $response.='<option value="'.$data["salsmngr"][$i]["salesManagerId"].'">'.$shw.'</option>';
                                }  
                                    
                    $response.='</select>
                                <span class="errmsg" style="text-align:left;" id="ermid"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Allot Tag</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                    ';

                    echo $response;
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
                        $response="done";
                    }else{
                       echo $response="sorry";
                       exit;
                    }
                  }
                  echo $response;
                  exit;
            }
        }
        $data=[];
        $data["fastag"]=$this->loginModel->orderBy('fasttagid', 'DESC')->findAll();
       
        
        return view('admin/managefasttag',$data);
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
        $table="classofbarcode";
        $viewdata="*";
        $whrclm="status";
        $whrval=0;
        $data["barcode"]=$this->loginModel-> viewspecific($table,$viewdata,$whrclm,$whrval);
        
        return view('admin/classofbarcode',$data);
    }
}

?>