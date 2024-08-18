<?php

//6-3-2024 added the condition of check and cross mark on the latin honors - atienza
//6-4-2024 added the variables for first,middle,last name of student to be adjusted together and added a condition where 0 value is present, it will be hidden on the current enrolled tab

include('../includes/session.php');

require_once('./dompdf/autoload.inc.php');

use Dompdf\Dompdf;

// DATA FROM DATABASE

$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "app4grad"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        div.aaa {
            line-height: 0;
            text-align: center;
        }

        div.aaaa {
            line-height: 0.2;
        }

        div.aa {
            font-family: 'Gothic', monospace;
            text-align: center;
        }

        div.a {
            text-align: center;
            font-size: 13.7px;
            font-family: Helvetica;

        }

        div.b {
            line-height: 0;
            font-family: Helvetica;


        }

        div.c {
            text-align: right;
            font-size: 12px;
            font-family: Helvetica;
        }

        div.d {

            font-size: 12px;
            font-family: Helvetica;

        }

        div.da {
            position: absolute;
            top: 305px;
        }

        div.daa {
            position: absolute;
            top: 820px;
            left: 0px;
        }


        div.e {
            text-align: right;
            font-size: 12px;
            font-family: Helvetica;
        }

        div.r {
            position: absolute;
            padding: 10px;
            right: 0;
            width: 260px;
            height: 65px;
            border: 1px solid blue;
            top: 530px;
        }

        div.rr {
            position: absolute;
            right: 0;

        }

        div.header {
            position: absolute;
            right: 0;
            float: right;
            font-size: 9px;
            font-style: italic;
            color: gray;
            font-family: Helvetica;
            top: -25px;
        }

        div.rrr {
            font-size: 12px;
            font-family: Helvetica;
        }

        pre {
            font-family: Helvetica;
        }

        span.a {
            display: inline-block;
            width: 100px;
            height: 100px;
            padding: 5px;
            border: 1px solid blue;
            background-color: yellow;

        }

        #a1 {
            text-indent: 4em;
            font-size: 12px;
            font-family: Helvetica;
        }

        #a2 {

            font-size: 12px;
            font-family: Helvetica;
        }

        .column {

            position: absolute;

        }

        .column1 {

            position: absolute;
            top: 800px;
            right: 50px;


        }

        .column1a {

            position: absolute;
            top: 800px;
            right: 50px;


        }

        .little {
            font-size: 5px;
            font-family: Helvetica;
        }
    </style>
</head>

<?php

$imagePath = 'uploads\cvsu.png';
$imageData = base64_encode(file_get_contents($imagePath));
$mimeType = mime_content_type($imagePath);
$base64ImageLogo = 'data:' . $mimeType . ';base64,' . $imageData;

$imagePath = 'uploads\check.png';
$imageData = base64_encode(file_get_contents($imagePath));
$mimeType = mime_content_type($imagePath);
$base64checkLogo = 'data:' . $mimeType . ';base64,' . $imageData;

$imagePath = 'uploads\cross.png';
$imageData = base64_encode(file_get_contents($imagePath));
$mimeType = mime_content_type($imagePath);
$base64crossLogo = 'data:' . $mimeType . ';base64,' . $imageData;

?>



<!-- To get data from database -->
<?php
if (isset($_GET['selectedAppIds'])) {
    $selectedAppIds = explode(",", $_GET['selectedAppIds']);

    foreach ($selectedAppIds as $appid) {

        // Proceed with the rest of your code
        $query = mysqli_query($conn, "SELECT * FROM application WHERE appID = '$appid'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($query);
        $RAstaffID = $row['RAstaffID'];


        // get tge program of the applicant
        $query2 = mysqli_query($conn, "SELECT program FROM applicants WHERE appID = '$appid'") or die(mysqli_error($conn));
        $datarow = mysqli_fetch_array($query2);
        $applicant_program = $datarow['program'];

        if (in_array($applicant_program, ['BSOA', 'BSIT', 'BSCS'])) {
            $applicant_department = 'DIT';
        } elseif (in_array($applicant_program, ['BSIE', 'BSIND-AT', 'BSIND-ET', 'BSIND-ECT'])) {
            $applicant_department = 'DIET';
        } elseif (in_array($applicant_program, ['BSCPE', 'BSEE', 'BSECE'])) {
            $applicant_department = 'DCEEE';
        } elseif (in_array($applicant_program, ['BSCE', 'BSARCH'])) {
            $applicant_department = 'DCEA';
        } elseif (in_array($applicant_program, ['BSABE'])) {
            $applicant_department = 'DAFE';
        }

        // Get the registration adviser
        $query3 = mysqli_query($conn, "SELECT * FROM staff WHERE staffID = '$RAstaffID' ") or die(mysqli_error($conn));
        $regadviser = mysqli_fetch_array($query3);
        $firstNameRegAdviser = $regadviser['firstName'];
        $middleNameRegAdviser = $regadviser['middleName'];
        $lastNameRegAdviser = $regadviser['lastName'];
        $middleInitialRegAdviser = !empty($middleNameRegAdviser) ? substr($middleNameRegAdviser, 0, 1) . '.' : '';
        $signatureRegAdviser = $regadviser['signature'];


        // Get the department head
        $query4 = mysqli_query($conn, "SELECT * FROM staff WHERE role = 'Department Head' and department = '$applicant_department'") or die(mysqli_error($conn));
        $depthead = mysqli_fetch_array($query4);
        $firstNameDeptHead = $depthead['firstName'];
        $middleNameDeptHead = $depthead['middleName'];
        $lastNameDeptHead = $depthead['lastName'];
        $middleInitialDeptHead = !empty($middleNameDeptHead) ? substr($middleNameDeptHead, 0, 1) . '.' : '';
        $signatureDeptHead = $depthead['signature'];




        // Get the college registrar
        $query5 = mysqli_query($conn, "SELECT * FROM staff WHERE role = 'College Registrar'") or die(mysqli_error($conn));
        $colregistrar = mysqli_fetch_array($query5);
        $firstNameColRegistrar = $colregistrar['firstName'];
        $middleNameColRegistrar = $colregistrar['middleName'];
        $lastNameColRegistrar = $colregistrar['lastName'];
        $middleInitialColRegistrar = !empty($middleNameColRegistrar) ? substr($middleNameColRegistrar, 0, 1) . '.' : '';
        $signatureColRegistrar = $colregistrar['signature'];


        // Get the college registrar
        $query6 = mysqli_query($conn, "SELECT * FROM staff WHERE role = 'College Dean'") or die(mysqli_error($conn));
        $coldean = mysqli_fetch_array($query6);
        $firstNameColDean = $coldean['firstName'];
        $middleNameColDean = $coldean['middleName'];
        $lastNameColDean = $coldean['lastName'];
        $middleInitialColDean = !empty($middleNameColDean) ? substr($middleNameColDean, 0, 1) . '.' : '';
        $signatureColDean = $coldean['signature'];


        // Student
        $firstname1 = $row['firstName'];
        $middlename1 = $row['middleName'];
        $lastname1 = $row['lastName'];





        //Base64 images/signature
        $imageFilename = $row['picture'];
        $imageDirectory = 'C:/xampp/htdocs/app4grad/applicant/uploads/';
        $imagePath =  $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64ImagePicture = 'data:' . $mimeType . ';base64,' . $imageData;


        // signature of student
        $imageFilename = $row['signature'];
        $imageDirectory = 'C:/xampp/htdocs/app4grad/applicant/uploads/';
        $imagePath =  $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64ImageSignatureStudent = 'data:' . $mimeType . ';base64,' . $imageData;

        // signature of reg adviser
        $imageFilename = $signatureRegAdviser;
        $imageDirectory = 'C:/xampp/htdocs/app4grad/admin/uploads/';
        $imagePath = $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64SignatureRegAdviser = 'data:' . $mimeType . ';base64,' . $imageData;

        // signature of col registrar
        $imageFilename = $signatureColRegistrar;
        $imageDirectory = 'C:/xampp/htdocs/app4grad/admin/uploads/';
        $imagePath = $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64ImageSignatureColRegistrar = 'data:' . $mimeType . ';base64,' . $imageData;


        // signature of depthead registrar
        $imageFilename = $signatureDeptHead;
        $imageDirectory = 'C:/xampp/htdocs/app4grad/admin/uploads/';
        $imagePath = $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64ImageSignatureDeptHead = 'data:' . $mimeType . ';base64,' . $imageData;

        // signature of col dean
        $imageFilename =  $signatureColDean;
        $imageDirectory = 'C:/xampp/htdocs/app4grad/admin/uploads/';
        $imagePath = $imageDirectory . $imageFilename;
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);
        $base64ImageSignatureColDean = 'data:' . $mimeType . ';base64,' . $imageData;


?>

        <?php

        $picture = "";


        $lowestGrade = "";
        $transfereeLowest = "";




        $signature = "";

        $COC = "";


        $none = "";

        $yes = "";





        //studentnumber
        $studnumcharLimit = 16;
        $averageCharWidth = 9; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('studNum') * $averageCharWidth;
        $studnumunderlineWidth = $studnumcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $studnumfinalWidth = min($inputWidth, $studnumunderlineWidth);


        //firstname
        $firstnamecharLimit = 23;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('firstName') * $averageCharWidth;
        $firstnameunderlineWidth = $firstnamecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $firstnamefinalWidth = min($inputWidth, $firstnameunderlineWidth);


        //middlename
        $middlenamecharLimit = 11;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('middleName') * $averageCharWidth;
        $middlenameunderlineWidth = $middlenamecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $middlenamefinalWidth = min($inputWidth, $middlenameunderlineWidth);


        //lastname
        $lastnamecharLimit = 27;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('lastName') * $averageCharWidth;
        $lastnameunderlineWidth = $lastnamecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $lastnamefinalWidth = min($inputWidth, $lastnameunderlineWidth);


        //sex
        $sexcharLimit = 15;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('sex') * $averageCharWidth;
        $sexunderlineWidth = $sexcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $sexfinalWidth = min($inputWidth, $sexunderlineWidth);


        //age
        $agecharLimit = 21.08;
        $averageCharWidth = 3; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('age') * $averageCharWidth;
        $ageunderlineWidth = $agecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $agefinalWidth = min($inputWidth, $ageunderlineWidth);


        //birthDate
        $birthDatecharLimit = 29;
        $averageCharWidth = 11; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('birthDate') * $averageCharWidth;
        $birthDateunderlineWidth = $birthDatecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $birthDatefinalWidth = min($inputWidth, $birthDateunderlineWidth);


        //phoneNumber
        $phoneNumbercharLimit = 25.11;
        $averageCharWidth = 11; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('phoneNumber') * $averageCharWidth;
        $phoneNumberunderlineWidth = $phoneNumbercharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $phoneNumberfinalWidth = min($inputWidth, $phoneNumberunderlineWidth);


        //birthPlace
        $birthPlacecharLimit = 26.02;
        $averageCharWidth = 25; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('birthPlace') * $averageCharWidth;
        $birthPlaceunderlineWidth = $birthPlacecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $birthPlacefinalWidth = min($inputWidth, $birthPlaceunderlineWidth);


        //address
        $addresscharLimit = 29.32;
        $averageCharWidth = 21; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('address') * $averageCharWidth;
        $addressunderlineWidth = $addresscharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $addressfinalWidth = min($inputWidth, $addressunderlineWidth);


        //shs
        $shscharLimit = 22;
        $averageCharWidth = 19; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('shs') * $averageCharWidth;
        $shsunderlineWidth = $shscharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $shsfinalWidth = min($inputWidth, $shsunderlineWidth);


        //shsYear
        $shsYearcharLimit = 11.01;
        $averageCharWidth = 11; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('shsYear') * $averageCharWidth;
        $shsYearunderlineWidth = $shsYearcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $shsYearfinalWidth = min($inputWidth, $shsYearunderlineWidth);


        //shsAddress
        $shsAddresscharLimit = 28.52;
        $averageCharWidth = 24; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('shsAddress') * $averageCharWidth;
        $shsAddressunderlineWidth = $shsAddresscharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $shsAddressfinalWidth = min($inputWidth, $shsAddressunderlineWidth);


        //osc
        $osccharLimit = 20.45;
        $averageCharWidth = 20; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('osc') * $averageCharWidth;
        $oscunderlineWidth = $osccharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $oscfinalWidth = min($inputWidth, $oscunderlineWidth);


        //oscYear
        $oscYearcharLimit = 8;
        $averageCharWidth = 11; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('oscYear') * $averageCharWidth;
        $oscYearunderlineWidth = $oscYearcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $oscYearfinalWidth = min($inputWidth, $oscYearunderlineWidth);


        //oscAddress
        $oscAddresscharLimit = 20.25;
        $averageCharWidth = 25; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('oscAddress') * $averageCharWidth;
        $oscAddressunderlineWidth = $oscAddresscharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $oscAddressfinalWidth = min($inputWidth, $oscAddressunderlineWidth);


        //admissionDate
        $admissionDatecharLimit = 13;
        $averageCharWidth = 14; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('admissionDate') * $averageCharWidth;
        $admissionDateunderlineWidth = $admissionDatecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $admissionDatefinalWidth = min($inputWidth, $admissionDateunderlineWidth);


        //first1
        $first1charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('1First') * $averageCharWidth;
        $first1underlineWidth = $first1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first1finalWidth = min($inputWidth, $first1underlineWidth);


        //second1
        $second1charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('1Second') * $averageCharWidth;
        $second1underlineWidth = $second1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second1finalWidth = min($inputWidth, $second1underlineWidth);


        //summer1
        $summer1charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('1Summer') * $averageCharWidth;
        $summer1underlineWidth = $summer1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer1finalWidth = min($inputWidth, $summer1underlineWidth);


        //first2
        $first2charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('2First') * $averageCharWidth;
        $first2underlineWidth = $first2charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first2finalWidth = min($inputWidth, $first2underlineWidth);


        //second2
        $second2charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('2Second') * $averageCharWidth;
        $second2underlineWidth = $second2charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second2finalWidth = min($inputWidth, $second2underlineWidth);


        //summer2
        $summer2charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('2Summer') * $averageCharWidth;
        $summer2underlineWidth = $summer2charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer2finalWidth = min($inputWidth, $summer2underlineWidth);


        //first3
        $first3charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('3First') * $averageCharWidth;
        $first3underlineWidth = $first3charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first3finalWidth = min($inputWidth, $first3underlineWidth);


        //second3
        $second3charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('3Second') * $averageCharWidth;
        $second3underlineWidth = $second3charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second3finalWidth = min($inputWidth, $second3underlineWidth);


        //summer3
        $summer3charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('3Summer') * $averageCharWidth;
        $summer3underlineWidth = $summer3charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer3finalWidth = min($inputWidth, $summer3underlineWidth);


        //first4
        $first4charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('4First') * $averageCharWidth;
        $first4underlineWidth = $first4charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first4finalWidth = min($inputWidth, $first4underlineWidth);


        //second4
        $second4charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('4Second') * $averageCharWidth;
        $second4underlineWidth = $second4charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second4finalWidth = min($inputWidth, $second4underlineWidth);


        //summer4
        $summer4charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('4Summer') * $averageCharWidth;
        $summer4underlineWidth = $summer4charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer4finalWidth = min($inputWidth, $summer4underlineWidth);


        //first5
        $first5charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('5First') * $averageCharWidth;
        $first5underlineWidth = $first5charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first5finalWidth = min($inputWidth, $first5underlineWidth);


        //second5
        $second5charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('5Second') * $averageCharWidth;
        $second5underlineWidth = $second5charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second5finalWidth = min($inputWidth, $second5underlineWidth);


        //summer5
        $summer5charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('5Summer') * $averageCharWidth;
        $summer5underlineWidth = $summer5charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer5finalWidth = min($inputWidth, $summer5underlineWidth);


        //first6
        $first6charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('6First') * $averageCharWidth;
        $first6underlineWidth = $first6charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first6finalWidth = min($inputWidth, $first6underlineWidth);


        //second6
        $second6charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('6Second') * $averageCharWidth;
        $second6underlineWidth = $second6charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second6finalWidth = min($inputWidth, $second6underlineWidth);


        //summer6
        $summer6charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('6Summer') * $averageCharWidth;
        $summer6underlineWidth = $summer6charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer6finalWidth = min($inputWidth, $summer6underlineWidth);


        //first7
        $first7charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('7First') * $averageCharWidth;
        $first7underlineWidth = $first7charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first7finalWidth = min($inputWidth, $first7underlineWidth);


        //second7
        $second7charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('7Second') * $averageCharWidth;
        $second7underlineWidth = $second7charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second7finalWidth = min($inputWidth, $second7underlineWidth);


        //summer7
        $summer7charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('7Summer') * $averageCharWidth;
        $summer7underlineWidth = $summer7charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer7finalWidth = min($inputWidth, $summer7underlineWidth);


        //first8
        $first8charLimit = 17.3;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('8First') * $averageCharWidth;
        $first8underlineWidth = $first8charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $first8finalWidth = min($inputWidth, $first8underlineWidth);


        //second8
        $second8charLimit = 17.2;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('8Second') * $averageCharWidth;
        $second8underlineWidth = $second8charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $second8finalWidth = min($inputWidth, $second8underlineWidth);


        //summer7
        $summer8charLimit = 16.15;
        $averageCharWidth = 10; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('8Summer') * $averageCharWidth;
        $summer8underlineWidth = $summer8charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $summer8finalWidth = min($inputWidth, $summer8underlineWidth);


        //sub1
        $sub1charLimit = 16.4;
        $averageCharWidth = 20; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('sub1') * $averageCharWidth;
        $sub1underlineWidth = $sub1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $sub1finalWidth = min($inputWidth, $sub1underlineWidth);


        //unit1
        $unit1charLimit = 4;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('unit1') * $averageCharWidth;
        $unit1underlineWidth = $unit1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $unit1finalWidth = min($inputWidth, $unit1underlineWidth);


        //sub2
        $sub2charLimit = 16.4;
        $averageCharWidth = 20; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('sub2') * $averageCharWidth;
        $sub2underlineWidth = $sub2charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $sub2finalWidth = min($inputWidth, $sub2underlineWidth);


        //unit2
        $unit2charLimit = 4;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('unit2') * $averageCharWidth;
        $unit2underlineWidth = $unit2charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $unit2finalWidth = min($inputWidth, $unit2underlineWidth);


        //sub3
        $sub3charLimit = 16.4;
        $averageCharWidth = 20; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('sub3') * $averageCharWidth;
        $sub3underlineWidth = $sub3charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $sub3finalWidth = min($inputWidth, $sub3underlineWidth);


        //unit3
        $unit3charLimit = 4;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('unit3') * $averageCharWidth;
        $unit3underlineWidth = $unit3charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $unit3finalWidth = min($inputWidth, $unit3underlineWidth);


        //sub4
        $sub4charLimit = 16.4;
        $averageCharWidth = 20; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('sub4') * $averageCharWidth;
        $sub4underlineWidth = $sub4charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $sub4finalWidth = min($inputWidth, $sub4underlineWidth);


        //unit4
        $unit4charLimit = 4;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('unit4') * $averageCharWidth;
        $unit4underlineWidth = $unit4charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $unit4finalWidth = min($inputWidth, $unit4underlineWidth);


        //totalUnits
        $totalUnitscharLimit = 4;
        $averageCharWidth = 6; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('totalUnits') * $averageCharWidth;
        $totalUnitsunderlineWidth = $totalUnitscharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $totalUnitsfinalWidth = min($inputWidth, $totalUnitsunderlineWidth);


        //program
        $programcharLimit = 31;
        $averageCharWidth = 15; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('program') * $averageCharWidth;
        $programunderlineWidth = $programcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $programfinalWidth = min($inputWidth, $programunderlineWidth);


        //gradYear
        $gradYearcharLimit = 8;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('gradYear') * $averageCharWidth;
        $gradYearunderlineWidth = $gradYearcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $gradYearfinalWidth = min($inputWidth, $gradYearunderlineWidth);


        //firstname1
        $firstname1charLimit = 15.5;
        $averageCharWidth = 14; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('firstName') * $averageCharWidth;
        $firstname1underlineWidth = $firstname1charLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $firstname1finalWidth = min($inputWidth, $firstname1underlineWidth);


        // RegistrationAdviser
        $regadviser = ""; // Initialize as empty string if not defined elsewhere
        $RegistrationAdvisercharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family

        $inputWidth = strlen($regadviser) * $averageCharWidth;
        $RegistrationAdviserunderlineWidth = $RegistrationAdvisercharLimit * $averageCharWidth;
        $RegistrationAdviserfinalWidth = min($inputWidth, $RegistrationAdviserunderlineWidth);


        //$CollegeRegistrar
        $colregistrar = ""; // Assign an empty string if it's not defined elsewhere
        $CollegeRegistrarcharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen($colregistrar) * $averageCharWidth;
        $CollegeRegistrarunderlineWidth = $CollegeRegistrarcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $CollegeRegistrarfinalWidth = min($inputWidth, $CollegeRegistrarunderlineWidth);


        //$DepartmentHead
        $depthead = ""; // Assign an empty string if it's not defined elsewhere
        $DepartmentHeadcharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen($depthead) * $averageCharWidth;
        $DepartmentHeadunderlineWidth = $DepartmentHeadcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $DepartmentHeadfinalWidth = min($inputWidth, $DepartmentHeadunderlineWidth);


        //$CollegeDean
        $coldean = ""; // Assign an empty string if it's not defined elsewhere
        $CollegeDeancharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen($coldean) * $averageCharWidth;
        $CollegeDeanunderlineWidth = $CollegeDeancharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $CollegeDeanfinalWidth = min($inputWidth, $CollegeDeanunderlineWidth);




        // Example DHremarkDate from the database
        $DHremarkDate = $row['DHremarkDate']; // Assume this is in the format 'YYYY.MM.DD HH:MM:SS'
        $DHremarkDateFormatted = date('F j, Y', strtotime(substr($DHremarkDate, 0, 10)));

        $DHremarkDatecharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('DHremarkDate') * $averageCharWidth;
        $DHremarkDateunderlineWidth = $DHremarkDatecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $DHremarkDatefinalWidth = min($inputWidth, $DHremarkDateunderlineWidth);


        // Example DHremarkDate from the database
        $CDremarkDate = $row['CDremarkDate']; // Assume this is in the format 'YYYY.MM.DD HH:MM:SS'
        $CDremarkDateFormatted = date('F j, Y', strtotime(substr($CDremarkDate, 0, 10)));

        $CDremarkDatecharLimit = 25;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('CDremarkDate') * $averageCharWidth;
        $CDremarkDateunderlineWidth = $CDremarkDatecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $CDremarkDatefinalWidth = min($inputWidth, $CDremarkDateunderlineWidth);


        //lowestGrade
        $lowestGradecharLimit = 8;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('lowestGrade') * $averageCharWidth;
        $lowestGradeunderlineWidth = $lowestGradecharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $lowestGradefinalWidth = min($inputWidth, $lowestGradeunderlineWidth);


        //transfereeLowest
        $transfereeLowestcharLimit = 8;
        $averageCharWidth = 8; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('transfereeLowest') * $averageCharWidth;
        $transfereeLowestunderlineWidth = $transfereeLowestcharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $transfereeLowestfinalWidth = min($inputWidth, $transfereeLowestunderlineWidth);


        //yes
        $yescharLimit = 4;
        $averageCharWidth = 4; // Adjust this based on your font-size and font-family
        $inputWidth = strlen('transfeyesreeLowest') * $averageCharWidth;
        $yesunderlineWidth = $yescharLimit * $averageCharWidth;

        // Ensure input width does not exceed the maximum allowed width
        $yesfinalWidth = min($inputWidth, $yesunderlineWidth);




        $date = DateTime::createFromFormat('Y-m-d', $row['DHremarkDate']);
        $formattedDate = $date ? $date->format('F j, Y') : 'Invalid date'; // Change 'F j, Y' to your desired format






        // Define a common style for the font
        $fontStyle = 'font-size: 12px; font-family: Helvetica;';
        $fontStyle2 = 'font-size: 14px; font-family: Helvetica;';


        ?>


        <body>
            <!-- <div class="header-container">UREG-QF-14</div> -->
            <div class="header"> UREG-QF-14 </div>

            <div class="column">
                <img id="logo" src="<?php echo $base64ImageLogo; ?>" alt="Logo" style="height: 100px; margin-left: 50px; margin-top: 0; position: absolute;">
                <img id="logo" src="<?php echo $base64ImagePicture; ?>" alt="Logo" style="width: 125px; height: 125px; border: 2px solid black; position: absolute; margin-top: -8px; margin-left: 596px; ">
            </div>


            <div class="aaa">
                <p style=" font-size: 92%;">Republic of the Philippines</p>
                <h4 style=" font-size: 118%;">CAVITE STATE UNIVERSITY</h4>
                <p style=>Don Severino delas Alas Campus</p>
                <p style=>Indang, Cavite</p>


            </div>
            <div class="a">
                <h3>APPLICATION FOR GRADUATION</h3>
            </div>

            <div class="c">
                <?php
                echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Student No.: </span>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $studnumunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $studnumfinalWidth . 'px;">' . htmlspecialchars($row['studNum']) . '</span>';
                echo '</div>'; ?>
            </div>


            <div class="aaaa">
                <div class="b">
                    <h4>Personal Information</h4>
                </div>
                <?php

                echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Name: </span>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $firstnameunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $firstnamefinalWidth . 'px;">' . htmlspecialchars($row['firstName']) . '</span>';
                echo '</div>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $middlenameunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $middlenamefinalWidth . 'px;">' . htmlspecialchars($row['middleName']) . '</span>';
                echo '</div>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $lastnameunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $lastnamefinalWidth . 'px;">' . htmlspecialchars($row['lastName']) . '</span>';
                echo '</div>';
                echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Sex: </span>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sexunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $sexfinalWidth . 'px;">' . htmlspecialchars($row['sex']) . '</span>';
                echo '</div>';
                echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Age: </span>';
                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $ageunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                echo '<span style="display: inline-block; width: ' . $agefinalWidth . 'px;">' . htmlspecialchars($row['age']) . '</span>';
                echo '</div>';
                ?>
                <div class="d">

                    <pre>                            (First Name)            	 	    (Middle Name)          		          (Family Name)</pre>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Date of Birth:</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $birthDateunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $birthDatefinalWidth . 'px;">' . htmlspecialchars($row['birthDate']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Phone No.:</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $phoneNumberunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $phoneNumberfinalWidth . 'px;">' . htmlspecialchars($row['phoneNumber']) . '</span>';
                    echo '</div>';

                    ?>
                    <br><br><br><br><br><br>
                    <?php

                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Place of Birth:</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $birthPlaceunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $birthPlacefinalWidth . 'px;">' . htmlspecialchars($row['birthPlace']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Permanent Address: </span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $addressunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $addressfinalWidth . 'px;">' . htmlspecialchars($row['address']) . '</span>';
                    echo '</div>';
                    ?>


                </div>
            </div>


            <div class="aaaa">
                <div class="b">
                    <h4>Educational Background</h4>
                </div>
                <div class="d">
                    <div class="da">
                        <?php
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Senior High School:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $shsunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $shsfinalWidth . 'px;">' . htmlspecialchars($row['shs']) . '</span>';
                        echo '</div>';
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Year Attended:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $shsYearunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $shsYearfinalWidth . 'px;">' . htmlspecialchars($row['shsYear']) . '</span>';
                        echo '</div>';
                        ?>
                        <br><br><br><br><br><br>

                        <?php
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Adress:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $shsAddressunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $shsAddressfinalWidth . 'px;">' . htmlspecialchars($row['shsAddress']) . '</span>';
                        echo '</div>';
                        ?>

                        <br><br><br><br><br><br>
                        <?php
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">School/College attended other than Cavite State University:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $oscunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $oscfinalWidth . 'px;">' . htmlspecialchars($row['osc']) . '</span>';
                        echo '</div>';
                        ?>

                        <br><br><br><br><br><br>
                        <?php
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Year Attended:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $oscYearunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $oscYearfinalWidth . 'px;">' . htmlspecialchars($row['oscYear']) . '</span>';
                        echo '</div>';
                        ?>

                        <?php
                        echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Address:</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $oscAddressunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $oscAddressfinalWidth . 'px;">' . htmlspecialchars($row['oscAddress']) . '</span>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="aaaa">
                <div class="d">
                    <h3> <?php
                            echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle2 . '">Date of Admission to CvSU:</span>';
                            echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $admissionDateunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                            echo '<span style="display: inline-block; width: ' . $admissionDatefinalWidth . 'px;">' . htmlspecialchars($row['admissionDate']) . '</span>';
                            echo '</div>';
                            ?></h3>
                    <pre>Semester and Academic Year Attended:</pre>

                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Date of Admission to CvSU:</span>'; ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block;; width: ' . $first1finalWidth . 'px;">' . htmlspecialchars($row['1First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second1finalWidth . 'px;">' . htmlspecialchars($row['1Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer1finalWidth . 'px;">' . htmlspecialchars($row['1Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first2underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first2finalWidth . 'px;">' . htmlspecialchars($row['2First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second2underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second2finalWidth . 'px;">' . htmlspecialchars($row['2Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer2underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer2finalWidth . 'px;">' . htmlspecialchars($row['2Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first3underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first3finalWidth . 'px;">' . htmlspecialchars($row['3First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second3underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second3finalWidth . 'px;">' . htmlspecialchars($row['3Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer3underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer3finalWidth . 'px;">' . htmlspecialchars($row['3Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first4finalWidth . 'px;">' . htmlspecialchars($row['4First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second4finalWidth . 'px;">' . htmlspecialchars($row['4Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer4finalWidth . 'px;">' . htmlspecialchars($row['4Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first5underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first5finalWidth . 'px;">' . htmlspecialchars($row['5First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second5underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second5finalWidth . 'px;">' . htmlspecialchars($row['5Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer5underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer5finalWidth . 'px;">' . htmlspecialchars($row['5Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first6underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first6finalWidth . 'px;">' . htmlspecialchars($row['6First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second6underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second6finalWidth . 'px;">' . htmlspecialchars($row['6Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer6underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer6finalWidth . 'px;">' . htmlspecialchars($row['6Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first7underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first7finalWidth . 'px;">' . htmlspecialchars($row['7First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second7underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second7finalWidth . 'px;">' . htmlspecialchars($row['7Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer7underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer7finalWidth . 'px;">' . htmlspecialchars($row['7Summer']) . '</span>';
                    echo '</div>';
                    ?>
                    <br><br><br><br><br><br>
                    <?php
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">First Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $first8underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $first8finalWidth . 'px;">' . htmlspecialchars($row['8First']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Second Semester</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $second8underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $second8finalWidth . 'px;">' . htmlspecialchars($row['8Second']) . '</span>';
                    echo '</div>';
                    echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Summer</span>';
                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $summer8underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    echo '<span style="display: inline-block; width: ' . $summer8finalWidth . 'px;">' . htmlspecialchars($row['8Summer']) . '</span>';
                    echo '</div>';
                    ?>

                    <br>
                    <pre>Subjects Currently Enrolled:		                    	                                            Unit </pre>
                    <div class="r"> <br><br><br>Applying for Latin Honors?&nbsp;&nbsp; <?php
                                                                                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $yesunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: bottom; ' . $fontStyle . '">';
                                                                                        echo '<span style="display: inline-block; width: ' . $yesfinalWidth . 'px;">' . htmlspecialchars($yes) . '</span>';
                                                                                        echo '</div>'; ?> <img id="logo" src="<?php echo ($row['appType'] == 'For Latin Honors') ? $base64checkLogo : ''; ?>" alt="Logo" style="position: absolute; width:12px; height:12px; margin-top: -11px; margin-left: -17px;"> yes&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $yesunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: bottom; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                        echo '<span style="display: inline-block; width: ' . $yesfinalWidth . 'px;">' . htmlspecialchars($yes) . '</span>';
                                                                                                                                                                                                                                                                                                                                        echo '</div>'; ?><img id="logo" src="<?php echo ($row['appType'] == 'Ordinary Application') ? $base64crossLogo : ''; ?>" alt="Logo" style="position: absolute; width:12px; height:12px; margin-top: -11px; margin-left: -13px;">&nbsp;&nbsp;no&nbsp;&nbsp;</div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub1finalWidth . 'px; font-size: 10px;">' . htmlspecialchars($row['sub1']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit1Value = htmlspecialchars($row['unit1']);
                    $unit1Id = 'unit1-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit1Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit1finalWidth . 'px;">' . $unit1Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit1finalWidth . 'px; visibility: hidden;">' . $unit1Value . '</span>';
                    }
                    echo '</div>';
                    ?>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub2underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub2finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub2']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit2Value = htmlspecialchars($row['unit2']);
                    $unit2Id = 'unit2-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit2underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit2Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit2finalWidth . 'px;">' . $unit2Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit2finalWidth . 'px; visibility: hidden;">' . $unit2Value . '</span>';
                    }
                    echo '</div>'; ?> <div class="rr"> If Yes, please indicate the lowest grade obtained &nbsp;&nbsp;&nbsp;</div>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub3underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub3finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub3']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    $unit3Value = htmlspecialchars($row['unit3']);
                    $unit3Id = 'unit3-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit3underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit3Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit3finalWidth . 'px;">' . $unit3Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit3finalWidth . 'px; visibility: hidden;">' . $unit3Value . '</span>';
                    }
                    echo '</div>';
                    ?> <div class="rr">

                        <?php echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">in CvSU.</span>';
                        echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $lowestGradeunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                        echo '<span style="display: inline-block; width: ' . $lowestGradefinalWidth . 'px;">' . htmlspecialchars($row['lowestGrade']) . '</span>';
                        echo '</div>'; ?>&nbsp;&nbsp;&nbsp;&nbsp;

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub4finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub4']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit4Value = htmlspecialchars($row['unit4']);
                    $unit4Id = 'unit4-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit4Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px;">' . $unit4Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px; visibility: hidden;">' . $unit4Value . '</span>';
                    }
                    echo '</div>';
                    ?> <div class="rr"> For transferee, kindly indicate the lowest grade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>


                    <div class="rr"> <br><br><br><br><br>

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">obtained from previous school.</span>';
                                                            echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $transfereeLowestunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                            echo '<span style="display: inline-block; width: ' . $transfereeLowestfinalWidth . 'px;">' . htmlspecialchars($row['transfereeLowest']) . '</span>';
                                                            echo '</div>'; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        &nbsp;&nbsp;&nbsp;&nbsp; </div>

                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub4finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub5']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit4Value = htmlspecialchars($row['unit5']);
                    $unit4Id = 'unit4-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit4Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px;">' . $unit4Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px; visibility: hidden;">' . $unit4Value . '</span>';
                    }
                    echo '</div>';
                    ?>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub4finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub6']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit4Value = htmlspecialchars($row['unit6']);
                    $unit4Id = 'unit4-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit4Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px;">' . $unit4Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px; visibility: hidden;">' . $unit4Value . '</span>';
                    }
                    echo '</div>';
                    ?>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub4finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub7']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit4Value = htmlspecialchars($row['unit7']);
                    $unit4Id = 'unit4-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit4Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px;">' . $unit4Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px; visibility: hidden;">' . $unit4Value . '</span>';
                    }
                    echo '</div>';
                    ?>
                    <br><br><br><br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $sub4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                        echo '<span style="display: inline-block; width: ' . $sub4finalWidth . 'px;font-size: 10px;">' . htmlspecialchars($row['sub8']) . '</span>';
                                                        echo '</div>'; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php $unit4Value = htmlspecialchars($row['unit8']);
                    $unit4Id = 'unit4-div';

                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $unit4underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                    if ($unit4Value !== '0') {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px;">' . $unit4Value . '</span>';
                    } else {
                        echo '<span style="display: inline-block; width: ' . $unit4finalWidth . 'px; visibility: hidden;">' . $unit4Value . '</span>';
                    }
                    echo '</div>';
                    ?>

                    <br><br><br><br><br>
                    <p style="position: absolute;">========================================================================================================</p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $totalUnitsunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo '<span style="display: inline-block; width: ' . $totalUnitsfinalWidth . 'px;">' . htmlspecialchars($row['totalUnits']) . '</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo '</div>'; ?>


                </div>
            </div>

            <br>
            <div class="column">
                <img id="logo" src="<?php //signature of student
                                    echo $base64ImageSignatureStudent; ?>" alt="Logo" style="width:125px; height:125px; margin-top: 30px; margin-left: 500px; object-fit: contain;">
            </div>

            <?php
            $durationQuery = mysqli_query($conn, "SELECT gradYear FROM duration") or die(mysqli_error($conn));
            $row1 = mysqli_fetch_array($durationQuery);
            ?>

            <div id="a2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;have &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the &nbsp;&nbsp;&nbsp;&nbsp;honor &nbsp;&nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;apply &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;graduation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;course &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leading &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;degree &nbsp;&nbsp;&nbsp;of<?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $programunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: bottom; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo '<span style="display: inline-block; width: ' . $programfinalWidth . 'px;">' . htmlspecialchars($row['program']) . '</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo '</div>'; ?>&nbsp;&nbsp;&nbsp;<?php echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">this Graduation</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $gradYearunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: bottom; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo '<span style="display: inline-block; width: ' . $gradYearfinalWidth . 'px;">' . htmlspecialchars($row1['gradYear']) . '</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo '</div>'; ?>.</p>

                <p id="a1">&nbsp;&nbsp;It is understood that I shall be entitled to a &nbsp;&nbsp;diploma / certificate / award if &nbsp;&nbsp;and &nbsp;after I have satisfactorily completed all the requirements for graduation including but not limited to the submission of my bound manuscript / special problem / narrative reports and clearance for my graduation in this University.</p>
                <div class="aaaa">
                    <div class="e">
                        <div class="column1"><?php
                                                echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $firstname1underlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                echo '<span style="display: inline-block; width: ' . $firstname1finalWidth . 'px;">' . htmlspecialchars($firstname1 . ' ' . $middlename1 . ' ' . $lastname1) . '</span>';
                                                echo '</div>';
                                                ?></div>
                        </p>
                        <div class="column1a">
                            <p> Printed name and Signature of Applicant</p>
                        </div>
                    </div>
                </div>
                <div class="daa">
                    <div class="column">

                        <img id="logo" src="<?php echo ($row['RAstatus'] == 1) ? $base64SignatureRegAdviser : ''; ?>" alt="Logo" style="width:75px; height:75px; margin-top: -25px; margin-left: 130px; position: absolute; object-fit: contain;">
                        <img id="logo" src="<?php echo ($row['CRstatus'] == 1) ? $base64ImageSignatureColRegistrar : ''; ?>" alt="Logo" style="width:75px; height:75px; margin-top: -25px; margin-left: 530px; position: absolute; object-fit: contain;">
                    </div>

                    <div class="aaaa">
                        <div class="d">
                            <p>Noted:</p>
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $RegistrationAdviserunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                                                                                echo '<span style="display: inline-block; width: ' . $DepartmentHeadfinalWidth . 'px;">' . htmlspecialchars($firstNameRegAdviser . ' ' . $middleNameRegAdviser . ' ' . $lastNameRegAdviser) . '</span>';

                                                                                                                                                                echo '</div>'; ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $CollegeRegistrarunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo '<span style="display: inline-block; width: ' . $CollegeRegistrarfinalWidth . 'px;">' . htmlspecialchars($firstNameColRegistrar . ' ' . $middleInitialColRegistrar . ' ' . $lastNameColRegistrar) . '</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo '</div>'; ?></span>
                            <pre>                                 Registration Adviser					                                                                                      College Registrar</pre>
                        </div>
                    </div>


                    <div class="column">
                        <img id="logo" src="<?php echo ($row['DHstatus'] == 1) ? $base64ImageSignatureDeptHead : ''; ?>" alt="Logo" style="width:75px; height:75px; margin-top: -5px; margin-left: 130px; position: absolute; object-fit: contain;">
                        <img id="logo" src="<?php echo ($row['CDstatus'] == 1) ? $base64ImageSignatureColDean : ''; ?>" alt="Logo" style="width:75px; height:75px; margin-top: -5px; margin-left: 530px; position: absolute; object-fit: contain;">
                    </div>

                    <div class="aaaa">
                        <div class="d">
                            <p>Recommending Approval:</p>
                            <br><br><br><br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $DepartmentHeadunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                                                                                echo '<span style="display: inline-block; width: ' . $DepartmentHeadfinalWidth . 'px;">' . htmlspecialchars($firstNameDeptHead . ' ' . $middleInitialDeptHead . ' ' . $lastNameDeptHead) . '</span>';
                                                                                                                                                                echo '</div>'; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $CollegeDeanunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo '<span style="display: inline-block; width: ' . $CollegeDeanfinalWidth . 'px;">' . htmlspecialchars($firstNameColDean . ' ' . $middleInitialColDean . ' ' . $lastNameColDean) . '</span>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo '</div>'; ?></span>


                            <pre>                               Department Chairperson					                                                                                  College Dean</pre>
                            <br><br><br><br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Date:</span>';
                                                                                                            echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $DHremarkDateunderlineWidth . 'px; max-width: 100%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                                                                                            echo '<span style="display: inline-block; width: ' . $DHremarkDatefinalWidth . 'px;">' . htmlspecialchars($DHremarkDateFormatted) . '</span>';
                                                                                                            echo '</div>'; ?></span>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span><?php echo '<span style="display: inline-block; vertical-align: bottom; ' . $fontStyle . '">Date:</span>';
                                    echo '<div style="display: inline-block; border-bottom: 1px solid black; width: ' . $CDremarkDateunderlineWidth . 'px; max-width: 180%; text-align: center; white-space: nowrap; vertical-align: middle; ' . $fontStyle . '">';
                                    echo '<span style="display: inline-block; width: ' . $CDremarkDatefinalWidth . 'px;">' . htmlspecialchars($CDremarkDateFormatted) . '</span>';
                                    echo '</div>'; ?> </span>
                        </div>
                    </div>
                </div>

        </body>

</html>
<?php
    }
} else {
    // Handle the case where 'selectedAppIds' is not set in the URL parameters
    // You might want to display an error message or redirect the user
}
?>
<?php
$html = ob_get_contents();
ob_end_clean();

$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->render();

// Set the filename as the current date
$filename = date('Y-m-d') . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
echo $dompdf->output();
?>