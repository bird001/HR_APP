<?php

include("../db/db3.php");
include('../PHPMailer/SmtpMailer.php');
include("../Validation/ValidateInput.php");





$sql_get = "select * from ApplyLeaveHRArchive";
$get_arr = array();
$get_arr = $conn->query($sql_get);

//echo dateDifferenceDays('06-10-2017', date("d-m-Y"));

while ($row = $get_arr->fetch_assoc()) {
    $now = date("d-m-Y");
    $empemail = $row['EmpEmail'];
    $empname = $row['FirstName'] . " " . $row['LastName'];
    $leavetype = $row['LeaveType'];
    $leavedays = $row['NumDays'];
    $startdate = $row['StartDate'];
    $daysToLeave = dateDifferenceDays($startdate, $now);
    
    if($daysToLeave === '3'){
        smtpmailer_LeaveReminder($empemail, $empname, $leavedays, $leavetype, $daysToLeave, $startdate);
        //echo $daysToLeave;
    }
    if($daysToLeave === '2'){
        smtpmailer_LeaveReminder($empemail, $empname, $leavedays, $leavetype, $daysToLeave, $startdate);
        //echo $daysToLeave;
    }
    if($daysToLeave === '1'){
        smtpmailer_LeaveReminder($empemail, $empname, $leavedays, $leavetype, $daysToLeave, $startdate);
        //echo $daysToLeave;
    }
    
}
?>