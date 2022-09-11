<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/adminPanel/css.php'); ?>
  
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
    
     .table-data {
      font-weight: 450;
      font-size: 13px;
      text-align: center;
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
					<div class="row" style="margin-top: -8px">
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
                                  
                                <?php
								  foreach($productdata as $productdata);
                                ?>
                                <div class="col-lg-12 col-md-12" style="padding-bottom: 50px;">	
                                    <div>
										<h6 class="card-title mb-1 card-flt">Edit Product ( <?= $productdata["prodctCode"]; ?> )</h6>
									</div>
									<form action ="<?= base_url(); ?>/secure/editproduct/<?= $productdata["productid"]; ?>" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Fastag Class<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select name="prdclass" class="form-control" style="max-width:50%;">
                                                    <option value=""> Select Fastag Class</option>  
                                                    <?php 
                                                        foreach($claassftag as $clsftag):
                                                           if($clsftag["classoftag"] !=""){
                                                    ?>
                                                          <option <?php if($productdata["fastagClass"] == $clsftag["classoftag"]){ echo"selected";} ?> value="<?= $clsftag["classoftag"]; ?>"><?= $clsftag["classoftag"]; ?></option>
                                                    <?php
                                                           }
                                                       endforeach;
                                                    ?>  
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'prdclass'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Class Of Vehicle<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select name="clsvehcl" class="form-control" style="max-width:50%;">
                                                    <option value=""> Select Class Of vehicle</option>  
                                                    <?php 
                                                        foreach($classofvehicle as $vehclclass):
                                                    ?>
                                                          <option <?php if($productdata["classofvehicle"] == $vehclclass["classofbarcode"]){ echo"selected";} ?> value="<?= $vehclclass["classofbarcode"]; ?>"><?= $vehclclass["classofbarcode"]; ?></option>
                                                    <?php
                                                       endforeach;
                                                    ?>  
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'clsvehcl'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Product Code<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="prdcode" value="<?= $productdata["prodctCode"]; ?>" Placeholder="Product Code" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'prdcode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Price<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="price" value="<?= $productdata["fastagprice"]; ?>" Placeholder="Price" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'price'); ?> <?php } ?> </span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Initial Amount<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="initialamt" value="<?= $productdata["initialPayment"]; ?>" Placeholder="Initial Amount" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'initialamt'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Minimum Amount<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="minamount" value="<?= $productdata["minamount"]; ?>" Placeholder="Minimum Amount" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'minamount'); ?> <?php } ?> </span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Deposit Amount<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="depositamnt" value="<?= $productdata["depositamnt"]; ?>" Placeholder="Deposit Amount" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'depositamnt'); ?> <?php } ?> </span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Card Cost<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="cardcost" value="<?= $productdata["cardcost"]; ?>" Placeholder="Card Cost" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'cardcost'); ?> <?php } ?> </span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">Total Cost<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="totalcost" value="<?= $productdata["totalcost"]; ?>" Placeholder="Total Cost" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'totalcost'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">CBS Cost<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="number" name="cbscost" value="<?= $productdata["cbscost"]; ?>" Placeholder="CBS Cost" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'cbscost'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info" value="Update Product">
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



















