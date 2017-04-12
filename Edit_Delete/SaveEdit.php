<?php

include '../db/db2.php';
include '../db/db3.php';
include('../Login/session.php');

echo $column = $_POST['column'];
echo $newValue = $_POST['editval'];
echo $id = $_POST['id'];
echo $name = $_POST['name'];

if ($name == 'LoanPayments') {//for the LoanPayment table
    $get_Loan = "select * from LoanApproved where id_val = '$id'";
    $get_results = mysqli_query($conn, $get_Loan);
    $row_results = mysqli_fetch_array($get_results, MYSQLI_ASSOC);

    $amount = $row_results['LoanAmount'];
    $balance = $row_results['StartBalance'];
    $loanid = $row_results['LoanID'];
    $loanrepayment = $row_results['MonthlyRepayment'];


    $get_loantype = "select * from LoanTypes where LoanID = '$loanid'";
    $get_loan = mysqli_query($conn, $get_loantype);
    $row_loan = mysqli_fetch_array($get_loan, MYSQLI_ASSOC);

    $loantype = $row_loan['Type'];
    $loaninterest = $row_loan['InterestPerAnnum'];
    $loanterm = $row_loan['TimeToPay'];
    $totalint = $row_loan['TotalInterest'];


    if ($loantype == 'Reducing') {

        $paymentTime = date("F d, Y");
        $interestrepaid = round(($balance * (($loaninterest / 100) / 12)), 2);
        $balancerepaid = round($newValue - $interestrepaid, 2);
        $endbal = $balance - $balancerepaid;
    }

    if ($loantype == 'Straight') {//remember to check this out
        $paymentTime = date("F d, Y");
        $interestrepaid = round(($amount * (($loaninterest / 100) / 12)), 2);
        $balancerepaid = round($newValue - $interestrepaid, 2);
        $endbal = $balance - $balancerepaid;
    }

    if ($loantype == 'NoInterest') {

        $paymentTime = date("F d, Y");
        $interestrepaid = 0;
        $balancerepaid = round($newValue - $interestrepaid, 2);
        $endbal = $balance - $balancerepaid;
    }


    $sql = "UPDATE LoanApproved SET $column = :value, PaymentDate = '$paymentTime', InterestRepaid = '$interestrepaid',"
            . " PrincipalRepaid = '$balancerepaid', EndBalance = '$endbal', Editable = '1', Refreshable = '0' WHERE id_val = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':value', $newValue);
    $stmt->bindParam(':id', $id);
    $response['success'] = $stmt->execute();
    $response['value'] = $newValue;
}
?>