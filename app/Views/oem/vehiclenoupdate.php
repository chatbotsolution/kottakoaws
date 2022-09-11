<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/oem/css.php'); ?>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   
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
                      
						<div class="left-content">
							<div>
							  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, <?//= $_SESSION['usrName']; ?> welcome back!</h2>
							</div>
						</div>
                      
						<div class="main-dashboard-header-right">
                          
							<div>
								<label class="tx-13">Today's Site Visit</label>
								<h5>1,000</h5>
							</div>
                          
							<div>
								<label class="tx-13">Total Site Visit</label>
								<h5>783,675</h5>
							</div>
                          
						</div>
                      
					</div>
					-->		
                  
                  <div class="card w-100 mt-2">
            <div>
				<h6 class="card-title mb-1 card-flt">Vehicle No. Update</h6>
				</div>
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

                <form method="post" action ="<?= base_url(); ?>/oem/vehiclenoupdate" style="margin-top: 20px;margin-bottom: 20px;" autocomplete="off" enctype='multipart/form-data'>
                    <div class="col-lg-4 form-group">
                        <label class="fw-bold">Chassis Number</label>
                        <div class="input-group">
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control" value="<?= set_value('chassisnumber'); ?>" name="chassisnumber" placeholder="Enter Chassis Number" />
                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'chassisnumber'); ?> <?php } ?> </span>
                        </div>
                    </div>

                    <div class="col-lg-4 form-group">
                        <label class="fw-bold mt-2">Vehicle RC</label>
                        <div class="input-group">
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control" value="<?= set_value('rcbook'); ?>" name="rcbook" placeholder="Enter Vehicle RC" />
                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'rcbook'); ?> <?php } ?> </span>
                        </div>
                    </div>
                  
                  	<div class="col-lg-4 form-group">
                        <label class="fw-bold mt-2">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-addon"></span>
                            <input type="number" class="form-control" value="<?= set_value('contactnum'); ?>" name="contactnum" placeholder="Enter Contact Number" />
                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contactnum'); ?> <?php } ?> </span>
                        </div>
                    </div>
                  
                    <div class="col-lg-4 form-group">
                        <div class="input-group mb-3 mt-2">
                            <label class="fw-bold mt-2 mr-2">Upload</label>
                            <div>
                              <input type="file" class="form-control" value="<?= set_value('rcupload'); ?>" name="rcupload" id="inputGroupFile01">
                              <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'rcupload'); ?> <?php } ?> </span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </form>				
            </div>
        </div>
                  
                </div>
			</div>
      </div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/oem/js.php'); ?>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    </body>
</html>