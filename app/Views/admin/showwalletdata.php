<!--DOCTYPE html-->
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
					<div class="row" style="margin-top: -8px;">
						<div class="col-lg-12 col-md-12">
							<div class="card row">
								<div class="card-body">	
                                  
                                  <span id="errmsg"></span>
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
                                
                                  
                                  <div class="row" style="margin-bottom:20px;">
                                       <div class="col-md-8">
                                         
                                       </div>
                                       <div class="col-md-2">
                                          <button class="btn btn-info" style="float:right;" onclick="addMoney();">
                                            Add Amount To Wallet
                                         </button>
                                       </div>
                                       <div class="col-md-2">
                                          <button class="btn btn-danger" style="float:right;" onclick="deductMoney();">
                                            Deduct Amount To Wallet
                                         </button>
                                       </div>
                                  </div>
                                    <div class="col-lg-12 col-md-12" style="margin-top:0px;">
                                    <table class="table table-bordered table-data">
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">Transaction Id</th>
                                                <th style="padding: 10px 10px;">Transaction Type</th>
                                                <th style="padding: 10px 10px;">Transaction Status</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;
                                                foreach($walletdata as $saledata):
                                                    $i++;
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $saledata["transactionid"]; ?></td>
                                                    <td><?php if($saledata["transactiontype"] ==1){ echo"CREDIT";}else{ echo"DEBIT"; }; ?></td>
                                                    <td><?php if($saledata["transactionstatus"] ==2){ echo"SUCCESS"; }else if($saledata["transactionstatus"] ==1){ echo"PENDING"; }else{ echo"DECLINED";} ?></td>
                                                    <td>
                                                     <a href="<?= base_url(); ?>/secure/manageallwallet/<?= $saledata["transactionid"]; ?>" target="_blank">
                                                       <button class="btn btn-info btn-sm">
                                                         View Details
                                                       </button>
                                                     </a>  
                                                      <button class="btn btn-warning btn-sm" onclick="refund('<?= $saledata["walletid"]; ?>');">
                                                         Refund
                                                      </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                      <div class="d-flex justify-content-end">
                                        <?php if ($pager) :?>
                                        <?php $pagi_path='secure/manageallwallet'; ?>
                                        <?php $pager->setPath($pagi_path); ?>
                                        <?= $pager->links() ?>
                                        <?php endif ?>
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
        <?= $this->include('partials/adminPanel/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>

    function refund(val){
      
      var refundid = val;
      
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/secure/manageallwallet',
        data:{refundid:refundid},
        success: function(data){
          $("#errmsg").html(data);
          setTimeout(function(){ location.reload(); }, 2000);
        }
      });

    }
  
  
  	function addMoney(){
      var addmoney =1;
      
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/secure/manageallwallet',
        data:{addmoney:addmoney},
        success: function(data){
          $("#passModelData").html(data);
          $("#passModel").modal("show");
        }
      });
      
    }
  
  
   function deductMoney(){
      var deductMoney =1;
      
      $.ajax({
        type:'post',
        url:'<?= base_url(); ?>/secure/manageallwallet',
        data:{deductMoney:deductMoney},
        success: function(data){
          $("#passModelData").html(data);
          $("#passModel").modal("show");
        }
      });
      
    }
  
  
  
  	  $(document).on('click','#addfundsbttn',function (event) {
        event.preventDefault();
        var form = $('#addfundsform')[0];
        var formData = new FormData(form);

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });

        var trnsid = document.getElementById('trnsid').value;
        var salesagentselect = document.getElementById('salesagentselect').value;
        var amnt = document.getElementById('amnt').value;
        

            if(trnsid == "" || salesagentselect == "" || amnt == ""){

                if(trnsid == ""){
                    $('#errtrnsid').html("Transaction Id Is Required");
                }else{
                    $('#errtrnsid').html("");
                }

              if(salesagentselect == ""){
                    $('#errsalesagentselect').html("Sales Agent Is Required");
                }else{
                    $('#errsalesagentselect').html("");
                }

              if(amnt == ""){
                    $('#erramnt').html("Amount Is Required");
                }else{
                    $('#erramnt').html("");
                }


            }else{
                 $('#errtrnsid').html("");
                 $('#errsalesagentselect').html("");
                 $('#erramnt').html("");


            $.ajax({
                url: "<?= base_url(); ?>/secure/manageallwallet",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data){
                  $("#errmsgmdl").html(data);
                  setTimeout(function(){ location.reload(); }, 2000);
                }
            });
          }

    });

</script>
<script>

  	$(document).on('click','#deductfundsbttn',function (event) {
        event.preventDefault();
        var form = $('#deductfundsform')[0];
        var formData = new FormData(form);

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });

        var trnsid = document.getElementById('deducttrnsid').value;
        var salesagentselect = document.getElementById('deductsalesagentselect').value;
        var amnt = document.getElementById('deductamnt').value;
        

            if(trnsid == "" || salesagentselect == "" || amnt == ""){

                if(trnsid == ""){
                    $('#errtrnsid').html("Transaction Id Is Required");
                }else{
                    $('#errtrnsid').html("");
                }

              if(salesagentselect == ""){
                    $('#errsalesagentselect').html("Sales Agent Is Required");
                }else{
                    $('#errsalesagentselect').html("");
                }

              if(amnt == ""){
                    $('#erramnt').html("Amount Is Required");
                }else{
                    $('#erramnt').html("");
                }


            }else{
                 $('#errtrnsid').html("");
                 $('#errsalesagentselect').html("");
                 $('#erramnt').html("");


            $.ajax({
                url: "<?= base_url(); ?>/secure/manageallwallet",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data){
                  $("#errmsgmdl").html(data);
                  setTimeout(function(){ location.reload(); }, 2000);
                }
            });
          }

    });

</script>



















