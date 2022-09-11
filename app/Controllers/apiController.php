<?php

namespace App\Controllers;
use \App\Models\LoginModel;
use \App\Models\SalesAgentModel;
use \App\Models\SalesAgentWalletModel;
use \App\Models\ProductModel;
use \App\Models\OemModel;
use \App\Models\SalesManagerModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class apiController extends BaseController
{
    public $loginModel;
    public $salesagentModel;
    public $walletModel;
    public $productmodel;
    public $oemModel;
    public $salesmanagerModel;
    use ResponseTrait;


    public function __construct(){
        helper("form");
        helper('text');
        helper('email');
        helper('cookie');
        helper('payment');
        helper('fastag');
        $this->loginModel = new loginModel();
        $this->salesagentModel = new SalesAgentModel();
        $this->walletModel = new SalesAgentWalletModel();
        $this->productmodel = new ProductModel(); 
        $this->oemModel = new OemModel();
        $this->salesmanagerModel = new SalesManagerModel();
        $this->session = session();
        
    }

    public function apilogin(){

          if ((isset($_SESSION['logged_usrid']))) {

              return redirect()->to(base_url('/secure/dashboard'));

          } else {

              $data= [];
              $rules = [
                  "userName"=>[
                      'rules'=>'required',
                      'errors'=>[
                          'required'=>'User Name Is Required',
                      ],
                  ],
                  "Password"=>[
                      'rules'=>'required',
                      'errors'=>[
                          'required'=>'Password Is Required',
                      ],
                  ],
              ];

              if($this->request->getMethod() == "post"){                                
                          $userid = $this->request->getVar('userName');
                          $password = $this->request->getVar('Password');
                          $pass = md5(sha1(md5(sha1($password))));
                          $retrndata = $this->loginModel->verifyUserid($userid,0);

                      if($retrndata){
                          $profileImage=$retrndata['image'];

                          if($pass == $retrndata['password']){                              

                                  if($retrndata['status'] == 0){
                                      $response = [
                                          'status'   => 200,
                                          'error'    => true,
                                          'messages' => [
                                              'responsecode'=>"00",
                                              'status' => $retrndata
                                          ]
                                      ];
                                      return $this->respond($response);

                                  }else{
                                      $response = [
                                          'status'   => 400,
                                          'error'    => false,
                                          'messages' => [
                                              'responsecode'=>"01",
                                              'status' => 'account locked'
                                          ]
                                      ];
                                      return $this->respond($response);
                                  } 

                              }else{
                                  $response = [
                                      'status'   => 400,
                                      'error'    => false,
                                      'messages' => [
                                          'responsecode'=>"01",
                                          'status' => 'invalid password'
                                      ]
                                  ];
                                  return $this->respond($response);
                              }
                          }else{
                              $response = [
                                  'status'   => 400,
                                  'error'    => false,
                                  'messages' => [
                                      'responsecode'=>"01",
                                      'status' => 'invalid id'
                                  ]
                              ];
                              return $this->respond($response);
                          }
              }
          }
      }
  
  
  
  	 public function saleagentapilogin(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $userid = $this->request->getVar('usrid');
                $otp = random_string('numeric', 6);
                //$otp=0;

                $retrndata = $this->salesagentModel->findSelect($userid);
                if($retrndata){

                    $table ='salesagent';
                    $upclnm ='salesagentId';
                    $updtdata = [
                        'otp'=>$otp,
                    ];
                    $updtid = $retrndata["salesagentId"];
                    $upt=$this->salesagentModel->entry_update($table,$upclnm,$updtdata,$updtid);

                        $to=$retrndata["salesagentmailid"];
                        $subject="OTP For Your Login";
                        $message="Hi, Your requested OTP is ".$otp;
                        $from="connect@kottakotabusinesses.com";
                        $sndmail = sendEMail($to,$from,$subject,$message);

                        $response = [
                          'status'   => 200,
                          'error'    => true,
                          'messages' => [
                            'responsecode'=>"00",
                            'status' => 'mail send'
                          ]
                        ];
                      return $this->respond($response);

                }else{
                  $response = [
                    'status'   => 400,
                    'error'    => false,
                    'messages' => [
                      'responsecode'=>"01",
                      'status' => 'invalid id'
                    ]
                  ];
                  return $this->respond($response);
                }
            }
       }
     }
  
  
  	 public function saleagentapiverifyotp(){

        $data=[];

        if($this->request->getMethod() == "post"){
            if($this->request->getVar('usrid')){
                $loginusrid = $this->request->getVar('usrid');
                $usrotp = $this->request->getVar('usrotp');

                $retrndata = $this->salesagentModel->findSelect($loginusrid);               
                                
                if($retrndata){
                    if($retrndata["status"] == 0){
                        
                        if($usrotp == $retrndata["otp"]){
                          
                          $salesagentfull = $this->salesagentModel->showprofiledetails1($retrndata["salesagentId"]);
                          
                          $tablee ='salesagent';
                          $updtide = $retrndata["salesagentId"];
                          $updtdatae = [
                            'otp'=>null,
                          ];
                          $upclnme = 'salesagentId';
                          $this->salesagentModel->entry_update($tablee,$upclnme,$updtdatae,$updtide);
                          
                          if (!empty($_SERVER['HTTP_CLIENT_IP']))
                          {
                            $ip = $_SERVER['HTTP_CLIENT_IP'];
                          }
                          elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                          {
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                          }
                          else
                          {
                            $ip = $_SERVER['REMOTE_ADDR'];
                          }

                          $dtm = date("Y-m-d h:i:s");
                          $tm = time();

                          $data = ["user_ip_add"=>$ip,'user_type'=>3,'login_id'=>$retrndata["salesagentId"],'datetime_login'=>$dtm,'date_logout'=>$dtm,'timevalue'=>$tm];

                          $loginData = $this->loginModel->loginDatainsert('login_data',$data);
                          $lid = $this->loginModel->db->insertID();
                          
                          
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $salesagentfull
                            ]
                          ];
                          return $this->respond($response);

                        }else{
                          $response = [
                            'status'   => 400,
                            'error'    => false,
                            'messages' => [
                              'responsecode'=>"01",
                              'status' => 'invalid otp'
                            ]
                          ];
                          return $this->respond($response);
                        }
                    }else{
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => 'account locked'
                        ]
                      ];
                      return $this->respond($response);
                    }
                }else{
                  $response = [
                    'status'   => 400,
                    'error'    => false,
                    'messages' => [
                      'responsecode'=>"01",
                      'status' => 'invalid id'
                    ]
                  ];
                  return $this->respond($response);
                }
            }
       }
     }
  
  
  	 public function addwalletbalance(){

          $data=[];

          if($this->request->getMethod() == "post"){
              if($this->request->getVar('payerid')){
                
                  $dtm = date("Y-m-d h:i:s");
                
                  $payerid = $this->request->getVar('payerid');
                  $amount = $this->request->getVar('amount');
                  $transactionid = $this->request->getVar('transactionid');
                  $transactionstatus = $this->request->getVar('transactionstatus');
                  $txnstatus = $this->request->getVar('txnstatus');
                
                
                  $walletdata = ["payerid"=>$payerid,"payertype"=>1,"amount"=>$amount,"transactionid"=>$transactionid,"transactiontype"=>1,"transactionstatus"=>$transactionstatus,"datetime"=>$dtm,"txn"=>$txnstatus];                
                  $loginData = $this->loginModel->loginDatainsert('wallet',$walletdata);
                
                  if($loginData){
                    
                      $response = [
                      'status'   => 200,
                      'error'    => true,
                      'messages' => [
                        'responsecode'=>"00",
                        'status' => 'wallet updated'
                      ]
                    ];
                    return $this->respond($response);
                    
                  }else{
                    
                    $response = [
                      'status'   => 400,
                      'error'    => false,
                      'messages' => [
                        'responsecode'=>"01",
                        'status' => 'wallet update failed'
                      ]
                    ];
                    return $this->respond($response);
                    
                  }  
              }
          }
       }
  
  
        public function getwalletbalance(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $loginData = $this->walletModel->getWalletbalance($userid,'1');

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $loginData
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  
  		public function fastagInventory(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $loginData = $this->salesagentModel->showfastag($userid,3);  

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $loginData
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  
  		public function newcustomerreport(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $array = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $userid , 'salesagenttype' =>0);
              $loginData = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array); 

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $loginData
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  
  		public function existingcustomerreport(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $userid , 'salesagentType' =>0);
              $loginData = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $loginData
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  
  		public function todayactivation(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $startdate = date("Y-m-d");
              $enddate = date( 'Y-m-d', strtotime( $startdate . ' +1 day' ) );

              $rt = $startdate.' 00:00:00';
              $rte = $enddate.' 00:00:00';
              
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $userid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              
              $array1 = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $userid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData1 = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array1);
              
              $finalreport = array_merge($loginData,$loginData1);
              
              $cnt = sizeof($loginData) + sizeof($loginData1);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $finalreport,
                    'count' => $cnt
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  		public function yesterdayactivation(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
              
              $enddate = date("Y-m-d");
              $startdate = date( 'Y-m-d', strtotime( $enddate . ' -1 day' ) );

              $rt = $startdate.' 00:00:00';
              $rte = $enddate.' 00:00:00';
              
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $userid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              
              $array1 = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $userid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData1 = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array1);
              
              $cnt = sizeof($loginData) + sizeof($loginData1);
              $finalreport = array_merge($loginData,$loginData1);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $finalreport,
                    'count' => $cnt
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
  
  
  	   public function gettranshistory(){

          $data=[];
             $data['vehicledata'] = GetTransactionsHistory("8755728922",0,"1-03-2022","22-05-2022");
             $data1 = json_decode($data['vehicledata'])[0];
             $array = json_decode(json_encode($data1), true);
         
           echo"<pre>";
           print_r($data['vehicledata']);
         
           exit;
      }
  
  	  
      public function getfastagclass(){

          $data=[];
              
              $userid = $this->request->getVar('userid');
              
              $clssoffastag = $this->productmodel->distinctVal('fasttag','classoftag');

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $clssoffastag
                  ]
                ];
                return $this->respond($response);               
            
       }
  
  
  	   public function fastagrequesthistory(){

          $data=[];
              
              if($this->request->getMethod() == "post"){
                  if($this->request->getVar('userid')){

                    $userid = $this->request->getVar('userid');

                    $requesthistory = $this->oemModel->multiSrch('fastagrequest','*','requestedbytype',1,'requestedbyid',$userid);

                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => $requesthistory
                        ]
                      ];
                      return $this->respond($response);


                  }else{

                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "invalid entry"
                        ]
                      ];
                      return $this->respond($response);

                  } 
              }
            
       }
  
  
  
  
  	   public function requestfastag(){

          $data=[];
              
              if($this->request->getMethod() == "post"){
                if($this->request->getVar('userid')){

                  $userid = $this->request->getVar('userid');
                  $nooftag = $this->request->getVar('nooftag');
                  $classoftag = $this->request->getVar('classoftag');

                  $dtm = date("Y-m-d h:i:s");
                  
                    $salsagentdata = $this->salesmanagerModel->viewspecific('salesagent','*','salesagentId',$userid);


                    $data = ["numberoffastag"=>$nooftag,"classoftag"=>$classoftag,"requestedbyid"=>$userid,"status"=>0,"datetime"=>$dtm,"requestedbytype"=>1,"requestedtoid"=>$salsagentdata[0]["requestedById"]];

                    $loginData = $this->salesmanagerModel->loginDatainsert('fastagrequest',$data);

                    if($loginData){
                        $response = [
                          'status'   => 200,
                          'error'    => true,
                          'messages' => [
                            'responsecode'=>"00",
                            'status' => "request send"
                          ]
                        ];
                        return $this->respond($response);
                    }else{
                        $response = [
                          'status'   => 400,
                          'error'    => false,
                          'messages' => [
                            'responsecode'=>"01",
                            'status' => "unable to send"
                          ]
                        ];
                        return $this->respond($response);
                    }                    


                }else{

                    $response = [
                      'status'   => 400,
                      'error'    => false,
                      'messages' => [
                        'responsecode'=>"01",
                        'status' => "invalid entry"
                      ]
                    ];
                    return $this->respond($response);

                } 
              }
            
       }
  
  
  		/* -------------------------------------TAG ACTIVATION API-------------------------------------- */
  
  	  public function getbarcode(){

          $data=[];
              
              $userid = $this->request->getVar('userid');
              
              $clssoffastag = $this->oemModel->showfastag($userid,3);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $clssoffastag
                  ]
                ];
                return $this->respond($response);               
            
       }
  
      public function getproduct(){

          $data=[];
              
              $userid = $this->request->getVar('userid');
              
              $clssoffastag = $this->salesagentModel->viewprdata($userid);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $clssoffastag
                  ]
                ];
                return $this->respond($response);               
            
       }
  
  
  	  public function addcontactnumber(){

          $data=[];
              
              if($this->request->getMethod() == "post"){
                  if($this->request->getVar('contactnumber')){

                    $contactnumber = $this->request->getVar('contactnumber');
                    $userid = $this->request->getVar('userid');
                    $dtm = date("Y-m-d h:i:s");

                    $insertdata = ["productid"=>'',"classofBarcode"=>'',"vehicleType"=>'',"customername"=>'',"mobileNumber"=>$contactnumber,"pancarddetails"=>'',"drivingLicence"=>'',"rcbook"=>'',"vehicleNumbertype"=>'',"vehiclechasisnumber"=>'',"salesagentId"=>$userid,"salesagenttype"=>0,"orgreqid"=>'',"crnnumber"=>'',"tokennumber"=>'',"customerid"=>'',"dateofbirth"=>'',"agenttype"=>'',"barcodeid"=>'',"transactionstatus"=>1,"transactionid"=>'',"datetime"=>$dtm];
                
                $loginData = $this->salesagentModel->loginDatainsert('tagactivationinitial',$insertdata);
                $lastinsertid = $this->loginModel->db->insertID();
                    
                    if($loginData){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => $lastinsertid
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }                      


                  }
                
                
                
                 if($this->request->getVar('orgreqid')){

                    $orgreqid = $this->request->getVar('orgreqid');
                    $tagactivationid = $this->request->getVar('tagactivationid');
                    $dtm = date("Y-m-d h:i:s");

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                        'orgreqid'=>$orgreqid,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                   
                   	if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }                                          
                      
                  }
                
                
                  if($this->request->getVar('pancardnumber')){
                    
                    $tagactivationid = $this->request->getVar('tagactivationid');
                    $pancardnumber = $this->request->getVar('pancardnumber');
                    $firstname = $this->request->getVar('firstname');
                    $lastname = $this->request->getVar('lastname');
                    $dob = $this->request->getVar('dob');
                    $addressprofftype = $this->request->getVar('addressprofftype');
                    $addressproofnumber = $this->request->getVar('addressproofnumber');
                    $name = $firstname.' '.$lastname;
                    
                    $dtm = date("Y-m-d h:i:s");

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                        'customername'=>$name,
                        'pancarddetails' => $pancardnumber,
                        'dateofbirth' =>$dob,
                        'drivingLicence'=>$addressproofnumber,
                        'vehicleNumbertype'=>$addressprofftype,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                                          
                      if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                  }
                
                
                  if($this->request->getVar('tokennumber')){
                    
                    $tokennumber = $this->request->getVar('tokennumber');
                    $crnnumber = $this->request->getVar('crnnumber');
                    $tagactivationid = $this->request->getVar('tagactivationid');

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                      'tokennumber'=>$tokennumber,
                      'crnnumber'=>$crnnumber,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                                          
                      if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                  }
                
                
                  if($this->request->getVar('agenttype')){
                    
                    $agenttype = $this->request->getVar('agenttype');
                    $customerid = $this->request->getVar('customerid');
                    $tagactivationid = $this->request->getVar('tagactivationid');

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                      'agenttype'=>$agenttype,
                      'customerid'=>$customerid,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                                          
                      if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                  }
                
                
                
                  if($this->request->getVar('vehicletype')){
                      
                     $vehicletype = $this->request->getVar('vehicletype');
                     $drivinglicence = $this->request->getFile('rcbook');
                     $vehiclenumbertype = $this->request->getVar('vehiclenumbertype');
                     $vehiclechasisnumber = $this->request->getVar('vehiclechasisnumber');
                     $barcodeid = $this->request->getVar('barcodeid');
                     $transactionid = $this->request->getVar('transactionid');
                     $classofBarcode = $this->request->getVar('classofBarcode');
                     $productid = $this->request->getVar('productid');
                     $tagactivationid = $this->request->getVar('tagactivationid');
                    
                   // if($drivinglicence->isValid() && !$drivinglicence->hasMoved()){
                   //   $newdrivinglicence = $drivinglicence->getRandomName();
                   //   if($drivinglicence->move(FCPATH.'public/drivinglicence',$newdrivinglicence)){     
                   //     $drivinglicencedat = base_url().'/public/drivinglicence/'.$newdrivinglicence;                           
                   //   }
                   // }
					
                   // $rcbook = 'data:image/png;base64,'.base64_encode(file_get_contents($drivinglicencedat));
                    
                   // return $this->respond($response);
                   // exit;
                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [
                      'vehicleType'=>$vehicletype,
                      'rcbook'=>$drivinglicence,
                      'vehicleNumbertype'=>$vehiclenumbertype,
                      'vehiclechasisnumber'=>$vehiclechasisnumber,
                      'barcodeid'=>$barcodeid,
                      'transactionid' =>$transactionid,
                      'classofBarcode' =>$classofBarcode,
                      'productid' => $productid,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                    
                    if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                    
                  }
                
                
                  if($this->request->getVar('txnstatus')){
                    
                    $transactionstatus = $this->request->getVar('transactionstatus');
                    $txnstatus = $this->request->getVar('txnstatus');
                    $responsecode = $this->request->getVar('responsecode');
                    $responsestatus = $this->request->getVar('responsestatus');
                    $tagactivationid = $this->request->getVar('tagactivationid');

                    $table ='tagactivationinitial';
                    $upclnm ='initialId';
                    $updtdata = [                          
                      'transactionstatus'=>$transactionstatus,
                      'txnstatus'=>"$txnstatus",
                      "responsecode"=>$responsecode,
                      "responsestatus"=>$responsestatus,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid); 
                    
                    if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                    
                  }
                
                  
                  
                  if($this->request->getVar('fastagprice')){
                    
                    $barcode = $this->request->getVar('barcodeid');
                    $tagactivationid = $this->request->getVar('tagactivationid');
                    $userid = $this->request->getVar('userid');
                    $fastagprice = $this->request->getVar('fastagprice');
                    $orderId = $this->request->getVar('transactionid');
                    
                    $dtm = date("Y-m-d h:i:s");

                    $salesagentdetails = $this->oemModel->viewspecific('fasttag','*','barcode',$barcode);
                    $fatsagid = $salesagentdetails[0]['fasttagid'];

                    $table1 ='fastaginventory';
                    $upclnm1 ='fasttagid';
                    $updtdata1 = [                          
                      'status'=>1,
                    ];
                    $updtid1 = $fatsagid;
                    $upt=$this->salesagentModel->entry_update($table1,$upclnm1,$updtdata1,$updtid1);

                    $tagupdateds = ["fasttagid"=>$fatsagid,"allotedto"=>$tagactivationid,"allotedtotype"=>4,"allotedby"=>$userid,"allotedbytype"=>3,"status"=>0,"datetime"=>$dtm];                
                    $loginData = $this->loginModel->loginDatainsert('fastaginventory',$tagupdateds);

                    $insertdata = ["payerid" => $userid, "payertype" =>1, "amount" => $fastagprice, "transactionid" => $orderId, "transactiontype" => 2, "transactionstatus" => 2,"txn" => "SUCCESS","datetime"=>$dtm];               
                    $loginData = $this->loginModel->loginDatainsert('wallet',$insertdata);
                    
                    if($loginData){
                    $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                    }
                    
                  }            
                
                
                  
                
              }
            
       }
  
  
  
  	  public function existinguser(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('customerid')){
                        $custid = $this->request->getVar('customerid');
                        $custnum = $this->request->getVar('customernumber');
                        $custnme = $this->request->getVar('customername');
                        $barcode = $this->request->getVar('barcodeid');
                        $prd = $this->request->getVar('productid');
                        $vehicleidtype = $this->request->getVar('vehiclenumbertype');
                        $vehiclenumber = strtoupper($this->request->getVar('vehiclenumber'));
                        $barcodetyp = $this->request->getVar('classofbarcode');
                        $typee = $this->request->getVar('vehicletype');
                        $fstagclss = $this->request->getVar('classoffastag');
                        $dtm = date('Y-m-d h:i:s');
                        $agntp = $this->request->getVar('agenttype');
                        $ordrid = $this->request->getVar('transactionid');
                        $salesagentid = $this->request->getVar('userid');
                        $salesagentType = 0;
                        $drivinglicencedat ="";

                      $databankdetails = ["productid"=>$prd,"classofBarcode" =>$barcodetyp,"vehicleType" =>$typee,"customername" =>$custnme,"mobileNumber" =>$custnum,"rcbook" =>$drivinglicencedat,"vehicleNumbertype" =>$vehicleidtype,"vehiclechasisnumber" =>$vehiclenumber,"salesagentId" =>$salesagentid,"customerid" =>$custid,"agenttype" =>$agntp,"barcodeid" =>$barcode,"transactionstatus" =>1,"transactionid" =>$ordrid,"datetime" =>$dtm,"salesagentType" =>$salesagentType];
                      $loginData = $this->salesagentModel->loginDatainsert('tagactivationExistingUser',$databankdetails);                
                      $lastinsertid = $this->salesagentModel->db->insertID();  
                      
                      if($loginData){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => $lastinsertid
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    } 


                 }
               }

        }
  
  
  
  		public function updatetransaction(){
          
                if($this->request->getMethod() == "post"){
                   if($this->request->getVar('txnstatus')){
                    
                    $transactionstatus = $this->request->getVar('transactionstatus');
                    $txnstatus = $this->request->getVar('txnstatus');
                    $responsecode = $this->request->getVar('responsecode');
                    $responsestatus = $this->request->getVar('responsestatus');
                    $tagactivationid = $this->request->getVar('tagactivationid');

                    $table ='tagactivationExistingUser';
                    $upclnm ='existinguserid';
                    $updtdata = [                          
                      'transactionstatus'=>$transactionstatus,
                      'txnstatus'=>"$txnstatus",
                      "statusTag"=>$responsecode,
                      "resultTag"=>$responsestatus,
                    ];
                    $updtid = $tagactivationid;
                    $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid); 
                    
                    if($upt){
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => "data updated"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }else{
                      
                      $response = [
                        'status'   => 400,
                        'error'    => false,
                        'messages' => [
                          'responsecode'=>"01",
                          'status' => "try again later"
                        ]
                      ];
                      return $this->respond($response);
                      
                    }
                    
                  }
             }
        }
  
  
  		public function getappversion(){

          $data=[];
              
              $appversion = $this->salesmanagerModel->viewspecific('settings','*','settingsid ',1);

                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $appversion
                  ]
                ];
                return $this->respond($response);               
            
       }
  
  
  	   public function setappversion(){

          $data=[];
         if($this->request->getMethod() == "post"){
              $appversion = $this->request->getVar('appversion');
              $settingsid = $this->request->getVar('settingsid');
         
         	   $table ='settings';
               $upclnm ='settingsid';
               $updtdata = [
                 'appversion'=>$appversion,
               ];
               $updtid = $settingsid;
               $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);

                if($upt){
                      
                  $response = [
                    'status'   => 200,
                    'error'    => true,
                    'messages' => [
                      'responsecode'=>"00",
                      'status' => "data updated"
                    ]
                  ];
                  return $this->respond($response);

                }else{

                  $response = [
                    'status'   => 400,
                    'error'    => false,
                    'messages' => [
                      'responsecode'=>"01",
                      'status' => "try again later"
                    ]
                  ];
                  return $this->respond($response);

                }
         }
            
       }
  
  
  		public function getindvWalletTransactionHistory(){
          
          $data=[];
           if($this->request->getMethod() == "post"){

                $idd = $this->request->getVar('transactionid');


                $walletdetails = $this->walletModel->getSalesagentindividual($idd);
                $transactiondetailsini = $this->salesagentModel->viewspecific('tagactivationinitial','*','transactionid',$idd);
                $transactiondetailsext = $this->salesagentModel->viewspecific('tagactivationExistingUser','*','transactionid',$idd);

                  $response = [
                    'status'   => 200,
                    'error'    => true,
                    'messages' => [
                      'walletdetails' => $walletdetails,
                      'transaction1' => $transactiondetailsini,
                      'transaction2' => $transactiondetailsext
                    ]
                  ];
                  return $this->respond($response); 
           } 
       }
  
  
  
  	  public function dashboarddata(){

          $data=[];

          if($this->request->getMethod() == "post"){
            if($this->request->getVar('userid')){
              
              $userid = $this->request->getVar('userid');
           /*--------------------------------------- TODAYS ACTIVATION----------------------------------*/
              
              $startdate = date("Y-m-d");
              $enddate = date( 'Y-m-d', strtotime( $startdate . ' +1 day' ) );

              $rt = $startdate.' 00:00:00';
              $rte = $enddate.' 00:00:00';
              
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $userid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginDataext = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              
              $array1 = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $userid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData1new = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array1);         
              
              
              $cnttoday = sizeof($loginDataext) + sizeof($loginData1new);
              $finalreporttoday = array_merge($loginDataext,$loginData1new);
		  /*--------------------------------------- END TODAYS ACTIVATION----------------------------------*/
          /*--------------------------------------- YESTERDAYS ACTIVATION----------------------------------*/
              
              $enddate = date("Y-m-d");
              $startdate = date( 'Y-m-d', strtotime( $enddate . ' -1 day' ) );

              $rt = $startdate.' 00:00:00';
              $rte = $enddate.' 00:00:00';
              
              $array = array('transactionstatus' => 0, 'statusTag' => 230201, 'salesagentId' => $userid , 'salesagentType' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData = $this->salesagentModel->viewspecificoth('tagactivationExistingUser','*',$array);
              
              $array1 = array('transactionstatus' => 0, 'responsecode' => 230201, 'salesagentId' => $userid , 'salesagenttype' =>0,'datetime >=' => $rt,'datetime <=' => $rte);
              $loginData1 = $this->salesagentModel->viewspecificoth('tagactivationinitial','*',$array1);
              
              $cntyesterday = sizeof($loginData) + sizeof($loginData1);
              $finalreportyesterday = array_merge($loginData,$loginData1);
              
          /*--------------------------------------- END YESTERDAYS ACTIVATION----------------------------------*/
          /*--------------------------------------- GETTING BANNER DATA ---------------------------------------*/
              $array = array('status' => 0);
              $banner = $this->salesagentModel->viewspecificoth('salesagentBanner','*',$array);
              
         /*--------------------------------------- END GETTING BANNER DATA ---------------------------------------*/   
              
                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'todaycount' => $cnttoday,
                    'todaydataexisting' => $loginDataext,
                    'todaydatanew' => $loginData1new,
                    'yesterdaycount' => $cntyesterday,
                    'yesterdaydataexisting' => $loginData,
                    'yesterdaydatanew' => $loginData1,
                    'homebanner' => $banner
                  ]
                ];
                return $this->respond($response);

               
            }else{
              
                $response = [
                  'status'   => 400,
                  'error'    => false,
                  'messages' => [
                    'responsecode'=>"01",
                    'status' => "invalid entry"
                  ]
                ];
                return $this->respond($response);
              
            }
          }
        }
        
        
        
        public function VIIformactivation(){

          $data=[];

          if($this->request->getMethod() == "post"){
              if($this->request->getVar('firstname')){
                
                  $dtm = date("Y-m-d h:i:s");
                  
                $fnamee = $this->request->getVar('firstname');
                $lnamee = $this->request->getVar('lastname');
                $mnum = $this->request->getVar('mobilenumber');
                $vhclnum = $this->request->getVar('vehiclenumber');
                $newVehicleRC = $this->request->getVar('vehiclerc');
                $barcode = $this->request->getVar('barcode');
                $prd = $this->request->getVar('productid');
                $vehicledatatype = $this->request->getVar('vehicledatatype');
                $vehclcls = $this->request->getVar('vehicleclass');
                $vehicletype = $this->request->getVar('vehicletype');
                $salesagentid = $this->request->getVar('userid');
                              
                $tagupdateds = ["firstname"=>$fnamee,"lastname"=>$lnamee,"mobilenumbr"=>$mnum,"vehcllnumbr"=>$vhclnum,"vehcllrc"=>$newVehicleRC,"salesagentid"=>$salesagentid,"reqstbytype"=>0,"allotedbarcode"=>$barcode,"status"=>0,"datetime"=>$dtm,"updtdatetime"=>$dtm,"product"=>$prd,"vehicledatatype"=>$vehicledatatype,"vehicleclass"=>$vehclcls,"vehicletype"=>$vehicletype];                
                $loginData = $this->loginModel->loginDatainsert('requestRegisterednumber',$tagupdateds);
                
                  if($loginData){
                    
                      $response = [
                      'status'   => 200,
                      'error'    => true,
                      'messages' => [
                        'responsecode'=>"00",
                        'status' => 'request send'
                      ]
                    ];
                    return $this->respond($response);
                    
                  }else{
                    
                    $response = [
                      'status'   => 400,
                      'error'    => false,
                      'messages' => [
                        'responsecode'=>"01",
                        'status' => 'request send failed'
                      ]
                    ];
                    return $this->respond($response);
                    
                  }  
              }
          }
       }
       
       
  /////////////////*******************************   ICICI BANK CONTROLLER *************************************//////////////////////////////////////////////////
  
       public function iciciidrequest(){

          $userData=[];

          if($this->request->getMethod() == "post"){
              
                $salesagentid = $this->request->getVar('userid');
                $requestid = $this->request->getVar('requestid');
                
                $prfimg = $this->request->getFile('selfie');
                $profileImage=$_FILES['selfie']['name'];
                if($profileImage){
                    /*$validated = $this->validate([
                        'profilr' => [
                            'uploaded[selfie]',
                            'mime_in[selfie,image/jpg,image/jpeg,image/gif,image/png,image/PNG,image/JPG,image/JPEG,image/heic]',
                            'max_size[selfie,3072]',
                        ],
                    ]);*/
                    $filetype = pathinfo($profileImage, PATHINFO_EXTENSION);
              
                   // if ($validated) {                    
                        $newprofilr = $prfimg->getRandomName();
                        if($prfimg->move(FCPATH.'public/selfie/',$newprofilr)){     
                            $profileImage=base_url().'/public/selfie/'.$newprofilr; 
                            
                              $table ='icicirequestid';
                              $upclnm ='requestid';
                              $updtdata = [
                                'otp'=>'',
                                'selfie'=>$profileImage,
                                'status' =>1,
                              ];
                              $updtid = $requestid;
                              $upt=$this->salesagentModel->entry_update($table,$upclnm,$updtdata,$updtid);
                              $responsedata="done";
                              
                        }else{
                            $responsedata="sorry";
                        }
                    /*}else{
                        $responsedata="Invalid File Type";
                    } */              
                }
                
                $response = [
                  'status'   => 200,
                  'error'    => true,
                  'messages' => [
                    'responsecode'=>"00",
                    'status' => $responsedata
                  ]
                ];
                return $this->respond($response);
          }
       }
       
       
       public function sendotpiciciidrequest(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $salesagentid = $this->request->getVar('userid');
                       
                       $otp = rand(111111,999999);
                       
                       $icicirequestid = $this->salesagentModel->viewspecific('icicirequestid','*','salesagentid',$salesagentid);
                       $salesagentdtt = $this->salesagentModel->viewspecific('salesagent','*','salesagentId',$salesagentid);
                       
                          
            				$insertdata = ["salesagentid" =>$salesagentid, "selfie" =>"", "otp" =>$otp, "iciciagentid" =>"", "status" =>3, "datetime" =>date("Y-m-d h:i:s")];
                            $loginData = $this->salesagentModel->loginDatainsert('icicirequestid',$insertdata);
                            $lastinsertid = $this->salesagentModel->db->insertID();
                            
                            $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
                            $userMobile=$salesagentdtt[0]['ContactPrimary'];
                            $send=sendOTP($userMobile,$userSMS);
                            
                            $data["status"]=1;
                            $data["sms"]="send";
                            $data["requestid"]=$lastinsertid;
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => $data
                        ]
                      ];
                      return $this->respond($response);

                 }
               }

        }
        
        
        
        public function verifyotpiciciidrequest(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $salesagentid = $this->request->getVar('userid');
                       $requestid = $this->request->getVar('requestid');
                       $otp = $this->request->getVar('otp');
                       
                       $array = array('salesagentid' => $salesagentid, 'requestid' => $requestid);
                       $icicirequestid = $this->salesagentModel->viewspecificoth('icicirequestid','*',$array);
           
                       $ottp = $icicirequestid[0]['otp'];
                       
                       if($otp == $ottp){
                           
                            $table ='icicirequestid';
                            $upclnm ='requestid';
                            $updtdata = [                          
                              'otp'=>'',
                            ];
                            $updtid = $requestid;
                            $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                           $data["response"] ="verified";
                       }else{
                           $data["response"] ="invalidotp";
                       }
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status' => $data
                        ]
                      ];
                      return $this->respond($response);

                 }
               }

        }
        
        
        public function getstatus(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $salesagentid = $this->request->getVar('userid');
                       
                       $icicirequestdetails = $this->salesagentModel->viewspecific('icicirequestid','*','salesagentid',$salesagentid);
                       
                       
                       if(sizeof($icicirequestdetails) == 0){
                           $otp = rand(111111,999999);
                       
                            $icicirequestid = $this->salesagentModel->viewspecific('icicirequestid','*','salesagentid',$salesagentid);
                            $salesagentdtt = $this->salesagentModel->viewspecific('salesagent','*','salesagentId',$salesagentid);
                       
                          
            				$insertdata = ["salesagentid" =>$salesagentid, "selfie" =>"", "otp" =>$otp, "iciciagentid" =>"", "status" =>3, "datetime" =>date("Y-m-d h:i:s")];
                            $loginData = $this->salesagentModel->loginDatainsert('icicirequestid',$insertdata);
                            $lastinsertid = $this->salesagentModel->db->insertID();
                            
                            $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
                            $userMobile=$salesagentdtt[0]['ContactPrimary'];
                            $send=sendOTP($userMobile,$userSMS);
                            
                            $statuss=3;
                            $data["sms"]="send";
                            $data["requestid"]=$lastinsertid;
                            
                       }else if($icicirequestdetails[0]["status"] == 3){
                           
                            $icicirequestid = $this->salesagentModel->viewspecific('icicirequestid','*','salesagentid',$salesagentid);
                            $salesagentdtt = $this->salesagentModel->viewspecific('salesagent','*','salesagentId',$salesagentid);
                           
                            $otp = rand(111111,999999);
                       
                            $table ='icicirequestid';
                            $upclnm ='requestid';
                            $updtdata = [                          
                              'otp'=>$otp,
                            ];
                            $updtid = $icicirequestdetails[0]["requestid"];
                            $upt=$this->salesagentModel->entry_update1($table,$upclnm,$updtdata,$updtid);
                            
                            $userSMS="The otp for Login to your Account is ".$otp." . OTP is valid for 10 mins. pls do not share with any one. Thanks. HITCH PAYMENTS Team KOTTAKOTA";
                            $userMobile=$salesagentdtt[0]['ContactPrimary'];
                            $send=sendOTP($userMobile,$userSMS);
                            
                            $statuss=$icicirequestdetails[0]["status"];
                            $data["sms"]="send";
                            $data["requestid"]=$icicirequestdetails[0]["requestid"];
                       
                       }else{
                           $statuss=$icicirequestdetails[0]["status"];
                           $data['icicirequestdetails'] = $icicirequestdetails;
                       }
                      
                      $response = [
                        'status'   => 200,
                        'error'    => true,
                        'messages' => [
                          'responsecode'=>"00",
                          'status'=>$statuss,
                          'details' => $data
                        ]
                      ];
                      return $this->respond($response);

                 }
               }

        }
        
        
        
        public function paymentidrequest(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $userid = $this->request->getVar('userid');
                       $amount = $this->request->getVar('amount');
                       $transactionid = $this->request->getVar('transactionid');
                       $paymentgateway = $this->request->getVar('paymentgateway');
                       $transactionstatus = $this->request->getVar('transactionstatus');
                       
                       
                       $refrenceid = $this->request->getVar('refrenceid');
                       $paymentmode = $this->request->getVar('paymentmode');
                       $orderid = $this->request->getVar('orderid');
                       $signature = $this->request->getVar('signature');
                       
                          
            				$insertdata = ["salesagentid" =>$userid, "amount" =>$amount, "transactionid" =>$transactionid, "paymentgatewayname" =>$paymentgateway, "amountinicici" =>'', "amounticiciafteraddition" =>'', "remark" =>'', "txn" =>$transactionstatus, "approveddatetime" =>date("Y-m-d h:i:s"), "approvedbyid" =>'', "status" =>3, "datetime" =>date("Y-m-d h:i:s")];
                            $loginData = $this->salesagentModel->loginDatainsert('iciciwallet',$insertdata);
                            $lastinsertid = $this->salesagentModel->db->insertID();
                            $data["walletinsertid"] = $lastinsertid;
                            $data["status"] = "inserteddata";
                             
                            $successpayment = ["refrenceid" =>$refrenceid, "paymentmode" =>$paymentmode, "paymentamount" =>$amount, "orderid" =>$orderid, "signature" =>$signature, "transactionstatus" =>$transactionstatus, "datetime" =>date("Y-m-d h:i:s")];
                            $loginData = $this->salesagentModel->loginDatainsert('paymentstatus',$successpayment);
                            
                            if($loginData){
                                
                                $response = [
                                    'status'   => 200,
                                    'error'    => true,
                                    'messages' => [
                                      'responsecode'=>"00",
                                      'status' => $data
                                    ]
                                  ];
                                return $this->respond($response);
                                
                            }else{
                                
                                $response = [
                                  'status'   => 400,
                                  'error'    => false,
                                  'messages' => [
                                    'responsecode'=>"01",
                                    'status' => 'request send failed'
                                  ]
                                ];
                                return $this->respond($response);
                                
                            }
                      
                      

                 }
               }

        }
        
        
        
        public function getindividualwalletdata(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $salesagentid = $this->request->getVar('userid');
                       $walletinsertid = $this->request->getVar('walletinsertid');
                       $transactionid = $this->request->getVar('transactionid');
                       
                       $array = array('iciciwalletid' => $walletinsertid, 'transactionid' => $transactionid, 'salesagentid' => $salesagentid);
                       $icicirequestid = $this->salesagentModel->viewspecificoth('iciciwallet','*',$array);
           
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $icicirequestid
                            ]
                          ];
                          return $this->respond($response);

                 }
               }

        }
        
        
        public function getwalletdata(){     

                  if($this->request->getMethod() == "post"){

                    if($this->request->getVar('userid')){
                        
                       $salesagentid = $this->request->getVar('userid');
                       
                       $array = array('salesagentid' => $salesagentid);
                       $icicirequestid = $this->salesagentModel->viewspecificoth('iciciwallet','*',$array);
           
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $icicirequestid
                            ]
                          ];
                          return $this->respond($response);

                 }
               }

        }
        
        
        public function productclassofbarcode(){     

                  if($this->request->getMethod() == "post"){

                       $salesagentid = $this->request->getVar('userid');
                       
                       $array = array('status' => 0);
                       $procudt = $this->salesagentModel->viewspecificoth('product','*',$array);
                       
                       /*$array1 = array('status' => 0, 'classofbarcode' => $procudt[0]['classofvehicle']);
                       $classofbarcode = $this->salesagentModel->viewspecificoth('classofbarcode','*',$array1);*/
                       
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $procudt,
                              //'classofbarcode' => $classofbarcode
                            ]
                          ];
                          return $this->respond($response);

                 
               }

        }
        
        
        
        public function getprdctdetls(){     

                  if($this->request->getMethod() == "post"){

                       $prdid = $this->request->getVar('productid');
                       
                       $array = array('status' => 0,'productid'=>$prdid);
                       $procudt = $this->salesagentModel->viewspecificoth('product','*',$array);
                       
                       $array1 = array('status' => 0, 'classofbarcode' => $procudt[0]['classofvehicle']);
                       $classofbarcode = $this->salesagentModel->viewspecificoth('classofbarcode','*',$array1);
                       
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $procudt,
                              'classofbarcode' => $classofbarcode
                            ]
                          ];
                          return $this->respond($response);
               }

        }
        
        
        public function getpincode(){     

                  if($this->request->getMethod() == "post"){

                       $array = array('status' => 0);
                       $procudt = $this->salesagentModel->viewspecificoth('pincode','*',$array);
                       
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $procudt,
                            ]
                          ];
                          return $this->respond($response);
               }

        }
        
        
        public function nametoshowdetails(){     

                  if($this->request->getMethod() == "post"){

                       $fromname = $this->request->getVar('toshowinapplication');
                       
                       $array1 = array('status' => 0, 'toshowinapplication' => $fromname);
                       $classofbarcode = $this->salesagentModel->viewspecificoth('classofbarcode','*',$array1);
                       
                       for($i=0; $i < sizeof($classofbarcode); $i++){
                           $data[$i] = $classofbarcode[$i]["typeofvehicle"];
                       }
                       
                       $dtt['vehicletype'] = $data;
                       
                          $response = [
                            'status'   => 200,
                            'error'    => true,
                            'messages' => [
                              'responsecode'=>"00",
                              'status' => $dtt
                            ]
                          ];
                          return $this->respond($response);

                 
               }

        }
  
}

?>