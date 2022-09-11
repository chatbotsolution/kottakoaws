<html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        
      <!-- GOOGLE FONTS -->
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
      <title>Fastag</title>
    </head>
    <body style="font-family: 'Montserrat';">
  
      <div class="container">
        <!-- table 1 start -->
        <table>
          <tr>
            <td> <img src="<?= base_url(); ?>/public/pdfdownloadinmage/fastag.jpeg" alt="Fastag" style="margin-right: 600px; margin-left: 0px; margin-top: 30px;" height="70px" width="130px"></td>
            <td> <img src="<?= base_url(); ?>/public/pdfdownloadinmage/kotakbank.jpeg" alt="Kotak" height="70px" width="170px" style="margin-top: 30px;"></td>
          </tr>
        </table>
        <!-- table 1 end -->
  
        <h2 style="text-decoration: underline; margin: 20px 0px 40px 300px; font-weight: 600;font-size: 30px;">
            Proof of fitment of FASTag
        </h2>
  
        <!-- table 2 start -->
        <table>
          <tr>
            <td style="font-weight: bold;padding-bottom: 20px;">Fitment Challan Number</td>
            <td style="padding-left: 80px;padding-bottom: 20px;">HDIDFCN-12046579-1396921</td>
          </tr>
          <tr>
            <td><b>Dated</b> 13-04-2022</td>
            <td style="padding-left: 80px;"><b>Time</b> 10:40:16</td>
          </tr>
        </table>
        <!-- table 2 end -->
  
        <!-- table 3 start -->
        <table border="2px" width="600px" height="200px" style="margin-top: 50px;margin-left: 0px;border-color: #0F0E0E;">
          <tr style="border-bottom-width: 2px; border-color: #0F0E0E;" >
            <th style="text-align:center; padding-left: 70px; font-size: 22px;">FASTag Details</th> 
            <!-- style="text-align:center" -->
          </tr>
          <tr>
            <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"> <li>TID</li> </td>
            <td style="font-weight: 500; font-size: 18px;">123456789</td>
          </tr>
          <tr>
            <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li>TAG ID</li></td>
            <td style="font-weight: 500; font-size: 18px;">34161FA820328EE812409D60</td>
          </tr>
          <tr>
            <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li>Barcode Number</li></td>
            <td style="font-weight: 500; font-size: 18px;">608116-009-0132331</td>
          </tr>
          <tr>
            <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li>Banks Issuer Name</li></td>
            <td style="font-weight: 500; font-size: 18px;">KOTAK BANK</td>
          </tr>
      </table>
  
        <!-- table 3 end -->

        <!-- table 4 start -->
        <table border="2px" width="600px" height="200px" style="margin-top: 50px;margin-left: 0px;border-color: #0F0E0E;">
            <tr style="border-bottom-width: 2px; border-color: #0F0E0E;" >
              <th style="text-align:center; padding-left: 70px; font-size: 22px;">Vehicle Details</th> 
              <!-- style="text-align:center" -->
            </tr>
            <tr>
              <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"> <li>Vehicle Registration No : </li> </td>
              <td style="font-weight: 500; font-size: 18px;">OD02BZ5775</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li><span style="color: red;">*</span>Vehicle No :</li></td>
              <td style="font-weight: 500; font-size: 18px;">OD02BZ5775</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li><span style="color: red;">*</span>Chassis No :</li></td>
              <td style="font-weight: 500; font-size: 18px;">NA</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; font-weight: 700; font-size: 18px;"><li>Engine No :</li></td>
              <td style="font-weight: 500; font-size: 18px;">NA</td>
            </tr>
        </table>
        <!-- table 4 end -->
  

        <!-- table 5 start -->
        <table style="margin-top: 50px;
                margin-left: 650px;
                border-color: #0F0E0E;
                height: 200px;
                width: 300px;
                ">
                <tr>
                    <td style="color: black; font-weight: 500;">Stamp and Signature of</td>
                </tr>
                <tr>
                    <td style="color: black; font-weight: 500;">or</td>
                </tr>
                <tr>
                    <td style="color: black; font-weight: 500;">Signature of Customer</td>
                </tr>
        </table>
        <!-- table 5 end -->

        <div style="text-align: center;
                font-size: 15px;
                font-weight: 500;
                color: black;
                margin-bottom: 20px;
                margin-top: 40px;
                ">
            <span >*Fields marked(*) are mandatory information to be provided in the challan.</span> <br>
            <span>*Vehicle owner shall be responsible affixing FASTag applied through online channels.</span>
        </div>
    </div>
  
  
  
  
      <script>
        var dt = new Date();
        document.getElementById('date-time').innerHTML=dt;
      </script>
  
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
  </html>
  