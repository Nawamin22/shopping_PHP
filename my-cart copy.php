<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit'])) {
	if (!empty($_SESSION['cart'])) {
		foreach ($_POST['quantity'] as $key => $val) {
			if ($val == 0) {
				unset($_SESSION['cart'][$key]);
			} else {
				$_SESSION['cart'][$key]['quantity'] = $val;

			}
		}
		echo "<script>alert('Your Cart hasbeen Updated');</script>";
	}
}
// Code for Remove a Product from Cart

if (isset($_POST['remove_code'])) {

	if (!empty($_SESSION['cart'])) {
		foreach ($_POST['remove_code'] as $key) {

			unset($_SESSION['cart'][$key]);
		}
		echo "<script>alert('Your Cart has been Updated');</script>";
	}
}
// code for insert product in order table


if (isset($_POST['ordersubmit'])) {

	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {

		$quantity = $_POST['quantity'];
		$pdd = $_SESSION['pid'];
		$value = array_combine($pdd, $quantity);


		foreach ($value as $qty => $val34) {



			mysqli_query($con, "insert into orders(userId,productId,quantity) values('" . $_SESSION['id'] . "','$qty','$val34')");
			header('location:payment-method.php');
		}
	}
}




// code for Shipping address updation
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



// if (isset($_POST['localupdate'])) {
// 	// รับค่า province_id, amphure_id, district_id จากฟอร์ม
// 	$caddress = $_POST['localaddress'];
// 	$province_id = $_POST['provinces'];
// 	$amphure_id = $_POST['amphures'];
// 	$district_id = $_POST['districts'];

// 	// ดำเนินการอัปเดตข้อมูลในตาราง users
// 	$query = mysqli_query($con, "UPDATE users SET  localAddress='$caddress', province_id='$province_id', amphure_id='$amphure_id', district_id='$district_id' WHERE id='" . $_SESSION['id'] . "'");
// 	if ($query) {
// 		echo "<script>alert('New Local Address has been updated');</script>";
// 	}
// }

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

	<title>My Cart</title>
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

	<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
	<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

</head>

<body class="cnt-home">



	<!-- ============================================== HEADER ============================================== -->
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>
	<!-- ============================================== HEADER : END ============================================== -->
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="#">Home</a></li>
					<li class='active'>Shopping Cart</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-xs">
		<div class="container">
			<div class="row inner-bottom-sm">
				<div class="shopping-cart">
					<div class="col-md-12 col-sm-12 shopping-cart-table ">
						<div class="table-responsive">
							<form name="cart" method="post">
								<?php
								if (!empty($_SESSION['cart'])) {
									?>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="cart-romove item">Remove</th>
												<th class="cart-description item">Image</th>
												<th class="cart-product-name item">Product Name</th>

												<th class="cart-qty item">Quantity</th>
												<th class="cart-sub-total item">Price Per unit</th>
												<th class="cart-sub-total item">Shipping Charge</th>
												<th class="cart-total last-item">Grandtotal</th>
											</tr>
										</thead><!-- /thead -->
										<tfoot>
											<tr>
												<td colspan="7">
													<div class="shopping-cart-btn">
														<span class="">
															<a href="index.php"
																class="btn btn-upper btn-primary outer-left-xs">Continue
																Shopping</a>
															<input type="submit" name="submit" value="Update shopping cart"
																class="btn btn-upper btn-primary pull-right outer-right-xs">
														</span>
													</div><!-- /.shopping-cart-btn -->
												</td>
											</tr>
										</tfoot>
										<tbody>
											<?php
											$pdtid = array();
											$sql = "SELECT * FROM products WHERE id IN(";
											foreach ($_SESSION['cart'] as $id => $value) {
												$sql .= $id . ",";
											}
											$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
											$query = mysqli_query($con, $sql);
											$totalprice = 0;
											$totalqunty = 0;
											if (!empty($query)) {
												while ($row = mysqli_fetch_array($query)) {
													$quantity = $_SESSION['cart'][$row['id']]['quantity'];
													$subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
													$totalprice += $subtotal;
													$_SESSION['qnty'] = $totalqunty += $quantity;

													array_push($pdtid, $row['id']);
													//print_r($_SESSION['pid'])=$pdtid;exit;
													?>

													<tr>
														<td class="romove-item"><input type="checkbox" name="remove_code[]"
																value="<?php echo htmlentities($row['id']); ?>" /></td>
														<td class="cart-image">
															<a class="entry-thumbnail" href="detail.html">
																<img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>"
																	alt="" width="114" height="146">
															</a>
														</td>
														<td class="cart-product-name-info">
															<h4 class='cart-product-description'><a
																	href="product-details.php?pid=<?php echo htmlentities($pd = $row['id']); ?>">
																	<?php echo $row['productName'];

																	$_SESSION['sid'] = $pd;
																	?>
																</a></h4>
															<div class="row">
																<div class="col-sm-4">
																	<div class="rating rateit-small"></div>
																</div>
																<div class="col-sm-8">
																	<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
																	$num = mysqli_num_rows($rt); {
																		?>
																		<div class="reviews">
																			(
																			<?php echo htmlentities($num); ?> Reviews )
																		</div>
																	<?php } ?>
																</div>
															</div><!-- /.row -->

														</td>
														<td class="cart-product-quantity">
															<div class="quant-input">
																<div class="arrows">
																	<div class="arrow plus gradient"><span class="ir"><i
																				class="icon fa fa-sort-asc"></i></span></div>
																	<div class="arrow minus gradient"><span class="ir"><i
																				class="icon fa fa-sort-desc"></i></span></div>
																</div>
																<input type="text"
																	value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>"
																	name="quantity[<?php echo $row['id']; ?>]">

															</div>
														</td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
																<?php echo "THB" . " " . $row['productPrice']; ?>.00
															</span></td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
																<?php echo "THB" . " " . $row['shippingCharge']; ?>.00
															</span></td>

														<td class="cart-product-grand-total"><span class="cart-grand-total-price">
																<?php echo ($_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge']); ?>.00
															</span></td>
													</tr>

												<?php }
											}
											$_SESSION['pid'] = $pdtid;
											?>

										</tbody><!-- /tbody -->
									</table><!-- /table -->

							</div>
						</div><!-- /.shopping-cart-table -->


						<div class="col-md-4 col-sm-12 estimate-ship-tax">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>
											<span class="estimate-title">Shipping Address</span>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="form-group">
												<?php
												$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
												while ($row = mysqli_fetch_array($query)) {
													?>

													<div class="form-group">
														<label class="info-title" for="Shipping Address">Shipping
															Address<span>*</span></label>
														<textarea class="form-control unicase-form-control text-input"
															name="shippingaddress"
															required="required"><?php echo $row['shippingAddress']; ?></textarea>
													</div>



													<div class="form-group">
														<label class="info-title" for="Shipping State ">Shipping
															State<span>*</span></label>
														<select class="form-control" id="shippingstate" name="shippingstate"
															required>
															<option value="">Select Shipping State</option>
															<?php
															$provinces_query = mysqli_query($con, "SELECT * FROM provinces ");
															while ($province = mysqli_fetch_array($provinces_query)) {
																$selected = ($row['shippingState'] == $province['name_en']) ? 'selected' : '';
																echo '<option value="' . $province['name_en'] . '" ' . $selected . '>' . $province['name_en'] . '</option>';
															}
															?>
														</select>
													</div>

													<div class="form-group">
														<label class="info-title" for="Shipping City">Shipping
															City<span>*</span></label>
														<select class="form-control" id="shippingcity" name="shippingcity"
															required>
															<option value="">Select Shipping City</option>
															<?php
															if (!empty($row['shippingState'])) {
																$amphures_query = mysqli_query($con, "SELECT * FROM amphures WHERE province_id=" . $row['province_id']);
																while ($amphure = mysqli_fetch_array($amphures_query)) {
																	$selected = ($row['shippingCity'] == $amphure['name_en']) ? 'selected' : '';
																	echo '<option value="' . $amphure['name_en'] . '" ' . $selected . '>' . $amphure['name_en'] . '</option>';
																}
															}
															?>
														</select>
													</div>

													<div class="form-group">
														<label class="info-title" for="Shipping Pincode">Shipping
															Pincode<span>*</span></label>
														<select class="form-control" id="shippingpincode" name="shippingpincode"
															required>
															<option value="">Select Shipping Pincode</option>
															<?php
															if (!empty($row['shippingCity'])) {
																$districts_query = mysqli_query($con, "SELECT * FROM districts WHERE amphure_id=" . $row['amphure_id']);
																while ($district = mysqli_fetch_array($districts_query)) {
																	$selected = ($row['shippingPincode'] == $district['name_en']) ? 'selected' : '';
																	echo '<option value="' . $district['name_en'] . '" ' . $selected . '>' . $district['name_en'] . '</option>';
																}
															}
															?>
														</select>
													</div>

													<div align="left">
														<button type="submit" name="shipupdate"
															class="btn-upper btn btn-primary checkout-page-button">Update</button>
														<button type="reset"
															class="btn-upper btn btn-primary checkout-page-button">Redufault</button>
													</div>

												<?php } ?>




											</div>

										</td>
									</tr>
								</tbody><!-- /tbody -->
							</table><!-- /table -->
						</div>

						<div class="col-md-4 col-sm-12 cart-shopping-total">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>

											<div class="cart-grand-total">
												Grand Total<span class="inner-left-md">
													<?php echo $_SESSION['tp'] = "$totalprice" . ".00"; ?>
												</span>
											</div>
										</th>
									</tr>
								</thead><!-- /thead -->
								<tbody>
									<tr>
										<td>
											<div class="cart-checkout-btn pull-right">
												<button type="submit" name="ordersubmit" class="btn btn-primary">PROCCED TO
													CHEKOUT</button>

											</div>
										</td>
									</tr>
								</tbody><!-- /tbody -->
							</table>
						<?php } else {
									echo "Your shopping Cart is empty";
								} ?>
					</div>
				</div>
			</div>
			</form>
			<?php echo include('includes/brands-slider.php'); ?>
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

	<!-- For demo purposes – can be removed on production -->

	<script src="switchstylesheet/switchstylesheet.js"></script>
	<script>
		function clearShippingInfo() {
			document.getElementById("shippingcity").value = "";
			document.getElementById("shippingpincode").value = "";
		}
	</script>
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
		// $('#shippingstate').on('change', function () {
		// 	var selectedState = $(this).val();
		// 	if (selectedState) {
		// 		$.ajax({
		// 			type: 'POST',
		// 			url: 'get_cities.php', // เปลี่ยนเป็นชื่อไฟล์ที่จะดึงข้อมูลเมือง
		// 			data: { state: selectedState },
		// 			success: function (response) {
		// 				var citySelect = $('#shippingcity');
		// 				citySelect.empty();
		// 				citySelect.append('<option value="">Select Shipping City</option>');
		// 				$.each(response, function (key, value) {
		// 					citySelect.append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
		// 				});
		// 			}
		// 		});
		// 	} else {
		// 		$('#shippingcity').empty();
		// 		$('#shippingcity').append('<option value="">Select Shipping City</option>');
		// 	}
		// });
	</script>

	<!-- For demo purposes – can be removed on production : End -->
</body>

</html>