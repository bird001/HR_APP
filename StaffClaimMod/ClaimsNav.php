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
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <li><a href="travelsubsistence">Traveling/Subsistence</a></li>
            <li><a href="mealtravel">Meal/Travel</a></li>
            <li><a href="loanapplication">Loan App</a></li>
            <?php
            if(($dept == "Accounts" && $role == "Manager") || ($dept == "Accounts" && $role == "Supervisor") || 
                    (strpos($position, 'Assistant General Manager') !== false) ||
                    (strpos($position, 'General Manager') !== false)){
                
            ?>
            <li><a href="loanrequests">Loan Requests</a></li>
            <?php
            }
            ?>
            <li><a href="loanpayment">Loan Payment</a></li>
            <li><a href="generatereports">Generate Reports</a></li>
            <!--
            <li><a href="#">Salary Advance</a></li>
            <li><a href="#">Payment Authorization</a></li>
            -->
        </ul>
    </div>
</nav>

