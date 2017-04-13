<?php

include('../db/db3.php');
include('Letters.php');
include('../PHPMailer/SmtpMailer.php');
include('../Login/session.php');
include('../Validation/ValidateInput.php');


$operator = $login_session;
$idArr = $_POST['checked_id'];
$nametitle = $_POST['RecName'];
$companyname = $_POST['CompanyName'];
$companyadd = $_POST['CompanyAdd'];

//generate Job or Recommendation letter
if (!empty($idArr)) {
    
    if (empty($nametitle)) {//validate name/title
        $nametitleError = "Name/Title is required";
    } else {
        $nametitle = validate_input($nametitle);
        // check if Fname only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $nametitle)) {
            $nametitleError = "Only letters and white space allowed";
            $nametitleSet = 0;
        } else {
            $nametitleSet = 1;
        }
    }

    if (empty($companyname)) {//validate company name
        $companynameError = "Company Name is required";
    } else {
        $companyname = validate_input($companyname);
        // check if Fname only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $companyname)) {
            $companynameError = "Only letters and white space allowed";
            $companynameSet = 0;
        } else {
            $companynameSet = 1;
        }
    }

    if (empty($companyadd)) { //validate company address
        $companyaddError = "Company address is required";
    } else {
        $companyadd = validate_input($companyadd);
        // check if Fname only contains letters and whitespace
        if (!preg_match("/^[-,a-zA-Z 0-9]*$/", $companyadd)) {
            $companyaddError = "Only letters, numbers white space allowed";
            $companyaddSet = 0;
        } else {
            $companyaddSet = 1;
        }
    }


    if ($nametitleSet == 1 && $companynameSet == 1 && $companyaddSet == 1) {
        foreach ($idArr as $id) {

            $result = mysqli_query($conn, "select * from Users where id_val = '$id' ");
            $result2 = mysqli_query($conn, "select * from Users where EmpEmail = '$operator' ");
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
            $empname = $row['FirstName'] . " " . $row['LastName'];
            $empsex = $row['EmpSex'];
            $emppos = $row['EmpPosition'];
            $empstart = date("F d,Y", strtotime($row['EmpStartDate']));
            $manname = $row2['FirstName'] . " " . $row2['LastName'];
            $manpos = $row2['EmpPosition'];
            $date = date("F d, Y"); //to get the date in the format August 10, 2016


            if ($_POST['Letter'] == 'Job Letter') {
                //generate the letter
                JobLetter($nametitle,$companyname,$companyadd,$manname,$manpos, $empname, $emppos, $empstart, $empsex, $date);
            }
            if ($_POST['Letter'] == 'Recommendation Letter'){
                //generate the letter
                RecomLetter($nametitle,$companyname,$companyadd,$manname,$manpos, $empname, $emppos, $empstart, $empsex, $date);
            }
        }
    }
} else {
    header("Location: lettertemplates"); //redirect to login page
}
?>
