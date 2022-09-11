<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
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
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
							<div>
							  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, <?= $_SESSION['usrName']; ?> Welcome Back!</h2>
							</div>
						</div>
						<!-- <div class="main-dashboard-header-right">
							<div>
								<label class="tx-13">Today's Site Visit</label>
								<h5>1,000</h5>
							</div>
							<div>
								<label class="tx-13">Total Site Visit</label>
								<h5>783,675</h5>
							</div>
						</div> -->
					</div>                  
                    <div class="row">
                      <div class="col-md-12">                        
                          <?php
                                    $credit=0;
                                    $debit=0;
									foreach($wallatdetails as $wallet):

                                      if($wallet["transactiontype"] == 1){
                                        $credit = $credit + $wallet["amount"];
                                      }else if($wallet["transactiontype"] == 2){
                                        $debit = $debit + $wallet["amount"];
                                      }else{
                                        
                                      }
                                     
									endforeach;
									$pending = $credit - $debit;
							
								if($pending >= 250){
                                  echo'';
                                }else if($pending < 250){
                                  echo'<span id="lowBal"> Wallet Balance Low !! <a href="'.base_url().'/salesagent/wallet"> Refill Your Wallet </a> To Start Registering Customers..</span>';
                                }
                          ?>
                          
                          
                      </div>
                    </div>
                      <?php
                            if(sizeof($banner) != 0){
                      ?>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                      <?php
                            $i=0;
                            foreach($banner as $banners):
                      ?>                    
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i; ?>" <?php if($i==0){ echo'class="active"';} ?>></li>
                      <?php
                            $i++;
                            endforeach;
                      ?>
                          </ol>
                          <div class="carousel-inner">
                            <?php
                                  $j=0;
                                  foreach($banner as $banners):
                            ?>
                            <div class="carousel-item <?php if($j==0){ echo"active";} ?>">
                                  <img class="d-block w-100" src="<?= $banners["bannerimage"]; ?>" title="<?= $banners["bannername"]; ?>" alt="<?= $banners["bannername"]; ?>" style="height:350px;">
                                </div>
                            <?php
                                  $j++;
                                  endforeach;
                            ?>
                          </div>

                          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      <?php
                          }
                      ?>
                  
                </div>
			</div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/salesagent/js.php'); ?>
    </body>
</html>