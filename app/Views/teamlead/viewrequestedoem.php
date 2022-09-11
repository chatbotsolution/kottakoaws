<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesManager/css.php'); ?>
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
                <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card row">
								<div class="card-body">
								    <?php if(session()->getTempdata('error')){ ?> 
										<div class="alert alert-danger alert-dismissible fade show"><?= session()->getTempdata('error'); ?>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
                                    <?php } ?>
                                    <div class="col-lg-12 col-md-12" style="margin-top:40px;">
                                    <table class="table table-bordered" id="users-list">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
												<th>Company Name</th>
                                                <th>Trade Name</th>
                                                <th>GST Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;
                                                foreach($oemrequest as $saledata):
                                                    $i++;

                                                    if($saledata["status"] == 0){
                                                        $sts="Active";
                                                    }else if($saledata["status"] == 1){
                                                        $sts="Blocked";
                                                    }else if($saledata["status"] == 2){
                                                        $sts="Pending";
                                                    }else if($saledata["status"] == 3){
                                                        $sts="Rejected";
                                                    }
													$hashdata =$saledata["oemid"];
        											$reqstid = base64_encode(json_encode($hashdata)); 
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $saledata["companyname"]; ?></td>
                                                    <td><?= $saledata["tradename"]; ?></td>
                                                    <td><?= $saledata["gstnumber"]; ?></td>
                                                    <td><?= $sts; ?></td>
                                                    <td>
                                                        <a href="<?= base_url(); ?>/salesmanager/viewrequestedoem/<?= $reqstid ?>"> <button class="btn btn-sm btn-info"> View </button> </a>
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
        <?= $this->include('partials/salesManager/js.php'); ?>
    </body>
</html>



















