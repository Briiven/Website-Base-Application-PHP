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
<?php
// code for action taken on application
if (isset($_POST['update'])) {
	$did = intval($_GET['appid']);
	$DHstatus = $_POST['DHstatus'];

	date_default_timezone_set('Asia/Manila');
	$DHremarkDate = date('Y-m-d G:i:s', strtotime("now"));

	try {
		$sql = "UPDATE application SET DHstatus = :DHstatus, DHremarkDate = :DHremarkDate WHERE id = :did";
		$query = $dbh->prepare($sql);
		$query->bindParam(':DHstatus', $DHstatus, PDO::PARAM_INT);
		$query->bindParam(':DHremarkDate', $DHremarkDate, PDO::PARAM_STR);
		$query->bindParam(':did', $did, PDO::PARAM_INT);
		$query->execute();

		// Check if any rows were affected
		$rowsAffected = $query->rowCount();

		if ($rowsAffected > 0) {
			echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Application Updated Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'index.php';
                    });
                });
            </script>";
		} else {
			throw new Exception('No rows were updated.');
		}
	} catch (Exception $e) {
		echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error updating application: " . $e->getMessage() . "'
            });
        </script>";
	}
}

// code for approving all applications
if (isset($_POST['approve_all'])) {
	date_default_timezone_set('Asia/Manila');
	$DHremarkDate = date('Y-m-d G:i:s', strtotime("now"));

	try {
		$sql = "UPDATE application SET DHstatus = 1, DHremarkDate = :DHremarkDate WHERE DHstatus = 0 AND CRstatus = 1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':DHremarkDate', $DHremarkDate, PDO::PARAM_STR);
		$query->execute();

		// Check if any rows were affected
		$rowsAffected = $query->rowCount();

		if ($rowsAffected > 0) {
			echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'All Applications Approved Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'index.php';
                    });
                });
            </script>";
		} else {
			throw new Exception('No applications were approved.');
		}
	} catch (Exception $e) {
		echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error approving applications: " . $e->getMessage() . "'
            });
        </script>";
	}
}
?>






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
								<li class="breadcrumb-item active" aria-current="page">Pending Applications</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
			<?php
			$duration_query = mysqli_query($conn, "SELECT isActive FROM duration WHERE id = $session_duration_id AND isActive = 1");
			$is_active = mysqli_num_rows($duration_query) > 0;

			if ($is_active) {
				?>
				<div class="card-box mb-30">
					<div class="pd-20 d-flex justify-content-between align-items-center">
						<h2 class="text-blue h4">PENDING APPLICATIONS</h2>

						<form method="POST" action="" class="approve-all-btn">
							<button type="submit" name="approve_all" id="approveAllBtn" class="btn btn-success" style="width: 3 in;">
								Approve All Applications <i class="fa fa-check-square ml-2"></i>
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
									<th>DEPARTMENT HEAD</th>
									<th class="datatable-nosort">ACTION</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sample = mysqli_query($conn, "SELECT department FROM staff WHERE staffID = '$session_id'");

								if ($row = mysqli_fetch_array($sample)) {
									// Store the department value in $department
									$department = $row['department'];

									// Initialize variables
									$department_id = null;
									$programs = [];

									// Query to get department_id from departments table
									$dept_query = mysqli_query($conn, "SELECT id FROM departments WHERE departmentShortName = '$department'");
									if ($dept_row = mysqli_fetch_array($dept_query)) {
										$department_id = $dept_row['id'];

										// Query to get programs based on department_id from programs table
										$programs_query = mysqli_query($conn, "SELECT programShortName FROM programs WHERE deptID = '$department_id'");
										while ($prog_row = mysqli_fetch_array($programs_query)) {
											$programs[] = $prog_row['programShortName'];
										}
									}

									// Convert the programs array to a comma-separated string for SQL IN clause
									$programs_list = "'" . implode("','", $programs) . "'";
								}

								// Initialize filters
								$filterProgram = isset($_GET['filterProgram']) ? $_GET['filterProgram'] : '';
								$filterAppType = isset($_GET['filterAppType']) ? $_GET['filterAppType'] : '';

								$CRstatus = 1;
								$DHstatus = 0;

								// Build SQL query with filters
								$sql = "SELECT application.id as lid, durationID, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus 
										FROM application 
										JOIN applicants ON application.appID = applicants.appID 
										WHERE application.durationID = $session_duration_id
										AND applicants.program IN ($programs_list) 
										AND application.DHstatus = $DHstatus AND application.CRstatus = $CRstatus";

								// Apply program filter
								if (!empty($filterProgram)) {
									$sql .= " AND applicants.program = '$filterProgram'";
								}

								// Apply application type filter
								if (!empty($filterAppType)) {
									$sql .= " AND application.appType = '$filterAppType'";
								}

								$sql .= " ORDER BY lid DESC 
										LIMIT 10";

								$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								$cnt = 1; // Initialize the counter outside the loop

								$hasPendingApplications = mysqli_num_rows($query) > 0;

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
										<td>
											<?php $stats = $row['DHstatus'];
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
													<input type="hidden" name="DHstatus" value="1">
													<button type="submit" name="update" title="Approve" class="btn btn-success">
														Approve <i class="fa fa-check-square"></i>
													</button>
												</form>
												<form method="POST" action="?appid=<?php echo $row['lid']; ?>" class="mx-1" style="display:inline;">
													<input type="hidden" name="DHstatus" value="2">
													<button type="submit" name="update" title="Reject" class="btn btn-danger">
														Reject <i class="fa fa-window-close"></i>
													</button>
												</form>
											</div>
										</td>
									</tr>
								<?php
									$cnt++;
								} ?>
							</tbody>
						</table>
					</div>
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

</html>