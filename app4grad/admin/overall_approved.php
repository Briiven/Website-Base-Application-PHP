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
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Approved Applications</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20 d-flex justify-content-between align-items-center">
                    <h2 class="text-blue h4">APPROVED APPLICATIONS</h2>
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
                                        $selected = (isset($_GET['filterDuration']) && $_GET['filterDuration'] == $durationRow['id']) || (!isset($_GET['filterDuration']) && $session_duration_id == $durationRow['id']) ? 'selected' : '';
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
                                <th>
                                    <input type="checkbox" id="selectAllCheckbox">
                                </th>
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
                            $RAstatus = 1;
                            $CRstatus = 1;
                            $DHstatus = 1;
                            $CDstatus = 1;
                            
                            $filterProgram = isset($_GET['filterProgram']) ? $_GET['filterProgram'] : '';
                            $filterAppType = isset($_GET['filterAppType']) ? $_GET['filterAppType'] : '';
                            $filterDuration = isset($_GET['filterDuration']) ? $_GET['filterDuration'] : $session_duration_id;

                            $sql = "SELECT application.id as lid, applicants.firstName, applicants.lastName, applicants.location, applicants.appID, applicants.program, application.appType, application.appDate, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus 
                                    FROM application 
                                    JOIN applicants ON application.appID = applicants.appID 
                                    WHERE durationID = '$filterDuration'
                                    AND application.RAstatus = $RAstatus 
                                    AND application.CRstatus = $CRstatus 
                                    AND application.DHstatus = $DHstatus
                                    AND application.CDstatus = $CDstatus";

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
                                    <td><input type="checkbox" name="selectedRows[]" value="<?php echo $row['appID']; ?>"></td>
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
                                            <form method="GET" action="pdf.php" class="mx-1" style="display:inline;" onsubmit="return logLid(<?php echo $row['appID']; ?>);">
                                                <input type="hidden" name="appid" value="<?php echo $row['appID']; ?>">
                                                <button type="submit" title="Download" class="btn btn-success custom-download-btn">
                                                    Download <i class="fa fa-download"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php $cnt++;
                            } ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-success" id="downloadSelectedBtn" style="display: none;">Download Selected <i class="fa fa-download"></i></button>
                    </div>
                </div>
            </div>

            <script>
            document.getElementById('selectAllCheckbox').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('input[name="selectedRows[]"]');
                const isChecked = this.checked;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                toggleDownloadButton();
            });

            document.querySelectorAll('input[name="selectedRows[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', toggleDownloadButton);
            });

            function toggleDownloadButton() {
                const anyChecked = document.querySelectorAll('input[name="selectedRows[]"]:checked').length > 0;
                document.getElementById('downloadSelectedBtn').style.display = anyChecked ? 'block' : 'none';
            }
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var selectAllCheckbox = document.getElementById("selectAllCheckbox");
                    var checkboxes = document.querySelectorAll('input[name="selectedRows[]"]');
                    var downloadSelectedBtn = document.getElementById("downloadSelectedBtn");

                    selectAllCheckbox.addEventListener("change", function() {
                        checkboxes.forEach(function(checkbox) {
                            checkbox.checked = selectAllCheckbox.checked;
                        });
                        toggleDownloadButtonVisibility();
                    });

                    // Event listener for individual checkboxes to toggle "Select All" checkbox
                    checkboxes.forEach(function(checkbox) {
                        checkbox.addEventListener("change", function() {
                            var allChecked = true;
                            var selectAllChecked = selectAllCheckbox.checked;
                            checkboxes.forEach(function(cb) {
                                if (!cb.checked) {
                                    allChecked = false;
                                }
                            });
                            if (selectAllChecked && !this.checked) { // Uncheck "Select All" if an individual checkbox is unchecked
                                selectAllCheckbox.checked = false;
                            }
                            if (selectAllCheckbox.checked || allChecked) {
                                downloadSelectedBtn.style.display = "inline-block";
                            } else {
                                downloadSelectedBtn.style.display = "none";
                            }

                            // Check "Select All" if all individual checkboxes are checked
                            if (allChecked) {
                                selectAllCheckbox.checked = true;
                            }
                        });
                    });




                    // Event listener for the download selected button
                    downloadSelectedBtn.addEventListener("click", function() {
                        var selectedRows = document.querySelectorAll('input[name="selectedRows[]"]:checked');
                        var selectedAppIds = [];
                        selectedRows.forEach(function(row) {
                            selectedAppIds.push(row.value);
                        });
                        console.log("Selected App IDs:", selectedAppIds);

                        // Redirect to the pdf-print.php page with selected appids as parameters
                        window.location.href = "pdf-all.php?selectedAppIds=" + selectedAppIds.join(",");
                    });

                    function toggleDownloadButtonVisibility() {
                        var selectedRows = document.querySelectorAll('input[name="selectedRows[]"]:checked');
                        if (selectedRows.length > 0 || selectAllCheckbox.checked) {
                            downloadSelectedBtn.style.display = "inline-block";
                        } else {
                            downloadSelectedBtn.style.display = "none";
                        }
                    }

                });
            </script>




            <script>
                function logLid(lid) {
                    console.log("LID: " + lid);
                    return true; // Proceed with form submission
                }
            </script>
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