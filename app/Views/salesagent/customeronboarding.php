<!-- DOCTYPE html -->
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
  
  
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
				<div class="container-fluid" style="margin-top: 0px;">
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
                                      
                                        <div class="col-lg-12 col-md-12 shwall" style="padding-bottom: 50px;">
                                          <div>
                                            <h6 class="card-title mb-1 card-flt">CUSTOMER ONBOARDING</h6>
                                          </div>
                                          <form action ="<?= base_url(); ?>/salesagent/customeronboarding" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">CONTACT NUMBER</label>
                                                <div class="col-sm-10">
                                                    <input type="number" onkeypress="if(this.value.length == 10){ return false; }" name="contactnumber" class="form-control" style="width:50%;"  value="<?= set_value('contactnumber'); ?>" placeholder="CONTACT NUMBER">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contactnumber'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">FASTAG BANK</label>
                                                <div class="col-sm-10">
                                                    <select name="fastagbank" class="form-control" style="width:50%;" onchange="getBarcode(this.value);">
                                                       <option value=""> SELECT BANK </option>
                                                       <option value="Kotak"> KOTAK BANK </option>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fastagbank'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">SELECT BARCODE</label>
                                                <div class="col-sm-10">
                                                    <select name="barcode" id="barcode" class="form-control" style="width:50%;">
                                                       <option value=""> SELECT BARCODE </option>
                                                      <?php
                                                          foreach($fastag as $fastag):
 													  ?>
                                                         <option value="<?= $fastag["barcode"]; ?>"> <?= $fastag["barcode"]; ?> </option>
                                                      <?php
														  endforeach;
													  ?>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'barcode'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">VEHICLE DATA TYPE</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" style="width:50%;" name="vehicledatatype" id="vehicledatatype" required>
                                                        <option value="1">Vehicle Number</option>
                                                        <option value="2">Chassis Number</option>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehicledatatype'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle Number / Chassis Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" style="text-transform:uppercase;width:50%;" name="vehclnum" id="vehclnum" class="form-control" placeholder="Vehicle Number / Chassis Number">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehclnum'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="btn btn-md btn-info"> SEND OTP </button>
                                                </div>
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
        <?= $this->include('partials/salesagent/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('#barcode').selectize({
      sortField: 'text'
    });
  });
</script>
