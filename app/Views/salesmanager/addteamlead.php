<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesManager/css.php'); ?>
  
  
  <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
      font-weight: 500;
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
			    <?= $this->include('partials/salesManager/headerLogo.php'); ?>
				<?= $this->include('partials/salesManager/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/salesManager/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/salesManager/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/salesManager/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/salesManager/headProfile.php'); ?>
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
										<h6 class="card-title mb-1 card-flt">Add team lead</h6>
									</div>
									<form action ="<?= base_url(); ?>/salesmanager/addteamlead" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Profile Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="profileimg" value="<?= set_value('profileimg'); ?>" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'profileimg'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">First Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fname" value="<?= set_value('fname'); ?>" Placeholder="First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lname" value="<?= set_value('lname'); ?>" Placeholder="Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumprim" value="<?= set_value('contctnumprim'); ?>" Placeholder="Contact Number(Primary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumprim'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" onkeypress="if(this.value.length == 10){return false;}" name="contctnumsec" value="<?= set_value('contctnumsec'); ?>" Placeholder="Contact Number(Secondary)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contctnumsec'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email Id<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" value="<?= set_value('email'); ?>" Placeholder="Email Id" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'email'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Permitted No. Of Id Creation<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="noidcrtn" value="<?= set_value('noidcrtn'); ?>" Placeholder="Permitted Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'noidcrtn'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Target<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" style="max-width:50%;" name="teamldtarget">
                                                    <option value="1200">1200</option>
                                                    <option value="1500">1500</option>
                                                    <option value="1800">1800</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2500">2500</option>
                                                    <option value="3000">3000</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'teamldtarget'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Toll or City<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select  class="form-control mg-b-10" style="max-width:50%;" name="tollncity" onchange="shownofdta(this.value);">
                                                    <option value="">Select Toll Or City</option>
                                                    <option value="Toll">Toll</option>
                                                    <option value="City">City</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'tollncity'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row nofdta">
                                            <input type="hidden" onkeyup="showbox(this.value);" name="nopermitted" placeholder="Number Permitted" class="form-control mg-b-10" style="max-width:50%;">
                                        </div>
                                        <div class="form-group row novall">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Region Of Sales<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="regnsale" value="<?= set_value('regnsale'); ?>" Placeholder="Region Of Sales" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'regnsale'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Product<span style="color: red">*</span></label>
                                            <div class="col-sm-6">
                                               <div class="row">
                                                   <?php
                                                      foreach($salesmanagerprd as $prd):
                                                    ?>
                                                        <div class="col-md-2" style="margin-bottom:15px;">
                                                            <span style="border: 1px solid #ebebeb;padding: 5px;float: left;width: 100%;text-align: center;">
                                                                <input type="checkbox" value="<?= $prd["productid"]; ?>" name="productcode[]"> <lable><?= $prd["prodctCode"]; ?></label>
                                                            </span>
                                                        </div>
                                                    <?php
                                                      endforeach;
                                                    ?>
                                               </div>
                                               <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'productcode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Account Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="accntnum" value="<?= set_value('accntnum'); ?>" Placeholder="Account Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'accntnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank IFSC Code<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ifsccode" value="<?= set_value('ifsccode'); ?>" Placeholder="IFSC Code" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'ifsccode'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Bank Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="bankname" value="<?= set_value('bankname'); ?>" Placeholder="Bank Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'bankname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Aadhar Details<span style="color: red">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="aadhrnum" value="<?= set_value('aadhrnum'); ?>" Placeholder="Aadhar Number" class="form-control mg-b-10">
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
                                                <input type="text" name="pannum" value="<?= set_value('pannum'); ?>" Placeholder="Pan Card Number" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pannum'); ?> <?php } ?> </span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" name="panproof" value="<?= set_value('panproof'); ?>" title="Pan Card Proof" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Driving Licence Details</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="drivinglicence" value="<?= set_value('drivinglicence'); ?>" Placeholder="Driving Licence Number" class="form-control mg-b-10">
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
                                                <input type="text" name="nomefname" value="<?= set_value('nomefname'); ?>" Placeholder="Nominee First Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomefname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Last Name<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomelname" value="<?= set_value('nomelname'); ?>" Placeholder="Nominee Last Name" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomelname'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Relationship With Manager<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="reltnwthmngr" style="max-width:50%;">
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Wife">Wife</option>
                                                    <option value="Son">Son</option>
                                                    <option value="Daughter">Daughter</option>
                                                </select>
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'reltnwthmngr'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact Number<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nomecntctnum" onkeypress="if(this.value.length == 10){return false;}" value="<?= set_value('nomecntctnum'); ?>" Placeholder="Nominee Contact Number" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomecntctnum'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ID Proof<span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" name="nomeidproof" value="<?= set_value('nomeidproof'); ?>" title="Nominee Id Proof(PAN Card, Aadhar Card, Driving Licence)" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'nomeidproof'); ?> <?php } ?> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info" value="Add Team Lead">
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
        <?= $this->include('partials/salesManager/js.php'); ?>
    </body>
</html>
<script>

    function shownofdta(val){
        var type = val;

        $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesmanager/addteamlead',
        data:{showtype:type},
        success:function(data){
            $(".nofdta").html(data);}
        });
    }

    function showbox(val){
        if(val ==""){
          var type = 0;
        }else{
          var type = val;
        }
        val1=1;

        $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesmanager/addteamlead',
        data:{showval:type,showng:val1},
        success:function(data){
            $(".novall").html(data);}
        });
    }
</script>



















