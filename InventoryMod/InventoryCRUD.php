<?php
include("../Templates/header.php");
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


<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="#" method="post" name="inventorycrud" id="inventorycrud" class = "form-group" >

            <div class="form-group">
                <label for="inputIName" class="control-label">Item Name</label>
                <input type="text" name="Iname" id="Iname" class="form-control" placeholder="Tush P"  required/>
                <span class="error">
                    <?php
                    if ($itemNV != 1) {
                        echo $itemNV;
                    }
                    ?>
                </span>
            </div>

            <div class="form-group">
                <label for="inputItemID" class="control-label">Item ID</label>
                <input type="number" name="ItemID" id="ItemID" class="form-control" placeholder="000" required/>
                <span class="error">
                    <?php
                    if ($itemIV != 1) {
                        echo $itemIV;
                    }
                    ?>
                </span>
            </div>

            <div class="form-group">
                <label for="inputCategory" class="control-label">Category</label>
                <select class="form-control" name="category" id="category" required>
                    <option>Select Category</option>
                    <?php
                    $sql_inventory = "select * from InventoryCategory";
                    $inventory_results = $dbh->query($sql_inventory);
                    $row_inventory = $inventory_results->fetchAll();


                    foreach ($row_inventory as $row) {
                        echo '<option>' . $row['ItemCategory'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputAmount" class="control-label">Amount</label>
                <input type="number" name="Amt" id="Amt" class="form-control" placeholder="500" required/>
                <span class="error">
                    <?php
                    if ($itemAV != 1) {
                        echo $itemAV;
                    }
                    ?>
                </span>
            </div>
            <input class="btn btn-primary" type="submit" name="crud" value="Create"/> 
            <input class="btn btn-primary" type="submit" name="crud" value="Update"/>
        </form>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>