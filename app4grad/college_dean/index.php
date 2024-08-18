<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<head>
	<!-- SweetAlert CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
	<!-- SweetAlert JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.custom-view-btn {
			background-color: #265ed7;
			color: white !important;
			width: 100%;
			text-align: center;
		}
	</style>
</head>

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
							<div class="<?php echo ($isActive == 1) ? 'text-green' : 'text-danger'; ?>">
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
						$sql = "SELECT * FROM application where durationID = $session_duration_id";
						$query = $dbh->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$appcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($appcount); ?></div>
								<div class="font-14 text-secondary weight-500">CEIT Applications</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-file"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$DHstatus = 1;
						$CDstatus = 0;
						$sql = "SELECT id from application where CDstatus=:CDstatus and DHstatus=:DHstatus AND durationID = $session_duration_id";
						$query = $dbh->prepare($sql);
						$query->bindParam(':CDstatus', $CDstatus, PDO::PARAM_STR);
						$query->bindParam(':DHstatus', $DHstatus, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$subcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($subcount); ?></div>
								<div class="font-14 text-secondary weight-500">Waiting for Approval</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$CDstatus = 1;
						$sql = "SELECT id from application where CDstatus=:CDstatus AND durationID = $session_duration_id";
						$query = $dbh->prepare($sql);
						$query->bindParam(':CDstatus', $CDstatus, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$subcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($subcount); ?></div>
								<div class="font-14 text-secondary weight-500">Approved</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$CDstatus = 2;
						$sql = "SELECT id from application where CDstatus=:CDstatus AND durationID = $session_duration_id";
						$query = $dbh->prepare($sql);
						$query->bindParam(':CDstatus', $CDstatus, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$subcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($subcount); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row pb-10">
				<!-- Total per Program -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$sql = "SELECT a.program, COUNT(*) as program_count 
								FROM applicants a 
								INNER JOIN application app ON a.appID = app.appID 
								WHERE app.durationID = :session_duration_id 
								GROUP BY a.program";
						$query = $dbh->prepare($sql);
						$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
						$query->execute();
						$programResults = $query->fetchAll(PDO::FETCH_OBJ);
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<a href="#" data-toggle="modal" data-target="#programModal">
									<div class="weight-700 font-18 text-dark">Per Program</div>
									<div class="font-14 text-secondary weight-500">Click to View</div>
								</a>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-graduation-cap" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Per Sex -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$sql = "SELECT a.sex, COUNT(*) as sex_count 
								FROM applicants a 
								INNER JOIN application app ON a.appID = app.appID 
								WHERE app.durationID = :session_duration_id 
								GROUP BY a.sex";
						$query = $dbh->prepare($sql);
						$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
						$query->execute();
						$sexResults = $query->fetchAll(PDO::FETCH_OBJ);
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<a href="#" data-toggle="modal" data-target="#sexModal">
									<div class="weight-700 font-18 text-dark">Per Sex</div>
									<div class="font-14 text-secondary weight-500">Click to View</div>
								</a>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-user" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Per Department -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$sql = "SELECT d.DepartmentShortName, COUNT(*) as department_count
								FROM applicants a
								INNER JOIN application app ON a.appID = app.appID
								INNER JOIN programs p ON a.program = p.ProgramShortName
								INNER JOIN departments d ON p.deptID = d.id
								WHERE app.durationID = :session_duration_id
								GROUP BY d.DepartmentShortName";
						$query = $dbh->prepare($sql);
						$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
						$query->execute();
						$departmentResults = $query->fetchAll(PDO::FETCH_OBJ);
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<a href="#" data-toggle="modal" data-target="#departmentModal">
									<div class="weight-700 font-18 text-dark">Per Department</div>
									<div class="font-14 text-secondary weight-500">Click to View</div>
								</a>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-building" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<!-- Per Application Type -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<?php
						$sql = "SELECT app.appType, COUNT(*) as appType_count
								FROM applicants a
								INNER JOIN application app ON a.appID = app.appID
								WHERE app.durationID = :session_duration_id
								GROUP BY app.appType";
						$query = $dbh->prepare($sql);
						$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
						$query->execute();
						$appTypeResults = $query->fetchAll(PDO::FETCH_OBJ);
						?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<a href="#" data-toggle="modal" data-target="#appTypeModal">
									<div class="weight-700 font-18 text-dark">Per App Type</div>
									<div class="font-14 text-secondary weight-500">Click to View</div>
								</a>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-list" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Per Program Modal -->
			<div class="modal fade" id="programModal" tabindex="-1" role="dialog" aria-labelledby="programModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="programModalLabel">Program Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="list-group">
								<?php foreach ($programResults as $result) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo htmlspecialchars($result->program); ?>
										<span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($result->program_count); ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal for Per Sex -->
			<div class="modal fade" id="sexModal" tabindex="-1" role="dialog" aria-labelledby="sexModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="sexModalLabel">Sex Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="list-group">
								<?php foreach ($sexResults as $result) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo htmlspecialchars($result->sex); ?>
										<span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($result->sex_count); ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal for Per Department -->
			<div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="departmentModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="departmentModalLabel">Department Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="list-group">
								<?php foreach ($departmentResults as $result) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo htmlspecialchars($result->DepartmentShortName); ?>
										<span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($result->department_count); ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal for Per Application Type -->
			<div class="modal fade" id="appTypeModal" tabindex="-1" role="dialog" aria-labelledby="appTypeModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="appTypeModalLabel">Application Type Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<ul class="list-group">
								<?php foreach ($appTypeResults as $result) { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<?php echo htmlspecialchars($result->appType); ?>
										<span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($result->appType_count); ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<?php

			// code for action taken on application
			if (isset($_POST['update'])) {
				$did = intval($_GET['appid']);
				$CDstatus = $_POST['CDstatus'];

				date_default_timezone_set('Asia/Manila');
				$CDremarkDate = date('Y-m-d G:i:s', strtotime("now"));

				$sql = "UPDATE application SET CDstatus = :CDstatus, CDremarkDate = :CDremarkDate WHERE id = :did";
				$query = $dbh->prepare($sql);
				$query->bindParam(':CDstatus', $CDstatus, PDO::PARAM_INT);
				$query->bindParam(':CDremarkDate', $CDremarkDate, PDO::PARAM_STR);
				$query->bindParam(':did', $did, PDO::PARAM_INT);
				$query->execute();

				echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Application Updated Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                window.location = 'index.php'; // Replace with your actual redirect page
            });
        });
    </script>";
			}

			// code for approving all applications
			if (isset($_POST['approve_all'])) {
				date_default_timezone_set('Asia/Manila');
				$CDremarkDate = date('Y-m-d G:i:s', strtotime("now"));

				$sql = "UPDATE application SET CDstatus = 1, CDremarkDate = :CDremarkDate WHERE CDstatus = 0 AND CRstatus = 1";
				$query = $dbh->prepare($sql);
				$query->bindParam(':CDremarkDate', $CDremarkDate, PDO::PARAM_STR);
				$query->execute();

				echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'All Applications Approved Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                window.location = 'index.php'; // Replace with your actual redirect page
            });
        });
    </script>";
			}


			// Check for pending applications
			$DHstatus = 1;
			$CDstatus = 0;
			$sql = "SELECT COUNT(*) as pending_count FROM application WHERE DHstatus = $DHstatus AND CDstatus = $CDstatus";
			$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$row = mysqli_fetch_assoc($query);
			$hasPendingApplications = $row['pending_count'] > 0;

			?>
			<div class="card-box mb-30">
				<?php
				$duration_query = mysqli_query($conn, "SELECT isActive FROM duration WHERE id = $session_duration_id AND isActive = 1");
				$is_active = mysqli_num_rows($duration_query) > 0;

				if ($is_active) {
				?>
				<div class="pd-20 d-flex justify-content-between align-items-center">
					<h2 class="text-blue h4">PENDING APPLICATIONS</h2>
					<form method="POST" action="" class="approve-all-btn">
						<button type="submit" name="approve_all" id="approveAllBtn" class="btn btn-success" style="width: 3 in;">
							Approve All Applications <i class="fa fa-check-square ml-2 "></i>
						</button>
					</form>
				</div>
				
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>APPLICANT</th>
								<th>PROGRAM</th>
								<th>DATE APPLIED</th>
								<th>APPLICATION TYPE</th>
								<th>COLLEGE DEAN</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CDstatus, application.DHstatus, application.CDstatus FROM application JOIN applicants ON application.appID = applicants.appID WHERE application.DHstatus = $DHstatus AND application.CDstatus = $CDstatus ORDER BY lid DESC LIMIT 10";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							$cnt = 1;
							while ($row = mysqli_fetch_array($query)) {
							?>

								<tr>
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
									<td><?php $stats = $row['CDstatus'];
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
										<div class="table-actions d-flex justify-content-center">
											<form method="GET" action="viewaction_application.php" class="mx-1" style="display:inline;">
												<input type="hidden" name="appid" value="<?php echo $row['lid']; ?>">
												<button type="submit" title="View" class="btn btn-primary custom-view-btn">
													View <i class="fa fa-eye"></i>
												</button>
											</form>
											<form method="POST" action="?appid=<?php echo $row['lid']; ?>" class="mx-1" style="display:inline;">
												<input type="hidden" name="CDstatus" value="1">
												<button type="submit" name="update" title="Approve" class="btn btn-success">
													Approve <i class="fa fa-check-square"></i>
												</button>
											</form>
											<form method="POST" action="?appid=<?php echo $row['lid']; ?>" class="mx-1" style="display:inline;">
												<input type="hidden" name="CDstatus" value="2">
												<button type="submit" name="update" title="Reject" class="btn btn-danger">
													Reject <i class="fa fa-window-close"></i>
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
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var approveAllBtn = document.getElementById('approveAllBtn');
			var hasPendingApplications = <?php echo json_encode($hasPendingApplications); ?>;
			approveAllBtn.disabled = !hasPendingApplications;
		});
	</script>
</body>

</html>