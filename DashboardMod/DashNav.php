<?php
include("../db/db3.php");

$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
?>

<nav id="primary-navigation" class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <?php
            if ($role == 'Manager') {
                ?>
                <li><a href="AddNews.php">Add News</a></li>
                <?php
            }
            ?>


            <li><a href="ViewNews.php">View News</a></li>
        </ul>
    </div>
</nav>