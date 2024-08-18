<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
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
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to delete this Application?',
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
                    document.location = 'overall_applications.php?confirm_delete=$delete';
                }
            });
        });
    </script>";
}

if (isset($_GET['confirm_delete'])) {
    $delete = $_GET['confirm_delete'];
    $sql = "DELETE FROM application WHERE id = '$delete'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Show success message after deletion
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Application deleted Successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    document.location = 'overall_applications.php';
                });
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
								<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Rejected Applications</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="text-blue h4">REJECTED APPLICATIONS</h2>
    </div>
    <div class="pd-20">
        <form method="GET" action="">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="filterProgram">Filter by Program</label>
                    <select name="filterProgram" id="filterProgram" class="form-control">
                        <option value="">All Programs</option>
                        <?php
                        $programQuery = mysqli_query($conn, "SELECT DISTINCT programShortName FROM programs") or die(mysqli_error($conn));
                        while ($programRow = mysqli_fetch_assoc($programQuery)) {
                            $selected = isset($_GET['filterProgram']) && $_GET['filterProgram'] == $programRow['programShortName'] ? 'selected' : '';
                            echo "<option value='" . $programRow['programShortName'] . "' $selected>" . $programRow['programShortName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="filterAppType">Filter by Application Type</label>
                    <select name="filterAppType" id="filterAppType" class="form-control">
                        <option value="">All Types</option>
                        <option value="Ordinary Application" <?php echo isset($_GET['filterAppType']) && $_GET['filterAppType'] == 'Ordinary Application' ? 'selected' : ''; ?>>Ordinary Application</option>
                        <option value="For Latin Honors" <?php echo isset($_GET['filterAppType']) && $_GET['filterAppType'] == 'For Latin Honors' ? 'selected' : ''; ?>>For Latin Honors</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="filterDuration">Filter by School Year and Semester</label>
                    <select name="filterDuration" id="filterDuration" class="form-control">
                        <?php
                        $durationQuery = mysqli_query($conn, "SELECT id, CONCAT(schoolYear, ' ', semester) AS duration FROM duration") or die(mysqli_error($conn));
                        while ($durationRow = mysqli_fetch_assoc($durationQuery)) {
                            $selected = isset($_GET['filterDuration']) && $_GET['filterDuration'] == $durationRow['id'] ? 'selected' : ($session_duration_id == $durationRow['id'] ? 'selected' : '');
                            echo "<option value='" . $durationRow['id'] . "' $selected>" . $durationRow['duration'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
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
                    <th>REGISTRATION ADVISER</th>
                    <th>COLLEGE REGISTRAR</th>
                    <th>DEPARTMENT HEAD</th>
                    <th>COLLEGE DEAN</th>
                    <th class="datatable-nosort">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $RAstatus = 2;
                $CRstatus = 2;
                $DHstatus = 2;
                $CDstatus = 2;

                $filterProgram = isset($_GET['filterProgram']) ? $_GET['filterProgram'] : '';
                $filterAppType = isset($_GET['filterAppType']) ? $_GET['filterAppType'] : '';
                $filterDuration = isset($_GET['filterDuration']) ? $_GET['filterDuration'] : $session_duration_id;

                $sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus 
                        FROM application 
                        JOIN applicants ON application.appID = applicants.appID 
                        WHERE durationID = '$filterDuration' 
                        AND (application.RAstatus = $RAstatus 
                        OR application.CRstatus = $CRstatus 
                        OR application.DHstatus = $DHstatus 
                        OR application.CDstatus = $CDstatus)";

                if (!empty($filterProgram)) {
                    $sql .= " AND applicants.program = '$filterProgram'";
                }

                if (!empty($filterAppType)) {
                    $sql .= " AND application.appType = '$filterAppType'";
                }

                $sql .= " ORDER BY lid DESC LIMIT 10";

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
                        <td><?php echo ($row['RAstatus'] == 1) ? '<span style="color: green">Approved</span>' : (($row['RAstatus'] == 2) ? '<span style="color: red">Rejected</span>' : '<span style="color: blue">Pending</span>'); ?></td>
                        <td><?php echo ($row['CRstatus'] == 1) ? '<span style="color: green">Approved</span>' : (($row['CRstatus'] == 2) ? '<span style="color: red">Rejected</span>' : '<span style="color: blue">Pending</span>'); ?></td>
                        <td><?php echo ($row['DHstatus'] == 1) ? '<span style="color: green">Approved</span>' : (($row['DHstatus'] == 2) ? '<span style="color: red">Rejected</span>' : '<span style="color: blue">Pending</span>'); ?></td>
                        <td><?php echo ($row['CDstatus'] == 1) ? '<span style="color: green">Approved</span>' : (($row['CDstatus'] == 2) ? '<span style="color: red">Rejected</span>' : '<span style="color: blue">Pending</span>'); ?></td>
                        <td>
                            <div class="table-actions d-flex justify-content-center">
                                <form method="GET" action="viewonly_application.php" class="mx-1" style="display:inline;">
                                    <input type="hidden" name="appid" value="<?php echo $row['lid']; ?>">
                                    <button type="submit" title="View" class="btn btn-primary custom-view-btn">
                                        View <i class="fa fa-eye"></i>
                                    </button>
                                </form>
                                <form method="GET" action="overall_rejected.php" class="mx-1" style="display:inline;">
                                    <input type="hidden" name="delete" value="<?php echo $row['lid']; ?>">
                                    <button type="submit" title="Delete" class="btn btn-danger custom-delete-btn">
                                        Delete <i class="fa fa-trash"></i>
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