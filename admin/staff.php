<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .swal2-cancel {
            order: 1;
        }
        .swal2-confirm {
            order: 2;
            background-color: red !important;
            border-color: red !important;
            color: white !important;
        }
    </style>
</head>

<?php
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    // We will not delete the applicant here, just show the confirmation dialog
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to delete this college staff?',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
                customClass: {
                    cancelButton: 'swal2-cancel',
                    confirmButton: 'swal2-confirm'
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    // If user confirms, proceed with deletion
                    document.location = 'staff.php?confirm_delete=$delete';
                }
            });
        });
    </script>";
}

if (isset($_GET['confirm_delete'])) {
    $delete = $_GET['confirm_delete'];
    $sql = "DELETE FROM staff WHERE staffID = $delete";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Show success message after deletion
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'College Staff deleted Successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    document.location = 'staff.php';
                });
            });
        </script>";
    }
}
?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="title pb-20">
				<h2 class="h3 mb-0">Administrative Breakdown</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-12 col-lg-12 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT staffID from staff";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$staffcount=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($staffcount);?></div>
								<div class="font-14 text-secondary weight-500">Total Staffs</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php 
						 $query_reg_CR = mysqli_query($conn,"select * from staff where role = 'College Registrar' ")or die(mysqli_error($conn));
						 $count_reg_CR = mysqli_num_rows($query_reg_CR);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($count_reg_CR); ?></div>
								<div class="font-14 text-secondary weight-500">College Registrar</div>
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
						 $query_reg_RA = mysqli_query($conn,"select * from staff where role = 'Registration Adviser' ")or die(mysqli_error($conn));
						 $count_reg_RA = mysqli_num_rows($query_reg_RA);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_RA); ?></div>
								<div class="font-14 text-secondary weight-500">Registration Adviser</div>
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
						 $query_reg_DH = mysqli_query($conn,"select * from staff where role = 'Department Head' ")or die(mysqli_error($conn));
						 $count_reg_DH = mysqli_num_rows($query_reg_DH);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_DH); ?></div>
								<div class="font-14 text-secondary weight-500">Department Head</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php 
						 $query_reg_CD = mysqli_query($conn,"select * from staff where role = 'College Dean' ")or die(mysqli_error($conn));
						 $count_reg_CD = mysqli_num_rows($query_reg_CD);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_CD); ?></div>
								<div class="font-14 text-secondary weight-500">College Dean</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL STAFFS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">FULL NAME</th>
								<th>EMAIL</th>
								<th>DEPARTMENT</th>
								<th>POSITION</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								 <?php
		                         $staff_query = mysqli_query($conn,"select * from staff LEFT JOIN departments ON staff.department = departments.DepartmentShortName where role != 'Admin' ORDER BY staff.staffID") or die(mysqli_error($conn));
		                         while ($row = mysqli_fetch_array($staff_query)) {
		                         $id = $row['staffID'];
		                             ?>

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['firstName'] . " " . $row['lastName']; ?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['email']; ?></td>
	                            <td><?php echo $row['DepartmentName']; ?></td>
								<td><?php echo $row['role']; ?></td>
								<td>
												<div class="table-actions">
													<a href="edit_staff.php?edit=<?php echo $row['staffID']; ?>" data-color="#265ed7">
														<i class="icon-copy fa fa-pencil"></i>
													</a>
													<a href="staff.php?delete=<?php echo $row['staffID'] ?>" data-color="#e95959">
														<i class="icon-copy fa fa-trash"></i>
													</a>
												</div>
											</td>
							</tr>
							<?php } ?>  
						</tbody>
					</table>
			   </div>
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