<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Success Payment</title>

    <style>
        .container {
            color: #243D25;
            text-align: center;
            margin: 300px auto;
        }
    </style>
  </head>
  <body onload="stts()">
    
  <div class="container">
      <p> <i class="fa fa-check-circle" style="font-size:100px;"></i>  </p>
      <span id="wer"></span>
      <h1 id="hy" style="background: #cdcdcd;padding: 20px;color: #120fe1;"> Checking Bank Possibilities </h1>
    <div id="tmr"> Redirecting in  <span id="timer"></span></div>
  </div>


   <!-- bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
document.getElementById('timer').innerHTML = 03 + ":" + 00;
startTimer();


function startTimer() {
  var presentTime = document.getElementById('timer').innerHTML;
  var timeArray = presentTime.split(/[:]+/);
  var m = timeArray[0];
  var s = checkSecond((timeArray[1] - 1));
  if(s==59){m=m-1}
 
  
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


function stts(){
    setInterval(function() { checkstatus(); }, 5000);
    setTimeout(function(){ location.href="<?= base_url(); ?>/salesagent/customeronboarding"; }, 190000);
}

function checkstatus(){
    var reqststs = 1;
    $.ajax({
      type:'post',
      url:'<?= base_url(); ?>/salesagent/requestcustomeronboarding',
      data:{reqststs:reqststs},
      success: function(data){
         if(data == 1){
           $("#hy").html("Alloted Successfully");
           setTimeout(function(){ location.href="<?= base_url(); ?>/salesagent/customeronboarding"; }, 2000);
         }
      }
    });
  }

</script>