<?php
$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
$dept = $row['EmpDept'];
$position = $row['EmpPosition'];
?>

<script>
    function GenerateReport() {
        window.open("../Reports/DisciplinaryReport.php", "GenerateReport", "location=1,status=1,scrollbars=1,width=400,height=400");
    }
</script>

</head>
<body>
    <div class="container">
        <header class="row">
            <div class = "col-lg-12 page-header" >
                <h4 class = "panel-title">Welcome <?php echo $login_name; ?></h4><!--user name display-->
                <h4 align="right"><a href="../Login/logout.php">Sign Out</a></h4>
            </div>
        </header>


        <nav id="primary-navigation" class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li><a  href="../Profile/profile.php">Profile</a></li>
                    <li><a  href="../DashboardMod/Dashboard.php">DashBoard</a></li>
                    <li><a  href="../Letters/letters.php">Letters</a></li>
                    <li><a  href="../LeaveMod/Leave.php">Leave</a></li>
                    <li><a  href="../StaffClaimMod/Claims.php">Staff Claims</a></li>
                    <?php
                    if ($dept == 'HR') {
                        ?>
                        <li><a  href="../RegistrationMod/Registration.php">Registration</a></li>
                        <?php
                    }
                    ?>
                    <!--<li><a  href="#Payroll">Payroll</a></li>
                    <li><a  href="#Inventory">Inventory</a></li>-->
                </ul>
            </div>
        </nav>


