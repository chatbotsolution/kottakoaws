<?php


namespace App\Models;
use \CodeIgniter\Model;

class TeamLeadModel extends Model{

    protected $table='teamlead';

    public function loginDatainsert($table,$data){

        $builder = $this->db->table($table);
        $res = $builder->insert($data);
        if($this->db->affectedRows() == 1){
                return true;
        }else{
                return false;
        }

    }

    public function showSelectd(){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.teamleadId,teamlead.TleadRegdNum, teamlead.Fname ,teamlead.Lname, teamlead.ContactPrimary, teamlead.requestedById , teamlead.allowedIdCreation, teamlead.toll&city, teamlead.status,teamlead.bankdetailsid , teamlead.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus');
        $builder->join('bankdetails', 'teamlead.bankdetailsid = bankdetails.bankDetailsId');
        $builder->join('kycdetails', 'teamlead.kycdetailsid = kycdetails.kycdetailsid');
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function vweAll($table){
        $builder = $this->db->table($table);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function findSelect($data){
        $builder = $this->db->table('teamlead');        
        $builder->select('teamleadId,teamleademailid,TleadRegdNum,Fname,Lname,ContactPrimary,ContactSecondary,ProfileImage,toll&city,allowedIdCreation,bankdetailsid,nomineedetailsid, kycdetailsid,requestedById,status,otp');
        $builder->where('TleadRegdNum',$data);
        $query   = $builder->get();

        if(count($query->getResultArray()) == 1){
                return $query->getRowArray();
        }else{
                return false;
        }
        return $query->getRowArray();
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

    public function lastLogin($usrid){

        $builder = $this->db->table('login_data');
        $builder->select('login_id,datetime_login');
        $builder->where('login_id',$usrid);
        $builder->where('user_type',1);
        $builder->orderBy('login_data_id ', 'desc');
        $builder->limit(1,1);
        $result = $builder->get();

        if(count($result->getResultArray()) == 1){
                return $result->getRowArray();
        }else{
                return false;
        }

    }

    public function viewspecific($table,$viewdata,$whrclm,$whrval){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $result = $builder->get();
        return $result->getResultArray();
    }

    public function showprofiledetails($uid){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.teamleadId,teamlead.TleadRegdNum,teamlead.toll&city,teamlead.allowedIdCreation,teamlead.Fname,teamlead.Lname,teamlead.ContactPrimary,teamlead.ContactSecondary,teamlead.ProfileImage,teamlead.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = teamlead.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = teamlead.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = teamlead.kycdetailsid');
        $builder->where('teamleadId', $uid);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function showprofiledetails1($uid){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.requestedById,teamlead.teamleadId,teamlead.bankdetailsid,teamlead.nomineedetailsid,teamlead.kycdetailsid,teamlead.TleadRegdNum,teamlead.toll&city,teamlead.allowedIdCreation,teamlead.Fname,teamlead.Lname,teamlead.ContactPrimary,teamlead.ContactSecondary,teamlead.ProfileImage,teamlead.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = teamlead.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = teamlead.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = teamlead.kycdetailsid');
        $builder->where('teamleadId', $uid);
        $query   = $builder->get();
        return $query->getRowArray();
    }


    public function requestshow(){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.teamleadId,teamlead.TleadRegdNum,teamlead.toll&city,teamlead.allowedIdCreation,teamlead.Fname,teamlead.Lname,teamlead.ContactPrimary,teamlead.ContactSecondary,teamlead.ProfileImage,salesmanager.RegdNum,salesmanager.datetime,salesmanager.salesManagerId');
        $builder->join('salesmanager', 'teamlead.requestedById = salesmanager.salesManagerId');
        $builder->where('teamlead.status',2);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function tollcityshow($uid,$type){
        $builder = $this->db->table('tollandcitypermitted');
        $builder->where('user_id',$uid);
        $builder->where('userType',$type);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function viewprdata($uid){

        $builder = $this->db->table("selectproduct");
        $builder->select('selectproduct.productid,selectproduct.userId,selectproduct.userType,selectproduct.status,product.fastagClass,product.fastagprice,product.initialPayment,product.prodctCode');
        $builder->join('product', 'product.productid = selectproduct.productid');
        $builder->where("selectproduct.userId",$uid);
        $builder->where("selectproduct.userType",2);
        $builder->where("selectproduct.status",0);
        $result = $builder->get();
        return $result->getResultArray();
    }

    public function showfastag($id,$typ){
        $builder = $this->db->table('fastaginventory');
        $builder->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$id);
        $builder->where('fastaginventory.allotedtotype',$typ);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function showSelectdManager($id){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.teamleadId,teamlead.TleadRegdNum, teamlead.Fname ,teamlead.Lname, teamlead.ContactPrimary, teamlead.requestedById , teamlead.allowedIdCreation, teamlead.toll&city, teamlead.status,teamlead.bankdetailsid , teamlead.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus');
        $builder->join('bankdetails', 'teamlead.bankdetailsid = bankdetails.bankDetailsId');
        $builder->join('kycdetails', 'teamlead.kycdetailsid = kycdetails.kycdetailsid');
        $builder->where('teamlead.requestedById',$id);
        $query   = $builder->get();
        return $query->getResultArray();
    }
}


?>