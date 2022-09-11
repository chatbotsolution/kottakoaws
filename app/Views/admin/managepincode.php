<!--DOCTYPE html-->
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
    
    .table-data {
      font-weight: 450;
      font-size: 11px;
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
                                    <div class="col-lg-12 col-md-12" style="margin-top:0px;">
                                      <div>
										<h6 class="card-title mb-1 card-flt">Add PIN Code</h6>
									</div>
									<form action ="<?= base_url(); ?>/secure/managepincode" method="post" autocomplete="off" enctype='multipart/form-data'?>                                        
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <input type="text" name="pincode" value="<?= set_value('pincode'); ?>" Placeholder="PIN Code" class="form-control mg-b-10">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincode'); ?> <?php } ?> </span>
                                            </div>
                                          	<div class="col-sm-4">
                                                <input type="submit" class="btn btn-info">
                                            </div>
                                        </div>
                                    </form>
                                    <form action ="<?= base_url(); ?>/secure/managepincode" method="post" autocomplete="off" enctype="multipart/form-data" ?>    
                                        <div>
                                            <h6 class="card-title mb-1 card-flt">Upload PIN Code</h6>
                                        </div>                             
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: 500;">PIN Code CSV <span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="file" name="file" value="<?= set_value('file'); ?>" title="CSV File Permitted" class="form-control mg-b-10" style="max-width:50%;">
                                                <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'file'); ?> <?php } ?> </span>
                                              <input type="hidden" name="uploadcsv" value="100">
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info rounded-corner" value="Add PIN Code">
                                        </div>
									</form>
                                    <table class="table table-bordered table-data" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">PIN Code</th>
                                                <th style="padding: 10px 10px;">Date / Time</th>
                                                <th style="padding: 10px 10px;">Status</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
											  $i=0;
                                              foreach($pincode as $pincode):
											  $i++;
 										  ?>
                                            <tr>
                                                <td> <?= $i; ?> </td>
                                                <td> <?= $pincode["pincode"]; ?> </td>
                                                <td> <?= date("d-m-Y / h:i:s", strtotime($pincode["datetime"])); ?> </td>
                                                <td> <?php if($pincode["status"] == 0){ echo"ACTIVE"; }else{ echo"BLOCKED"; } ?> </td>
                                                <td>
                                                     <?php 
                                                        if($pincode["status"] == 0){
                                                     ?>
                                                  	    <button class="btn btn-sm btn-info" onclick="chngsts('<?= $pincode["pincodeid"]; ?>','1');"> BLOCK </button>
                                                     <?php }else{ ?>
                                                        <button class="btn btn-sm btn-info" onclick="chngsts('<?= $pincode["pincodeid"]; ?>','0');"> UN-BLOCK </button>
                                                     <?php } ?>                                                     
                                                </td>
                                            </tr>
                                           <?php
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
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
   
</html>

<script>

     function chngsts(val,val1){
       
       var changeid = val;
       var changeval = val1;
       
       $.ajax({
         type:'post',
         url:'<?= base_url(); ?>/secure/managepincode',
         data:{changeid:changeid,changeval:changeval},
         success: function(data){
           location.reload();
         }
       });
       
     }

</script>