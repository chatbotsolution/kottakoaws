<?php

namespace App\Controllers;
use \App\Models\LoginModel;

class AdminDashboardController extends BaseController
{
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('email');
        $this->loginModel = new loginModel();
        $this->session = session();
    
        
    }
    public function index()
    {

        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        } else {

        $data= [];
            $admndta = $this->loginModel->searchh('admin','*','admin_id',1);
            $to = $admndta[0]['email'];
            $from = "connect@kottakotabusinesses.com";
            $subject ="Login Notification";
            $message ="Admin Account Has Been Logged In";
            sendEMail($to,$from,$subject,$message);
              
        
           return view('admin/dashboard',$data);
        }    
    }

    public function addpayment($id)
    {

        if ((!isset($_SESSION['logged_usrid']))) {

            return redirect()->to(base_url('adminLogin'));
            
        } else {

        $data= [];
        
            $rules = [
                "payamount"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Payment Amount Is Required',
                    ],
                ],
                "referencenum"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Refrence Number Is Required',
                    ],
                ],
                "modeofpay"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Mode Of Payment Is Required',
                    ],
                ],
                "dateofpay"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Date Of Payment Is Required',
                    ],
                ],
                "qntyordr"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Quantity Ordered Is Required',
                    ],
                ],
                "fastagprd"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Fastag Product  Is Required',
                    ],
                ],
            ];

            if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                   
                    $oemid = $this->request->getVar('oemid');
                    $payamount = $this->request->getVar('payamount');
                    $referencenum = $this->request->getVar('referencenum');
                    $modeofpay = $this->request->getVar('modeofpay');
                    $dateofpay = $this->request->getVar('dateofpay');
                    $qntyordr = $this->request->getVar('qntyordr');
                    $fastagprd = $this->request->getVar('fastagprd');

                        $dtm = date("Y-m-d h:i:s");
                        $datte = date("Y-m-d", strtotime($dateofpay));
                        
                        $data = ["paymentamount"=>$payamount,"refrencenumber"=>$referencenum,"modeofpayment"=>$modeofpay,"dateofpayment"=>$dateofpay,"quantityordered"=>$qntyordr,"fastagproduct"=>$fastagprd,"oemid"=>$oemid,"datetime"=>$dtm];
                        
                        $loginData = $this->loginModel->loginDatainsert('oempayments',$data);
                        

                        if($loginData){
                            $this->session->setTempdata('success','Payment Added Successfully', 3);
                            return redirect()->to(current_url());
                        }else{
                            $this->session->setTempdata('error','Sorry Unable To Add Payment', 3);
                            return redirect()->to(current_url());
                        }
                        return redirect()->to(base_url().'/secure/addpayment/'.$oemid);

                                
        
        
                }else{
                    $data['validations'] = $this->validator;
                }
            }
            $data['paymentfor'] = $this->loginModel->searchh('oem','*','oemid',$id);

            return view('admin/addpayment',$data);
        }
    }
  
  
  
    public function walletactivation(){      
         $data=[]; 
      if($this->request->getMethod() == "post"){
        if($this->request->getVar('updtval')){
          
          $updtval = $this->request->getVar('updtval');
          $updtid = $this->request->getVar('updtid');
          $updtsts = $this->request->getVar('updtsts');
                  
          $table ='wallet';
          $upclnm ='walletid';
          $updtdata = [
            'txn'=>$updtsts,
            'transactionstatus'=>$updtval,
          ];
          $updtid = $updtid;
          $upt=$this->loginModel->entry_update($table,$updtid,$updtdata,$upclnm); 
      $response='    
          <div class="alert alert-success alert-dismissible fade show">Data Updated Successfully
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          ';
          
          echo $response;
          exit;
          
        }
      }
      
      
      
      	$data['walletdata'] = $this->loginModel->walltsrch();
     
      
        return view('admin/walletactivation',$data);
    }
  
  
  
  	public function manufacturer(){
      
        $data=[];
      
      	$rules = [
                "manfctrnm"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Manufacturer Name Is Required',
                    ],
                ],                
            ];

            if($this->request->getMethod() == "post"){
                if($this->validate($rules)){
                   
                    $manfctrnm = $this->request->getVar('manfctrnm');

                        $dtm = date("Y-m-d h:i:s");
                        
                        $data = ["manufacturername"=>$manfctrnm,"status"=>0,"datetime"=>$dtm];
                        
                        $loginData = $this->loginModel->loginDatainsert('manufacturer',$data);
                        

                        if($loginData){
                            $this->session->setTempdata('success','Manufacturer Added Successfully', 3);
                            return redirect()->to(current_url());
                        }else{
                            $this->session->setTempdata('error','Sorry Unable To Add Manufacturer', 3);
                            return redirect()->to(current_url());
                        }
                        return redirect()->to(base_url().'/secure/manufacturer'); 
                }else{
                    $data['validations'] = $this->validator;
                }
            }
      
      
      
      
        $data['manufacturer'] = $this->loginModel->allsrch('manufacturer');     
      
        return view('admin/manufacturer',$data);
      
    }
  
  	public function updateStatus($idd,$val){
        if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }

        $data=[];

        $table="manufacturer";
        $upclnm=$idd;
        $updtdata = [
            'status'=>$val,
        ];
        $updtid="manufactureid";
        $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);

        $this->session->setTempdata('success','Status Updated Successfully', 3);
        return redirect()->to(base_url('secure/manufacturer')); 

    }
  
  public function downloaddatabase()// this function is for downloading the whole database
  {
      if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
   // Database configuration
    $host = "localhost";
    $username = "kottakotabusines_kottako_hitchpa";
    $password = "M3nxTZ0AnJu5";
    $database_name = "kottakotabusines_hitchpa";
    // Get connection object and set the charset
    $conn = mysqli_connect($host, $username, $password, $database_name);
    $conn->set_charset("utf8");
    // Get All Table Names From the Database
    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }
    $sqlScript = "";
    foreach ($tables as $table) {
            // Prepare SQLscript for creating table structure
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
        $query = "SELECT * FROM $table";
        $result = mysqli_query($conn, $query);
        $columnCount = mysqli_num_fields($result);
        // Prepare SQLscript for dumping data for each table
        for ($i = 0; $i < $columnCount; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $columnCount; $j++) {
                    $row[$j] = $row[$j];
                 if (isset($row[$j])) {
                        $sqlScript .= '"' . $row[$j] . '"';
                    } else {
                        $sqlScript .= '""';
                    }
                    if ($j < ($columnCount - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
        }

        $sqlScript .= "\n"; 
    }

    if(!empty($sqlScript))
    {
        // Save the SQL script to a backup file
        $backup_file_name = $database_name . '_backup_' . time() . '.sql';
        $fileHandler = fopen($backup_file_name, 'w+');
        $number_of_lines = fwrite($fileHandler, $sqlScript);
        fclose($fileHandler); 
     // Download the SQL backup file to the browser
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backup_file_name));
        ob_clean();
        flush();
        readfile($backup_file_name);
        exec('rm ' . $backup_file_name); 
    } 
      }
  
  
  	public function managepincode(){
  	    if ((!isset($_SESSION['logged_usrid']))) {
            return redirect()->to(base_url('adminLogin'));            
        }
      
        $data=[];
      
      	$rules = [
                "pincode"=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'PIN Code Is Required',
                    ],
                ],                
            ];

            if($this->request->getMethod() == "post"){
              

          if($this->request->getVar('uploadcsv')){  
            $dtm=date("Y-m-d h:i:s");
            
           $input = $this->validate([
                'file' => 'uploaded[file]|max_size[file,10048]|ext_in[file,csv],'
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
                        $numberOfFields = 1; 
                        $importData_arr = array();
                        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields){
                        $importData_arr[$i]['pincode'] = $filedata[0];
                        }
                        $i++;
                        }
                        fclose($file);
                        $count = 0;
                        print_r($importData_arr);
                        foreach($importData_arr as $userdata){
                            $data = ["pincode"=>$userdata["pincode"],"status"=>0,"datetime"=>$dtm];
                            $loginData = $this->loginModel->loginDatainsert('pincode',$data);
                        }
                            $this->session->setTempdata('success','PIN Code Added Successfully', 3);
                            return redirect()->to(current_url());
                        }else{
                            $this->session->setTempdata('error','Sorry Unable To Add PIN Code', 3);
                            return redirect()->to(current_url());
                        }
                        return redirect()->to(base_url().'/secure/managepincode');               
                
                }       
              
            }
              
              if($this->request->getVar('changeid')){ 
               
               	$changeid = $this->request->getVar('changeid');
                $changeval = $this->request->getVar('changeval');
               
                $table="pincode";
                $upclnm=$changeid;
                $updtdata = [
                    'status'=>$changeval,
                ];
                $updtid="pincodeid";
                $loginData = $this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
               exit;
             }
              
              if($this->validate($rules)){
                   
                        $pincode = $this->request->getVar('pincode');
                        $dtm = date("Y-m-d h:i:s");
                        
                        $data = ["pincode"=>$pincode,"status"=>0,"datetime"=>$dtm];
                        
                        $loginData = $this->loginModel->loginDatainsert('pincode',$data);
                        

                        if($loginData){
                            $this->session->setTempdata('success','PIN Code Added Successfully', 3);
                            return redirect()->to(current_url());
                        }else{
                            $this->session->setTempdata('error','Sorry Unable To Add PIN Code', 3);
                            return redirect()->to(current_url());
                        }
                        return redirect()->to(base_url().'/secure/managepincode'); 
                }else{
                    $data['validations'] = $this->validator;
                }
            }
      
      
         
        $data['pincode'] = $this->loginModel->allsrch('pincode');
      
        return view('admin/managepincode',$data);
      
    }
  public function letterrequest()
  {
      if ((!isset($_SESSION['logged_usrid']))) {
           return redirect()->to(base_url('adminLogin'));            
      }
  	return view('admin/permissionletterrequest');  
  }
  
  
  public function otplist($type){
      
      if ((!isset($_SESSION['logged_usrid']))) {
          return redirect()->to(base_url('adminLogin'));            
      }
      
      if($type == "fse"){
        $data["otp"] = $this->loginModel->searchhotp('salesagent');
        $data["type"] = $type;
      }else if($type == "salesmanager"){
        $data["otp"] = $this->loginModel->searchhotp('salesmanager');
        $data["type"] = $type;
      }else if($type == "teamlead"){
        $data["otp"] = $this->loginModel->searchhotp('teamlead');
        $data["type"] = $type;
      }
      
      return view('admin/otplist',$data);
      
  }

}//controller end
  