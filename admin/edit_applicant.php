<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_applicant']))
	{
		$fname=$_POST['firstname'];
		$mname=$_POST['middlename'];
		$lname=$_POST['lastname'];
		$email=$_POST['email']; 
		$studnum=$_POST['studnum'];
		$birthdate=$_POST['birthdate'];
		$birthplace=$_POST['birthplace'];
		$age=$_POST['age'];
		$program=$_POST['program'];
		$section=$_POST['section'];
		$address=$_POST['address'];
		$sex=$_POST['sex']; 
		$phonenumber=$_POST['phonenumber'];

		$result = mysqli_query($conn, "UPDATE applicants SET firstName='$fname', middleName='$mname', lastName='$lname', email='$email', studNumber='$studnum', birthDate='$birthdate', birthPlace='$birthplace', age='$age', program='$program', section='$section', address='$address', sex='$sex', phoneNumber='$phonenumber' WHERE appID='$get_id'"); 		
		if ($result) {
			echo "<script>
				document.addEventListener('DOMContentLoaded', function () {
					Swal.fire({
						icon: 'success',
						title: 'Record Successfully Updated',
						showConfirmButton: false,
						timer: 1500
					}).then(function () {
						document.location = 'applicants.php';
					});
				});
			</script>";
		} else {
			die(mysqli_error($conn));
		}
	}
?>
<body>

<?php include('includes/navbar.php')?>

<?php include('includes/right_sidebar.php')?>

<?php include('includes/left_sidebar.php')?>

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
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
						<form method="post" action="">
							<section>
                            <?php
									$query = mysqli_query($conn,"select * from applicants where appID = '$get_id' ")or die(mysqli_error($conn));
									$row = mysqli_fetch_array($query);
							?>
						
                            <div class="row">
                                    <div class="col-md-4 col-sm-12">
										<div class="form-group">
										<strong><label >First Name </label></strong>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $row['firstName']; ?>" onblur="toTitleCase(this)">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
										<strong><label >Middle Name </label></strong>
											<input name="middlename" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['middleName']; ?>" onblur="toTitleCase(this)">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
										<strong><label >Last Name </label></strong>
											<input name="lastname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['lastName']; ?>" onblur="toTitleCase(this)">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
										<strong><label>Email Address </label></strong>
											<input name="email" type="email" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $row['email']; ?>">
										</div>
									</div>
									
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
										<strong><label>Student Number </label></strong>
											<input name="studnum" type="number" class="form-control" required="true" autocomplete="off" value="<?php echo $row['studNumber']; ?>">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
										<strong><label>Phone Number </label></strong>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['phoneNumber']; ?>">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
										<strong><label>Sex </label></strong>
											<select name="sex" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="<?php echo $row['sex']; ?>"><?php echo $row['sex']; ?></option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
									<div class="form-group">
														<strong><label>Program</label></strong>
																<select name="program" class="custom-select form-control" required="true" autocomplete="off">
																	<?php $query = mysqli_query($conn, "select * from applicants LEFT JOIN programs ON applicants.program = programs.ProgramShortName where appID = '$get_id'") or die(mysqli_error($conn));
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
									$query = mysqli_query($conn,"select * from applicants where appID = '$get_id' ")or die(mysqli_error($conn));
									$row = mysqli_fetch_array($query);
									?>
									<div class="col-md-2 col-sm-12">
									<div class="form-group">
														<strong><label>Section</label></strong>
																<select name="section" class="custom-select form-control" required="true" autocomplete="off">
																	<option value="<?php echo $row['section']; ?>"><?php echo $row['section']; ?></option>
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
										<strong><label>Date Of Birth</label></strong>
											<input name="birthdate" type="text" class="form-control date-picker" required="true" autocomplete="off" value="<?php echo $row['birthDate']; ?>">
										</div>
									</div>
									<div class="col-md-1 col-sm-12">
										<div class="form-group">
										<strong><label>Age</label></strong>
											<input name="age" type="number" min="18" max="99" class="form-control" required="true" autocomplete="off" value="<?php echo $row['age']; ?>">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
										<strong><label>Birthplace</label></strong>
											<input name="birthplace" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['birthPlace']; ?>">
										</div>
									</div>
									
									
									
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
										<strong><label>Complete Address </label></strong>
											<input name="address" type="text" placeholder="House No./Street/Barangay/Municipality/Province" class="form-control" required="true" autocomplete="off"value="<?php echo $row['address']; ?>" onblur="toTitleCase(this)">
										</div>
									</div>					
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<a href="applicants.php" class="btn btn-secondary" role="button">Cancel</a>
												<button class="btn btn-success" name="add_applicant" id="add_applicant" data-toggle="modal">Update&nbsp;Applicant</button>
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
            <?php include('includes/footer.php'); ?>
		</div>
	</div>
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
	<?php include('includes/scripts.php')?>
</body>
</html>
  