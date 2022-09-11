<!--DOCTYPE html-->
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay- Admin Panel</title>
    <link rel="icon" href="<?= base_url(); ?>/public/assets/images/logo.png">
    <?= $this->include('partials/adminPanel/css.php'); ?>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

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
                            <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
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
                                <a class="new nav-link full-screen-link" href="#"><svg
                                        xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-maximize">
                                        <path
                                            d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                                        </path>
                                    </svg></a>
                            </div>
                            <div class="dropdown main-profile-menu nav nav-item nav-link">
                                <?= $this->include('partials/adminPanel/headProfile.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

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
                                <div>
									<h6 class="card-title mb-1 card-flt">Sales Territory</h6>
							    </div>
								
								<form class="row" action ="<?= base_url(); ?>/secure/salesterritory" method="post" autocomplete="off" enctype='multipart/form-data' onsubmit="return validateForm()"  style="margin-bottom:30px;">
                                        <div class="form-group col-lg-3">
                                                <select name="state" id="state" class="form-control">
                                                    <option value="">Select Your State</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                </select>
                                        </div>
                                        
                                        <div class="form-group form-inline col-lg-4">
                                            <div class="col-sm-6"><lable>Choose City / Toll :</lable></div>
                                            <div class="col-sm-6">
                                                <select name="cityortoll" id="cityortoll" class="form-control" onchange="Shwfld(this.value);">
                                                    <option value="">Select City or Toll</option>
                                                    <option value="city">City</option>
                                                    <option value="toll">Toll</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group form-inline col-md-12 shwdta">
                                            
                                        </div>
                                        

                                </form>	  
                                
                                <div class="col-lg-12 pl-0 pr-0">
                                    <div>
    									<h6 class="card-title mb-1 card-flt">Add Sales Territory</h6>
    							    </div>
                                </div>
                                
                                <form action ="<?= base_url(); ?>/secure/salesterritoryexcel" method="post" onsubmit="return validateUploadForm()" autocomplete="off" enctype='multipart/form-data'  style="margin-bottom:30px;">
										<div class="form-group row">
										        <div class="col-md-2" style="padding-left: 25px;padding-top: 10px;">
										            <label style="font-weight: 500;">Select City or Toll<span style="color: red">*</span></label>
										        </div>
										        <div class="col-md-4">
										            <select name="cityortollcsv" id="cityortollcsv" class="form-control" style="max-width:50%;">
										                 <option>Select City or Toll</option>
        												 <option value="City">City</option>
        												 <option value="Toll">Toll</option>
        											</select> 
										        </div>
										</div>
                                        <div class="form-group row">
                                            <div class="col-md-2" style="padding-left: 25px;padding-top: 10px;">
                                                <label style="font-weight: 500;">Fast Tag CSV <span style="color: red">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <input type="file" name="file" title="Upload CSV File" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                            
											<input type="submit" class="allocated-button btn btn-info rounded-corner" value="Add Territories">
                                        </div>
                                </form>
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

<script>
    
    function Shwfld(val){
        var type = val;
        
        if(type != ""){
            
            $.ajax({
                type:'post',
                data:{type:type},
                url:'<?= base_url(); ?>/secure/salesterritory',
                success: function(data){
                    $(".shwdta").html(data);
                }
            });
        }else{
            $(".shwdta").html("");
        }
    }
    
    
    function validateForm(){
        var state = document.getElementById("state").value;
        var cityortoll = document.getElementById("cityortoll").value;
        
        if(cityortoll == "city"){
            
            var ccity = document.getElementById("ccity").value;
            var cdistrict = document.getElementById("cdistrict").value;
            
            if(state =="" || ccity =="" || cdistrict ==""){
                if(state ==""){
                    document.getElementById("state").style.border="1px solid red";
                }else{
                    document.getElementById("state").style.border="";
                }
                
                if(ccity ==""){
                    document.getElementById("ccity").style.border="1px solid red";
                }else{
                    document.getElementById("ccity").style.border="";
                }
                
                if(cdistrict ==""){
                    document.getElementById("cdistrict").style.border="1px solid red";
                }else{
                    document.getElementById("cdistrict").style.border="";
                }
                
                return false;
            }else{
                return true;
            }
        
        }else if(cityortoll == "toll"){
            
            var tplazacode = document.getElementById("tplazacode").value;
            var ttype = document.getElementById("ttype").value;
            var tplazatype = document.getElementById("tplazatype").value;
            var tplazacity = document.getElementById("tplazacity").value;
            var tconcess = document.getElementById("tconcess").value;
            var tplazaname = document.getElementById("tplazaname").value;
            
            if(state =="" || tplazacode =="" || ttype =="" || tplazatype =="" || tplazacity =="" || tconcess =="" || tplazaname ==""){
                
                if(state ==""){
                    document.getElementById("state").style.border="1px solid red";
                }else{
                    document.getElementById("state").style.border="";
                }
                
                if(tplazacode ==""){
                    document.getElementById("tplazacode").style.border="1px solid red";
                }else{
                    document.getElementById("tplazacode").style.border="";
                }
                
                if(ttype ==""){
                    document.getElementById("ttype").style.border="1px solid red";
                }else{
                    document.getElementById("ttype").style.border="";
                }
                
                if(tplazatype ==""){
                    document.getElementById("tplazatype").style.border="1px solid red";
                }else{
                    document.getElementById("tplazatype").style.border="";
                }
                
                if(tplazacity ==""){
                    document.getElementById("tplazacity").style.border="1px solid red";
                }else{
                    document.getElementById("tplazacity").style.border="";
                }
                
                if(tconcess ==""){
                    document.getElementById("tconcess").style.border="1px solid red";
                }else{
                    document.getElementById("tconcess").style.border="";
                }
                
                if(tplazaname ==""){
                    document.getElementById("tplazaname").style.border="1px solid red";
                }else{
                    document.getElementById("tplazaname").style.border="";
                }
                
                return false;
            }else{
                return true;
            }
            
        }
    }
    
    
    
    
</script>





