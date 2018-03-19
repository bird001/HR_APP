<?php

include('../db/db3.php');
include('../PHPMailer/SmtpMailer.php');
include('../Login/session.php');

if (isset($_POST['get_id'])) {
    
    $id = $_POST['get_id'];
    $reason = $_POST['get_reason'];
    $numdays = $_POST['get_numdays'];
    $idArr = explode(',', $id);
    
    foreach($idArr as $row){
        
        $archive_query = "select * from ApplyLeaveHRArchive where id_val = '$row' ";
        $archive_result = mysqli_query($conn, $archive_query);
        $archive_row = mysqli_fetch_array($archive_result, MYSQLI_ASSOC);

        //retrieve data from Leave Archive Table
        
        $empid = $archive_row['EmpID'];
        $empname = $archive_row['FirstName']." ".$archive_row['LastName'];
        //$numdays = $archive_row['NumDays'];
        $empdept = $archive_row['EmpDept'];
        $empemail = $archive_row['EmpEmail'];
        $manageremail = $archive_row['ManagerEmail'];
        $leavetype = $archive_row['LeaveType'];
        $startdate = $archive_row['StartDate'];
        $enddate = $archive_row['EndDate'];
        $manresponse = $archive_row['ManagerResponse'];
        $hrresponse = $archive_row['HRResponse'];
        
        //add leave days back to employees leave record 
        $leave_query = "select * from Leaves where EmpId = '$empid'";
        $leave_result = mysqli_query($conn, $leave_query);
        $leave_row = mysqli_fetch_array($leave_result, MYSQLI_ASSOC);
        
        $leavedays = $leave_row[$leavetype];
        $retracted_leave = $leavedays + $numdays;
        
        $update_leave = "update Leaves set $leavetype = '$retracted_leave' where EmpID = '$empid'";
        mysqli_query($conn, $update_leave);
        
        
        //Add record to Retracted Leave table
        $now = date('d-m-Y h:i:s');
        $operator = $login_session;
        
        $insert_query = "insert into RetractedLeave(id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,
                    StartDate,EndDate,Reason,ManagerResponse,HRResponse, DateRetracted)
                    select
                    id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,Reason,ManagerResponse,HRResponse,'$now' from ApplyLeaveHRArchive
                    WHERE id_val = '$row'";
        mysqli_query($conn, $insert_query);
        
        $update_retracted = "update RetractedLeave set RetractedBy = '$operator',NumDays = '$numdays',ReasonRetracted='$reason' where id_val = '$row'";
        mysqli_query($conn, $update_retracted);
        
        //send email to employee and said employee's manager detailing what was done
        smtpmailer_RetractLeave($empname, $empemail, $leavetype, $empdept, $manageremail, $numdays, $startdate, $enddate);
        
        //Removeleave from archive table
        $delete_leave = "delete from ApplyLeaveHRArchive where id_val = '$row'";
        mysqli_query($conn, $delete_leave);
    }
}
?>