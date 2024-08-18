<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<head>
	<!-- SweetAlert CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
	<!-- SweetAlert JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php

if (isset($_POST['add_staff'])) {
	$fname = $_POST['firstname'];
	$mname = $_POST['middlename'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$sex = $_POST['sex'];
	$department = $_POST['department'];
	$program = $_POST['program'];
	$address = $_POST['address'];
	$phonenumber = $_POST['phonenumber'];
	$role = $_POST['role'];
	$status = 1;

	$query = mysqli_query($conn, "SELECT * FROM staff WHERE email = '$email'") or die(mysqli_error($conn));
	$count = mysqli_num_rows($query);

	$uploadFolder = 'uploads/';

	// Get the original filename
	$originalFileName = $_FILES['signature']['name'];

	// Generate a unique identifier
	$uniqueIdentifier = uniqid();

	// Extract the file extension
	$fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

	// Create a unique filename by combining the original filename, unique identifier, and file extension
	$uniqueFileName = $uniqueIdentifier . '_' . $originalFileName;

	// Move uploaded files to the 'uploads' folder with the unique filename
	$signaturePath = $uniqueFileName;
	move_uploaded_file($_FILES['signature']['tmp_name'], $uploadFolder . $signaturePath);

	if ($count > 0) {
?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Data Already Exist'
				});
			});
		</script>
	<?php
	} else {
		mysqli_query($conn, "INSERT INTO staff (firstName, middleName, lastName, email, password, sex, department, program, address, phoneNumber, role, status, location, signature) VALUES ('$fname', '$mname', '$lname', '$email', '$password', '$sex', '$department', '$program', '$address', '$phonenumber', '$role', '$status', 'NO-IMAGE-AVAILABLE.jpg', '$signaturePath')") or die(mysqli_error($conn));
	?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire({
					icon: 'success',
					title: 'Success',
					text: 'Staff Added Successfully',
					showConfirmButton: false,
					timer: 1500
				}).then(function() {
					window.location = "staff.php";
				});
			});
		</script>
<?php
	}
}
?>


<style>
	.icon-right {
		float: right;
		margin-top: 5px;
		margin-right: 85px;
		/* Adjust this value as needed */
	}
</style>

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
								<h4>Staff Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff Module</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Staff Form</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="" enctype="multipart/form-data">
							<section>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Name *</label></strong>
											<input name="firstname" type="text" class="form-control wizard-required" onblur="toTitleCase(this)" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Middle Name</label></strong>
											<input name="middlename" type="text" class="form-control" onblur="toTitleCase(this)" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Last Name *</label></strong>
											<input name="lastname" type="text" class="form-control" onblur="toTitleCase(this)" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Email Address *</label></strong>
											<input name="email" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Password *</label></strong>
											<div class="input-group" style="position: relative;">
												<input name="password" id="password" class="form-control" type="password" placeholder="********" required="true" autocomplete="off" style="padding-right: 40px; z-index: 1;">
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="fa fa-eye" id="passwordToggleIcon" onclick="togglePasswordVisibility()"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Confirm Password *</label></strong>
											<div class="input-group" style="position: relative;">
												<input id="confirmPassword" class="form-control" type="password" placeholder="********" required="true" autocomplete="off" style="padding-right: 40px; z-index: 1;">
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="fa fa-eye" id="confirmPasswordToggleIcon" onclick="toggleConfirmPasswordVisibility()"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Sex *</label></strong>
											<select name="sex" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select </option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Phone Number *</label></strong>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Address *</label></strong>
											<input name="address" type="text" placeholder="House No./Street/Barangay/Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
										</div>
									</div>


									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Department</label></strong>
											<select name="department" id="department" class="custom-select form-control" autocomplete="off">
												<option value="" disabled selected>Select Department</option>
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
												<option value="">Select Program</option>
												<?php
												$programQuery = mysqli_query($conn, "SELECT * FROM programs");
												while ($programRow = mysqli_fetch_array($programQuery)) {
												?>
													<option class="<?php echo $programRow['deptID']; ?>" value="<?php echo $programRow['ProgramShortName']; ?>" style="display:none;"><?php echo $programRow['ProgramName']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>




									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Role *</label></strong>
											<select name="role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Role</option>
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
											<input name="signature" id="signatureFile" type="file" class="custom-file-input" required="true" accept=".png" onchange="validateAndDisplayFileName('signatureFile', 'signatureLabel')">
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
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;College&nbsp;Staff</button>
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
	<?php include('includes/scripts.php') ?>


	<script>
		function validateAndDisplayFileName(inputId, labelId) {
			var fileInput = document.getElementById(inputId);
			var fileName = fileInput.value.split("\\").pop();
			var allowedExtensions = /(\.png)$/i;

			if (fileInput.files.length > 0) {
				if (!allowedExtensions.exec(fileName)) {
					alert('Invalid file type. Please upload a png file.');
					fileInput.value = '';
					document.getElementById(labelId).innerHTML = 'Choose png file';
					return;
				}

				if (fileInput.files[0].size > 2 * 1024 * 1024) {
					alert('File size exceeds 2MB. Please choose a smaller file.');
					fileInput.value = '';
					document.getElementById(labelId).innerHTML = 'Choose png file';
					return;
				}

				document.getElementById(labelId).innerHTML = fileName;
			}
		}

		function togglePasswordVisibility() {
			var passwordInput = document.getElementById('password');
			var passwordToggleIcon = document.getElementById('passwordToggleIcon');
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				passwordToggleIcon.classList.remove('fa-eye');
				passwordToggleIcon.classList.add('fa-eye-slash');
			} else {
				passwordInput.type = 'password';
				passwordToggleIcon.classList.remove('fa-eye-slash');
				passwordToggleIcon.classList.add('fa-eye');
			}
		}

		function toggleConfirmPasswordVisibility() {
			var confirmPasswordInput = document.getElementById('confirmPassword');
			var confirmPasswordToggleIcon = document.getElementById('confirmPasswordToggleIcon');
			if (confirmPasswordInput.type === 'password') {
				confirmPasswordInput.type = 'text';
				confirmPasswordToggleIcon.classList.remove('fa-eye');
				confirmPasswordToggleIcon.classList.add('fa-eye-slash');
			} else {
				confirmPasswordInput.type = 'password';
				confirmPasswordToggleIcon.classList.remove('fa-eye-slash');
				confirmPasswordToggleIcon.classList.add('fa-eye');
			}
		}

		document.getElementById('add_staff').disabled = true;

		var firstname = document.querySelector('input[name="firstname"]');
		var middlename = document.querySelector('input[name="middlename"]');
		var lastname = document.querySelector('input[name="lastname"]');
		var address = document.querySelector('input[name="address"]');
		var phoneNumber = document.querySelector('input[name="phonenumber"]');
		var sex = document.querySelector('select[name="sex"]');
		var role = document.querySelector('select[name="role"]');
		var program = document.querySelector('select[name="program"]');
		var department = document.querySelector('select[name="department"]');
		var signature = document.querySelector('input[name="signature"]');
		var email = document.querySelector('input[name="email"]');
		var password = document.getElementById('password');
		var confirmPassword = document.getElementById('confirmPassword');

		sex.addEventListener('change', function() {
			validateSelect(this, 'Sex is required');
		});

		role.addEventListener('change', function() {
			validateSelect(this, 'Role is required');
		});

		program.addEventListener('change', function() {
			if (this.value.trim() === '') {
				clearMessages(this);
			} else {
				validateSelect(this);
			}
		});

		department.addEventListener('change', function() {
			if (this.value.trim() === '') {
				clearMessages(this);
			} else {
				validateSelect(this);
			}
		});

		firstname.addEventListener('input', function() {
			validateInput(this, /^[A-Za-z ñ.]+$/, 'First Name is required');
		});

		middlename.addEventListener('input', function() {
			validateOptionalInput(this, /^[A-Za-z ñ.]+$/, 'Middle Name is required');
		});

		lastname.addEventListener('input', function() {
			validateInput(this, /^[A-Za-z ñ.]+$/, 'Last Name is required');
		});

		address.addEventListener('input', function() {
			validateInput(this, /^[a-zA-Z0-9,\s.]+$/, 'Address is required');
		});

		phoneNumber.addEventListener('input', function() {
			validatePhoneNumber(this);
		});

		signature.addEventListener('change', function() {
			validateUpload(this, 'Signature is required');
		});

		email.addEventListener('input', function() {
			validateEmail(this);
		});

		password.addEventListener('input', function() {
			validatePassword(this);
			validateConfirmPassword(confirmPassword); // Validate confirm password whenever password changes
		});

		confirmPassword.addEventListener('input', function() {
			validateConfirmPassword(this);
		});

		function validateInput(input, regex, errorMessage) {
			var value = input.value.trim();

			if (value === '') {
				showError(input, errorMessage);
				enableDisableAddButton(false);
				return false;
			} else if (!regex.test(value)) {
				showError(input, 'Invalid Input');
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validateOptionalInput(input, regex, errorMessage) {
			var value = input.value.trim();

			if (value === '') {
				clearMessages(input);
				checkAllRequiredFields(); // Update button status
			} else if (!regex.test(value)) {
				showError(input, errorMessage);
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validatePhoneNumber(input) {
			var phoneNumberRegex = /^09\d{9}$/; // Regex for phone number starting with 09 and containing 11 digits
			var value = input.value.trim();

			if (value === '') {
				showError(input, 'Phone Number is required');
				enableDisableAddButton(false);
				return false;
			} else if (!phoneNumberRegex.test(value)) {
				showError(input, 'Invalid Phone Number');
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validateSelect(input, errorMessage) {
			var value = input.value.trim();

			if (value === '') {
				showError(input, errorMessage);
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validateUpload(input, errorMessage) {
			var value = input.value.trim();

			if (value === '') {
				showError1(input, errorMessage);
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess1(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validateEmail(input) {
			var emailRegex = /^[a-zA-Z0-9._%+-ñ]+@cvsu\.edu\.ph$/; // Regex for email ending with '@cvsu.edu.ph'
			var value = input.value.trim();

			if (value === '') {
				showError(input, 'Email Address is required');
				enableDisableAddButton(false);
				return false;
			} else if (!emailRegex.test(value)) {
				showError(input, 'Invalid Email Address');
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function validatePassword(input) {
			var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Regex for password with at least one letter, one number, and minimum length of 8 characters
			var value = input.value.trim();

			if (value === '') {
				showError(input, 'Password is required');
				enableDisableAddButton(false);
				return false;
			} else if (!passwordRegex.test(value)) {
				showError(input, 'Password must contain at least one letter, one number, and minimum length of 8 characters');
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				return true;
			}
		}

		function validateConfirmPassword(input) {
			var value = input.value.trim();
			var passwordValue = password.value.trim();

			if (value === '') {
				showError(input, 'Confirm Password is required');
				enableDisableAddButton(false);
				return false;
			} else if (value !== passwordValue) {
				showError(input, 'Passwords do not match');
				enableDisableAddButton(false);
				return false;
			} else {
				showSuccess(input);
				checkAllRequiredFields();
				return true;
			}
		}

		function checkAllRequiredFields() {
			// Check if all required fields are valid
			if (firstname.value.trim() !== '' && lastname.value.trim() !== '' &&
				address.value.trim() !== '' && /^[a-zA-Z0-9,\s.]+$/.test(address.value.trim()) &&
				/^[A-Za-z ñ.]+$/.test(firstname.value.trim()) &&
				/^[A-Za-z ñ.]+$/.test(lastname.value.trim()) && phoneNumber.value.trim() !== '' &&
				/^09\d{9}$/.test(phoneNumber.value.trim()) && email.value.trim() !== '' &&
				/^[a-zA-Z0-9._%+-ñ]+@cvsu\.edu\.ph$/.test(email.value.trim()) && sex.value.trim() !== '' &&
				role.value.trim() !== '' && password.value.trim() !== '' &&
				/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password.value.trim()) &&
				confirmPassword.value.trim() !== '' && confirmPassword.value.trim() === password.value.trim() &&
				signature.classList.contains('is-valid')
			) {
				enableDisableAddButton(true);
			}
		}

		function clearMessages(input) {
			// Clear error or success messages
			input.classList.remove('showError');
			input.classList.remove('showSuccess');
			input.classList.remove('is-invalid'); // Also removing 'is-invalid' class
			input.classList.remove('is-valid'); // Also removing 'is-valid' class
			input.nextElementSibling.textContent = '';
		}

		// Function to display error message
		function showError(input, message) {
			input.classList.add('is-invalid');
			var errorElement = input.parentElement.querySelector('.invalid-feedback');
			if (!errorElement) {
				errorElement = document.createElement('div');
				errorElement.classList.add('invalid-feedback');
				input.parentElement.appendChild(errorElement);
			}
			errorElement.innerText = message;
		}

		// Function to remove error message
		function showSuccess(input) {
			input.classList.remove('is-invalid');
			input.classList.add('is-valid');
			var errorElement = input.parentElement.querySelector('.invalid-feedback');
			if (errorElement) {
				errorElement.innerText = '';
			}
		}

		// Function to display error message
		function showError1(input, message) {
			input.classList.add('is-invalid');
			let errorElement = input.parentElement.querySelector('.invalid-feedback');
			if (!errorElement) {
				errorElement = document.createElement('div');
				errorElement.classList.add('invalid-feedback');
				input.parentElement.appendChild(errorElement);
			}
			errorElement.innerText = message;
		}

		// Function to remove error message
		function showSuccess1(input) {
			input.classList.remove('is-invalid');
			input.classList.add('is-valid');
			const label = input.parentElement.querySelector('.custom-file-label');
			const fileName = input.files[0].name;
			label.innerHTML = '<span class="file-name">' + fileName + '</span><span class="fa fa-check text-success icon-right"></span>';
		}

		// Function to enable or disable add_staff button
		function enableDisableAddButton(enabled) {
			document.getElementById('add_staff').disabled = !enabled;
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