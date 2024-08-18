<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<head>
	<!-- SweetAlert CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
	<!-- SweetAlert JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php $get_id = $_GET['edit']; ?>
<?php
if (isset($_POST['edit'])) {
	$progname = $_POST['programname'];
	$progshortname = $_POST['programshortname'];
	$deptID = $_POST['deptID'];

	$result = mysqli_query($conn, "UPDATE programs SET ProgramName = '$progname', ProgramShortName ='$progshortname', deptID ='$deptID' WHERE id = '$get_id'");
	if ($result) {
		echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Program Successfully Updated',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    window.location = 'program.php';
                });
            });
        </script>";
	} else {
		die(mysqli_error($conn));
	}
}
?>

<body>

	<?php include('includes/navbar.php') ?>
	<?php include('includes/right_sidebar.php') ?>
	<?php include('includes/left_sidebar.php') ?>
	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Program List</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Program</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<br>
							<h2 class="mb-30 h4">Edit Program</h2>
							<section>
								<?php
								$query = mysqli_query($conn, "SELECT p.*, d.DepartmentName 
									FROM programs p 
									JOIN departments d ON p.deptID = d.id 
									WHERE p.id = '$get_id'") or die(mysqli_error($conn));

								// Check if the query returned any results
								if (mysqli_num_rows($query) > 0) {
									$row = mysqli_fetch_assoc($query);
									// Access the DepartmentName from the result set
									$departmentName = $row['DepartmentName'];
									// You can use $departmentName as needed
								}
								?>

								<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Program Name</label>
												<input name="programname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['ProgramName']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Program Abbreviation</label>
												<input name="programshortname" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase" value="<?php echo $row['ProgramShortName']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">

											<div class="form-group">
												<label>Department</label>
												<select class="custom-select form-control" id="deptID" name="deptID">
													<?php
													$departmentQuery = mysqli_query($conn, "SELECT * FROM departments") or die(mysqli_error($conn));
													while ($deptRow = mysqli_fetch_assoc($departmentQuery)) {
														$selected = ($deptRow['id'] == $row['deptID']) ? 'selected' : '';

														echo "<option value='" . $deptRow['id'] . "' $selected>" . $deptRow['DepartmentName'] . "</option>";
													}
													?>
												</select>

											</div>
										</div>
									</div>
									<div class="col-sm-12 text-right">
										<div class="dropdown">
											<a href="program.php" class="btn btn-secondary" role="button">CANCEL</a>
											<input class="btn btn-primary" type="submit" value="UPDATE" name="edit" id="edit">
										</div>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
						<div class="card-box pd-30 pt-10 height-100-p">
							<br>
							<h2 class="mb-30 h4">Program List</h2>
							<div class="pb-20">
								<table class="data-table table stripe hover nowrap">
									<thead>
										<tr>
											<th>SR NO.</th>
											<th class="table-plus">PROGRAM</th>
											<th>ABBREVIATION</th>
											<th>DEPARTMENT</th>


										</tr>
									</thead>
									<tbody>

										<?php
										$sql = "SELECT p.ProgramName, p.ProgramShortName, p.id, d.DepartmentName 
												FROM programs p 
												JOIN departments d ON p.deptID = d.id";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;

										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>

												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($result->ProgramName); ?></td>
													<td><?php echo htmlentities($result->ProgramShortName); ?></td>
													<td><?php echo htmlentities($result->DepartmentName); ?></td>

												</tr>

										<?php
												$cnt++;
											}
										}
										?>


									</tbody>
								</table>
							</div>
						</div>
					</div>
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

</html>