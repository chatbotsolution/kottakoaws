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
                                    <div class="col-lg-12 col-md-12" style="margin-top:40px;">
                                    <table class="table table-bordered" id="users-list">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
												<th>Regd. Id</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Toll & City</th>
                                                <th>Allowed Id Creation</th>
                                                <th>Requested By Regd No</th>
                                                <th>Date / Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;
                                                foreach($teamleaddata as $saledata):
                                                    $i++;
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $saledata["TleadRegdNum"]; ?></td>
                                                    <td><?= $saledata["Fname"].' '.$saledata["Lname"]; ?></td>
                                                    <td><?= $saledata["ContactPrimary"]; ?></td>
                                                    <td><?= $saledata["toll&city"]; ?></td>
                                                    <td><?= $saledata["allowedIdCreation"]; ?></td>
                                                    <td><a href="<?= base_url(); ?>/secure/managesalesmanager/<?= $saledata["salesManagerId"]; ?>" target="_blank">  <?= $saledata["RegdNum"]; ?> </a> </td>
                                                    <td><?= date("d-m-Y / h:i:s", strtotime($saledata["datetime"])); ?></td>
                                                    <td>
													<a href="<?= base_url(); ?>/secure/manageteamlead/<?= $saledata["teamleadId"]; ?>"> <button class="btn btn-sm btn-info"> View </button> </a>
                                                    <a href="<?= base_url(); ?>/secure/updtstatus/<?= $saledata["teamleadId"]; ?>/0">    <button class="btn btn-sm btn-success"> Approve </button> </a>
                                                    <a href="<?= base_url(); ?>/secure/updtstatus/<?= $saledata["teamleadId"]; ?>/3">    <button class="btn btn-sm btn-danger"> Decline </button> </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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



















