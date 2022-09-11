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
            <form action="<?=base_url(); ?>/adminLogin" method="post">
                    <h2 class="text-danger text-center mr-5">Admin Login</h2>
                    <div class="row form-group">
                        <div class="col-md-10">
                            <label for="uname" class="text-primary">User Id</label>
                            <input type="text" name="userName" placeholder="User Id" class="form-control">
                            <span class="errmsg"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'userName'); ?> <?php } ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-10">
                            <label for="pass" class="text-primary">Password</label>
                            <input type="password" name="Password" placeholder="Password" class="form-control">
                            <span class="errmsg"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'Password'); ?> <?php } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">login</button>
                        </div>                    
                    </div>

            </form>
            </div>
        </div>
    <script src="<?= base_url(); ?>/public/assets/js/main.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/script.js"></script>
    </body>

</html>