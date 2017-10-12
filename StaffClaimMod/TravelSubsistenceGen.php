<?php

include('../db/db3.php');
include("../Letters/Letters.php");
include('../Login/session.php');
include('../Validation/ValidateInput.php');


$fname = $_POST['Fname'];
$lname = $_POST['Lname'];
$name = $fname . " " . $lname;
$empdept = $_POST['EmpDept'];
$startdate = $_POST['StartDate'];
$enddate = $_POST['EndDate'];
$dest = $_POST['Dest'];
$origin = $_POST['Origin'];
$kilometers = $_POST['KM'];
$purpose = $_POST['Purpose'];
$date = date("F d, Y");


if (empty($fname)) {
    $fnameError = "First Name is required";
} else {
    $fname = validate_input($fname);
// check if Fname only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
        $fnameError = "Only letters and white space allowed"; //FirstName
        $fnameSet = 0;
    } else {
        $fnameSet = 1;
    }
}

if (empty($lname)) {
    $lnameError = "Last Name is required";
} else {
    $lname = validate_input($lname);
// check if Lname only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
        $lnameError = "Only letters and white space allowed"; //LastName
        $lnameSet = 0;
    } else {
        $lnameSet = 1;
    }
}

if (empty($startdate)) {
    $startdateError = "FROM is required";
    $startdateSet = 0;
} else {
    $Sdate = date("F d, Y", strtotime($startdate));
    $startdateSet = 1;
}


if (empty($enddate)) {
    $enddateError = "TO is required";
    $enddateSet = 0;
} else {
    $Edate = date("F d, Y", strtotime($enddate));
    $enddateSet = 1;
}

if (empty($dest)) {
    $destError = "Destination is required";
} else {
    $dest = validate_input($dest);
// check if Lname only contains letters and whitespace
    if (!preg_match("/^[- a-zA-Z0-9]*$/", $dest)) {
        $destError = "Only letters,numbers and white space allowed"; //LastName
        $destSet = 0;
    } else {
        $destSet = 1;
    }
}

if (empty($origin)) {
    $originError = "Origin is required";
} else {
    $origin = validate_input($origin);
// check if Lname only contains letters and whitespace
    if (!preg_match("/^[- a-zA-Z0-9 ]*$/", $origin)) {
        $originError = "Only letters,numbers and white space allowed"; //LastName
        $originSet = 0;
    } else {
        $originSet = 1;
    }
}

if (empty($kilometers)) {
    $kilometersError = "Milage is required";
} else {
    $kilometers = validate_input($kilometers);
// check if Lname only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/", $kilometers)) {
        $kilometersError = "Only letters allowed"; //LastName
        $kilometersSet = 0;
    } else {
        $kilometersSet = 1;
    }
}


if (empty($purpose)) {
    $purposeError = "Purpose is required";
    $purposeSet = 0;
} else {
    $purposeSet = 1;
}



if ($fnameSet == 1 && $lnameSet == 1 && $startdateSet == 1 && $enddateSet == 1 && $destSet == 1 && $originSet == 1 && $kilometersSet == 1 && $purposeSet == 1) {

    $email = $_SESSION['login_user'];
    $sql_rates = "SELECT * FROM RatesListing";
    $sql_users = "SELECT * FROM Users where EmpEmail = '$email' ";
    $result_rates = mysqli_query($conn, $sql_rates);
    $result_users = mysqli_query($conn, $sql_users);
    $row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC);
    $row_users = mysqli_fetch_array($result_users, MYSQLI_ASSOC);
    
    $emprole = $row_users['EmpRole'];
    $subsistence = $row_rates['Subsistence'];
    
    if($emprole === "Manager"){
        
        $kmrate = $row_rates['ManagerMilage'];
        
        //$totalkm = $kmrate * ($kilometers*1.4);
        $totalkm = $kmrate * ($kilometers);
    } else{
        $kmrate = $row_rates['EmployeeMilage'];//if not a manager then standard employee rate of $40/km
        
        //$totalkm = $kmrate * ($kilometers*1.4); //calculate the amount for the trip
        $totalkm = $kmrate * ($kilometers); //calculate the amount for the trip
    }
    
    

    

    TravelSubsistence($name,$empdept,$Sdate,$Edate,$dest,$origin,$purpose,$date,$totalkm,$subsistence);
} else {
    echo "error";
}
?>