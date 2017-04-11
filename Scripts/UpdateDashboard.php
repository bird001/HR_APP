<?php

//Tally Leave and Carry Over Leave
include("../db/db3.php"); //use when testing
include("../Validation/ValidateInput.php"); //use when testing


$sql_bday_workanni = "select * from Users";
$get_bday_workanni = array();
$get_bday_workanni = $conn->query($sql_bday_workanni);

$sql_leaveday = "select * from ApplyLeaveHRArchive where HRResponse = 'Accepted'";
$get_leaveday = array();
$get_leaveday = $conn->query($sql_leaveday);

while ($row = $get_bday_workanni->fetch_assoc()) {//alert for birthdays and work anniversaries
    $empdob = date("d-m", strtotime($row['EmpDOB'])); //get the first two octets of the date ie. the day and the month
    $empstartdate = date("d-m", strtotime($row['EmpStartDate'])); //get the first two octets of the date ie. the day and the month

    $now = date("d-m-Y");
    $startdate = $row['EmpStartDate'];
    $datediff = dateDifferenceYears($startdate, $now);

    $empname = $row['FirstName'] . " " . $row['LastName'];
    $currentdate = date("d-m");
    //echo $currentdate." ";
    //echo $empstartdate;


    if ($currentdate === $empdob) {//compare the current date to the dob of each employee
        $headlinedob = "HAPPY BIRTHDAY!!";
        $storydob = "We would like to extend a happy happy birthday to $empname";
        $namedob = "CronJob";
        $emaildob = "";

        $sql_dashboard = "INSERT INTO DashBoard(Headline, Story, Name, Email, Time)VALUES('$headlinedob', '$storydob', '$namedob', '$emaildob', now())";
        mysqli_query($conn, $sql_dashboard);
    }

    if ($currentdate === $empstartdate) {//compare the current date to the start date of each employee
        $headlinedate = "Work Aniversary";
        $storydate = "We would like to congratulate $empname on $datediff years of loyal service to the Society";
        $namedate = "CronJob";
        $emaildate = "";

        $sql_dashboard = "INSERT INTO DashBoard(Headline, Story, Name, Email, Time)VALUES('$headlinedate', '$storydate', '$namedate', '$emaildate', now())";
        mysqli_query($conn, $sql_dashboard);
    }
}



while ($row = $get_leaveday->fetch_assoc()) {//alert for the day an employee goes on leave
    $empname = $row['FirstName'] . " " . $row['LastName'];
    $empdept = $row['EmpDept'];
    $leavedate = $row['StartDate'];
    $leaveend = $row['EndDate'];
    $currentdate = date("d-m-Y");

    if ($currentdate === $leavedate) {
        $headlineleave = "LEAVE";
        $storyleave = "$empname goes on leave today";
        $nameleave = "CronJob";
        $emailleave = "";

        $sql_dashboard = "INSERT INTO DashBoard(Headline, Story, Name, Email, Time)VALUES('$headlineleave', '$storyleave', '$nameleave', '$emailleave', now())";
        mysqli_query($conn, $sql_dashboard);
    }
    
    if ($currentdate === $leaveend) {
        $headlineleave = "LEAVE";
        $storyleave = "$empname leave has ended today";
        $nameleave = "CronJob";
        $emailleave = "";

        $sql_dashboard = "INSERT INTO DashBoard(Headline, Story, Name, Email, Time)VALUES('$headlineleave', '$storyleave', '$nameleave', '$emailleave', now())";
        mysqli_query($conn, $sql_dashboard);
    }
}

//remove old posts from Dashboard table----------------------------------------------------------------------------------
$getdashsql = "select * from DashBoard";
$getdash = array();
$getdash = $conn->query($getdashsql);

while ($row = $getdash->fetch_assoc()){
    
    $getdate = $row['Time'];
    $dashdate = date("d-m-Y", strtotime($getdate));
    $currentdate = date("d-m-Y");
    
    if(dateDifferenceDays($dashdate, $currentdate) > 2){
        $removedash = "delete from Dashboard where Time = $getdate";
        mysqli_query($conn, $removedash);
    }
    
    
    
}
?>