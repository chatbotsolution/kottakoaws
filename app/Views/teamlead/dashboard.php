<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
    <?= $this->include('partials/teamlead/css.php'); ?>
  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  
  
  <style>
   body {
     font-family: "Montserrat", "Ubuntu";
   }
    .total-no-of-agents {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.total-no-of-agents:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .todays-active-agent {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.todays-active-agent:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .yesterdays-live-agent {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.yesterdays-live-agent:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .lastweek-active-agent {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.lastweek-active-agent:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .yesterday-inactive-agent {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.yesterday-inactive-agent:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .lastweek-inactive-agent {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.lastweek-inactive-agent:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .fastag-availability {
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
    }
    	.fastag-availability:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .performer-report {
      font-weight: 500;
      border: 1px solid black;
      text-align: center;
      background-color: #fff;
    }
    	.performer-report:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
  
  </style>
</head>

    <body class="main-body app sidebar-mini" onload="updtTime();">
   
        <div class="page">
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
			    <?= $this->include('partials/teamlead/headerLogo.php'); ?>
				<?= $this->include('partials/teamlead/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/teamlead/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/teamlead/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/teamlead/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/teamlead/headProfile.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
                      <div class="breadcrumb-header justify-content-between" style="margin-top: 0px;">
                            <div class="left-content">
                                <div>
                                  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, <?= $_SESSION['usrName']; ?> welcome back!</h2>
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
                  <!--Dashboard Table Design -->
                  <!-- 1st row start -->
                  <div class="row justify-content-center">
                    <!-- col -->
                    <div class="total-no-of-agents col-lg-3 col-md-6 col-sm-12 mr-2 mb-2">
                      <div>
                        <label style="text-decoration: underline;">Total No.Of Agents</label>
                      </div>
                      <div>
                        <span><?php print_r($salesagent); ?></span>
                      </div>
                    </div>
                    <!-- col -->
                    
                    <!-- col -->
                    <div class="todays-active-agent col-lg-3 col-md-6 col-sm-12 mr-2 mb-2">
                       <div>
                        <label style="text-decoration: underline;">Today's Active Agents</label>
                      </div>
                      <div style="display: flex; justify-content: center;">
									<table style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">Agent</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">Sales</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;"><?php print_r($todayactiveagent); ?></td>
                                        <td style="padding-right: 50px;"><?php print_r($todaysales); ?></td>
                                      </tr>
                                   </table>
                       </div>
                    </div>
                    <!-- col -->
                    
                    <!-- col -->
                    <div class="yesterdays-live-agent col-lg-3 col-md-6 col-sm-12 mb-2">
                       <div>
                        <label style="text-decoration: underline;">YesterDay's Live Agents</label>
                      </div>
                      <div style="display: flex; justify-content: center;">
							<table style="text-align: center;">
                                 <tr>
                                    <td style="text-decoration: underline; padding-right: 50px;">Agent</td>
                                    <td style="text-decoration: underline; padding-right: 50px;">Sales</td>
                                 </tr>
                                 <tr>
                                    <td style="padding-right: 50px;"><?php print_r($yesterdaysactiveagent); ?></td>
                                    <td style="padding-right: 50px;"><?php print_r($yesterdayssales); ?></td>
                                 </tr>
                            </table>
                       </div>
                    </div>
                    <!-- col -->
                    
                  </div>
                  <!-- 1st row end -->
                  
                  <!-- //////////////////////////////////////// -->
                  
                  
                  <!-- 2nd row start -->
                  <div class="row justify-content-center">
                    <!-- col -->
                    <div class="lastweek-active-agent col-lg-3 col-md-6 col-sm-12 mr-2 mb-2">
                       <div>
                        <label style="text-decoration: underline;">LastWeek Active Agents</label>
                      </div>
                      <div style="display: flex; justify-content: center;">
							<table style="text-align: center;">
                                 <tr>
                                    <td style="text-decoration: underline; padding-right: 50px;">Agent</td>
                                    <td style="text-decoration: underline; padding-right: 50px;">Sales</td>
                                 </tr>
                                 <tr>
                                    <td style="padding-right: 50px;"><?php print_r($lastweekactiveagent); ?></td>
                                    <td style="padding-right: 50px;"><?php print_r($lastweeksales); ?></td>
                                 </tr>
                            </table>
                       </div>
                    </div>
                    <!-- col -->
                    
                    <!-- col -->
                    <div class="yesterday-inactive-agent col-lg-3 col-md-6 col-sm-12 mr-2 mb-2">
                       <div>
                        <label style="text-decoration: underline;">YesterDay's In-Active Agents</label>
                      </div>
                      <div style="display: flex; justify-content: center;">
							<table style="text-align: center;">
                                 <tr>
                                    <td style="text-decoration: underline; padding-right: 50px;">Agent</td>
                                 </tr>
                                 <tr>
                                    <td style="padding-right: 50px;"><?php echo $salesagent - $yesterdaysactiveagent; ?></td>
                                 </tr>
                            </table>
                       </div>
                    </div>
                    <!-- col -->
                    
                    <!-- col -->
                    <div class="lastweek-inactive-agent col-lg-3 col-md-6 col-sm-12 mb-2">
                       <div>
                        <label style="text-decoration: underline;">Lastweek In-Active Agents</label>
                      </div>
                      <div style="display: flex; justify-content: center;">
							<table style="text-align: center;">
                                 <tr>
                                    <td style="text-decoration: underline; padding-right: 50px;">Agent</td>
                                 </tr>
                                 <tr>
                                    <td style="padding-right: 50px;"><?php echo $salesagent - $lastweekactiveagent; ?></td>
                                 </tr>
                            </table>
                       </div>
                    </div>
                    <!-- col -->
                    
                  </div>
                  <!-- 2nd row end -->
                  
                  <!-- //////////////////////////////////////// -->
                  
                  <!-- 3rd row start -->
                  <div class="row justify-content-center">
                    <div class="fastag-availability col-lg-3 col-md-6 col-sm-12 mr-3 mb-2">
                      <div>
                        <label style="text-decoration: underline;">Fastag Availability</label>
                      </div>
                      <div>
                        <div style="display: flex; justify-content: center;">
							<table style="text-align: center;">
                                 <tr>
                                    <td style="text-decoration: underline; padding-right: 50px;">Allocated</td>
                                   <td style="text-decoration: underline; padding-right: 50px;">Not-Allocated</td>
                                 </tr>
                                 <tr>
                                    <td style="padding-right: 50px;"><?php echo $alloted; ?></td>
                                   <td style="padding-right: 50px;"><?php echo $unalloted; ?></td>
                                 </tr>
                            </table>
                       </div>
                      </div>
                    </div>
                    <div class="performer-report col-lg-6 col-md-6 col-sm-12 mb-2">
                      <div class="">
                        <label style="text-decoration: underline;">Performer Report</label>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                        	<label style="text-decoration: underline;">Higher Performer</label>
                      	</div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                          <label style="text-decoration: underline;">Lower Performer</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 3rd row end -->
                  
                  <!-- //////////////////////////////////////// -->
                  
                  <!--Dashboard Table Design -->
                </div>
			</div>
      </div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/teamlead/js.php'); ?>
    </body>
</html>