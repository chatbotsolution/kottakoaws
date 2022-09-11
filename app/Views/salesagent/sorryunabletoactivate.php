<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>RadhaMadhab Nagar</title>

    <style>
        .container {
            color: #F32424;
            text-align: center;
            margin: 300px auto;
        }
    </style>
  </head>
  <body>
    
  <div class="container">
      <p> <i class="fa fa-times-circle" style="font-size:100px;"></i>  </p>
    <?php if(session()->getTempdata('success')){ ?>
      <h1> <?= session()->getTempdata('success'); ?> </h1>
    <?php } ?>
    <?php if(session()->getTempdata('error')){ ?>
      <h1> <?= session()->getTempdata('error'); ?> </h1>
    <?php } ?>
    
    <div id="tmr"> Redirecting in  <span id="timer"></span></div>
  </div>



   <!-- bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<script>

setTimeout(function(){ location.href="<?= base_url(); ?>/salesagent/customeronboarding"; }, 4000);

</script>
<script>
document.getElementById('timer').innerHTML =
  00 + ":" + 06;
startTimer();


function startTimer() {
  var presentTime = document.getElementById('timer').innerHTML;
  var timeArray = presentTime.split(/[:]+/);
  var m = timeArray[0];
  var s = checkSecond((timeArray[1] - 1));
  if(s==59){m=m-1}
  if(m<0){
    return
  }
  
  document.getElementById('timer').innerHTML =
    m + ":" + s;
  console.log(m)
  setTimeout(startTimer, 1000);
  
}

function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
  if (sec < 0) {sec = "59"};
  return sec;
}

</script>



