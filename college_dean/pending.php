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
    window.location = 'index.php'; 
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
    window.location = 'index'; 
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

            <div class="card-box mb-30">
                <?php
                $duration_query = mysqli_query($conn, "SELECT isActive FROM duration WHERE id = $session_duration_id AND isActive = 1");
                $is_active = mysqli_num_rows($duration_query) > 0;

                if ($is_active) {
                ?>
                <div class="pd-20 d-flex justify-content-between align-items-center">
                    <h2 class="text-blue h4">PENDING APPLICATIONS</h2>
                    <form method="GET" action="">
                        <div class="form-row align-items-center">
                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-4">
                                <label for="filterAppType">Filter by Application Type</label>
                                <select name="filterAppType" id="filterAppType" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="Ordinary Application" <?php echo isset($_GET['filterAppType']) && $_GET['filterAppType'] == 'Ordinary Application' ? 'selected' : ''; ?>>Ordinary Application</option>
                                    <option value="For Latin Honors" <?php echo isset($_GET['filterAppType']) && $_GET['filterAppType'] == 'For Latin Honors' ? 'selected' : ''; ?>>For Latin Honors</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
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
                                <th>APPLIED DATE</th>
                                <th>APPLICATION TYPE</th>
                                <th>COLLEGE DEAN</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Initialize filters
                            $filterProgram = isset($_GET['filterProgram']) ? $_GET['filterProgram'] : '';
                            $filterAppType = isset($_GET['filterAppType']) ? $_GET['filterAppType'] : '';

                            $sql = "SELECT application.id as lid, durationID, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.CDstatus
                                    FROM application
                                    JOIN applicants ON application.appID = applicants.appID 
                                    WHERE durationID = $session_duration_id
                                    AND application.DHstatus = $DHstatus";

                            // Apply program filter
                            if (!empty($filterProgram)) {
                                $sql .= " AND applicants.program = '$filterProgram'";
                            }

                            // Apply application type filter
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
                        <p>The confirmation period has ended.</p>
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