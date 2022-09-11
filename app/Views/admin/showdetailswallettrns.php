<!--DOCTYPE html-->
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
					<div class="row" style="margin-top: -8px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row">
								<div class="card-body">	
                                  
                                  <span id="errmsg"></span>
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
                                        foreach($walletdetails as $wall);
								  ?>
                                  
                                <div class="col-lg-12 col-md-12" style="padding-bottom: 50px;">	
                                    <div>
										<h6 class="card-title mb-1 card-flt">Wallet Details</h6>
									</div>
									<div class="row nc">
										<div class="col-md-6">
											<p> Agent Name <span><?= $wall["Fname"].' '.$wall["Lname"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">										
										</div>
										<div class="col-md-6">
											<p> Amount <span><?= $wall["amount"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Transaction Id <span><?= $wall["transactionid"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
                                          <p> Balance Type <span><?php if($wall["transactiontype"] ==1){ echo"Credited"; }else if($wall["transactiontype"] ==2){ echo"Debited";} ?> </span> </p>											
										</div>
										<div class="col-md-6">
                                          <p> Status <span><?php if($wall["transactionstatus"] ==2){ echo"Success"; }else if($wall["transactionstatus"] ==1){ echo"Pending"; }else if($wall["transactionstatus"] ==3){ echo"Failed"; } ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Date <span><?= date("d-m-Y", strtotime($wall["datetime"])); ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Time <span><?= date("h : i : s a", strtotime($wall["datetime"])); ?> </span> </p>											
										</div>
									</div>
									<div>
										<h6 class="card-title mb-1 card-flt"> Transaction Details </h6>
									</div>
									<div class="row nc">
                                      <?php

                                          if(sizeof($transactiondetailsini) != 0){
                                            
                                            foreach($transactiondetailsini as $init);
                                      ?>                                                
										<div class="col-md-6">
											<p> Customer Name <span> <?= $init["customername"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Customer Mobile <span> <?= $init["mobileNumber"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Date Of Birth <span> <?= date("d-m-Y", strtotime($init["dateofbirth"])); ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span> <?= $init["pancarddetails"]; ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Driving Licence Number <span> <?= $init["drivingLicence"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Vehicle Number / Chassis Number <span> <?= $init["vehiclechasisnumber"]; ?> </span> </p>											
										</div>										
										<div class="col-md-6">
											<p> Barcode Number <span> <?= $init["barcodeid"]; ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
                                          <p> Transaction Status <span> <?php if($init["responsecode"] == 230201){ echo "Success"; }else{ echo $init["responsecode"]; } ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Date <span> <?= date("d-m-Y", strtotime($init["datetime"])); ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Time <span> <?= date("h : i : s a", strtotime($init["datetime"])); ?> </span> </p>											
										</div>
                                     <?php     
                                        }else if(sizeof($transactiondetailsext) != 0){    
                                            
                                            foreach($transactiondetailsext as $init);
                                     ?>
                                      
                                      	<div class="col-md-6">
											<p> Customer Name <span> <?= $init["customername"]; ?> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Customer Mobile <span> <?= $init["mobileNumber"]; ?> </span> </p>										
										</div>
										<div class="col-md-6">
											<p> Date Of Birth <span> NA </span> </p>										
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span> NA </span> </p>												
										</div>
                                      	<div class="col-md-6">
											<p> Driving Licence Number <span> NA </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Vehicle Number / Chassis Number <span> <?= $init["vehiclechasisnumber"]; ?> </span> </p>										
										</div>										
										<div class="col-md-6">
											<p> Barcode Number <span> <?= $init["barcodeid"]; ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Status <span> <?php if($init["statusTag"] == 230201){ echo "Success"; }else{ echo $init["statusTag"]; } ?> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Date <span> <?= date("d-m-Y", strtotime($init["datetime"])); ?> </span> </p>										
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Time <span> <?= date("h : i : s a", strtotime($init["datetime"])); ?> </span> </p>										
										</div>
                                      
                                     <?php     
                                        }else{                                      
                                     ?>
                                      
                                      	<div class="col-md-6">
											<p> Customer Name <span></span> </p>											
										</div>
										<div class="col-md-6">
											<p> Customer Mobile <span>  </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Date Of Birth <span></span> </p>											
										</div>
										<div class="col-md-6">
											<p> PAN Card Number <span> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Driving Licence Number <span> </span> </p>											
										</div>
										<div class="col-md-6">
											<p> Vehicle Number / Chassis Number <span></span> </p>											
										</div>										
										<div class="col-md-6">
											<p> Barcode Number <span> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Status <span> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Date <span> </span> </p>											
										</div>
                                      	<div class="col-md-6">
											<p> Transaction Time <span> </span> </p>											
										</div>
                                      
                                     <?php     
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
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>

</script>



















