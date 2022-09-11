<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
	<link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
     <?= $this->include('partials/salesManager/css.php'); ?>
  
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  
  <style>
    
    body {
      font-family: "Montserrat", "Ubuntu";
    }
    
     .manage-fastag {
       margin-left: 400px;
       font-weight: bold;
       font-size: 20px;
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
			    <?= $this->include('partials/salesManager/headerLogo.php'); ?>
				<?= $this->include('partials/salesManager/sidebar.php'); ?>
			</aside>
			<div class="main-content app-content">
				<div class="main-header sticky side-header nav nav-item layout-pin">
					<div class="container-fluid">
						<div class="main-header-left ">
						    <?= $this->include('partials/salesManager/headerLogoMobile.php'); ?>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>						
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="dropdown nav-item main-header-message ">
								   <?= $this->include('partials/salesManager/headMessage.php'); ?>
								</div>
								<div class="dropdown nav-item main-header-notification">
								   <?= $this->include('partials/salesManager/headNotification.php'); ?>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
								    <?= $this->include('partials/salesManager/headProfile.php'); ?>
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
                                    <div class="col-lg-12 col-md-12" style="margin-top:10px;">
                                        <label style="font-weight: 500;">Advance Search For Barcode</label>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <input type="text" name="firstnum" id="firstnum" value="<?= set_value('firstnum'); ?>" Placeholder="Barcode First Number" class="form-control mg-b-10" style="width: 224.5px;height: 33.25px;">
                                                <span class="frstnum errmsg" style="text-align:left;"></span>
                                            </div>
                                          	<div class="col-sm-3">
                                                <input type="text" name="lastnum" id="lastnum" value="<?= set_value('lastnum'); ?>" Placeholder="Barcode Last Number" class="form-control mg-b-10" style="width: 224.5px;height: 33.25px;">
                                                <span class="lstnum errmsg" style="text-align:left;"></span>
                                            </div>
                                            <div class="col-md-3">                                            
                                              <input type="button" class="allocated-button btn btn-info" value="Search Tag" onclick="searchTag();" style="font-weight: 500;">
                                            </div>
                                          <div class="col-md-3 text-right" style="margin-bottom:40px;">
                                           <input type="text" class="form-control" name="searchname" placeholder="Single Search Tag" onkeyup="getval(this.value);" style="height: 33.25px; width: 224.5px">                                             
                                         </div>
                                        </div>
                                    </div>
                                  
                                  
                                    <div class="col-lg-12 col-md-12" style="margin-top:0px;">
                                       <div class="row">
                                         <div class="col-md-3">
                                           <input type="text" placeholder="Enter Value" id="noofbox" style="width: 226px; height: 26px; border: 1px solid #e1e5ef; padding: 1.0rem 0.5rem; font-size: .875rem; font-weight: 400; line-height: 1.5; color: #4d5875; border-radius: 3px">
                                           <button class="allocated-button btn btn-info mt-2 mb-2 rounded-top" onclick="selects();">
                                              Select Tag
                                           </button>
                                         </div>                                         
                                         <div class="col-md-2">
                                             <label id="shwCount"></label>
                                         </div>
                                         <div class="col-md-5 text-right" style="margin-left: 155px;">
                                          <a href="<? base_url(); ?>/salesmanager/fastaginventory/allocated">
                                             <button class="allocated-button btn btn-info">
                                                Show Allocated Tag
                                             </button>
                                           </a> 
                                           <a href="<? base_url(); ?>/salesmanager/fastaginventory/unallocated">
                                             <button class="allocated-button btn btn-info">
                                                Show Un-Allocated Tag
                                             </button>
                                           </a>
                                         </div>
                                   <!--      <div class="col-md-2 text-right" style="margin-bottom:40px;">
                                           <input type="text" class="form-control" name="searchname" placeholder="Enter Barcode" onkeyup="getval(this.value);">                                            
                                         </div> -->
                                      </div>
                                      
                                      
                                    <table class="table table-bordered table-data">
                                       <!--  id="users-list"-->
                                        <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                            <tr>
                                                <th style="padding: 10px 10px;">SL NO</th>
												<th style="padding: 10px 10px;">Bar Code</th>
                                                <th style="padding: 10px 10px;">Tag Id</th>
                                                <th style="padding: 10px 10px;">Class Of Tag</th>
                                                <th style="padding: 10px 10px;">Status</th>
                                                <th style="padding: 10px 10px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="shww">
                                            <?php 
                                                $i=0;
                                                foreach($fastag as $saledata):
                                                    $i++;

                                                    if($saledata["status"] == 0){
                                                        $sts="Active";
                                                        $btn1='<button class="btn btn-sm btn-info" onclick="allot_tag(\''.$saledata["fasttagid"].'\',\''.$saledata["inventoryid"].'\');"> Allot Fastag </button>';
													}else if($saledata["status"] == 1){
                                                        $sts="Allocated";
														$btn1="";                                                    
													}else{
														$sts="";
														$btn1="";
													}
                                            ?>
                                                <tr>
                                                    <td>
                                                      <div id="itemForm">
                                                        <?php if($saledata["status"] == 0){ ?>
                                                         
                                                        <input type="checkbox" name="checkedtogive" id="checkedtogive<?= $saledata["fasttagid"]; ?>" value="<?= $saledata["fasttagid"]; ?>">
                                                        <input type="hidden" name="invntid" id="<?= $saledata["fasttagid"]; ?>" value="<?= $saledata["inventoryid"]; ?>">
                                                        
                                                        <?php }else{ ?>
                                                         
                                                        <input type="checkbox" disabled="disabled">
                                                        
                                                        <?php } ?> 
                                                        <?= $i; ?>
                                                      </div>
                                                    </td>
                                                    <td><?= $saledata["barcode"]; ?></td>
                                                    <td><?= $saledata["tagid"]; ?></td>
                                                    <td><?= $saledata["classoftag"]; ?></td>
                                                    <td><?= $sts; ?></td>
                                                    <td>
														<?= $btn1; ?>
                                                    </td>
                                                    
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                      <div class="d-flex justify-content-end fgt">
                                        <?php if ($pager) :?>
                                        <?php $pagi_path='salesmanager/fastaginventory/'.$type.''; ?>
                                        <?php $pager->setPath($pagi_path); ?>
                                        <?= $pager->links() ?>
                                        <?php endif ?>
                                      </div>
                                    <button class="allocated-button btn btn-info" onclick="sendtag('checkedtogive','invnt');">
										Send Tag
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
        <?= $this->include('partials/salesManager/js.php'); ?>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
	function allot_tag(val,invntid){
        var fastagid= val;

		$.ajax({
			type:'post',
			url:'<?= base_url(); ?>/salesmanager/fastaginventory',
			data:{fastagid:fastagid,invntid:invntid},
			success: function(data){
				$("#passModelData").html(data);
				$("#passModel").modal("show");
			}
		});
	}

	function allot(){
		var fasttagid = document.getElementById("fastatgidd").value;
		var salesmngis = document.getElementById("salesmanager").value;invntid
        var invntid = document.getElementById("invntid").value;
		
		if(salesmngis == ""){
			$("#ermid").html("Team Lead Is Required");
		}else{
			$("#ermid").html("");
			$.ajax({
				type:'post',
				url:'<?= base_url(); ?>/salesmanager/fastaginventory',
				data:{fasttagid:fasttagid,salesmngis:salesmngis,invntid:invntid},
				success: function(data){
					if(data =="done"){
						$("#mdg").html('<div class="alert alert-success alert-dismissible fade show"> Fastag Alloted Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
						setTimeout(function(){ location.reload();}, 2000);
					}else{
						$("#mdg").html('<div class="alert alert-danger alert-dismissible fade show"> Sorry Try Again Later <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					}
				}
			});
		}
	}
  
  function sendtag(checkboxName,invnt){
			var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
            var values1 =[];
			Array.prototype.forEach.call(checkboxes, function(el) {
				values.push(el.value);
             	var textbx = document.getElementById(el.value).value;                				
				values1.push(textbx);                
			});
    
			$.ajax({
				type:'post',
				url:'<?= base_url(); ?>/salesmanager/fastaginventory',
				data:{values:values,ad:1,invntid:values1},
				success: function(data){
					$("#passModelData").html(data);
				    $("#passModel").modal("show");
				}
			});
	}

	function shwtyp(val){
		var typ = val;
		$.ajax({
			type:'post',
			url:'<?= base_url(); ?>/secure/managefasttag',
			data:{typ:typ},
			success: function(data){
				$(".shwhrr").html(data);
			}
		});
	}
  
    function checkthis(val){
      $("#"+val).attr('checked',true);
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

 function getval(val){
  
  if(val != ""){
    var searchvalue = val;
  }else{
    var searchvalue = "a";
  }
  
  $.ajax({
    type:'post',
    url:'<?= base_url(); ?>/salesmanager/fastaginventory',
    data:{searchvalue:searchvalue},
    success: function(data){
      $(".shww").html(data);
      $(".fgt").html("");
    }
  });  
}

</script>

<script>

    function searchTag(){
      var firstnum = document.getElementById('firstnum').value;
      var lastnum = document.getElementById("lastnum").value;
      
      if(firstnum == "" || lastnum ==""){
        if(firstnum == ""){
          $(".frstnum").html("First Number Is Required");
        }else{
          $(".frstnum").html("");
        }
        if(lastnum == ""){
          $(".lstnum").html("Last Number Is Required");
        }else{
          $(".lstnum").html("");
        }
        
      }else if(parseInt(lastnum) > parseInt(firstnum)+100 ){
       
         $(".frstnum").html("");
         $(".lstnum").html("Cannot Enter Value More Then 100 From First Number");
        
      }else{
        $(".frstnum").html("");
        $(".lstnum").html("");
        
         $.ajax({
          type:'post',
          url:'<?= base_url(); ?>/salesmanager/fastaginventory',
          data:{firstnum:firstnum,lastnum:lastnum},
          success: function(data){
            $(".shww").html(data);
            $(".fgt").html("");
          }
        });
        
      }
    }
    
    
    
    function shwnumberverify(val){
        var salesagentidotp = val;
        var transctnid = document.getElementById('trnsid').value;
        $.ajax({
            type:'post',
            url:'<?= base_url(); ?>/salesmanager/fastaginventory',
            data:{salesagentidotp:salesagentidotp,transctnid:transctnid},
            success: function(data){
                document.getElementById("moblenumm").setAttribute('value',data);
            }
        });
        
    }


    function sendotp(){
        var transctniddd = document.getElementById('trnsid').value;
        var moblnnumm = document.getElementById('moblenumm').value;
        var salesmanagerfstg = document.getElementById('salesmanagerfstg').value;
      
      if(salesmanagerfstg == ""){
          $('.otppsndt').html('<span style="float:left;"> Team Lead Is Required </span>');
      }else{
        $.ajax({
            type:'post',
            url:'<?= base_url(); ?>/salesmanager/fastaginventory',
            data:{transctniddd:transctniddd,moblnnumm:moblnnumm,salesmanagerfstg:salesmanagerfstg},
            success: function(data){
                if(data =="send"){
                    $('.btnspace').html('<button type="button" class="btn btn-info" onclick="sendotp();" style="position: absolute;top: 0px;left: 325px;padding: 10px;border-radius: 0px 4px 4px 0px;"> RE-SEND OTP </button><button type="button" class="btn btn-info" onclick="verifyotp();" style="position: absolute;top: 0px;left: 445px;padding: 10px;border-radius: 4px 4px 4px 4px;"> VERIFY OTP </button>');
                    $('.otppsndt').html('<span style="color:green;float:left;"> OTP SEND TO SELECTED TEAM LEAD </span>');
                }else{
                    $('.otppsndt').html('<span style="float:left;">' + data + '</span>');
                }
            }
        });
      }
    }
    
    function verifyotp(){
        var transctnidddvrfy = document.getElementById('trnsid').value;
        var moblnnummvrfy = document.getElementById('moblenumm').value;
        var otppvrfy = document.getElementById('ottp').value;
        
        if(otppvrfy == ""){
            $('.otppsndt').html('<span style="float:left;"> OTP Is Required </span>');
        }else{
            $('.otppsndt').html('');
            
            $.ajax({
                type:'post',
                url:'<?= base_url(); ?>/salesmanager/fastaginventory',
                data:{transctnidddvrfy:transctnidddvrfy,moblnnummvrfy:moblnnummvrfy,otppvrfy:otppvrfy},
                success: function(data){
                    if(data =="verified"){
                        $('.btnspace').html('<button type="button" disabled class="btn btn-info" style="position: absolute;top: 0px;left: 325px;padding: 10px;border-radius: 0px 4px 4px 0px;"> VERIFIED </button>');
                        $('.otppsndt').html('');
                        $('#ottp').attr('readonly',true);
                        $("#tagbtnn").attr('disabled',false);
                    }else if(data =="invalidotp"){
                        $('.otppsndt').html('<span style="float:left;"> Invalid OTP ! Try Again </span>');
                    }
                }
            });
        }
    }
</script>




















