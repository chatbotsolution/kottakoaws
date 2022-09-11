<?php


namespace App\Models;
use \CodeIgniter\Model;

class ProductModel extends Model{

    protected $table='product';

    public function loginDatainsert($table,$data){

        $builder = $this->db->table($table);
        $res = $builder->insert($data);
        if($this->db->affectedRows() == 1){
                return true;
        }else{
                return false;
        }

    }

    public function vweAll($table){
        $builder = $this->db->table($table);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function distinctVal($table,$distnct){
        $builder = $this->db->table($table);
        $builder->select('DISTINCT('.$distnct.')');
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function entry_update($table,$upclnm,$updtdata,$updtid){
            
        $builder = $this->db->table($table);
        $builder->where($upclnm,$updtid);
        $builder->update($updtdata);
        $result = $builder->get();
        if(count($result->getResultArray()) == 1){
                return $result->getRowArray();
        }else{
                return false;
        }
    }
}


?>