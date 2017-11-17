<?php

include('../db/db3.php');
include("../Letters/Letters.php");
include('../Login/session.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');

$operator = $login_session;

$fname = $_POST['Fname'];
$lname = $_POST['Lname'];
$name = $fname . " " . $lname;
$empid = $_POST['EmpID'];
$empdept = $_POST['EmpDept'];
$empadd = $_POST['EmpAdd'];
$empnum = $_POST['EmpNum'];
$loanamount = $_POST['Amount'];
$loanexplode = explode('|', $_POST['LoanType']);
$loantype = $loanexplode[2];
$loanid = $loanexplode[3];
$loaninterest = $loanexplode[0];
$purpose = $_POST['Purpose'];
$payback = $_POST['Payment'];
$term = $_POST['Period'];
$ref1name = $_POST['RefName1'];
$ref1add = $_POST['RefAdd1'];
$ref1phone = $_POST['RefPhone1'];
$ref2name = $_POST['RefName2'];
$ref2add = $_POST['RefAdd2'];
$ref2phone = $_POST['RefPhone2'];
$ref2phone = $_POST['RefPhone2'];
$dateapplied = $_POST['DateA'];

$valFname = ValidateName($fname);
$valLname = ValidateName($lname);
$valEmpnum = ValidateNumeric($empnum);
$valAddress = ValidateAlphaNumeric($empadd);
//do the rest of this validation
if (empty($loanamount)) {
    $loanamountError = "Loan Amount is required";
} else {
    $loanamount = validate_input($loanamount);
// check if Lname only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/", $loanamount)) {
        $loanamountError = "Only numbers allowed"; //LastName
        $loanamountSet = 0;
    } else {
        $loanamountSet = 1;
    }
}

$valPurpose = ValidateAlphaNumeric($purpose);

//TO-DO validation for all input, gonna create a validation function tailored to each...

if ($loanamountSet == 1 && $valPurpose == 1 && $valLname == 1 && $valFname == 1) {

    $loanapply = "insert into LoanApplication(EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
            . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2) "
            . "VALUES ('$name','$empid','$empdept','$empadd','$empnum','$loantype','$loanid','$loanamount','$purpose','$payback','$term',"
            . "'$loaninterest','$dateapplied','$ref1name','$ref1add','$ref1phone','$ref2name','$ref2add','$ref2phone')";

    mysqli_query($conn, $loanapply);

    $accmanemail = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'";
    $accsupemail = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Supervisor'";
    //$accmanemail = "call GetAccountsManager";
    $result_accman = mysqli_query($conn, $accmanemail);
    $result_accsup = mysqli_query($conn, $accsupemail);
    $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
    $row_accsup = mysqli_fetch_array($result_accsup, MYSQLI_ASSOC);
    $accman = $row_accman['EmpEmail']; //Accounts manager email
    $accsup = $row_accsup['EmpEmail']; //Accounts supervisor email
    
    smtpmailer_LoanApplication($accsup, $accman, $name, $empdept);

    header("Location: loanapplication");
} else {
    echo "error";
}
?>