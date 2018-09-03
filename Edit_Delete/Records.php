<?php

include '../db/db2.php';
include '../db/db3.php';
include('../Login/session.php');

echo $id = $_POST['id'];
echo $name = $_POST['action'];
echo $payment = $_POST['payment'];


if ($name == 'UpdatePayment') {
    $get_Loan = "select * from LoanApproved where id_val = '$id'";
    $get_results = mysqli_query($conn, $get_Loan);
    $row_results = mysqli_fetch_array($get_results, MYSQLI_ASSOC);
    
    $newpayment = $payment;//new payment that was added
    
    $endbalance = $row_results['EndBalance']; //get end balance to subtract extra payment from
    $loanid = $row_results['LoanID'];
    $loanmonthlyrepayment = $row_results['MonthlyRepayment'];
    $loanrepayment = $row_results['Payment'];
    $loanrepaymentactual = $row_results['ActualRepayment'];
    $loanprincipalrepaid = $row_results['PrincipalRepaid'];

    $loantype = $row_results['LoanType'];
    $loaninterest = $row_results['InterestPerAnnum'];

    //maths to update loanapproved tables
    $totalrepayment = round(($loanrepayment + $newpayment), 2);
    $newendbalance = round(($endbalance - $newpayment), 2);
    $newprincipalrepaid = round(($loanprincipalrepaid + $newpayment), 2);
    
    
    if(($loanmonthlyrepayment - $totalrepayment) <= $loanrepaymentactual){
        $sql = "UPDATE LoanApproved SET MonthlyRepayment = :monthlypayment, Payment = :payment, PrincipalRepaid = :principalrepaid,"
                . " EndBalance = :newendbal, OutstandingPayments = '0' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':monthlypayment', $loanrepaymentactual);
        $stmt->bindParam(':payment', $totalrepayment);
        $stmt->bindParam(':principalrepaid', $newprincipalrepaid);
        $stmt->bindParam(':newendbal', $newendbalance);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;
    } else {
        $newmonthly = round(($loanmonthlyrepayment - $totalrepayment), 2);
        
        $sql = "UPDATE LoanApproved SET MonthlyRepayment = :monthlypayment, Payment = :payment, PrincipalRepaid = :principalrepaid,"
                . " EndBalance = :newendbal, OutstandingPayments = '0' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':monthlypayment', $newmonthly);
        $stmt->bindParam(':payment', $totalrepayment);
        $stmt->bindParam(':principalrepaid', $newprincipalrepaid);
        $stmt->bindParam(':newendbal', $newendbalance);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;
    }
    
    
    
header("Location: loanpayment");
}
?>