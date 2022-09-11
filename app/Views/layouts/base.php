<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
<?= $this->include('layouts/seoMeta.php'); ?>
    <title>Odisha Bazaar - Online Shopping</title>
     <?= $this->include('partials/css.php'); ?>
</head>
<body>
    <div class="backdrop"></div><a class="backtop fas fa-arrow-up" href="#"></a>
    <div class="header-top alert fade show">
        <p>20% Discount All New Customers <a href="register.html">get register</a></p><button data-bs-dismiss="alert"><i class="fas fa-times"></i></button></div>
    <header class="header-part">
        <div class="container">
            <div class="header-content">
                <div class="header-media-group"><button class="header-user"><img src="<?= base_url(); ?>/public/asset/images/user.png" alt="user"></button><a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>/public/asset/images/logo.png" alt="logo"></a><button class="header-src"><i class="fas fa-search"></i></button></div><a href="<?= base_url(); ?>" class="header-logo"><img src="<?= base_url(); ?>/public/asset/images/logo.png" alt="logo"></a>
                <a href="<?= base_url(); ?>/userLogin" class="header-widget" title="My Account"><span> sign in or register </span> </a>
                    <form class="header-form"><input type="text" placeholder="Search anything..."><button><i class="fas fa-search"></i></button></form>
                    <div class="header-widget-group"><a href="compare.html" class="header-widget" title="Compare List"><i class="fas fa-random"></i><sup>0</sup></a><a href="wishlist.html" class="header-widget" title="Wishlist"><i class="fas fa-heart"></i><sup>0</sup></a><button class="header-widget header-cart"
                            title="Cartlist"><i class="fas fa-shopping-basket"></i><sup>9+</sup><span>total price<small>$345.00</small></span></button></div>
            </div>
        </div>
    </header>

    <?= $this->renderSection("content"); ?>

    <footer class="footer-part">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget"><a class="footer-logo" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>/public/asset/images/logo.png" alt="logo"></a>
                        <p class="footer-desc">Odishabazar was already known for Fruits, Vegetables, Dairy & Bakery, Grocery, Garments,Nonveg Items of retail & Wholesale.</p>
                        <ul class="footer-social">
                            <li><a class="icofont-facebook" href="https://www.facebook.com/OdishaBazar/"></a></li>
                            <li><a class="icofont-twitter" href="https://www.facebook.com/OdishaBazar/"></a></li>
                            <li><a href="https://www.facebook.com/OdishaBazar/"><i class="fab fa-youtube"></i></a></li>
                            <li><a class="icofont-instagram" href="https://www.facebook.com/OdishaBazar/"></a></li>
                            <li><a class="icofont-pinterest" href="https://www.facebook.com/OdishaBazar/"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget contact">
                        <h3 class="footer-title">contact us</h3>
                        <ul class="footer-contact" style="font-size: 15px;">
                            <li><i class="icofont-ui-email"></i>
                                <span>odishabazaronline@gmail.com</span>
                            </li>
                            <li><i class="icofont-ui-touch-phone"></i>
                                <span>Call Us :+91- 9853958747</span>
                            </li>
                            <li><i class="icofont-location-pin"></i>
                                <span>M-1/23 Panchasaakhanagar, Po-Dumuduma, Bhubaneswar</span>
                            </li>
                            <li><i class=" font-size-14 fa fa-globe"></i>
                                <a href="https://odishabazaar.net/" style="color: #39404a"><span>https://odishabazaar.net/</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget contact">
                        <h3 class="footer-title">Vendor/Wholesaler</h3>
                       

                                 <div class="footer-links1">
                            <ul>
                                <li><a href="<?= base_url(); ?>/userLogin">Vender Login</a></li>
                                <li><a href="<?= base_url(); ?>/userRegistration">Vender SignUp</a></li>
                                <li><a href="<?= base_url(); ?>/wholesellerLogin">Wholesaler Login</a></li>
                                <li><a href="<?= base_url(); ?>/wholesellerRegistration">Wholesaler Signup</a></li>
                               
                            </ul>
                        </div>
                                
                        </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget">
                        <h3 class="footer-title">Important Links</h3>
                        <div class="footer-links1">
                            <ul>
                                <li><a href="<?= base_url(); ?>/page/aboutUs">About Us</a></li>
                                <li><a href="<?= base_url(); ?>/page/privacypolicy">Privacy policy</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Cancellations And Return Policy</a></li>
                                <li><a href="<?= base_url(); ?>/contact_us">Contact Us</a></li>
                                <li><a href="#">Feedback</a></li>
                                <li><a href="<?= base_url(); ?>/faq">FAQ's</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p class="footer-copytext">&copy; Copyrights © 2022 All rights reserved Odisha Bazar Design By AIONINNO Technologies Pvt.Ltd.</p>
                        <div class="footer-card"><a href="#"><img src="<?= base_url(); ?>/public/asset/images/payment/jpg/01.jpg" alt="payment"></a><a href="#"><img src="<?= base_url(); ?>/public/asset/images/payment/jpg/02.jpg" alt="payment"></a><a href="#"><img src="<?= base_url(); ?>/public/asset/images/payment/jpg/03.jpg" alt="payment"></a><a href="#"><img src="<?= base_url(); ?>/public/asset/images/payment/jpg/04.jpg" alt="payment"></a></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?= $this->include('partials/js.php'); ?>
</body>
</html>