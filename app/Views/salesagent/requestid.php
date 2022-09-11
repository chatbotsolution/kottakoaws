<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
  
  <style>
    .table-data {
      font-weight: 450;
      font-size: 11px;
      text-align: center;
    }
    
  	.allocated-button:hover {
      background-color: red;
      color: #fff;
    }
    
    #getotp{
      position: absolute;
      top: 0px;
      left: 45%;
    }
  </style>
</head>
  <?php
  if(sizeof($icicirequestid) != 0){
   foreach($icicirequestid as $icicirequestid123);
     if($icicirequestid123['status'] == 1 || $icicirequestid123['status'] == 2 || $icicirequestid123['status'] == 0){
  ?>
     <body class="main-body app sidebar-mini" onload="stts()">
  <?php
     }else{
  ?>
     <body class="main-body app sidebar-mini">
  <?php
     }
  }else{
  ?>
     <body class="main-body app sidebar-mini">
  <?php
  }
  ?>
    
   
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
                	<!-- <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card row">
								<div class="card-body">
                                	<div class="col-lg-12 col-md-12 yuitt" style="padding-bottom: 50px;">	
                                      <?php
                                          if(sizeof($icicirequestid) == 0){
                                      ?>
                                      	<div>
                                            <h6 class="card-title mb-1 card-flt">Request Your ID</h6>
                                        </div>
                                        <form action ="<?= base_url(); ?>/salesagent/requestid" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Upload Selfie<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="selfie" title="Only Image Permitted" Placeholder="selfie" class="form-control mg-b-10" style="max-width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'selfie'); ?> <?php } ?> </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">OTP<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="otp" Placeholder="OTP" class="form-control mg-b-10" style="max-width:50%;">
                                                    <span id="getotp"> <button type="button" class="btn btn-sm btn-info" style="padding:12px;" onclick="getottp();"> GET OTP  </button> <span id="qw"> </span> </span>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'otp'); ?> <?php } ?> </span>
                                                </div>
                                            </div>  
                                            
                                            <?php
                                             foreach($salesagent as $agentdata); 
                                            ?>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">State<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="sattedtt" id="stt" value="<?= $agentdata["state"]; ?>" Placeholder="State" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["state"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'sattedtt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">City<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="cityydt" id="ctty" value="<?= $agentdata["city"]; ?>" Placeholder="City" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["city"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'cityydt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Pincode<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="pincodeedt" id="pncddtt" value="<?= $agentdata["pincode"]; ?>" Placeholder="Pincode" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["pincode"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincodeedt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 1<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln1" id="addrr1" value="<?= $agentdata["addressline1"]; ?>" Placeholder="Address Line 1" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline1"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln1'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 2<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln2" id="addrr2" value="<?= $agentdata["addressline2"]; ?>" Placeholder="Address Line 2" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline2"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln2'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 3<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln3" id="addrr3" value="<?= $agentdata["addressline3"]; ?>" Placeholder="Address Line 3" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline3"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln3'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            
                                            
                                            <div class="col-md-12">                                            
                                                <input type="submit" class="allocated-button btn btn-info" value="Request Id">
                                            </div>
                                        </form>
                                      <?php    
                                          }else{

                                           foreach($icicirequestid as $icicirequestid);
                                            if($icicirequestid['status'] == 1){
                                      ?>
                                          <p class="text-center"> <i class="fa fa-check-circle" style="font-size: 150px;color:orange;"></i> </p>
                                          <p class="text-center" style="font-size: 20px;font-weight: 700;color:orange;"> REQUEST HAS ALREADY BEEN SEND WAITING FOR ADMIN APPROVAL </p>
                                      <?php
                                            }else if($icicirequestid['status'] == 0){
                                      ?>
                                          <p class="text-center"> <i class="fa fa-check-circle" style="font-size: 150px;color:green;"></i> </p>
                                          <p class="text-center" style="font-size: 20px;font-weight: 700;color:green;"> <?= $icicirequestid['remarks']; ?> </p>
                                          <p class="text-center" style="font-size: 20px;font-weight: 700;;"> ICICI AGENT ID <?= $icicirequestid['iciciagentid']; ?> </p>
                                      <?php
                                            }else if($icicirequestid['status'] == 2){
                                      ?>
                                          <p class="text-center"> <i class="fa fa-times-circle" style="font-size: 150px;color:red;"></i> </p>
                                          <p class="text-center" style="font-size: 20px;font-weight: 700;color:red;"> <?= $icicirequestid['remarks']; ?> </p>
                                      <?php
                                            }else{
                                      ?>
                                        <div>
                                            <h6 class="card-title mb-1 card-flt">Request Your ID</h6>
                                        </div>
                                        <form action ="<?= base_url(); ?>/salesagent/requestid" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Upload Selfie<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="selfie" title="Only Image Permitted" Placeholder="selfie" class="form-control mg-b-10" style="max-width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'selfie'); ?> <?php } ?> </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">OTP<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="otp" id="ottp" Placeholder="OTP" class="form-control mg-b-10" style="max-width:50%;">
                                                    <span id="getotp"> <button type="button" class="btn btn-sm btn-info" style="padding:12px;" onclick="getottp();"> GET OTP  </button>  </span>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'otp'); ?> <?php } ?> </span>
                                                    <span id="qw"> </span>
                                                </div>
                                            </div>   
                                            
                                            <?php
                                             foreach($salesagent as $agentdata); 
                                            ?>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">State<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="sattedtt" id="stt" value="<?= $agentdata["state"]; ?>" Placeholder="State" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["state"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'sattedtt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">City<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="cityydt" id="ctty" value="<?= $agentdata["city"]; ?>" Placeholder="City" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["city"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'cityydt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Pincode<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="pincodeedt" id="pncddtt" value="<?= $agentdata["pincode"]; ?>" Placeholder="Pincode" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["pincode"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincodeedt'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 1<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln1" id="addrr1" value="<?= $agentdata["addressline1"]; ?>" Placeholder="Address Line 1" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline1"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln1'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 2<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln2" id="addrr2" value="<?= $agentdata["addressline2"]; ?>" Placeholder="Address Line 2" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline2"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln2'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" style="font-weight: 500;">Address Line 3<span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrrssln3" id="addrr3" value="<?= $agentdata["addressline3"]; ?>" Placeholder="Address Line 3" class="form-control mg-b-10" style="max-width:50%;" <?php if($agentdata["addressline3"] != ""){ echo"readonly='readonly'"; } ?>>
                                                    <span class="errmsg tyu" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrrssln3'); ?> <?php } ?> </span>
                                                </div>
                                            </div> 
                                            
                                            
                                            
                                            <div class="col-md-12">                                            
                                                <input type="submit" class="allocated-button btn btn-info" value="Request Id">
                                            </div>
                                        </form>
                                      <?php
                                            }
                                         }
                                      ?>
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
<script>

function getottp(){
  var getottp =1;
  
  $.ajax({
    type:'post',
    url:'<?= base_url(); ?>/salesagent/requestid',
    data:{getottp:getottp},
    success: function(data){
        if(data == "send"){
            $("#getotp").html('<button type="button" class="btn btn-sm btn-info" style="padding:12px;" onclick="verifyotp();"> VERIFY OTP  </button>');
            $(".tyu").html('<span style="color:green;"> OTP Send Successfully </span>');
        }else if(data == "sorry"){
            $(".tyu").html('Unable To Send OTP ! Try Again Later');
        }
    }
  });
}



function verifyotp(){
  var verfyotp = document.getElementById('ottp').value;
  
  $.ajax({
    type:'post',
    url:'<?= base_url(); ?>/salesagent/requestid',
    data:{verfyotp:verfyotp},
    success: function(data){
        if(data == "verified"){
            $("#ottp").attr('readonly',true);
            $("#getotp").html('<button type="button" class="btn btn-sm btn-info" style="padding:12px;" disabled> VERIFIED  </button>');
            $(".tyu").html('');
        }else if(data == "invalidotp"){
            $("#getotp").html('<button type="button" class="btn btn-sm btn-info" style="padding:12px;" onclick="getottp();"> RE-SEND OTP  </button> <button type="button" class="btn btn-sm btn-info" style="padding:12px;" onclick="verifyotp();"> VERIFY OTP  </button>');
            $(".tyu").html('Invalid OTP');
        }
    }
  });
}

function stts(){
    setInterval(function() { $(".yuitt").load(location.href+" .yuitt>*",""); }, 5000);
}

</script>



















