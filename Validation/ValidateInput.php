<?php

//include("../Login/session.php");
//include("../db/db3.php");

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifferenceYears($date_1, $date_2, $differenceFormat = '%y') {
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function dateDifferenceDays($date_1, $date_2, $differenceFormat = '%d') {
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function getHourDifference($date_1, $date_2) {
    $datetime1 = new DateTime($date_1);

    $datetime2 = new DateTime($date_2);


    $diff = $datetime2->diff($datetime1);
    $hours = $diff->h;
    $hours = $hours + ($diff->days * 24);
    return $hours;
}

function getWeekdayDifference(\DateTime $startDate, \DateTime $endDate) {
    $isWeekday = function (\DateTime $date) {
        return $date->format('N') < 6;
    };

    $days = $isWeekday($endDate) ? 1 : 0;

    while ($startDate->diff($endDate)->days > 0) {
        $days += $isWeekday($startDate) ? 1 : 0;
        $startDate = $startDate->add(new \DateInterval("P1D"));
    }

    return $days;
}

//Form Validation
function ValidateName($name) {
    if (empty($name)) {
        return "cannot be empty";
    } else {
        $name = validate_input($name);
// check if name only contains letters and whitespace
        if (!preg_match("@^[a-zA-Z -/]*$@", $name)) {//@ is a delimiter
            return "only letters and white space";
        } else {
            return 1;
        }
    }
}

function ValidateAlphaNumeric($alphanum) {
    if (empty($alphanum)) {
        return "cannot be empty";
    } else {
        $alphanum = validate_input($alphanum);
// check if name only contains letters and whitespace
        if (!preg_match("#^[a-zA-Z()0-9 /]*$#", $alphanum)) {
            return "only letters and white space";
        } else {
            return 1;
        }
    }
}

function ValidateNumeric($alphanum) {
    if (empty($alphanum)) {
        return "cannot be empty";
    } else {
        $alphanum = validate_input($alphanum);
// check if name only contains letters and whitespace
        if (!preg_match("/^[0-9 -]*$/", $alphanum)) {
            return "only numbers and white space";
        } else {
            return 1;
        }
    }
}

function ValidatePosition($emppos) {
    if (empty($emppos)) {
        return "Position is required";
    } else {
        $emppos = validate_input($emppos);
        // check if Lname only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $emppos)) {
            return "Only letters and white space allowed"; //LastName
        } else {
            return 1;
        }
    }
}

function ValidateEmail($email) {
    if (empty($email)) {
        return "Managers Email is required";
    } else {
        $email = validate_input($email);
// check if Mail is valid
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            return "Invalid Email Format";
        } else {

            $sql_emailtest = "SELECT * FROM Users WHERE EmpEmail = '$email'";
            $selectresult = mysqli_query($conn, $sql_emailtest);
            if (mysqli_num_rows($selectresult) >= 1) {
                return "Email already exists, contact IT Manager";
            } else {
                return 1;
            }
        }
    }
}

function ValidatePhone($phone) {

    if (empty($phone)) {
        return "Phone# is required";
    } else {
        $phone = validate_input($phone);
        // check if phone# has only numbers and '-'
        if (!preg_match("/^[0-9 -]*$/", $phone)) {
            return "Only numbers allowed";
        } else {
            return 1;
        }
    }
}

function ValidateDOB($dob) {

    if (empty($dob)) {
        return "DOB is required";
    } else {
        $DOB = date("d-m-Y", strtotime($dob));
        $currentDate = date("d-m-Y");
        if (dateDifferenceYears($DOB, $currentDate) < 18) {
            return "This person is too young to be an employee of TIPFS";
        } else {

            return 1;
        }
    }
}


function ValidateDate($date) {

    if (empty($date)) {
        return "Date of Employment is required";
    } else {
        $Date = strtotime(date("d-m-Y", strtotime($date)));
        $currentDate = strtotime(date("d-m-Y"));
        if ($Date > $currentDate) {
            return "Cannot be a future date";
        } else {

            return 1;
        }
    }
}

function ValidateDatePast($date) {
    if (empty($date)) {
        //echo "Date(s) required";
        return "Date(s) required";
    } else {
        $Date = strtotime(date("d-m-Y", strtotime($date)));
        $currentDate = strtotime(date("d-m-Y"));
        if ($Date < $currentDate) {
            //echo "Cannot be a past date";
            return "Cannot be a past date";
        } else {

            //echo 1;
            return 1;
        }
    }
}
//ValidateDatePast(05/20/2017);

function ComparePasswords($pass1,$pass2){
    if(empty($pass1) || empty($pass2)){
        return "both feilds should be filled";
    } else{
        if($pass1 == $pass2){
            return 1;
        }else{
            return "passwords do not match";
        }
    }
}
/*
  function ValidateID($name) {

  }

  function ValidateDept($name) {

  }

  function ValidateLeaveType($name) {

  }

  function ValidateLoanType($name) {

  }

  function ValidateRepayment($name) {

  }

  function ValidatePeriod($name) {

  }
 */
?>
