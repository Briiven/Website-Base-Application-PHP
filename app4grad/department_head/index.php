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


				// Prepare the first SQL statement
				$sql = "SELECT COUNT(*) as count FROM application 
        JOIN applicants ON application.appID = applicants.appID 
        WHERE durationID = $session_duration_id AND applicants.program IN ($programs_list)";
				$query = $dbh->prepare($sql);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);
				$appcount = $result->count;

				// Prepare the second SQL statement
				$RAstatus = 1;
				$CRstatus = 1;
				$DHstatus = 0;
				$sql = "SELECT COUNT(*) as count FROM application 
        JOIN applicants ON application.appID = applicants.appID 
        WHERE durationID = $session_duration_id AND applicants.program IN ($programs_list) AND application.RAstatus=:RAstatus AND application.CRstatus=:CRstatus AND application.DHstatus=:DHstatus";
				$query = $dbh->prepare($sql);
				$query->bindParam(':RAstatus', $RAstatus, PDO::PARAM_INT);
				$query->bindParam(':CRstatus', $CRstatus, PDO::PARAM_INT);
				$query->bindParam(':DHstatus', $DHstatus, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);
				$subcount = $result->count;

				// Prepare the third SQL statement
				$RAstatus = 1;
				$CRstatus = 1;
				$DHstatus = 1;
				$sql = "SELECT COUNT(*) as count FROM application 
        JOIN applicants ON application.appID = applicants.appID 
        WHERE durationID = $session_duration_id AND 	applicants.program IN ($programs_list) AND application.RAstatus=:RAstatus AND application.CRstatus=:CRstatus AND application.DHstatus=:DHstatus";
				$query = $dbh->prepare($sql);
				$query->bindParam(':RAstatus', $RAstatus, PDO::PARAM_INT);
				$query->bindParam(':CRstatus', $CRstatus, PDO::PARAM_INT);
				$query->bindParam(':DHstatus', $DHstatus, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);
				$subcount1 = $result->count;

				// Prepare the fourth SQL statement
				$RAstatus = 1;
				$CRstatus = 1;
				$DHstatus = 2;
				$sql = "SELECT COUNT(*) as count FROM application 
        JOIN applicants ON application.appID = applicants.appID 
        WHERE durationID = $session_duration_id AND applicants.program IN ($programs_list) AND application.RAstatus=:RAstatus AND application.CRstatus=:CRstatus AND application.DHstatus=:DHstatus";
				$query = $dbh->prepare($sql);
				$query->bindParam(':RAstatus', $RAstatus, PDO::PARAM_INT);
				$query->bindParam(':CRstatus', $CRstatus, PDO::PARAM_INT);
				$query->bindParam(':DHstatus', $DHstatus, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);
				$subcount2 = $result->count;
				?>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($appcount); ?></div>
								<div class="font-14 text-secondary weight-500">Department Applications</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-file"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
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
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($subcount1); ?></div>
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
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($subcount2); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			// Get the department name
			$sqlDepartmentName = "SELECT department FROM staff WHERE staffID = :session_id";
			$query = $dbh->prepare($sqlDepartmentName);
			$query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
			$query->execute();
			$departmentName = $query->fetchColumn();

			// Get the department ID
			$sqlDepartmentID = "SELECT id FROM departments WHERE departmentShortName = :department";
			$query = $dbh->prepare($sqlDepartmentID);
			$query->bindParam(':department', $departmentName, PDO::PARAM_STR);
			$query->execute();
			$departmentID = $query->fetchColumn();
			?>

			<?php
			$sqlPrograms = "SELECT p.ProgramShortName, COUNT(*) as program_count
							FROM applicants a
							INNER JOIN application app ON a.appID = app.appID
							INNER JOIN programs p ON a.program = p.ProgramShortName
							WHERE p.deptID = :department_id AND app.durationID = :session_duration_id
							GROUP BY p.ProgramShortName";
			$query = $dbh->prepare($sqlPrograms);
			$query->bindParam(':department_id', $departmentID, PDO::PARAM_INT);
			$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
			$query->execute();
			$programResults = $query->fetchAll(PDO::FETCH_OBJ);

			$sqlSex = "SELECT a.sex, COUNT(*) as sex_count
					FROM applicants a
					INNER JOIN application app ON a.appID = app.appID
					INNER JOIN programs p ON a.program = p.ProgramShortName
					WHERE p.deptID = :department_id AND app.durationID = :session_duration_id
					GROUP BY a.sex";
			$query = $dbh->prepare($sqlSex);
			$query->bindParam(':department_id', $departmentID, PDO::PARAM_INT);
			$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
			$query->execute();
			$sexResults = $query->fetchAll(PDO::FETCH_OBJ);

			$sqlAppType = "SELECT app.appType, COUNT(*) as appType_count
						FROM applicants a
						INNER JOIN application app ON a.appID = app.appID
						INNER JOIN programs p ON a.program = p.ProgramShortName
						WHERE p.deptID = :department_id AND app.durationID = :session_duration_id
						GROUP BY app.appType";
			$query = $dbh->prepare($sqlAppType);
			$query->bindParam(':department_id', $departmentID, PDO::PARAM_INT);
			$query->bindParam(':session_duration_id', $session_duration_id, PDO::PARAM_STR);
			$query->execute();
			$appTypeResults = $query->fetchAll(PDO::FETCH_OBJ);
			?>

			<div class="row pb-10">
				<!-- Total per Program -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
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

				<!-- Per Application Type -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
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
										<?php echo htmlspecialchars($result->ProgramShortName); ?>
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
								<th>DEPARTMENT HEAD</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php
								$CRstatus = 1;
								$DHstatus = 0;

								// Assuming $conn is your database connection object
								$sample = mysqli_query($conn, "SELECT department FROM staff WHERE staffID = '$session_id'");

								if ($row = mysqli_fetch_array($sample)) {
									// Store the department value in $department
									$department = $row['department'];

									// Initialize the $programs array
									$programs = [];

									// Set the programs based on the department
									if ($department == 'DIT') {
										$programs = ['BSOA', 'BSIT', 'BSCS'];
									} elseif ($department == 'DIET') {
										$programs = ['BSIE', 'BSIND-AT', 'BSIND-ET', 'BSIND-ECT'];
									} elseif ($department == 'DCEEE') {
										$programs = ['BSCPE', 'BSEE', 'BSECE'];
									} elseif ($department == 'DCEA') {
										$programs = ['BSCE', 'BSARCH'];
									} elseif ($department == 'DAFE') {
										$programs = ['BSABE'];
									}

									// Convert the programs array to a comma-separated string for SQL IN clause
									$programs_list = "'" . implode("','", $programs) . "'";
								}

								$sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus 
        								FROM application 
       									JOIN applicants ON application.appID = applicants.appID 
        								WHERE durationID = $session_duration_id
										AND applicants.program IN ($programs_list) 
        								AND application.DHstatus = $DHstatus AND application.CRstatus = $CRstatus 
        								ORDER BY lid DESC 
        								LIMIT 10";

								$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								$cnt = 1; // Initialize the counter outside the loop

								$hasPendingApplications = mysqli_num_rows($query) > 0;

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
									<td><?php $stats = $row['DHstatus'];
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

				</div>
		
				</tr>
			<?php $cnt++;
								} ?>
			</tbody>
			</table>
			<?php if (!$hasPendingApplications) { ?>
				<script>
					document.addEventListener('DOMContentLoaded', function() {
						document.getElementById('approveAllBtn').disabled = true;
					});
				</script>
			<?php } ?>
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

</body>

</html>