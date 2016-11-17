<?php

include("../db/db3.php");
include('../PHPMailer/SmtpMailer.php');
include("../Validation/ValidateInput.php");

$sql_get = "select * from Leaves";
$get_arr = array();
$get_arr = $conn->query($sql_get);

while ($row = $get_arr->fetch_assoc()) {
    $empemail = $row['EmpEmail'];
    $empname = $row['EmpFName'] . " " . $row['EmpLName'];
    $outstandingleave = $row['OutstandingLeave_Years'];
    $outstandingleavereset = '0';
    $outstandingleavedays = $row['VacationOutstanding'];

//To-Do
// if(//outstanding leave is === 3 then promt that person to take any outstanding leave now){
    //}

    if ($outstandingleave === '3' && $outstandingleavedays !== '0') {//if outstanding days are not reduced to zero and outstanding leave years is 3 years notify the powers
        smtpmailer_OutstandingLeave($empemail, $empname, $outstandingleavedays); //send an email alerting both HR and employee
        
    } else {
        
        if ($outstandingleave >= '0' && $outstandingleave <= '2' && $outstandingleavedays !== '0') {
            
            $sql_update = "update HR_DEPT.Leaves set OutstandingLeave_Years = '$outstandingleave' where EmpEmail = '$empemail'";
            mysqli_query($conn, $sql_update);
            
        } else {//if outstanding days are cleared up and reduced to 0 then reset the outstanding years to 0
            
            $sql_update = "update HR_DEPT.Leaves set OutstandingLeave_Years = '$outstandingleavereset' where EmpEmail = '$empemail'";
            mysqli_query($conn, $sql_update);
            
        }
    }
}
?>

