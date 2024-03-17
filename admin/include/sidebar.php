<div class="span3">
	<div class="sidebar">


		<ul class="widget widget-menu unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-cog"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					Order Management
				</a>
				<ul id="togglePages" class="collapse unstyled">
				<li>
						<a href="pending-orders.php">
							<i class="icon-tasks"></i>
							Pending Orders
							<?php
							$ret = mysqli_query($con, "SELECT * FROM Orders where  orderStatus is null ");
							$num = mysqli_num_rows($ret); { ?><b class="label orange pull-right">
									<?php echo htmlentities($num); ?>
								</b>
							<?php } ?>
						</a>
					</li>

					<li>
						<a href="todays-orders.php">
							<i class="icon-tasks"></i>
							Inprocess Orders
							<?php
							$status2 = 'In Process';
							$ret = mysqli_query($con, "SELECT * FROM Orders where orderStatus='$status2'  ");
							$num = mysqli_num_rows($ret); { ?><b class="label orange pull-right">
									<?php echo htmlentities($num); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					
					<li>
						<a href="delivered-orders.php">
							<i class="icon-inbox"></i>
							Delivered Orders
							<?php
							$status = 'Delivered';
							$rt = mysqli_query($con, "SELECT * FROM Orders where orderStatus='$status'");
							$num1 = mysqli_num_rows($rt); { ?><b class="label green pull-right">
									<?php echo htmlentities($num1); ?>
								</b>
							<?php } ?>

						</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="manage-users.php">
					<i class="menu-icon icon-group"></i>
					Manage users
				</a>
			</li>
		</ul>


		<ul class="widget widget-menu unstyled">
			<li><a href="category.php"><i class="menu-icon icon-tasks"></i> Create Category </a></li>
			<li><a href="subcategory.php"><i class="menu-icon icon-tasks"></i>Sub Category </a></li>
			<li><a href="insert-product.php"><i class="menu-icon icon-paste"></i>Insert Product </a></li>
			<li><a href="manage-products.php"><i class="menu-icon icon-table"></i>Manage Products </a></li>

		</ul><!--/.widget-nav-->

		<ul class="widget widget-menu unstyled">
			<li><a href="user-logs.php"><i class="menu-icon icon-tasks"></i>User Login Log </a></li>

			<li>
				<a href="logout.php">
					<i class="menu-icon icon-signout"></i>
					Logout
				</a>
			</li>
		</ul>

	</div><!--/.sidebar-->
</div><!--/.span3-->