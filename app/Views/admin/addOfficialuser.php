<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/adminPanel/css.php'); ?>
  
  <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
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
                  <!-- 
                	<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div>
                  -->
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
										<h6 class="card-title mb-1 card-flt">Add User</h6>
									</div>
									<form action ="<?= base_url(); ?>/secure/addofficialuser" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Profile Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="profileimg" value="<?= set_value('profileimg'); ?>" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'profileimg'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Login User Id<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="usrid" value="<?= set_value('usrid'); ?>" Placeholder="Login User Id" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'usrid'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fname" value="<?= set_value('fname'); ?>" Placeholder="First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lname" value="<?= set_value('lname'); ?>" Placeholder="Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumprim" value="<?= set_value('contctnumprim'); ?>" Placeholder="Contact Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumprim'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Email<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" value="<?= set_value('email'); ?>" Placeholder="Email" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'email'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Password<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" name="pass" value="<?= set_value('pass'); ?>" Placeholder="Password" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pass'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                      
                                      	<div class="form-group row" style="padding: 10px;border: 1px solid #dddddd;">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Select Privilege<span style="color: red">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="privilege[]" value="edit"> <label> Edit </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="privilege[]" value="view"> <label> View </label>
                                            </div>
                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'privilege'); ?> <?php } ?> </span>
                                        </div>
                                      	<div class="form-group row" style="padding: 10px;border: 1px solid #dddddd;">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500">Select Module<span style="color: red">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="fastag"> <label> Fastag </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="product"> <label> Product </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="users"> <label> Users (SM,TL,FSE,OEM) </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="wallet"> <label> Wallet </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="pin"> <label> PIN Code </label>
                                            </div>
                                            <div class="col-sm-2">
                                                &nbsp;
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="banner"> <label> Banner </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="report"> <label> Report </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="vehclupdtrqst"> <label> Vehicle Update Request </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" name="module[]" value="permissionletter"> <label> Permission Letter Request </label>
                                            </div>
                                          
                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'module'); ?> <?php } ?> </span>
                                        </div>
                                      
                                      
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info" value="Add Official User">
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
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
</html>



















