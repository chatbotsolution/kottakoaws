<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HiTch - Contact</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->include('partials/css.php'); ?> 
    </head>

    <body>
    <?= $this->include('partials/header.php'); ?>
    <div class="breadcumb-area flex-style  black-opacity">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Contact</h2>
                    <ul class="d-flex">
                        <li><a href="index.php">Home</a></li>
                        <li><i class="fa fa-angle-double-right"></i></li>
                        <li><span>Contact</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcumb-area end -->

    <div class="contact-page-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3><span>Get in </span> touch with us! </h3>
                        <p>There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form .</p>
                        <form action="contact">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name">
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" placeholder="Email">
                                </div>
                                <div class="col-12">
                                    <input type="text" placeholder="subject">
                                </div>
                                <div class="col-12">
                                    <textarea name="massage" cols="30" rows="10" placeholder="Your Message"></textarea>
                                </div>
                                <div class="col-12">
                                    <button>Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-page-info">
                        <h3>Head Office</h3>
                        <ul class="border-bottom">
                            <li><i class="fa fa-home"></i> 30 South Park Avenue, CA 94108 San Francisco USA</li>
                            <li><i class="fa fa-envelope"></i> Supportinfo@yourdomain.com </li>
                            <li><i class="fa fa-phone"></i> +18 0540 1516 056, +01 2156 2455 054</li>
                        </ul>
                        <h3>Branch Office</h3>
                        <ul class="mb-0">
                            <li><i class="fa fa-home"></i> 30 South Park Avenue, CA 94108 San Francisco USA</li>
                            <li><i class="fa fa-envelope"></i> Supportinfo@yourdomain.com </li>
                            <li><i class="fa fa-phone"></i> +18 0540 1516 056, +01 2156 2455 054</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="googleMap"></div>
    <?= $this->include('partials/footer.php'); ?> 
    <?= $this->include('partials/js.php'); ?> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbeBYsZSDkbIyfUkoIw1Rt38eRQOQQU0o"></script>
    <script>
    function initialize() {
        var e = { zoom: 15, scrollwheel: !1, center: new google.maps.LatLng(40.712764, -74.005667), styles: [{ elementType: "geometry", stylers: [{ color: "#f5f5f5" }] }, { elementType: "labels.icon", stylers: [{ visibility: "off" }] }, { elementType: "labels.text.fill", stylers: [{ color: "#616161" }] }, { elementType: "labels.text.stroke", stylers: [{ color: "#f5f5f5" }] }, { featureType: "administrative.land_parcel", elementType: "labels.text.fill", stylers: [{ color: "#bdbdbd" }] }, { featureType: "poi", elementType: "geometry", stylers: [{ color: "#eeeeee" }] }, { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#757575" }] }, { featureType: "poi.park", elementType: "geometry", stylers: [{ color: "#e5e5e5" }] }, { featureType: "poi.park", elementType: "labels.text.fill", stylers: [{ color: "#9e9e9e" }] }, { featureType: "road", elementType: "geometry", stylers: [{ color: "#ffffff" }] }, { featureType: "road.arterial", elementType: "labels.text.fill", stylers: [{ color: "#757575" }] }, { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#dadada" }] }, { featureType: "road.highway", elementType: "labels.text.fill", stylers: [{ color: "#616161" }] }, { featureType: "road.local", elementType: "labels.text.fill", stylers: [{ color: "#9e9e9e" }] }, { featureType: "transit.line", elementType: "geometry", stylers: [{ color: "#e5e5e5" }] }, { featureType: "transit.station", elementType: "geometry", stylers: [{ color: "#eeeeee" }] }, { featureType: "water", elementType: "geometry", stylers: [{ color: "#c9c9c9" }] }, { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#9e9e9e" }] }] },

            l = new google.maps.Map(document.getElementById("googleMap"), e);
        new google.maps.Marker({ position: l.getCenter(), animation: google.maps.Animation.BOUNCE, map: l })
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <!-- main js -->
    <script src="assets/js/scripts.js "></script>
</body>

</html>