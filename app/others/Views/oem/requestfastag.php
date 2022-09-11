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
                                            <h6 class="card-title mb-1 card-flt">Add Product</h6>
                                        </div>
                                        <form action ="<?= base_url(); ?>/oem/requestfastag" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Fastag Class<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <select name="prdclass" class="form-control" style="max-width:50%;">
                                                        <option value=""> Select Fastag Class</option>  
                                                        <?php 
                                                            foreach($claassftag as $clsftag):
                                                        ?>
                                                            <option value="<?= $clsftag["classoftag"]; ?>"><?= $clsftag["classoftag"]; ?></option>
                                                        <?php
                                                        endforeach;
                                                        ?>  
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'prdclass'); ?> <?php } ?> </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Number Of Fastag<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="nofatag" value="<?= set_value('nofatag'); ?>" Placeholder="No Of Fastag" class="form-control mg-b-10" style="max-width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nofatag'); ?> <?php } ?> </span>
                                                </div>
                                            </div>                                        
                                            <div class="col-md-12">                                            
                                                <input type="submit" class="btn btn-main-primary" style="width:10%;" value="Send Request">
                                            </div>
                                        </form>                                    
                                    </div>   
                                    <div class="col-md-12 col-lg-12">
                                         <table class="table table-bordered">
                                             <thead>
                                                <tr>
                                                    <th>SL No. </th>
                                                    <th>Class Of Tag</th>
                                                    <th>Number Of Tag</th>
                                                    <th>Status</th>
                                                    <th>Requested On</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                 <?php
                                                    foreach($oemreqst as $rqst):
                                                        $i=1;

                                                        if($rqst["status"] == 0){
                                                            $sts="Pending";
                                                        }else if($rqst["status"] == 1){
                                                            $sts="Approved";
                                                        }else{
                                                            $sts="Declined";
                                                        }
                                                 ?>
                                                 <tr>
                                                     <td> <?= $i; ?> </td>
                                                     <td> <?= $rqst["classoftag"]; ?> </td>
                                                     <td> <?= $rqst["numberoffastag"]; ?> </td>
                                                     <td> <?= $sts; ?> </td>
                                                     <td> <?= date("d-m-Y", strtotime($rqst["datetime"])); ?> </td>
                                                 </tr>
                                                 <?php
                                                    $i++;
                                                   endforeach;
                                                 ?>
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
        <?= $this->include('partials/oem/js.php'); ?>
    </body>
</html>



















