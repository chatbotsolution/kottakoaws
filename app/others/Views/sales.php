<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HiTch</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->include('partials/css.php'); ?> 
    </head>

    <body>
    <?= $this->include('partials/header.php'); ?>
    <div class="container mt-3 mb-3">
        <h2 class="text-center text-danger">Sales Manager</h2>

            <form action="" method="post" enctype="multipart/form-data">

<div class="row">
    <div class="col-md-7 col-sm-7">
        <div class="row">
            <div class="col-md-6 col-sm-6 form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" placeholder="first name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>

            <div class="col-md-6 col-sm-6 form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" placeholder="last name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="sales">Region of sales</label>
                <input type="text" id="sales" name="sales" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-8">
                <label for="num">Mobile Number</label>
                <input type="number" id="num" name="num" placeholder="enter mobile number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
            <div class="col-md-4 col-sm-4">
                <button type="" class="btn btn-lg btn-info mt-4">Send OTP</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="otp"><span>Enter otp</label>
                <input type="text" id="otp" name="otp" placeholder="enter OTP" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="namebank"><span class="text-info">bank</span>&nbsp; name</label>
                <input type="text" id="namebank" name="namebank" placeholder="enter bank name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 form-group">
                <label for="accnum"><span class="text-info">bank</span>&nbsp; acount number</label>
                <input type="number" id="accnum" name="accnum" placeholder="enter account number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>

            <div class="col-md-6 col-sm-6 form-group">
                <label for="ifsc"><span class="text-info">bank</span>&nbsp; ifsc</label>
                <input type="text" id="ifsc" name="ifsc" placeholder="enter ifsc code" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="adhar">Adhar Number</label>
                <input type="text" id="adhar" name="adhar" placeholder="adhar card number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="pan">Pan Card Number</label>
                <input type="text" id="pan" name="pan" placeholder="pan card number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <label for="dl">Driving Licence</label>
                <input type="text" id="dl" name="dl" placeholder="enter driving licence number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
            </div>
        </div>

        
    </div>


    <div class="col-md-5 col-sm-5" id="immg">

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="top" id="display_image"></div>
                <div class="form-group">
                    <label for="img" class="text-warning">PROFILE PICTURE</label>
                    <input type="file" name="img" class="form-control" id="image_input">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="top" id="disp_image"></div>
                <div class="form-group">
                    <label for="img" class="text-warning">UPLOAD ADHAR CARD</label>
                    <input type="file" name="img" class="form-control" id="image_inp">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="top" id="dis_image"></div>
                <div class="form-group">
                    <label for="img" class="text-warning">UPLOAD PANCARD</label>
                    <input type="file" name="img" class="form-control" id="image_inpu">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="top" id="d_image"></div>
                <div class="form-group">
                    <label for="img" class="text-warning">UPLOAD DRIVING LICENCE</label>
                    <input type="file" name="img" class="form-control" id="image_i">
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
       <button type="submit" class="btn btn-lg btn-success">Submit</button>
       <button type="reset" class="btn btn-lg btn-secondary">reset</button>
    </div>
</div>
            </form>
    </div>
    <?= $this->include('partials/footer.php'); ?> 
    <?= $this->include('partials/js.php'); ?> 
        <script>
            // chart
    window.onload = function () {
    var limit = 10000;    //increase number of dataPoints by increasing the limit
    var y = 100;    
    var data = [];
    var dataSeries = { type: "line" };
    var dataPoints = [];
    for (var i = 0; i < limit; i += 1) {
        y += Math.round(Math.random() * 10 - 5);
        dataPoints.push({
            x: i,
            y: y
        });
    }
    dataSeries.dataPoints = dataPoints;
    data.push(dataSeries);

    //Better to construct options first and then pass it as a parameter
    var options = {
        zoomEnabled: true,
        animationEnabled: true,
        axisY: {
            includeZero: false
        },
        data: data  // random data
    };

        $("#chartContainer").CanvasJSChart(options);
    }
    </script>
    <!-- main js -->
    <script src="<?= base_url(); ?>/public/assets/js/scripts.js "></script>
  <script src="<?= base_url(); ?>/public/js1/main.js"></script>
<script src="<?= base_url(); ?>/public/js1/script.js"></script>
</body>

</html>