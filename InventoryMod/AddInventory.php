<?php
include("../Templates/header_dashboard.php");
include("../InventoryMod/CrudOperations.php");
include('../Validation/ValidateInput.php');

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$dept = $_GET['dept'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($dept === 'HR') {
        $item = $_POST['Iname'];
        $color = $_POST['Color'];
        $brand = $_POST['Brand'];
        $itemamount = $_POST['Amt'];
        //$posttype = $_POST['crud'];
        //Validate
        $itemN = ValidateAlphaNumeric($item);
        $itemC = ValidateAlphaNumeric($color);
        $itemB = ValidateAlphaNumeric($brand);
        $itemA = ValidateNumeric($itemamount);

        if ($itemN == 1 && $itemC == 1 && $itemB == 1 && $itemA == 1) { //check validation
            //if ($posttype == 'Add') { //create a new type of item
            CreateStationary($item, $color, $brand, $itemamount);
            //}
        }
    }
    if ($dept === 'IT') {
        $item = $_POST['Iname'];
        $color = $_POST['Color'];
        $brand = $_POST['Brand'];
        $model = $_POST['Model'];
        $itemamount = $_POST['Amt'];
        //$posttype = $_POST['crud'];
        //Validate
        $itemN = ValidateAlphaNumeric($item);
        $itemC = ValidateAlphaNumeric($color);
        $itemB = ValidateAlphaNumeric($brand);
        $itemM = ValidateAlphaNumeric($model);
        $itemA = ValidateNumeric($itemamount);
        
        if ($itemN == 1 && $itemC == 1 && $itemB == 1 && $itemM == 1 && $itemA == 1) { //check validation
            //if ($posttype == 'Add') { //create a new type of item
            CreateTech($item, $color, $brand, $model, $itemamount);
            //}
        }
    }
    if ($dept === 'Maintenance') {
        //TO-DO
    }
}
?>

<?php
if ($dept === 'HR') {
    ?>
    <br>
    <div align="left" class = "form-group">
        <div style="width:500px;" class = "form-group" align="left">
            <form action="#" method="post" name="inventorycrud" id="inventorycrud" class = "form-group" >

                <div class="form-group">
                    <label for="inputIName" class="control-label">Item</label>
                    <input type="text" name="Iname" id="Iname" class="form-control" placeholder="Stapler"  required/>
                    <span class="error">
                        <?php
                        if ($itemN != 1) {
                            echo $itemN;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputColor" class="control-label">Color</label>
                    <input type="text" name="Color" id="Color" class="form-control" placeholder="Black"  required/>
                    <span class="error">
                        <?php
                        if ($itemC != 1) {
                            echo $itemC;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputBrand" class="control-label">Brand</label>
                    <input type="text" name="Brand" id="Brand" class="form-control" placeholder="Bostitch" required/>
                    <span class="error">
                        <?php
                        if ($itemB != 1) {
                            echo $itemB;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputAmount" class="control-label">Amount</label>
                    <input type="number" name="Amt" id="Amt" class="form-control" placeholder="5" required/>
                    <span class="error">
                        <?php
                        if ($itemA != 1) {
                            echo $itemA;
                        }
                        ?>
                    </span>
                </div>
                <input class="btn btn-primary" type="submit" name="crud" value="Add"/> 
            </form>
        </div>
    </div>
    <?php
}
if ($dept === 'IT') {
    ?>
    <br>
    <div align="left" class = "form-group">
        <div style="width:500px;" class = "form-group" align="left">
            <form action="#" method="post" name="inventorycrud" id="inventorycrud" class = "form-group" >

                <div class="form-group">
                    <label for="inputIName" class="control-label">Item</label>
                    <input type="text" name="Iname" id="Iname" class="form-control" placeholder="Toner"  required/>
                    <span class="error">
                        <?php
                        if ($itemN != 1) {
                            echo $itemN;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputColor" class="control-label">Color</label>
                    <input type="text" name="Color" id="Color" class="form-control" placeholder="Yellow"  required/>
                    <span class="error">
                        <?php
                        if ($itemC != 1) {
                            echo $itemC;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputBrand" class="control-label">Brand</label>
                    <input type="text" name="Brand" id="Brand" class="form-control" placeholder="Kyocera" required/>
                    <span class="error">
                        <?php
                        if ($itemB != 1) {
                            echo $itemB;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputModel" class="control-label">Model</label>
                    <input type="text" name="Model" id="Model" class="form-control" placeholder="4002i" required/>
                    <span class="error">
                        <?php
                        if ($itemM != 1) {
                            echo $itemM;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputAmount" class="control-label">Amount</label>
                    <input type="number" name="Amt" id="Amt" class="form-control" placeholder="5" required/>
                    <span class="error">
                        <?php
                        if ($itemA != 1) {
                            echo $itemA;
                        }
                        ?>
                    </span>
                </div>
                <input class="btn btn-primary" type="submit" name="crud" value="Add"/> 
            </form>
        </div>
    </div>
    <?php
}
if ($dept === 'Maintenance') {
    ?>
    <br>
    <div align="left" class = "form-group">
        <div style="width:500px;" class = "form-group" align="left">
            <form action="#" method="post" name="inventorycrud" id="inventorycrud" class = "form-group" >

                <div class="form-group">
                    <label for="inputIName" class="control-label">Item</label>
                    <input type="text" name="Iname" id="Iname" class="form-control" placeholder="Bleach"  required/>
                    <span class="error">
                        <?php
                        if ($itemNV != 1) {
                            echo $itemN;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputBrand" class="control-label">Brand</label>
                    <input type="text" name="Brand" id="Brand" class="form-control" placeholder="Clorodo" required/>
                    <span class="error">
                        <?php
                        if ($itemIV != 1) {
                            echo $itemB;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputAmount" class="control-label">Amount</label>
                    <input type="number" name="Amt" id="Amt" class="form-control" placeholder="5" required/>
                    <span class="error">
                        <?php
                        if ($itemAV != 1) {
                            echo $itemA;
                        }
                        ?>
                    </span>
                </div>
                <input class="btn btn-primary" type="submit" name="crud" value="Add"/> 
            </form>
        </div>
    </div>
    <?php
}
?>



<?php include("../Templates/footer_dashboard.php"); ?>