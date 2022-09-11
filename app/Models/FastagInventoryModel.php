<?php


namespace App\Models;
use \CodeIgniter\Model;

class FastagInventoryModel extends Model{
  
    protected $table='fastaginventory';
  
  
    public function showfastag($id,$typ){
        $builder = $this->db->table('fastaginventory');
        $builder->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$id);
        $builder->where('fastaginventory.allotedtotype',$typ);
        $query   = $builder->get();
        return $query->getResultArray();
    }
  
  	public function sortfastag($id,$typ,$sts){
        $builder = $this->db->table('fastaginventory');
        $builder->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$id);
        $builder->where('fastaginventory.allotedtotype',$typ);
        $builder->where('fastaginventory.status',$sts);
        $query   = $builder->get();
        return $query->getResultArray();
    }
    
}


?>