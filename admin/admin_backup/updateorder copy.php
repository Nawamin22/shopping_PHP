<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";
session_start();

include_once 'include/config.php';
if (strlen($_SESSION['alogin']) == 0) {
  header('location:index.php');
} else {
  $oid = intval($_GET['oid']);
  if (isset($_POST['submit2'])) {
    $status = $_POST['status'];
    $remark = $_POST['remark']; //space char

    $query = mysqli_query($con, "insert into ordertrackhistory(orderId,status,remark) values('$oid','$status','$remark')");
    $sql = mysqli_query($con, "UPDATE orders set orderStatus='$status' where id='$oid'");


    $userIdQuery = mysqli_query($con, "SELECT userId FROM orders WHERE id='$oid'");
    $userIdRow = mysqli_fetch_array($userIdQuery);
    $userId = $userIdRow['userId'];
    
    $emailUserQuery = mysqli_query($con, "SELECT email FROM users WHERE id='$userId'");
    $emailUserRow = mysqli_fetch_array($emailUserQuery);
    $emailUser = $emailUserRow['email'];
    
    $nameUserQuery = mysqli_query($con, "SELECT name FROM users WHERE id='$userId'");
    $nameUserRow = mysqli_fetch_array($nameUserQuery);
    $nameUser = $nameUserRow['name'];
    
    
    // Check if the status is "Delivered" and send an email
    if ($status == 'Delivered') {


      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // Change to your SMTP server
      $mail->SMTPAuth = true;
      $mail->Username = 'nwmin22@gmail.com'; // อีเมลของคุณ
      $mail->Password = 'ogph giaq bnuk ecmx'; // รหัสผ่านของคุณ
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587; // Your SMTP port

      $mail->setFrom('Vintage_Shirt_Shop@gmail.com', 'Vintage Shirt Shop');          //ต้นทาง
      $mail->addAddress($emailUser, $nameUser);     //ปลายทาง
      // $mail->addAddress('nwmin30@gmail.com', 'test Delevered');     //ปลายทาง

      $mail->isHTML(true);
      $mail->Subject = 'Order Delivered';
      $mail->Body = 'Order with ID ' . $oid . ' has been delivered.';

      if ($mail->send()) {
        echo 'Email sent successfully.';
      } else {
        echo 'Email could not be sent.';
      }
    }
    echo "<script>alert('Order updated sucessfully...');</script>";
    //}

  }

  ?>
  <script language="javascript" type="text/javascript">
    function f2() {
      window.close();
    }
    function f3() {
      window.print();
    }
  </script>
  <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Update Compliant</title>

    <!-- <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="anuj.css" rel="stylesheet" type="text/css"> -->
    <!-- <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
      rel='stylesheet'>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <!-- <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script> -->
  </head>

  <body>

    <div style="margin-left:50px;">
      <form name="updateticket" id="updateticket" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr height="50">
            <td colspan="2" class="fontkink2" style="padding-left:0px;">
              <div class="fontpink2"> <b>Update Order !</b></div>
            </td>


          </tr>
          <tr height="30">
            <td class="fontkink1"><b>order Id:</b></td>
            <td class="fontkink">
              <?php echo $oid; ?>
            </td>
          </tr>



          <?php
          $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
          while ($row = mysqli_fetch_array($ret)) {
            ?>



            <tr height="20">
              <td class="fontkink1"><b>At Date:</b></td>
              <td class="fontkink">
                <?php echo $row['postingDate']; ?>
              </td>
            </tr>
            <tr height="20">
              <td class="fontkink1"><b>Status:</b></td>
              <td class="fontkink">
                <?php echo $row['status']; ?>
              </td>
            </tr>


            <tr height="20">
              <td class="fontkink1"><b>Remark:</b></td>
              <td class="fontkink">
                <?php echo $row['remark']; ?>
              </td>
            </tr>


            <tr>
              <td colspan="2">
                <hr />
              </td>
            </tr>
          <?php } ?>
          <?php
          $st = 'Delivered';
          $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");

          while ($num = mysqli_fetch_array($rt)) {
            $currrentSt = $num['orderStatus'];
          }
          if ($st == $currrentSt) { ?>
            <tr>
              <td colspan="2"><b>
                  Product Delivered </b></td>
            <?php } else {
            ?>

            <tr height="50">
              <td class="fontkink1">Status: </td>
              <td class="fontkink"><span class="fontkink1">
                  <select name="status" class="fontkink" required="required">
                    <option value="">Select Status</option>
                    <option value="in Process">In Process</option>
                    <option value="Delivered">Delivered</option>
                    
                  </select>
                </span></td>
            </tr>



            <?php $queryPic = mysqli_query($con, "SELECT * from orders WHERE id='$oid'");

            while ($row = mysqli_fetch_array($queryPic)) {
              ?>
              <tr height="30">
                <td class="fontkink1">Payment Slip:</td>
                <td class="fontkink">
                  <img src="p_payment/<?php echo $row['paymentImage1']; ?>" width="20%"><br></br>
                </td>
              </tr>

              </tr>
              <?php ;
            } ?>




            <tr style=''>
              <td class="fontkink1">Remark:</td>
              <td class="fontkink" align="justify"><span class="fontkink">
                  <textarea cols="50" rows="7" name="remark" required="required"></textarea>
                </span></td>
            </tr>




            <tr>
              <td class="fontkink1">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="fontkink"> </td>
              <td class="fontkink"> <input type="submit" name="submit2" value="update" size="40" style="cursor: pointer;" />
                &nbsp;&nbsp;
                <input name="Submit2" type="submit" class="txtbox4" value="Close this Window " onClick="return f2();"
                  style="cursor: pointer;" />
              </td>
            </tr>
          <?php } ?>
        </table>
      </form>
    </div>

  </body>

  </html>
<?php } ?>