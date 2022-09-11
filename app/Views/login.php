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

    <div class="container">
        <div class="col-md-6 mx-auto" style="margin-top: 15%;">
            <form action="" method="post">
                <h2 class="text-danger text-center">login</h2>
                <div class="row form-group">
                    <div class="col-md-10">
                        <label for="uname" class="text-primary">User name or mobile</label>
                        <input type="text" id="uname" name="uname" placeholder="enter user name or phone number" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-10">
                        <label for="pass" class="text-primary">Password</label>
                        <input type="password" id="pass" name="pass" placeholder="enter password" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-10">
                    <input type="checkbox"><span class="text-primary ml-2">Forgot Password</span>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">login</button>
                    </div>
                    <div class="col-md-8">
                        <span class="text-primary ml-5">Register Now</span>
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