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
        href="https://fonts.googleapis.com/css2?						family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
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
                                <table class="table table-bordered table-data">
                                    <!-- id="users-list" -->
                                    <thead style="background-color: #FFAFAF; border: 1px solid black;">
                                        <tr>
                                            <th style="padding: 10px 10px;">SL NO</th>
                                            <th style="padding: 10px 10px;">Bank_Name</th>
                                            <th style="padding: 10px 10px;">Person_Name</th>
                                            <th style="padding: 10px 10px;">Email</th>
                                            <th style="padding: 10px 10px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Test</td>
                                            <td>Person</td>
                                            <td>Email</td>
                                            <td>
                                                <a href="#">
                                                    <button class="btn btn-sm btn-success">
                                                        View
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>

                <div>




                </div>
            </div>
        </div>
    </div>
    <a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <?= $this->include('partials/adminPanel/js.php'); ?>
</body>

</html>