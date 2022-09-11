<?php


namespace App\Models;
use \CodeIgniter\Model;

class ReportModel extends Model{

    public function loginDatainsert($table,$data){

        $builder = $this->db->table($table);
        $res = $builder->insert($data);
        if($this->db->affectedRows() == 1){
                return true;
        }else{
                return false;
        }

    }
  
  	public function showtlreport($id){
      $builder = $this->db->table('teamlead');
      $builder->select('*');
     // $builder->select('teamlead.teamleadId,teamlead.TleadRegdNum,teamlead.Fname,teamlead.Lname,teamlead.target,salesagent.salesAgentRegdNum,salesagent.Fname as salefname,salesagent.Lname as salelname,salesagent.ContactPrimary,salesagent.salesagentId');
      //$builder->join('salesagent', 'salesagent.requestedById = teamlead.teamleadId');
      $builder->where('requestedById',$id);
      $query   = $builder->get();
      return $query->getResultArray();
    }

}


?>