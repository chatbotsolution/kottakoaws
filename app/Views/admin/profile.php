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
                                    <div class="row">
                                        <div class="col-md-12 text-center"> 
                                            <img src ="<?= base_url(); ?>/public/adminasset/img/faces/<?= $profile["image"]; ?>" style="width:300px;">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-4"> 
                                            
                                        </div>
                                        <div class="col-md-4"> 
                                            <p>NAME : <?= $profile["name"]; ?></p>
                                            <p>EMAIL : <?= $profile["email"]; ?></p>
                                            <p>CONTACT : <?= $profile["contact_number"]; ?></p>
                                            <p>USER ID : <?= $profile["userid"]; ?></p>
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