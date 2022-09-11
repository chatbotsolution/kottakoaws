<?php $pagename=basename($_SERVER["PHP_SELF"]) ; ?> 
<!-- header-area start -->
    <header class="header-area header-area2">
        <div class="header-top">
            <div class="container">
                <div class="row" id="hetop">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-12 mt-2">
                        <ul class="contact-info d-flex">
                            <li>
                                <span class="text-danger"><i class="fa fa-phone"></i> +91 100 200 3001</span>
                            </li>
                            <li>
                                <span class="text-danger"><i class="fa fa-envelope"></i> info@youremail.com</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-sm-4 col-12 d-none d-md-block mt-3">
                            <ul class="mainmenu d-flex justify-content-end">
                              <li><a href="" class="text-danger"><img src="<?= base_url(); ?>/public/assets/images/bg/icon.png" style="height:20px; margin:0 3px 5px 0;">Apply Fastag</a></li>
                                <li><a href="<?= base_url(); ?>/login" class="text-danger"><img src="<?= base_url(); ?>/public/assets/images/bg/icon.png" style="height:20px; margin:0 3px 5px 0;">Login</a></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom bg-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-7">
                        <div class="logo" style="margin-top: -10px;">
                            <a href="index.html">
                                <img src="<?= base_url(); ?>/public/assets/images/logo.png" height="70px" alt="" class="logo11">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-9 d-none d-lg-block mt-2">
                        <ul class="mainmenu d-flex justify-content-end">
                            <li <?php if($pagename == "index.php"){ echo 'class="active"';} ?>><a href="<?= base_url(); ?>">Home</a>
                            </li>
                            <li <?php if($pagename == "aboutus"){ echo 'class="active"';} ?>><a href="<?= base_url(); ?>/aboutus">about us</a></li>
                            <li <?php if($pagename == "service"){ echo 'class="active"';} ?>><a href="<?= base_url(); ?>/service">Our Services</a></li>
                            <li <?php if($pagename == "blog"){ echo 'class="active"';} ?>><a href="<?= base_url(); ?>/blog">blog</a></li>
                            <li <?php if($pagename == "contact"){ echo 'class="active"';} ?>><a href="<?= base_url(); ?>/contact">contact</a></li>
                            <li <?php if($pagename == "sales" || $pagename == "salesagent" || $pagename == "teamlead"){ echo 'class="active"';} ?>><a href="javascript:void(0);">Sign Up</a>
                                <ul>
                                    <li><a href="<?= base_url(); ?>/sales">Sales</a></li>
                                    <li><a href="<?= base_url(); ?>/salesagent">Sales agent</a></li>
                                    <li><a href="<?= base_url(); ?>/teamlead">Team Leader Sales</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="d-block d-lg-none col-4 pull-right col-sm-2">
                        <ul class="menu">
                            <li class="first"></li>
                            <li class="second"></li>
                            <li class="third"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- responsive-menu area start -->
            <div class="responsive-menu-area d-block d-sm-none">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <ul class="metismenu">
                                <li class="sidemenu-items"><a class="has-arrow" aria-expanded="false" href="index.php">Home</a></li>
                                <li><a href="about.php">about us</a></li>
                                <li class="sidemenu-items"><a class="has-arrow" aria-expanded="false" href="service.html">Our Service</a></li>
                                <li><a href="blog.php">blog</a></li>
                                <li><a href="contact.php">contact</a></li>
                                <li><a href="login.php">Login</a></li>
                                <li><a href="">Apply Fastag</a></li>
                                <li class="sidemenu-items"><a class="has-arrow" aria-expanded="false" href="sales.html">Sign Up</a>
                                    <ul aria-expanded="false">
                                        <li><a href="sales.php">Sales</a></li>
                                        <li><a href="sales_agent.php">Sales agent</a></li>
                                        <li><a href="team_leader_sales.php">Team Leader Sales</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- responsive-menu area end -->
        </div>
        
    </header>
    <!-- header-area end -->