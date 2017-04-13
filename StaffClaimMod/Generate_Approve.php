<?php

// session_start();
include('../db/db3.php');
include('../db/db2.php');
include('../Login/session.php');
include('../Letters/Letters.php');
include('../PHPMailer/SmtpMailer.php');

$operator = $login_session;
$result_k = mysqli_query($conn, "select * from Users where EmpEmail = '$operator'");
$row_k = mysqli_fetch_array($result_k, MYSQLI_ASSOC);
$operatorposition = $row_k['EmpPosition'];
$operatorname = $row_k['FirstName'] . " " . $row_k['LastName'];

$idArr = $_POST['checked_id'];
$functiontype = $_POST['Request']; //get the type to determine what to execute




foreach ($idArr as $id) {

    $result = mysqli_query($conn, "select * from LoanApplication where id_val = '$id' ");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);



    $empname = $row['EmpName'];
    $empid = $row['EmpID'];
    $empdept = $row['EmpDept'];
    $empadd = $row['EmpAddress'];
    $empnum = $row['EmpPhone'];
    $loantype = $row['LoanType'];
    $amount = $row['AmountRequested'];
    $purpose = $row['Purpose'];
    $monthlyrepayment = $row['MonthlyRepayment'];
    $term = $row['RepaymentPeriod'];
    $loaninterest = $row['InterestPerAnnum'];
    $dateA = $row['DateApplied'];
    $refname1 = $row['RefName1'];
    $refadd1 = $row['RefAdd1'];
    $refphone1 = $row['RefPhone1'];
    $refname2 = $row['RefName2'];
    $refadd2 = $row['RefAdd2'];
    $refphone2 = $row['RefPhone2'];

    $approvedby = $row['ApprovedBy'];
    $approveddate = $row['DateApproved'];
    $vettedby = $row['VettedBy'];
    $vetteddate = $row['DateVetted'];


    //get previous loans
    $sql_prevloans = "SELECT * FROM LoanApproved where EmpID = '$empid'";
    $result_prevloans = $dbh->query($sql_prevloans);
    $row_prevloans = $result_prevloans->fetchAll();


    //get email of Loan Applicant
    $empmail = "select * from Users where EmpID = '$empid'";
    $results_empmail = mysqli_query($conn, $empmail);
    $row_empmail = mysqli_fetch_array($results_empmail, MYSQLI_ASSOC);

    $empemail = $row_empmail['EmpEmail'];


    if ($functiontype == 'Generate') {

        LoanAppAccounts($row_prevloans, $empname, $empid, $empdept, $empadd, $empnum, $loantype, $amount, $purpose, $monthlyrepayment, $term, $loaninterest, $dateA, $refname1, $refadd1, $refphone1, $refname2, $refadd2, $refphone2, $approvedby, $approveddate, $vettedby, $vetteddate);
    }



    if ($functiontype == 'Approve') {

        if (strpos($operatorposition, 'General Manager') == false) {

            //if the operator's position is not AGM then execute this code
            //get email address for the assistant GM
            $asstgm = "SELECT * FROM Users WHERE INSTR(EmpPosition, 'Assistant General') > 0";
            $result_asstgm = mysqli_query($conn, $asstgm);
            $row_asstgm = mysqli_fetch_array($result_asstgm);
            $asstgm_email = $row_asstgm['EmpEmail'];
            $asstgm_name = $row_asstgm['FirstName'] . " " . $row_asstgm['LastName'];
            $accountsapprovedate = date("F d, Y");

            //update LoanApply table with who approved and the time approved
            $approval = "update LoanApplication set ApprovedBy = '$operatorname', DateApproved = '$accountsapprovedate' where id_val = '$id'";
            mysqli_query($conn, $approval);

            //notify the Assistant GM
            smtpmailer_AccountsApprove($asstgm_email, $empname, $empdept);

            header("Location: loanrequests");
            
        } else {

            //if operator is the AGM execute this code
            $accmanemail = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'";
            $result_accman = mysqli_query($conn, $accmanemail);
            $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
            $accman = $row_accman['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
            $accmanname = $row_accman['FirstName'] . " " . $row_accman['LastName'];
            $agmapprovedate = date("F d, Y");

            $approval = "update LoanApplication set VettedBy = '$operatorname', DateVetted = '$agmapprovedate' where id_val = '$id'";
            mysqli_query($conn, $approval);

            //notify the Assistant GM
            smtpmailer_GMApprove($accman, $empname, $empdept);
            smtpmailer_GMApprove2($empemail, $empname, $empdept, $loantype, $amount);


            //move all loan applicatins to a archive table for reference and auditing
            $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                    . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2, 
                        ApprovedBy, DateApproved, VettedBy, DateVetted)
                                select
                                id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
                                MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, 
                                    RefName2, RefAdd2, RefPhone2, ApprovedBy, DateApproved, VettedBy, DateVetted
                                from LoanApplication
                                WHERE id_val = '$id'";
            mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
            //update archive table with either accepted or rejected leave app
            $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Approved' WHERE id_val = $id";
            mysqli_query($conn, $sql_update_loan_archive);

            header("Location: loanrequests");
        }
    }

    if ($functiontype == 'Deny') {



        smtpmailer_GMDeny($empemail, $empname, $empdept, $loantype, $amount);


        //move all loan applicatins to a archive table for reference and auditing
        $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2,
                    ApprovedBy, DateApproved, VettedBy, DateVetted)
          select
          id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
          MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1,
          RefName2, RefAdd2, RefPhone2, ApprovedBy, DateApproved, VettedBy, DateVetted
          from LoanApplication
          WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Rejected' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_loan_archive);


        header("Location: loanrequests"); //go back to loan request page
    }


    if ($functiontype == 'Disburse') {

        if (!empty($approvedby) && !empty($vettedby)) {

            $disbursed_date = date("F d, Y");
            //$balanceoutstanding = $amount * (1+ (($loaninterest/100)/12));

            $sql_insert_loan_approved = "insert into LoanApproved (id_val, EmpName, EmpID, LoanType, LoanID, LoanAmount, DateDisbursed,
                MonthlyRepayment,ActualRepayment, RepaymentPeriod, InterestPerAnnum, StartBalance, Editable)
                select id_val, EmpName, EmpID, LoanType, LoanID, AmountRequested, '$disbursed_date', MonthlyRepayment,MonthlyRepayment, RepaymentPeriod, 
                    InterestPerAnnum, '$amount', '0' from LoanApplication
                where id_val = '$id'";
            mysqli_query($conn, $sql_insert_loan_approved);

            $sql_update_loan_archive = "update LoanApplicationArchive set DisbursedBy = '$operatorname' where id_val = $id";
            mysqli_query($conn, $sql_update_loan_archive); //update loan archive table with who disbursed loan, for accountability

            smtpmailer_Disburse($empemail, $empname, $empdept, $loantype, $amount);

            //remove this data from the loan application table
            $removeloanapp = "delete from LoanApplication where id_val = '$id'";
            mysqli_query($conn, $removeloanapp); //execute the query to remove the loan app

            header("Location: loanrequests"); //go back to loan request page
        } else {
            $disburseerror = "Not approved. Cannot be disbursed";
            header("Location: loanrequests");
        }
    }
}
?>