<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
     <?= $this->include('partials/oem/css.php'); ?>

  
  <style>
  
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
                   <!--  <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
                    <div class="row" style="margin-top: 10px;">
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
                                          
                                          <?php if(isset($_SESSION["otpVeryfy"]) && $_SESSION["otpVeryfy"] == 1){ ?>
                                          
                                          <div>
                                            <h6 class="card-title mb-1 card-flt">Verify OTP</h6>
                                          </div>
                                          <form action ="<?= base_url(); ?>/oem/verifyotp" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">OTP</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="otpreceived" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'otpreceived'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="btn btn-md btn-info"> VERIFY OTP </button>                                                   
                                                    <button type="button" class="btn btn-md btn-danger" onclick="cancelTrans();"> CANCEL </button>
                                                </div>
                                            </div>
                                          </form>
  
                                          <?php }else if(isset($_SESSION["otpVerified"])){ ?>
  										  <div>
                                            <h6 class="card-title mb-1 card-flt"> Customers Details </h6>
                                          </div>                                          
                                          <form action ="<?= base_url(); ?>/oem/verifycustomerdetails" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">First Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="firstname" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'firstname'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Last Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="lastname" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lastname'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">PAN Card Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="panumber" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panumber'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Date Of Birth</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="dob" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'dob'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Gender</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="gender" style="width:50%;">
                                                       <option value="1"> Male </option>
                                                       <option value="2"> Female </option>
                                                       <option value="3"> Transgender </option>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'gender'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Pincode</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="pincode" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincode'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg" hidden>
                                                <label class="col-sm-2 col-form-label">Address 1</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addr1" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr1'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg" hidden>
                                                <label class="col-sm-2 col-form-label">Address 2</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addr2" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr2'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg" hidden>
                                                <label class="col-sm-2 col-form-label">Address 3</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addr3" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr3'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Address Proof Type</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" style="width:50%" name="addresstype">
                                                       <option value="2">Driving License</option>
                                                       <option value="1">Voter Id</option>
                                                       <option value="3">Passport</option>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addresstype'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Address Proof Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="addrproofnum" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addrproofnum'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="btn btn-md btn-info"> VERIFY CUSTOMER </button>                                                  
                                                    <button type="button" class="btn btn-md btn-danger" onclick="cancelTrans();"> CANCEL </button>
                                                </div>
                                            </div>
                                          </form>
  
                                          <?php }else if(isset($_SESSION["customerverified"])){ ?>
  										  
                                          <div>
                                            <h6 class="card-title mb-1 card-flt"> Allot Barcode </h6>
                                          </div>
                                          <form action ="<?= base_url(); ?>/oem/allotbarcode" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Barcode</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" style="width:50%;" name="barcode" id="barcode"  placeholder="Select Barcode">
                                                       <option value="">Select Barcode</option>
                                                       <?php                                           
                                                           foreach($barcode as $bar):
                                                            if($bar["status"] == 0){
                                                        ?>
                                                      		<option value="<?= $bar["barcode"]; ?>"> <?= $bar["barcode"]; ?> </option>
                                                        <?php
                                                            }
                                                           endforeach;
                                                        ?> 
                                                    </select>                                                  
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'barcode'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle Data Type</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" style="width:50%;" name="vehicledatatype">
                                                        <option value="1">Vehicle Number</option>
                                                        <option value="2">Chassis Number</option>
                                                    </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contactNumber'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle Number / Chassis Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" style="text-transform:uppercase;" name="vehclnum" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehclnum'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle Class</label>
                                                <div class="col-sm-10">
                                                    <select name="vehclcls" id="vehclcls" class="form-control" style="width:50%;" required>
                                                      <option value="VC4"> VC4</option>
                                                      <option value="VC20">VC20</option>
                                                  </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehclcls'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label"> Vehicle Type </label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" style="width:50%;" name="vehicletype">
                                                      <option value="Commercial">Commercial</option>
                                                      <option value="Non-Commercial">Non-Commercial</option>
                                                  </select>
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehicletype'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">RC Book Upload</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="rcbook" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'rcbook'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="btn btn-md btn-info"> ALLOT TAG </button>                                                  
                                                    <button type="button" class="btn btn-md btn-danger" onclick="cancelTrans();"> CANCEL </button>
                                                </div>
                                            </div>
                                          </form>
  										   
  
										 <?php }else if(isset($_SESSION["phnumberpresent"])){ ?>
  										  
                                          <div>
                                            <h6 class="card-title mb-1 card-flt"> Request Activation </h6>
                                          </div>
                                          <form action ="<?= base_url(); ?>/oem/verifyregstrnum" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">First Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="fnamee" id="fnamee" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fnamee'); ?> <?php } ?> </span>
                                                </div>
											</div>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Last Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="lnamee" id="lnamee" class="form-control" style="width:50%;">                                            
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lnamee'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Contact Number</label>
                                                <div class="col-sm-10">
                                                    <input type="number" onkeypress="if(this.value.length == 10){ return false; }" name="mnum" id="mnum" class="form-control" style="width:50%;">                                            
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'mnum'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle Number</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="vhclnum" id="vhclnum" class="form-control" style="width:50%;">                                            
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vhclnum'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Vehicle RC</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="VehicleRC" id="VehicleRC" class="form-control" style="width:50%;">                                            
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'VehicleRC'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="btn btn-md btn-info"> SEND REQUEST </button>
                                                    <button type="button" class="btn btn-md btn-danger" onclick="cancelTrans();"> CANCEL </button>
                                                </div>
                                            </div>
                                          </form>
  										   
  
										 <?php }else{  ?>
                                          
                                          <div>
                                            <h6 class="card-title mb-1 card-flt">Verify Customer</h6>
                                          </div>
                                          <form action ="<?= base_url(); ?>/oem/newtagactivation" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                          	<div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Customer Number</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="contactNumber" onkeypress="if(this.value.length == 10){ return false; }" class="form-control" style="width:50%;">
                                                    <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'contactNumber'); ?> <?php } ?> </span>
                                                </div>                                                
											</div>
                                            <div class="form-group row utg">
                                                <div class="col-md-6 text-center">
                                                    <button type="submit" class="allocated-button btn btn-info"> SEND OTP </button>
                                                </div>
                                            </div>
                                          </form>
                                          
                                      <?php } ?>
                                     </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>			
                    </div>
			</div>
        <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?= $this->include('partials/oem/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>
function cancelTrans(){	
      var canceltr =1;
      $.ajax({
        type:'POST',
        url:'<?= base_url(); ?>/salesagent/caceltransactions',
        data:{canceltr:canceltr},
        success: function(data){
          location.reload();
        }
      });		
	}


</script>
<script>
  $(document).ready(function () {
    $('#barcode').selectize({
      sortField: 'text'
    });
  });
</script>
