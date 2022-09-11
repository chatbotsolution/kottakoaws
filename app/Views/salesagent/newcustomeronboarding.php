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
    
    
    #loader {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      background: rgba(0,0,0,0.75) url(<?= base_url(); ?>/public/adminasset/download-loading.gif) no-repeat center center;
      z-index: 10000;
    }
  </style>
</head>

    <body class="main-body app sidebar-mini" onload="updtTime();">
      <div id="loader"></div>
   
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
                                               <?php
                                                  if(isset($_SESSION["showUserform"])){
                                               ?>
                                                <div>
                                                  <h6 class="card-title mb-1 card-flt"> CUSTOMER DETAILS</h6>
                                                </div>
                                                <form action ="<?= base_url(); ?>/salesagent/verifynewcustomeronboarding" method="post" autocomplete="off" enctype='multipart/form-data' onsubmit="showspinner();" >
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">FIRST NAME</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="firstname" class="form-control" style="width:50%;" value="<?= set_value('firstname'); ?>">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'firstname'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">LAST NAME</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="lastname" class="form-control" style="width:50%;" value="<?= set_value('lastname'); ?>">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'lastname'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">PAN CARD NUMBER</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="panumber" class="form-control" style="width:50%;" value="<?= set_value('panumber'); ?>">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panumber'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">DATE OF BIRTH</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="dob" class="form-control" style="width:50%;" value="<?= set_value('dob'); ?>">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'dob'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">GENDER</label>
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
                                                        <label class="col-sm-2 col-form-label">PINCODE</label>
                                                        <div class="col-sm-10">
                                                          <select name="pincode" class="form-control" style="width:50%;">
                                                            <option value=""> SELECT PINCODE </option>
                                                            <?php
                                                                foreach($pincode as $pincode):
                                                            ?>
                                                                <option value="<?= $pincode["pincode"]; ?>"><?= $pincode["pincode"]; ?></option>
                                                            <?php
                                                                endforeach;
                                                            ?>
                                                          </select>
                                                            
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'pincode'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg" hidden>
                                                        <label class="col-sm-2 col-form-label">ADDTRESS 1</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="addr1" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr1'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg" hidden>
                                                        <label class="col-sm-2 col-form-label">ADDRESS 2</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="addr2" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr2'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg" hidden>
                                                        <label class="col-sm-2 col-form-label">ADDRESS 3</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="addr3" class="form-control" style="width:50%;" value="INDIA" readonly="readonly">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'addr3'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">ADDRESS PROOF TYPE</label>
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
                                                        <label class="col-sm-2 col-form-label">ADDRESS PROOF NUMBER</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="addrproofnum" class="form-control" style="width:50%;" value="<?= set_value('addrproofnum'); ?>">
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
                                               <?php
                                                  }else if(isset($_SESSION["customerverified"])){
                                               ?>
                                            
                                            	  <div>
                                                    <h6 class="card-title mb-1 card-flt"> Allot Barcode </h6>
                                                  </div>
                                                  <form action="<?= base_url(); ?>/salesagent/allotbarcodenewcustomeronboarding" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">Select Product</label>
                                                        <div class="col-sm-10">
                                                            <select name="product" id="product" class="form-control" style="width:50%;" onchange="getClassofbarcode(this.value);">
                                                               <option value=""> SELECT PRODUCT </option>
                                                              <?php
                                                                  foreach($product as $product):
                                                              ?>
                                                                 <option value="<?= $product["productid"]; ?>"> <?= $product["prodctCode"]; ?> </option>
                                                              <?php
                                                                  endforeach;
                                                              ?>
                                                            </select>
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'product'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label"> Select Class Of Barcode </label>
                                                        <div class="col-sm-10">
                                                            <select name="classofbarcode" id="classofbarcode" class="form-control" style="width:50%;" onchange="getVehicletype(this.value);">
                                                               <option value=""> SELECT CLASS OF BARCODE </option>
                                                            </select>
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'classofbarcode'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label"> Select Vehicle Type </label>
                                                        <div class="col-sm-10">
                                                            <select name="vehicletype" id="vehicletype" class="form-control" style="width:50%;">
                                                               <option value=""> SELECT VEHICLE TYPE </option>
                                                            </select>
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'vehicletype'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <label class="col-sm-2 col-form-label">RC Book Upload</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="rcbook" id="rcbook" class="form-control" style="width:50%;">
                                                            <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'rcbook'); ?> <?php } ?> </span>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row utg">
                                                        <div class="col-md-6 text-center">
                                                            <button type="submit" class="btn btn-md btn-info"> MAKE PAYMENT & ALLOT TAG </button>
                                                            <button type="button" class="btn btn-md btn-danger" onclick="cancelTrans();"> CANCEL </button>
                                                        </div>
                                                    </div>
                                                  </form>
                                            
                                            
                                               <?php
                                                  }else{
                                               ?>
                                                <div>
                                                  <h6 class="card-title mb-1 card-flt">VERIFY OTP</h6>
                                                </div>
                                                <form action ="<?= base_url(); ?>/salesagent/newcustomeronboarding" method="post" autocomplete="off" enctype='multipart/form-data'?>
                                                  <div class="form-group row utg">
                                                      <label class="col-sm-2 col-form-label">OTP</label>
                                                      <div class="col-sm-10">
                                                          <input type="number" name="otp" class="form-control" style="width:50%;"  value="<?= set_value('contactnumber'); ?>" placeholder="OTP">
                                                          <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'otp'); ?> <?php } ?> </span>
                                                      </div>                                                
                                                  </div>
                                                  <div class="form-group row utg">
                                                      <div class="col-md-6 text-center">
                                                          <button type="submit" class="btn btn-md btn-info"> VERIFY OTP </button>
                                                      </div>
                                                  </div>
                                                </form>
                                               <?php
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>
    
  function getBarcode(val){
      var bankname = val;
    
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesagent/customeronboarding',
        data:{bankname:bankname},
        success: function(data){
          $("#barcode").html(data);
        }
      });
  }
  
  function cancelTrans(){
      var cancl = 1;
    
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesagent/customeronboarding',
        data:{cancl:cancl},
        success: function(data){
          location.reload();
        }
      });
  }
  
  
  function getClassofbarcode(val){
      var productid = val;
    
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesagent/existingcustomeronboarding',
        data:{productid:productid},
        success: function(data){
          $("#classofbarcode").html(data);
        }
      });
  }
  
  
  function getVehicletype(val){
      var classofbarcode = val;
    
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/salesagent/existingcustomeronboarding',
        data:{classofbarcodesearch:classofbarcode},
        success: function(data){
          $("#vehicletype").html(data);
        }
      });
  }
</script>
<script>
var spinner = $('#loader');
  
  function showspinner(){    
    spinner.show();
  }
  

</script>