<?php
//include("../Login/session.php");
include("../db/db3.php");

$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
?>

<nav id="primary-navigation" class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <li><a href="LeaveApply.php">Apply for Leave</a></li>
            <!--<li><a href="LeaveResumption.php">Resumption of Duty</a></li>-->
            <?php
            if ($role == 'Manager' || $role == 'Supervisor') {
                ?>
                <li><a  href="LeaveRequests.php">Leave Requests</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>

