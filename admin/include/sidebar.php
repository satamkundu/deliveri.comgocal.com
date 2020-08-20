<div class="span3">
	<div class="sidebar">
		<ul class="widget widget-menu unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-cog"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Order Management
				</a>
				<ul id="togglePages" class="collapse unstyled">
					<li>
						<a href="todays-orders.php"><i class="icon-tasks"></i>Today's Orders
							<?php
								$f1="00:00:00";
								$from=date('Y-m-d')." ".$f1;
								$t1="23:59:59";
								$to=date('Y-m-d')." ".$t1;
								$result = mysqli_query($con,"SELECT * FROM order_main where datetime Between '$from' and '$to'");
								$num_rows1 = mysqli_num_rows($result);	
							?>
							<b class="label orange pull-right"><?php echo htmlentities($num_rows1); ?></b>
						</a>
					</li>
					<li>
						<a href="pending-orders.php"><i class="icon-tasks"></i>Pending Orders
							<?php	
								$status='delivered';									 
								$ret = mysqli_query($con,"SELECT * FROM order_main where status!='$status' || status is null");
								$num = mysqli_num_rows($ret);	
							?>
							<b class="label orange pull-right"><?php echo htmlentities($num); ?></b>
						</a>
					</li>
					<li>
						<a href="delivered-orders.php"><i class="icon-inbox"></i>Delivered Orders
							<?php	
								$status='delivered';									 
								$rt = mysqli_query($con,"SELECT * FROM order_main where status='$status'");
								$num1 = mysqli_num_rows($rt);
							?>
							<b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="widget widget-menu unstyled">						
			<li><a href="logout.php"><i class="menu-icon icon-signout"></i>Logout</a></li>
		</ul>
	</div>
</div>
