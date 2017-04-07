<?php
include("../Templates/header.php");
?>

<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../InventoryMod/InventoryNav.php");
include("../InventoryMod/RequestOperations.php");
include('../Validation/ValidateInput.php');


//get details of employee making requests
$email = $_SESSION['login_user'];
$query_emp = "SELECT * FROM Users where EmpEmail = '$email' ";
$result_emp = mysqli_query($conn, $query_emp);
$row_emp = mysqli_fetch_array($result_emp, MYSQLI_ASSOC);

$firstname = $row_emp['FirstName'];
$lastname = $row_emp['LastName'];
$empid = $row_emp['EmpID'];
$dept = $row_emp['EmpDept'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empname = $_POST['empname'];
    $empid = $_POST['empid'];
    $empdept = $_POST['empdept'];
    $itemname = $_POST['Iname'];
    $itemamount = $_POST['Amt'];
    $posttype = $_POST['request'];

//Validate
    $itemNV = ValidateName($itemname);
    $itemAV = ValidatePhone($itemamount);
    if ($itemNV == 1 && $itemAV == 1) {
        if ($posttype == 'Request') {
            //echo 'hello';
            Request($empname, $email, $empid, $empdept, $itemname, $itemamount);
        }
    } else {
        echo "error";
        $itemNV;
        $itemAV;
        //}
    }
}
?>


<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="#" method="post" name="inventoryreq" id="inventoryreq" class = "form-group" >

            <div class="form-group">
                <label for="inputEmpName" class="control-label">Employee Name</label>
                <input type="text" name="empname" id="empname" class="form-control" value="<?php echo $firstname . " " . $lastname; ?>"  required readonly/>
                <span class="error">

                </span>
            </div>

            <div class="form-group">
                <label for="inputEmpDept" class="control-label">Department</label>
                <input type="text" name="empdept" id="empdept" class="form-control" value="<?php echo $dept; ?>"  required readonly/>
                <span class="error">
                </span>
            </div>

            <div class="form-group">
                <label for="inputEmpID" class="control-label">Employee ID</label>
                <input type="number" name="empid" id="empid" class="form-control" value="<?php echo $empid; ?>"  required readonly/>
                <span class="error"></span>
            </div>

            <div class="form-group">
                <label for="inputIName" class="control-label">Item Name</label>
                <select class="form-control" name="Iname" id="Iname" required>
                    <option>Select Item</option>
                    <?php
                    $sql_inventory = "select * from Inventory";
                    $inventory_results = $dbh->query($sql_inventory);
                    $row_inventory = $inventory_results->fetchAll();


                    foreach ($row_inventory as $row) {
                        echo '<option>' . $row['ItemName'] . '</option>';
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
            <input class="btn btn-primary" type="submit" name="request" value="Request"/> 
        </form>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>