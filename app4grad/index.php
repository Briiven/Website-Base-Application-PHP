<!DOCTYPE html>
<html lang="en">

<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>CEIT Application For Graduation Management System</title>
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-119386393-1');
    </script>
    <style>
        .modal-lg {
            max-width: 50% !important;
        }
    </style>
</head>

<body class="login-page">
    <?php
    session_start();
    include('includes/config.php');

    // Function to show SweetAlert
    function showAlert($title, $text, $icon)
    {
        echo "<script>
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon',
                confirmButtonText: 'OK'
            });
          </script>";
    }

    // Registration Logic
    if (isset($_POST['register'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $mname = mysqli_real_escape_string($conn, $_POST['middlename']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $studnum = mysqli_real_escape_string($conn, $_POST['studnum']);
        $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $birthplace = mysqli_real_escape_string($conn, $_POST['birthplace']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $program = mysqli_real_escape_string($conn, $_POST['program']);
        $section = mysqli_real_escape_string($conn, $_POST['section']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
        $status = 1;

        $query = mysqli_query($conn, "SELECT * FROM applicants WHERE email = '$email'") or die(mysqli_error($conn));
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            echo "<script>Swal.fire('Oops!', 'Email already exists for registration.', 'error');</script>";
        } else {
            mysqli_query($conn, "INSERT INTO applicants(firstName,middleName,lastName,email,password,studNumber,birthDate,birthPlace,age,program,section,address,sex,phoneNumber,status,location) VALUES('$fname','$mname','$lname','$email','$password','$studnum','$birthdate', '$birthplace', '$age','$program','$section','$address','$sex','$phonenumber','$status','NO-IMAGE-AVAILABLE.jpg')") or die(mysqli_error($conn));
            echo "<script>Swal.fire('Success!', 'Registration Successful', 'success');</script>";
        }
    }

    // Login Logic
if (isset($_POST['signin_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    // Check if the user is a staff member
    $sql_staff = "SELECT * FROM staff WHERE email ='$username'";
    $query_staff = mysqli_query($conn, $sql_staff);
    $count_staff = mysqli_num_rows($query_staff);

    if ($count_staff > 0) {
        $row = mysqli_fetch_assoc($query_staff);
        if ($row['password'] == $password) {
            if ($row['role'] == 'College Registrar') {
                $_SESSION['alogin'] = $row['staffID'];
                $_SESSION['arole'] = $row['role'];
                // Get the last inserted ID from the duration table
                $duration_query = "SELECT id FROM duration ORDER BY id DESC LIMIT 1";
                $duration_result = mysqli_query($conn, $duration_query);
                $duration_row = mysqli_fetch_assoc($duration_result);
                $_SESSION['duration_id'] = $duration_row['id'];
                echo "<script>document.location = 'admin/admin_dashboard.php'; </script>";
            } elseif ($row['role'] == 'Registration Adviser') {
                $_SESSION['alogin'] = $row['staffID'];
                $_SESSION['arole'] = $row['role'];
                // Get the last inserted ID from the duration table
                $duration_query = "SELECT id FROM duration ORDER BY id DESC LIMIT 1";
                $duration_result = mysqli_query($conn, $duration_query);
                $duration_row = mysqli_fetch_assoc($duration_result);
                $_SESSION['duration_id'] = $duration_row['id'];
                echo "<script>document.location = 'registration_adviser/index.php'; </script>";
            } elseif ($row['role'] == 'Department Head') {
                $_SESSION['alogin'] = $row['staffID'];
                $_SESSION['arole'] = $row['role'];
                // Get the last inserted ID from the duration table
                $duration_query = "SELECT id FROM duration ORDER BY id DESC LIMIT 1";
                $duration_result = mysqli_query($conn, $duration_query);
                $duration_row = mysqli_fetch_assoc($duration_result);
                $_SESSION['duration_id'] = $duration_row['id'];
                echo "<script>document.location = 'department_head/index.php'; </script>";
            } else {
                $_SESSION['alogin'] = $row['staffID'];
                $_SESSION['arole'] = $row['role'];
                // Get the last inserted ID from the duration table
                $duration_query = "SELECT id FROM duration ORDER BY id DESC LIMIT 1";
                $duration_result = mysqli_query($conn, $duration_query);
                $duration_row = mysqli_fetch_assoc($duration_result);
                $_SESSION['duration_id'] = $duration_row['id'];
                echo "<script>document.location = 'college_dean/index.php'; </script>";
            }
        } else {
            echo "<script>Swal.fire('Oops!', 'Incorrect Password', 'error');</script>";
            // Clear password input
            echo "<script>document.getElementById('password').value = '';</script>";
        }
    } else {
        // Check if the user is an applicant
        $sql_applicant = "SELECT * FROM applicants WHERE email ='$username'";
        $query_applicant = mysqli_query($conn, $sql_applicant);
        $count_applicant = mysqli_num_rows($query_applicant);

        if ($count_applicant > 0) {
            $applicant_row = mysqli_fetch_assoc($query_applicant);
            if ($applicant_row['password'] == $password) {
                $_SESSION['alogin'] = $applicant_row['appID'];
                $_SESSION['arole'] = 'program';
                // Get the last inserted ID from the duration table
                $duration_query = "SELECT id FROM duration ORDER BY id DESC LIMIT 1";
                $duration_result = mysqli_query($conn, $duration_query);
                $duration_row = mysqli_fetch_assoc($duration_result);
                $_SESSION['duration_id'] = $duration_row['id'];
                echo "<script>document.location = 'applicant/index.php'; </script>";
            } else {
                echo "<script>Swal.fire('Oops!', 'Incorrect Password', 'error');</script>";
                // Clear password input
                echo "<script>document.getElementById('password').value = '';</script>";
            }
        } else {
            echo "<script>Swal.fire('Oops!', 'Invalid Username', 'error');</script>";
        }
    }
}

    ?>
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="index.php">
                    <img src="vendors/images/deskapp-logo-svg.png" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="vendors/images/login.png" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center">Welcome to CEIT Application for Graduation Management System!</h2>
                        </div>
                        <form name="signin" method="post" action="">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="CvSU Email" name="username" id="username" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" id="password" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="row pb-30">
                                <div class="mx-auto text-center">
                                    <p>Don't have an account?<a href="#" data-toggle="modal" data-target="#registrationModal">&nbsp;Register Now!</a></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-success btn-lg btn-block" name="signin_btn" id="signin" type="submit" value="Sign In">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Registration Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register Now!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <section>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>First Name *</label></strong>
                                        <input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Middle Name</label></strong>
                                        <input name="middlename" type="text" class="form-control" autocomplete="off" onblur="toTitleCase(this)">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Last Name *</label></strong>
                                        <input name="lastname" type="text" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Email Address *</label></strong>
                                        <input name="email" type="email" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Student Number *</label></strong>
                                        <input name="studnum" type="text" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Password *</label></strong>
                                        <input id="password" name="password" type="password" placeholder="**********" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Confirm Password *</label></strong>
                                        <input id="confirmPassword" name="confirmPassword" type="password" placeholder="**********" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Phone Number *</label></strong>
                                        <input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Program *</label></strong>
                                        <select name="program" class="custom-select form-control" required="true" autocomplete="off">
                                            <option value="">Select Program</option>
                                            <?php
                                            $query = mysqli_query($conn, "select * from programs");
                                            while ($row = mysqli_fetch_array($query)) {

                                            ?>
                                                <option value="<?php echo $row['ProgramShortName']; ?>"><?php echo $row['ProgramName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Section *</label></strong>
                                        <select name="section" class="custom-select form-control" required="true">
                                            <option value="">Select Section</option>
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
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Sex *</label></strong>
                                        <select name="sex" class="custom-select form-control" required="true" autocomplete="off">
                                            <option value="">Select </option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Date Of Birth *</label></strong>
                                        <input name="birthdate" id="birthdate" type="text" class="form-control date-picker" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Age *</label></strong>
                                        <input name="age" id="age" type="number" min="18" max="99" class="form-control" readonly="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Birthplace *</label></strong>
                                        <input name="birthplace" type="text" placeholder="Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <strong><label>Complete Address *</label></strong>
                                        <input name="address" type="text" placeholder="House No./Street/Barangay/Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label style="font-size:16px;"><b></b></label>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-primary" name="register" id="register">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa fa-eye-slash');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#birthdate").datepicker({
                dateFormat: 'MM dd, yy',
                changeYear: true,
                yearRange: '1900:c', // From 1900 to the current year
                maxDate: '0', // Disable future dates
                defaultDate: '-18y', // Set default date to 18 years ago from current year
                onSelect: function(selectedDate) {
                    var today = new Date();
                    var dob = new Date(selectedDate);
                    var age = today.getFullYear() - dob.getFullYear();
                    var m = today.getMonth() - dob.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    $('#age').val(age).trigger('input'); // Set age and trigger input event
                    $('#birthdate').val(selectedDate).trigger('change'); // Set birthdate input value and trigger change event
                }
            });

            function enableDisableRegisterButton() {
                // Enable the register button if there are no errors and all required fields have a value
                if ($('.error-message').length === 0 && allFieldsHaveValue()) {
                    $('#register').prop('disabled', false);
                } else {
                    // Disable the register button if there are errors or required fields are empty
                    $('#register').prop('disabled', true);
                }
            }

            function allFieldsHaveValue() {
                // Check if all required fields have a value
                var fields = ['#registrationModal select[name="program"]', '#registrationModal select[name="section"]', '#registrationModal input[name="birthdate"]', '#registrationModal input[name="age"]', '#registrationModal select[name="sex"]', '#registrationModal input[name="address"]', '#registrationModal input[name="birthplace"]'];
                for (var i = 0; i < fields.length; i++) {
                    var fieldValue = $(fields[i]).val().trim();
                    if (fieldValue === '') {
                        return false; // Return false if any required field is empty
                    }
                }
                return true; // Return true if all required fields have a value
            }

            // Disable the register button initially
            $('#register').prop('disabled', true);

            // Validation for first name
            $('#registrationModal input[name="firstname"]').on('input', function() {
                validateName($(this), 'First Name');
                enableDisableRegisterButton();
            });

            // Validation for middle name (optional)
            $('#registrationModal input[name="middlename"]').on('input', function() {
                if ($(this).val().trim() !== '') {
                    validateName($(this), 'Middle Name');
                } else {
                    clearMessages($(this));
                }
                enableDisableRegisterButton();
            });

            // Validation for last name
            $('#registrationModal input[name="lastname"]').on('input', function() {
                validateName($(this), 'Last Name');
                enableDisableRegisterButton();
            });

            // Validation for email address
            $('#registrationModal input[name="email"]').on('input', function() {
                validateEmail($(this));
                enableDisableRegisterButton();
            });

            // Validation for password
            $('#registrationModal input[name="password"]').on('input', function() {
                validatePassword($(this));
                enableDisableRegisterButton();
            });

            // Validation for confirm password
            $('#registrationModal input[name="confirmPassword"]').on('input', function() {
                validateConfirmPassword($(this));
                enableDisableRegisterButton();
            });

            // Validation for student number
            $('#registrationModal input[name="studnum"]').on('input', function() {
                validateStudentNumber($(this));
                enableDisableRegisterButton();
            });

            // Validation for phone number
            $('#registrationModal input[name="phonenumber"]').on('input', function() {
                validatePhoneNumber($(this));
                enableDisableRegisterButton();
            });

            // Validation for program
            $('#registrationModal select[name="program"]').on('change', function() {
                validateProgram($(this));
                enableDisableRegisterButton();
            });

            // Validation for section
            $('#registrationModal select[name="section"]').on('change', function() {
                validateSection($(this));
                enableDisableRegisterButton();
            });

            // Validation for date of birth
            $('#registrationModal input[name="birthdate"]').on('change', function() {
                validateBirthdate($(this));
                enableDisableRegisterButton();
            });

            // Validation for age
            $('#registrationModal input[name="age"]').on('input', function() {
                validateAge($(this));
                enableDisableRegisterButton();
            });

            // Validation for sex
            $('#registrationModal select[name="sex"]').on('change', function() {
                validateSex($(this));
                enableDisableRegisterButton();
            });

            // Validation for address
            $('#registrationModal input[name="address"]').on('input', function() {
                validateAddress($(this));
                enableDisableRegisterButton();
            });

            // Validation for address
            $('#registrationModal input[name="birthplace"]').on('input', function() {
                validateAddress($(this));
                enableDisableRegisterButton();
            });

            // Validation for form submission
            $('#registrationModal form').submit(function(e) {
                // Client-side validation for first name, middle name, last name, email, and password
                var firstNameValid = validateName($('#registrationModal input[name="firstname"]'), 'First Name');
                var middleNameValid = true; // Middle name is optional
                var middleNameInput = $('#registrationModal input[name="middlename"]');
                if (middleNameInput.val().trim() !== '') {
                    middleNameValid = validateName(middleNameInput, 'Middle Name');
                }
                var lastNameValid = validateName($('#registrationModal input[name="lastname"]'), 'Last Name');
                var emailValid = validateEmail($('#registrationModal input[name="email"]'));
                var passwordValid = validatePassword($('#registrationModal input[name="password"]'));
                var confirmPasswordValid = validateConfirmPassword($('#registrationModal input[name="confirmPassword"]'));
                var studentNumberValid = validateStudentNumber($('#registrationModal input[name="studnum"]'));
                var phoneNumberValid = validatePhoneNumber($('#registrationModal input[name="phonenumber"]'));

                // If any validation fails, prevent form submission
                if (!firstNameValid || !middleNameValid || !lastNameValid || !emailValid || !passwordValid || !confirmPasswordValid || !studentNumberValid || !phoneNumberValid) {
                    e.preventDefault();
                }
            });

            function validateName(input, fieldName) {
                clearMessages(input);
                var name = input.val().trim();
                if (name === '') {
                    showError(input, fieldName + ' is required');
                    return false;
                } else if (!/^[a-zA-ZñÑ\s]+$/.test(name)) {
                    showError(input, 'Invalid ' + fieldName);
                    return false;
                } else {
                    showSuccess(input);
                    return true;
                }
            }

            function validateEmail(input) {
                clearMessages(input);
                var email = input.val().trim();

                if (email === '') {
                    showError(input, 'Email is required');
                    return false;
                } else if (!/^\S+@cvsu\.edu\.ph$/.test(email)) {
                    showError(input, 'Invalid email address. It must end with @cvsu.edu.ph');
                    return false;
                } else {
                    showSuccess(input);
                    return true;
                }
            }

            function validatePassword(input) {
                clearMessages(input);
                var password = input.val().trim();
                var letterPattern = /[a-zA-Z]/;
                var numberPattern = /[0-9]/;

                if (password === '') {
                    showError(input, 'Password is required');
                    return false;
                } else if (password.length < 8) {
                    showError(input, 'Password must be at least 8 characters long');
                    return false;
                } else if (!letterPattern.test(password) || !numberPattern.test(password)) {
                    showError(input, 'Password must contain both letters and numbers');
                    return false;
                } else {
                    showSuccess(input);
                    validateConfirmPassword($('#confirmPassword')); // Validate confirm password whenever password changes
                    return true;
                }
            }

            function validateConfirmPassword(input) {
                clearMessages(input);
                var confirmPassword = input.val().trim();
                var password = $('#registrationModal input[name="password"]').val().trim();

                if (confirmPassword === '') {
                    showError(input, 'Confirm password is required');
                    return false;
                } else if (password !== confirmPassword) {
                    showError(input, 'Passwords do not match');
                    return false;
                } else {
                    showSuccess(input);
                    return true;
                }
            }

            function validateStudentNumber(input) {
                clearMessages(input);
                var studNum = input.val().trim();

                if (studNum === '') {
                    showError(input, 'Student number is required');
                    return false;
                } else if (studNum.length !== 9 || !/^\d+$/.test(studNum)) {
                    showError(input, 'Invalid student number. It must be 9 digits long.');
                    return false;
                } else {
                    showSuccess(input);
                    return true;
                }
            }

            function validatePhoneNumber(input) {
                clearMessages(input);
                var phoneNumber = input.val().trim();

                if (phoneNumber === '') {
                    showError(input, 'Phone number is required');
                    return false;
                } else if (phoneNumber.length !== 11 || !/^\d{11}$/.test(phoneNumber)) {
                    showError(input, 'Invalid phone number. It must be 11 digits long.');
                    return false;
                } else {
                    showSuccess(input);
                    return true;
                }
            }

            function validateProgram(input) {
                clearMessages(input);
                var program = input.val().trim();
                if (program === '') {
                    showError(input, 'Program is required');
                } else {
                    showSuccess(input);
                }
            }

            function validateSection(input) {
                clearMessages(input);
                var section = input.val().trim();
                if (section === '') {
                    showError(input, 'Section is required');
                } else {
                    showSuccess(input);
                }
            }

            function validateBirthdate(input) {
                clearMessages(input);
                var birthdate = input.val().trim();
                if (birthdate === '') {
                    showError(input, 'Date of Birth is required');
                } else {
                    showSuccess(input);
                }
            }

            function validateAge(input) {
                clearMessages(input);
                var age = input.val().trim();
                if (age === '') {
                    showError(input, 'Age is required');
                } else if (isNaN(age)) {
                    showError(input, 'Please enter a valid age');
                } else if (parseInt(age) < 18) {
                    showError(input, 'Age must be 18 years old or higher');
                } else {
                    showSuccess(input);
                }
            }

            function validateSex(input) {
                clearMessages(input);
                var sex = input.val().trim();
                if (sex === '') {
                    showError(input, 'Sex is required');
                } else {
                    showSuccess(input);
                }
            }

            function validateAddress(input) {
                clearMessages(input);
                var address = input.val().trim();
                if (address === '') {
                    showError(input, 'Address is required');
                } else {
                    showSuccess(input);
                }
            }


            function showError(input, message) {
                input.addClass('is-invalid').removeClass('is-valid');
                input.parent().find('.invalid-feedback').remove();
                input.after('<div class="invalid-feedback">' + message + '</div>');
            }

            function showSuccess(input) {
                input.addClass('is-valid').removeClass('is-invalid');
                input.parent().find('.invalid-feedback').remove();
            }

            function clearMessages(input) {
                input.removeClass('is-valid is-invalid');
                input.parent().find('.invalid-feedback').remove();
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
</body>

</html>