<?php


namespace App\Models;
use \CodeIgniter\Model;

class SalesAgentModel extends Model{

    protected $table='salesagent';

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
  
    public function getSalesagentindividual($idd){
          $builder = $this->db->table('tagactivationExistingUser');
          $builder->select('tagactivationExistingUser.salesagentId,salesagent.salesAgentRegdNum,salesagent.ProfileImage, salesagent.Fname ,salesagent.Lname');
          $builder->join('salesagent', 'salesagent.salesagentId = tagactivationExistingUser.salesagentId');
          $builder->where('transactionid',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
  public function getSalesagentindividual1($idd){
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
        $builder = $this->db->table('salesagent');        
        $builder->select('salesagentmailid,salesagentId,salesAgentRegdNum,Fname,Lname,ContactPrimary,ContactSecondary,ProfileImage,toll&city,allowedIdCreation,bankdetailsid,nomineedetailsid, kycdetailsid,requestedById,status,otp');
        $builder->where('salesAgentRegdNum',$data);
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
  
  
  	public function entry_update1($table,$upclnm,$updtdata,$updtid){
            
        $builder = $this->db->table($table);
        $builder->where($upclnm,$updtid);
        $builder->update($updtdata);
        $result = $builder->get();
        if(count($result->getResultArray()) >= 1){
                return true;
        }else{
                return false;
        }
    }

    public function lastLogin($usrid){

        $builder = $this->db->table('login_data');
        $builder->select('login_id,datetime_login,login_data_id');
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
  
  	public function lastLogin1($usrid){

        $builder = $this->db->table('login_data');
        $builder->select('login_id,datetime_login,login_data_id');
        $builder->where('login_id',$usrid);
        $builder->where('user_type',3);
        $builder->orderBy('login_data_id ', 'desc');
        $builder->limit(1,1);
        $result = $builder->get();

                return $result->getRowArray();

    }

    public function viewspecific($table,$viewdata,$whrclm,$whrval){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $result = $builder->get();
        return $result->getResultArray();
    }
    
    
    public function viewspecificdstnt($table,$viewdata,$whrclm,$whrval){

        $builder = $this->db->table($table);
        $builder->distinct();
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $builder->where('status',0);
        $result = $builder->get();
        return $result->getResultArray();
    }
    
    
    public function barcddstnt($table,$viewdata,$whrclm,$whrval){

        $builder = $this->db->table($table);
        $builder->distinct();
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  	public function viewspecificoth($table,$viewdata,$whrclm){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm);
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
        $builder = $this->db->table('salesagent');
        $builder->select('salesagent.salesagentId,salesagent.bankdetailsid,salesagent.nomineedetailsid,salesagent.kycdetailsid,salesagent.allowedIdCreation,salesagent.salesAgentRegdNum,salesagent.Fname,salesagent.Lname,salesagent.ContactPrimary,salesagent.ContactSecondary,salesagent.ProfileImage,salesagent.toll&city,salesagent.status,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
        $builder->join('bankdetails', 'bankdetails.bankDetailsId = salesagent.bankdetailsid');
        $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesagent.nomineedetailsid');
        $builder->join('kycdetails', 'kycdetails.kycdetailsid = salesagent.kycdetailsid');
        $builder->where('salesagentId', $uid);
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
  
  
    public function requestshow1(){
          $builder = $this->db->table('salesagent');
          $builder->select('salesagent.salesagentId,salesagent.bankdetailsid,salesagent.nomineedetailsid,salesagent.kycdetailsid,salesagent.allowedIdCreation,salesagent.salesAgentRegdNum,salesagent.Fname,salesagent.Lname,salesagent.ContactPrimary,salesagent.ContactSecondary,salesagent.ProfileImage,salesagent.toll&city,salesagent.status,salesagent.datetime,teamlead.TleadRegdNum');
          $builder->join('teamlead', 'salesagent.requestedById = teamlead.teamleadId');
          $builder->join('salesmanager', 'salesmanager.salesManagerId = teamlead.requestedById');
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
        $builder->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag,fasttag.bankname');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$id);
        $builder->where('fastaginventory.allotedtotype',$typ);
        $query   = $builder->get();
        return $query->getResultArray();
    }
  
    public function showfastagbank($id,$typ,$bank){
        $builder = $this->db->table('fastaginventory');
        $builder->select('fastaginventory.fasttagid,fastaginventory.inventoryid,fastaginventory.allotedto,fastaginventory.allotedtotype,fastaginventory.status,fasttag.barcode,fasttag.tagid,fasttag.classoftag,fasttag.bankname');
        $builder->join('fasttag', 'fasttag.fasttagid = fastaginventory.fasttagid');
        $builder->where('fastaginventory.allotedto',$id);
        $builder->where('fastaginventory.allotedtotype',$typ);
        $builder->where('fasttag.bankname',$bank);
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
        $builder->where("selectproduct.userId",$uid);
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
  
  
    public function salesAgentnew($idd,$type){
          $builder = $this->db->table('tagactivationinitial'); 
          $builder->select('tagactivationinitial.productid,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.drivingLicence,tagactivationinitial.rcbook,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.salesagenttype,tagactivationinitial.orgreqid,tagactivationinitial.crnnumber,tagactivationinitial.tokennumber,tagactivationinitial.customerid,tagactivationinitial.dateofbirth,tagactivationinitial.agenttype,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,fasttag.tagid,fasttag.tid');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationinitial.barcodeid');
          $builder->where('salesagentId',$idd);
          $builder->where('salesagenttype',$type);
          $builder->where('tagactivationinitial.transactionstatus',0);
          $builder->where('tagactivationinitial.responsecode',230201);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
    public function salesAgentexisting($idd,$type){
            $builder = $this->db->table('tagactivationExistingUser'); 
            $builder->select('tagactivationExistingUser.productid,tagactivationExistingUser.classofBarcode,tagactivationExistingUser.vehicleType,tagactivationExistingUser.customername,tagactivationExistingUser.mobileNumber,tagactivationExistingUser.rcbook,tagactivationExistingUser.vehicleNumbertype,tagactivationExistingUser.vehiclechasisnumber,tagactivationExistingUser.salesagentId,tagactivationExistingUser.salesagenttype,tagactivationExistingUser.customerid,tagactivationExistingUser.statusTag,tagactivationExistingUser.agenttype,tagactivationExistingUser.barcodeid,tagactivationExistingUser.transactionstatus,tagactivationExistingUser.transactionid,tagactivationExistingUser.datetime,fasttag.tagid,fasttag.tid');

            $builder->join('fasttag', 'fasttag.barcode = tagactivationExistingUser.barcodeid');
            $builder->where('salesagentId',$idd);
            $builder->where('salesagenttype',$type);
            $builder->where('tagactivationExistingUser.transactionstatus',0);
            $builder->where('tagactivationExistingUser.statusTag',230201);
            $query   = $builder->get();
            return $query->getResultArray();
        }
  
  
  		public function showSelectdTeamAgent($idd){
            $builder = $this->db->table('salesagent');
            $builder->select('salesagent.salesagentId,salesagent.salesAgentRegdNum, salesagent.Fname ,salesagent.Lname, salesagent.ContactPrimary, salesagent.requestedById , salesagent.allowedIdCreation, salesagent.toll&city, salesagent.status,salesagent.bankdetailsid , salesagent.kycdetailsid,bankdetails.bankkycStatus,kycdetails.kycStatus,bankdetails.bankName,bankdetails.accountNumber,bankdetails.IFSCCode,bankdetails.bankkycStatus,nomeedetails.firstName,nomeedetails.lastName,nomeedetails.relationWith,nomeedetails.contactNumber,nomeedetails.idProof,kycdetails.aadharNumber,kycdetails.panCardNumber,kycdetails.drivingLicenceNumber,kycdetails.aadharProof,kycdetails.panCardProof,kycdetails.drivingLicenceProof,kycdetails.kycStatus');
            $builder->join('bankdetails', 'salesagent.bankdetailsid = bankdetails.bankDetailsId');
            $builder->join('kycdetails', 'salesagent.kycdetailsid = kycdetails.kycdetailsid');
            $builder->join('nomeedetails', 'nomeedetails.nameeDetailsId = salesagent.nomineedetailsid');
            $builder->where('salesagent.requestedById',$idd);
            $query   = $builder->get();
            return $query->getResultArray();
        }
  
  
  		public function salesAgentreport($idd){
          $builder = $this->db->table('tagactivationinitial');
          $builder->select('tagactivationinitial.productid,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.drivingLicence,tagactivationinitial.rcbook,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.salesagenttype,tagactivationinitial.orgreqid,tagactivationinitial.crnnumber,tagactivationinitial.tokennumber,tagactivationinitial.customerid,tagactivationinitial.dateofbirth,tagactivationinitial.agenttype,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,fasttag.tagid,fasttag.tid,fasttag.bankname');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationinitial.barcodeid');
          $builder->where('initialId',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
  	  public function salesAgentreportext($idd){
          $builder = $this->db->table('tagactivationExistingUser');
          $builder->select('tagactivationExistingUser.productid,tagactivationExistingUser.classofBarcode,tagactivationExistingUser.vehicleType,tagactivationExistingUser.customername,tagactivationExistingUser.mobileNumber,tagactivationExistingUser.vehicleNumbertype,tagactivationExistingUser.vehiclechasisnumber,tagactivationExistingUser.salesagentId,tagactivationExistingUser.salesagentType,tagactivationExistingUser.customerid,tagactivationExistingUser.agenttype,tagactivationExistingUser.barcodeid,tagactivationExistingUser.transactionstatus,tagactivationExistingUser.transactionid,tagactivationExistingUser.resultTag,tagactivationExistingUser.statusTag,tagactivationExistingUser.datetime,fasttag.tagid,fasttag.tid,fasttag.bankname');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationExistingUser.barcodeid');
          $builder->where('existinguserid',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
  	  public function salesAgentreportoem($idd){
          $builder = $this->db->table('tagactivationinitial');
          $builder->select('tagactivationinitial.productid,tagactivationinitial.classofBarcode,tagactivationinitial.vehicleType,tagactivationinitial.customername,tagactivationinitial.mobileNumber,tagactivationinitial.pancarddetails,tagactivationinitial.drivingLicence,tagactivationinitial.rcbook,tagactivationinitial.vehicleNumbertype,tagactivationinitial.vehiclechasisnumber,tagactivationinitial.salesagentId,tagactivationinitial.salesagenttype,tagactivationinitial.orgreqid,tagactivationinitial.crnnumber,tagactivationinitial.tokennumber,tagactivationinitial.customerid,tagactivationinitial.dateofbirth,tagactivationinitial.agenttype,tagactivationinitial.barcodeid,tagactivationinitial.transactionstatus,tagactivationinitial.transactionid,tagactivationinitial.datetime,fasttag.tagid,fasttag.tid,fasttag.bankname,oem.companyname,manufacturer.manufacturername');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationinitial.barcodeid');
          $builder->join('oem', 'oem.oemid = tagactivationinitial.salesagentId');
          $builder->join('manufacturer', 'manufacturer.manufactureid = oem.manufacturer');
          $builder->where('initialId',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
  	  public function salesAgentreportoemext($idd){
          $builder = $this->db->table('tagactivationExistingUser');
          $builder->select('tagactivationExistingUser.productid,tagactivationExistingUser.classofBarcode,tagactivationExistingUser.vehicleType,tagactivationExistingUser.customername,tagactivationExistingUser.mobileNumber,tagactivationExistingUser.vehicleNumbertype,tagactivationExistingUser.vehiclechasisnumber,tagactivationExistingUser.salesagentId,tagactivationExistingUser.salesagentType,tagactivationExistingUser.customerid,tagactivationExistingUser.agenttype,tagactivationExistingUser.barcodeid,tagactivationExistingUser.transactionstatus,tagactivationExistingUser.transactionid,tagactivationExistingUser.resultTag,tagactivationExistingUser.statusTag,tagactivationExistingUser.datetime,fasttag.tagid,fasttag.tid,fasttag.bankname,oem.companyname,manufacturer.manufacturername');
      
          $builder->join('fasttag', 'fasttag.barcode = tagactivationExistingUser.barcodeid');
          $builder->join('oem', 'oem.oemid = tagactivationExistingUser.salesagentId');
          $builder->join('manufacturer', 'manufacturer.manufactureid = oem.manufacturer');
          $builder->where('existinguserid',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
      }
  
  	
  	 public function deletef($idd){
       $builder = $this->db->table('selectproduct');
       $builder->where('userId', $idd);
       $builder->where('userType', 3);
       $query   = $builder->delete();
       return true;
     }
  
  	 public function viewspecificothh($table,$viewdata,$whrclm){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm);
        //$builder->where('datetime BETWEEN CURDATE()-INTERVAL 1 WEEK AND CURDATE()');
        $builder->where('week(datetime)=week(now())-1');
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  
  	public function multiSrchnw($table,$viewdata,$whrclm,$whrval,$whrclm1,$whrval1,$whrclm2,$whrval2){

        $builder = $this->db->table($table);
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $builder->where($whrclm1,$whrval1);
        $builder->where($whrclm2,$whrval2);
        $result = $builder->get();
        return $result->getResultArray();
    }
  
  
    public function getClassofbarcode($idd){
          $builder = $this->db->table('product');
          
          $builder->distinct();
          //$builder->groupBy('classofbarcode.classofbarcode');
          $builder->select('product.productid,product.fastagClass,product.fastagprice,classofbarcode.classofbarcode,classofbarcode.typeofvehicle,classofbarcode.toshowinapplication');      
          $builder->join('classofbarcode', 'product.fastagClass = classofbarcode.fastagclass');
          $builder->where('product.productid',$idd);
          $query   = $builder->get();
          return $query->getResultArray();
          
          /*$builder = $this->db->table($table);
        $builder->distinct();
        $builder->select($viewdata);
        $builder->where($whrclm,$whrval);
        $builder->where('status',0);
        $result = $builder->get();
        return $result->getResultArray();*/
      }
  
   public function getClassofbarcodespecific($clss){
          $builder = $this->db->table('classofbarcode');
          $builder->select('*');
          $builder->where('classofbarcode',$clss);
          $builder->where('status',0);
          $query   = $builder->get();
          return $query->getResultArray();
      }
      
      
    public function getClassofbarcodespecificnwe($clss){
          $builder = $this->db->table('classofbarcode');
          $builder->select('*');
          $builder->where('toshowinapplication',$clss);
          $builder->where('status',0);
          $query   = $builder->get();
          return $query->getResultArray();
      }
}


?>