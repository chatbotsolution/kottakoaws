<?php

namespace App\Controllers;
use \App\Models\OemModel;

class oemProfileController extends BaseController
{
    public $profileModel;
    public $session;

    public function __construct(){
        helper("form");
        $this->profileModel = new OemModel();
        $this->session = session();
        
    }

    public function editProfile(){
        if(!$this->session->has('salesagentId')){
            return redirect()->to(base_url('salesagentLogin'));
        }

        $data= [];

        $rules = [
            "fname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'First Name Is required ',
                ],
            ],
            "tollnme"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll And City Name Is required ',
                ],
            ],
            "lname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Last Name Is required ',
                ],
            ],
            "contctnumprim"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Primary Contact Number Is required ',
                ],
            ],
            "contctnumsec"=>[
                'rules'=>'required|numeric|max_length[10]',
                'errors'=>[
                    'required'=>'Secondary Contact Number Is required ',
                ],
            ],
            "noidcrtn"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'No Of Id Creation Is required ',
                ],
            ],
            "tollncity"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll And City Is required ',
                ],
            ],
            "tollnme"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Toll Name And City Name Is required ',
                ],
            ],
            "accntnum"=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Account Number Is required ',
                ],
            ],
            "ifsccode"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'IFSC Code Is required ',
                ],
            ],
            "bankname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Bank Name Is required ',
                ],
            ],
            "aadhrnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Aadhar Number Is required ',
                ],
            ],
            "pannum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'PAN Number Is required ',
                ],
            ],
            "drivinglicence"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Driving Licence Is required ',
                ],
            ],
            "nomefname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee First Name Is required ',
                ],
            ],
            "nomelname"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Last Name is required ',
                ],
            ],
            "reltnwthmngr"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Relationship With Sales Manager Is required ',
                ],
            ],
            "nomecntctnum"=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Nominee Contact Number Is required ',
                ],
            ],
        ];

        if($this->request->getMethod() == "post"){
            if($this->validate($rules)){
                $fname = $this->request->getVar('fname');
                $lname = $this->request->getVar('lname');
                $contctnumprim = $this->request->getVar('contctnumprim');
                $contctnumsec = $this->request->getVar('contctnumsec');
                $tollnme = $this->request->getVar('tollnme');
                
                
                $tollncity = $this->request->getVar('tollncity');
                $noidcrtn = $this->request->getVar('noidcrtn');
                $tollnme = $this->request->getVar('tollnme');
                
                
                $accntnum = $this->request->getVar('accntnum');
                $ifsccode = $this->request->getVar('ifsccode');
                $bankname = $this->request->getVar('bankname');
                $aadhrnum = $this->request->getVar('aadhrnum');
                $aadharproof = $this->request->getFile('aadharproof');
                $pannum = $this->request->getVar('pannum');
                $panproof = $this->request->getFile('panproof');
                $drivinglicence = $this->request->getVar('drivinglicence');
                $drivingproof = $this->request->getFile('drivingproof');
                $nomefname = $this->request->getVar('nomefname');
                $nomelname = $this->request->getVar('nomelname');
                $reltnwthmngr = $this->request->getVar('reltnwthmngr');
                $nomecntctnum = $this->request->getVar('nomecntctnum');
                $nomeidproof = $this->request->getFile('nomeidproof');
                $profileimg = $this->request->getFile('profileimg');

                $alldata = $this->profileModel->showprofiledetails1($_SESSION["salesagentId"]);

                if($this->request->getFile('profileimg')){
                    if($profileimg->isValid() && !$profileimg->hasMoved()){
                        $newprofileimg = $profileimg->getRandomName();
                        if($profileimg->move(FCPATH.'public/adminasset/img/salesagent/profileimage/',$newprofileimg)){                           
                                 $profileImage = $newprofileimg;
                        }
                    }else{
                                 $profileImage = $alldata["ProfileImage"];
                    }
                }

                if($this->request->getFile('nomeidproof')){
                    if($nomeidproof->isValid() && !$nomeidproof->hasMoved()){
                        $newnomeidproof = $nomeidproof->getRandomName();
                        if($nomeidproof->move(FCPATH.'public/adminasset/img/salesagent/nomeedata/',$newnomeidproof)){                           
                                 $nomineeproof = $newnomeidproof;
                        }
                    }else{
                                 $nomineeproof = $alldata["idProof"];
                    }
                }

                if($this->request->getFile('drivingproof')){
                    if($drivingproof->isValid() && !$drivingproof->hasMoved()){
                        $newdrivingproof = $drivingproof->getRandomName();
                        if($drivingproof->move(FCPATH.'public/adminasset/img/salesagent/drivinglicence/',$newdrivingproof)){                           
                                $drivinglicenceproof = $newdrivingproof;
                        }
                    }else{
                                $drivinglicenceproof = $alldata["drivingLicenceProof"];
                    }
                }

                if($this->request->getFile('panproof')){
                    if($panproof->isValid() && !$panproof->hasMoved()){
                        $newpanproof = $panproof->getRandomName();
                        if($panproof->move(FCPATH.'public/adminasset/img/salesagent/pancard/',$newpanproof)){                           
                                $pancardproof = $newpanproof;
                        }
                    }else{
                                $pancardproof = $alldata["panCardProof"];
                    }
                }

                if($this->request->getFile('aadharproof')){
                    if($aadharproof->isValid() && !$aadharproof->hasMoved()){
                        $newaadharproof = $aadharproof->getRandomName();
                        if($aadharproof->move(FCPATH.'public/adminasset/img/salesagent/aadharcard/',$newaadharproof)){                           
                                $aadharcardproof = $newaadharproof;
                        }
                    }else{
                                $aadharcardproof = $alldata["aadharProof"];
                    }  
                }                       
                            
                    $dtm = date("Y-m-d h:i:s");

                    /*----------------------------Bank Details--------------------------------*/
                    $tablee="bankdetails";
                    $upclnm="bankDetailsId";
                    $updtid=$alldata["bankdetailsid"];
                    $updtdata = ["bankName"=>$bankname,"accountNumber"=>$accntnum,"IFSCCode"=>$ifsccode,"datetime"=>$dtm];
                    $bnkdtta = $this->profileModel->entry_update($tablee,$upclnm,$updtdata,$updtid);

                    /*----------------------------KYC Details--------------------------------*/
                    
                    $tablee="kycdetails";
                    $upclnm="kycdetailsid";
                    $updtid=$alldata["kycdetailsid"];
                    $updtdata = ["aadharNumber"=>$aadhrnum,"panCardNumber"=>$pannum,"drivingLicenceNumber"=>$drivinglicence,"aadharProof"=>$aadharcardproof,"panCardProof"=>$pancardproof,"drivingLicenceProof"=>$drivinglicenceproof,"datetime"=>$dtm];
                    $kycdtta = $this->profileModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    
                    /*----------------------------- Nominee Details---------------------------*/
                    $tablee="nomeedetails";
                    $upclnm="nameeDetailsId";
                    $updtid=$alldata["nomineedetailsid"];
                    $updtdata = ["firstName"=>$nomefname,"lastName"=>$nomelname,"relationWith"=>$reltnwthmngr,"contactNumber"=>$nomecntctnum,"idProof"=>$nomineeproof,"datetime"=>$dtm];
                    $nomineedtta = $this->profileModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    
                    $tablee="salesagent";
                    $upclnm="salesagentId";
                    $updtid=$alldata["salesagentId"];
                    $updtdata = ["tollname"=>$tollnme,"Fname"=>$fname,"Lname"=>$lname,"ContactPrimary"=>$contctnumprim,"ContactSecondary"=>$contctnumsec,"toll&city"=>$tollncity,"allowedIdCreation"=>$noidcrtn,"ProfileImage"=>$profileImage,"datetime"=>$dtm];
                    $salesagent = $this->profileModel->entry_update($tablee,$upclnm,$updtdata,$updtid);
                    $this->session->set('logged_img',$profileImage);

                        $this->session->setTempdata('success','Profile Updated Successfully', 3);
                        return redirect()->to(base_url('salesagent/editprofile'));
                    

            }else{
                $data['validations'] = $this->validator;
            }
        }

        $data['editprofileData'] = $this->profileModel->showprofiledetails($_SESSION["salesagentId"]);
        
        return view('salesagent/editprofile',$data);

    }
    
    public function viewProfile(){
        if(!$this->session->has('oemid')){
            return redirect()->to(base_url('oemLogin'));
        }

        $data= [];

        $data['profileData'] = $this->profileModel->showprofiledetails1($_SESSION["oemid"]);        
        

        return view('oem/Profile',$data);
    }

}
