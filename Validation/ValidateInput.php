<?php

include("../Login/session.php");
include("../db/db3.php");

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

function ValidateName($name) {
    if (empty($name)) {
        return "cannot be empty";
    } else {
// check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            return "only letter and white space";
        } else {
            return 1;
        }
    }
}

function ValidateEmail($email) {
    if (empty($email)) {
        return "Managers Email is required";
    } else {
// check if Mail is valid
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            return "Invalid Email Format";
        } else {

            $sql_emailtest = "SELECT * FROM Users WHERE EmpEmail = '$email'";
            $selectresult = mysqli_query($conn, $sql_emailtest);
            if (mysqli_num_rows($selectresult) >= 1) {
                return 1;
            } else {
                return "Email doesn't exist, check spelling or contact admin";
            }
        }
    }
}

if(ValidateEmail('a.adams@tipfriendly.com') === 1){
    echo ValidateEmail('a.adams@tipfriendly.com');
} else{
    echo ValidateEmail('a.adams@tipfriendly.com');
}

function ValidateDate($date) {
    
}

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

?>
