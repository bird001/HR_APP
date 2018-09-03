<?php

include("../db/db3.php");
//include("../db/db2.php");


/* a script written with the purpose of generating loan re-payment schedules monthly
 * 
 */

$sql_get = "select * from LoanApproved where Refreshable = '0'";
$get_arr = array();
$get_arr = $conn->query($sql_get);

$dayofmonth = date("d");

if ($dayofmonth == '28') {
//if ($dayofmonth == '21') {

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
        $actualrepayment = $row['ActualRepayment'];
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


        if ($term != '0' || $loanendbalance != '0') {

            $newterm = $term - 1;
            if ($amountpaid >= $monthlyrepayment) {//if the client pays the correct sum of money update Tailing info
                $sql_insert_new_approved = "INSERT INTO LoanApprovedTail select * from LoanApproved where Editable = 1";
                mysqli_query($conn, $sql_insert_new_approved);//so staff can track payments
                
                $sql_update_new_approved = "Update LoanApproved set MonthlyRepayment = '$actualrepayment', "
                        . "RepaymentPeriod = '$newterm', StartBalance = '$loanendbalance', Editable = 0, Refreshable = 0 where id_val = '$id'";
                mysqli_query($conn, $sql_update_new_approved);//simply updates current entry in loan approved table instead of replicating
            }

            if ($amountpaid < $monthlyrepayment) {//if not then difference is added to the principal
                $difference = $monthlyrepayment - $amountpaid;
                $newmonthlyrepayment = $monthlyrepayment + $difference;

                $sql_insert_new_approved = "INSERT INTO LoanApprovedTail select * from LoanApproved where Editable = 1";
                mysqli_query($conn, $sql_insert_new_approved);

                //set refreshable to 1 so that next month the same record doesn't get updated
                $sql_update_refresh = "update LoanApproved set MonthlyRepayment = '$newmonthlyrepayment', RepaymentPeriod = '$newterm',"
                        . "StartBalance = '$loanendbalance', Editable = 0, Refreshable = 0, OutstandingPayments = 1 where id_val = '$id'";
                mysqli_query($conn, $sql_update_new_approved);
            }
        } else {
            //remove from LoanApproved table and place into the archive table, loan has been paid off
            $sql_moveto_archive = "INSERT INTO LoanApprovedArchive(id_val, EmpName, EmpID, LoanType, LoanID, LoanAmount, DateDisbursed, MonthlyRepayment,"
                    . " ActualRepayment, Payment, PaymentDate, InterestRepaid, PrincipalRepaid, RepaymentPeriod, InterestPerAnnum, StartBalance,"
                    . " EndBalance)"
                    . " Select"
                    . " id_val, EmpName, EmpID, LoanType, LoanID, LoanAmount, DateDisbursed, MonthlyRepayment,"
                    . " ActualRepayment, Payment, PaymentDate, InterestRepaid, PrincipalRepaid, RepaymentPeriod, InterestPerAnnum, StartBalance,"
                    . " EndBalance"
                    . " from LoanApproved where id_val = '$id'";


            mysqli_query($conn, $sql_moveto_archive);
           

            //delete from the Loan Approved Table
            $sql_remove_loan_approved = "delete from LoanApproved where "
                    . "EmpID = '$empid' and "
                    . "LoanID = '$loanid' and "
                    . "LoanAmount = '$loanamount' and "
                    . "DateDisbursed = '$datedisbursed'";
            mysqli_query($conn, $sql_remove_loan_approved);
        }
    }
}
