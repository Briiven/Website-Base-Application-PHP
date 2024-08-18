<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/right_sidebar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h4>App4Grad Portal</h4>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">All Applications</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">ALL APPLICATIONS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<th class="table-plus datatable-nosort">APPLICANT</th>
							<th>PROGRAM</th>
							<th>DATE APPLIED</th>
							<th>APPPLICATION TYPE</th>
							<th>REGISTRATION ADVISER</th>
							<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								// Assuming $conn is your database connection object
								$sample = mysqli_query($conn, "SELECT program FROM staff WHERE staffID = '$session_id'");

								if ($row = mysqli_fetch_array($sample)) {
									// Assuming you want to store the program value in $program
									$program = $row['program'];
								}

								$sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus FROM application JOIN applicants ON application.appID = applicants.appID WHERE applicants.program = '$program' ORDER BY lid DESC LIMIT 10";

								$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								$cnt = 1; // Initialize the counter outside the loop

								while ($row = mysqli_fetch_array($query)) {
								?>
									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt mr-2 flex-shrink-0">
												<b><?php echo htmlentities($cnt); ?></b>
											</div>
											<div class="avatar mr-2 flex-shrink-0">
												<img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
											</div>
											<div class="txt">
												<div class="weight-600"><?php echo $row['firstName'] . " " . $row['lastName']; ?></div>
											</div>
										</div>
									</td>
									<td><?php echo $row['program']; ?></td>
									<td><?php echo $row['appDate']; ?></td>
									<td><?php echo $row['appType']; ?></td>
									<td><?php $stats = $row['RAstatus'];
										if ($stats == 1) {
										?>
											<span style="color: green">Approved</span>
										<?php }
										if ($stats == 2) { ?>
											<span style="color: red">Rejected</span>
										<?php }
										if ($stats == 0) { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item" href="application_details.php?appid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i> View</a>
												<a class="dropdown-item" href="index.php?appid=<?php echo $row['lid']; ?>"><i class="dw dw-delete-3"></i>Delete</a>
											</div>
										</div>
									</td>
							</tr>
						<?php $cnt++;
								} ?>
						</tbody>
					</table>
				</div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- buttons for Export datatable -->
	<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

	<script src="../vendors/scripts/datatable-setting.js"></script>
</body>
</body>

</html>