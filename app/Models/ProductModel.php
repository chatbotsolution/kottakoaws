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
  
  public function multisearchFastag($updtid){
            
        $builder = $this->db->table('fastaginventory');
    	$builder->select('fastaginventory.fasttagid,fastaginventory.datetime,fasttag.barcode,fasttag.fasttagid');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$updtid);
        $builder->where('fastaginventory.allotedtotype',3);
        $builder->where('fastaginventory.status',0);
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  	public function multisearchFastagOEM($updtid){
            
        $builder = $this->db->table('fastaginventory');
    	$builder->select('fastaginventory.fasttagid,fastaginventory.datetime,fasttag.barcode,fasttag.fasttagid');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$updtid);
        $builder->where('fastaginventory.allotedtotype',5);
        $builder->where('fastaginventory.status',0);
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  	public function salesAgentnew($idd,$type){
          $builder = $this->db->table('tagactivationinitial');      
          $builder->select('tagactivationinitial.productid,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.drivingLicence,tagactivationinitial.rcbook,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.salesagenttype,tagactivationinitial.orgreqid,tagactivationinitial.crnnumber,tagactivationinitial.tokennumber,tagactivationinitial.customerid,tagactivationinitial.dateofbirth,tagactivationinitial.agenttype,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,fasttag.tagid,fasttag.tid');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationinitial.barcodeid');
          $builder->where('salesagentId',$idd);
          $builder->where('salesagenttype',$type);
          $query   = $builder->get();
          return $query->getResultArray();
      }
}


?>