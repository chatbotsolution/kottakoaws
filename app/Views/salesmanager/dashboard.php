<!--DOCTYPE html -->
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/salesManager/css.php'); ?>
  
  <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
    .table-data:hover {
      color: #fff;
      font-weight: 600;
    }
    
     .fastag-availability {
       font-weight: 500;
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      background-color: #fff;
      padding: 5px;
      border: 1px solid black;
     }
    	.fastag-availability:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
     .total-no-of-team {
       font-weight: 500;
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      padding: 5px;
       background-color: #fff;
    }
    	.total-no-of-team:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    	
    .todays-active {
      background-color: #fff;
      font-weight: 500;
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      padding: 5px;
    }
    	.todays-active:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .yesterdays-active {
      background-color: #fff;
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      font-weight: 500;
      padding: 5px;
      
    }
    	.yesterdays-active:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .sales-dashboard {
      background-color: #fff;
      font-weight: 500;
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      padding: 5px;
    }
    	.sales-dashboard:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .lastweek-active {
      margin-left: 20px;
      background-color: #fff;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      font-weight: 500;
      padding: 5px;
    }
    	.lastweek-active:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .inactive-today {
	  margin-left: 20px;
      background-color: #fff;
      margin-top: 20px;
      text-align: center;
      border: 1px solid black;
      font-weight: 500;
      padding: 5px;
     }
    	.inactive-today:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    .inactive-yesterday {
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      font-weight: 500;
      background-color: #fff;
      border: 1px solid black;
      padding: 5px;
    }
    	.inactive-yesterday:hover {
          background-color: #FF7272;
          color: #fff;
          font-weight: 600;
          border-radius: 10px;
        }
    
    
    .inactive-lastweek {
      margin-left: 20px;
      margin-top: 20px;
      text-align: center;
      background-color: #fff;
      font-weight: 500;
      border: 1px solid black;
      padding: 5px;
    }
    	.inactive-lastweek:hover {
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
			    <?= $this->include('partials/salesManager/headerLogo.php'); ?>
				<?= $this->include('partials/salesManager/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/salesManager/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/salesManager/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/salesManager/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/salesManager/headProfile.php'); ?>
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
                </div>
              
              			  <!-- *******///////////////////////////********* -->
                          <!-- *******///////////////////////////********* -->
               <!--  SALES MANAGER NOTICE BOARD START -->
                      <div class="container-fluid">
                        
                          <!-- first row start -->
                            <div class="row justify-content-center">
                              <div class="fastag-availability col-lg-5 col-md-3 col-sm-6">
                                <label style="text-decoration: underline;">Fastag Availability</label>
                                
                        		<div>
                                  <label style="margin-right: 50px; text-decoration: underline;">Allocated</label>
                                  <label style="text-decoration: underline;">Not-Allocated</label>
                                </div>
                              </div>
                              <div class="col-lg-5 col-md-3 col-sm-6 total-no-of-team">
                              	<label style="text-decoration: underline;">Total No.of Team</label>
                        		<div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                              
                            </div>
                          <!-- first row end -->

                          <!-- *******///////////////////////////********* -->
                        
                        <div class="row justify-content-center">
                          	  <div class="col-lg-5 col-md-3 col-sm-6 todays-active">
                              	<label style="text-decoration: underline;">Today's Active</label>
                                <div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                          	  <div class="col-lg-5 col-md-3 col-sm-6 yesterdays-active">
                              	<label style="text-decoration: underline;">yesterdays Active</label>
                        		<div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                        </div>
                        	
                          <!-- *******///////////////////////////********* -->

                          <!-- second row start -->
                            <div class="row justify-content-center">
                              
                              <div class="col-lg-5 col-md-3 col-sm-6 sales-dashboard">
                              	<label style="text-decoration: underline;">Sales Dashboard</label>
                        		<div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                              <div class="col-lg-5 col-md-3 col-sm-6 lastweek-active">
                              	<label style="text-decoration: underline;">Lastweek Active</label>
                        		<div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                            </div>
                          <!-- second row end -->
                          <!-- *******///////////////////////////********* -->
                          <!-- *******///////////////////////////********* -->
                        
                        <!-- third row start -->
                            <div class="row justify-content-center">
                              <div class="col-lg-5 col-md-3 col-sm-6 inactive-today">
                              	<label style="text-decoration: underline;">Inactive Today</label>
                                <div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                              <div class="col-lg-5 col-md-3 col-sm-6 inactive-yesterday">
                              	<label style="text-decoration: underline;">Inactive Yesterday</label>
                                <div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                              </div>
                            </div>
                          <!-- third row end -->
                        
                        <div class="row justify-content-center">
                        	<div class="col-lg-5 col-md-3 col-sm-6 inactive-lastweek">
                          		<label style="text-decoration: underline;">Inactive Lastweek</label>
                                <div style="display: flex; justify-content: center;">
									<table class="table-data" style="text-align: center;">
                                      <tr>
                                        <td style="text-decoration: underline; padding-right: 50px;">OEM</td>
                                        <td style="text-decoration: underline; padding-right: 50px;">TL</td>
                                        <td style="text-decoration: underline;">SE</td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right: 50px;">10</td>
                                        <td style="padding-right: 50px;">20</td>
                                        <td>40</td>
                                      </tr>
                                   </table>
                                </div>
                          	</div>
                        </div>
                          <!-- *******///////////////////////////********* -->
                          <!-- *******///////////////////////////********* -->
                        </div>
              <!--  SALES MANAGER NOTICE BOARD END -->
			</div>
      </div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/salesManager/js.php'); ?>
          
    </body>
</html>