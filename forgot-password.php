<!-- อันเดิม -->
<?php
session_start();
error_reporting(0);
include('includes/config.php');


if (isset($_POST['change'])) {
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$password = md5($_POST['password']);
	$query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and contactno='$contact'");
	$num = mysqli_fetch_array($query);
	if ($num > 0) {
		$extra = "forgot-password.php";
		mysqli_query($con, "update users set password='$password' WHERE email='$email' and contactno='$contact' ");
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

		header("location:http://$host$uri/$extra");
		$_SESSION['errmsg'] = "Password Changed Successfully";

		exit();
	} else {
		$extra = "forgot-password.php";
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("location:http://$host$uri/$extra");
		$_SESSION['errmsg'] = "Invalid email id or Contact no";
		exit();
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

	<title>Vintage Shirt Shop | Forgot Password</title>

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Customizable CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/green.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

	<!-- Demo Purpose Only. Should be removed in production -->
	<link rel="stylesheet" href="assets/css/config.css">

	<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
	<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
	<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
	<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
	<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
	<!-- Demo Purpose Only. Should be removed in production : END -->


	<!-- Icons/Glyphs -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<script type="text/javascript">
		function valid() {
			if (document.register.password.value != document.register.confirmpassword.value) {
				alert("Password and Confirm Password Field do not match  !!");
				document.register.confirmpassword.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body class="cnt-home">



	<!-- ============================================== HEADER ============================================== -->
	<header class="header-style-1">

		<!-- ============================================== TOP MENU ============================================== -->
		<?php include('includes/top-header.php'); ?>
		<!-- ============================================== TOP MENU : END ============================================== -->
		<?php include('includes/main-header.php'); ?>
		<!-- ============================================== NAVBAR ============================================== -->
		<?php include('includes/menu-bar.php'); ?>
		<!-- ============================================== NAVBAR : END ============================================== -->

	</header>

	<!-- ============================================== HEADER : END ============================================== -->
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="login.php">Home</a></li>
					<li class='active'>Forgot Password</li>
				</ul>

			</div><!-- /.breadcrumb-inner -->
			<h3 class="">Forgot Password</h3>

		</div><!-- /.container -->

	</div><!-- /.breadcrumb -->

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Forgot Password</title>
		<link rel="stylesheet" href="your-styles.css">
		<style>
			/* Add custom CSS styles */
			.forgot-password-form {
				max-width: 400px;
				margin: 0 auto;
				padding: 20px;
				/* background: #f9f9f9; */
				/* border: 1px solid #ccc; */
				border-radius: 5px;
			}

			.form-group {
				margin-bottom: 15px;
			}

			label {
				display: block;
				font-weight: bold;
			}

			input[type="email"] {
				width: 100%;
				padding: 10px;
				font-size: 16px;
				border: 1px solid #ccc;
				border-radius: 5px;
			}

			input[type="submit"] {
				width: 100%;
				padding: 15px;
				font-size: 18px;
				background: #B9B6B5;
				color: #fff;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background 0.3s;
				/* Add transition for smooth color change */
			}

			input[type="submit"]:hover {
				background: #ABD07E;
				/* Change to your desired green color */
			}
		</style>
	</head>

	<body class="forgot-password-page">

		<div class="container">
			<div class="forgot-password-form">
				<form method="post" action="send_reset_link.php">
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" required>
					</div>
					
					<div class="form-group">
						<input type="submit" name="reset" value="Reset Password">
					</div>
				</form>
			</div>
		</div>
	</body>
	</div>
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
	</script>
	<!-- For demo purposes – can be removed on production : End -->



</body>

</html>