<!-- Inprocess Orders -->
<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// require_once "PHPMailer/src/PHPMailer.php";
// require_once "PHPMailer/src/SMTP.php";
// require_once "PHPMailer/src/Exception.php";
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Bangkok'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());

	// $mail = new PHPMailer;
	// $mail->isSMTP();
	// $mail->Host = 'smtp.gmail.com'; // เปลี่ยนเป็นเซิร์ฟเวอร์ SMTP ของคุณ
	// $mail->SMTPAuth = true;
	// $mail->Username = 'nwmin22@gmail.com'; // อีเมลของคุณ
	// $mail->Password = 'ogph giaq bnuk ecmx'; // รหัสผ่านของคุณ
	// $mail->SMTPSecure = 'tls';
	// $mail->Port = 587; // หรือพอร์ต SMTP ของคุณ

	// $mail->setFrom('VinTageShirtShop@gmail.com', 'Vintage Shirt Shop'); // อีเมลและชื่อผู้ส่ง
	// $mail->addAddress('nwmin30@gmail.com', 'Admin Vintage shirt shop'); // อีเมลแอดมินและชื่อแอดมิน

	// $mail->isHTML(true);

	// $mail->Subject = 'New Order Notification';
	// $mail->Body = 'Now have a new Order.';

	// if (!$mail->send()) {
	// 	echo 'Email could not be sent.';
	// } else {
	// 	echo 'Email sent to admin.';
	// }

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Pending Orders</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<script language="javascript" type="text/javascript">
			var popUpWin = 0;
			function popUpWindow(URLStr, left, top, width, height) {
				if (popUpWin) {
					if (!popUpWin.closed) popUpWin.close();
				}
				popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
			}
		</script>
	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Inprocess Orders</h3>
								</div>
								<div class="module-body table">
									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>
									<br />

									<table cellpadding="0" cellspacing="0" border="0"
									class="datatable-1 table-bordered table-striped 	table display table-responsive"
										style="width: 100%;">
										<!-- datatable-1  table-bordered table-striped	 display  -->
										<thead>
											<tr>
												<th style="width: 5%;">#</th>
												<th style="width: 15%;">Name</th>
												<th style="width: 15%;">Email / Contact no</th>
												<th style="width: 20%;">Shipping Address</th>
												<th style="width: 10%;">Product</th>
												<th style="width: 5%;">Qty</th>
												<th style="width: 10%;">Amount</th>
												<th style="width: 5%;">Total Pirce</th>
												<th style="width: 10%;">Order Date</th>
												<th style="width: 5%;">Action</th>


											</tr>
										</thead>

										<tbody>
											<?php
											$status = 'Delivered';
											$status2 = 'in Process';
											$status3 = 'Close Order';
											$query = mysqli_query($con, "select users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,   orders.totalPrice as total,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id  from orders join users on  orders.userId=users.id join products on products.id=orders.productId where orders.	orderStatus='$status2' ");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['username']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['useremail']); ?>/
														<?php echo htmlentities($row['usercontact']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['shippingaddress'] . "," . $row['shippingcity'] . "," . $row['shippingstate'] . "-" . $row['shippingpincode']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['productname']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['quantity']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['quantity'] * $row['productprice'] + $row['shippingcharge']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['total']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['orderdate']); ?>
													</td>
													<td> <a href="updateorder.php?oid=<?php echo htmlentities($row['id']); ?>"
															title="Update order" target="_blank"><i class="icon-edit"></i></a>
													</td>
												</tr>

												<?php $cnt = $cnt + 1;
											} ?>
										</tbody>
									</table>
								</div>
							</div>



						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>

		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function () {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
			});
		</script>
	</body>
<?php } ?>