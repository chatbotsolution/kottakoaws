<!--DOCTYPE html-->
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/adminPanel/css.php'); ?>
  <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
  	
.custom-social-proof {
  position: absolute;
  left:50%;
  top:10px;
  z-index: 9999999999999 !important;
  font-family: "Open Sans", sans-serif;
}
  .custom-notification {
    background-color:#9CB4CC;
    width: auto;
    height:auto;
    border: 0;
    text-align: left;
    z-index: 99999;
    box-sizing: border-box;
    font-weight: 600;
    border-radius: 10px;
    box-shadow: 4px 4px 10px 4px hsla(0, 4%, 4%, 0.2);
    background-color: #fff;
    position: relative;
    cursor: pointer;
  }
    .custom-notification-container {
      display: flex !important;
      align-items: center;
      height: auto;
    }
      .custom-notification-content-wrapper {
        margin: 0;
        color:#ffffff;
        background-color:#30475E;
        height: auto;
        
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 0 6px 6px 0;
        flex: 1;
        display: flex !important;
        flex-direction: column;
        justify-content: center;
      }
        .custom-notification-content {
          font-family: inherit !important;
          margin: 0 !important;
          padding: 0 !important;
          font-size: 14px;
          line-height: 16px;
        }
          small {
            margin-top: 3px !important;
            display: block !important;
            font-size: 12px !important;
            opacity: 0.8;
          }
       
    .custom-close {
      position: absolute;
      top: 8px;
      right: 8px;
      height: 12px;
      width: 12px;
      cursor: pointer;
      transition: 0.2s ease-in-out;
      transform: rotate(45deg);
      opacity: 0;
      background-color:white;
    }
      
    .custom-close::before {
        content: "";
        display: block;
        width: 100%;
        height: 2px;
        background-color: gray;
        position: absolute;
        left: 0;
        top: 5px;
      }
      .custom-close::after {
        content: "";
        display: block;
        height: 100%;
        width: 2px;
        background-color: gray;
        position: absolute;
        left: 5px;
        top: 0;
      }
      .custom-close:hover {
        opacity: 3;
          
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
                      
                      
                      <!-- I add download database button in here -->
                              	<div style="margin-left: 700px;">
								   <?= $this->include('partials/adminPanel/downloadDbBtn.php'); ?>
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
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
							<div>
							  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, <?= $_SESSION['usrName']; ?> welcome back!</h2>
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
                  <!-- NOTICE BOARD -->
                  <div>
                  <!-- <h2 class="notice-board" align="center">NOTICE BOARD</h2>  -->
                    <div class="row" style="margin-top: 20px;">
						 
                      <div class="col-md-3 lastday-active">
                        <label style="border-bottom: 1px solid black;">Lastday Activation</label>
                        <h5 style="font-size: 15px;">200</h5>
                      </div>
                      
                      <div class="col-md-3 lastweek-active">
                        <label style="border-bottom: 1px solid black;">Lastweek Activation</label>
                        <h5 style="font-size: 15px;">90</h5>
                      </div>
                      
                      <div class="col-md-3 available-fastag">
                        <label style="border-bottom: 1px solid black;">Available Fastag</label>
                        <h5 style="font-size: 15px;">50</h5>
                      </div>

                  </div>
                    
				<!-- -->
                    <section class="custom-social-proof">
                      <div class="custom-notification">
                        <div class="custom-notification-container">

                          <div class="custom-notification-content-wrapper">
                            <p class="custom-notification-content">
                              <small>Someone Activate <br> <b> Fastag</b>
                              <small>17 mins ago from Bhubaneswar</small>
                            </p>
                          </div>
                        </div>
                        <div class="custom-close"></div>
                      </div>
                    </section>
                <!-- -->
			</div>
              </div>
          </div>
      </div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
</html>