<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<body>

	<?php include('includes/navbar.php') ?>

	<?php include('includes/right_sidebar.php') ?>

	<?php include('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
				<div class="col-md-4 user-icon">
						<img src="../vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">

						<?php $query = mysqli_query($conn, "select * from staff where staffID = '$session_id'") or die(mysqli_error($conn));
						$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome back <div class="weight-600 font-30 text-blue"><?php echo $row['firstName'] . " " . $row['lastName']; ?>,</div>
						</h4>
						<p class="font-18 max-width-600">We Roar as One!</p>
					</div>
					<div class="col-md-4">
						<?php
							$durationQuery = mysqli_query($conn, "SELECT * FROM duration WHERE id = '$session_duration_id'") or die(mysqli_error($conn));
							
							if ($row = mysqli_fetch_array($durationQuery)) {
								$startDate = date("F j, Y", strtotime($row['startDate']));
								$endDate = date("F j, Y", strtotime($row['endDate'])	);
							} else {
								$startDate = "N/A";
								$endDate = "N/A";
							}
							$isActive = $row['isActive'];
						?>

						<h6 class="mt-3 weight-500 mb-10 text-capitalize">
							- Current Confirmation Period -
							<div class="weight-600 text-green"><?php echo $startDate . " - " . $endDate; ?></div>
							<div class="<?php echo ($isActive == 1) ? 'text-success' : 'text-danger'; ?>">
								<?php
								if ($isActive == 1) {
									echo "Confirmation is Open";
								} else {
									echo "Confirmation is already Closed";
								}
								?>
							</div>
						</h6>


					</div>

				</div>
			</div>
			<div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						// Assuming $dbh is your PDO connection and $session_id is already set and properly sanitized
						$sql = "SELECT * FROM application WHERE RAstaffID = :session_id and durationID = $session_duration_id";
						$query = $dbh->prepare($sql);
						$query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$appcount = $query->rowCount();
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($appcount); ?></div>
								<div class="font-14 text-secondary weight-500">Advisee Applications</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-file"></i></div>
							</div>
						</div>
					</div>
				</div>

				<?php
				$statuses = [
					['label' => 'Waiting for Approval', 'color' => '#00eccf', 'icon' => 'fa fa-hourglass-end', 'status' => 0],
					['label' => 'Approved', 'color' => '#09cc06', 'icon' => 'fa fa-hourglass', 'status' => 1],
					['label' => 'Rejected', 'color' => '#ff5b5b', 'icon' => 'fa fa-hourglass-o', 'status' => 2],
				];

				foreach ($statuses as $status) {
					$RAstatus = $status['status'];
					$sql = "SELECT * FROM application WHERE RAstaffID = :session_id and RAstatus = :RAstatus and durationID = $session_duration_id" ;
					$query = $dbh->prepare($sql);
					$query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
					$query->bindParam(':RAstatus', $RAstatus, PDO::PARAM_INT);
					$query->execute();
					$results = $query->fetchAll(PDO::FETCH_OBJ);
					$subcount = $query->rowCount();
				?>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark"><?php echo ($subcount); ?></div>
									<div class="font-14 text-secondary weight-500"><?php echo ($status['label']); ?></div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="<?php echo ($status['color']); ?>"><i class="icon-copy <?php echo ($status['icon']); ?>" aria-hidden="true"></i></div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>


			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">PENDING APPLICATIONS</h2>
				</div>
				<?php
				$duration_query = mysqli_query($conn, "SELECT isActive FROM duration WHERE id = $session_duration_id AND isActive = 1");
				$is_active = mysqli_num_rows($duration_query) > 0;

				if ($is_active) {
				?>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>APPLICANT</th>
								<th>DATE APPLIED</th>
								<th>APPLICATION TYPE</th>
								<th>REGISTRATION ADVISER</th>
								<th class="datatable-nosort">VIEW</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								// Initializing the status
								$RAstatus = 0;


								// SQL query to fetch application data based on RAstaffID
								$sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus 
                        FROM application 
                        JOIN applicants ON application.appID = applicants.appID 
                        WHERE application.RAstatus = '$RAstatus' 
                        AND application.RAstaffID = '$session_id' 
                        ORDER BY lid DESC LIMIT 10";

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
									<td><?php echo $row['appDate']; ?></td>
									<td><?php echo $row['appType']; ?></td>
									<td><?php
										$stats = $row['RAstatus'];
										if ($stats == 1) {
											echo '<span style="color: green">Approved</span>';
										} elseif ($stats == 2) {
											echo '<span style="color: red">Rejected</span>';
										} else {
											echo '<span style="color: blue">Pending</span>';
										}
										?></td>
									<td>
										<div class="table-actions d-flex justify-content-center">
											<form method="GET" action="viewaction_application.php" class="mx-1" style="display:inline;">
												<input type="hidden" name="appid" value="<?php echo $row['lid']; ?>">
												<button type="submit" title="Review Application" class="btn btn-success custom-view-btn">
													Review Application &nbsp; <i class="fa fa-file-text-o"></i>
												</button>
											</form>
										</div>
									</td>
							</tr>
						<?php $cnt++;
								} ?>
						</tbody>
					</table>
				</div>
				<?php
				} else {
					// Render a message if isActive is not 1
					?>
					<div class="card-box mb-30">
						<div class="pd-20">
							<h2 class="text-blue h4">Confirmation for Pending Application is already closed</h2>
						</div>
						<div class="pb-20">
							<p>The confirmation period has ended. </p>
						</div>
					</div>
					<?php
				}
				?>

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