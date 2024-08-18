<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>
<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php
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
                    text: 'Please upload an image to update'
                });
            });
        </script>";
    }

    $result = mysqli_query($conn, "UPDATE staff SET location='$location' WHERE staffID='$session_id'") or die(mysqli_error($conn));
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
        die(mysqli_error($conn));
    }
}

if (isset($_POST['new_password'])) {
    $staffID = $session_id;
    $password = md5($_POST['password']);

    $result = mysqli_query($conn, "UPDATE staff SET password='$password' WHERE staffID='$session_id'") or die(mysqli_error($conn));

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
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4>Profile</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">

							<?php $query = mysqli_query($conn, "select * from staff LEFT JOIN departments ON staff.department = departments.DepartmentShortName where staffID = '$session_id'") or die(mysqli_error($conn));
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
							<p class="text-center text-muted font-14"><?php echo $row['DepartmentName']; ?></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-blue">Contact Information</h5>
								<ul>
									<li>
										<span>Email Address:</span>
										<?php echo $row['email']; ?>
									</li>
									<li>
										<span>Phone Number:</span>
										<?php echo $row['phoneNumber']; ?>
									</li>
									<li>
										<span>Role:</span>
										<?php echo $row['role']; ?>
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
													<input name="password" id="newPassword" class="form-control" type="password" placeholder="********" required="true" autocomplete="off" style="padding-right: 40px; z-index: 1;">
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
													<input name="password" id="confirmPassword" class="form-control" type="password" placeholder="********" required="true" autocomplete="off" style="padding-right: 40px; z-index: 1;">
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
										input.classList.remove('showError');
										input.classList.remove('showSuccess');
										input.classList.remove('is-invalid');
										input.classList.remove('is-valid');
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
					</div>

				</div>
				<?php include('includes/footer.php'); ?>
			</div>
		</div>
		<!-- js -->
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
			function togglePasswordVisibility() {
				var passwordInput = document.getElementById("newPassword");
				var passwordToggleIcon = document.getElementById("passwordToggleIcon");
				if (passwordInput.type === "password") {
					passwordInput.type = "text";
					passwordToggleIcon.classList.remove("fa-eye-slash");
					passwordToggleIcon.classList.add("fa-eye");
				} else {
					passwordInput.type = "password";
					passwordToggleIcon.classList.remove("fa-eye");
					passwordToggleIcon.classList.add("fa-eye-slash");
				}
			}

			function toggleConfirmPasswordVisibility() {
				var confirmPasswordInput = document.getElementById("confirmPassword");
				var confirmPasswordToggleIcon = document.getElementById("confirmPasswordToggleIcon");
				if (confirmPasswordInput.type === "password") {
					confirmPasswordInput.type = "text";
					confirmPasswordToggleIcon.classList.remove("fa-eye-slash");
					confirmPasswordToggleIcon.classList.add("fa-eye");
				} else {
					confirmPasswordInput.type = "password";
					confirmPasswordToggleIcon.classList.remove("fa-eye");
					confirmPasswordToggleIcon.classList.add("fa-eye-slash");
				}
			}
		</script>
</body>

</html>