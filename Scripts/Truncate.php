<?php
include("../db/db3.php");

$sql1 = "truncate table Users";
mysqli_query($conn, $sql1);

$sql1_adminuser = "insert into Users (FirstName, EmpEmail, EmpStatus, EmpRole, EmpPosition, EmpPass, PasswordChanged) values('Administrator',"
        . "'info@tipfriendly.com','Permanent','Manager','Admin','Admin','1')";
mysqli_query($conn, $sql1_adminuser);

$sql2 = "truncate table UserLog";
mysqli_query($conn, $sql2);

$sql3 = "truncate table Leaves";
mysqli_query($conn, $sql3);

$sql4 = "truncate table DLetters";
mysqli_query($conn, $sql4);

$sql5 = "truncate table AvailableDays";
mysqli_query($conn, $sql5);

$sql6 = "truncate table ApplyLeaveArchive";
mysqli_query($conn, $sql6);

$sql7 = "truncate table ApplyLeave";
mysqli_query($conn, $sql7);

$sql8 = "truncate table DashBoard";
mysqli_query($conn, $sql8);

$sql9 = "truncate table LoanApproved";
mysqli_query($conn, $sql9);

$sql10 = "truncate table LoanApprovedArchive";
mysqli_query($conn, $sql10);

$sql11 = "truncate table LoanApplication";
mysqli_query($conn, $sql11);

$sql12 = "truncate table LoanApplicationArchive";
mysqli_query($conn, $sql12);

$sql13 = "truncate table ApplyLeaveHRArchive";
mysqli_query($conn, $sql13);

$sql14 = "truncate table ApplyLeaveHR";
mysqli_query($conn, $sql14);

$sql15 = "truncate table ManagersDepartments";
mysqli_query($conn, $sql15);

$sql16 = "truncate table InventoryRequests";
mysqli_query($conn, $sql16);

$sql17 = "truncate table InventoryRequestsArchive";
mysqli_query($conn, $sql17);

$sql18 = "truncate table Inventory";
mysqli_query($conn, $sql18);

?>

