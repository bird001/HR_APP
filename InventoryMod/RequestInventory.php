<?php
include("../Templates/header.php");
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
$emplocation = $row_emp['EmpLocation'];
$empid = $row_emp['EmpID'];
$dept = $row_emp['EmpDept'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empname = $_POST['empname'];
    $empdept = $_POST['empdept'];
    $empid = $_POST['empid'];
    $emplocation = $_POST['location'];
    $empfloor = $_POST['floor'];
    $itemcat = $_POST['InvCat'];
    $item = $_POST['Iname'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $itemamount = $_POST['Amt'];
    //$posttype = $_POST['request'];

//Validate
    $floorNV = ValidateName($empfloor);
    $categoryNV = ValidateAlphaNumeric($itemcat);
    $itemNV = ValidateAlphaNumeric($item);
    $modelNV = ValidateAlphaNumeric($model);
    $colorNV = ValidateAlphaNumeric($color);
    $itemAV = ValidateNumeric($itemamount);
    
    if ($floorNV == 1 && $categoryNV == 1 && $itemNV == 1 && $modelNV == 1 && $colorNV == 1 && $itemAV == 1) {
            Request($empname, $empdept, $empid, $email, $emplocation, $empfloor, $itemcat, $item, $model, $color, $itemamount);
        
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
                <label for="inputlocation" class="control-label">Employee Location</label>
                <input type="text" name="location" id="location" class="form-control" value="<?php echo $emplocation; ?>"  required readonly/>
                <span class="error"></span>
            </div>
            <?php
            if ($emplocation === 'HQ') {
                ?>
                <div class="form-group">
                    <label for="inputfloor" class="control-label">Floor</label>
                    <select class="form-control" name="floor" id="floor" required>
                        <option disabled selected value> -- select floor -- </option>
                        <option value="Ground">Ground</option>
                        <option value="First">First</option>
                        <option value="Second">Second</option>
                        <option value="Third">Third</option>
                    </select>
                    <?php
                        if ($floorNV != 1) {
                            echo $floorNV;
                        }
                        ?>
                </div>
                <?php
            } else {
                ?>
                <div class="form-group">
                    <label for="inputfloor" class="control-label">Floor</label>
                    <input type="text" name="floor" id="floor" class="form-control" value="Ground"  required readonly/>
                    <span class="error">
                    <?php
                        if ($floorNV != 1) {
                            echo $floorNV;
                        }
                        ?>
                </span>
                </div>
                <?php
            }
            ?>
            <div class="form-group">
                <label for="inputInvCat" class="control-label">Item Category</label>
                <select class="form-control" name="InvCat" id="InvCat" required>
                    <option disabled selected value> -- select category -- </option>
                    <option value="stationary">Stationary Supplies</option>
                    <option value="sanitary">Sanitary Supplies</option>
                    <option value = "tech">IT Supplies</option>
                </select>
                <script>
                    $(document).ready(function () {

                        $("#InvCat").change(function () {
                            var val = $(this).val();
                            if (val == "tech") {
                                $("#Iname").html("\
                                        <option disabled selected value> -- select item -- </option>\n\
                                        <option value='toner'>Toner</option>\n\
                                        <option value='keyboard'>KeyBoard</option>\n\
                                        <option value='mouse'>Mouse</option>\n\
                                        <option value='cpu'>CPU</option>\n\
                                        <option value='monitor'>Monitor</option>"
                                        );
                            } else if (val == "sanitary") {//to-do 
                                $("#Iname").html("<option value='n/a'>n/a</option>");
                            } else if (val == "stationary") {
                                $("#Iname").html("\
                                            <option disabled selected value> -- select item -- </option>\
                                            <option value='stapler'>Stapler</option>\
                                            <option value='staples'>Staples</option>\
                                            <option value='pens'>Pens</option>\
                                            <option value='pencil'>Pencil</option>\
                                            <option value='ruler'>Ruler</option>\
                                            <option value='legalpaper'>Legal Paper</option>\
                                            <option value='letterpaper'>Letter Paper</option>\
                                            <option value='letteropener'>Letter Opener</option>\
                                            <option value='notepad'>Note Pad</option>\
                                            <option value='legalpad'>Legal Pad</option>\
                                            <option value='4quire'>4 Quire Books</option>\
                                            ");
                            }
                        });
                    });
                </script>
            </div>

            <div class="form-group">
                <label for="inputIName" class="control-label">Item</label>
                <select class="form-control" name="Iname" id="Iname" required>
                    <option disabled selected value> -- select category -- </option>

                    <script>
                        $(document).ready(function () {

                            $("#Iname").change(function () {
                                var val = $(this).val();
                                if (val == "toner") {
                                    $("#color").removeAttr("readonly");
                                    $("#color").html("\
                                        <option disabled selected value> -- select item -- </option>\
                                        <option value='black'>Black</option>\n\
                                        <option value='blue'>Blue</option>\n\
                                        <option value='red'>Red</option>\n\
                                        <option value='yellow'>Yellow</option>\n\
                                        <option value='tri'>Tri-Color</option>\n\
                                            ");
                                    $("#model").removeAttr("readonly");
                                    $("#model").html("\
                                        <option disabled selected value> -- select item -- </option>\
                                        <option value='4002i'>TaskAlpha4002i</option>\n\
                                        <option value='3552ci'>TaskAlpha3552ci</option>\n\
                                        <option value='5002i'>TaskAlpha5002i</option>\n\
                                        <option value='393'>OKI390 Series</option>\n\
                                            ");
                                } else {
                                    $("#color").attr("readonly", true);
                                    $("#color").html("\
                                        <option selected value='N/A'>N/A</option>\
                                        ");

                                    $("#model").attr("readonly", true);
                                    $("#model").html("\
                                        <option selected value='N/A'>N/A</option>\
                                        ");

                                }

                            });
                        });
                    </script>
                </select>
                <span class="error">
                    <?php
                        if ($itemNV != 1) {
                            echo $itemNV;
                        }
                        ?>
                </span>
            </div>
            <!--
            <div class="form-group">
                <label for="inputBrand" class="control-label">Brand</label>
                <select class="form-control" name="brand" id="brand" readonly required>
                    <option selected value="n/a">N/A</option>
                </select>
            </div>
            -->

            <div class="form-group">
                <label for="inputModel" class="control-label">Model</label>
                <select class="form-control" name="model" id="model" readonly>
                    <option selected value="n/a">N/A</option>
                </select>
                <span class="error">
                    <?php
                        if ($modelNV != 1) {
                            echo $modelNV;
                        }
                        ?>
                </span>
            </div>

            <div class="form-group">
                <label for="inputColor" class="control-label">Color</label>
                <select name="color" id="color" class="form-control" readonly >
                    <option selected value="n/a">N/A</option>
                </select>
                <span class="error">
                    <?php
                        if ($colorNV != 1) {
                            echo $colorNV;
                        }
                        ?>
                </span>
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