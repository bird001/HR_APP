<?php
include("../Login/session.php");
include("../db/db3.php");
include("../db/db2.php");
include("../Templates/header.php");
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../StaffClaimMod/ClaimsNav.php");

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$firstname = $row['FirstName'];
$lastname = $row['LastName'];
$empid = $row['EmpID'];
$dept = $row['EmpDept'];
$add = $row['EmpAddress'];
$phone = $row['EmpPhone'];
?>


<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="../StaffClaimMod/LoanAppBack.php" method="post" name="mealtravel" id="mealtravel" class = "form-group" >

            <div class="form-group">
                <label for="inputFName" class="control-label">First Name</label>
                <input type="text" name="Fname" id="Fname" class="form-control" value="<?php echo $firstname; ?>" required readonly/>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputLName" class="control-label">Last Name</label>
                <input type="text" name="Lname" id="Lname" class="form-control" value="<?php echo $lastname; ?>" required readonly/>
                <span class="error"><?php echo $lnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputEmpID" class="control-label">Employee #</label>
                <input type="text" name="EmpID" id="EmpID" class="form-control" value="<?php echo $empid; ?>" required readonly/>
                <span class="error"><?php echo $lnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputDate" class="control-label">Date</label>
                <input type="text" name="DateA" id="DateA" class="form-control" value="<?php echo date("F d, Y"); ?>" required readonly/>
                <span class="error"><?php echo $lnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputDept" class="control-label">Department</label>
                <input type="text" name="EmpDept" id="EmpDept" class="form-control" value="<?php echo $dept; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputEmpAdd" class="control-label">Address</label>
                <input type="text" name="EmpAdd" id="EmpAdd" class="form-control" value="<?php echo $add; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputEmpNum" class="control-label">Phone#</label>
                <input type="text" name="EmpNum" id="EmpNum" class="form-control" value="<?php echo $phone; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputAmount" class="control-label">Amount Requested</label>
                <input type="number" name="Amount" id="Amount" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="inputLoanType" class="control-label">Loan Type</label>
                <select class="form-control" name="LoanType" id="LoanType" required>
                    <option>Select Loan</option>
                    <?php
                    $sql_loans = "select * from LoanTypes";
                    $result_loans = $dbh->query($sql_loans);
                    $row_loans = $result_loans->fetchAll();


                    foreach ($row_loans as $row) {
                        echo '<option value="' . $row['InterestPerAnnum'] . '|' . $row['TimeToPay'] . '|' . $row['LoanName'] . '|' . $row['LoanID'] . '">' . $row['LoanName'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <script>
                //Sets Payback period depending on loan selected
                function roundToTwo(num) {
                    return +(Math.round(num + "e+2") + "e-2");
                }

                $("#LoanType").change(function () {
                    var loanValues = $("#LoanType").val().split('|');
                    var loanInterest = loanValues[0] / 100; //interest
                    var loanTerm = loanValues[1]; //term of loan
                    var loanAmount = parseInt($("#Amount").val());
                    var loanPayment = roundToTwo((loanAmount + (loanAmount * loanInterest)) / loanTerm);

                    $("#Payment").val(loanPayment);
                    $("#Period").val(loanTerm);

                    //alert("value is "+ loanTerm);
                });

            </script>

            <div class="form-group">
                <label for="inputPurpose" class="control-label">Purpose</label>
                <input type="text" name="Purpose" id="Purpose" class="form-control" required/>
            </div>


            <div class="form-group">
                <label for="inputPayment" class="control-label">Monthly Repayment</label>
                <input type="text" name="Payment" id="Payment" class="form-control" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputPeriod" class="control-label">Repayment Period</label>
                <input type="text" name="Period" id="Period" class="form-control" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputRef1" class="control-label">Reference 1</label>
            </div>
            <br>

            <div class="form-group">
                <label for="inputRefName1" class="control-label">Name</label>
                <input type="text" name="RefName1" id="RefName1" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="inputRefAdd1" class="control-label">Address</label>
                <input type="text" name="RefAdd1" id="RefAdd1" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="inputRefPhone1" class="control-label">Phone#</label>
                <input type="text" name="RefPhone1" id="RefPhone1" class="form-control" required/>
            </div>

            <br>

            <div class="form-group">
                <label for="inputRef2" class="control-label">Reference 2</label>
            </div>

            <br>

            <div class="form-group">
                <label for="inputRefName2" class="control-label">Name</label>
                <input type="text" name="RefName2" id="RefName2" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="inputRefAdd2" class="control-label">Address</label>
                <input type="text" name="RefAdd2" id="RefAdd2" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="inputRefPhone2" class="control-label">Phone#</label>
                <input type="text" name="RefPhone2" id="RefPhone2" class="form-control" required/>
            </div>

            <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
        </form>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>