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
                                    <table class="table table-bordered table-data" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">User Name</th>
                                                <th style="padding: 10px 10px;">User Id</th>
                                                <th style="padding: 10px 10px;">Contact</th>
                                                <th style="padding: 10px 10px;">Email</th>
                                                <th style="padding: 10px 10px;">Status</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              $i=0;
                                               foreach($users as $usr):
                                                $i++;

                                                if($usr["status"] == 0){
                                                    $sts="Active";
                                                    $btn='<a href="'.base_url().'/secure/updateofficialuser/'.$usr["admin_id"].'/1">    <button class="btn btn-sm btn-danger" title="Block User"> Block </button> </a>';
                                                    
                                                }else if($usr["status"] == 1){
                                                    $sts="Blocked";
                                                    $btn='<a href="'.base_url().'/secure/updateofficialuser/'.$usr["admin_id"].'/0">    <button class="btn btn-sm btn-primary" title="Un-Block User"> Un-Block </button> </a>';                                                        
                                                    
                                                }
                                            ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $usr["name"]; ?></td>
                                                <td><?= $usr["userid"]; ?></td>
                                                <td><?= $usr["contact_number"]; ?></td>
                                                <td><?= $usr["email"]; ?></td>
                                                <td><?= $sts; ?></td>
                                                <td>
                                                    <?= $btn; ?>
                                                    <button type="button" onclick="shwChngepass('<?= $usr["admin_id"]; ?>');" class="btn btn-sm btn-warning" title="Change User Password">Change Password</button>
                                                    <a href="<?= base_url(); ?>/secure/editofficialusers/<?= $usr["admin_id"]; ?>"> <button class="btn btn-sm btn-info" title="Edit User">Edit</button> </a>
                                                </td>
                                            </tr>
                                            <?php
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

    function shwChngepass(val){
        var changePassid = val;

        $.ajax({
            type:'post',
            data:{changePassid:changePassid},
            url:'<?= base_url(); ?>/secure/passwork',
            success: function(data){
                $("#passModelData").html(data);
                $("#passModel").modal("show");
            }
        });
    }

    function updtPass(val){
       var updtidd =val;
       var password = document.getElementById("password").value; 
       var confirmpassword = document.getElementById("confirmpassword").value; 

       if(confirmpassword =="" || password == ""){
           if(confirmpassword ==""){
               $("#cnfrmpass").html("Confirm Password Is Required");
           }else{
               $("#cnfrmpass").html("");
           }

           if(password == ""){
               $("#pass").html("Password Is Required");
            }else{
               $("#pass").html("");
            }

       }else if(confirmpassword != password){
            $("#shwlrt").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Password And Confirm Password Do Not Match</strong></div>');
            $("#pass").html("");
            $("#cnfrmpass").html("");
        }else{
            $("#shwlrt").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Please Wait Updating</strong></div>');
            $("#pass").html("");
            $("#cnfrmpass").html("");

            $.ajax({
                type:'post',
                url:'<?= base_url(); ?>/secure/passwork',
                data:{updtidd:updtidd,password:password,confirmpassword:confirmpassword},
                success: function(data){
                    if(data =="done"){
                        $("#shwlrt").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Password Updated Successfully</strong></div>');
                        setTimeout(function(){ location.reload();}, 2000);
                    }else{
                        $("#shwlrt").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Cannot Update Try After Sometime</strong></div>');
                    }
                }
            });

        }
    }
</script>