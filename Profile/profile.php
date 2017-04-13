<?php
include("../Login/session.php");
include("../db/db3.php");



$email = $_SESSION['login_user'];

$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$fname = $row['FirstName'];
$lname = $row["LastName"];
$empid = $row["EmpID"];
$empmail = $row["EmpEmail"];
$empstatus = $row["EmpStatus"];
$empaddress = $row["EmpAddress"];
$empdept = $row["EmpDept"];
$empstart = $row["EmpStartDate"];
$empdob = $row["EmpDOB"];
$empsex = $row["EmpSex"];
$empphone = $row["EmpPhone"];
?>

<?php include("../Templates/header.php"); ?>
<?php include("../Templates/navigation.php"); ?>
<?php include("../Templates/body.php"); ?>

<div class="container">
    <div class="row">
        <br>
        <div class="col-lg-8" >
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $fname . " " . $lname ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        if($empsex === 'F'){
                        ?>
                        <div class="col-md-3 col-lg-3 " align="left"> <img alt="User Pic" src="imagefemale" class="img-circle img-responsive"> </div>
                        <?php
                        }else {
                            ?>
                        <div class="col-md-3 col-lg-3 " align="left"> <img alt="User Pic" src="imagemale" class="img-circle img-responsive"> </div>
                            <?php
                        }
                        ?>
                        <div class=" col-md-9 col-lg-9 "> 
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>Department</td>
                                        <td><?php echo $empdept ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hire date</td>
                                        <td><?php echo $empstart ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td><?php echo $empdob ?></td>
                                    </tr>

                                    <tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td><?php echo $empsex ?></td>
                                    </tr>
                                    <tr>
                                        <td>Home Address</td>
                                        <td><?php echo $empaddress ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><a href="mailto:<?php echo $empmail ?>"><?php echo $empmail ?></a></td>
                                    </tr>
                                <td>Phone Number</td>
                                <td><?php echo $empphone ?>
                                </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../Templates/footer.php"); ?> 