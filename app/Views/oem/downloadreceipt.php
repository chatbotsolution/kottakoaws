<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
         <!-- table 1 start -->
         <table>
            <tr>
              <td> <img src="<?= base_url(); ?>/public/pdfdownloadinmage/fastag.jpeg" alt="Fastag" style="margin-right: 800px; margin-left: 0px; margin-top: 30px;" height="60px" width="130px"></td>
              <td> <img src="<?= base_url(); ?>/public/pdfdownloadinmage/kotakbank.jpeg" alt="Kotak" height="60px" width="170px" style="margin-top: 30px;"></td>
            </tr>
          </table>
          <!-- table 1 end -->
          <div style="margin-top: 10px; font-weight: 500;">
            <p>Dear Customer</p>
            <p>Thank you for using KOTAK Bank FASTag Services</p>
          </div>
          <hr style="border: 3px solid #1C0A00; border-radius: 5px;">
          <div>
            <label style="font-weight: bold; font-size: 18px;">Receipt No :</label>
            <span style="padding-left: 10px; font-weight: 500;">1396921</span>
            <label style="margin-left: 790px;font-weight: bold; font-size: 18px;">Date</label>
            <span style="padding-left: 10px; font-weight: 500;">20-04-2022</span>
          </div>
          <!-- table 1 start -->
          <table style=" margin-left: 50px; margin-top: 20px;">
            <tr>
              <td  style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">Manufacture Name :</td>
              <td style="font-weight: 400;padding-bottom: 20px; font-size: 15px; padding-left: 80px;">KIA</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; padding-bottom: 20px; font-weight: bold; font-size: 15px;">Dealer Name :</td>
              <td style="font-weight: 400; padding-bottom: 20px; font-size: 15px; padding-left: 80px;">CENTRAL KIA</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; padding-bottom: 20px; font-weight: bold; font-size: 15px;">Customer Name :</td>
              <td style="font-weight: 400; padding-bottom: 20px; font-size: 15px; padding-left: 80px;">SAROJ KUMAR JENA</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; padding-bottom: 20px; font-weight: bold; font-size: 15px;">Vehicle Number :</td>
              <td style="font-weight: 400; padding-bottom: 20px; font-size: 15px; padding-left: 80px;">OD02BZ5775</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; padding-bottom: 20px; font-weight: bold; font-size: 15px;">Barcode :</td>
              <td style="font-weight: 400; padding-bottom: 20px; font-size: 15px; padding-left: 80px;">608116-009-0132331</td>
            </tr>
            <tr>
              <td style="padding-left: 20px; font-weight: bold; font-size: 15px;">Tag ID :</td>
              <td style="font-weight: 400; font-size: 15px; padding-left: 80px;">34161FA820328EE812409D60</td>
            </tr>
          </table>
          <!-- table 1 end -->
<!-- ***************************************************** -->
<!-- ***************************************************** -->
<!-- ***************************************************** -->
          <!-- table 2 start -->

          <div style="text-align: center; margin-top: 20px; font-weight: bold; font-size: 20px;">
            <label style="text-decoration: underline;">Amount Breakdown</label>
          </div>
            <table style=" margin-left: 50px; margin-top: 20px;">
              <tr>
                <td style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">Insurance Fees(Including GST) : </td>
                <td style="font-weight: 400;padding-bottom: 20px;  font-size: 15px; padding-left: 80px;">Rs. 50</td>
              </tr>
              <tr>
                <td style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">Security Deposit :</td>
                <td style="padding-bottom: 20px; font-weight: 400; font-size: 15px; padding-left: 80px;">Rs. 1000</td>
              </tr>
              <tr>
                <td style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">Initial Topup :</td>
                <td style="padding-bottom: 20px; font-weight: 400; font-size: 15px; padding-left: 80px;">Rs. 300</td>
              </tr>
              <tr>
                <td style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">P.S Fees :</td>
                <td style="padding-bottom: 20px; font-weight: 400; font-size: 15px; padding-left: 80px;">Rs. 200</td>
              </tr>
              <tr>
                <td style="padding-bottom: 20px; padding-left: 20px; font-weight: bold; font-size: 15px;">Total Amount :</td>
                <td style="padding-bottom: 20px; font-weight: 400; font-size: 15px; padding-left: 80px;">Rs. 1550</td>
              </tr>
            </table>
          <!-- table 2 end -->
          <div style="margin-top: 80px;">
            <span style="font-size: 14px; font-weight: 500; ">Note: GST is included in Tag Insurance Fee and is paid by end customer directly to the KOTAK Bank.</span>
          </div>

          <hr style="border: 3px solid #1C0A00; border-radius: 5px;">
            <div style="text-align: center; margin-top: 20px; font-weight: bold; font-size: 20px;">
              <label style="text-decoration: underline;">FASTag Support</label>
            </div>
            <div style="margin-top: 20px; margin-bottom: 20px;">
              <p style="font-weight: 500; font-size: 13px;"><span style="color: black;">*</span>Account recharge may take maximum upto 30mins to effect.</p>
              <p style="font-weight: 500; font-size: 13px;"><span style="color: black;">*</span>Pass usage is subject to validity period at pass enabled plaza's only.</p>
              <p style="font-weight: 500; font-size: 13px;"><span style="color: black;">*</span>Running account is valid across all FASTag enabled plaza's.</p>
            </div>
          <hr style="border: 3px solid #1C0A00; border-radius: 5px;">
    </div>

    
    


  </body>
</html>