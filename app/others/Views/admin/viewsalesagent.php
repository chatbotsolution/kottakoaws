<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/adminPanel/css.php'); ?>
</head>

    <body class="main-body app sidebar-mini" onload="updtTime();">
   
        <div class="page">
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
			    <?= $this->include('partials/adminPanel/headerLogo.php'); ?>
				<?= $this->include('partials/adminPanel/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/adminPanel/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/adminPanel/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/adminPanel/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/adminPanel/headProfile.php'); ?>
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
                                    <?php foreach($salesagent as $sales); ?>
                                    <div class="row">
                                        <div class="col-md-12 text-center"> 
                                            <img src ="<?= base_url(); ?>/public/adminasset/img/salesagent/profileimage/<?php if($sales["ProfileImage"] == "default"){ echo"default_user.jpg"; }else{ echo $sales["ProfileImage"]; }; ?>" style="width:300px;">
                                        </div>
                                    </div>
                                    <div>
										<h6 class="card-title mb-1 card-flt">Personal Information</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Registration Number <span><?= $sales["salesAgentRegdNum"]; ?></span> </p>											
										</div>
										<div class="col-md-6">										
										</div>
										<div class="col-md-6">
											<p> First name <span><?= $sales["Fname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Last name <span><?= $sales["Lname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Primary Contact <span><?= $sales["ContactPrimary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Secondary Contact <span><?= $sales["ContactSecondary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Email Id <span><?= $sales["salesagentmailid"]; ?></span> </p>											
										</div>
                                        <div class="col-md-6">
											<p> Region Of Sale <span><?= $sales["region"]; ?></span> </p>											
										</div>
                                        <div class="col-md-6">
											<p> Allowed Number Of ID Creation <span><?= $sales["allowedIdCreation"]; ?></span> </p>											
										</div>
                                        <div class="col-md-6">
											<p> Toll & City <span><?= $sales["toll&city"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Profile Status <span><?php if($sales["status"] ==0){ echo"ACTIVE";}else{ echo"BLOCKED";}; ?></span> </p>											
										</div>
									</div>  
                                    <div>
										<h6 class="card-title mb-1 card-flt">KYC Details</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Aadhar Number <span><?= $sales["aadharNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Aadhar Card Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/salesagent/aadharcard/<?= $sales["aadharProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span><?= $sales["panCardNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/salesagent/pancard/<?= $sales["panCardProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Driving Licence <span><?= $sales["drivingLicenceNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Driving Licence Document <span> <a href="<?= base_url(); ?>/public/adminasset/img/salesagent/drivinglicence/<?= $sales["drivingLicenceProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> KYC Status <span><?php if($sales["kycStatus"] == 0){ echo "PENDING"; }else if($sales["kycStatus"] == 1){ echo"FAILED"; }else{ echo "SUCCESS";}; ?></span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt">Bank Details</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Bank Name <span><?= $sales["bankName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Account Number <span><?= $sales["accountNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> IFSC Code <span><?= $sales["IFSCCode"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Bank Verification Status <span><?php if($sales["bankkycStatus"] == 0){ echo "PENDING"; }else if($sales["bankkycStatus"] == 1){ echo"FAILED"; }else{ echo "SUCCESS";}; ?></span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt">Nominee Details</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> First Name <span><?= $sales["firstName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Last Name <span><?= $sales["lastName"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Relationship With Nominee <span><?= $sales["relationWith"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Contact Number <span><?= $sales["contactNumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Id Proof <span> <a href="<?= base_url(); ?>/public/adminasset/img/salesagent/nomeedata/<?= $sales["idProof"]; ?>" download> <i class="fa fa-download" title="Download File"></i> </a> </span> </p>											
										</div>
									</div>

									<div>
										<h6 class="card-title mb-1 card-flt">Product Details</h6>
									</div>
									<?php
									 foreach($salesmanagerPrd as $prd): 
									?>
									<div class="row nc" style="border: 1px solid #e5e3e3;padding: 10px;margin-bottom: 10px;">
										<div class="col-md-6">
											<p> Product Code <span><?= $prd["prodctCode"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Fastag Class <span><?= $prd["fastagClass"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Price <span>Rs. <?= $prd["fastagprice"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Initial Payment <span> Rs. <?= $prd["initialPayment"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Status <span> <?php if($prd["status"] == 0){ echo "Active"; }else{ echo"Blocked"; }?> </span> </p>											
										</div>
									</div>
									<?php
									 endforeach; 
									?>

                                    <div>
										<h6 class="card-title mb-1 card-flt">Request By Information</h6>
									</div>
                                    <?php foreach($salesreqst1 as $salesreqst); ?>
									<div class="row nc">
										<div class="col-md-6">
											<p> Registration Number <span><?= $salesreqst["TleadRegdNum"]; ?></span> </p>											
										</div>
										<div class="col-md-6">										
										</div>
										<div class="col-md-6">
											<p> First name <span><?= $salesreqst["Fname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Last name <span><?= $salesreqst["Lname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Primary Contact <span><?= $salesreqst["ContactPrimary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Secondary Contact <span><?= $salesreqst["ContactSecondary"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Email Id <span><?= $salesreqst["teamleademailid"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Profile Status <span><?php if($salesreqst["status"] == 0){ echo "Active"; }else if($salesreqst["status"] == 1){ echo"Blocked"; }else{ echo "Pending Request";}; ?></span> </p>											
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
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
</html>



















