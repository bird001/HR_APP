<?php
include '../db/db3.php';
include('../Login/session.php');
include('../Validation/ValidateInput.php');
include("../Templates/header.php");
include('../PHPMailer/SmtpMailer.php');


$idArr = $_POST['checked_id'];
$functiontype = $_POST['InvOp']; //get the type to determine what to execute

$operator = $login_session;
$operator_dept = $login_dept;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $functiontype == 'UpdateInventory') {

    if (!empty($idArr)) {
        $i = 0;
        foreach ($idArr as $id) {
            if ($operator_dept === 'HR') {
                $result = mysqli_query($conn, "select * from InventoryStationary where id_val = '$id' "); //get the relevant user
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
            if ($operator_dept === 'IT') {
                $result = mysqli_query($conn, "select * from InventoryTech where id_val = '$id' "); //get the relevant user
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
            if ($operator_dept === 'Maintenance') {
                
            }
            $itemname = $row['Item'];
            $itemid = $row['id_val'];
            $itemcolor = $row['Color'];
            $itemmodel = $row['Model'];
            $itembrand = $row['Brand'];
            $instock = $row['Amount'];
            $newstock = 0;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $functiontype == 'Update') {
    $itemname = $_POST['Itemname'];
    $itemid = $_POST['ItemID'];
    $itemcolor = $_POST['Color'];
    $itemmodel = $_POST['Model'];
    $itembrand = $_POST['Brand'];
    $instock = $_POST['Instock'];
    $newstock = $_POST['Purchased'];
    $dateupdated = date('d-m-Y h:i A');


    $itemname_result = ValidateAlphaNumeric($itemname);
    $itemcolor_result = ValidateAlphaNumeric($itemcolor);
    $itembrand_result = ValidateAlphaNumeric($itembrand);
    $instock_result = ValidateNumeric($instock);
    $newstock_result = ValidateNumeric($newstock);
    $dateupdated_result = ValidateDate($dateupdated);

    if ($itemname_result == 1 && $itemcolor_result == 1 && $itembrand_result == 1 && $instock_result == 1) {
        echo $stock = $instock + $newstock;
        if ($operator_dept === 'HR') {
            $update_query = "update InventoryStationary set Item = '$itemname', Color = '$itemcolor', Brand = '$itembrand', "
                    . "Amount = $stock, LastUpdated = '$dateupdated' where id_val = '$itemid'";
            mysqli_query($conn, $update_query);

            if ($newstock == 0) {//check what kind of change was made and track changes
                $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                        . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                        . "'$stock','$login_location','$operator_dept','$operator', 'Item Details Changed')";
                mysqli_query($conn, $track_inv);
            } else {
                $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                        . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                        . "'$stock','$login_location','$operator_dept','$operator', 'Item Stock Updated')";
                mysqli_query($conn, $track_inv);
            }
            echo "<script>window.close();</script>";
        }
        if ($operator_dept === 'IT') {
            $update_query = "update InventoryTech set Item = '$itemname', Color = '$itemcolor', Brand = '$itembrand', "
                    . "Model = '$itemmodel', Amount = $stock, LastUpdated = '$dateupdated' where id_val = '$itemid'";
            mysqli_query($conn, $track_inv);

            if ($newstock == 0) {//check what kind of change was made and track changes
                $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                        . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                        . "'$stock','$login_location','$operator_dept','$operator', 'Item Details Changed')";
                mysqli_query($conn, $track_inv);
            } else {
                $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                        . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                        . "'$stock','$login_location','$operator_dept','$operator', 'Item Stock Updated')";
                mysqli_query($conn, $track_inv);
            }
            echo "<script>window.close();</script>";
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $functiontype == 'AddInventory') {
    $itemname = "";
    $itemid = "";
    $itemcolor = "";
    $itemmodel = "";
    $itembrand = "";
    $instock = 0;
    $newstock = 0;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $functiontype == 'Create') {
    $itemname = $_POST['Itemname'];
    $itemcolor = $_POST['Color'];
    $itemmodel = $_POST['Model'];
    $itembrand = $_POST['Brand'];
    $instock = $_POST['Instock'];
    $newstock = $_POST['Purchased'];
    $dateupdated = date('d-m-Y h:i A');


    $itemname_result = ValidateAlphaNumeric($itemname);
    $itemcolor_result = ValidateAlphaNumeric($itemcolor);
    $itembrand_result = ValidateAlphaNumeric($itembrand);
    $instock_result = ValidateNumeric($instock);
    $newstock_result = ValidateNumeric($newstock);
    $dateupdated_result = ValidateDate($dateupdated);

    if ($itemname_result == 1 && $itemcolor_result == 1 && $itembrand_result == 1 && $instock_result == 1 && $newstock_result == 1) {
        $stock = $instock + $newstock;
        if ($operator_dept === 'HR') {
            $insert_query = "insert into InventoryStationary (Item, Color, Brand, Amount, LastUpdated, Location) values "
                    . "('$itemname', '$itemcolor', '$itembrand', '$stock','$dateupdated','$login_location')";

            mysqli_query($conn, $insert_query);

            //check what kind of change was made and track changes
            $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                    . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                    . "'$stock','$login_location','$operator_dept','$operator', 'Item Added')";
            mysqli_query($conn, $track_inv);
            echo "<script>window.close();</script>";
        }
        if ($operator_dept === 'IT') {
            $insert_query = "insert into InventoryTech (Item, Color, Brand, Model, Amount, LastUpdated, Location) values"
                    . " ('$itemname', '$itemcolor', '$itembrand','$itemmodel', '$stock', '$dateupdated', '$login_location')";
            mysqli_query($conn, $insert_query);

            //check what kind of change was made and track changes
            $track_inv = "insert into InventoryTracker (Item, Color, Brand, Model, InStock, Purchased, UpdatedStock, Location, "
                    . "Department, UpdatedBy, Action) values('$itemname','$itemcolor','$itembrand','N/A','$instock','$newstock',"
                    . "'$stock','$login_location','$operator_dept','$operator', 'Item Added')";
            mysqli_query($conn, $track_inv);
            echo "<script>window.close();</script>";
        }
    }
}

if ($functiontype === 'AddInventory') {
    ?>
    <body bgcolor="#FFFFFF">
        <br>
        <div align="left" class = "form-group">
            <div style="width:500px;" class = "form-group" align="left">

                <form action="#" method="post" id="form1" class = "form-group" role="form" >

                    <div class="form-group">
                        <label for="inputItemName" class="control-label">Item Name</label>
                        <input type="text" name="Itemname" id="Itemname" class="form-control" value="<?php echo $itemname ?>" required/>

                    </div>

                    <div class="form-group">
                        <label for="inputItemcolor" class="control-label">Color</label>
                        <input type="text" name="Color" id="Color" class="form-control" value="<?php echo $itemcolor ?>" required/>

                    </div>
                    <?php
                    if ($operator_dept === 'IT') {
                        ?>
                        <div class="form-group">
                            <label for="inputItemModel" class="control-label">Model</label>
                            <input type="text" name="Model" id="Model" class="form-control" value="<?php echo $itemmodel ?>" required/>

                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label for="inputBrand" class="control-label">Brand</label>
                        <input type="text" name="Brand" id="Brand" class="form-control" value="<?php echo $itembrand ?>" required/>

                    </div>

                    <div class="form-group">
                        <label class="control-label">In Stock</label>
                        <input type="number" name="Instock" id="Instock" class="form-control" value="<?php echo $instock ?>" required/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Purchased</label>
                        <input type="number" name="Purchased" id="Purchased" class="form-control" value="<?php echo $newstock ?>" required/>
                    </div>
                    <input class="btn btn-primary" type="submit" name="InvOp" id ="InvOp" value="Create"/> 

                </form>
            </div>

        </div>
    </body>
    <?php
}

if ($functiontype == 'UpdateInventory') {
    ?>
    <body bgcolor="#FFFFFF">
        <br>
        <div align="left" class = "form-group">
            <div style="width:500px;" class = "form-group" align="left">

                <form action="#" method="post" id="form1" class = "form-group" role="form" >

                    <div class="form-group">
                        <label for="inputItemName" class="control-label">Item Name</label>
                        <input type="text" name="Itemname" id="Itemname" class="form-control" value="<?php echo $itemname ?>" required/>
                        <span class="error">
                            <?php
                            if ($fname_result != 1) {
                                echo $fname_result;
                            }
                            ?>
                        </span>

                    </div>

                    <div class="form-group" style = "display:none">
                        <label for="ItemID" class="control-label">Item ID</label>
                        <input type="number" name="ItemID" id="ItemID" class="form-control" value="<?php echo $itemid ?>" required/>
                    </div>

                    <div class="form-group">
                        <label for="inputItemcolor" class="control-label">Color</label>
                        <input type="text" name="Color" id="Color" class="form-control" value="<?php echo $itemcolor ?>" required/>
                        <span class="error">
                            <?php
                            if ($lname_result != 1) {
                                echo $lname_result;
                            }
                            ?>
                        </span>
                    </div>
                    <?php
                    if ($operator_dept === 'IT') {
                        ?>
                        <div class="form-group">
                            <label for="inputItemModel" class="control-label">Model</label>
                            <input type="text" name="Model" id="Model" class="form-control" value="<?php echo $itemmodel ?>" required/>
                            <span class="error">
                                <?php
                                if ($lname_result != 1) {
                                    echo $lname_result;
                                }
                                ?>
                            </span>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label for="inputBrand" class="control-label">Brand</label>
                        <input type="text" name="Brand" id="Brand" class="form-control" value="<?php echo $itembrand ?>" required/>
                        <span class="error">
                            <?php
                            if ($lname_result != 1) {
                                echo $lname_result;
                            }
                            ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label class="control-label">In Stock</label>
                        <input type="number" name="Instock" id="Instock" class="form-control" value="<?php echo $instock ?>" required/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Purchased</label>
                        <input type="number" name="Purchased" id="Purchased" class="form-control" value="<?php echo $newstock ?>" required/>
                    </div>
                    <input class="btn btn-primary" type="submit" name="InvOp" id ="InvOp" value="Update"/> 

                </form>
            </div>

        </div>
    </body>
    <?php
}
?>
