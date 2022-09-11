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
                                        <div class="col-lg-12 col-md-12 shwall" style="padding-bottom: 50px;">	
										 <?php
										    if(isset($_SESSION["setTagactivationId"]) && $_SESSION['paymentstatus'] == "success"){
												foreach($somedata as $dat);
											   if(isset($otpdata)){
												   print_r($otpdata);
												   
												$data = json_decode($otpdata)[0];
												$array = json_decode(json_encode($data), true);
												if($array['RESPONSECODE'] == 00){
										  ?>
												<div>
													<h6 class="card-title mb-1 card-flt">Verify OTP</h6>
												</div>
												<form action="<?= base_url(); ?>/salesagent/tagactivation" method="post"> 
													<label class="col-sm-2 col-form-label"> OTP </label>
													<div class="col-sm-10">
														<input type="password" name="ottpdata" class="form-control" style="max-width:50%;">
														<span class="errmsg clstg" style="text-align:left;"></span>
														<button class="btn btn-md btn-info"> VERIFY OTP </button>
													</div>
												</form>
										  <?php										
												}else if($array['RESPONSECODE'] == 02){
										  ?>
										  		<table class="table table-bordered">
													<tr>
														<td> Contact Number Already Registered </td>
													</tr>
												</table>
										  <?php										
											}else if($array['RESPONSECODE'] == 01){
										  ?>
										  		<table class="table table-bordered">
													<tr>
														<td> Daily Limit For This Number Exceeded </td>
													</tr>
												</table>
										  <?php		
												}else{
										  ?>
												<table class="table table-bordered">
													<tr>
														<td> Unable To Send OTP Try Again Later </td>
													</tr>
												</table>
										  <?php
												}
										   ?>


										<?php
										    }else if(isset($otpverify)){

												$data = json_decode($otpverify)[0];
												$array = json_decode(json_encode($data), true);
												if($array['RESPONSECODE'] == 00){
										?>
												<table class="table table-bordered">
													<tr>
														<td> OTP Verified Success Fully  </td>
													</tr>
												</table>
												<form action="<?= base_url(); ?>/salesagent/tagactivation" method="post"> 
													<label class="col-sm-2 col-form-label"> Date Of Birth </label>
													<div class="col-sm-10">
														<input type="date" name="dob" id="dob" class="form-control" style="max-width:50%;">
														<span class="errmsg clstg" style="text-align:left;"></span>
														<button type="button" class="btn btn-md btn-info" onclick="verifydob();"> VERIFY DOB </button>
														<span style="color:red;font-size:12px;font-weight:700;" id="errfordob"> </span>
														<span style="color:green;font-size:12px;font-weight:700;" id="sussfordob"> </span>
													</div>
												</form>
										<?php
												}else if($array['RESPONSECODE'] == 01){
										?>
												<div>
													<h6 class="card-title mb-1 card-flt">Verify OTP</h6>
												</div>
												<form action="<?= base_url(); ?>/salesagent/tagactivation" method="post"> 
													<label class="col-sm-2 col-form-label"> OTP </label>
													<div class="col-sm-10">
														<input type="password" name="ottpdata" class="form-control" style="max-width:50%;">
														<span class="errmsg clstg" style="text-align:left;"></span>
														<button class="btn btn-md btn-info"> VERIFY OTP </button>
														<span style="color:red;font-size:12px;font-weight:700;"> Invalid OTP </span>
													</div>
												</form>
										<?php
												}
										?>
										<?php
											}else{												
										?>
											<div>
												<h6 class="card-title mb-1 card-flt">Verify Customer</h6>
											</div>
											<div class="row hyu">
											  <div class="col-md-2"></div>
											  <div class="col-md-8">
												<table class="table table-bordered">
													<tr>
														<td>Name</td>
														<td> <?= $dat['customername']; ?> </td>
													</tr>
													<tr>
														<td>Contact Number</td>
														<td> <?= $dat['mobileNumber']; ?> </td>
													</tr>
													<tr>
														<td>PAN Card Details</td>
														<td> <?= $dat['pancarddetails']; ?> </td>
													</tr>
												</table>
												<form action="<?= base_url(); ?>/salesagent/tagactivation" method="post">
												    <input type="hidden" value="<?= $dat['mobileNumber']; ?>" name="contactSndotp">
												    <button class="btn btn-md btn-info" onclick="sendotp('<?= $dat['mobileNumber']; ?>');"> VERIFY </button>
													<button type="button" class="btn btn-md btn-info" onclick="edit('<?= $dat['initialId']; ?>');"> EDIT </button>
											    </form>
											  </div>
											</div>
										 <?php
											   }
											}else{
										 ?>
											<div>
												<h6 class="card-title mb-1 card-flt">TAG Activation</h6>
											</div>
                                            <div class="form-group row utg">
                                                <label class="col-sm-2 col-form-label">Product</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="prd" id="prd" style="width:50%;" onchange="shwClassTag(this.value);">
                                                        <option value=""> Select Product </option>
														<?php
														   foreach($product as $tagg):
														?>
														    <option value="<?= $tagg["productid"]; ?>"> <?= $tagg["prodctCode"]; ?> </option>
														<?php 
														   endforeach;
														?>
                                                    </select>
                                                    <span class="errmsg clstg" style="text-align:left;"></span>
                                                </div>
											</div>  
											<div class="form-group row shwTag">
											</div>
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

<script>

	function shwClassTag(val){
		var shwclssTag = val;
		if(shwclssTag == ""){
			$(".we").html('<input type="button" onclick="SubNext();" class="btn btn-main-primary" style="width:10%;" value="Next">');
			$(".clstg").html("");
			$(".shwTag").html("");
		}else{	
			$(".clstg").html("");
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{shwclssTag:shwclssTag},
				success: function(data){
					$(".we").html('<input type="button" onclick="chck();" class="btn btn-main-primary" style="width:10%;" value="Next">');
					$(".shwTag").html(data);
				}
			});
	    }
	}

	function verifydob(){
		var dob = document.getElementById("dob").value;
		if(dob == ""){
			$("#errfordob").html("Date Of Birth Is Required");
		}else{
			$("#errfordob").html("");
			
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{ddob:dob},
				success: function(data){
					if(data == "invalidpan"){
						$("#errfordob").html("Invalid PAN Card Details");
					}else if(data == "sorry"){
						$("#errfordob").html("Unable To Process Try Again Later");
					}else if(data == "done"){
						$("#sussfordob").html("Wallet Created Successfully");
					}else if(data == "notdone"){
						$("#errfordob").html("Wallet Not Created");
					}else{
						$("#errfordob").html("Looking");
					}
				}
			});
		}
	}


	function edit(val){
		var edttid = val;

		$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{edttid:edttid},
				success: function(data){
					$(".hyu").html(data);
				}
			});


	}

	function SubNext(){
		var prd = document.getElementById("prd").value;
		if(prd == ""){
			$(".clstg").html("Atleast One Product Is Required");
		}else{
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{prd:prd},
				success: function(data){
					$(".utg").html(data);
				}
			});
	    }
	}

	function updt(val){
		var editiddd = val;
		var nammee = document.getElementById("fname").value;
		var contctnum = document.getElementById("contc").value;
		var pncdr = document.getElementById("pncdr").value;

		if(nammee == "" || contctnum == "" || pncdr == ""){			
			
			if(nammee == ""){
				$('#errmsg1').html('Name Is Required');
			}else{
				$('#errmsg1').html('');
			}

			if(contctnum == ""){
				$('#errmsg2').html('Contact Number Is Required');
			}else{
				$('#errmsg2').html('');
			}

			if(pncdr == ""){
				$('#errmsg3').html('PAN Card Is Required');
			}else{
				$('#errmsg3').html('');
			}

		}else{
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{editiddd:editiddd,nammee:nammee,contctnum:contctnum,pncdr:pncdr},
				success: function(data){
					location.reload();
				}
			});
	    }
	}

	function shwsome(val){
		var barcodetype = val;
		if(barcodetype == ""){
			$(".clstg1").html("Class Of Barcode Is Required");
		}else{	
			$(".clstg1").html("");	
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{barcodetype:barcodetype},
				success: function(data){
					$("#ss").html(data);
					$(".yu").html('<input type="button" onclick="subs();" class="btn btn-main-primary" style="width:10%;" value="Next">');
				}
			});
	    }
	}
	let myWindow;

	function validateSubmit(){

		var fstagclss = document.getElementById('fstagclss').value;
		var barcodetyp = document.getElementById('barcodetyp').value;
		var custname = document.getElementById('custname').value;
		var mobilenumber = document.getElementById('mobilenumber').value;
		var vehiclenumber = document.getElementById('vehiclenumber').value;
		var pancardnum = document.getElementById('pancardnum').value;
		var prd = document.getElementById('prd').value;
		var typee = document.getElementById("typee").value;

		if(fstagclss == "" || barcodetyp == "" || custname == "" || mobilenumber =="" || vehiclenumber == "" || pancardnum == ""){

			if(fstagclss == ""){
				$("#fstgcls").html('Fastag Class Is Required');
			}else{
				$("#fstgcls").html('');
			}

			if(barcodetyp == ""){
				$("#clsbrcd").html('Fastag Class Is Required');
			}else{
				$("#clsbrcd").html('');
			}

			if(custname == ""){
				$("#cusnm").html('Fastag Class Is Required');
			}else{
				$("#cusnm").html('');
			}

			if(mobilenumber ==""){
				$("#mobnum").html('Fastag Class Is Required');
			}else{
				$("#mobnum").html('');
			}

			if(vehiclenumber == ""){
				$("#vehclnm").html('Fastag Class Is Required');
			}else{
				$("#vehclnm").html('');
			}

			if(pancardnum == ""){
				$("#pannum").html('Fastag Class Is Required');
			}else{
				$("#pannum").html('');
			}

		}else{
			$("#fstgcls").html('');
			$("#clsbrcd").html('');
			$("#cusnm").html('');
			$("#mobnum").html('');
			$("#vehclnm").html('');
			$("#pannum").html('');
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{prd:prd,typee:typee,fstagclsssub:fstagclss,barcodetypsub:barcodetyp,custnamesub:custname,mobilenumbersub:mobilenumber,vehiclenumbersub:vehiclenumber,pancardnumsub:pancardnum},
				success: function(data){
					const obj = JSON.parse(data);
					var URL=obj.paymentLink;
					myWindow = window.open(URL, '_blank');
					checkWin();
				}
			});

		}

	}

	function checkWin() {
		
		if (myWindow.closed) { 
			var checkPayment =1;

			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/salesagent/tagactivation',
				data:{checkPayment:checkPayment},
				success: function(data){
					location.reload();
				}
			});
		}else{
			setTimeout(checkWin, 2000);
		}		
	}

</script>