<?php

//include("../Login/session.php");
include("../db/db3.php");

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

function getWeekdayDifference(\DateTime $startDate, \DateTime $endDate) {// used to remove weekends from leave application
    $isWeekday = function (\DateTime $date) {
        return $date->format('N') < 6; //format('N') gets the day of the week (1 - Monday, 7 - Sunday)
    };
    $Sdate = new DateTime(date("Y-m-d", strtotime(date_format($startDate, "Y-m-d"))));
    $Edate = new DateTime(date("Y-m-d", strtotime(date_format($endDate, "Y-m-d"))));
    
    $days = $isWeekday($endDate) ? 1 : 0;
    
    while ($Sdate->diff($Edate)->days > 0) {

        //if function here to check if date is within holiday calender library
        //set that holiday date to 6 or 7, representing sat or sunday, this will exclude it from th days count
        $days += $isWeekday($Sdate) ? 1 : 0; //if day is less than 6 then add 1 to days, if greater then add 0
        $Sdate = $Sdate->add(new \DateInterval("P1D")); // adds 1 day to start date until it is equal to end date
    }

    //return $days; // output days
    return getHolidays($startDate, $endDate, $days); // output days
}

function isDateBetweenDates(\DateTime $date, \DateTime $startDate, \DateTime $endDate) {//function created to check if date is within
    if($date > $startDate && $date < $endDate){                                         //a specific date range
        return "True";
    } else {
        return "False";
    }

}

function getHolidays(\DateTime $startDate, \DateTime $endDate, $days) {
    $year = date("Y"); //gets current year
    $myfile = fopen("../LeaveMod/Years/" . $year, "r") or die("Unable to open file!"); //open and read from year file
    //Output one line until end-of-file
    while (!feof($myfile)) {
        $holidays = fgets($myfile);//get individual days from file
        $Holiday = new DateTime(date("Y-m-d", strtotime($holidays)));// transform string to date object
        if(isDateBetweenDates($Holiday, $startDate, $endDate) === "True"){//check if day in file is within range
            $days -= 1;// if it is within the range, then remove it from the total days to be removed from employees
                            //leave days
        }
    }
    //echo $days;
    return $days;
    
    fclose($myfile);// close file
}
//some tests for the removal of holiday days
/*
$sdate = "26-03-2018";
$edate = "04-04-2018";
//$specdate = "20-03-2018";
$newSdate = new DateTime(date("Y-m-d", strtotime($sdate)));
$newEdate = new DateTime(date("Y-m-d", strtotime($edate)));
//$newspecdate = new DateTime(date("Y-m-d", strtotime($specdate)));
//$wkdays = getWeekdayDifference($newSdate, $newEdate);
//echo getWeekdayDifference($newSdate, $newEdate);
//echo getHolidays($newSdate, $newEdate, '8');
//echo isDateBetweenDates($newspecdate, $newSdate, $newEdate);
 * 
 */


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
        if (!preg_match("#^[a-zA-Z()0-9 -/]*$#", $alphanum)) {
            return "only letters and white space";
        } else {
            return 1;
        }
    }
}

function ValidateNumeric($alphanum) {
    if (empty($alphanum) && !isset($alphanum)) {
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

function ComparePasswords($pass1, $pass2) {
    if (empty($pass1) || empty($pass2)) {
        return "both feilds should be filled";
    } else {
        if ($pass1 == $pass2) {
            return 1;
        } else {
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
