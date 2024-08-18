<?php
include('includes/header.php');
include('../includes/session.php');
?>
<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<?php
if (isset($_POST['add_duration'])) {
    $gradYear = $_POST['gradYear'];
    $academicYear = $_POST['academicYear'];
    $semester = $_POST['semester'];
    $startDate = date("Y-m-d", strtotime($_POST['startDate']));
    $endDate = date("Y-m-d", strtotime($_POST['endDate']));
    $deadline = date("Y-m-d", strtotime($_POST['deadline']));

    $checkSemesterQuery = "SELECT id FROM duration WHERE gradYear = '$gradYear' AND semester = '$semester'";
    $checkSemesterResult = $conn->query($checkSemesterQuery);

    if ($checkSemesterResult->num_rows > 0) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Semester already exists for the selected graduation year.',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(function () {
                        window.location = 'duration.php';
                    });
                });
              </script>";
    } else {
        $checkOverlapQuery = "SELECT * FROM duration 
                              WHERE ('$startDate' BETWEEN startDate AND endDate 
                                     OR '$endDate' BETWEEN startDate AND endDate 
                                     OR startDate BETWEEN '$startDate' AND '$endDate' 
                                     OR endDate BETWEEN '$startDate' AND '$endDate')";
        
        $checkOverlapResult = $conn->query($checkOverlapQuery);

        if ($checkOverlapResult->num_rows > 0) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Duration overlaps with an existing record. Please choose different dates.',
                            showConfirmButton: false,
                            timer: 2500
                        }).then(function () {
                            window.location = 'duration.php';
                        });
                    });
                  </script>";
        } else {
            $insert_query = "INSERT INTO duration (gradYear, schoolYear, semester, startDate, endDate, deadline) 
                            VALUES ('$gradYear', '$academicYear', '$semester', '$startDate', '$endDate', '$deadline')";

            $result = mysqli_query($conn, $insert_query);

            if ($result) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Duration Successfully Added',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                window.location = 'duration.php';
                            });
                        });
                      </script>";
            } else {
                die(mysqli_error($conn));
            }
        }
    }
}

if (isset($_POST['filter'])) {
    $selectedYear = $_POST['year'];
    $selectedSemester = $_POST['semester'];

    $checkQuery = "SELECT id FROM duration WHERE gradYear = '$selectedYear' AND semester = '$selectedSemester'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $_SESSION['duration_id'] = $row['id'];

        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data Filtered Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'duration.php';
                    });
                });
              </script>";
    } else {
        // No match found, keep previous session value
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Year and Semester not found!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'duration.php';
                    });
                });
              </script>";
    }
}

if (isset($_POST['editStatusDropdown'])) {
    $editDurationId = $_POST['durationID'];
    $editStatus = $_POST['editStatusDropdown'];

    $editDurationId = mysqli_real_escape_string($conn, $editDurationId);
    $editStatus = mysqli_real_escape_string($conn, $editStatus);

    if ($editStatus == '1') {
        // Check if there is already a row with isActive = 1
        $checkQuery = "SELECT id FROM duration WHERE isActive = '1' AND id != '$editDurationId'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Another duration is already active.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location = 'duration.php';
                        });
                    });
                  </script>";
            exit;
        }
    }

    $updateQuery = "UPDATE duration SET isActive = '$editStatus' WHERE id = '$editDurationId'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Duration Updated Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'duration.php';
                    });
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error updating duration: " . $conn->error . "',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'duration.php';
                    });
                });
              </script>";
    }
}



?>



<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/right_sidebar.php'); ?>
    <?php include('includes/left_sidebar.php'); ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Add Duration</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Duration Period</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-md-6 col-sm-12 mb-30">
                    <div class="card-box pd-30 pt-10 height-100-p">
                        <h2 class="mb-30 mt-3 h4">Filter Applications</h2>
                        
                        <form  method="post" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="yearDropdown">Year:</label>
                                        <select class="form-control" id="yearDropdown" name="year">
                                            <option value="">Select Year</option>
                                            <?php
                                            $yearQuery = "SELECT DISTINCT gradYear FROM duration";
                                            $yearResult = $conn->query($yearQuery);

                                            if ($yearResult->num_rows > 0) {
                                                while ($row = $yearResult->fetch_assoc()) {
                                                    echo '<option value="' . $row['gradYear'] . '">' . $row['gradYear'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="semesterDropdown">Semester:</label>
                                        <select class="form-control" id="semesterDropdown" name="semester">
                                            <option value="">Select Semester</option>
                                            <option value="1st Semester">1st Semester</option>
                                            <option value="2nd Semester">2nd Semester</option>
                                            <option value="3rd Semester">3rd Semester</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-12 mb-30">
                    <div class="card-box pd-30 pt-10 height-100-p">
                        <h2 class="mb-30 mt-3 h4">Add Duration</h2>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Graduation Year</strong></label>
                                        <input name="gradYear" type="text" class="form-control" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Academic Year</strong></label>
                                        <input name="academicYear" type="text" class="form-control" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Semester</strong></label>
                                        <select name="semester" class="form-control" required="true">
                                            <option value="">Select Semester</option>
                                            <option value="1st Semester">1st Semester</option>
                                            <option value="2nd Semester">2nd Semester</option>
                                            <option value="3rd Semester">3rd Semester</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Start Date</strong></label>
                                        <input name="startDate" type="text" class="form-control date-picker" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Application Deadline</strong></label>
                                        <input name="deadline" type="text" class="form-control date-picker" required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>End Date</strong></label>
                                        <input name="endDate" type="text" class="form-control date-picker" required="true">
                                    </div>
                                </div>

                                <div class="col-md-12 text-right">
                                    <div class="dropdown">
                                        <button type="submit" class="btn btn-success" name="add_duration">Add Duration</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7 col-md-6 col-sm-12 mb-30">
                    <div class="card-box pd-30 pt-10 height-100-p">
                        <h2 class="mb-30 mt-3 h4">List of Durations</h2>
                        <div class="table-responsive">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Status</th> 
                                        <th>Graduation Year</th>
                                        <th>Academic Year</th>
                                        <th>Semester</th>
                                        <th>Start Date</th>
                                        <th>Application Deadline</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * FROM duration") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        $status = $row['isActive'] == 1 ? 'Open' : 'Close';
                                        echo "<td>{$status}</td>";
                                        echo "<td>{$row['gradYear']}</td>";
                                        echo "<td>{$row['schoolYear']}</td>";
                                        echo "<td>{$row['semester']}</td>";
                                        echo "<td>{$row['startDate']}</td>";
                                        echo "<td>{$row['deadline']}</td>";
                                        echo "<td>{$row['endDate']}</td>";
                                        echo "<td>";
                                        echo '<a href="#" onclick="editDuration(' . $row['id'] . ', ' . $row['isActive'] . ')" style="color: #0e49b5;">Edit Status</a>';
                                        echo "</td>";
                                        echo "</tr>";
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
<!-- Edit Duration Modal -->
<div class="modal fade" id="editDurationModal" tabindex="-1" role="dialog" aria-labelledby="editDurationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDurationModalLabel">Edit Duration Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editDurationForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="durationID" name="durationID"> 
                        <div class="form-group">
                            <label for="editStatusDropdown">Status</label>
                            <select class="form-control" id="editStatusDropdown" name="editStatusDropdown">
                                <option value="1">Open</option>
                                <option value="0">Close</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
function editDuration(durationId, isActive) {
    $('#durationID').val(durationId);
    $('#editStatusDropdown').val(isActive);  
    $('#editDurationModal').modal('show');
}
</script>

<!-- js -->
<?php include('includes/scripts.php'); ?>
</body>
</html>
