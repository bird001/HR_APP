<?php

//include("../Login/session.php");
include("../db/db3.php");

$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$dept = $row['EmpDept'];
?>

<nav id="primary-navigation" class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <?php
            if ($dept == 'HR') {
                ?>
            <li><a  href="disciplinaryletters">Upload Disciplinary</a></li>
            <li><a  href="lettertemplates">Letter Templates</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>

