<?php


namespace App\Models;
use \CodeIgniter\Model;

class LoginModel extends Model{

    public function verifyUserid($data,$type){

        $builder = $this->db->table('admin');
        $builder->select('userid,password,status,admin_id,admin_type,image');
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
        $builder->select('name,email,contact_number');
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
}


?>