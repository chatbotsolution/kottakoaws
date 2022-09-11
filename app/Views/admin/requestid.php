<!DOCTYPE html>
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
                                    <div class="col-lg-12 col-md-12 ty" style="margin-top:0px;">
                                    <table class="table table-bordered table-data" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">Regd. Id</th>
                                                <th style="padding: 10px 10px;">TL Name</th>
                                                <th style="padding: 10px 10px;">TL Name Regd. Id</th>
                                                <th style="padding: 10px 10px;">SM Name</th>
                                                <th style="padding: 10px 10px;">SM Regd. Id</th>
                                                <th style="padding: 10px 10px;">Date/Time</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                                $i=0;
												$j=0;
                                               foreach($icicirequestid as $icicirequestid):
                                               $i++;
                                               if($icicirequestid['status'] == 1){
                                          ?>
                                            <tr>
                                                <td> <?= $i; ?> </td>
                                                <td> <?= $salesagent[$j][0]['salesAgentRegdNum']; ?> </td>
                                                <td> <?= $teamlead[$j][0]['Fname'].' '.$teamlead[$j][0]['Lname']; ?> </td>
                                                <td> <?= $teamlead[$j][0]['TleadRegdNum']; ?> </td>
                                                <td> <?= $salesmanager[$j][0]['Fname'].' '.$salesmanager[$j][0]['Lname']; ?> </td>
                                                <td> <?= $salesmanager[$j][0]['RegdNum']; ?> </td>
                                                <td> <?= date('d-m-Y / h:i:s', strtotime($icicirequestid['datetime'])); ?> </td>
                                                
                                                <td>
                                                  <button class="btn btn-info btn-sm" onclick="shwDtls('<?= $icicirequestid['requestid']; ?>');">
                                                        RESPONSE
                                                  </button>
                                                </td>
                                            </tr>
                                          <?php
                                               $j++; }
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>

     function shwDtls(val){
       
       var shwdatafr = val;
       
       $.ajax({
         type:'post',
         url:'<?= base_url(); ?>/secure/requestid',
         data:{shwdatafr:shwdatafr},
         success: function(data){
           $(".ty").html(data);
         }
       });
     }
  
  
     function acpt(val1,val2){
       var updtid = val1;
       var updtval = val2;
       
       $.ajax({
         type:'post',
         url:'<?= base_url(); ?>/secure/requestid',
         data:{updtid:updtid,updtval:updtval},
         success: function(data){
           $("#passModelData").html(data);
           $("#passModel").modal("show");
         }
       });
     }
  
  function validateForm(){
    var remark = document.getElementById('remark').value;
    var generatedid = document.getElementById('generatedid').value;
    
    if(remark == "" || generatedid == ""){
      
      if(remark == ""){
        $('.rem').html('Remark Is Required');
      }else{
        $('.rem').html('');
      }
      
      if(generatedid == ""){
        $('.ici').html('ICICI Generated Id Is Required');
      }else{
        $('.ici').html('');
      }
      
      return false;
    }else{
      return true;
    }
    
  }
  
  function validateFormdecline(){
    var remarkk = document.getElementById('remarkk').value;
    var screenshot = document.getElementById('screenshot').value;
    
    if(remarkk == "" || screenshot == ""){
      
      if(remarkk == ""){
        $('.remarkkt').html('Remark Is Required');
      }else{
        $('.remarkkt').html('');
      }
      
      if(screenshot == ""){
        $('.screenshott').html('Screenshot Id Is Required');
      }else{
        $('.screenshott').html('');
      }
      
      return false;
    }else{
      return true;
    }
    
  }

</script>


















