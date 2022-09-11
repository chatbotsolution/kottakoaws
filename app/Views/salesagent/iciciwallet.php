<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesagent/css.php'); ?>
  
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
               <!--  <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
					<div class="row" style="margin-top: 8px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row" style="overflow: scroll;">
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
                                <?php
                                   if(sizeof($icicirequestid) == 0){
                                ?>
                                    <p class="text-center"> <i class="fa fa-times-circle" style="font-size: 150px;color:red;"></i> </p>
                                    <p class="text-center" style="font-size: 20px;font-weight: 700;color:red;"> ICICI ID NEED TO BE CREATED BEFORE RECHARGE </p>
                                <?php
                                   }else if($icicirequestid[0]['status'] != 0){
                                ?>
                                    <p class="text-center"> <i class="fa fa-times-circle" style="font-size: 150px;color:red;"></i> </p>
                                    <p class="text-center" style="font-size: 20px;font-weight: 700;color:red;"> ICICI ID NEED TO BE CREATED BEFORE RECHARGE </p>
                                <?php
                                   }else{
                                ?>
                                    <div class="col-lg-12 col-md-12" style="margin-top:40px;">
                                      <div class="row">
                                          <h6 class="card-title mb-1 card-flt" style="width:100%;">Add Wallet Balance</h6>
                                      </div>
                                      <form id="makepaymentform" method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validatefrm()">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Amount</label>
                                            <div class="col-sm-5">
                                                <input type="number" name="amount" id="amount" value="<?= set_value('amount'); ?>" class="form-control mg-b-10">
                                                <span class="errmsg" id="amnt" style="text-align:left;"> </span>
                                            </div>
                                            <div class="col-md-2">                                            
                                              <input type="button" id="makpayment" class="btn btn-main-primary" value="Make Payment">
                                            </div>
                                        </div>                                        
                                      </form>
                                    
                                      <table class="table-data table table-bordered" id="users-list">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL_NO</th>
                                              	<th style="padding: 10px 10px;">Amount_Request_Date</th>
												<th style="padding: 10px 10px;">Amount</th>
                                              	<th style="padding: 10px 10px;">Transaction_Id</th>
                                              	<th style="padding: 10px 10px;">Status_of_ICICI_Wallet</th>
                                              	<th style="padding: 10px 10px;">Approval_Time</th>
                                              	<th style="padding: 10px 10px;">Approving Admin Id</th>
                                                <th style="padding: 10px 10px;">Amount_In_ICICI_Wallet</th>
                                              	<th style="padding: 10px 10px;">After_Addition</th>
                                              	<th style="padding: 10px 10px;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                             $i=0;
                                             foreach($iciciwallettransaction as $iccwallet):
                                             $i++;
                                          ?>
                                            <tr>
                                                <td> <?= $i; ?> </td>
                                                <td> <?= date("d-m-Y", strtotime($iccwallet["datetime"])); ?> </td>
                                                <td> Rs. <?= number_format($iccwallet["amount"],2); ?> </td>
                                                <td> <?= $iccwallet["transactionid"]; ?> </td>
                                                <td> <?php if($iccwallet["status"] ==0){ echo"APPROVED";}else if($iccwallet["status"] ==1){ echo"PENDING";}else if($iccwallet["status"] ==2){ echo"FAILED";}else if($iccwallet["status"] ==3){ echo"IN PROCESS";} ?> </td>
                                                <td> <?= date("h:i:s", strtotime($iccwallet["approveddatetime"])); ?> </td>
                                                <td> <?= $iccwallet["approvedbyid"]; ?> </td>
                                                <?php
                                                    if($iccwallet["amountinicici"] != ""){
                                                ?>
                                                      <td> Rs. <?= number_format($iccwallet["amountinicici"],2); ?> </td>
                                                <?php
                                                    }
                                                ?>
                                              
                                              	<?php
                                                    if($iccwallet["amounticiciafteraddition"] != ""){
                                                ?>
                                                     <td> Rs. <?= number_format($iccwallet["amounticiciafteraddition"],2); ?> </td>
                                                <?php
                                                    }
                                                ?>
                                                
                                                
                                                <td> <?= $iccwallet["remark"]; ?> </td>
                                            </tr>
                                          <?php
                                             endforeach;
										  ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                                    
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

<script>
function validatefrm(){
  
  var amnt = document.getElementById("amount").value;
  
  if(amnt > 2000){
    $(".web").html("Amount allowed is Rs. 2000 or Less");
    return false;
  }else{
    return true;
  }
  
}
  
  
  $(document).on('click','#makpayment',function (event) {
        event.preventDefault();
        var form = $('#makepaymentform')[0];
        var formData = new FormData(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });

    var amount = document.getElementById('amount').value;

		if(amount == ""){

			if(amount == ""){
				$("#amnt").html('Amount Is Required');
			}else{
				$("#amnt").html('');
			}


		}else if(amount > 2000){
            $("#amnt").html('Amount Should Be Rs. 2000 Or Less');
        }else{
            $("#amnt").html('');

        $.ajax({
            url: "<?= base_url(); ?>/salesagent/iciciwallet",
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
              const obj = JSON.parse(data);
              var URL=obj.paymentLink;
              location.href=URL;
            }
        });
      }

    });


</script>

















