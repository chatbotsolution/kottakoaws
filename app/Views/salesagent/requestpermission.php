<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <?= $this->include('layouts/adminseoMeta.php'); ?>
    <title>Hitchpay - Admin Panel</title>
    <link rel="icon" href="<?= base_url(); ?>/public/asset/images/logo.png">
    <?= $this->include('partials/salesagent/css.php'); ?>

    <style>
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
                            <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
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
                                <?= $this->include('partials/salesagent/headProfile.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <!-- <div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								&nbsp;
							</div>
						</div>
					</div> -->
                <div class="card">
                    <div class="card-title card-flt mx-2 my-2 rounded">
                        Request Permission
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url(); ?>/salesagent/requestpermission" method="post" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Bank Name<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" value="<?= set_value('bankname'); ?>" id="bankname" name="bankname"
                                        placeholder="Enter Bank Name">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'bankname'); ?> <?php } ?> </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Person Name<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" value="<?= set_value('personname'); ?>" id="personname" name="personname"
                                        placeholder="Enter Person Name">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'personname'); ?> <?php } ?> </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Father's Name<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" value="<?= set_value('fathername'); ?>" id="fathername" name="fathername"
                                        placeholder="Enter Father's Name">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'fathername'); ?> <?php } ?> </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Phone No.<span style="color: red">*</span> :</label>
                                    <input type="number" class="form-control" onkeypress="if(this.value.length == 10){return false;}" value="<?= set_value('phoneno'); ?>" id="phoneno" name="phoneno" name="phoneno" placeholder="Enter Phone Number">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'phoneno'); ?> <?php } ?> </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Email<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>"
                                        placeholder="Enter Email">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'email'); ?> <?php } ?> </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Adhaar<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" id="adhaar" name="adhaar" value="<?= set_value('adhaar'); ?>"
                                        placeholder="Enter Adhaar Number">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'adhaar'); ?> <?php } ?> </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">PAN No.<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" id="panno" name="panno" value="<?= set_value('panno'); ?>"
                                        placeholder="Enter PAN Number">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'panno'); ?> <?php } ?> </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Address<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= set_value('address'); ?>"
                                        placeholder="Enter Address">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'address'); ?> <?php } ?> </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Toll_Plaza_Name<span style="color: red">*</span> :</label>
                                    <input type="text" class="form-control" id="tollplazaname" name="tollplazaname" value="<?= set_value('tollplazaname'); ?>"
                                        placeholder="Enter Toll Plaza Name">
                                  <span class="errmsg" style="text-align:left;"> <?php if(isset($validations)){ ?> <?= show_form_error($validations,'tollplazaname'); ?> <?php } ?> </span>
                                </div>
                            </div>
                           <div class="form-row">
                             	<div class="form-group col-md-12" style="text-align: end;">
                                    <input type="submit" class="allocated-button btn btn-info" value="Submit">
                                </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
            <?= $this->include('partials/salesagent/js.php'); ?>
</body>

</html>