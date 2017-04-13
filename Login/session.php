<?php

include('../db/db3.php');
session_start();

header("refresh: 1801;");
$user_check = $_SESSION['login_user'];
$user_pass = $_SESSION['login_pass'];

$ses_sql = mysqli_query($conn, "select * from Users where EmpEmail ='$user_check' and EmpPass = '$user_pass' ");
$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
$login_session = $row['EmpEmail'];
$login_name = $row['FirstName']." ".$row['LastName'];


if (isset($_SESSION["login_user"])) {// ensures user times out after a certain time
    if ((time() - $_SESSION['last_time']) > 1800) { //time in secconds
        header("location:logout");
    } else {
        $_SESSION['last_time'] = time();
    }
} else {
    header("location:logout");
}
?>
