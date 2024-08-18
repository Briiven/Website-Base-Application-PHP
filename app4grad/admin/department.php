<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to delete this Department?',
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
                    document.location = 'department.php?confirm_delete=$delete';
                }
            });
        });
    </script>";
}

if (isset($_GET['confirm_delete'])) {
    $delete = $_GET['confirm_delete'];
    $sql = "DELETE FROM departments WHERE id = $delete";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Show success message after deletion
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Department deleted Successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    document.location = 'department.php';
                });
            });
        </script>";
    }
}
?>

<?php
if (isset($_POST['add'])) {
    $deptname = $_POST['departmentname'];
    $deptshortname = $_POST['departmentshortname'];

    $query = mysqli_query($conn, "SELECT * FROM departments WHERE DepartmentName = '$deptname'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Department Already Exists'
                });
            });
        </script>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO departments (DepartmentName, DepartmentShortName) VALUES ('$deptname', '$deptshortname')") or die(mysqli_error($conn));

        if ($query) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Department Added Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'department.php';
                    });
                });
            </script>";
        }
    }
}
?>	

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Department List</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Department Module</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<br>
								<h2 class="mb-30 h4">New Department</h2>
								<section>
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<strong><label >Department Name</label></strong>
												<input name="departmentname" type="text" class="form-control" required="true" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
											<strong><label>Department Acronym</label></strong>
												<input name="departmentshortname" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>
									
									<div class="col-sm-12 text-right">
										<div class="dropdown">
										   <input class="btn btn-primary" type="submit" value="REGISTER" name="add" id="add">
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<br>
								<h2 class="mb-30 h4">Department List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th>SR NO.</th>
											<th class="table-plus">DEPARTMENT</th>
											<th>DEPARTMENT ACRONYM</th>
											<th class="datatable-nosort">ACTION</th>
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from departments";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												<td> <?php echo htmlentities($cnt);?></td>
	                                            <td><?php echo htmlentities($result->DepartmentName);?></td>
	                                            <td><?php echo htmlentities($result->DepartmentShortName);?></td>
												<td>
													<div class="table-actions">
														<a href="edit_department.php?edit=<?php echo htmlentities($result->id);?>" data-color="#265ed7"><i class="icon-copy fa fa-pencil"></i></a>
														<a href="department.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy fa fa-trash"></i></a>
													</div>
												</td>
											</tr>

											<?php $cnt++;} }?>  

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