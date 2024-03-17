<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:.php');
} else {

	if (isset($_POST['localupdate'])) {
		$caddress = $_POST['localaddress'];
		$province_id = $_POST['provinces'];
		$amphure_id = $_POST['amphures'];
		$district_id = $_POST['districts'];

		$query = mysqli_query($con, "UPDATE users SET  localAddress='$caddress', province_id='$province_id', amphure_id='$amphure_id', district_id='$district_id' WHERE id='" . $_SESSION['id'] . "'");

		// อัปเดตค่าใน Shipping Address ด้วยค่า Local Address, Province.name_en, Amphure.name_en, และ District.name_en ตามลำดับ
		$query = mysqli_query($con, "update users set shippingAddress='$caddress',shippingState=(SELECT name_en FROM provinces WHERE id='$province_id'),shippingCity=(SELECT name_en FROM amphures WHERE id='$amphure_id'),shippingPincode=(SELECT name_en FROM districts WHERE id='$district_id') where id='" . $_SESSION['id'] . "'");

		if ($query) {
			echo "<script>alert('New Local Address has been updated');</script>";
		}
	}

	if (isset($_POST['shipupdate'])) {
		$saddress = $_POST['shippingaddress'];
		$sstate = $_POST['shippingstate'];
		$scity = $_POST['shippingcity'];
		$spincode = $_POST['shippingpincode'];
		$query = mysqli_query($con, "update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='" . $_SESSION['id'] . "'");
		if ($query) {
			echo "<script>alert('Shipping Address has been updated');</script>";
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
		<title>My Account</title>

		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Customizable CSS -->
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/green.css">
		<link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
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
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
		<script>
			function saveLocalAddress(form) {
				var localAddress = form.localaddress.value;
				var province_id = form.provinces.value;
				var amphure_id = form.amphures.value;
				var district_id = form.districts.value;

				// ส่งข้อมูล Local Address ไปยัง Shipping Address ทันที
				document.getElementById("shippingaddress").value = localAddress;
				document.getElementById("shippingstate").value = document.querySelector('#provinces option:checked').text;
				document.getElementById("shippingcity").value = document.querySelector('#amphures option:checked').text;
				document.getElementById("shippingpincode").value = document.querySelector('#districts option:checked').text;

				// ส่งข้อมูล Local Address ไปยังเซิร์ฟเวอร์เพื่อบันทึก
				$.ajax({
					type: "POST",
					url: "save_local_address.php", // ตั้งชื่อไฟล์ที่จะรับข้อมูลและบันทึก Local Address
					data: {
						localaddress: localAddress,
						provinces: province_id,
						amphures: amphure_id,
						districts: district_id
					},
					success: function (data) {
						// รับการตอบรับจากเซิร์ฟเวอร์ หรือทำการประมวลผลตามที่ต้องการ
					}
				});

				return true; // อนุญาตให้ฟอร์ม Local Address ถูกส่งไปยังเซิร์ฟเวอร์
			}
		</script>



		<script>
			function getAmphures(val) {
				$.ajax({
					type: "POST",
					url: "get_amphures.php",
					data: 'province_id=' + val,
					success: function (data) {
						$("#amphures").html(data);
					}
				});
			}
			function getDistricts(val) {
				$.ajax({
					type: "POST",
					url: "get_districts.php",
					data: 'amphure_id=' + val,
					success: function (data) {
						$("#districts").html(data);
					}
				});
			}
			function selectCountry(val) {
				$("#search-box").val(val);
				$("#suggesstion-box").hide();
			}
		</script>

	</head>

	<body class="cnt-home">
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
						<li><a href="my-account.php">Home</a></li>
						<li class='active'>Shipping Address</li>
					</ul>
				</div><!-- /.breadcrumb-inner -->
			</div><!-- /.container -->
		</div><!-- /.breadcrumb -->

		<div class="body-content outer-top-bd">
			<div class="container">
				<div class="checkout-box inner-bottom-sm">
					<div class="row">
						<div class="col-md-8">
							<div class="panel-group checkout-steps" id="accordion">
								<!-- checkout-step-01  -->
								<div class="panel panel-default checkout-step-01">
									<!-- panel-heading -->
									<div class="panel-heading">
										<h4 class="unicase-checkout-title">
											<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
												<span>1</span>Shipping Address
											</a>
										</h4>
									</div>
									<!-- panel-heading -->
									<div id="collapseOne" class="panel-collapse collapse in">
										<!-- panel-body  -->
										<div class="panel-body">
											<?php
											$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
											$row = mysqli_fetch_array($query);

											// เรียกข้อมูลจังหวัด
											$provinces_query = mysqli_query($con, "SELECT * FROM provinces");
											?>
											<form class="register-form" role="form" method="post"
												onsubmit="return saveLocalAddress(this);">



												<div class="form-group">
													<label class="info-title" for="Local Address">Local
														Address<span>*</span></label>
													<textarea class="form-control unicase-form-control text-input"
														id="localaddress" name="localaddress"
														required="required"><?php echo $row['localAddress']; ?></textarea>
												</div>

												
												<div class="form-group">
													<label for="province">Province</label>
													<select class="form-control" name="provinces" id="provinces"
														onChange="getAmphures(this.value);">
														<option value="">Select Province</option>
														<?php
														while ($province = mysqli_fetch_array($provinces_query)) {
															$selected = ($row['province_id'] == $province['id']) ? 'selected' : '';
															echo '<option value="' . $province['id'] . '" ' . $selected . '>' . $province['name_en'] . '</option>';
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label for="amphures">Amphure</label>
													<select class="form-control" id="amphures" name="amphures"
														onChange="getDistricts(this.value);">
														<option value="">Select Amphure</option>
														<?php
														if ($row['province_id']) {
															$amphures_query = mysqli_query($con, "SELECT * FROM amphures WHERE province_id=" . $row['province_id']);
															while ($amphure = mysqli_fetch_array($amphures_query)) {
																$selected = ($row['amphure_id'] == $amphure['id']) ? 'selected' : '';
																echo '<option value="' . $amphure['id'] . '" ' . $selected . '>' . $amphure['name_en'] . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label for="districts">District</label>
													<select class="form-control" id="districts" name="districts">
														<option value="">Select District</option>
														<?php
														if ($row['amphure_id']) {
															$districts_query = mysqli_query($con, "SELECT * FROM districts WHERE amphure_id=" . $row['amphure_id']);
															while ($district = mysqli_fetch_array($districts_query)) {
																$selected = ($row['district_id'] == $district['id']) ? 'selected' : '';
																echo '<option value="' . $district['id'] . '" ' . $selected . '>' . $district['name_en'] . '</option>';
															}
														}
														?>
													</select>
												</div>

												<button type="submit" name="localupdate"
													class="btn-upper btn btn-primary checkout-page-button">Save</button>
											</form>
										</div>
										<!-- panel-body  -->
									</div><!-- row -->
								</div>

								<!-- checkout-step-03  -->
							</div><!-- /.checkout-steps -->
						</div>
						<?php include('includes/myaccount-sidebar.php'); ?>
					</div><!-- /.row -->
				</div><!-- /.checkout-box -->
				<?php include('includes/brands-slider.php'); ?>
			</div>
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

	</body>

	</html>
	<?php
}
?>