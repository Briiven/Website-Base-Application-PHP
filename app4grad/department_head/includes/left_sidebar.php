<div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.php">
				<img src="../vendors/images/deskapp-logo-svg.png" alt="" class="dark-logo">
				<img src="../vendors/images/deskapp-logo-white-svg.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
						</a>
						
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-apartment"></span><span class="mtext"> Dept. Applications </span>
						</a>
						<ul class="submenu">
							<li><a href="applications.php">All</a></li>
							<li><a href="pending.php">Pending</a></li>
							<li><a href="approved.php">Approved</a></li>
							<li><a href="rejected.php">Rejected</a></li>
						</ul>
					</li>

					<?php
					$roleQuery = $query= mysqli_query($conn,"select * from application where RAstaffID = '$session_id'")or 
						die(mysqli_error($conn));$row = mysqli_fetch_array($roleQuery);

						if (mysqli_num_rows($roleQuery) > 0) {

			
					?>
					<li class="dropdown">
						<a href="advicy.php:;" class="dropdown-toggle">
							<span class="micon dw dw-pen"></span><span class="mtext">Advisee Applications</span>
						</a>
						<ul class="submenu">
							<li><a href="applications1.php">All</a></li>
							<li><a href="pending1.php">Pending</a></li>
							<li><a href="approved1.php">Approved</a></li>
							<li><a href="rejected1.php">Rejected</a></li>
						</ul>
					</li>
					<?php 
						}
					?>

					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Extra</div>
					</li>
					<li>
						<a href="https://cvsu.edu.ph/" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-edit-2"></span><span class="mtext">Visit Us</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>