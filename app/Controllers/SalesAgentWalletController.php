<?php

namespace App\Controllers;
use \App\Models\SalesAgentWalletModel;
use \App\Models\SalesAgentModel;

class SalesAgentWalletController extends BaseController
{
    public $walletModel;
    public $loginModel;


    public function __construct(){
        helper("form");
        helper('text');
        helper('fastag');      
        helper('payment');
        $this->loginModel = new SalesAgentModel();
        $this->walletModel = new SalesAgentWalletModel();
        $this->session = session();
        
    }
  
  
    public function wallet(){
         if ((!isset($_SESSION['salesagentId']))) {
           return redirect()->to(base_url('salesagentLogin'));            
         }
      
        $data= [];
       
        $dtm = date('Y-m-d h:i:s');

        if($this->request->getMethod() == "post"){
          
            if($this->request->getVar('amount')){
              
              $salesagentdetails = $this->loginModel->viewspecific('salesagent','*','salesagentId',$_SESSION['salesagentId']);            
              
              $orderId = 'HP-'.time();
              $orderAmount = $this->request->getVar('amount');
              $purchasenote = "Adding Money To Wallet";
              $custname=$salesagentdetails[0]['Fname'].' '.$salesagentdetails[0]['Lname'];
              $mobnum=$salesagentdetails[0]['ContactPrimary'];
              $salesmailid=$salesagentdetails[0]['salesagentmailid'];
              $returnurl=base_url().'/salesagent/paymentnotation';
              $notifyurl=base_url().'/salesagent/paymentnotation';
              
              $walletdata = ["payerid"=>$_SESSION['salesagentId'],"payertype"=>1,"amount"=>$this->request->getVar('amount'),"transactionid"=>$orderId,"transactiontype"=>1,"transactionstatus"=>1,"datetime"=>$dtm,"txn"=>''];                
              $loginData = $this->loginModel->loginDatainsert('wallet',$walletdata);
              
              $postdata = array("appId"=>'19350339ee25ac9bdf7c97d3f6305391', "orderId"=>$orderId, "orderAmount"=>$orderAmount, "orderCurrency"=>'INR', "orderNote"=>$purchasenote, "customerName"=>$custname, "customerPhone"=>$mobnum, "customerEmail"=>$salesmailid, "returnUrl"=>$returnurl, "notifyUrl"=>$notifyurl);
                $signature = generateSignature($postdata);

              echo $payment = makePayment($orderId,$orderAmount,$purchasenote,$salesmailid,$custname,$mobnum,$returnurl,$signature,$notifyurl); 
               
               exit;
              
            }
        }
              
	    
		$data["wallatdetails"] = $this->walletModel->getWalletbalance($_SESSION['salesagentId'],'1');
              
       return view('salesagent/wallet',$data);
    }  
  
  
  	public function paymentnotation(){

            $orderId = $this->request->getVar('orderId');       
        
        	$data =[];      
            $salesagentdetails = $this->walletModel->getSalesagentindividual($orderId);
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
        
        
            if($this->request->getVar('txStatus') == "SUCCESS"){               
                

              $table ='wallet';
              $upclnm ='transactionid';
              $updtdata = [
                'txn'=>$this->request->getVar('txStatus'),
                'transactionstatus'=>2,
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);              
              
              $this->session->setTempdata('Success','Tag Activated Successfully', 3);
              return redirect()->to(base_url('salesagent/wallet'));
              
            }else{
              
              $table ='wallet';
              $upclnm ='transactionid';
              $updtdata = [
                'txn'=>$this->request->getVar('txStatus'),
              ];
              $updtid = $orderId;
              $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
              
              $this->session->setTempdata('error','Payment Was Not Successfully', 3);
              return redirect()->to(base_url('salesagent/wallet'));
              
            }
    }
  
     public function viewwalletdata(){
       if ((!isset($_SESSION['logged_usrid']))) {
         return redirect()->to(base_url('adminLogin'));            
       }

       $data= [];
       $dtm=date("Y-m-d h:i:s");
       if($this->request->getMethod() == "post"){
          if($this->request->getVar('refundid')){
            
            $refundid = $this->request->getVar('refundid');
            $refundata = $this->loginModel->viewspecific('wallet','*','walletid',$refundid);
            
            $walletdata = ["payerid"=>$refundata[0]["payerid"],"payertype"=>$refundata[0]["payertype"],"amount"=>$refundata[0]["amount"],"transactionid"=>$refundata[0]["transactionid"],"transactiontype"=>$refundata[0]["transactiontype"],"transactionstatus"=>$refundata[0]["transactionstatus"],"datetime"=>$refundata[0]["datetime"],"txn"=>$refundata[0]["txn"],"updateddatetime"=>$dtm];                
            $loginData = $this->loginModel->loginDatainsert('refundhistory',$walletdata);
            
            $table ='wallet';
            $upclnm ='walletid';
            $updtdata = [
              'txn'=>$this->request->getVar('txStatus'),
              'transactiontype'=>1,
              'transactionstatus'=>2,
              'txn'=>'REFUND',
            ];
            $updtid = $refundid;
            $upt=$this->loginModel->entry_update($table,$upclnm,$updtdata,$updtid);
            
            $response='
            		   <div class="alert alert-success alert-dismissible fade show">
                            Refund Was Successfully
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                                ';
            
            
            echo $response;
            exit;
            
          } 
         
         
         if($this->request->getVar('addmoney')){
           
           $salesagentdetails = $this->loginModel->viewspecific('salesagent','*','status',0); 
           ?>
            <script>
               $(document).ready(function () {
                  $('select').selectize({
                      sortField: 'text'
                  });
              });
            </script>
           <?php
           $response='
                  <form id="addfundsform">
           			<div class="modal-header">
                      <h5 class="modal-title">Add Amount To Wallet</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group row">
                        <div class="col-md-12"><span id="errmsgmdl"></span></div>
                        <label class="col-sm-2 col-form-label">Transaction Id</label>
                          <div class="col-sm-10">
                              <input type="text" placeholder="Transaction Id" id="trnsid" name="trnsid" class="form-control mg-b-10" style="max-width:50%;">
                              <span id="errtrnsid" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sales Agent</label>
                          <div class="col-sm-5">
                              <select class="form-control mg-b-10" style="max-width:50%;" id="salesagentselect" name="salesagentselect" placeholder="Select Sales Agent">
                                 <option value="">Select Sales Agent</option>
                              ';
                                  for($i=0; $i < sizeof($salesagentdetails); $i++){
                                 $response.='<option value="'.$salesagentdetails[$i]['salesagentId'].'"> '.$salesagentdetails[$i]['Fname'].'  '.$salesagentdetails[$i]['Lname'].' ( '.$salesagentdetails[$i]['salesAgentRegdNum'].' ) </option>';   
                                  }
                  $response.='</select>
                              <span id="errsalesagentselect" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Amount</label>
                          <div class="col-sm-10">
                              <input type="number" placeholder="Amount" id="amnt" name="amnt" class="form-control mg-b-10" style="max-width:50%;">
                              <span id="erramnt" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary"  id="addfundsbttn">Add Funds</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                 </form>
      ';
           
           echo $response;
           exit;
         }
         
         
         if($this->request->getVar('deductMoney')){
           
           $salesagentdetails = $this->loginModel->viewspecific('salesagent','*','status',0); 
           ?>
            <script>
               $(document).ready(function () {
                  $('select').selectize({
                      sortField: 'text'
                  });
              });
            </script>
           <?php
           $response='
                  <form id="deductfundsform">
           			<div class="modal-header">
                      <h5 class="modal-title">Deduct Amount To Wallet</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group row">
                        <div class="col-md-12"><span id="errmsgmdl"></span></div>
                        <label class="col-sm-2 col-form-label">Transaction Id</label>
                          <div class="col-sm-10">
                              <input type="text" placeholder="Transaction Id" id="deducttrnsid" name="deducttrnsid" class="form-control mg-b-10" style="max-width:50%;">
                              <span id="errtrnsid" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sales Agent</label>
                          <div class="col-sm-5">
                              <select class="form-control mg-b-10" style="max-width:50%;" id="deductsalesagentselect" name="deductsalesagentselect" placeholder="Select Sales Agent">
                                 <option value="">Select Sales Agent</option>
                              ';
                                  for($i=0; $i < sizeof($salesagentdetails); $i++){
                                 $response.='<option value="'.$salesagentdetails[$i]['salesagentId'].'"> '.$salesagentdetails[$i]['Fname'].'  '.$salesagentdetails[$i]['Lname'].' ( '.$salesagentdetails[$i]['salesAgentRegdNum'].' ) </option>';   
                                  }
                  $response.='</select>
                              <span id="errsalesagentselect" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Amount</label>
                          <div class="col-sm-10">
                              <input type="number" placeholder="Amount" id="deductamnt" name="deductamnt" class="form-control mg-b-10" style="max-width:50%;">
                              <span id="erramnt" class="errmsg" style="text-align:left;"></span>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary"  id="deductfundsbttn">Deduct Funds</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                 </form>
      ';
           
           echo $response;
           exit;
         }
         
         if($this->request->getVar('salesagentselect')){
           
             $trnsid = $this->request->getVar('trnsid');
             $salesagentselect = $this->request->getVar('salesagentselect');
             $amnt = $this->request->getVar('amnt');
              
             $walletdata = ["payerid"=>$salesagentselect,"payertype"=>1,"amount"=>$amnt,"transactionid"=>$trnsid,"transactiontype"=>1,"transactionstatus"=>2,"datetime"=>$dtm,"txn"=>'SUCCESS'];                
             $loginData = $this->loginModel->loginDatainsert('wallet',$walletdata);
           
             $response='
            		   <div class="alert alert-success alert-dismissible fade show">
                            Money Added Successfully
                       </div>
                                ';
            
            
            echo $response;
            exit;	
           
         }
         
         
         if($this->request->getVar('deductsalesagentselect')){
           
             $trnsid = $this->request->getVar('deducttrnsid');
             $salesagentselect = $this->request->getVar('deductsalesagentselect');
             $amnt = $this->request->getVar('deductamnt');
              
             $walletdata = ["payerid"=>$salesagentselect,"payertype"=>1,"amount"=>$amnt,"transactionid"=>$trnsid,"transactiontype"=>2,"transactionstatus"=>2,"datetime"=>$dtm,"txn"=>'SUCCESS'];                
             $loginData = $this->loginModel->loginDatainsert('wallet',$walletdata);
           
             $response='
            		   <div class="alert alert-success alert-dismissible fade show">
                            Money Deducted Successfully
                       </div>
                                ';
            
            
            echo $response;
            exit;	
           
         }
         
         
       }		
       
      // $data["walletdata"] = $this->walletModel->walletsrch();
       
       //$paginateData = $this->walletModel->select('wallet.walletid,wallet.payerid,wallet.payertype,wallet.amount,wallet.transactionid,wallet.transactiontype,wallet.transactionstatus,tagactivationinitial.initialId,tagactivationinitial.transactionid,tagactivationinitial.responsecode,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.barcodeid')
          //->join('tagactivationinitial', 'wallet.transactionid = tagactivationinitial.transactionid')     
          //->where("wallet.transactiontype",2)
          //->where("wallet.transactionstatus",2)             
         // ->where("tagactivationinitial.salesagenttype",0)
          //->orderBy('tagactivationinitial.initialId ', 'desc')
          $paginateData = $this->walletModel->select('*')
          ->orderBy('walletid', 'desc')
          ->paginate(100);
          
        //  $this->loginModel->srchallnewusr()
      
         $data = [
           'walletdata' => $paginateData,
           'pager' => $this->walletModel->pager
         ];
       
       
       return view('admin/showwalletdata',$data);
     }
  
  
  
  	public function manageshowdata($idd){
       if ((!isset($_SESSION['logged_usrid']))) {
         return redirect()->to(base_url('adminLogin'));            
       }
    
    	$data=[];
      $data["walletdetails"] = $this->walletModel->getSalesagentindividual($idd);
      //$data["walletdetails"] = $this->loginModel->viewspecific('wallet','*','transactionid',$idd);
      $data["transactiondetailsini"] = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$idd);
      $data["transactiondetailsext"] = $this->loginModel->viewspecific('tagactivationExistingUser','*','transactionid',$idd);
      
          
      return view('admin/showdetailswallettrns',$data);
    
    }
  
  	public function manageshowdatawllt($idd){
       if ((!isset($_SESSION['salesagentId']))) {
         return redirect()->to(base_url('salesagentLogin'));            
       }
    
    	$data=[];
      $data["walletdetails"] = $this->walletModel->getSalesagentindividual($idd);
      //$data["walletdetails"] = $this->loginModel->viewspecific('wallet','*','transactionid',$idd);
      $data["transactiondetailsini"] = $this->loginModel->viewspecific('tagactivationinitial','*','transactionid',$idd);
      $data["transactiondetailsext"] = $this->loginModel->viewspecific('tagactivationExistingUser','*','transactionid',$idd);
      
          
      return view('salesagent/showdetailswallettrns',$data);
    
    }
  
}

?>