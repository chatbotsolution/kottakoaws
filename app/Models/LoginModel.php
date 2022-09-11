<?php


namespace App\Models;
use \CodeIgniter\Model;

class LoginModel extends Model{
  
    protected $table = 'tagactivationinitial';
  
    public function verifyUserid($data,$type){

        $builder = $this->db->table('admin');
        $builder->select('*');
        $builder->where('userid',$data);
        $builder->where('admin_type',$type);
        $result = $builder->get();

        if(count($result->getResultArray()) == 1){
                return $result->getRowArray();
        }else{
                return false;
        }

    }


    public function showUserdata($userid,$logged_inid,$logged_intype){

        $builder = $this->db->table('admin');
        $builder->select('name,email,contact_number,admin_type');
        $builder->where('userid',$userid);
        $builder->where('admin_type',$logged_intype);
        $builder->where('admin_id',$logged_inid);
        $result = $builder->get();

        if(count($result->getResultArray()) == 1){
                return $result->getRowArray();
        }else{
                return false;
        }

    }


    public function loginDatainsert($table,$data){

        $builder = $this->db->table($table);
        $res = $builder->insert($data);
        if($this->db->affectedRows() == 1){
                return true;
        }else{
                return false;
        }

    }

    public function lastLogin($usrid){

        $builder = $this->db->table('login_data');
        $builder->select('login_id,datetime_login');
        $builder->where('login_id',$usrid);
        $builder->where('user_type',0);
        $builder->orderBy('login_data_id ', 'desc');
        $builder->limit(1,1);
        $result = $builder->get();

        if(count($result->getResultArray()) == 1){
                return $result->getRowArray();
        }else{
                return false;
        }

    }

    public function entry_update($table,$updtId,$updtVal,$uu) {
            
        $builder = $this->db->table($table);
        $builder->where($uu,$updtId);
        $builder->update($updtVal);
        $result = $builder->get();
        if(count($result->getResultArray()) == 1){
                return $result;
        }else{
                return false;
        }
    }

    public function searchDuplicate($table,$data,$whr1,$whr2){

        $builder = $this->db->table($table);
        $builder->select($data);
        $builder->where($whr1,$whr2);
        $result = $builder->get();

        if(count($result->getResultArray()) == 1){
                return $result->getResultArray();
        }else{
                return false;
        }

    }

    public function searchh($table,$data,$whr1,$whr2){

        $builder = $this->db->table($table);
        $builder->select($data);
        $builder->where($whr1,$whr2);
        $result = $builder->get();
        return $result->getResultArray();

    }
    
    
    
    public function searchhotp($table){

        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where('otp !=','');
        $builder->where('otp !=',0);
        $result = $builder->get();
        return $result->getResultArray();

    }
  
  
  	public function walltsrch(){

        $builder = $this->db->table('wallet');
        $builder->select('wallet.walletid,wallet.payerid,wallet.payertype,wallet.amount,wallet.transactionid,wallet.transactionstatus,wallet.datetime,salesagent.salesAgentRegdNum,salesagent.Fname,salesagent.Lname');
        $builder->join('salesagent','salesagent.salesagentId  = wallet.payerid');
        $builder->where('payertype',1);
        $builder->where('transactionstatus',1);
        $builder->where('transactiontype',1);
        $result = $builder->get();
        return $result->getResultArray();

    }
  
    public function srchallnewusr(){

          $builder = $this->db->table('tagactivationinitial');
         // $builder->select('*');
          $builder->select('tagactivationinitial.responsestatus,tagactivationinitial.responsecode,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.orgreqid,tagactivationinitial.customerid,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,tagactivationinitial.responsestatus,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname,salesmanager.Fname as smfrst,salesmanager.Lname as smlst,teamlead.Fname as tlfrst,teamlead.Lname as tllst');
          $builder->join('salesagent', 'salesagent.salesagentId = tagactivationinitial.salesagentId');
      
          $builder->join('teamlead', 'teamlead.teamleadId = salesagent.requestedById');
          $builder->join('salesmanager', 'salesmanager.salesManagerId = teamlead.requestedById');
      
          $builder->where('tagactivationinitial.salesagenttype',0);
          $builder->orderBy('initialId DESC');
          
          $query   = $builder->get();
          return $query->getResultArray();

      }
  
  	public function srchallexistingusr(){

          $builder = $this->db->table('tagactivationExistingUser');       
          $builder->select('tagactivationExistingUser.classofBarcode,tagactivationExistingUser.vehicleType,tagactivationExistingUser.customername,tagactivationExistingUser.mobileNumber,tagactivationExistingUser.vehicleNumbertype,tagactivationExistingUser.vehiclechasisnumber,tagactivationExistingUser.salesagentId,tagactivationExistingUser.barcodeid,tagactivationExistingUser.transactionstatus,tagactivationExistingUser.transactionid,tagactivationExistingUser.datetime,tagactivationExistingUser.resultTag,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname,salesmanager.Fname as smfrst,salesmanager.Lname as smlst,teamlead.Fname as tlfrst,teamlead.Lname as tllst');
          $builder->join('salesagent', 'salesagent.salesagentId = tagactivationExistingUser.salesagentId');
          $builder->join('teamlead', 'teamlead.teamleadId = salesagent.requestedById');
          $builder->join('salesmanager', 'salesmanager.salesManagerId = teamlead.requestedById');
          $builder->where('tagactivationExistingUser.salesagentType',0);
          $builder->orderBy('existinguserid DESC');          
          $query   = $builder->get();
          return $query->getResultArray();

      }
  
  
  	public function allsrch($table){
        $builder = $this->db->table($table);
        $result = $builder->get();
        return $result->getResultArray();

    }
}


?>