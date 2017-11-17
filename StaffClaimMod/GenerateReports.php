<?php
include("../Templates/header.php");
?>

<?php
include("../db/db3.php");

$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
$dept = $row['EmpDept'];
$position = $row['EmpPosition'];
?>

<nav id="primary-navigation" class="row">
    <div class="col-lg-10">
        <ul class="nav nav-tabs">
            <li><a href="outstandingpayments">Outstanding Loans</a></li>
            <li><a href="specificreports">Specific Loan Report</a></li>
        </ul>
    </div>
</nav>