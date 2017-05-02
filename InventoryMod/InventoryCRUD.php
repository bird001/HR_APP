<?php
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>

<script>
    function AddInventory() {
//pop up window for uploading SchoolListinngs csv files
        window.open("addinventory", "Add Inventory", "location=1,status=1,scrollbars=1,width=400,height=400");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemname = $_POST['Iname'];
    $itemid = $_POST['ItemID'];
    $itemcategory = $_POST['category'];
    $itemamount = $_POST['Amt'];
    $posttype = $_POST['crud'];

    //Validate
    $itemNV = ValidateName($itemname);
    $itemIV = ValidatePhone($itemid);
    $itemAV = ValidatePhone($itemamount);

    if ($itemNV == 1 && $itemIV == 1 && $itemAV == 1) { //check validation
        if ($posttype == 'Create') { //create a new type of item
            Create($itemname, $itemid, $itemcategory, $itemamount);
        }

        if ($posttype == 'Update') {//update items that are already 
            Update($itemname, $itemid, $itemcategory, $itemamount);
        }

        if ($posttype == 'Delete') {//TO-DO
        }
    } else {
        echo "error";
    }
}
?>

<div class = "container-fluid datatables_wrapper">
    <table id = "ViewInventory" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting--> 
                <th>Item Name</th>
                <th>Item ID</th>
                <th>Category</th>
                <th>Item Amount</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Inventory";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();
            //NB... if you want to make all the rows editable, make the class name the same as the row name`
            foreach ($rows as $row) {
                echo '<tr name = "ViewInventory" id="' . $row['id_val'] . '">';
                echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="ItemName">' . $row['ItemName'] . '</td>' .
                '<td class="itid">' . $row['ItemID'] . '</td>' .
                '<td class="Category">' . $row['Category'] . '</td>' .
                '<td class="ItemAmount">' . $row['ItemAmount'] . '</td>'.
                '<td class="itdate">' . $row['DateInputed'] . '</td>';

                echo '</tr>';
            }
            ?>
            

        </tbody>                     
    </table>
    <button class="btn btn-primary" onclick="AddInventory();">Add Inventory</button>
</div>
<?php include("../Templates/footer.php"); ?>