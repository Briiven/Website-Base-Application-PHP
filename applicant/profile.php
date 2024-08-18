<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<head>
	<!-- SweetAlert CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
	<!-- SweetAlert JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<!-- Datepicker CSS -->
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<?php
if (isset($_POST['new_update'])) {
	$appid = $session_id;
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$studnum = $_POST['studnum'];
	$birthdate = $_POST['birthdate'];
	$birthplace = $_POST['birthplace'];
	$age = $_POST['age'];
	$program = $_POST['program'];
	$section = $_POST['section'];
	$address = $_POST['address'];
	$sex = $_POST['sex'];
	$phonenumber = $_POST['phonenumber'];

	$result = mysqli_query($conn, "update applicants set firstName='$firstname', middleName='$middlename', lastName='$lastname', email='$email', studNumber='$studnum', birthDate='$birthdate', age='$age', birthPlace='$birthplace', sex='$sex', program='$program', section='$section', address='$address', phoneNumber='$phonenumber' where appID='$session_id'") or die(mysqli_error($conn));

	if ($result) {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your profile is successfully updated',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	} else {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update profile',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	}
}

if (isset($_POST['new_password'])) {
	$appid = $session_id;
	$password = md5($_POST['password']);

	// Assuming $conn is your database connection variable
	$result = mysqli_query($conn, "UPDATE applicants SET password='$password' WHERE appID='$session_id'") or die(mysqli_error($conn));

	if ($result) {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password changed successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	} else {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to change password',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	}
}

if (isset($_POST["update_image"])) {
	$image = $_FILES['image']['name'];

	if (!empty($image)) {
		move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
		$location = $image;
	} else {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Choose Profile Picture',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	}

	$result = mysqli_query($conn, "update applicants set location='$location' where appID='$session_id'") or die(mysqli_error($conn));

	if ($result) {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Profile Picture Updated',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	} else {
		echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update Profile Picture',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = 'profile.php';
                    });
                });
              </script>";
	}
}
?>


<body>

	<?php include('includes/navbar.php') ?>
	<?php include('includes/right_sidebar.php') ?>
	<div class="mobile-menu-overlay"></div>
	<br>
	<div class="container1 mb-30" style="width: 95%; margin: 0 auto;">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4><strong>PROFILE</strong></h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">

							<?php $query = mysqli_query($conn, "select * from applicants LEFT JOIN programs ON applicants.program = programs.ProgramShortName where appID = '$session_id'") or die(mysqli_error($conn));
							$row = mysqli_fetch_array($query);
							?>

							<div class="profile-photo">
								<a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
								<img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="" class="avatar-photo">
								<form method="post" enctype="multipart/form-data">
									<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="weight-500 col-md-12 pd-5">
													<div class="form-group">
														<div class="custom-file">
															<input name="image" id="file" type="file" class="custom-file-input" accept="image/*" onchange="validateImage('file')">
															<label class="custom-file-label" for="file" id="selector">Choose file</label>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" name="update_image" value="Update" class="btn btn-success">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<h5 class="text-center h5 mb-0"><?php echo $row['firstName'] . " " . $row['lastName']; ?></h5>
							<p class="text-center text-muted font-14"><?php echo $row['ProgramName']; ?> <?php echo $row['section']; ?></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-green">Contact Information</h5>
								<ul>
									<li>
										<span>Email address:</span>
										<?php echo $row['email']; ?>
									</li>
									<li>
										<span>Phone Number:</span>
										<?php echo $row['phoneNumber']; ?>
									</li>
									<li>
										<span>Address:</span>
										<?php echo $row['address']; ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Settings</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#password" role="tab">Change Password</a>
										</li>
									</ul>
									<div class="tab-content">

										<!-- Settings Tab -->
										<div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
											<div class="profile-setting">
												<form method="POST" enctype="multipart/form-data">
													<div class="profile-edit-list row">
														<div class="col-md-12">
															<h4 class="text-green h5 mb-20">Edit Your Profile</h4>
														</div>

														<?php
														$query = mysqli_query($conn, "select * from applicants where appID = '$session_id' ") or die(mysqli_error($conn));
														$row = mysqli_fetch_array($query);
														?>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>First Name</label>
																<input name="firstname" class="form-control form-control-lg" type="text" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['firstName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Middle Name</label>
																<input name="middlename" class="form-control form-control-lg" type="text" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['middleName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Last Name</label>
																<input name="lastname" class="form-control form-control-lg" type="text" placeholder="" onblur="toTitleCase(this)" autocomplete="off" value="<?php echo $row['lastName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Email address</label>
																<input name="email" class="form-control form-control-lg" type="text" placeholder="" autocomplete="off" value="<?php echo $row['email']; ?>" readonly>
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Student Number</label>
																<input name="studnum" class="form-control form-control-lg" type="text" placeholder="" autocomplete="off" value="<?php echo $row['studNumber']; ?>" readonly>
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Phone Number</label>
																<input name="phonenumber" class="form-control form-control-lg" type="text" placeholder="" autocomplete="off" value="<?php echo $row['phoneNumber']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-4">
															<div class="form-group">
																<label>Date Of Birth</label>
																<input name="birthdate" id="birthdate" type="text" class="form-control" autocomplete="off" value="<?php echo $row['birthDate']; ?>" readonly>
															</div>
														</div>
														<div class="weight-500 col-md-3">
															<div class="form-group">
																<label>Age</label>
																<input name="age" id="age" class="form-control" type="number" min="18" max="99" readonly="true" autocomplete="off" value="<?php echo $row['age']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-5">
															<div class="form-group">
																<label>Birthplace</label>
																<input name="birthplace" id="birthplace " type="text" placeholder="Municipality/Province" class="form-control" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['birthPlace']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-3">
															<div class="form-group">
																<label>Sex</label>
																<select name="sex" id="sex" class="custom-select form-control" autocomplete="off">
																	<option value="<?php echo $row['sex']; ?>"><?php echo $row['sex']; ?></option>
																	<!-- Assuming the value is already set and is not supposed to change -->
																</select>
																<!-- Add a hidden input to send the sex value with the form -->
																<input type="hidden" name="sex" value="<?php echo $row['sex']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Program</label>
																<select name="program" class="custom-select form-control" autocomplete="off">
																	<?php $query = mysqli_query($conn, "select * from applicants LEFT JOIN programs ON applicants.program = programs.ProgramShortName where appID = '$session_id'") or die(mysqli_error($conn));
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
														$query = mysqli_query($conn, "select * from applicants where appID = '$session_id' ") or die(mysqli_error($conn));
														$row = mysqli_fetch_array($query);
														?>
														<div class="weight-500 col-md-3">
															<div class="form-group">
																<label>Section</label>
																<select name="section" class="custom-select form-control" autocomplete="off">
																	<option value="<?php echo $row['section']; ?>"><?php echo $row['section']; ?></option>
																	<option value="Irregular">Irregular</option>
																	<option value="4-1">4-1</option>
																	<option value="4-2">4-2</option>
																	<option value="4-3">4-3</option>
																	<option value="4-4">4-4</option>
																	<option value="4-5">4-5</option>
																	<option value="5-1">5-1</option>
																	<option value="5-2">5-2</option>
																	<option value="5-3">5-3</option>
																	<option value="5-4">5-4</option>
																	<option value="5-5">5-5</option>
																	<option value="6-1">6-1</option>
																	<option value="6-2">6-2</option>
																	<option value="6-3">6-3</option>
																	<option value="6-4">6-4</option>
																	<option value="6-5">6-5</option>
																</select>
															</div>
														</div>
														<div class="weight-500 col-md-12">
															<div class="form-group">
																<label>Address</label>
																<input name="address" class="form-control form-control-lg" type="text" placeholder="" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['address']; ?>">
															</div>
														</div>

														<div class="weight-500 col-md-12">
															<div class="form-group">
																<label></label>
																<div class="modal-footer justify-content-center">
																	<button class="btn btn-success" name="new_update" id="new_update" data-toggle="modal">Save&nbsp;&&nbsp;Update</button>
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- Setting Tab End -->
										<!-- Change Password Tab -->
										<div class="tab-pane fade height-100-p" id="password" role="tabpanel">
											<div class="profile-setting">
												<form method="POST" enctype="multipart/form-data" onsubmit="return validatePasswords();">
													<div class="profile-edit-list row">
														<div class="col-md-12">
															<h4 class="text-green h5 mb-20">Change Password</h4>
														</div>
														<div class="weight-500 col-md-12">
															<div class="form-group">
																<label for="newPassword">New Password</label>
																<div class="input-group" style="position: relative;">
																	<input name="password" id="newPassword" class="form-control" type="password" placeholder="********" autocomplete="off" style="padding-right: 40px; z-index: 1;">
																	<div class="input-group-append">
																		<span class="input-group-text">
																			<i class="fa fa-eye" id="passwordToggleIcon" onclick="togglePasswordVisibility()"></i>
																		</span>
																	</div>
																</div>
															</div>
														</div>
														<div class="weight-500 col-md-12">
															<div class="form-group">
																<label for="confirmPassword">Confirm Password</label>
																<div class="input-group" style="position: relative;">
																	<input name="password" id="confirmPassword" class="form-control" type="password" placeholder="********" autocomplete="off" style="padding-right: 40px; z-index: 1;">
																	<div class="input-group-append">
																		<span class="input-group-text">
																			<i class="fa fa-eye" id="confirmPasswordToggleIcon" onclick="toggleConfirmPasswordVisibility()"></i>
																		</span>
																	</div>
																</div>
															</div>
														</div>
														<div class="weight-500 col-md-12">
															<div class="form-group">
																<div class="modal-footer justify-content-center">
																	<button class="btn btn-success" type="submit" name="new_password" id="new_password">Save New Password</button>
																</div>
															</div>
														</div>
													</div>
												</form>
												<script>
													function showError(input, message) {
														input.classList.add('is-invalid');
														input.classList.remove('is-valid');
														var errorElement = input.parentElement.querySelector('.invalid-feedback');
														if (!errorElement) {
															errorElement = document.createElement('div');
															errorElement.classList.add('invalid-feedback');
															input.parentElement.appendChild(errorElement);
														}
														errorElement.innerText = message;
													}

													function showSuccess(input) {
														input.classList.add('is-valid');
														input.classList.remove('is-invalid');
														var errorElement = input.parentElement.querySelector('.invalid-feedback');
														if (errorElement) {
															errorElement.innerText = '';
														}
													}

													function clearMessages(input) {
														// Clear error or success messages
														input.classList.remove('showError');
														input.classList.remove('showSuccess');
														input.classList.remove('is-invalid'); // Also removing 'is-invalid' class
														input.classList.remove('is-valid'); // Also removing 'is-valid' class
													}

													function validatePasswords() {
														const newPasswordInput = document.getElementById('newPassword');
														const confirmPasswordInput = document.getElementById('confirmPassword');
														return checkInputs(newPasswordInput, confirmPasswordInput);
													}

													function togglePasswordVisibility() {
														const passwordInput = document.getElementById('newPassword');
														const passwordIcon = document.getElementById('passwordToggleIcon');
														if (passwordInput.type === 'password') {
															passwordInput.type = 'text';
															passwordIcon.classList.remove('fa-eye-slash');
															passwordIcon.classList.add('fa-eye');
														} else {
															passwordInput.type = 'password';
															passwordIcon.classList.remove('fa-eye');
															passwordIcon.classList.add('fa-eye-slash');
														}
													}

													function toggleConfirmPasswordVisibility() {
														const confirmPasswordInput = document.getElementById('confirmPassword');
														const confirmPasswordIcon = document.getElementById('confirmPasswordToggleIcon');
														if (confirmPasswordInput.type === 'password') {
															confirmPasswordInput.type = 'text';
															confirmPasswordIcon.classList.remove('fa-eye-slash');
															confirmPasswordIcon.classList.add('fa-eye');
														} else {
															confirmPasswordInput.type = 'password';
															confirmPasswordIcon.classList.remove('fa-eye');
															confirmPasswordIcon.classList.add('fa-eye-slash');
														}
													}

													function checkInputs() {
														const newPasswordInput = document.getElementById('newPassword');
														const confirmPasswordInput = document.getElementById('confirmPassword');
														const saveButton = document.getElementById('new_password');
														const newPassword = newPasswordInput.value.trim();
														const confirmPassword = confirmPasswordInput.value.trim();
														const passwordCriteria = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

														let isValid = true;

														if (newPassword !== '' && !passwordCriteria.test(newPassword)) {
															showError(newPasswordInput, 'Password must be at least 8 characters long and include both letters and numbers.');
															isValid = false;
														} else {
															showSuccess(newPasswordInput);
														}

														if (confirmPassword === '' && newPassword !== '') {
															showError(confirmPasswordInput, 'Confirm Password cannot be empty if New Password is set.');
															isValid = false;
														} else if (newPassword !== confirmPassword) {
															showError(confirmPasswordInput, 'Confirm Password must match the New Password.');
															isValid = false;
														} else {
															showSuccess(confirmPasswordInput);
														}

														if (newPassword === '') {
															clearMessages(newPasswordInput);
															clearMessages(confirmPasswordInput);
														}

														if (newPassword === '' && confirmPassword === '') {
															saveButton.disabled = true;
														} else {
															saveButton.disabled = !isValid;
														}

														return isValid;
													}





													document.addEventListener('DOMContentLoaded', () => {
														document.getElementById('newPassword').addEventListener('input', checkInputs);
														document.getElementById('confirmPassword').addEventListener('input', checkInputs);
														document.getElementById('new_password').disabled = true;
													});
												</script>

											</div>
										</div>
										<!-- Change Password Tab End -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include('includes/footer.php'); ?>

		</div>
	</div>
	<?php include('includes/scripts.php') ?>
	<script type="text/javascript">
		var loader = function(e) {
			let file = e.target.files;

			let show = "<span>Selected file : </span>" + file[0].name;
			let output = document.getElementById("selector");
			output.innerHTML = show;
			output.classList.add("active");
		};

		let fileInput = document.getElementById("file");
		fileInput.addEventListener("change", loader);
	</script>
	<script type="text/javascript">
		function validateImage(id) {
			var formData = new FormData();
			var file = document.getElementById(id).files[0];
			formData.append("Filedata", file);
			var t = file.type.split('/').pop().toLowerCase();
			if (t != "jpeg" && t != "jpg" && t != "png") {
				alert('Please select a valid image file');
				document.getElementById(id).value = '';
				return false;
			}
			if (file.size > 1050000) {
				alert('Max Upload size is 1MB only');
				document.getElementById(id).value = '';
				return false;
			}

			return true;
		}
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
</body>

</html>