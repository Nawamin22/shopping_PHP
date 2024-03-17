<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "admin/PHPMailer/src/PHPMailer.php";
require_once "admin/PHPMailer/src/SMTP.php";
require_once "admin/PHPMailer/src/Exception.php";
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	if (isset($_POST['submit'])) {
		// รับชื่อไฟล์รูปภาพ
		$paymentImage = $_FILES['paymentImage']['name'];

		// อัปโหลดไฟล์ภาพไปยังโฟลเดอร์ p_payment ที่อยู่ในโฟลเดอร์ admin
		move_uploaded_file($_FILES['paymentImage']['tmp_name'], 'admin/p_payment/' . $paymentImage);

		// ดึงค่า totalprice จาก $_SESSION
		$totalprice = $_SESSION['tp'];

		// อัปเดตช่อง paymentMethod และ totalprice ในตาราง orders
		mysqli_query($con, "UPDATE orders SET paymentMethod = '" . $_POST['paymethod'] . "', paymentImage1 = '$paymentImage', totalprice = '$totalprice' WHERE userId = '" . $_SESSION['id'] . "' AND paymentMethod IS NULL");

		unset($_SESSION['cart']);
		header('location:order-history.php');

		// // ดึงค่า Order ID จากฐานข้อมูลหลังจากอัปเดต
		// $result = mysqli_query($con, "SELECT orderId FROM orders WHERE userId = '" . $_SESSION['id'] . "' AND paymentMethod = '" . $_POST['paymethod'] . "'");
		// $row = mysqli_fetch_assoc($result);
		// $id = $row['orderId'];

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com'; // เปลี่ยนเป็นเซิร์ฟเวอร์ SMTP ของคุณ
		$mail->SMTPAuth = true;
		$mail->Username = 'nwmin22@gmail.com'; // อีเมลของคุณ
		$mail->Password = 'ogph giaq bnuk ecmx'; // รหัสผ่านของคุณ
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587; // หรือพอร์ต SMTP ของคุณ

		$mail->setFrom('VinTageShirtShop@gmail.com', 'Vintage Shirt Shop'); // อีเมลและชื่อผู้ส่ง
		$mail->addAddress('nwmin13@gmail.com', 'Admin Vintage shirt shop'); // อีเมลแอดมินและชื่อแอดมิน



		$mail->isHTML(true);
		$mail->Subject = 'New Order Notification';
		// $mail->Body = 'Now have a new Order ';
		$mail->Body = '<html>    
			<body>
		   		<h1>New Order Notification</h1>
       			<p>Now you have a new order.</p>
    		</body>
		</html>';

		if ($mail->send()) {
			// ส่งอีเมลสำเร็จ
			unset($_SESSION['cart']);
			header('location:order-history.php');
		} else {
			// ไม่สามารถส่งอีเมล
			echo 'Email could not be sent.';
		}
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="MediaCenter, Template, eCommerce">
		<meta name="robots" content="all">

		<title>Vintage Shirt Shop | Payment Method</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/green.css">
		<link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/config.css">
		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
	</head>

	<body class="cnt-home">


		<header class="header-style-1">
			<?php include('includes/top-header.php'); ?>
			<?php include('includes/main-header.php'); ?>
			<?php include('includes/menu-bar.php'); ?>
		</header>
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-inner">
					<ul class="list-inline list-unstyled">
						<li><a href="home.html">Home</a></li>
						<li class='active'>Payment Method</li>
					</ul>
				</div><!-- /.breadcrumb-inner -->
			</div><!-- /.container -->
		</div><!-- /.breadcrumb -->

		<div class="body-content outer-top-bd">
			<div class="container">
				<div class="checkout-box faq-page inner-bottom-sm">
					<div class="row">
						<div class="col-md-12">
							<h2>Choose Payment Method</h2>
							<div class="panel-group checkout-steps" id="accordion">
								<!-- checkout-step-01  -->
								<div class="panel panel-default checkout-step-01">

									<!-- panel-heading -->
									<div class="panel-heading">
										<h4 class="unicase-checkout-title">
											<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
												Select your Payment Method
											</a>
										</h4>
									</div>
									<!-- panel-heading -->

									<div id="collapseOne" class="panel-collapse collapse in">

										<!-- panel-body  -->
										<div class="panel-body">
											<form name="payment" method="post" enctype="multipart/form-data">
												<h4 class="cart-product-grand-total"><span class="cart-grand-total-price"
														style="color: red;">
														Price
														<?php echo $_SESSION['tp'] = "$totalprice" . ".00"; ?>
														THB.<br>
													</span></h4>

												<input type="radio" name="paymethod" value="Internet Banking" required>
												Internet
												Banking<br /><br />
												<div id="bankingInfo" style="display:none;">
													Banking Code : 284-046-7283<br>
													Bank Name : Krungthai<br>
													Bank Holder Name : Mr.Nawamin Saengsaikaew
												</div>
												<br />
												<input type="file" name="paymentImage" id="paymentImage"
													required><br /><br />
												<input type="submit" value="submit" name="submit" class="btn btn-primary">


											</form>

										</div>
										<!-- panel-body  -->

									</div><!-- row -->
								</div>
								<!-- checkout-step-01  -->


							</div><!-- /.checkout-steps -->
						</div>
					</div><!-- /.row -->
				</div><!-- /.checkout-box -->
				<!-- ============================================== BRANDS CAROUSEL ============================================== -->
				<?php echo include('includes/brands-slider.php'); ?>
				<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
			</div><!-- /.container -->
		</div><!-- /.body-content -->
		<?php include('includes/footer.php'); ?>
		<script src="assets/js/jquery-1.11.1.min.js"></script>

		<script src="assets/js/bootstrap.min.js"></script>

		<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
		<script src="assets/js/owl.carousel.min.js"></script>

		<script src="assets/js/echo.min.js"></script>
		<script src="assets/js/jquery.easing-1.3.min.js"></script>
		<script src="assets/js/bootstrap-slider.min.js"></script>
		<script src="assets/js/jquery.rateit.min.js"></script>
		<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/scripts.js"></script>

		<!-- For demo purposes – can be removed on production -->

		<script src="switchstylesheet/switchstylesheet.js"></script>

		<script>
			$(document).ready(function () {
				$(".changecolor").switchstylesheet({ seperator: "color" });
				$('.show-theme-options').click(function () {
					$(this).parent().toggleClass('open');
					return false;
				});
			});

			$(window).bind("load", function () {
				$('.show-theme-options').delay(2000).trigger('click');
			});
			document.querySelector('input[name="paymethod"]').addEventListener('change', function () {
				if (this.value === 'Internet Banking') {
					document.getElementById('bankingInfo').style.display = 'block';
				} else {
					document.getElementById('bankingInfo').style.display = 'none';
				}
			});
		</script>
		<!-- For demo purposes – can be removed on production : End -->



	</body>

	</html>
<?php } ?>