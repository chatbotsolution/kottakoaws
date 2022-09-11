<?php


namespace App\Models;
use \CodeIgniter\Model;

class OemModel extends Model{

    protected $table='oem';

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
        $builder = $this->db->table('salesagent');
        $builder->select('salesagent.salesagentId,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname, salesagent.ContactPrimary, salesagent.requestedById , salesagent.allowedIdCreation, salesagent.toll&city, salesagent.status,salesagent.bankdetailsid , salesagent.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus');
        $builder->join('bankdetails', 'salesagent.bankdetailsid = bankdetails.bankDetailsId');
        $builder->join('kycdetails', 'salesagent.kycdetailsid = kycdetails.kycdetailsid');
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function getSalesagent($idd){
        $builder = $this->db->table('tagactivationinitial');
        $builder->select('tagactivationinitial.salesagentId,salesagent.salesAgentRegdNum,salesagent.ProfileImage, salesagent.Fname ,salesagent.Lname');
        $builder->join('salesagent', 'salesagent.salesagentId = tagactivationinitial.salesagentId');
        $builder->where('transactionid',$idd);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function vweAll($table){
        $builder = $this->db->table($table);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function findSelect($data){
        $builder = $this->db->table('oem');        
        $builder->select('*');
        $builder->where('gstnumber',$data);
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
        $builder->select('login_id,datetime_login,login_data_id');
        $builder->where('login_id',$usrid);
        $builder->where('user_type',5);
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
        $builder = $this->db->table('salesagent');
        $builder->select('salesagent.salesagentId,salesagent.salesagentmailid,salesagent.region,salesagent.allowedIdCreation,salesagent.salesAgentRegdNum,salesagent.Fname,salesagent.Lname,salesagent.ContactPrimary,salesagent.ContactSecondary,salesagent.ProfileImage,salesagent.toll&city,salesagent.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = salesagent.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesagent.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = salesagent.kycdetailsid');
        $builder->where('salesagentId', $uid);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function showprofiledetails1($uid){
        $builder = $this->db->table('oem');
        
        $builder->select('oem.companyname,oem.tradename,oem.gstnumber,oem.pancardnumber,oem.spocnumber,oem.spocdetails,oem.gmname,oem.gmcontact,oem.gstcertificate,oem.manufacturer,oem.noofbranch,oem.hodcity,oem.status,oem.ProfileImage,manufacturer.manufacturername');
        $builder->join('manufacturer', 'oem.manufacturer = manufacturer.manufactureid');
        $builder->where('oemid', $uid);
        $query   = $builder->get();
        return $query->getRowArray();
    }

    public function requestshow(){
        $builder = $this->db->table('salesagent');
        $builder->select('salesagent.salesagentId,salesagent.bankdetailsid,salesagent.nomineedetailsid,salesagent.kycdetailsid,salesagent.allowedIdCreation,salesagent.salesAgentRegdNum,salesagent.Fname,salesagent.Lname,salesagent.ContactPrimary,salesagent.ContactSecondary,salesagent.ProfileImage,salesagent.toll&city,salesagent.status,salesagent.datetime,teamlead.TleadRegdNum');
        $builder->join('teamlead', 'salesagent.requestedById = teamlead.teamleadId');
        $builder->where('salesagent.status',2);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function viewprdata($uid){

        $builder = $this->db->table("selectproduct");
        $builder->select('selectproduct.productid,selectproduct.userId,selectproduct.userType,selectproduct.status,product.fastagClass,product.fastagprice,product.initialPayment,product.prodctCode');
        $builder->join('product', 'product.productid = selectproduct.productid');
        $builder->where("selectproduct.userId",$uid);
        $builder->where("selectproduct.userType",3);
        $builder->where("selectproduct.status",0);
        $result = $builder->get();
        return $result->getResultArray();
    }

    public function requestindvshow($idd){
        $builder = $this->db->table('salesagent');
        $builder->select('teamlead.TleadRegdNum,teamlead.Fname,teamlead.Lname,teamlead.ContactPrimary,teamlead.ContactSecondary, teamlead.teamleademailid,teamlead.status');
        $builder->join('teamlead', 'salesagent.requestedById = teamlead.teamleadId');
        $builder->where('salesagent.salesagentId',$idd);
        $query   = $builder->get();
        return $query->getResultArray();
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

    public function showSelectdAgent($idd){
        $builder = $this->db->table('teamlead');
        $builder->select('teamlead.requestedById,teamlead.status,salesagent.salesagentId,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname, salesagent.ContactPrimary, salesagent.requestedById , salesagent.allowedIdCreation, salesagent.toll&city, salesagent.status,salesagent.bankdetailsid , salesagent.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('salesagent', 'salesagent.requestedById = teamlead.teamleadId');
        $builder->join('bankdetails', 'salesagent.bankdetailsid = bankdetails.bankDetailsId');
        $builder->join('kycdetails', 'salesagent.kycdetailsid = kycdetails.kycdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesagent.nomineedetailsid');
        $builder->where('teamlead.requestedById',$idd);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function snglprddtls($uid){

        $builder = $this->db->table("selectproduct");
        $builder->select('selectproduct.productid,selectproduct.userId,selectproduct.userType,selectproduct.status,product.fastagClass,product.fastagprice,product.initialPayment,product.prodctCode');
        $builder->join('product', 'product.productid = selectproduct.productid');
        $builder->where("selectproduct.selectProductid",$uid);
        $result = $builder->get();
        return $result->getResultArray();
    }

    public function multiSrch($table,$viewdata,$whrclm,$whrval,$whrclm1,$whrval1){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $builder->where($whrclm1,$whrval1);
        $result = $builder->get();
        return $result->getResultArray();
    }
}


?>