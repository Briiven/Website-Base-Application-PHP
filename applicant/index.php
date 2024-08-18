<?php include('includes/header.php'); ?>
<?php include('../includes/session.php'); ?>
<?php

// Check if there is an existing entry with appID based on $session_id and RAstatus is 2
$checkExistingApplication = mysqli_query($conn, "SELECT * FROM application WHERE appID = '$session_id' AND RAstatus = 2") or die(mysqli_error($conn));
$dataExists = mysqli_num_rows($checkExistingApplication) > 0;

$applicationQuery = mysqli_query($conn, "SELECT * FROM application WHERE appID = '$session_id' ") or die(mysqli_error($conn));
$row = mysqli_fetch_array($applicationQuery);
$applicationExist = !empty($row);




if (isset($_POST['apply'])) {
	$appid = $session_id;
	$durationID = $_POST['durationID'];
	$RAstaffID = $_POST['RAstaffID'];
	$apptype = $_POST['apptype'];
	$appdate = date("Y-m-d");
	$studnum = $_POST['studnum'];
	$email = $_POST['email'];
	$fname = $_POST['firstname'];
	$mname = $_POST['middlename'];
	$lname = $_POST['lastname'];
	$sex = $_POST['sex'];
	$age = $_POST['age'];
	$birthdate = $_POST['birthdate'];
	$birthplace = $_POST['birthplace'];
	$phonenum = $_POST['phonenum'];
	$address = $_POST['address'];
	$shs = $_POST['shs'];
	$shsyear = $_POST['shsyear'];
	$shsaddress = $_POST['shsaddress'];
	$osc = $_POST['osc'];
	$oscyear = $_POST['oscyear'];
	$oscaddress = $_POST['oscaddress'];
	$admissiondate = strtoupper($_POST['admissiondate']);
	$onefirst = $_POST['onefirst'];
	$onesecond = $_POST['onesecond'];
	$onesummer = $_POST['onesummer'];
	$twofirst = $_POST['twofirst'];
	$twosecond = $_POST['twosecond'];
	$twosummer = $_POST['twosummer'];
	$threefirst = $_POST['threefirst'];
	$threesecond = $_POST['threesecond'];
	$threesummer = $_POST['threesummer'];
	$fourfirst = $_POST['fourfirst'];
	$foursecond = $_POST['foursecond'];
	$foursummer = $_POST['foursummer'];
	$fivefirst = $_POST['fivefirst'];
	$fivesecond = $_POST['fivesecond'];
	$fivesummer = $_POST['fivesummer'];
	$sixfirst = $_POST['sixfirst'];
	$sixsecond = $_POST['sixsecond'];
	$sixsummer = $_POST['sixsummer'];
	$sevenfirst = $_POST['sevenfirst'];
	$sevensecond = $_POST['sevensecond'];
	$sevensummer = $_POST['sevensummer'];
	$eightfirst = $_POST['eightfirst'];
	$eightsecond = $_POST['eightsecond'];
	$eightsummer = $_POST['eightsummer'];
	$subone = $_POST['subone'];
	$unitone = $_POST['unitone'];
	$subtwo = $_POST['subtwo'];
	$unittwo = $_POST['unittwo'];
	$subthree = $_POST['subthree'];
	$unitthree = $_POST['unitthree'];
	$subfour = $_POST['subfour'];
	$unitfour = $_POST['unitfour'];
	$subfive = $_POST['subfive'];
	$unitfive = $_POST['unitfive'];
	$subsix = $_POST['subsix'];
	$unitsix = $_POST['unitsix'];
	$subseven = $_POST['subseven'];
	$unitseven = $_POST['unitseven'];
	$subeight = $_POST['subeight'];
	$uniteight = $_POST['uniteight'];
	$totalunits = $_POST['totalunits'];
	$lowestgrade = $_POST['lowestgrade'] ?? null;
	$transfereelowest = $_POST['transfereelowest'] ?? null;
	$program = $_POST['program'];
	$gradyear = $_POST['gradYear'];
	$isread = 0;
	$crstatus = 0;
	$dhstatus = 0;
	$cdstatus = 0;

	// Handle file uploads
	$signature = $_FILES['signature'];
	$picture = $_FILES['picture'];
	$coc = $_FILES['coc'];

	// Get current timestamp for renaming files
	$current_time = time();

	// Rename and move uploaded files to 'uploads' folder
	$signature_name = $studnum . '_signature_' . $current_time . '.png';
	move_uploaded_file($signature['tmp_name'], 'uploads/' . $signature_name);

	$picture_name = $studnum . '_picture_' . $current_time . '.' . pathinfo($picture['name'], PATHINFO_EXTENSION);
	move_uploaded_file($picture['tmp_name'], 'uploads/' . $picture_name);

	$coc_name = $studnum . '_coc_' . $current_time . '.' . pathinfo($coc['name'], PATHINFO_EXTENSION);
	move_uploaded_file($coc['tmp_name'], 'uploads/' . $coc_name);

	// Save the renamed files' names to be stored in the database
	$query = mysqli_query($conn, "SELECT * FROM application WHERE appID = $session_id AND email = '" . mysqli_real_escape_string($conn, $email) . "'") or die(mysqli_error($conn));
	$count = mysqli_num_rows($query);

	if ($count > 0) {
		$existing_query = mysqli_query($conn, "SELECT * FROM application WHERE appID = $session_id AND RAstatus = 2") or die(mysqli_error($conn));
		$existing_data = mysqli_fetch_assoc($existing_query);
	
		if ($existing_data) {
			$delete_query = mysqli_query($conn, "DELETE FROM application WHERE appID = $session_id AND RAstatus = 2") or die(mysqli_error($conn));
		}
		
		mysqli_query(
			$conn,
			"INSERT INTO application (appID, durationID, RAstaffID, appType, appDate, studNum, email, firstName, middleName, lastName, sex, age, birthDate, birthPlace, phoneNumber, address, shs, shsYear, shsAddress, osc, oscYear, oscAddress, admissionDate, 1First, 1Second, 1Summer, 2First, 2Second, 2Summer, 3First, 3Second, 3Summer, 4First, 4Second, 4Summer, 5First, 5Second, 5Summer, 6First, 6Second, 6Summer, 7First, 7Second, 7Summer, 8First, 8Second, 8Summer, sub1, unit1, sub2, unit2, sub3, unit3, sub4, unit4, sub5, unit5, sub6, unit6, sub7, unit7, sub8, unit8, totalUnits, lowestGrade, transfereeLowest, program, gradYear, signature, picture, COC, isRead, CRstatus, DHstatus, CDstatus)
			VALUES ('$appid', '$durationID', '$RAstaffID', '$apptype', '$appdate', '$studnum', '$email', '$fname', '$mname', '$lname', '$sex', '$age', '$birthdate', '$birthplace', '$phonenum', '$address', '$shs', '$shsyear', '$shsaddress', '$osc', '$oscyear', '$oscaddress', '$admissiondate', '$onefirst', '$onesecond', '$onesummer', '$twofirst', '$twosecond', '$twosummer', '$threefirst', '$threesecond', '$threesummer', '$fourfirst', '$foursecond', '$foursummer', '$fivefirst', '$fivesecond', '$fivesummer', '$sixfirst', '$sixsecond', '$sixsummer', '$sevenfirst', '$sevensecond', '$sevensummer', '$eightfirst', '$eightsecond', '$eightsummer','$subone', '$unitone', '$subtwo', '$unittwo', '$subthree', '$unitthree', '$subfour', '$unitfour', '$subfive', '$unitfive', '$subsix', '$unitsix', '$subseven', '$unitseven', '$subeight', '$uniteight', '$totalunits', '$lowestgrade', '$transfereelowest', '$program', '$gradyear', '$signature_name', '$picture_name', '$coc_name', '$isread', '$crstatus', '$dhstatus', '$cdstatus')"
		) or die(mysqli_error($conn));
	
		?>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire({
					icon: 'success',
					title: 'Application Submitted Successfully!',
					showConfirmButton: false,
					timer: 1500
				}).then(function() {
					window.location = "index.php";
				});
			});
		</script>
		<?php
	} else {
		mysqli_query(
			$conn,
			"INSERT INTO application (appID, durationID, RAstaffID, appType, appDate, studNum, email, firstName, middleName, lastName, sex, age, birthDate, birthPlace, phoneNumber, address, shs, shsYear, shsAddress, osc, oscYear, oscAddress, admissionDate, 1First, 1Second, 1Summer, 2First, 2Second, 2Summer, 3First, 3Second, 3Summer, 4First, 4Second, 4Summer, 5First, 5Second, 5Summer, 6First, 6Second, 6Summer, 7First, 7Second, 7Summer, 8First, 8Second, 8Summer, sub1, unit1, sub2, unit2, sub3, unit3, sub4, unit4, sub5, unit5, sub6, unit6, sub7, unit7, sub8, unit8, totalUnits, lowestGrade, transfereeLowest, program, gradYear, signature, picture, COC, isRead, CRstatus, DHstatus, CDstatus)
            VALUES ('$appid', '$durationID', '$RAstaffID', '$apptype', '$appdate', '$studnum', '$email', '$fname', '$mname', '$lname', '$sex', '$age', '$birthdate', '$birthplace', '$phonenum', '$address', '$shs', '$shsyear', '$shsaddress', '$osc', '$oscyear', '$oscaddress', '$admissiondate', '$onefirst', '$onesecond', '$onesummer', '$twofirst', '$twosecond', '$twosummer', '$threefirst', '$threesecond', '$threesummer', '$fourfirst', '$foursecond', '$foursummer', '$fivefirst', '$fivesecond', '$fivesummer', '$sixfirst', '$sixsecond', '$sixsummer', '$sevenfirst', '$sevensecond', '$sevensummer', '$eightfirst', '$eightsecond', '$eightsummer','$subone', '$unitone', '$subtwo', '$unittwo', '$subthree', '$unitthree', '$subfour', '$unitfour', '$subfive', '$unitfive', '$subsix', '$unitsix', '$subseven', '$unitseven', '$subeight', '$uniteight', '$totalunits', '$lowestgrade', '$transfereelowest', '$program', '$gradyear', '$signature_name', '$picture_name', '$coc_name', '$isread', '$crstatus', '$dhstatus', '$cdstatus')"
		) or die(mysqli_error($conn));
	?>
		<!-- SweetAlert CSS -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
		<!-- SweetAlert JS -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire({
					icon: 'success',
					title: 'Application Submitted Successfully!',
					showConfirmButton: false,
					timer: 1500
				}).then(function() {
					window.location = "index.php";
				});
			});
		</script>
<?php
	}
}
?>
<html>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

	.container {
		display: flex;
		flex-direction: column;
		align-items: center;
		max-width: 1200px;
		width: 100%;
		margin-top: 40px;
	}

	.container .row {
		width: 100%;
		position: relative;
		font-size: 12px;
		font-weight: bold;
	}

	.container .steps {
		display: flex;
		width: 88%;
		align-items: center;
		justify-content: space-between;
		position: relative;
	}

	.steps .circle {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 50px;
		width: 50px;
		color: #999;
		font-size: 22px;
		font-weight: 500;
		border-radius: 50%;
		background: #fff;
		border: 4px solid #e0e0e0;
		transition: all 200ms ease;
		transition-delay: 0s;
		z-index: 2;
	}

	.steps .circle.active {
		transition-delay: 100ms;
		border-color: #50C878;
		color: #50C878;
	}

	.steps .progress {
		position: absolute;
		height: 4px;
		width: 100%;
		background: #e0e0e0;
		z-index: 1;
	}

	.progress .bar {
		position: absolute;
		height: 100%;
		width: 0%;
		background: #50C878;
		transition: all 300ms ease;
	}

	.container .buttons {
		display: flex;
		gap: 20px;
	}

	.buttons button {
		padding: 8px 25px;
		background: #4070f4;
		border: none;
		border-radius: 8px;
		color: #fff;
		font-size: 16px;
		font-weight: 400;
		cursor: pointer;
		box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
		transition: all 200ms linear;
	}

	.buttons button:active {
		transform: scale(0.97);
	}

	.buttons button:disabled {
		background: #87a5f8;
		cursor: not-allowed;
	}

	.no-application {
		display: none;
		text-align: center;
		font-size: 20px;
		color: red;
		margin-top: 20px;
	}

	.centered-message {
		text-align: center;
		margin-top: 20px;
	}

	.card-header {
		color: green;
	}

	.text-center h1,
	h2 {
		color: green;
	}

	.text-green {
		color: green;
	}
</style>

<body>
	<?php include('includes/navbar.php'); ?>
	<?php include('includes/right_sidebar.php'); ?>
	<?php include('includes/icon_style.php'); ?>
	<div class="mobile-menu-overlay"></div>
	<br>
	<br>
	<div class="container1" style="width: 95%; margin: 0 auto;">
		<div class="pb-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						<img src="../vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-4">

						<?php $query = mysqli_query($conn, "select * from applicants where appID = '$session_id'") or die(mysqli_error($conn));
						$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome <div class="weight-600 font-30 text-green"><?php echo $row['firstName'] . " " . $row['lastName']; ?>,</div>
						</h4>
						<p class="font-18 max-width-600">We Roar As One!!!</p>
					</div>
					<div class="col-md-4">
						<?php
						$durationQuery = mysqli_query($conn, "SELECT startDate, deadline FROM duration WHERE id = '$session_duration_id'") or die(mysqli_error($conn));
						$row = mysqli_fetch_array($durationQuery);

						$startDate = date("F j, Y", strtotime($row['startDate']));
						$deadline = date("F j, Y", strtotime($row['deadline']));
						?>

						<h6 class="font-20 weight-500 mb-10 text-capitalize">
							Current Application Period
							<div class="weight-600 font-20 text-green"><?php echo $startDate . " - " . $deadline; ?></div>
						</h6>
					</div>

				</div>
			</div>
				<div class="card-box mb-30 pd-20" id="secondDiv" style="display: none">
					<button class="btn btn-sm btn-success mb-3" id="backButton">
						<i class="fa fa-home"></i> <strong>HOME</strong>
					</button>
					<div class="clearfix">
						<div class="pull-left">
							<h2 class="text-black h2">Application Form</h2>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="" enctype="multipart/form-data">
							<?php $query = mysqli_query($conn, "select * from applicants where appID = '$session_id'") or die(mysqli_error($conn));
							$row = mysqli_fetch_array($query);
							?>
							<section id="regad_section">
								<!-- Registration Adviser Selection -->
								<input type="hidden" name="durationID" id="durationID"  value=" <?php echo $session_duration_id; ?>" >
								<h4 class="text-green h4">Select Registration Adviser</h4>
								<div class="justify-content-center">
									<div class="form-group">
										<select class="custom-select form-control" id="RAstaffID" name="RAstaffID">
											<option disabled selected>Select Adviser</option>
											<?php
											// get tge program of the applicant
											// $loggedInProgramQuery = mysqli_query($conn, "SELECT program FROM applicants WHERE appID = '$session_id'") or die(mysqli_error($conn));

											$loggedInProgramQuery = mysqli_query($conn, "SELECT program FROM applicants WHERE appID = '$session_id'") or die(mysqli_error($conn));
											$programrow = mysqli_fetch_array($loggedInProgramQuery);
											$applicant_program = $programrow['program'];

											$RAquery = mysqli_query($conn, "SELECT *, CONCAT(firstName, ' ', lastName) AS name FROM staff WHERE program = '$applicant_program' ") or die(mysqli_error($conn));

											// Fetch and populate the dropdown menu with staff names and IDs
											while ($RArow = mysqli_fetch_assoc($RAquery)) {
												echo "<option value='" . $RArow['staffID'] . "'>" . $RArow['name'] . "</option>";
											}

											?>
										</select>
									</div>
								</div>
								<!-- Next button -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-success next-btn" id="regad_next">Next</button>
									</div>
								</div>
							</section>
							<section id="personal_info_section" style="display: none;">
								<!-- Personal Information -->
								<h4 class="text-green h4">Personal Information</h4>
								<p>* You can update the details in this section in the
									<a href="profile.php" style="font-weight: bold; color:green;">Edit Profile</a> Tab
								</p>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Name </label></strong>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" onblur="toTitleCase(this)" value=" <?php echo $row['firstName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Middle Name </label></strong>
											<input name="middlename" type="text" class="form-control" readonly required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['middleName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Last Name </label></strong>
											<input name="lastname" type="text" class="form-control" readonly required="true" autocomplete="off" onblur="toTitleCase(this)" value="<?php echo $row['lastName']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Student Number</label></strong>
											<input name="studnum" type="text" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $row['studNumber']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Sex</label></strong>
											<input name="sex" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['sex']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Date of Birth</label></strong>
											<input name="birthdate" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['birthDate']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Age</label></strong>
											<input name="age" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['age']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Phone Number</label></strong>
											<input name="phonenum" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['phoneNumber']; ?>">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Email</label></strong>
											<input name="email" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['email']; ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<strong><label>Place of Birth</label></strong>
											<input name="birthplace" type="text" class="form-control" autocomplete="off" onblur="toTitleCase(this)" readonly value="<?php echo $row['birthPlace']; ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<strong><label>Permanent Address</label></strong>
											<input name="address" type="text" class="form-control" required="true" autocomplete="off" onblur="toTitleCase(this)" readonly value="<?php echo $row['address']; ?>">
										</div>
									</div>
								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="personal_info_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="personal_info_next">Next</button>
									</div>
								</div>
							</section>

							<section id="educational_background_section" style="display: none;">
								<!-- Educational Background -->
								<h4 class="text-green h4">Educational Background</h4>
								<div class="row">
									<div class="col-md-5 col-sm-12">
										<div class="form-group">
											<strong><label>Senior Highschool</label></strong>
											<input name="shs" type="text" class="form-control" placeholder="Enter Schoolname" autocomplete="off" onblur="toTitleCase(this)">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label>Year Attended</label></strong>
											<input name="shsyear" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="form-group">
											<strong><label>Address</label></strong>
											<input name="shsaddress" type="text" class="form-control" placeholder="Barangay, Municipality/City, Province" autocomplete="off" onblur="toTitleCase(this)">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5 col-sm-12">
										<div class="form-group">
											<strong><label>School/College attended other than Cavite State University</label></strong>
											<input name="osc" type="text" placeholder="Enter Schoolname" class="form-control" autocomplete="off" onblur="toTitleCase(this)">
										</div>
									</div>
									<div class="col-md-2 col-sm-12">
										<div class="form-group">
											<strong><label for="oscyear">Year Attended</label></strong>
											<input name="oscyear" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="form-group">
											<strong><label>Address</label></strong>
											<input name="oscaddress" type="text" class="form-control" placeholder="Barangay, Municipality/City, Province" autocomplete="off" onblur="toTitleCase(this)">
										</div>
									</div>
								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="educational_background_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="educational_background_next">Next</button>
									</div>
								</div>
							</section>

							<section id="admission_dates_section" style="display: none;">
								<!-- Admission Dates -->
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<strong><label>
													<h4 class="text-green h4">Date of Admission to CvSU</h4>
												</label></strong>
											<input name="admissiondate" type="text" class="form-control" placeholder="MONTH, YEAR" required="true" autocomplete="off" style="text-transform: uppercase;">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester *</label></strong>
											<input name="onefirst" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester *</label></strong>
											<input name="onesecond" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="onesummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester *</label></strong>
											<input name="twofirst" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester *</label></strong>
											<input name="twosecond" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="twosummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester *</label></strong>
											<input name="threefirst" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester *</label></strong>
											<input name="threesecond" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="threesummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester *</label></strong>
											<input name="fourfirst" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester *</label></strong>
											<input name="foursecond" type="text" class="form-control" placeholder="YYYY-YYYY" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="foursummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester</label></strong>
											<input name="fivefirst" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester</label></strong>
											<input name="fivesecond" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="fivesummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester</label></strong>
											<input name="sixfirst" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester</label></strong>
											<input name="sixsecond" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="sixsummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester</label></strong>
											<input name="sevenfirst" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester</label></strong>
											<input name="sevensecond" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="sevensummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>First Semester</label></strong>
											<input name="eightfirst" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Second Semester</label></strong>
											<input name="eightsecond" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<strong><label>Summer</label></strong>
											<input name="eightsummer" type="text" class="form-control" placeholder="YYYY-YYYY" autocomplete="off">
										</div>
									</div>
								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="admission_dates_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="admission_dates_next">Next</button>
									</div>
								</div>
							</section>

							<section id="subjects_section" style="display: none;">
								<!-- Subjects Currently Enrolled -->
								<div class="row">
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label>
												<h6 class="text-black h6">SUBJECTS CURRENTLY ENROLLED</h6>
											</label>
											<input name="subone" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subtwo" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subthree" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subfour" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subfive" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subsix" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subseven" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
											<input name="subeight" type="text" class="form-control" autocomplete="off" placeholder="Course Code - Course Name">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>
												<h6 class="text-black h6">UNITS</h6>
											</label>
											<select name="unitone" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unittwo" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unitthree" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unitfour" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unitfive" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unitsix" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="unitseven" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
											<select name="uniteight" class="custom-select form-control" autocomplete="off" onchange="calculateTotalUnits()">
												<option value=""></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
											</select>
										</div>
									</div>
									<div class="col-md-8 col-sm-12">
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>
												<h6 class="text-green h6">TOTAL UNITS</h6>
											</label>
											<input name="totalunits" type="number" min="1" max="36" class="form-control" autocomplete="off" readonly value="">
										</div>
									</div>

									<script>
										function calculateTotalUnits() {
											// Get values from input fields
											var unitone = parseInt(document.getElementsByName("unitone")[0].value) || 0;
											var unittwo = parseInt(document.getElementsByName("unittwo")[0].value) || 0;
											var unitthree = parseInt(document.getElementsByName("unitthree")[0].value) || 0;
											var unitfour = parseInt(document.getElementsByName("unitfour")[0].value) || 0;
											var unitfive = parseInt(document.getElementsByName("unitfive")[0].value) || 0;
											var unitsix = parseInt(document.getElementsByName("unitsix")[0].value) || 0;
											var unitseven = parseInt(document.getElementsByName("unitseven")[0].value) || 0;
											var uniteight = parseInt(document.getElementsByName("uniteight")[0].value) || 0;

											// Calculate total units
											var totalUnits = unitone + unittwo + unitthree + unitfour + unitfive + unitsix + unitseven + uniteight;

											// Update totalunits input field
											if (totalUnits === 0) {
												document.getElementsByName("totalunits")[0].value = '';
											} else {
												document.getElementsByName("totalunits")[0].value = totalUnits;
											}
										}
									</script>

								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="subjects_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="subjects_next">Next</button>
									</div>
								</div>
							</section>

							<section id="latin_honors_section" style="display: none;">
								<!-- Latin Honors Application -->
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<strong><label>Applying for Latin Honors? *</label></strong>
											<select id="apptype" name="apptype" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select</option>
												<option value="For Latin Honors">Yes</option>
												<option value="Ordinary Application">No</option>
											</select>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<strong><label>If Yes, please indicate the lowest grade obtained in CvSU</label></strong>
											<select id="lowestgrade" name="lowestgrade" class="custom-select form-control" autocomplete="off" disabled>
												<option value="">Select</option>
												<option value="1.00">1.00</option>
												<option value="1.25">1.25</option>
												<option value="1.50">1.50</option>
												<option value="1.75">1.75</option>
												<option value="2.00">2.00</option>
												<option value="2.25">2.25</option>
												<option value="2.50">2.50</option>
											</select>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<strong><label>For transferee, kindly indicate the lowest grade obtained from the previous school</label></strong>
											<select id="transfereelowest" name="transfereelowest" class="custom-select form-control" autocomplete="off" disabled>
												<option value="">Select</option>
												<option value="1.00">1.00</option>
												<option value="1.25">1.25</option>
												<option value="1.50">1.50</option>
												<option value="1.75">1.75</option>
												<option value="2.00">2.00</option>
												<option value="2.25">2.25</option>
												<option value="2.50">2.50</option>
											</select>
										</div>
									</div>
								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="latin_honors_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="latin_honors_next">Next</button>
									</div>
								</div>
							</section>

							<script>
								// Function to clear error or success messages
								function clearMessages(input) {
									// Clear error or success messages
									input.classList.remove('showError');
									input.classList.remove('showSuccess');
									input.classList.remove('is-invalid'); // Also removing 'is-invalid' class
									input.classList.remove('is-valid');
								}
								document.addEventListener('DOMContentLoaded', function() {
									const apptype = document.getElementById('apptype');
									const lowestgrade = document.getElementById('lowestgrade');
									const transfereelowest = document.getElementById('transfereelowest');

									apptype.addEventListener('change', function() {
										if (apptype.value === 'For Latin Honors') {
											lowestgrade.disabled = false;
											transfereelowest.disabled = false;
										} else {
											lowestgrade.disabled = true;
											lowestgrade.value = '';
											clearMessages(lowestgrade); // Set value to empty string
											transfereelowest.disabled = true;
											transfereelowest.value = ''; // Set value to empty string
											clearMessages(transfereelowest);
										}
									});
								});
							</script>

							<section id="upload_files_section" style="display: none;">
								<!-- Upload Necessary Files -->
								<h5 class="text-green h5">Upload Necessary Files</h5>
								<div class="row">
									<div class="col-md-12 col-sm-12 mb-1">
										<strong><label for="signatureInput" class="form-label">Signature (PNG only) *</label></strong>
										<div class="input-group">
											<input type="file" accept=".png" class="form-control custom-file-input" id="signatureInput" name="signature">
											<label class="custom-file-label" for="signatureInput">Choose file</label>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 mb-1">
										<strong><label for="pictureInput" class="form-label">2x2 ID Picture (PNG or JPG) *</label></strong>
										<div class="input-group">
											<input type="file" accept=".png, .jpg, .jpeg" class="form-control custom-file-input" id="pictureInput" name="picture">
											<label class="custom-file-label" for="pictureInput">Choose file</label>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 mb-1">
										<strong><label for="cocInput" class="form-label">Checklist of Courses (Scanned PDF Copy) *</label></strong>
										<div class="input-group">
											<input type="file" accept=".pdf" class="form-control custom-file-input" id="cocInput" name="coc">
											<label class="custom-file-label" for="cocInput">Choose file</label>
										</div>
									</div>
								</div>
								<!-- Previous and Next buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary mr-2" id="upload_files_prev">Previous</button>
										<button type="button" class="btn btn-success next-btn" id="upload_files_next">Next</button>
									</div>
								</div>
							</section>

							<section id="submission_section" style="display: none;">
								<?php $query = mysqli_query($conn, "select * from applicants LEFT JOIN programs ON applicants.program = programs.ProgramShortName where appID = '$session_id'") or die(mysqli_error($conn));
								$row = mysqli_fetch_array($query);
								$query1 = mysqli_query($conn, "select * from duration WHERE id = '$session_duration_id'") or die(mysqli_error($conn));
								$row1 = mysqli_fetch_array($query1);
								?>
								<!-- Submission -->
								<h4 class="text-green h4">Application Submission</h4>
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<br>
										<h6 class="text-black">
											I have the honor to apply for graduation in the course leading to the degree of
											<input id="programInput" name="program" type="text" readonly style="border: none; width: auto; white-space: nowrap; overflow: visible;" class="text-green" value="<?php echo htmlspecialchars($row['ProgramName']); ?>">
											this Graduation
											<input name="gradYear" type="text" readonly style="border: none; width: auto; white-space: nowrap; overflow: visible;" class="text-green" value="<?php echo htmlspecialchars($row1['gradYear']); ?>"> .
										</h6>
										<br>
										<h6 class="text-black">
											It is understood that I shall be entitled to a diploma / certificate / award if and after I have satisfactorily completed all the requirements for graduation including but not limited to the submission of my bound manuscript / special problem / narrative reports and clearance for my graduation in this University.
										</h6>
										<br>
										<hr>
										<br>
									</div>
								</div>
								<!-- Previous and Submit buttons -->
								<div class="row">
									<div class="col-md-12 col-sm-12 d-flex justify-content-center">
										<button type="button" class="btn btn-secondary prev-btn mr-2" id="submission_prev">Review Form</button>
										<button type="submit" class="btn btn-success" name="apply" id="apply">Submit Application</button>
										<br>
									</div>
								</div>
								<script>
									var input = document.getElementById('programInput');
									input.style.width = ((input.value.length + 1) * 8) + 'px'; // Adjust the multiplier (8) as needed for proper sizing
									input.addEventListener('input', function() {
										this.style.width = ((this.value.length + 1) * 8) + 'px'; // Adjust the multiplier (8) as needed for proper sizing
									});
								</script>
							</section>
						</form>
					</div>
				</div>

			<?php if (!$applicationExist) : ?>
				<div class="card-box mb-30" id="firstDiv">
					<div class="container mt-3">
						<div class="row">
							<div class="col-md-12 text-center pd-30">
								<h1>Welcome to the Graduation Management System</h1>
								<p>Follow the instructions below to successfully complete and submit your graduation application along with the necessary requirements.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card mt-0">
									<div class="card-header">
										<strong>Step 1: Access the Application Form</strong>
									</div>
									<div class="card-body">
										<ol>
											<li><strong class="text-green">1)</strong> Login to App4Grad using your university credentials.</li>
											<li><strong class="text-green">2)</strong> Read instructions carefully.</li>
											<li><strong class="text-green">3)</strong> Click on <strong class="text-green">Apply for Graduation</strong> button below to access the application form.</li>
										</ol>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 my-4">
								<div class="card">
									<div class="card-header">
										<strong>Step 2: Fill Out the Application Form</strong>
									</div>
									<div class="card-body">
										<p>Complete all sections of the form. Ensure the information you provide is accurate and up-to-date.</p>
										<ol>
											<li>1)<strong class="text-green"> Select Registration Adviser</strong></li>
											<li>2)<strong class="text-green"> Personal Background</strong>(Information are fetched from your registration, you can edit details in account settings)</li>
											<li>3)<strong class="text-green"> Educational Background</strong></li>
											<li>4)<strong class="text-green"> Admission Dates</strong></li>
											<li>5)<strong class="text-green"> Subjects Currently Enrolled</strong></li>
											<li>6)<strong class="text-green"> Latin Honors Application</strong>(Optional)</li>
										</ol>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 my-4">
								<div class="card">
									<div class="card-header">
										<strong>Step 3: Attach Required Documents</strong>
									</div>
									<div class="card-body">
										<p>Prepare and upload the following documents:</p>
										<ul>
											<li>
												1)<strong class="text-green"> E-Signature:</strong> Applicant's signature, must be a png file and no background.
											</li>
											<li>
												2)<strong class="text-green"> ID Picture:</strong> 2x2 Ratio, must be png or jpg and on white background.
											</li>
											<li>
												3)<strong class="text-green"> Checklist of Courses:</strong> A PDF Scanned Copy of the Up to Date Checklist of Courses.
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 my-4">
								<div class="card">
									<div class="card-header">
										<strong>Step 4: Review and Submit</strong>
									</div>
									<div class="card-body">
										<ol>
											<li>1)<strong class="text-green"> Review</strong> all entered information and uploaded documents for accuracy.</li>
											<li>2)<strong class="text-green"></strong> Click the <strong class="text-green">Submit</strong> button to finalize your application.</li>
										</ol>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 my-4">
								<div class="card">
									<div class="card-header">
										<strong>Step 5: Track and Follow-Up</strong>
									</div>
									<div class="card-body">
										<ol>
											<li>
												<strong class="text-green">Track Application Status:</strong> Regularly check the Graduation Management System for updates on your application status.
											</li>
											<li>
												<strong class="text-green">Respond to Requests:</strong> If additional information or corrections are needed, promptly respond to any requests from the college registrar.
											</li>
											<li>
												<strong class="text-green">Download your Copy:</strong> Once the application is approved you can download the PDF Copy of your Application Form signed by the four signatories.
											</li>
										</ol>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 my-4">
								<div class="card">
									<div class="card-header">
										<strong> IMPORTANT NOTES </strong>
									</div>
									<div class="card-body">
										<ul>
											<li><strong class="text-green">Deadline:</strong> Ensure that you submit your application before the stated deadline. Late submissions are not considered.</li>
											<li><strong class="text-green">Accuracy:</strong> Providing false or inaccurate information can result in denial of your graduation application.</li>
											<li><strong class="text-green">Support:</strong> If you encounter any issues or have questions, contact the College Registrar at <a href="https://cvsu.edu.ph/">www.cvsu.edu.ph</a>.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 text-center pd-30">
								<h2>Congratulations on reaching this milestone!</h2>
								<p>We look forward to celebrating your achievements at the upcoming graduation ceremony.</p>
							</div>
						</div>
					</div>
					<hr>
					<?php
					$currentDate = date('Y-m-d');

					$query = mysqli_query($conn, "SELECT * FROM duration WHERE id = '$session_duration_id'") or die(mysqli_error($conn));

					if (mysqli_num_rows($query) > 0) {
						$row = mysqli_fetch_assoc($query);
						if ($row['startDate'] <= $currentDate && $row['deadline'] >= $currentDate) {
							// Application is open
					?>
							<div class="container mt-3">
								<div class="text-center pd-30">
									<input type="checkbox" id="termsCheckbox" onclick="toggleButton()">
									<label for="termsCheckbox"><strong> I have read the instructions and I want to proceed.</strong></label>
									<br>
									<button class="btn btn-lg text-white btn-success mt-3" id="applyButton" style="display:none;"><strong>APPLY FOR GRADUATION</strong></button>
								</div>
							</div>

							<script>
								function toggleButton() {
									var checkbox = document.getElementById("termsCheckbox");
									var button = document.getElementById("applyButton");
									button.style.display = checkbox.checked ? "block" : "none";
								}
							</script>
					<?php
						} else {
							if ($row['startDate'] > $currentDate) {
								echo "<h5 class='text-center pd-30'><strong>The Application for Graduation is not yet open.</strong></h5>";
							} elseif ($row['deadline'] < $currentDate) {
								echo "<h5 class='text-center pd-30'><strong>The Application for Graduation is already closed.</strong></h5>";
							}
						}
					}
					?>


				</div>

				
			<?php endif; ?>
			

			<?php if ($applicationExist) : ?>
				<div class="card-box mb-30" id="appProgress">
					<div class="pd-20">
						<h2 class="text-blue h4">APPLICATION PROGRESS</h2>

						<?php
						$query = mysqli_query($conn, "SELECT * FROM application WHERE appID = '$session_id'") or die(mysqli_error($conn));
						?>

						<div class="container">
							<div class="steps">
								<span id="circle1" class="circle"><i class="fa fa-clock-o"></i></span>
								<span id="circle2" class="circle"><i class="fa fa-clock-o"></i></span>
								<span id="circle3" class="circle"><i class="fa fa-clock-o"></i></span>
								<span id="circle4" class="circle"><i class="fa fa-clock-o"></i></span>
								<span id="circle5" class="circle"><i class="fa fa-clock-o"></i></span>
								<?php
								$row = mysqli_fetch_array($query);
								if ($row['RAstatus'] == '1' && $row['DHstatus'] == '1' && $row['CRstatus'] == '1' && $row['CDstatus'] == '1') {
									echo '<span id="circle6" class="circle" style="line-height: 75px; font-size: 24px; border-radius: 50%; cursor: pointer;" ';
									echo 'onclick="window.open(\'pdf.php\', \'_blank\')" ';
									echo 'onmouseover="this.style.backgroundColor=\'#50C878\'; this.style.color=\'#fff\';" ';
									echo 'onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'\';">';
									echo '<i class="fa fa-clock-o"></i>';
									echo '</span>';
								} else {
									echo '<span id="circle6" class="circle"><i class="fa fa-clock-o"></i></span>';
								}
								?>

								<div class="progress">
									<span class="bar"></span>
								</div>
							</div>

							<div class="row justify-content-center text-center mt-4">
								<span class="col-md-2 col-sm-12">Application Submitted</span>
								<span class="col-md-2 col-sm-12">Registration Adviser</span>
								<span class="col-md-2 col-sm-12">College Registrar</span>
								<span class="col-md-2 col-sm-12">Department Head</span>
								<span class="col-md-2 col-sm-12">College Dean</span>
								<span class="col-md-2 col-sm-12">Application Completed</span>
							</div>

							<div class="row justify-content-center text-center">
								<?php
								$sql = "SELECT * from application where appID = '$session_id'";
								$query = $dbh->prepare($sql);
								$query->execute();
								$results = $query->fetchAll(PDO::FETCH_OBJ);

								foreach ($results as $result) { ?>
									<span id="appdate" class="col-md-2 col-sm-12"><?php echo htmlentities($result->appDate); ?></span>
									<span id="RAstatus" class="col-md-2 col-sm-12">
										<?php
										$stats = $result->RAstatus;
										if ($stats == 1) { ?>
											<span style="color: green">Approved</span>
										<?php } elseif ($stats == 2) { ?>
											<span style="color: red">Not Approved</span>
										<?php } else { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</span>
									<span id="CRstatus" class="col-md-2 col-sm-12">
										<?php
										$stats = $result->CRstatus;
										$stats1 = $result->RAstatus;
										if ($stats == 1 && $stats1 == 1) { ?>
											<span style="color: green">Approved</span>
										<?php } elseif ($stats == 2) { ?>
											<span style="color: red">Not Approved</span>
										<?php } elseif ($stats1 == 2) { ?>
											<span style="color: red"> </span>
										<?php } else { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</span>
									<span id="DHstatus" class="col-md-2 col-sm-12">
										<?php
										$stats = $result->DHstatus;
										$stats1 = $result->RAstatus;
										$stats2 = $result->CRstatus;
										if ($stats == 1 && $stats1 == 1 && $stats2 == 1) { ?>
											<span style="color: green">Approved</span>
										<?php } elseif ($stats == 2) { ?>
											<span style="color: red">Not Approved</span>
										<?php } elseif ($stats1 == 2 || $stats2 == 2) { ?>
											<span style="color: red"> </span>
										<?php } else { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</span>
									<span id="CDstatus" class="col-md-2 col-sm-12">
										<?php
										$stats = $result->CDstatus;
										$stats1 = $result->RAstatus;
										$stats2 = $result->CRstatus;
										$stats3 = $result->DHstatus;
										if ($stats == 1 && $stats1 == 1 && $stats2 == 1 && $stats3 == 1) { ?>
											<span style="color: green">Approved</span>
										<?php } elseif ($stats == 2) { ?>
											<span style="color: red">Not Approved</span>
										<?php } elseif ($stats1 == 2 || $stats2 == 2 || $stats3 == 2) { ?>
											<span style="color: red"> </span>
										<?php } else { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</span>
									<span id="CDstatus" class="col-md-2 col-sm-12">
										<?php
										$stats = $result->CDstatus;
										if ($stats == 1) { ?>
											<span style="color: green">Download Form</span>
										<?php } ?>
									</span>
								<?php } ?>
							</div>
							<br>
							<br>
							<div class="row">
								<span class="col-md-6 col-sm-12">
									<h6 class="text-blue">Registration Remarks:</h6>
								</span>
							</div>
							<br>
							<div class="row">
								<?php
								$sql = "SELECT * from application where appID = '$session_id'";
								$query = $dbh->prepare($sql);
								$query->execute();
								$results = $query->fetchAll(PDO::FETCH_OBJ);

								foreach ($results as $result) { ?>
									<span id="RAremark" class="col-md-2 col-sm-12">
										<?php
										$status = $result->RAremark;
										if ($status == '') { ?>
											<span>None</span>
										<?php } else { ?>
											<span><?php echo htmlentities($result->RAremark); ?></span>
										<?php } ?>
									</span>
								<?php } ?>
							</div>
							<br>
							<br>
							<div class="row justify-content-center ml-3 text-center">
								<a href="viewonly_application.php" class="btn btn-success mr-3 ">
									<i class="fa fa-eye"></i> View Application
								</a>
								<?php if ($result->RAstatus == 2) : ?>
									<a href="#" class="btn btn-success mt-2" id="reApplyButton">
										<i class=""></i> Re-Apply
									</a>
								<?php endif; ?>

							</div>

						</div>
					</div>
				</div>
			<?php endif; ?>



		</div>
		<?php include('includes/footer.php'); ?>
	</div>

	<?php include('includes/validation_script.php'); ?>
	<?php include('includes/scripts.php') ?>
	<script>
		const circles = document.querySelectorAll(".circle");
		const progressBar = document.querySelector(".bar");
		const appdate = document.getElementById('appdate') ? document.getElementById('appdate').innerText.trim() : '';

		let currentStep = 1;

		const updateSteps = () => {
			const RAstatus = document.getElementById('RAstatus') ? document.getElementById('RAstatus').innerText.trim() : '';
			const CRstatus = document.getElementById('CRstatus') ? document.getElementById('CRstatus').innerText.trim() : '';
			const DHstatus = document.getElementById('DHstatus') ? document.getElementById('DHstatus').innerText.trim() : '';
			const CDstatus = document.getElementById('CDstatus') ? document.getElementById('CDstatus').innerText.trim() : '';

			if (appdate !== '') {
				circles[0].classList.add("active");
				circles[0].innerHTML = '<i class="fa fa-check"></i>';
				progressBar.style.width = `${(currentStep / (circles.length - 1)) * 100}%`;
			} else {
				circles[0].classList.remove("active");
				circles[0].innerHTML = '<i class="fa fa-clock-o"></i>';
			}

			if (RAstatus === 'Approved') {
				currentStep = 2;
			} else if (RAstatus === 'Not Approved') {
				currentStep = 2;
			}
			if (CRstatus === 'Approved') {
				currentStep = 3;
			} else if (CRstatus === 'Not Approved') {
				currentStep = 3;
			}
			if (DHstatus === 'Approved') {
				currentStep = 4;
			} else if (DHstatus === 'Not Approved') {
				currentStep = 4;
			}
			if (CDstatus === 'Approved') {
				currentStep = 6;
			} else if (CDstatus === 'Not Approved') {
				currentStep = 5;
			}

			progressBar.style.width = `${((currentStep - 1) / (circles.length - 1)) * 100}%`;

			circles.forEach((circle, index) => {
				circle.classList.remove("active");
				if (index < currentStep) {
					if (index === 1 && RAstatus === 'Not Approved') {
						circle.innerHTML = '<i class="fa fa-times" style="color: red;"></i>';
					} else if (index === 2 && CRstatus === 'Not Approved') {
						circle.innerHTML = '<i class="fa fa-times" style="color: red;"></i>';
					} else if (index === 3 && DHstatus === 'Not Approved') {
						circle.innerHTML = '<i class="fa fa-times" style="color: red;"></i>';
					} else if (index === 4 && CDstatus === 'Not Approved') {
						circle.innerHTML = '<i class="fa fa-times" style="color: red;"></i>';
					} else if (index === 5) {
						circle.innerHTML = '<i class="fa fa-download"></i>'; // Change to download icon
					} else {
						circle.innerHTML = '<i class="fa fa-check"></i>';
					}
				} else {
					circle.innerHTML = '<i class="fa fa-clock-o"></i>';
				}
			});

			for (let i = 0; i < currentStep; i++) {
				circles[i].classList.add("active");
			}
		};

		if (appdate !== '') {
			updateSteps();
		}
	</script>
	<script>
		$(document).ready(function() {
			$("#applyButton").click(function() {
				console.log('button clicked');
				$("#firstDiv").hide();
				$("#secondDiv").show();
			});

			$("#reApplyButton").click(function() {
				$("#appProgress").hide(); // Assuming appProgress is the ID of the application progress div
				$("#secondDiv").show();
			});

			$("#backButton").click(function() {
				location.reload(); // This will reload the page
			});
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