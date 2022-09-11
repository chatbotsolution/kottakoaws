<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
    <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
  


  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
    
    .table-data {
      font-weight: 450;
      font-size: 13px;
      text-align: center;
    }
    
    .allocated-button:hover {
      background-color: red;
      color: #fff;
    }
    
    .dropdown-item:hover {
      color:fff;
      background-color: #B3E8E5;
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
                <!-- <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> 
					-->
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
                                  
                                    <div class="col-lg-12 col-md-12 table-responsive" style="margin-top:20px;">
                                      
                                      <div class="row" style="margin-bottom:20px">
                                           <div class="col-lg-6">
                                               <div class="dropdown">
                                                   <button class="allocated-button btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                       Download Report
                                                   </button>
                                                   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                       <a class="dropdown-item" href="#" style="font-weight:500;">Download Today's Report</a>
                                                       <a class="dropdown-item" href="#" style="font-weight:500;">Download Yesterday's Report</a>
                                                       <a class="dropdown-item" href="#" style="font-weight:500;">Download 15 Day's Report</a>
                                                       <a class="dropdown-item" href="#" style="font-weight:500;">Download 30 Day's Report</a>
                                                       <a class="dropdown-item" href="#" style="font-weight:500;"data-toggle="modal" data-target="#exampleModal">Custom Date Range</a>
                                                   </div>
                                               </div> 
                                           </div>
                                           <div class="col-lg-6" align="right">
                                               <a href="<?= base_url(); ?>/salesagent/downloadreportnew">
                                                   <button class="allocated-button btn btn-info">
                                                       Download Report (PDF)
                                                   </button>
                                               </a>
                                           </div>
                                       </div>
                                     <!-- <div class="row" style="margin-bottom:20px;float:right;"> 
                                        <h3>Test</h3>
                                         <a href="<?= base_url(); ?>/salesagent/downloadreportnew">
                                          <button class="btn btn-sm btn-info">
                                              Download Report (PDF)
                                          </button>
                                        </a>
                                      </div>-->
                                      <table class="table-data table table-bordered" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th>SL NO</th>
												<th>Customer Name</th>
                                                <th>Customer Id</th>
                                                <th>PAN Card Number</th>
                                                <th> Vehicle/ Chassis Number </th>
												<th>Mobile Number</th>
                                                <th>Bar Code</th>
                                                <th>TAG Id</th>
                                                <th>TID</th>
                                                <th>Date Of Activation</th>
                                                <th>Time Of Activation</th>
                                                <th>Action</th>
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
                                                <th> <?= $detailss["pancarddetails"]; ?> </th>
                                                <th> <?= $detailss["vehiclechasisnumber"]; ?> </th>
                                                <th> <?= $detailss["mobileNumber"]; ?> </th>
                                                <th> <?= $detailss["barcodeid"]; ?> </th>
                                                <th> <?php if(sizeof($fstgdetls[$j]) != 0){ echo $fstgdetls[$j][0]["tagid"]; } ?> </th>
                                                <th> <?php if(sizeof($fstgdetls[$j]) != 0){ echo $fstgdetls[$j][0]["tid"]; } ?></th>
                                                <th> <?= date("d-m-Y", strtotime($detailss["datetime"])); ?> </th>
                                                <th> <?= date("h:i:s", strtotime($detailss["datetime"])); ?> </th>
                                                <th id="balcls<?= $i; ?>"> <button class="allocated-button btn btn-sm btn-info" onclick="getbal('<?= $detailss["mobileNumber"]; ?>','<?= $i; ?>');"> Get Balance </button></th>
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
      
<!--  calender pop up -->
      
  <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="text-transform:uppercase;color:#F32424;margin:auto;">Choose Date</h5>
        <!-- 
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		-->
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6" style="display: grid;">
            <label style="font-weight: bold;">From</label>
            <input type="date" style="border: none;">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6" style="display: grid;">
            <label style="font-weight: bold;">To</label>
            <input type="date" style="border: none;">
          </div>
          
        </div>
        <!-- <input type="date" style="border: none;">
        <input type="date" style="border: none;"> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-primary">Download Report</a>
        <!-- <button type="button" class="btn btn-primary">Download</button> -->
      </div>
    </div>
  </div>
</div>
      
      <!--  calender pop up -->
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
  
  function bigImg(){
    //alert('helllo');
   $('#exampleModal').modal('show');
  }
  
 

</script>




















