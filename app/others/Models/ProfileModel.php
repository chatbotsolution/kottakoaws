<?php


namespace App\Models;
use \CodeIgniter\Model;

class ProfileModel extends Model{


        public function findAdminData(){
            $builder = $this->db->table('admin');
            $builder->select('userid,name,email,contact_number');
            $builder->where('admin_id','1');
            $result = $builder->get();
            
            return $result->getResultArray();
            
        }

        public function ftchAdminData($table,$selct,$typ,$idd){
            $builder = $this->db->table($table);
            $builder->select($selct);
            $builder->where($typ,$idd);
            $result = $builder->get();
            
            return $result->getRowArray();
            
        }

        public function updtAdminData($data) {
            
            $builder = $this->db->table('admin');
            $builder->where('admin_id','1');
            $builder->update($data);
            $result = $builder->get();
            if(count($result->getResultArray()) == 1){
                    return $result;
            }else{
                    return false;
            }
        }


}