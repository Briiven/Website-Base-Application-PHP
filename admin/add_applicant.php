<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>

<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php
if (isset($_POST['add_applicant'])) {

    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $studnum = $_POST['studnum'];
    $birthdate = $_POST['birthdate'];
    $birthplace = $_POST['birthplace'];
    $age = $_POST['age'];
    $program = $_POST['program'];
    $section = $_POST['section'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $phonenumber = $_POST['phonenumber'];
    $status = 1;

    $query = mysqli_query($conn, "SELECT * FROM applicants WHERE email = '$email'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) { ?>
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
        mysqli_query($conn, "INSERT INTO applicants(firstName,middleName,lastName,email,password,studNumber,birthDate,birthPlace,age,program,section,address,sex,phoneNumber,status,location) VALUES('$fname','$mname','$lname','$email','$password','$studnum','$birthdate','$birthplace','$age','$program','$section','$address','$sex','$phonenumber','$status','NO-IMAGE-AVAILABLE.jpg')         
        ") or die(mysqli_error($conn)); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Applicant Successfully Added',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = "applicants.php";
                });
            });
        </script>
<?php   }
}
?>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

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
                                <h4>Applicant Portal</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Applicant Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Applicant Form</h4>
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
                                            <input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Middle Name</label></strong>
                                            <input name="middlename" type="text" class="form-control" autocomplete="off" onblur="toTitleCase(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Last Name *</label></strong>
                                            <input name="lastname" type="text" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Email Address *</label></strong>
                                            <input name="email" type="email" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Student Number *</label></strong>
                                            <input name="studnum" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
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
                                    <div class="col-md-3 col-sm-12">
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
                                            <strong><label>Phone Number *</label></strong>
                                            <input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Date Of Birth *</label></strong>
                                            <input name="birthdate" id="birthdate" type="text" class="form-control date-picker" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Age *</label>
                                            <input name="age" id="age" type="number" min="18" max="99" class="form-control" readonly="true" autocomplete="off">
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
                                            <strong><label>Program *</label></strong>
                                            <select name="program" class="custom-select form-control" autocomplete="off">
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
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Section *</label></strong>
                                            <select name="section" class="custom-select form-control" required="true" autocomplete="off">
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
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Birthplace *</label></strong>
                                            <input name="birthplace" type="text" placeholder="Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <strong><label>Address *</label></strong>
                                            <input name="address" type="text" placeholder="House No./Street/Barangay/Municipality/Province" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-success" name="add_applicant" id="add_applicant" data-toggle="modal">Add&nbsp;Applicant</button>
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
        $(document).ready(function() {
            $("#birthdate").datepicker({
                dateFormat: 'dd MM yyyy',
                onSelect: function(selectedDate) {
                    var today = new Date();
                    var dob = new Date(selectedDate);
                    var age = today.getFullYear() - dob.getFullYear();
                    var m = today.getMonth() - dob.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    $('#age').val(age).trigger('input'); // Set age and trigger input event
                }
            });
        });

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

        document.getElementById('add_applicant').disabled = true;

        var firstname = document.querySelector('input[name="firstname"]');
        var middlename = document.querySelector('input[name="middlename"]');
        var lastname = document.querySelector('input[name="lastname"]');
        var address = document.querySelector('input[name="address"]');
        var birthplace = document.querySelector('input[name="birthplace"]');
        var phoneNumber = document.querySelector('input[name="phonenumber"]');
        var studnum = document.querySelector('input[name="studnum"]');
        var sex = document.querySelector('select[name="sex"]');
        var section = document.querySelector('select[name="section"]');
        var program = document.querySelector('select[name="program"]');
        var email = document.querySelector('input[name="email"]');
        var password = document.getElementById('password');
        var confirmPassword = document.getElementById('confirmPassword');

        sex.addEventListener('change', function() {
            validateSelect(this, 'Sex is required');
        });

        section.addEventListener('change', function() {
            validateSelect(this, 'Section is required');
        });

        program.addEventListener('change', function() {
            validateSelect(this, 'Program is required');
        });

        firstname.addEventListener('input', function() {
            validateInput(this, /^[A-Za-z .]+$/, 'First Name is required');
        });

        middlename.addEventListener('input', function() {
            validateInput(this, /^[A-Za-z .]+$/, 'Middle Name is required');
        });

        lastname.addEventListener('input', function() {
            validateInput(this, /^[A-Za-z .]+$/, 'Last Name is required');
        });

        address.addEventListener('input', function() {
            validateInput(this, /^[a-zA-Z0-9,\sñÑ\-'.]+$/, 'Address is required');
        });

        birthplace.addEventListener('input', function() {
            validateInput(this, /^[a-zA-Z0-9,\sñÑ\-'.]+$/, 'Birthplace is required');
        });

        phoneNumber.addEventListener('input', function() {
            validatePhoneNumber(this);
        });

        studnum.addEventListener('input', function() {
            validateStudNumber(this);
        });

        email.addEventListener('input', function() {
            validateEmail(this);
        });

        password.addEventListener('input', function() {
            validatePassword(this);
            validateConfirmPassword(confirmPassword);
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

        function validateStudNumber(input) {
            var phoneNumberRegex = /^\d{9}$/; // Regex for exactly 9 digits
            var value = input.value.trim();

            if (value === '') {
                showError(input, 'Student Number is required');
                enableDisableAddButton(false);
                return false;
            } else if (!phoneNumberRegex.test(value)) {
                showError(input, 'Invalid Student Number');
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


        function validateEmail(input) {
            var emailRegex = /^[a-zA-Z0-9._%+-]+@cvsu\.edu\.ph$/; // Regex for email ending with '@cvsu.edu.ph'
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
            if (firstname.value.trim() !== '' && middlename.value.trim() !== '' && lastname.value.trim() !== '' &&
                address.value.trim() !== '' && /^[a-zA-Z0-9,\sñÑ\-'.]+$/.test(address.value.trim()) &&
                birthplace.value.trim() !== '' && /^[a-zA-Z0-9,\sñÑ\-'.]+$/.test(birthplace.value.trim()) &&
                /^[A-Za-z .]+$/.test(firstname.value.trim()) && /^[A-Za-z .]+$/.test(middlename.value.trim()) &&
                /^[A-Za-z .]+$/.test(lastname.value.trim()) && phoneNumber.value.trim() !== '' &&
                /^09\d{9}$/.test(phoneNumber.value.trim()) && studnum.value.trim() !== '' &&
                /^\d{9}$/.test(studnum.value.trim()) && email.value.trim() !== '' &&
                /^[a-zA-Z0-9._%+-]+@cvsu\.edu\.ph$/.test(email.value.trim()) && sex.value.trim() !== '' &&
                section.value.trim() !== '' && program.value.trim() !== '' && password.value.trim() !== '' &&
                /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password.value.trim()) &&
                confirmPassword.value.trim() !== '' && confirmPassword.value.trim() === password.value.trim()
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

        // Function to enable or disable add_applicant button
        function enableDisableAddButton(enabled) {
            document.getElementById('add_applicant').disabled = !enabled;
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