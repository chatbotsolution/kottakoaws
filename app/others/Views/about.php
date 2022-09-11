<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HiTch - About</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <?= $this->include('partials/css.php'); ?> 
</head>

<body>
<?= $this->include('partials/header.php'); ?>

    <!-- breadcumb-area start -->
    <div class="breadcumb-area flex-style  black-opacity">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>About Us Company</h2>
                    <ul class="d-flex">
                        <li><a href="home">Home</a></li>
                        <li><i class="fa fa-angle-double-right"></i></li>
                        <li><span>About Us</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcumb-area end -->

    <!-- about-area start -->
    <div class="about-area position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="about-img">
                        <img src="<?= base_url(); ?>/public/assets/images/about/1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        <h1>HiTch Payments</h1>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="about-items">
                                <img src="<?= base_url(); ?>/public/assets/images/about/icon/1.png" alt="">
                                <span class="counter">1454</span>
                                <p>Support Countrie</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="about-items">
                                <img src="<?= base_url(); ?>/public/assets/images/about/icon/2.png" alt="">
                                <span class="counter">759</span>
                                <p>Bank Support</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="about-items mb-0">
                                <img src="<?= base_url(); ?>/public/assets/images/about/icon/3.png" alt="">
                                <span class="counter">1250</span>
                                <p>BitCoin ATMs</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="about-items mb-0">
                                <img src="<?= base_url(); ?>/public/assets/images/about/icon/4.png" alt="">
                                <span class="counter">2391</span>
                                <p>Producers Ready</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about-area end -->

    <!-- service-area start -->
    <div class="service-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2>Why Choose HiTch</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="service-wrap">
                        <h3>What We Offer</h3>
                        <p>There are many variations of passages of an Lorem Ipsum available but the about majority have suffered alteration in man some form a by injected humour or that randomised the a words which</p>
                        <p>There are many variations of passages of an Lorem Ipsum available but the about majority have suffered.</p>
                        <a href="#">Free Consultation</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="service-items">
                        <span class="flaticon-bitcoin-9"></span>
                        <h3>Safe And Secure</h3>
                        <p>There are many variations of Lorem Ipsum available but the about  some majority have form randomised words which believable.</p>
                    </div>
                    <div class="service-items">
                        <span class="flaticon-profits"></span>
                        <h3>Instant Exchange</h3>
                        <p>There are many variations of Lorem Ipsum available but the about  some majority have form randomised words which believable.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="service-items">
                                <span class="flaticon-exchange-1"></span>
                                <h3>Secure Wallet</h3>
                                <p>There are many variations of Lorem Ipsum available but the about  some majority have form randomised words which believable.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="service-items">
                                <span class="flaticon-bitcoin-7"></span>
                                <h3>Experts Support</h3>
                                <p>There are many variations of Lorem Ipsum available but the about  some majority have form randomised words which believable.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->include('partials/footer.php'); ?> 
<?= $this->include('partials/js.php'); ?> 
</body>

</html>