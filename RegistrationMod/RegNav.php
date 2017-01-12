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
            <?php
            if($dept == 'HR' || $position == 'Admin'){
                
            ?>
            <li><a href="Registration.php">Registration</a></li>
            <li><a href="EditRegistration.php">Edit Registration</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>

