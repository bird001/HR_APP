<?php
//include("../db/db3.php");

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
            if($dept == 'IT' || $dept == 'HR' || $position == 'Branch Supervisor'){
            ?>
            <li><a href="inventorycrud">Update Inventory</a></li> <!--Update/Add/Delete inventory items-->
            <?php 
            }
            ?>
            <li><a href="requestinventory">Request Inventory</a></li><!--Used to request inventory items from HR Dept-->
            <?php
            if($role == 'Manager' || $dept == 'HR' || $position == 'Branch Supervisor'){
            ?>
            <li><a href="inventoryrequests">Requests To Be Approved</a></li><!--Used to request inventory items from HR Dept-->
            <li><a href="requestdelivery">Requests To Be Delivered</a></li><!--Used to request inventory items from HR Dept-->
            <li><a href="inventoryreports">Reports</a></li><!--Generate reports based on specific parameters-->
            
            <?php
            }
            ?>
            <!--
            <li><a href="#">Payment Authorization</a></li>
            -->
        </ul>
    </div>
</nav>

