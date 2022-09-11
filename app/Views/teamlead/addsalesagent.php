<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/teamlead/css.php'); ?>
  
  	<!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
    .allocated-button:hover {
      background-color: red;
      color: #fff;
    }
  </style>  
</head>

    <body class="main-body app sidebar-mini" onload="updtTime();">
   
        <div class="page">
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
			    <?= $this->include('partials/teamlead/headerLogo.php'); ?>
				<?= $this->include('partials/teamlead/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/teamlead/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/teamlead/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/teamlead/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/teamlead/headProfile.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
                	<!--	<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
					<div class="row" style="margin-top: -8px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row">
								<div class="card-body">	
								<?php if(session()->getTempdata('success')){ ?> 
                                <div class="alert alert-success alert-dismissible fade show"><?= session()->getTempdata('success'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
                                </div>
                                    <?php } ?>	
								
								<?php if(session()->getTempdata('error')){ ?> 
                                <div class="alert alert-danger alert-dismissible fade show"><?= session()->getTempdata('error'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
                                </div>
                                <?php } ?>
                                <div class="col-lg-12 col-md-12" style="padding-bottom: 50px;">	
                                    <div>
										<h6 class="card-title mb-1 card-flt">Add sales agent</h6>
									</div>
									<form action ="<?= base_url(); ?>/teamlead/addsalesagent" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Profile Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="profileimg" value="<?= set_value('profileimg'); ?>" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'profileimg'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fname" value="<?= set_value('fname'); ?>" Placeholder="First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lname" value="<?= set_value('lname'); ?>" Placeholder="Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumprim" value="<?= set_value('contctnumprim'); ?>" Placeholder="Contact Number(Primary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumprim'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumsec" value="<?= set_value('contctnumsec'); ?>" Placeholder="Contact Number(Secondary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumsec'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Email Id<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" value="<?= set_value('email'); ?>" Placeholder="Email Id" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'email'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Toll or City<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select  class="form-control mg-b-10" style="max-width:50%;" name="tollncity">
                                                    <option value="<?= $teamlead["toll&city"]; ?>"><?= $teamlead["toll&city"]; ?></option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'tollncity'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">State<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select  class="form-control mg-b-10" style="max-width:50%;" name="statedt">
                                                    <option value="">Select Your State</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'statedt'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">City<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="citydt" value="<?= set_value('citydt'); ?>" Placeholder="City" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'citydt'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Pincode<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="pincodedt" value="<?= set_value('pincodedt'); ?>" Placeholder="Pincode" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincodedt'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 1<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="addresslndt1" value="<?= set_value('addresslndt1'); ?>" Placeholder="Address Line 1" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addresslndt1'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 2<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="addresslndt2" value="<?= set_value('addresslndt2'); ?>" Placeholder="Address Line 2" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addresslndt2'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 3<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="addresslndt3" value="<?= set_value('addresslndt3'); ?>" Placeholder="Address Line 3" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addresslndt3'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Toll And City Name<span style="color: red">*</span></label>
                                            <div class="col-sm-6">
                                               <div class="row">
                                                   <?php
                                                      foreach($teamleadtoll as $prd):
                                                    ?>
                                                        <div class="col-md-3" style="margin-bottom:15px;">
                                                            <span style="border: 1px solid #ebebeb;padding: 5px;float: left;width: 100%;text-align: center;">
                                                                <input type="checkbox" value="<?= $prd["tollorcityname"]; ?>" name="producttollcity[]"> <lable><?= $prd["tollorcityname"]; ?></label>
                                                            </span>
                                                        </div>
                                                    <?php
                                                      endforeach;
                                                    ?>
                                               </div>
                                              <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'producttollcity'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Product<span style="color: red">*</span></label>
                                            <div class="col-sm-6">
                                               <div class="row">
                                                   <?php
                                                      foreach($teamleadmanagerprd as $prd):
                                                    ?>
                                                        <div class="col-md-3" style="margin-bottom:15px;">
                                                            <span style="border: 1px solid #ebebeb;padding: 5px;float: left;width: 100%;text-align: center;">
                                                                <input type="checkbox" value="<?= $prd["productid"]; ?>" name="productcode[]"> <lable><?= $prd["prodctCode"]; ?></label>
                                                            </span>
                                                        </div>
                                                    <?php
                                                      endforeach;
                                                    ?>
                                               </div>
                                              <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'productcode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Bank Account Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="accntnum" value="<?= set_value('accntnum'); ?>" Placeholder="Account Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'accntnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Bank IFSC Code<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ifsccode" value="<?= set_value('ifsccode'); ?>" Placeholder="IFSC Code" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'ifsccode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Bank Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="bankname" value="<?= set_value('bankname'); ?>" Placeholder="Bank Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'bankname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Aadhar Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="aadhrnum" value="<?= set_value('aadhrnum'); ?>" Placeholder="Aadhar Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'aadhrnum'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="aadharproof" value="<?= set_value('aadharproof'); ?>" title="Aadhar Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'aadharproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">PAN Card Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="pannum" value="<?= set_value('pannum'); ?>" Placeholder="Pan Card Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pannum'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="panproof" value="<?= set_value('panproof'); ?>" title="Pan Card Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Driving Licence Details</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="drivinglicence" value="<?= set_value('drivinglicence'); ?>" Placeholder="Driving Licence Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'drivinglicence'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="drivingproof" value="<?= set_value('drivingproof'); ?>" title="Driving Licence Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'drivingproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="card-title mb-1 card-flt">Nominee Details</h6>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomefname" value="<?= set_value('nomefname'); ?>" Placeholder="Nominee First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomefname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomelname" value="<?= set_value('nomelname'); ?>" Placeholder="Nominee Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomelname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Relationship With Manager<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="reltnwthmngr" style="max-width:50%; font-weight: 500">
                                                    <option value="Mother" style="font-weight: 500">Mother</option>
                                                    <option value="Father" style="font-weight: 500">Father</option>
                                                    <option value="Brother" style="font-weight: 500">Brother</option>
                                                    <option value="Sister" style="font-weight: 500">Sister</option>
                                                    <option value="Wife" style="font-weight: 500">Wife</option>
                                                    <option value="Son" style="font-weight: 500">Son</option>
                                                    <option value="Daughter" style="font-weight: 500">Daughter</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'reltnwthmngr'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomecntctnum" value="<?= set_value('nomecntctnum'); ?>" Placeholder="Nominee Contact Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomecntctnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">ID Proof<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" name="nomeidproof" value="<?= set_value('nomeidproof'); ?>" title="Nominee Id Proof(PAN Card, Aadhar Card, Driving Licence)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomeidproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info" value="Add Sales Agent">
                                        </div>
									</form>
                                </div>                                    
								</div>
								</div>
							</div>
						</div>
					</div>				
                </div>
			</div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/teamlead/js.php'); ?>
    </body>
</html>



















