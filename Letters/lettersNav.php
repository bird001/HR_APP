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
            <!--<li><a href="../Discipline/discipline.php">View Disciplinary</a></li>-->
            <?php
            if ($role == 'Manager') {
                ?>
            <li><a  href="../Letters/generateDLetter.php">Upload Disciplinary</a></li>
            <li><a  href="../Letters/LetterTemplates.php">Letter Templates</a></li>
                <?php
            }
            ?>
            <!--<li><a data-toggle="tab" href="#Letters">Letters</a></li>
            <li><a data-toggle="tab" href="#Leave">Leave</a></li>
            <li><a data-toggle="tab" href="#Discipline">Disciplinary</a></li>
            <li><a data-toggle="tab" href="#Payroll">Payroll</a></li>
            <li><a data-toggle="tab" href="#Inventory">Inventory</a></li>-->
            <!--<li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a data-toggle="tab" href="#dropdown1">Dropdown 1</a></li>
                    <li><a data-toggle="tab" href="#dropdown2">Dropdown 2</a></li>
                </ul>
            </li>-->
        </ul>
    </div>
</nav>

