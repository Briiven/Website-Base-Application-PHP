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

if (isset($_POST['update_staff'])) {
    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $sex = $_POST['sex'];
    $phonenumber = $_POST['phonenumber'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // Initialize the signaturePath variable
    $signaturePath = '';

    // Check if the signature file input has data
    if (isset($_FILES['signatureFile']) && $_FILES['signatureFile']['error'] == UPLOAD_ERR_OK) {
        $uploadFolder = 'uploads/';

        // Get the original filename
        $originalFileName = $_FILES['signatureFile']['name'];

        // Generate a unique identifier
        $uniqueIdentifier = uniqid();

        // Extract the file extension
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Create a unique filename by combining the original filename, unique identifier, and file extension
        $uniqueFileName = $uniqueIdentifier . '_' . $originalFileName;

        // Move uploaded files to the 'uploads' folder with the unique filename
        $signaturePath = $uniqueFileName;
        move_uploaded_file($_FILES['signatureFile']['tmp_name'], $uploadFolder . $signaturePath);
    } else {
        // If no new file is uploaded, keep the existing signature path
        $result = mysqli_query($conn, "SELECT signature FROM staff WHERE staffID = '$get_id'");
        if ($row = mysqli_fetch_assoc($result)) {
            $signaturePath = $row['signature'];
        }
    }

    // Update staff details
    $result = mysqli_query($conn, "UPDATE staff SET 
            firstName = '$fname', 
            middleName = '$mname', 
            lastName = '$lname', 
            sex = '$sex', 
            department = '$department', 
            program = '$program', 
            address = '$address', 
            phoneNumber = '$phonenumber', 
            role = '$role', 
            signature = '$signaturePath' 
            WHERE staffID = '$get_id'");
    if ($result) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Staff Updated Successfully',
                    showConfirmButton: false,
					timer: 1500
                }).then(function() {
                    document.location = 'staff.php';
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

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>App4Grad</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff Edit</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Edit Staff</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="" enctype="multipart/form-data">
							<section>
								<?php
								$query = mysqli_query($conn, "select * from staff where staffID = '$get_id' ") or die(mysqli_error($conn));
								$row = mysqli_fetch_array($query);
								?>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Name </label></strong>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['firstName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Last Name </label></strong>
											<input name="lastname" type="text" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['lastName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Middle Name </label></strong>
											<input name="middlename" type="text" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['middleName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Sex </label></strong>
											<select name="sex" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $row['sex']; ?>"><?php echo $row['sex']; ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Phone Number </label></strong>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['phoneNumber']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Address </label></strong>
											<input name="address" type="text" placeholder="House No./Street/Barangay/Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['address']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Department</label></strong>

											<select name="department" id="department" class="custom-select form-control" autocomplete="off">
												<?php $query = mysqli_query($conn, "select * from staff LEFT JOIN departments ON staff.department = departments.DepartmentShortName where staffID = '$get_id'") or die(mysqli_error($conn));
												$row = mysqli_fetch_array($query);
												?>
												<option value="<?php echo $row['DepartmentShortName']; ?>"><?php echo $row['DepartmentName']; ?></option>
												<?php
												$query = mysqli_query($conn, "SELECT * FROM departments");
												while ($row = mysqli_fetch_array($query)) {
												?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['DepartmentName']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Program</label></strong>
											<select name="program" id="program" class="custom-select form-control" autocomplete="off">
												<?php $query = mysqli_query($conn, "select * from staff LEFT JOIN programs ON staff.program = programs.ProgramShortName where staffID = '$get_id'") or die(mysqli_error($conn));
												$row = mysqli_fetch_array($query);
												?>
												<option value="<?php echo $row['ProgramShortName']; ?>"><?php echo $row['ProgramName']; ?></option>
												<?php
												$query = mysqli_query($conn, "select * from programs");
												while ($row = mysqli_fetch_array($query)) {
												?>
													<option value="<?php echo $row['ProgramShortName']; ?>"><?php echo $row['ProgramName']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<?php
									$query = mysqli_query($conn, "select * from staff where staffID = '$get_id' ") or die(mysqli_error($conn));
									$new_row = mysqli_fetch_array($query);
									?>

									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>User Role </label></strong>
											<select name="role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $new_row['role']; ?>"><?php echo $new_row['role']; ?></option>
												<option value="College Registrar">College Registrar</option>
												<option value="Registration Adviser">Registration Adviser</option>
												<option value="Department Head">Department Head</option>
												<option value="College Dean">College Dean</option>
											</select>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<strong><label>Signature *</label></strong>
										<div class="custom-file">
											<input name="signatureFile" id="signatureFile" type="file" class="custom-file-input" accept=".png" onchange="validateAndDisplayFileName('signatureFile', 'signatureLabel')">
											<label class="custom-file-label overflow-hidden" for="signatureFile" id="signatureLabel">Choose png file no background</label>
										</div>
									</div>
									<style>
										.overflow-hidden {
											overflow: hidden;
											white-space: nowrap;
											text-overflow: ellipsis;
										}

										.label {
											font-weight: bold;
										}
									</style>
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-success" name="update_staff" id="update_staff" data-toggle="modal">Update&nbsp;College&nbsp;Staff</button>
											</div>
										</div>
									</div>
								</div>
					</div>
					</section>
					</form>
				</div>
			</div>

		</div>
		<?php include('includes/footer.php'); ?>
	</div>
	</div>
	<script>
		document.getElementById("department").addEventListener("change", function() {
			var department = this.value;
			var programs = document.getElementById("program").getElementsByTagName("option");

			// Hide all programs
			for (var i = 0; i < programs.length; i++) {
				programs[i].style.display = "none";
			}

			// Show programs for the selected department
			var departmentPrograms = document.getElementsByClassName(department);
			for (var j = 0; j < departmentPrograms.length; j++) {
				departmentPrograms[j].style.display = "block";
			}
		});
	</script>

	<script>
		function toTitleCase(element) {
			let words = element.value.toLowerCase().split(' ');
			for (let i = 0; i < words.length; i++) {
				words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
			}
			element.value = words.join(' ');
		}
	</script>

	<!-- js -->
	<?php include('includes/scripts.php') ?>
</body>

</html>