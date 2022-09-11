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
				<!-- 	<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
						<div class="row" style="margin-top: 8px;">
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
                                  <span id="msg"></span>                                  
									<div class="col-lg-12 col-md-12" style="padding-bottom: 50px;">	
										<div>
											<h6 class="card-title mb-1 card-flt"> Allot Barcode ( Registered User ) </h6>
										</div>
										<form action ="<?= base_url(); ?>/oem/tagactivationexisting" method="post" autocomplete="off" enctype="multipart/form-data" ?>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Enter Registered Mobile Number </label>
												<div class="col-sm-9">
													<input type="number" onkeypress="if(this.value.length == 10){ return false; }" name="mobilenum" value="<?= set_value('mobilenum'); ?>" class="form-control mg-b-10" style="max-width:50%;">
													<span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'mobilenum'); ?> <?php } ?> </span>
												</div>
											</div>
											<div class="col-md-12">                                            
												<input type="submit" class="allocated-button btn btn-info" value="Search Status">
											</div>
										</form>
									</div> 
									<div class="col-md-12 col-lg-12">
										<div class="row">
                                          <div class="col-md-12 col-lg-12">
                                         <form id="form_submit">
											<div class="col-md-12 col-lg-12">	
												<?php

													if(isset($customerverfctn)){
														$data = json_decode($customerverfctn)[0];
														$array = json_decode(json_encode($data), true);                                                   
                                                      
														if($array['STATUS'] == "SUCCESS" && $array['RESPONSECODE'] == 00){
												?>									  
												<table class="table table-bordered">
													<tr>
														<td> <strong> Customer Id</strong> <br> <?= $array['CUSTOMERID']; ?> 
                                                           <input type="hidden" name="custid" value="<?= $array['CUSTOMERID']; ?>">
                                                        </td>
														<td> <strong> Customer Name </strong> <br> <?= $array['CUSTOMERNAME']; ?>
                                                           <input type="hidden" name="custnme" value="<?= $array['CUSTOMERNAME']; ?>">
                                                          <input type="hidden" name="agntp" value="<?= $array['AGENTTYPE']; ?>">
                                                        </td>
													</tr>
													<tr>
														<td> <strong> Registered Contact Number </strong> <br> <?= $array['MOBILENUMBER']; ?> 
                                                          <input type="hidden" name="custnum" value="<?= $array['MOBILENUMBER']; ?>">
                                                        </td>
														<td> <strong> Email Id </strong> <br> <?= $array['EMAILID']; ?> </td>
													</tr>
                                                  
                                                  	<tr>
														<td> <strong> Select Barcode </strong>
                                                          <select class="form-control" name="barcode" id="barcode" placeholder="Select Barcode">
                                                            <option value="">Select Barcode</option>
                                                            <?php foreach($slctdfstg as $fstg): ?>
                                                               <option value="<?= $fstg["barcode"]; ?>"> <?= $fstg["barcode"]; ?> </option>
                                                            <?php endforeach; ?>
                                                          </select>
                                                        </td>
                                                        <td> <strong> Select Product </strong>
                                                          <select class="form-control" name="prd" id="prd" onchange="shwClassTag(this.value);">
                                                              <option value=""> Select Product </option>
                                                              <?php
                                                                 foreach($product as $tagg):
                                                              ?>
                                                                  <option value="<?= $tagg["productid"]; ?>"> <?= $tagg["prodctCode"]; ?> </option>
                                                              <?php 
                                                                 endforeach;
                                                              ?>
                                                          </select>
                                                        </td>
													</tr>                                                  
                                                    <tr class="shwTag">
														
													</tr>
                                                    <tr class="shwTag1">
														
													</tr>
                                                    <tr>
                                                      <td>
                                                        <strong> Vehicle Data Type </strong>
                                                            <select class="form-control mg-b-10" name="vehicleidtype" id="vehicleidtype">
                                                                <option value="1"> Vehicle Number </option>
                                                                <option value="2"> Chassis Number </option>
                                                            </select>
                                                      </td>
                                                      <td>
                                                      		<strong> Vehicle Number / Chassis Number </strong>
                                                            <input type="text" style="text-transform:uppercase;" name="vehiclenumber" id="vehiclenumber" Placeholder="Vehicle Number / Chassis Number" class="form-control mg-b-10">
                                                      </td>
                                                    </tr>
                                                  <tr>
                                                     <td>
                                                       <strong> RC Book Image </strong>
                                                            <input type="file" style="text-transform:uppercase;" name="drivinglicence" id="drivinglicence" title="RC Book Image" class="form-control mg-b-10">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2">
                                                        <div class="col-md-12 text-center">                                            
                                                            <input type="button" class="btn btn-main-primary" id="submit_frm" value="Activate Tag">
                                                        </div>
                                                    </td>
                                                  </tr>
												</table>
                                                    
                                                  </div>
												<?php
														}else{
													   echo'<table class="table table-bordered">
																<tr>
																	<td> '.$array['STATUS'].' </td>
																</tr>
															</table>';
														}
													}
												?>
                                          </form>
                                            </div>
										</div>
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

	function shwClassTag(val){
		var shwclssTag = val;
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/oem/tagactivationexisting',
				data:{shwclssTag:shwclssTag},
				success: function(data){
					$(".shwTag").html(data);
				}
			});
	}
  
  	function shwsome(val){
		var barcodetype = val;
		if(barcodetype == ""){
			$(".clstg1").html("Class Of Barcode Is Required");
		}else{	
			$(".clstg1").html("");	
			$.ajax({
				type:'POST',
				url:'<?= base_url(); ?>/oem/tagactivationexisting',
				data:{barcodetype:barcodetype},
				success: function(data){
					$(".shwTag1").html(data);
				}
			});
	    }
	}
  
  	let myWindow;
  
  $(document).on('click','#submit_frm',function (event) {
        event.preventDefault();
        var form = $('#form_submit')[0];
        var formData = new FormData(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });

    var barcode = document.getElementById('barcode').value;
    var prd = document.getElementById('prd').value;
    var vehiclenumber = document.getElementById('vehiclenumber').value;
    var drivinglicence = document.getElementById('drivinglicence').value;
    
    if(prd != ""){
      var barcodetyp = document.getElementById('barcodetyp').value;
      if(barcodetyp != ""){
        var typee = document.getElementById("typee").value;
        document.getElementById('barcodetyp').style.border="";
      }else if(barcodetyp == ""){
        document.getElementById('barcodetyp').style.border="1px solid red";
      }
    }else{
      var barcodetyp = "";
      var typee = "";
    }

		if(barcode == "" || barcodetyp == "" || vehiclenumber == "" || drivinglicence == "" || prd ==""){
			if(prd != ""){
              if(barcodetyp == ""){
                  document.getElementById('barcodetyp').style.border="1px solid red";
              }else{
                  document.getElementById('barcodetyp').style.border="";
              }
            }
          
          if(vehiclenumber == ""){
				document.getElementById('vehiclenumber').style.border="1px solid red";
			}else{
				document.getElementById('vehiclenumber').style.border="";
			}
          
          if(drivinglicence == ""){
				document.getElementById('drivinglicence').style.border="1px solid red";
			}else{
				document.getElementById('drivinglicence').style.border="";
			}
          
          if(barcode == ""){
            $(".selectize-input").attr("style","border:1px solid red;");
          }else{
            $(".selectize-input").attr("style","border:;");
          }
          
          if(prd == ""){
				document.getElementById('prd').style.border="1px solid red";
			}else{
				document.getElementById('prd').style.border="";
			}
			

		}else{
            document.getElementById('barcodetyp').style.border="";
            document.getElementById('vehiclenumber').style.border="";
            document.getElementById('drivinglicence').style.border="";
            document.getElementById('prd').style.border="";
          

        $.ajax({
            url: "<?= base_url(); ?>/oem/activatinguser",
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
              $("#msg").html('<div class="alert alert-success alert-dismissible fade show">' + data + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
      }

    });
  

</script>
<script>
  $(document).ready(function () {
    $('#barcode').selectize({
      sortField: 'text'
    });
  });
</script>