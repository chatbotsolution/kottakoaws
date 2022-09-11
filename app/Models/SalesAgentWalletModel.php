<?php


namespace App\Models;
use \CodeIgniter\Model;

class SalesAgentWalletModel extends Model{

    protected $table='wallet';

    public function loginDatainsert($table,$data){

        $builder = $this->db->table($table);
        $res = $builder->insert($data);
        if($this->db->affectedRows() == 1){
                return true;
        }else{
                return false;
        }

    }
  
    public function getSalesagentindividual($idd){
      $builder = $this->db->table('wallet');
      
      $builder->select('wallet.payerid,wallet.amount,wallet.transactionid,wallet.transactiontype,wallet.transactionstatus,wallet.datetime,salesagent.salesAgentRegdNum,salesagent.ProfileImage, salesagent.Fname ,salesagent.Lname,salesagent.salesagentId');
      $builder->join('salesagent', 'salesagent.salesagentId = wallet.payerid');
      $builder->where('transactionid',$idd);
      $query   = $builder->get();
      return $query->getResultArray();
    }
  
  	public function getWalletbalance($id,$typ){
      $builder = $this->db->table('wallet');
      $builder->select('*');
      $builder->where('payertype',$typ);
      $builder->where('payerid',$id);
      $builder->where('transactionstatus',2);
      $query   = $builder->get();
      return $query->getResultArray();
    }
  
  	//public function multiSrch($table,$viewdata,$whrclm,$whrval,$whrclm1,$whrval1,$whrclm2,$whrval2){
	public function walletsrch(){
        $builder = $this->db->table("wallet");
        $builder->select('wallet.walletid,wallet.payerid,wallet.payertype,wallet.amount,wallet.transactionid,wallet.transactiontype,wallet.transactionstatus,tagactivationinitial.initialId,tagactivationinitial.transactionid,tagactivationinitial.responsecode,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.barcodeid');
      
        $builder->join('tagactivationinitial', 'wallet.transactionid = tagactivationinitial.transactionid');
        $builder->where("wallet.transactiontype",2);
        $builder->where("wallet.transactionstatus",2);
        $builder->where("tagactivationinitial.salesagenttype",0);
       // $builder->where("tagactivationinitial.responsecode !=",230201);
       // $builder->where("tagactivationinitial.responsecode is not NULL",NULL);
        $builder->orderBy('tagactivationinitial.initialId ', 'desc');
      
      
        //$builder = $this->db->table($table);
        //$builder->select($viewdata);
        //$builder->where($whrclm,$whrval);
        //$builder->where($whrclm1,$whrval1);
        //$builder->where($whrclm2,$whrval2);
        //$builder->orderBy('initialId ', 'desc');
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  
  
  	public function iciciwalletbal($idd){
      $builder = $this->db->table('iciciwallet');
      
      $builder->select('iciciwallet.salesagentid, iciciwallet.amount, iciciwallet.transactionid, iciciwallet.paymentgatewayname, iciciwallet.amountinicici, iciciwallet.amounticiciafteraddition, iciciwallet.remark, iciciwallet.status, iciciwallet.datetime, iciciwallet.approveddatetime, iciciwallet.approvedbyid,salesagent.salesAgentRegdNum,salesagent.ProfileImage, salesagent.Fname ,salesagent.Lname,salesagent.salesagentId');
      $builder->join('salesagent', 'salesagent.salesagentId = iciciwallet.salesagentid');
      $builder->where('transactionid',$idd);
      $query   = $builder->get();
      return $query->getResultArray();
    }
}


?>