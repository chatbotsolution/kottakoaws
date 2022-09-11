<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
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
											<h6 class="card-title mb-1 card-flt">NPCI Tag Status Check</h6>
										</div>
										<form action ="<?= base_url(); ?>/oem/ncpitag" method="post" autocomplete="off" enctype="multipart/form-data" ?>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Enter Vehicle Registration Number</label>
												<div class="col-sm-9">
													<input type="text" name="vehicleNumber" value="<?= set_value('vehicleNumber'); ?>" class="form-control mg-b-10" style="max-width:50%;">
													<span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehicleNumber'); ?> <?php } ?> </span>
												</div>
											</div>
											<div class="col-md-12">                                            
												<input type="submit" class="btn btn-main-primary" style="width:10%;" value="Search Status">
											</div>
										</form>
									</div> 
									<div class="col-md-12 col-lg-12">
										<div class="row">
											<div class="col-md-1 col-lg-1">&nbsp;</div>
											<div class="col-md-8 col-lg-8">	
												<?php
													if(isset($npceiresponse)){
														$data = json_decode($npceiresponse)[0];
														$array = json_decode(json_encode($data), true);
														if($array['STATUS'] == "Success"){
												?>									  
												<table class="table table-bordered">
													<tr>
														<td> <strong> Tag Id</strong> <br> <?= $array['NPCIVehicleDetails'][0]['TID']; ?> </td>
														<td> <strong> Vehicle Number </strong> <br> <?= $array['NPCIVehicleDetails'][0]['REGNUMBER']; ?> </td>
													</tr>
													<tr>
														<td> <strong> Vehicle Class</strong> <br> <?= $array['NPCIVehicleDetails'][0]['VEHICLECLASS']; ?> </td>
														<td> <strong> Tag Status </strong> <br> <?= $array['NPCIVehicleDetails'][0]['TAGSTATUS']; ?> </td>
													</tr>
													<tr>
														<td> <strong> Issue Date </strong> <br> <?= $array['NPCIVehicleDetails'][0]['ISSUEDATE']; ?> </td>
														<td> <strong> Exc Code</strong> <br> <?= $array['NPCIVehicleDetails'][0]['EXCCODE']; ?> </td>
													</tr>
													<tr>
														<td> <strong> Bank Id </strong> <br> <?= $array['NPCIVehicleDetails'][0]['BANKID']; ?> </td>
														<td> <strong> Commercial Vehicle </strong> <br> <?= $array['NPCIVehicleDetails'][0]['COMVEHICLE']; ?> </td>
													</tr>
													<tr>
														<td> <strong> CCH </strong> <br> <?= $array['NPCIVehicleDetails'][0]['VEHICLECLASS']; ?> </td>
														<td> <strong> Activation Date </strong> <br> <?= $array['NPCIVehicleDetails'][0]['ISSUEDATE']; ?> </td>
													</tr>
												</table>												
												<?php
														}else if($array['STATUS'] == "FAILURE" && $array['ERRORDESC'] == "Vehicle Reg No not in DB"){
													   echo'<table class="table table-bordered">
																<tr>
																	<td> Vehicle Not Registered </td>
																</tr>
															</table>';
														}else{
													   echo'<table class="table table-bordered">
																<tr>
																	<td> Sorry ! Unable To Process Try Again Later </td>
																</tr>
															</table>';
														}
													}
												?>
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