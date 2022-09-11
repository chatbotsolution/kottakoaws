<!-- doctype html -->
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <title>HiTch</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">
    
    <style>
    	body {
    font-family: "Montserrat", "Ubuntu";
    background-color: #E3FDFD;
  }

  /* LOGO Styles*/
  .image-div {
    display: flex;
    justify-content: center;
    margin: 20px 0;
  }
  /* LOGIN Message Div Styles */
  .login-text {
    text-align: center;
    font-weight: 600;
    text-decoration: underline;
    color: #0B032D;
    padding: 20px;
   }
  /* Members Login Styles */

   
  /* rows styles */
  .row {
    display: flex;
    justify-content: center;
  }

  /* vertical line styles */
  
        /* Sales Manager Login Styles */

        .salesManager-Login {
            height: 110px;
            width: 300px;
            background-color: #0F4C75;
            color: #fff;
            margin-bottom: 20px;
            margin-right: 20px;
            border-radius: 5px;
            text-align: center;
          }
    
          .salesManager-Login:hover {
            background-color: #F67280;
          }



        /* OEM Login Styles */
        .oem-Login {
            height: 110px;
            width: 300px;
            background-color: #0F4C75;
            color: #fff;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
          }
    
          .oem-Login:hover {
            background-color: #F67280;
          }


        /* Team Lead Login Styles  */
        .teamLead-Login {
            height: 110px;
            width: 300px;
            background-color: #0F4C75;
            color: #fff;
            margin-right: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            }
    
          .teamLead-Login:hover {
            background-color: #F67280;
          }
    /* Sales Agent Login Styles */        

        .fieldSalesExecutive {
            height: 110px;
            width: 300px;
            background-color: #0F4C75;
            color: #fff;
           
            border-radius: 5px;
            text-align: center;
            }
    
          .fieldSalesExecutive:hover {
            background-color: #F67280;
          }
    

      /* Font-Icon Styles */
      .font-icon {
          color: #fff;
          margin-right: 8px;
          margin-top: 4px;
      }

      .font-icon:hover {
          color: black;
      }

</style>
    
  </head>
  <body>

    <div class="container">

      <div class="image-div">
        <a href="#" class="image">
          <img src="<?= base_url(); ?>/public/assets/images/hitch.png" width="120" height="50">
        </a>
      </div>

      <!-- Content Area -->
        <div style="margin-bottom: 20px;">
            <h1 class="login-text">LOGIN</h1>
        </div>
        
        <!-- <div class="insideRows"> </div> -->
          <div class="row">
            <div class="salesManager-Login col-lg-6">
              <h3 style="font-size: 23px; padding-top: 8px;">Sales Manager</h3>
              <i class="font-icon fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
              <a href="<?= base_url(); ?>/salesmanagerLogin">
                <button type="button"  class="btn  btn-outline-dark" style="color: #fff;">Login</button>
              </a>
            </div>
          
            <div class="oem-Login col-lg-6">
              <h3 style="font-size: 23px; padding-top: 8px;">OEM</h3>
              <i class="font-icon fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
              <a href="<?= base_url(); ?>/oemLogin">
                <button type="button"  class="btn  btn-outline-dark" style="color: #fff;">Login</button>
              </a>
            </div>
            
          </div>
    </div>
         <div class="container">
            <div class="row">
                <div class="teamLead-Login col-lg-6">
                  <h3 style="font-size: 23px; padding-top: 8px;">Team Lead</h3>
                  <i class="font-icon fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
                  <a href="<?= base_url(); ?>/teamleadLogin">
                    <button type="button"  class="btn  btn-outline-dark" style="color: #fff;">Login</button>
                  </a>
                </div>
                <div class="fieldSalesExecutive col-lg-6">
                  <h3 style="font-size: 23px; padding-top: 8px;">Field Sales Executive</h3>
                  <i class="font-icon fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
                  <a href="<?= base_url(); ?>/salesagentLogin">
                    <button type="button"  class="btn  btn-outline-dark" style="color: #fff;">Login</button>
                  </a>
                </div>
            </div>
         </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>