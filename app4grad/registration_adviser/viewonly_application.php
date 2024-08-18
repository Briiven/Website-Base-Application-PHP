<?php error_reporting(0); ?>
<?php include('includes/header.php') ?>
<?php include('../includes/session.php') ?>


<style>
    input[type="text"] {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    .btn-outline:hover {
        color: #fff;
        background-color: #524d7d;
        border-color: #524d7d;
    }

    textarea {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    textarea.text_area {
        height: 8em;
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }
</style>

<body>

    <?php include('includes/navbar.php') ?>

    <?php include('includes/right_sidebar.php') ?>

    <?php include('includes/left_sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>APPLICATION DETAILS</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Application</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Application Details</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <form method="post" action="">

                        <?php
                        if (!isset($_GET['appid']) && empty($_GET['appid'])) {
                            header('Location: index.php');
                        } else {

                            $lid = intval($_GET['appid']);
                            $sql = "SELECT application.id as lid,application.appType, application.appDate, application.isRead, application.RAstatus, application.CRstatus, application.DHstatus, application.CDstatus, application.RAremark, application.RAremarkDate, application.CRremarkDate, application.DHremarkDate, application.CDremarkDate, application.studNum, application.email, application.firstName, application.middleName, application.lastName, application.sex, application.age, application.birthDate, application.birthPlace, application.phoneNumber, application.address, application.shs, application.shsYear, application.shsAddress, application.osc, application.oscYear, application.oscAddress, application.admissionDate, application.1First, application.1Second, application.1Summer, application.2First, application.2Second, application.2Summer, application.3First, application.3Second, application.3Summer, application.4First, application.4Second, application.4Summer, application.5First, application.5Second, application.5Summer, application.6First, application.6Second, application.6Summer, application.7First, application.7Second, application.7Summer, application.8First, application.8Second, application.8Summer, application.sub1, application.unit1, application.sub2, application.unit2, application.sub3, application.unit3, application.sub4, application.unit4, application.sub5, application.unit5, application.sub6, application.unit6, application.sub7, application.unit7, application.sub8, application.unit8, application.totalUnits, application.lowestGrade, application.transfereeLowest, application.program, application.gradYear, application.signature, application.picture, application.COC from application join applicants on application.appID=applicants.appID where application.id=:lid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) {
                        ?>
                                    <h4 class="text-black h4">Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->firstName); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->middleName); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->lastName); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group">
                                                <label>Student Number</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->studNum); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sex); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group">
                                                <label>Birth Date</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->birthDate); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->age); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->phoneNumber); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->email); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Place of Birth</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->birthPlace); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Permanent Address</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->address); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="text-black h4">Educational Background</h4>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label>Senior Highschool</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->shs); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group">
                                                <label>Year Attended</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->shsYear); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->shsAddress); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label>School/College attended other than Cavite State University</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->osc); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group">
                                                <label>Year Attended</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->oscYear); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->oscAddress); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>
                                                    <h4 class="text-black h4">Date of Admission to CvSU</h4>
                                                </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->admissionDate); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'1First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'1Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'1Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'2First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'2Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'2Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'3First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'3Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'3Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'4First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'4Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'4Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'5First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'5Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'5Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'6First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'6Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'6Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'7First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'7Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'7Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'8First'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Second Semester</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'8Second'}); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Summer</label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->{'8Summer'}); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-12">
                                            <div class="form-group">
                                                <label>
                                                    <h6 class="text-black h6">SUBJECTS CURRENTLY ENROLLED</h6>
                                                </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub1); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub2); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub3); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub4); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub5); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub6); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub7); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->sub8); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>
                                                    <h6 class="text-black h6">UNITS</h6>
                                                </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit1); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit2); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit3); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit4); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit5); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit6); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit7); ?>">
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->unit8); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>
                                                    <h6 class="text-black h6">TOTAL UNITS</h6>
                                                </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->totalUnits); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Applying for Latin Honors? </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->appType); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>If Yes, please indicate the lowest grade obtained in CvSU </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->lowestGrade); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label>For transferee, kindly indicate the lowest grade obtained from the previous school </label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->transfereeLowest); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="text-black h5">Uploaded Files</h5>
                                    <div class="row">
                                        <!-- Picture Button -->
                                        <div class="col-md-4 col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#pictureModal">Picture</button>
                                        </div>
                                        <!-- Signature Button -->
                                        <div class="col-md-4 col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#signatureModal">Signature</button>
                                        </div>
                                        <!-- COC Button -->
                                        <div class="col-md-4 col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#cocModal">Checklist of Courses</button>
                                        </div>
                                    </div>

                                    <!-- Picture Modal -->
                                    <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="pictureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pictureModalLabel">Picture</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="../applicant/uploads/<?php echo htmlentities($result->picture); ?>" alt="Picture Image" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Signature Modal -->
                                    <div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="signatureModalLabel">Signature</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="../applicant/uploads/<?php echo htmlentities($result->signature); ?>" alt="Signature Image" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- COC Modal -->
                                    <div class="modal fade" id="cocModal" tabindex="-1" role="dialog" aria-labelledby="cocModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document" style="width: 100%; height: 1000px;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cocModalLabel">Checklist of Courses</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="width:100% ; height: 100%;">
                                                    <iframe src="../applicant/uploads/<?php echo htmlentities($result->COC); ?>" style="width: 100%; height: 1000px; border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                        <?php }
                            }
                        } ?>
                    </form>
                </div>

            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('includes/scripts.php') ?>
</body>

</html>