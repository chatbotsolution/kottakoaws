<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Odisha Bazaar - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/teamlead/css.php'); ?>
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
                <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div>
					<div class="row">
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
										<h6 class="card-title mb-1 card-flt">Update sales agent</h6>
									</div>
                                    <?php foreach($editprofileData as $usr); ?>
                                    
									<form action ="<?= base_url(); ?>/teamlead/editprofile" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Profile Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="profileimg" value="<?= set_value('profileimg'); ?>" class="form-control mg-b-10" style="max-width:50%;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fname" value="<?= $usr["Fname"]; ?>" Placeholder="First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lname" value="<?= $usr["Lname"]; ?>" Placeholder="Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumprim" value="<?= $usr["ContactPrimary"]; ?>" Placeholder="Contact Number(Primary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumprim'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumsec" value="<?= $usr["ContactSecondary"]; ?>" Placeholder="Contact Number(Secondary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumsec'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Permitted No. Of Id Creation<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="noidcrtn" value="<?= $usr["allowedIdCreation"]; ?>" Placeholder="Permitted Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'noidcrtn'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Toll or City<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select  class="form-control mg-b-10" style="max-width:50%;" name="tollncity">
                                                    <option <?php if($usr["toll&city"] == "Toll"){ echo"selected"; } ?> value="Toll">Toll</option>
                                                    <option <?php if($usr["toll&city"] == "City"){ echo"selected"; } ?> value="City">City</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'tollncity'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Account Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="accntnum" value="<?= $usr["accountNumber"]; ?>" Placeholder="Account Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'accntnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank IFSC Code<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ifsccode" value="<?= $usr["IFSCCode"]; ?>" Placeholder="IFSC Code" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'ifsccode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="bankname" value="<?= $usr["bankName"]; ?>" Placeholder="Bank Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'bankname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Aadhar Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="aadhrnum" value="<?= $usr["aadharNumber"]; ?>" Placeholder="Aadhar Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'aadhrnum'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="aadharproof" value="<?= set_value('aadharproof'); ?>" title="Aadhar Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'aadharproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">PAN Card Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="pannum" value="<?= $usr["panCardNumber"]; ?>" Placeholder="Pan Card Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pannum'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="panproof" value="<?= set_value('panproof'); ?>" title="Pan Card Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Driving Licence Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="drivinglicence" value="<?= $usr["drivingLicenceNumber"]; ?>" Placeholder="Driving Licence Number" class="form-control mg-b-10">
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
                                            <label class="col-sm-2 col-form-label">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomefname" value="<?= $usr["firstName"]; ?>" Placeholder="Nominee First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomefname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomelname" value="<?= $usr["lastName"]; ?>" Placeholder="Nominee Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomelname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Relationship With Manager<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="reltnwthmngr" style="max-width:50%;">
                                                    <option <?php if($usr["relationWith"] == "Mother"){ echo"selected"; } ?> value="Mother">Mother</option>
                                                    <option <?php if($usr["relationWith"] == "Father"){ echo"selected"; } ?> value="Father">Father</option>
                                                    <option <?php if($usr["relationWith"] == "Brother"){ echo"selected"; } ?> value="Brother">Brother</option>
                                                    <option <?php if($usr["relationWith"] == "Sister"){ echo"selected"; } ?> value="Sister">Sister</option>
                                                    <option <?php if($usr["relationWith"] == "Wife"){ echo"selected"; } ?> value="Wife">Wife</option>
                                                    <option <?php if($usr["relationWith"] == "Son"){ echo"selected"; } ?> value="Son">Son</option>
                                                    <option <?php if($usr["relationWith"] == "Daughter"){ echo"selected"; } ?> value="Daughter">Daughter</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'reltnwthmngr'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomecntctnum" value="<?= $usr["contactNumber"]; ?>" Placeholder="Nominee Contact Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomecntctnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Id Proof</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="nomeidproof" value="<?= set_value('nomeidproof'); ?>" title="Nominee Id Proof(PAN Card, Aadhar Card, Driving Licence)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomeidproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                            
											<input type="submit" class="btn btn-main-primary" style="width:10%;" value="Update Sales Agent">
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