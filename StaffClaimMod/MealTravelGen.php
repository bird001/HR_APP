<?php

include('../db/db3.php');
include("../Letters/Letters.php");
include('../Login/session.php');
include('../Validation/ValidateInput.php');


$fname = $_POST['Fname'];
$lname = $_POST['Lname'];
$name = $fname . " " . $lname;
$empdept = $_POST['EmpDept'];
$date = date("F d, Y",  strtotime($_POST['Date']));
$dest = $_POST['Dest'];
$purpose = $_POST['Purpose'];
$date2 = date("F d, Y");


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

if (empty($date)) {
    $dateError = "FROM is required";
    $dateSet = 0;
} else {
    $Date = date("F d, Y", strtotime($date));
    $dateSet = 1;
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


if (empty($purpose)) {
    $purposeError = "Purpose is required";
    $purposeSet = 0;
} else {
    $purposeSet = 1;
}



if ($fnameSet == 1 && $lnameSet == 1 && $dateSet == 1 && $destSet == 1  && $purposeSet == 1) {

    $email = $_SESSION['login_user'];
    $sql_rates = "SELECT * FROM RatesListing";
    $sql_users = "SELECT * FROM Users where EmpEmail = '$email' ";
    $result_rates = mysqli_query($conn, $sql_rates);
    $result_users = mysqli_query($conn, $sql_users);
    $row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC);
    $row_users = mysqli_fetch_array($result_users, MYSQLI_ASSOC);

    $emprole = $row_users['EmpRole'];
    $meal = $row_rates['Meal'];    

    MealTravel($name, $empdept, $date, $date2 ,$dest, $purpose, $meal,$manname, $supname);
} else {
    echo "error";
}
?>