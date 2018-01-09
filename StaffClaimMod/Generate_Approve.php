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
$operatordept = $row_k['EmpDept'];
$operatorname = $row_k['FirstName'] . " " . $row_k['LastName'];

$idArr = $_POST['checked_id'];
$functiontype = $_POST['Request']; //get the type to determine what to execute
$reason = $_POST['TextReason'];




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

    $verifiedby = $row['VerifiedBy'];
    $verifieddate = $row['DateVerified'];
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

        LoanAppAccounts($row_prevloans, $empname, $empid, $empdept, $empadd, $empnum, $loantype, $amount, $purpose, $monthlyrepayment, $term, $loaninterest, $dateA, $refname1, $refadd1, $refphone1, $refname2, $refadd2, $refphone2, $verifiedby, $verifieddate, $approvedby, $approveddate, $vettedby, $vetteddate);
    }

    if ($functiontype == 'Verify') {
        if ((strpos($operatorposition, 'Accounts Manager') !== false) || (strpos($operatorposition, 'Accounts Supervisor') !== false)) {
            //if the operator's position is accounts manager || sup
            //get email address for the assistant GM/hr manager
            $hrman = "SELECT * FROM Users WHERE INSTR(EmpPosition, 'HR Manager') > 0";
            $result_hrman = mysqli_query($conn, $hrman);
            $row_hrman = mysqli_fetch_array($result_hrman);
            $hrman_email = $row_hrman['EmpEmail'];
            $hrman_name = $row_hrman['FirstName'] . " " . $row_hrman['LastName'];
            echo $verifieddate = date("F d, Y");
            echo $id;
            //update LoanApply table with who approved and the time approved
            $verify = "update LoanApplication set VerifiedBy = '$operatorname', DateVerified = '$verifieddate' where id_val = '$id'";
            mysqli_query($conn, $verify);

            //notify the Assistant GM/HR Manager
            smtpmailer_AccountsApprove($hrman_email, $empname, $empdept);

            header("Location: loanrequests");
        }
    }

    if ($functiontype == 'Approve') {
        if (strpos($operatorposition, 'General Manager') !== false) {
            //Assistant General Manager Second Level Approval
            if ($operatordept == 'HR') {
                $genman = "select EmpEmail from ManagersDepartments where Department = 'Management'"; //select the General Managers Email
                $result_gm = mysqli_query($conn, $genman);
                $row_gm = mysqli_fetch_array($result_gm, MYSQLI_ASSOC);
                $gmemail = $row_gm['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
                $gmname = $row_gm['Name'];
                $agmapprovedate = date("F d, Y"); //date the assistant general manager approved

                $approval = "update LoanApplication set ApprovedBy = '$operatorname', ApprovedStatus = 'Approved', ApprovedReason = '$reason', "
                        . "DateApproved= '$agmapprovedate' where id_val = '$id'";
                mysqli_query($conn, $approval);

                //notify the General Manager
                smtpmailer_AGMApprove($gmemail, $empname, $empdept);

                header("Location: loanrequests");
            }
            //General Manager Final Approve
            if ($operatordept == 'Management') {
                $accman = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'"; //select the Accounts Managers Email
                $result_accman = mysqli_query($conn, $accman);
                $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
                $accmanemail = $row_accman['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
                $accmanname = $row_accman['FirstName'] . " " . $row_accman['LastName'];
                $gmapprovedate = date("F d, Y"); //date the assistant general manager approved

                $approval = "update LoanApplication set VettedBy = '$operatorname', VettedStatus = 'Approved', VettedReason = '$reason', "
                        . "DateVetted = '$gmapprovedate' where id_val = '$id'";
                mysqli_query($conn, $approval);

                //notify the General Manager
                smtpmailer_GMApproveAccounts($accmanemail, $empname, $empdept);
                smtpmailer_GMApproveEmployee($empemail, $empname, $empdept, $loantype, $amount);


                //move all loan applicatins to a archive table for reference and auditing
                $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                        . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2, 
                        VerifiedBy, DateVerified, ApprovedBy,ApprovedStatus,ApprovedReason, DateApproved, VettedBy, VettedStatus, VettedReason, DateVetted)
                                select
                                id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
                                MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, 
                                    RefName2, RefAdd2, RefPhone2, VerifiedBy, DateVerified, ApprovedBy, ApprovedStatus, ApprovedReason, DateApproved, 
                                    VettedBy, VettedStatus, VettedReason, DateVetted
                                from LoanApplication
                                WHERE id_val = '$id'";
                mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
                //update archive table with either accepted or rejected leave app
                $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Approved' WHERE id_val = $id";
                mysqli_query($conn, $sql_update_loan_archive);

                header("Location: loanrequests");
            }
        }
    }

    if ($functiontype == 'Deny') {

        if (strpos($operatorposition, 'General Manager') !== false) {
            //Assistant General Manager Second Level Approval
            if ($operatordept == 'HR') {
                $genman = "select EmpEmail from ManagersDepartments where Department = 'Management'"; //select the General Managers Email
                $result_gm = mysqli_query($conn, $genman);
                $row_gm = mysqli_fetch_array($result_gm, MYSQLI_ASSOC);
                $gmemail = $row_gm['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
                $gmname = $row_gm['Name'];
                $agmdenialdate = date("F d, Y"); //date the assistant general manager approved


                $denial = "update LoanApplication set ApprovedBy = '$operatorname', ApprovedStatus = 'Denied', ApprovedReason = '$reason', "
                        . "DateApproved= '$agmdenialdate' where id_val = '$id'";
                mysqli_query($conn, $denial);

                //notify the General Manager
                smtpmailer_AGMDenial($gmemail, $empname, $empdept);


                header("Location: loanrequests");
            }
            //General Manager Final Denial
            if ($operatordept == 'Management') {
                $accman = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'"; //select the Accounts Managers Email
                $result_accman = mysqli_query($conn, $accman);
                $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
                $accmanemail = $row_accman['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
                $accmanname = $row_accman['FirstName'] . " " . $row_accman['LastName'];
                $gmdenialdate = date("F d, Y"); //date the assistant general manager approved

                $denial = "update LoanApplication set VettedBy = '$operatorname', VettedStatus = 'Denied', VettedReason = '$reason', "
                        . "DateVetted = '$gmdenialdate' where id_val = '$id'";
                mysqli_query($conn, $denial);

                //notify the General Manager
                smtpmailer_GMDenialAccounts($accmanemail, $empname, $empdept);
                smtpmailer_GMDenialEmployee($empemail, $empname, $empdept, $loantype, $amount);


                //move all loan applicatins to a archive table for reference and auditing
                $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                        . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2, 
                        VerifiedBy, DateVerified, ApprovedBy,ApprovedStatus,ApprovedReason, DateApproved, VettedBy, VettedStatus, VettedReason, DateVetted)
                                select
                                id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
                                MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, 
                                    RefName2, RefAdd2, RefPhone2, VerifiedBy, DateVerified, ApprovedBy, ApprovedStatus, ApprovedReason, DateApproved, 
                                    VettedBy, VettedStatus, VettedReason, DateVetted
                                from LoanApplication
                                WHERE id_val = '$id'";
                mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
                //update archive table with either accepted or rejected leave app
                $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Denied' WHERE id_val = $id";
                mysqli_query($conn, $sql_update_loan_archive);

                //remove this data from the loan application table
                //$removeloanapp = "delete from LoanApplication where id_val = '$id'";
                //mysqli_query($conn, $removeloanapp); //execute the query to remove the loan app

                header("Location: loanrequests");
            }
        }
    }

    if ($functiontype == 'AbsenceApprove') {
        //Assistant General Manager Final Approve when General Manager Absent
        $accman = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'"; //select the Accounts Managers Email
        $result_accman = mysqli_query($conn, $accman);
        $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
        $accmanemail = $row_accman['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
        $accmanname = $row_accman['FirstName'] . " " . $row_accman['LastName'];
        $gmapprovedate = date("F d, Y"); //date the assistant general manager approved

        $approval = "update LoanApplication set VettedBy = '$operatorname', VettedStatus = 'Approved', VettedReason = '$reason', "
                . "DateVetted = '$gmapprovedate', GMAbsent = 'yes' where id_val = '$id'";
        mysqli_query($conn, $approval);

        //notify the General Manager
        smtpmailer_GMApproveAccounts($accmanemail, $empname, $empdept);
        smtpmailer_GMApproveEmployee($empemail, $empname, $empdept, $loantype, $amount);


        //move all loan applicatins to a archive table for reference and auditing
        $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2, 
                        VerifiedBy, DateVerified, ApprovedBy,ApprovedStatus,ApprovedReason, DateApproved, VettedBy, VettedStatus, VettedReason, DateVetted, GMAbsent)
                                select
                                id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
                                MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, 
                                    RefName2, RefAdd2, RefPhone2, VerifiedBy, DateVerified, ApprovedBy, ApprovedStatus, ApprovedReason, DateApproved, 
                                    VettedBy, VettedStatus, VettedReason, DateVetted,GMAbsent
                                from LoanApplication
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Approved' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_loan_archive);

        header("Location: loanrequests");
    }

    if ($functiontype == 'AbsenceDeny') {
        $accman = "select EmpEmail from Users where EmpDept = 'Accounts' and EmpRole = 'Manager'"; //select the Accounts Managers Email
        $result_accman = mysqli_query($conn, $accman);
        $row_accman = mysqli_fetch_array($result_accman, MYSQLI_ASSOC);
        $accmanemail = $row_accman['EmpEmail']; //gets the email address of the Accounts manager and sends an email when someone applies for a loan
        $accmanname = $row_accman['FirstName'] . " " . $row_accman['LastName'];
        $gmdenialdate = date("F d, Y"); //date the assistant general manager approved

        $denial = "update LoanApplication set VettedBy = '$operatorname', VettedStatus = 'Denied', VettedReason = '$reason', "
                . "DateVetted = '$gmdenialdate', GMAbsent = 'yes' where id_val = '$id'";
        mysqli_query($conn, $denial);

        //notify the General Manager
        smtpmailer_GMDenialAccounts($accmanemail, $empname, $empdept);
        smtpmailer_GMDenialEmployee($empemail, $empname, $empdept, $loantype, $amount);


        //move all loan applicatins to a archive table for reference and auditing
        $sql_insert_loan_archive = "insert into LoanApplicationArchive(id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose, "
                . "MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, RefName2, RefAdd2, RefPhone2, 
                        VerifiedBy, DateVerified, ApprovedBy,ApprovedStatus,ApprovedReason, DateApproved, VettedBy, VettedStatus, VettedReason, DateVetted, GMAbsent)
                                select
                                id_val,EmpName, EmpID, EmpDept, EmpAddress, EmpPhone, LoanType, LoanID, AmountRequested, Purpose,
                                MonthlyRepayment, RepaymentPeriod,InterestPerAnnum, DateApplied, RefName1, RefAdd1, RefPhone1, 
                                    RefName2, RefAdd2, RefPhone2, VerifiedBy, DateVerified, ApprovedBy, ApprovedStatus, ApprovedReason, DateApproved, 
                                    VettedBy, VettedStatus, VettedReason, DateVetted, GMAbsent
                                from LoanApplication
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_loan_archive); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_loan_archive = "UPDATE LoanApplicationArchive SET Status = 'Denied' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_loan_archive);

        //remove this data from the loan application table
        $removeloanapp = "delete from LoanApplication where id_val = '$id'";
        mysqli_query($conn, $removeloanapp); //execute the query to remove the loan app

        header("Location: loanrequests");
    }



    if ($functiontype == 'Disburse') {

        if (!empty($verifiedby) && !empty($approvedby) && !empty($vettedby)) {

            $disbursed_date = date("F d, Y");
            //$balanceoutstanding = $amount * (1+ (($loaninterest/100)/12));

            $sql_insert_loan_approved = "insert into LoanApproved (id_val, EmpName, EmpID, LoanType, LoanID, LoanAmount, DateDisbursed,
                MonthlyRepayment,ActualRepayment, RepaymentPeriod, InterestPerAnnum, StartBalance, Editable)
                select id_val, EmpName, EmpID, LoanType, LoanID, AmountRequested, '$disbursed_date', MonthlyRepayment,MonthlyRepayment, RepaymentPeriod, 
                    InterestPerAnnum, '$amount', '0' from LoanApplication
                where id_val = '$id'";
            mysqli_query($conn, $sql_insert_loan_approved);

            $sql_update_loan_archive = "update LoanApplicationArchive set DisbursedBy = '$operatorname', DateDisbursed = '$disbursed_date' where id_val = $id";
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