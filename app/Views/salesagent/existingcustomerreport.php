<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
  
  <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
    
    .table-data {
      font-weight: 450;
      font-size: 11px;
      text-align: center;
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
			    <?= $this->include('partials/salesagent/headerLogo.php'); ?>
				<?= $this->include('partials/salesagent/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/salesagent/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/salesagent/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/salesagent/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/salesagent/headProfile.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
               <!--  <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div>-->
					<div class="row" style="margin-top: 8px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row" style="overflow: scroll;">
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
                                    <div class="col-lg-12 col-md-12 table-responsive" style="margin-top:40px;">
                                      <div class="row" style="margin-bottom:20px;float:right;">
                                        <a href="<?= base_url(); ?>/salesagent/downloadreportext">
                                          <button class="btn btn-sm btn-info">
                                              Download Report (PDF)
                                          </button>
                                        </a>
                                      </div>
                                    <table class="table-data table table-bordered" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">Customer Name</th>
                                                <th style="padding: 10px 10px;">Customer Id</th>
												<th style="padding: 10px 10px;">Mobile Number</th>
                                                <th style="padding: 10px 10px;"> Vehicle / Chassis Number</th>
                                                <th style="padding: 10px 10px;">Bar Code</th>
                                                <th style="padding: 10px 10px;">TAG Id</th>
                                                <th style="padding: 10px 10px;">TID</th>
                                                <th style="padding: 10px 10px;">Date Of Activation</th>
                                                <th style="padding: 10px 10px;">Time Of Activation</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php
											if(sizeof($customer) == 0){
                                              
                                            }else{
                                              
                                               $i=0;  
											   $j=0;                                               
                                               foreach($customer as $detailss):
                                               $i++;
                                         ?>
                                          	
                                            <tr>
                                                <th> <?= $i; ?> </th>
												<th> <?= $detailss["customername"]; ?> </th>
                                                <th> <?= $detailss["customerid"]; ?> </th>
                                                <th> <?= $detailss["mobileNumber"]; ?> </th>
                                                <th> <?= $detailss["vehiclechasisnumber"]; ?> </th>
                                                <th> <?= $detailss["barcodeid"]; ?> </th>
                                                <th> <?php if(sizeof($fstgdetls[$j]) != 0){ ?> <?= $fstgdetls[$j][0]["tagid"]; ?> <?php } ?> </th>
                                                <th> <?php if(sizeof($fstgdetls[$j]) != 0){ ?> <?= $fstgdetls[$j][0]["tid"]; ?> <?php } ?> </th>
                                                <th> <?= date("d-m-Y", strtotime($detailss["datetime"])); ?> </th>
                                                <th> <?= date("h:i:s", strtotime($detailss["datetime"])); ?> </th>
                                                <th id="balcls<?= $i; ?>"> <button class="btn btn-sm btn-info" onclick="getbal('<?= $detailss["mobileNumber"]; ?>','<?= $i; ?>');"> Get Balance </button></th>
                                            </tr>
                                          
                                         <?php 
                                               $j++;
                                               endforeach;
                                            }
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
        <?= $this->include('partials/salesagent/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>

 function getbal(val,val1){
   var getBaltel = val;
   
   $.ajax({
     type:'post',
     url:'<?= base_url(); ?>/salesagent/newcustomerreport',
     data:{getBaltel:getBaltel},
     success: function(data){
       $("#balcls" + val1).html("Rs. "+ data);
     }
   });
 }

</script>


















