<?php

function Updates($fname, $lname, $empsex, $empid, $empemail, $status, $empdept, $role, $emppos, $empadd, $dob, $empphone, $startdate) {
    global $conn;

    $updateuserstable = "update Users set FirstName = '$fname', LastName = '$lname', EmpSex = '$empsex', EmpEmail = '$empemail', "
            . "EmpStatus = '$status', EmpDept = '$empdept', EmpRole = '$role', EmpPosition = '$emppos', EmpAddress = '$empadd', "
            . "EmpDOB = '$dob', EmpPhone = '$empphone', EmpStartDate = '$startdate' where EmpID = '$empid'";
    mysqli_query($conn, $updateuserstable);
    
    $actualempnum = $empnum - 1;
    $updateleavestable = "update Leaves set EmpFName = '$fname', EmpLName = '$lname', EmpEmail='$empemail', EmpStartDate = '$startdate'"
            . " where EmpID = '$empid'";
    mysqli_query($conn, $updateleavestable);
    
    $updatedlettertable = "update DLetters set EmpFName = '$fname', EmpLName = '$lname', EmpEmail = '$empemail'"
            . " where EmpID = '$empid'";
    mysqli_query($conn, $updatedlettertable);
    
    $name = $fname." ".$lname;
    $updatemanagers = "update ManagersDepartments set Name = '$name', EmpEmail='$empemail'"
            . "where EmpID = '$empid'";
    mysqli_query($conn, $updatemanagers);
}
?>

