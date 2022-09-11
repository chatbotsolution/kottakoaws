<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/oem/css.php'); ?>
</head>

    <body class="main-body app sidebar-mini" onload="updtTime();">
   
        <div class="page">
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
			    <?= $this->include('partials/oem/headerLogo.php'); ?>
				<?= $this->include('partials/oem/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/oem/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/oem/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/oem/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/oem/headProfile.php'); ?>
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
										    <?php
											    if($profileData["ProfileImage"] =="default"){
													$prof="default_user.jpg";
												}else{
													$prof=$profileData["ProfileImage"];
												}
												 ?>
                                            <img src ="<?= base_url(); ?>/public/adminasset/img/salesagent/profileimage/<?= $prof; ?>" style="width:300px;">
                                        </div>
                                    </div>
                                    <div>
										<h6 class="card-title mb-1 card-flt">OEM Information</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Company Name <span><?= $profileData["companyname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">										
										</div>
										<div class="col-md-6">
											<p> Trade Name <span><?= $profileData["tradename"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> GST Number <span><?= $profileData["gstnumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span><?= $profileData["pancardnumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> SPOC Number <span><?= $profileData["spocnumber"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> SPOC Details <span><?= $profileData["spocdetails"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> GM Name <span><?= $profileData["gmname"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> GM Contact Number <span><?= $profileData["gmcontact"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> GST Certificate <span> <a href="<?= base_url(); ?>/public/adminasset/oemdocument/<?= $profileData["gstcertificate"]; ?>" download> <i class="fa fa-download"></i> </a> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Manufacturer <span><?= $profileData["manufacturername"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> No Of Branch <span><?= $profileData["noofbranch"]; ?></span> </p>											
										</div>
										<div class="col-md-6">
											<p> HOD City <span><?= $profileData["hodcity"]; ?></span> </p>											
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
        <?= $this->include('partials/oem/js.php'); ?>
    </body>
</html>