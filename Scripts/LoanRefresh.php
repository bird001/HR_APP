<?php

include("../db/db3.php");


/* a script written with the purpose of generating loan re-payment schedules monthly
 * 
 */

$sql_get = "select * from LoanApproved";
$get_arr = array();
$get_arr = $conn->query($sql_get);

$dayofmonth = date("d");

if ($dayofmonth == '23') {

    while ($row = $get_arr->fetch_assoc()) {

        $id = $row['id_val'];
        $empname = $row['EmpName'];
        $empid = $row['EmpID'];
        $loantype = $row['LoanType'];
        $loanid = $row['LoanID'];
        $loanamount = $row['LoanAmount'];
        $loanendbalance = $row['EndBalance'];
        $datedisbursed = $row['DateDisbursed'];
        $monthlyrepayment = $row['MonthlyRepayment'];
        $amountpaid = $row['Payment'];
        $paymentdate = $row['PaymentDate'];
        $interestrepaid = $row['InterestRepaid'];
        $balancerepaid = $row['PrincipalRepaid'];
        $term = $row['RepaymentPeriod'];
        $interestperannum = $row['InterestPerAnnum'];

        $get_loantype = "select * from LoanTypes where LoanID = '$loanid'";
        $get_loantype_results = mysqli_query($conn, $get_loantype);
        $row_loantype = mysqli_fetch_array($get_loantype_results, MYSQLI_ASSOC);

        $loan_type = $row_loantype['Type'];


        if ($term != '0') {

            $newterm = $term - 1;

            $sql_insert_new_approved = "INSERT INTO LoanApproved(EmpName, EmpID, LoanType, LoanID, LoanAmount, DateDisbursed,
                        MonthlyRepayment, RepaymentPeriod, InterestPerAnnum, StartBalance, Editable)
                        VALUES ('$empname','$empid','$loantype','$loanid','$loanamount','$datedisbursed','$monthlyrepayment',
                        '$newterm','$interestperannum','$loanendbalance',0)";
            mysqli_query($conn, $sql_insert_new_approved);

           
        } else {
            //TO-DO remove from LoanApproved table and place into the archive table, loan has been paid off
        }
    }
}
