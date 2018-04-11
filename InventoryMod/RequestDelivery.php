<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
?>

<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#InventoryRequests').dataTable({
            "sPaginationType": "full_numbers" //show pagination buttons
        });

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../InventoryMod/InventoryNav.php");
include("../InventoryMod/RequestOperations.php");
?>



<?php
$email = $_SESSION['login_user'];
$sql1 = "SELECT * FROM  Users where EmpEmail = '$email'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

$position = $row1['EmpPosition'];
$dept = $row1['EmpDept'];
$role = $row1['EmpRole'];
$location = $row1['EmpLocation'];

$idArr = $_POST['checked_id'];
$functiontype = $_POST['Request'];

if ($functiontype == 'Delivered') {
    Delivered($idArr);
}
if($dept === 'HR' || $position === 'Branch Supervisor'){
   $itemcat = 'Stationary'; 
}
if($dept === 'IT'){
    $itemcat = 'Tech';
}
?>

<div class = "container-fluid datatables_wrapper">
    <form name="bulk_action_form" action="#" method="post" >
        <table id = "InventoryRequests" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th align = "center">
                        <div align = "center">

                        </div>
                    </th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Item Name</th>
                    <th>Color</th>
                    <th>Model</th>
                    <th>Item Category</th>
                    <th>Amount Requested</th>
                    <th>Time Requested</th>
                    <th>Item Delivered</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM InventoryRequests where ItemCategory = '$itemcat' and ManagerAcceptReject = 'Accepted'"
                        . "and ItemDelivered = 'No' and EmpLocation = '$location'";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    echo '<tr id="' . $row['id_val'] . '">';
                    echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                    '<td class="name">' . $row['EmpName'] . '</td>' .
                    '<td class="empdept">' . $row['EmpDept'] . '</td>' .
                    '<td class="type">' . $row['ItemName'] . '</td>' .
                    '<td class="color">' . $row['Color'] . '</td>' .
                    '<td class="model">' . $row['Model'] . '</td>' .
                    '<td class="dates">' . $row['ItemCategory'] . '</td>' .
                    '<td class="days">' . $row['AmountRequested'] . '</td>' .
                    '<td class="days">' . $row['TimeRequested'] . '</td>'.
                    '<td class="days">' . $row['ItemDelivered'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <input class="btn btn-primary" type="submit" name="Request" id = "Delivered" value="Delivered"/>
        
    </form>
</div>
<br>
<br>


<?php include("../Templates/footer_dashboard.php"); ?> 