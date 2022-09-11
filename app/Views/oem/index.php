<!doctype html>
<html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>HiTch</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>/public/asset/assets/images/favicon.png">
        <!-- Place favicon.ico in the root directory -->
        <!-- all css here -->
        <!-- bootstrap v3.3.7 css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/bootstrap.min.css">
        <!-- animate css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/animate.css">
        <!-- owl.carousel.2.0.0-beta.2.4 css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/owl.carousel.min.css">
        <!-- swiper.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/swiper.min.css">
        <!-- font-awesome v4.6.3 css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/font-awesome.min.css">
        <!-- flaticon.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/flaticon.css">
        <!-- magnific-popup.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/magnific-popup.css">
        <!-- metisMenu.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/metisMenu.min.css">
        <!-- style css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/styles.css">
        <!-- responsive css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/responsive.css">

        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/main.css">
        <!-- modernizr css -->
        <script src="<?= base_url(); ?>/public/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <div class="container">
        <div><img src=""></div>
            <div class="col-md-6 mx-auto" style="margin-top: 15%;">
            <?php if(session()->getTempdata('error')){ ?> <div class="alert alert-danger"><?= session()->getTempdata('error'); ?></div> <?php } ?>
            <form action="<?=base_url(); ?>/oemLogin" method="post">
                    <h2 class="text-danger text-center mr-5">OEM LOGIN</h2>
                    <div class="row form-group">
                        <div class="col-md-10">
                            <label for="uname" class="text-primary">GST NUMBER</label>
                            <input type="text" id="userName" name="userName" placeholder="GST NUMBER" class="form-control">
                            <span class="errmsg"><span class="usrerrmsg"></span></span>
                        </div>
                    </div>
                    <span id="shwwhr">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary btn-sm" onclick="sendOtp();">Send OTP</button>
                            </div>
                            <!--<div class="col-md-2">-->
                                <!--<button type="button" class="btn btn-primary btn-sm" onclick="">Resend OTP</button>-->
                            <!--</div>-->
                            <!--<div class="col-md-4" style="text-align: end;">-->
                            <!--    <button type="button" class="btn btn-info btn-sm" onclick="">Resend OTP</button>-->
                            <!--</div>-->
                        </div>
                    </span>
            </form>
            </div>
        </div>
    <script src="<?= base_url(); ?>/public/assets/js/main.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>

</html>
<script>

    function sendOtp(){
        var usrid= document.getElementById("userName").value;
        
        if(usrid == ""){
            $(".usrerrmsg").html("User Name Is Required");
        }else{

            $.ajax({
                type:'post',
                url:'<?= base_url(); ?>/oem/sendotp',
                data:{usrid:usrid},
                success:function(data){
                    if(data =="invalid"){
                        $(".usrerrmsg").html("Invalid OEM Id");
                    }else if(data =="sorry"){
                        $(".usrerrmsg").html("Sorry Try Again Later");
                    }else{
                        $(".usrerrmsg").html("");
                        $("#shwwhr").html(data);
                    }
                }
            });
        }
    }


    function login(){

        var loginusrid = document.getElementById("userName").value;
        var usrotp = document.getElementById("otp").value;

        if(loginusrid == "" || usrotp ==""){
            $(".usrerrmsg").html("User Name Is Required");
            $(".otperrmsg").html("OTP Is Required");

        }else{

            $.ajax({
                type:'post',
                url:'<?= base_url(); ?>/oem/sendotp',
                data:{loginusrid:loginusrid,usrotp:usrotp},
                success:function(data){
                    if(data =="invalid"){
                        $(".usrerrmsg").html("Invalid OEM Id");
                    }else if(data =="invalidotp"){
                        $(".otperrmsg").html("Invalid OTP");
                    }else if(data =="sorry"){
                        $(".otperrmsg").html("Sorry Try Again Later");
                    }else if(data =="done"){
                        location.reload();
                    }else{
                        $(".usrerrmsg").html("");
                        $("#userName").attr("readonly","readonly");
                        $("#shwwhr").html(data);
                    }
                }
            });
        }
    }

</script>