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
    <div class="container mb-3 mt-3">
        <div class="col-md-8 mx-auto">
        <form action="" method="post" enctype="multipart/form-data">
            <h2 class="text-center text-danger">Team Leader Creation Sales</h2>

            <div class="row form-group">
                <div class="col-md-6">
                   <label for="fname" class="text-primary">First Name</label>
                   <input type="text" id="fname" name="fname" placeholder="enter first name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
                <div class="col-md-6">
                    <label for="lname" class="text-primary">Last Name</label>
                    <input type="text" id="lname" name="lname" placeholder="enter last name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <label for="num" class="text-primary">Mobile Number</label>
                    <input type="number" id="num" name="num" placeholder="enter mobile number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
                <div class="col-md-3">
                    <button type="" class="btn btn-lg btn-info mt-4">Send OTP</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="otp"><span class="text-primary">Enter otp</label>
                    <input type="text" id="otp" name="otp" placeholder="enter OTP" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label for="city" class="text-primary">Toll or City</label>
                    <select name="" id="city" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                        <option value="">--select--</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                        <option value="bbsr">bbsr</option>
                    </select>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-4">
                    <label for="adhar" class="text-primary">Adhar Card</label>
                    <input type="text" id="adhar" name="adhar" placeholder="enter adhar card" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
                <div class="col-md-4">
                    <label for="pancard" class="text-primary">Pan Card</label>
                    <input type="text" id="pancard" name="pancard" placeholder="enter pan card" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
                <div class="col-md-4">
                    <label for="dl" class="text-primary">Driving Licence</label>
                    <input type="text" id="dl" name="dl" placeholder="enter driving licence" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="id"><span class="text-primary">Number Of Id</label>
                    <input type="number" id="id" name="id" placeholder="enter number of id created" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="namebank"><span class="text-primary">Bank</span>&nbsp; name</label>
                    <input type="text" id="namebank" name="namebank" placeholder="enter bank name" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="accnum"><span class="text-primary">Bank</span>&nbsp; acount number</label>
                    <input type="number" id="accnum" name="accnum" placeholder="enter account number" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
    
                <div class="col-md-6 form-group">
                    <label for="ifsc"><span class="text-primary">Bank</span>&nbsp; ifsc</label>
                    <input type="text" id="ifsc" name="ifsc" placeholder="enter ifsc code" value="" class="form-control" onfocus="abc(this)" onblur="bcd(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                   <button type="submit" class="btn btn-lg btn-success">Submit</button>
                   <button type="reset" class="btn btn-lg btn-secondary">reset</button>
                </div>
            </div>

            



        </form>
    </div>
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



    

