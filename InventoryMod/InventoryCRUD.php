<?php
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>

<script>
    function AddInventory() {
        var dept = $("#Dept").val();
        //pop up window for uploading SchoolListinngs csv files
        window.open("addinventory?dept=" + dept, "Add Inventory", "location=1,status=1,scrollbars=1,width=500,height=500");
    }
</script>

<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#ViewInventory').dataTable({
            "sPaginationType": "full_numbers" //show pagination buttons
        });
    });

</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../InventoryMod/InventoryNav.php");
include("../InventoryMod/CrudOperations.php");
include('../Validation/ValidateInput.php');

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$dept = $row['EmpDept'];
?>

<?php
if ($dept === 'HR') {
    ?>
    <div class = "container-fluid datatables_wrapper">
        <table id = "ViewInventory" name ="ViewInventory" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting--> 
                    <th>Item</th>
                    <th>Color</th>
                    <th>Brand</th>
                    <th>Amount</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM InventoryStationary";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();
                //NB... if you want to make all the rows editable, make the class name the same as the row name
                foreach ($rows as $row) {
                    echo '<tr name = "InventoryStationary" id="' . $row['id_val'] . '">';
                    echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td class="Item">' . $row['Item'] . '</td>' .
                    '<td class="Color">' . $row['Color'] . '</td>' .
                    '<td class="Brand">' . $row['Brand'] . '</td>' .
                    '<td class="Amount">' . $row['Amount'] . '</td>' .
                    '<td class="itdate">' . $row['LastUpdated'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <button class="btn btn-primary" id="Dept" value="<?php echo $dept ?>" onclick="AddInventory();">Add Inventory</button>
    </div>
    <?php
}
?>

<?php
if ($dept === 'IT') {
    ?>
    <div class = "container-fluid datatables_wrapper">
        <table id = "ViewInventory" name ="ViewInventory" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting--> 
                    <th>Item</th>
                    <th>Color</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Amount</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM InventoryTech";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();
                //NB... if you want to make all the rows editable, make the class name the same as the row name
                foreach ($rows as $row) {
                    echo '<tr name = "InventoryTech" id="' . $row['id_val'] . '">';
                    echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td class="Item">' . $row['Item'] . '</td>' .
                    '<td class="Color">' . $row['Color'] . '</td>' .
                    '<td class="Brand">' . $row['Brand'] . '</td>' .
                    '<td class="Model">' . $row['Model'] . '</td>' .
                    '<td class="Amount">' . $row['Amount'] . '</td>' .
                    '<td class="itdate">' . $row['LastUpdated'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <button class="btn btn-primary" id="Dept" value ="<?php echo $dept; ?>" onclick="AddInventory();">Add Inventory</button>
    </div>
    <?php
}
?>

<?php
if ($dept === 'Maintenance') {
    ?>
    <div class = "container-fluid datatables_wrapper">
        <table id = "ViewInventory" name ="ViewInventory" value ="<?php echo $dept; ?>" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting--> 
                    <th>Item</th>
                    <th>Brand</th>
                    <th>Amount</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM InventorySanitary";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();
                //NB... if you want to make all the rows editable, make the class name the same as the row name
                foreach ($rows as $row) {
                    echo '<tr name = "InventorySanitary" id="' . $row['id_val'] . '">';
                    echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td class="Item">' . $row['Item'] . '</td>' .
                    '<td class="Brand">' . $row['Brand'] . '</td>' .
                    '<td class="Amount">' . $row['Amount'] . '</td>' .
                    '<td class="itdate">' . $row['LastUpdated'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <button class="btn btn-primary" id="Dept" value ="<?php echo $dept; ?>" onclick="AddInventory();">Add Inventory</button>
    </div>
    <?php
}
?>
<?php include("../Templates/footer.php"); ?>