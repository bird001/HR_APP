<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
?>
<script>
    function ViewInventory() {
        //pop up window for uploading SchoolListinngs csv files
        window.open("viewinventory", "View Inventory", "location=1,status=1,scrollbars=1,width=400,height=550");
    }
</script>

<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#InventoryRequests').dataTable({
            "sPaginationType": "full_numbers" //show pagination buttons
        });

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });

    //window.alert("blah");
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

$idArr = $_POST['checked_id'];
$functiontype = $_POST['Request'];

if($functiontype == 'Approve'){
    Approve($idArr);
}
if($functiontype == 'Deny'){
    Deny($idArr);
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
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Amount Requested</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM InventoryRequests where ManagerEmail = '$email'";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    echo '<tr id="' . $row['id_val'] . '">';
                    echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                    '<td class="name">' . $row['EmpName'] .
                    '<td class="empnum">' . $row['EmpID'] . '</td>' .
                    '<td class="empdept">' . $row['EmpDept'] . '</td>' .
                    '<td class="type">' . $row['ItemName'] . '</td>' .
                    '<td class="dates">' . $row['ItemCategory'] . '</td>' .
                    '<td class="days">' . $row['AmountRequested'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <!---->
        <input class="btn btn-primary" type="submit" name="Request" id = "Approve" value="Approve"/> 

        <input class="btn btn-primary" type="submit" name="Request" id = "Deny" value="Deny"/> 

        <input class="btn btn-primary" type="button" onclick='ViewInventory()' name="request" value="View"/> 
    </form>
</div>
<br>
<br>
<?php include("../Templates/footer_dashboard.php"); ?> 