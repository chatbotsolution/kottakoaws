<?php


namespace App\Models;
use \CodeIgniter\Model;

class SalesManagerModel extends Model{

    protected $table='fasttag';

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
        $builder = $this->db->table('salesmanager');
        $builder->select('salesmanager.salesManagerId,salesmanager.RegdNum, salesmanager.Fname ,salesmanager.Lname, salesmanager.ContactPrimary , salesmanager.regionOfSale, salesmanager.status,salesmanager.bankdetailsid , salesmanager.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus');
        $builder->join('bankdetails', 'salesmanager.bankdetailsid = bankdetails.bankDetailsId');
        $builder->join('kycdetails', 'salesmanager.kycdetailsid = kycdetails.kycdetailsid');
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function vweAll($table){
        $builder = $this->db->table($table);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function findSelect($data){
        $builder = $this->db->table('salesmanager');
        $builder->select('RegdNum,salesManagerId,otp,Fname,Lname,salesManagerId,ProfileImage,status,salesmngremailid');
        $builder->where('RegdNum',$data);
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
        $builder = $this->db->table('salesmanager');
        $builder->select('salesmanager.salesmngremailid,salesmanager.salesManagerId,salesmanager.RegdNum,salesmanager.Fname,salesmanager.Lname,salesmanager.ContactPrimary,salesmanager.ContactSecondary,salesmanager.ProfileImage,salesmanager.regionOfSale,salesmanager.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = salesmanager.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesmanager.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = salesmanager.kycdetailsid');
        $builder->where('salesManagerId', $uid);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function showprofiledetails1($uid){
        $builder = $this->db->table('salesmanager');
        $builder->select('salesmanager.salesmngremailid,salesmanager.salesManagerId,salesmanager.bankdetailsid,salesmanager.nomineedetailsid,salesmanager.kycdetailsid,salesmanager.RegdNum,salesmanager.Fname,salesmanager.Lname,salesmanager.ContactPrimary,salesmanager.ContactSecondary,salesmanager.ProfileImage,salesmanager.regionOfSale,salesmanager.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = salesmanager.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesmanager.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = salesmanager.kycdetailsid');
        $builder->where('salesManagerId', $uid);
        $query   = $builder->get();
        return $query->getRowArray();
    }

    public function viewspecific1($table,$viewdata,$whrclm,$whrval){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $result = $builder->get();
        return count($result->getResultArray());
    }

    public function viewprdata($uid){

        $builder = $this->db->table("selectproduct");
        $builder->select('selectproduct.productid,selectproduct.userId,selectproduct.userType,selectproduct.status,product.fastagClass,product.fastagprice,product.initialPayment,product.prodctCode');
        $builder->join('product', 'product.productid = selectproduct.productid');
        $builder->where("selectproduct.userId",$uid);
        $builder->where("selectproduct.userType",1);
        $builder->where("selectproduct.status",0);
        $result = $builder->get();
        return $result->getResultArray();
    }

    public function showprofiledetailsoem($uid){
        $builder = $this->db->table('oem'); 
        $builder->select('oem.oemid,oem.companyname,oem.tradename,oem.gstnumber,oem.pancardnumber,oem.spocnumber,oem.spocdetails,oem.gmcontact,oem.gstcertificate,oem.manufacturer,oem.noofbranch,oem.hodcity,oem.status,oem.datetime,oem.requestbyid,manufacturer.manufacturername');
        $builder->join('manufacturer', 'manufacturer.manufactureid = oem.manufacturer');
        $builder->where('oemid', $uid);
        $query   = $builder->get();
        return $query->getRowArray();
    }

    public function oemReqstmanager($uid){
        $builder = $this->db->table('salesmanager'); 
        $builder->select('RegdNum,Fname,Lname,salesmngremailid,ContactPrimary,ContactSecondary');
        $builder->where('salesManagerId', $uid);
        $query   = $builder->get();
        return $query->getRowArray();
    }

    public function requestshow(){
        $builder = $this->db->table('oem');        
        $builder->select('oem.oemid,oem.companyname,oem.tradename,oem.gstnumber,oem.pancardnumber,oem.spocnumber,oem.spocdetails,oem.gmcontact,oem.gstcertificate,oem.manufacturer,oem.noofbranch,oem.hodcity,oem.status,oem.datetime,oem.requestbyid,salesmanager.salesManagerId,salesmanager.RegdNum,salesmanager.Fname,salesmanager.Lname,salesmanager.salesmngremailid,salesmanager.ContactPrimary,salesmanager.ContactSecondary,manufacturer.manufacturername');
        $builder->join('manufacturer', 'manufacturer.manufactureid = oem.manufacturer');
        $builder->join('salesmanager', 'salesmanager.salesManagerId = oem.requestbyid');
        $builder->where('oem.status',2);
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

    public function ftchmulti($table,$viewdata,$whrdata){
        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrdata);
        $result = $builder->get();
        return $result->getResultArray();
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