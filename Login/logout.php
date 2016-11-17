<?php

include('../db/db3.php');
include("../Login/session.php");


$_SESSION = array();
unset($_COOKIE);//destroy cookies and sessions
unset($_SESSION);

//update userlog table with logout times
$sql_users = "UPDATE
      HR_DEPT.UserLog
      SET
      HR_DEPT.UserLog.TimeLoggedOut = now()
      WHERE
      HR_DEPT.UserLog.EmpEmail = '$user_check' and
      HR_DEPT.UserLog.TimeLoggedIn < now() order by HR_DEPT.UserLog.TimeLoggedIn desc limit 1"; //a log of users that have logged out this app
mysqli_query($conn, $sql_users); //execute the statement

session_destroy(); //completely destroy the session



header("Location: ../Login/login.php");//redirect to login page
?>