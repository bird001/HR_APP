<?php
include('../db/db3.php');
include('../Validation/ValidateInput.php');
include("../Templates/header.php");
include("../RegistrationMod/Updates.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $loanname = $_POST['LoanName'];
    $loanid = $_POST['LoanID'];
    $interest = $_POST['Interest'];
    $loanterm = $_POST['LoanTerm'];
    $loantype = $_POST['LoanType'];


    $loanname_result = ValidateName($loanname);
    $loanid_result = ValidatePhone($loanid);
    $interest_result = ValidatePhone($interest);
    $loanterm_result = ValidatePhone($loanterm);
    $loantype_result = ValidateName($loantype);



    if ($loanname_result == 1 && $loanid_result == 1 && $interest_result == 1 && $loanterm_result == 1 && $loantype_result == 1) {


        $addloan = "insert into LoanTypes (LoanName, LoanID, InterestPerAnnum,TimeToPay,Type) values "
                . "('$loanname','$loanid','$interest','$loanterm','$loantype')";
        mysqli_query($conn, $addloan);
        echo "<script>window.close();</script>";
    }
}
?>

<body bgcolor="#FFFFFF">
    <br>
    <div align="left" class = "form-group">
        <div style="width:500px;" class = "form-group" align="left">

            <form action="#" method="post" id="form1" class = "form-group" role="form" >

                <div class="form-group">
                    <label for="inputLoanName" class="control-label">Loan Name</label>
                    <input type="text" name="LoanName" id="LoanName" class="form-control" required/>
                    <span class="error">
                        <?php
                        //if ($fname_result != 1) {
                        //  echo $fname_result;
                        //}
                        ?>
                    </span>

                </div>

                <div class="form-group">
                    <label for="inputLoanID" class="control-label">Loan ID</label>
                    <input type="number" name="LoanID" id="LoanID" class="form-control" value="<?php //echo $empid     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($fname_result != 1) {
                        //  echo $fname_result;
                        //}
                        ?>
                    </span>

                </div>

                <div class="form-group">
                    <label for="inputInterest" class="control-label">Interest/Annum</label>
                    <input type="number" name="Interest" id="Interest" class="form-control" value="<?php //echo $empemail     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($lname_result != 1) {
                        //  echo $lname_result;
                        //}
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputLoanTerm" class="control-label">Loan Term</label>
                    <input type="number" name="LoanTerm" id="LoanTerm" class="form-control" value="<?php //echo $empnum     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($lname_result != 1) {
                        //  echo $lname_result;
                        //}
                        ?>
                    </span>
                </div>
                
                <div class="form-group">
                <label for="inputLoanType" class="control-label">Loan Type</label>
                <select class="form-control" name="LoanType" id="LoanType" required>
                    <option>Select Loan</option>
                    <option>Reducing</option>
                    <option>NoInterest</option>
                    <option>Straight</option>
                    
                </select>
            </div>
                <input class="btn btn-primary" type="submit" name="AddLoan" id ="AddLoan" value="AddLoan"/> 

            </form>
        </div>

    </div>
</body>


