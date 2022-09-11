<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/adminPanel/css.php'); ?>
  
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <style>
  	body {
      font-family: "Montserrat", "Ubuntu";
    }
    
    .table-data {
      font-weight: 450;
      font-size: 11px;
      text-align: center;
    }
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
                                       <div class="row">
                                         <div class="col-md-3">
                                           <input type="text" placeholder="No.of Tags" id="noofbox" style="width: 226px; height: 26px; border: 1px solid #e1e5ef; padding: 1.0rem 0.5rem; font-size: .875rem; font-weight: 400; line-height: 1.5; color: #4d5875; border-radius: 3px">
                                           <button class="allocated-button btn btn-info mt-2 mb-2 rounded-top" onclick="selects();">
                                              Select Tag
                                           </button>
                                         </div> 
                                         <div class="col-md-3 ml-auto" style="margin-bottom:40px;">
                                           <input type="text" class="form-control" name="searchname" id="searchname" placeholder="Single Search Tag" onkeyup="if(this.value == 0){ return false; }else{ getval(this.value); }" onkeyup="getval(this.value);" style="height: 33.25px; width: 224.5px">                                             
                                         </div>
                                         <div class="col-md-2">
                                             <label id="shwCount"></label>
                                         </div>
                                      </div>
                                    <table class="table table-bordered table-data">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">Bank Name</th>
                                                <th style="padding: 10px 10px;">Barcode</th>
                                                <th style="padding: 10px 10px;">Tag Id</th>
                                                <th style="padding: 10px 10px;">TID</th>
                                                <th style="padding: 10px 10px;"> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody class="shww">
                                            <?php 
                                                $i=0;
                                                foreach($barcode as $saledata):
                                                    $i++;
                                            ?>
                                                <tr>
                                                    <td>
                                                      <div id="itemForm">
                                                        <input type="checkbox" name="checkedtogive" id="checkedtogive<?= $saledata["fasttagid"]; ?>" value="<?= $saledata["fasttagid"]; ?>">
                                                        <?= $i; ?>
                                                      </div>
                                                    </td>
                                                    <td><?= $saledata["bankname"]; ?></td>
                                                    <td><?= $saledata["barcode"]; ?></td>
                                                    <td><?= $saledata["tagid"]; ?></td>
                                                    <td><?= $saledata["tid"]; ?>
                                                     <input type="hidden" value="<?= $saledata["fasttagid"]; ?>" name="tagsrollback<?= $saledata["fasttagid"]; ?>">
                                                    </td>
                                                    <td> <button class="allocated-button btn btn-sm btn-info" onclick="rollback('<?= $saledata["fasttagid"]; ?>');"> Rollback </button> </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>  
                                      <!-- pagination start -->
                                      
                                      <div class="d-flex justify-content-end hde">
                                      <?php if ($pager) :?>
                                      <?php $pagi_path='secure/returntag'; ?>
                                      <?php $pager->setPath($pagi_path); ?>
                                      <?= $pager->links() ?>
                                      <?php endif ?>
                                    </div>
                                      <!-- pagination end -->
                                    <button class="allocated-button btn btn-info hde" onclick="rollbackall('checkedtogive');">
										Rollback Tag
									</button>
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
    
    function rollback(val){
        var rollbackid = val;
        var checkboxes = document.querySelectorAll('input[name="tagsrollback'+ rollbackid +'"]'), values = [];
        
        Array.prototype.forEach.call(checkboxes, function(el) {
			values.push(el.value);                
		});
		
    		$.ajax({
        		type:'post',
        		url:'<?= base_url(); ?>/secure/returntag',
        		data:{rollbackid:values,add:1},
        		success: function(data){
        			$("#passModelData").html(data);
				    $("#passModel").modal("show");
    		    }
    	   });
    }
    
    function rollbackall(checkboxName){
        var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
        
        Array.prototype.forEach.call(checkboxes, function(el) {
			values.push(el.value);                
		});
		if(values.length != 0){
    		$.ajax({
        		type:'post',
        		url:'<?= base_url(); ?>/secure/returntag',
        		data:{rollbackid:values,add:1},
        		success: function(data){
        			$("#passModelData").html(data);
				    $("#passModel").modal("show");
    		    }
    	   });
		}
    }
</script>
<script>
    function selects(){  
    var noofbox = document.getElementById("noofbox").value;
    var ele=document.getElementsByName('checkedtogive');  
    for(var i=0; i<ele.length; i++){  
      if(ele[i].type=='checkbox')  
        ele[i].checked=false;  

    }
    for(var i=0; i<noofbox; i++){  
      if(ele[i].type=='checkbox')  
        ele[i].checked=true;  
       $("#shwCount").html((i + 1) + ' Tags Selected');
    }  
  }
</script>
<script>

  function getval(val){
    
    if(val != ""){
      var searchvalue = val;
    }else if(val == 0){
      var searchvalue = "a";
    }else{
      var searchvalue = "a";
    }

    $.ajax({
      type:'post',
      url:'<?= base_url(); ?>/secure/returntag',
      data:{searchvalue:searchvalue},
      success: function(data){
        $(".shww").html(data);
        $(".hde").attr("style","display:none !important;");
      }
    });  
  }
  

</script>

















