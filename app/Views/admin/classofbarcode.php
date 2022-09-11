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
										<h6 class="card-title mb-1 card-flt">Add Class Of Vehicle</h6>
									  </div>
                                      <form class="row" action ="<?= base_url(); ?>/secure/classofbarcode" method="post" autocomplete="off" enctype='multipart/form-data'  style="margin-bottom:30px;">
                                        <div class="form-group col-md-3">
                                          <select name="prdclass" class="form-control">
                                            <option value=""> Select Fastag Class</option>  
                                            <?php 
												foreach($claassftag as $clsftag):
												if($clsftag["classoftag"] !=""){
                                            ?>
                                                   <option value="<?= $clsftag["classoftag"]; ?>"><?= $clsftag["classoftag"]; ?></option>
                                            <?php
												}
												endforeach;
                                            ?>
                                          </select>
                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'prdclass'); ?> <?php } ?> </span>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" name="barcodeclass" id="barcodeclass" class="form-control" value="<?= set_value('barcodeclass'); ?>" placeholder="Vehicle Class To Be Passed">
                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'barcodeclass'); ?> <?php } ?> </span>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="text" name="toshowinapplication" id="toshowinapplication" class="form-control" value="<?= set_value('toshowinapplication'); ?>" placeholder="To Be Shown In Application">
                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'toshowinapplication'); ?> <?php } ?> </span>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <select name="vehicletype" id="vehicletype" class="form-control">
                                            <option value="">Commercial Type</option>
                                            <option value="Non-Commercial">Non-Commercial</option>
                                            <option value="Commercial">Commercial</option>
                                          </select>
                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehicletype'); ?> <?php } ?> </span>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="submit" value="Add Class Of Vehicle" class="btn btn-info">
                                        </div>
                                        
                                      </form>
                                      
                                      
                                    <table class="table table-bordered table-data" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
                                                <th style="padding: 10px 10px;">Class Of Fastag</th>
												<th style="padding: 10px 10px;">Vehicle Class To Be Passed</th>
                                                <th style="padding: 10px 10px;">To Be Shown In Application</th>
                                                <th style="padding: 10px 10px;">Commercial Type</th>
                                                <th style="padding: 10px 10px;">Status</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;
                                                foreach($barcode as $saledata):
                                                    $i++;

												if($saledata["status"] == 0){
                                                  $sts="ACTIVE";
                                                  $btn='<button class="btn btn-sm btn-info" onclick="updatests(\''.$saledata["classofbarcodeid"].'\',\'1\');"> BLOCK </button>';
                                                }else if($saledata["status"] == 1){
                                                  $sts="BLOCKED";
                                                  $btn='<button class="btn btn-sm btn-info" onclick="updatests(\''.$saledata["classofbarcodeid"].'\',\'0\');"> UN-BLOCK </button>';
                                                }else{
                                                  $sts="DELETED";
                                                  $btn="";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $saledata["fastagclass"]; ?></td>
                                                    <td><?= $saledata["classofbarcode"]; ?></td>
                                                    <td><?= $saledata["toshowinapplication"]; ?></td>
                                                    <td><?= $saledata["typeofvehicle"]; ?></td>
                                                    <td><?= $sts; ?></td>
                                                    <td>
                                                      <?= $btn; ?>
                                                      <button class="btn btn-sm btn-danger" onclick="updatests('<?= $saledata["classofbarcodeid"]; ?>',2);"> REMOVE </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

     function updatests(val,val1){
       var updateid = val;
       var updatedata = val1;
       
       $.ajax({
         type:'post',
         url:'<?= base_url(); ?>/secure/classofbarcode',
         data:{updateid:updateid,updatedata:updatedata},
         success: function(data){
           location.reload();
         }
       });
     }

</script>


















