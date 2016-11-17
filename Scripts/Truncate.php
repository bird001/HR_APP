<?php
include("../db/db3.php");

$sql1 = "truncate table Users";
mysqli_query($conn, $sql1);

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
?>

