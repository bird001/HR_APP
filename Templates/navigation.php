<?php
$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
$dept = $row['EmpDept'];
$position = $row['EmpPosition'];
?>

</head>
<body>
    <div class="container">
        <header class="row">
            <div class = "col-lg-12 page-header" >
                <h4 class = "panel-title">Welcome <?php echo $login_name ?></h4><!--user name display-->
                <h4 align="right"><a href="logout">Sign Out</a></h4>
            </div>
        </header>
        <?php
        //include("../DashboardMod/ViewNewsStrip.php");
        ?>

        <nav id="primary-navigation" class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li><a  href="profile">Profile</a></li>
                    <li><a  href="dashboard">DashBoard</a></li>
                    <?php
                    if ($dept == 'HR') {
                        ?>
                        <li><a  href="letters">Letters</a></li>
                        <?php
                    }
                    ?>
                    <li><a  href="leave">Leave</a></li>
                    <li><a  href="claims">Staff Claims</a></li>
                    <?php
                    if ($dept == 'HR' || $position == 'Admin') {
                        ?>
                        <li><a  href="registration">Registration</a></li>
                        <?php
                    }
                    ?>
                    <li><a  href="inventory">Inventory</a></li>
                    <?php
                    if ($dept == 'HR') {
                        ?>
                        <li><a  href="operations">Operations</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>


