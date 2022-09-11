<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
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
                                <div class="col-lg-12 col-md-12" style="padding-bottom: 50px;">	
                                    <div>
										<h6 class="card-title mb-1 card-flt">Profile</h6>
									</div>
                                    <div class="row">
                                        <div class="col-md-12 text-center"> 
                                            <img src ="<?= base_url(); ?>/public/adminasset/img/teamlead/profileimage/<?php if($profileData["ProfileImage"] == "default"){ echo"default_user.jpg"; }else{ echo $profileData["ProfileImage"]; }; ?>" style="width:300px;">
                                        </div>
                                    </div>
                                    <div>
										<h6 class="card-title mb-1 card-flt">Personal Information</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Registration Number <span><?= $profileData["TleadRegdNum"]; ?></span> </p>											
										</div>
										<div class="col-md-6">										
										</div>
										<div class="col-md-6">
											<p> First name <span><?= $profileData["Fname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Last name <span><?= $profileData["Lname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Primary Contact <span><?= $profileData["ContactPrimary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Secondary Contact <span><?= $profileData["ContactSecondary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Allowed Number Of Id Creation <span><?= $profileData["allowedIdCreation"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Toll Or City <span><?= $profileData["toll&city"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Profile Status <span><?php if($profileData["status"] ==0){ echo"ACTIVE";}else{ echo"BLOCKED";}; ?></span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt">KYC Details
											<?php
												if($profileData["kycStatus"] == 0 && $_SESSION["logged_intype"] == 2)
												{
											?>
												<span style="float:right;"> <button class="btn btn-sm btn-success">VEIFY</button> </span>
											<?php 
												}
											?>
										</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Aadhar Number <span><?= $profileData["aadharNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Aadhar Card Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/teamlead/aadharcard/<?= $profileData["aadharProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span><?= $profileData["panCardNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/teamlead/pancard/<?= $profileData["panCardProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Driving Licence <span><?= $profileData["drivingLicenceNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Driving Licence Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/teamlead/drivinglicence/<?= $profileData["drivingLicenceProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> KYC Status <span><?php if($profileData["kycStatus"] == 0){ echo "PENDING"; }else if($profileData["kycStatus"] == 1){ echo"FAILED"; }else{ echo "SUCCESS";}; ?></span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt">Bank Details
									    <?php
										     if($profileData["bankkycStatus"] == 0 && $_SESSION["logged_intype"] == 2)
											 {
										?>
										    <span style="float:right;"> <button class="btn btn-sm btn-success">VEIFY</button> </span>
										<?php 
										     }
										?>
										</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Bank Name <span><?= $profileData["bankName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Account Number <span><?= $profileData["accountNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> IFSC Code <span><?= $profileData["IFSCCode"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Bank Verification Status <span><?php if($profileData["bankkycStatus"] == 0){ echo "PENDING"; }else if($profileData["bankkycStatus"] == 1){ echo"FAILED"; }else{ echo "SUCCESS";}; ?></span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt">Nominee Details</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> First Name <span><?= $profileData["firstName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Last Name <span><?= $profileData["lastName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Relationship With Nominee <span><?= $profileData["relationWith"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Contact Number <span><?= $profileData["contactNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Id Proof <span> <a href="<?= base_url(); ?>/public/adminasset/img/teamlead/nomeedata/<?= $profileData["idProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
									</div>
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