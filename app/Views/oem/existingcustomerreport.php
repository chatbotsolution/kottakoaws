<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/oem/css.php'); ?>
  
  <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <style>
  	 body {
      font-family: "Montserrat", "Ubuntu";
      
    }
    
    .table-data {
      font-weight: 450;
      font-size: 11px;
      text-align: center;
      vertical-align: middle;
    }
    .allocated-button:hover {
      background-color: red;
      color: #fff;
    }
    .btn{
      font-size: 10px;
    }
    
  </style>
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
                	<!-- 
                            <div class="breadcrumb-header justify-content-between">
                                <div class="my-auto">
                                    <div class="d-flex">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>

    					-->
					<div class="row" style="margin-top: -10px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row" style="overflow:scroll;">
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
                                    <div class="col-lg-12 col-md-6 table-responsive-sm" style="overflow-x: auto;">
                                      <div class="row" style="margin-bottom:20px;">
                                        <div class="col-md-12 report-bx">
                                          <div class="row">
                                             <div class="col-md-3">
                                               <?php $date = date("Y-m-d"); $day_before = date( 'Y-m-d', strtotime( $date . ' -1 day' ) ); ?>
                                               <form action ="<?= base_url(); ?>/oem/searchdataext" method="post" autocomplete="off" enctype="multipart/form-data" ?>
                                                  <div class="form-group row">
                                                      <label class="form-label" style="font-weight: 500;margin-left: 5px;">Start Date</label>
                                                      <div class="col-sm-10">
                                                          <input type="date" data-date="" data-date-format="DD MMMM YYYY" name="dtstrt" value="<?= set_value('dtstrt'); ?>" class="form-control mg-b-10" max="<?= $day_before; ?>">
                                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'dtstrt'); ?> <?php } ?> </span>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="form-label" style="font-weight: 500;margin-left: 5px;">End Date<span style="color: red">*</span></label>
                                                      <div class="col-sm-10">
                                                          <input type="date" name="endt" value="<?= set_value('endt'); ?>" Placeholder="Login User Id" class="form-control mg-b-10" max="<?= date("Y-m-d"); ?>">
                                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'endt'); ?> <?php } ?> </span>
                                                      </div>
                                                  </div>
                                                   <div class="form-group row">
                                                     <div class="col-sm-12">
                                                       <input type="submit" value="Search" class="allocated-button btn btn-info" style="width:100%;font-size: 12px;">
                                                     </div>
                                                    </div>
                                               </form> 
                                               
                                             </div>
                                             <div class="col-md-3">
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -1 days' ) ); ?>/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -1 days' ) ); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Yesterday Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportlstwekext">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last Week Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -15 days' ) ); ?>/<?= date("Y-m-d"); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last 15 Days Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -1 month' ) ); ?>/<?= date("Y-m-d"); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last 1 Month Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>                                                 
                                             </div>
                                             <div class="col-md-3">                                               
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -3 month' ) ); ?>/<?= date("Y-m-d"); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last 3 Month Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -6 month' ) ); ?>/<?= date("Y-m-d"); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last 6 Month Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                   <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= date( 'Y-m-d', strtotime( date("Y-m-d") . ' -12 month' ) ); ?>/<?= date("Y-m-d"); ?>">
                                                     <button class="allocated-button btn btn-info" style="width:100%;">
                                                        Download Last 12 Month Report (PDF)
                                                     </button>
                                                   </a>
                                                 </div>
                                               </div>                                               
                                               <div class="form-group row">
                                                 <div class="col-md-12">
                                                    <a href="<?= base_url(); ?>/oem/downloadreportext">
                                                      <button class="allocated-button btn btn-info" style="width:100%;">
                                                          Download All Time Report (PDF)
                                                      </button>
                                                    </a>
                                                 </div>
                                               </div>
                                             </div>
                                             <div class="col-md-3">
                                               
                                                 <?php
                                                   if(isset($datadatebetween)){
                                                 ?>
                                                    <div class="form-group row">
                                                     <div class="col-md-12">
                                                        <a href="<?= base_url(); ?>/oem/downloadreportextsrch/<?= $datadatebetween[0]; ?>/<?= $datadatebetween[1]; ?>">
                                                          <button class="allocated-button btn btn-info" style="width:100%;">
                                                              Download Report ( <?= date("d-m-Y", strtotime($datadatebetween[0])); ?> Till <?= date("d-m-Y", strtotime($datadatebetween[1])); ?> )
                                                          </button>
                                                        </a>
                                                     </div>
                                                   </div>
                                                 <?php    
                                                   }
                                                 ?>
                                               
                                             </div>
                                          </div>
                                        </div>
                                      </div>
                                    <table class="table table-bordered table-data" id="users-list">
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
                                        <tbody class="text-center">
                                         <?php  
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
                                                <th> <?= $fstgdetls[$j][0]["tagid"]; ?> </th>
                                                <th> <?= $fstgdetls[$j][0]["tid"]; ?> </th>
                                                <th> <?= date("d-m-Y", strtotime($detailss["datetime"])); ?> </th>
                                                <th> <?= date("h:i:s", strtotime($detailss["datetime"])); ?> </th>
                                              	<th>
                                                  <a href="<?= base_url(); ?>/oem/fitmenchallann/<?= $detailss["existinguserid"]; ?>" target="_blank">
                                                   <button class="btn btn-sm btn-info">
                                                     Download Fitmen Challan
                                                   </button>
                                                  </a>
                                                  <a href="<?= base_url(); ?>/oem/fitmenchallannreceipt/<?= $detailss["existinguserid"]; ?>" target="_blank">
                                                   <button class="btn btn-sm btn-info mt-1">
                                                     Download Receipt
                                                   </button>
                                                  </a>
                                                </th>
                                            </tr>
                                          
                                         <?php 
                                               $j++;
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>



















