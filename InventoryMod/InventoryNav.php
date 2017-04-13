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
            <li><a href="inventorycrud">Update Inventory</a></li> <!--Update/Add/Delete inventory items-->
            <li><a href="requestinventory">Request Inventory</a></li><!--Used to request inventory items from HR Dept-->
            <li><a href="inventoryrequests">Inventory Requests</a></li><!--Used to request inventory items from HR Dept-->
            <li><a href="inventoryreports">Reports</a></li><!--Generate reports based on specific parameters-->
            <!--
            <li><a href="#">Payment Authorization</a></li>
            -->
        </ul>
    </div>
</nav>

