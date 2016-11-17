<?php

include '../db/db3.php';
include('../Login/session.php');
include('../PHPMailer/SmtpMailer.php');



$email = $login_session;
$id = $_GET['id'];
$column = $_GET['column'];

if ($_GET['check'] === "true") {
    $check = 1; //set check value in DB to 1
    //insert into the archive table for fututre reference
    $sql_insert_archive = "insert into ApplyLeaveArchive(id_val,Firstname,LastName,EmpID,EmpDept,ManagerEmail,LeaveType,StartDate,EndDate,NumDays,Reason)
                                select
                                id_val,Firstname,LastName,EmpID,EmpDept,ManagerEmail,LeaveType,StartDate,EndDate,NumDays,Reason
                                from ApplyLeave
                                WHERE id_val = '$id'";
    mysqli_query($conn, $sql_insert_archive); //connect to db and execute
    //update archive table with either accepted or rejected leave app
    $sql_update_archive = "UPDATE ApplyLeaveArchive SET $column = $check WHERE id_val = $id";
    mysqli_query($conn, $sql_update_archive);


    //some value needed for sorting
    $email = $_SESSION['login_user'];
    $sql1 = "SELECT * FROM ApplyLeave where ManagerEmail = '$email'";
    $sql2 = "SELECT * FROM ApplyLeaveHR where HREmail = '$email'";
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);
    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

    $manemail = $row1['ManagerEmail'];
    $hremail = $row2['HREmail'];



    //if the request was accepted by HR
    if ($column === 'Accept' && $hremail === $email) {
        $sql_getstuff = "SELECT * FROM ApplyLeaveHR where HREmail = '$email' and id_val ='$id'"; //get the specific row of data
        $result = mysqli_query($conn, $sql_getstuff);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $startdate = $row['StartDate'];
        //$startdate_leave = date("d F Y", $startdate);
        $enddate = $row['EndDate'];
        //$enddate_leave = date("d F Y", $enddate);
        $numdays = $row['NumDays'];
        $name = $row['FirstName'] . " " . $row['LastName'];
        $dept = $row['EmpDept'];
        $type = $row['LeaveType'];
        $empemail = $row['EmpEmail'];

        //subtract the days from the relevant category and update AvailableDays table if the leave was accepted
        $result = mysqli_query($conn, "select * from Leaves where EmpEmail = '$empemail'");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $availabledays = $row[$type];

        //TO-DO do a vaerification on the remaning days here as well, persons could be able to spam alot of leave requests and when they are approved they'll 
        //have access to alot of days, shut down this by-pass...if you remember
        $remainingdays = $availabledays - $numdays;
        $updateRemainingDays = "update Leaves set $type = '$remainingdays' where EmpEmail = '$empemail'";
        mysqli_query($conn, $updateRemainingDays);
        //-------------------------------------------------------------------------------------------------------
        //update ApplyLeaveHRArchive---------------------------------------------------------------------------------------------------------
        $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,
            StartDate,EndDate,NumDays,Reason,ManagerResponse)
                                select
                                id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
                                from ApplyLeaveHR
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Accepted' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_hr_archive);

        //---------------------------------------------------------------------------------------------------------
        //insert into Dashboard table------------------------------------------------------------------------------
        if ($type === 'Department') {

            $headline_Sdate = date("d F Y, g:i a", strtotime($startdate));
            $headline_Edate = date("d F Y, g:i a", strtotime($enddate));
            $headline = "Leave Notification";
            $story = $name . " will be on " . $type . " leave from " . $headline_Sdate . " to " . $headline_Edate . " for " . $numdays . " hours";
            $name_leave = "Leave_Mod";
            $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
              values(
              '$headline','$story','$name_leave','$email',now()
              )";
            mysqli_query($conn, $dashboard_leave);

            smtpmailer_LeaveAcceptHR($empemail, $email, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
        } else {

            $headline_date = date("d F Y", strtotime($startdate));
            $headline = "Leave Notification";
            $story = $name . " will be on " . $type . " leave as of " . $headline_date . " for " . $numdays . " workdays";
            $name_leave = "Leave_Mod";
            $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
              values(
              '$headline','$story','$name_leave','$email',now()
              )";
            mysqli_query($conn, $dashboard_leave);

            smtpmailer_LeaveAcceptHR($empemail, $email, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
        }

        //delete from applyleavehr
        $sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
        mysqli_query($conn, $sql_delete_hr);
        //----------------------------------------------------------------------------------------------------------
    }


    //if accept and is a manager
    if ($column === 'Accept' && $manemail === $email) {
        $sql_getstuff = "SELECT * FROM ApplyLeave where ManagerEmail = '$email' and id_val ='$id'"; //get the specific row of data
        $result = mysqli_query($conn, $sql_getstuff);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $startdate = $row['StartDate'];
        //$startdate_leave = date("d F Y", $startdate);
        $enddate = $row['EndDate'];
        //$enddate_leave = date("d F Y", $enddate);
        $numdays = $row['NumDays'];
        $name = $row['FirstName'] . " " . $row['LastName'];
        $dept = $row['EmpDept'];
        $type = $row['LeaveType'];
        $empemail = $row['EmpEmail'];
        $hremail = $row['HREmail'];
        //-------------------------------------------------------------------------------------------------------
        //update ApplyLeaveHR----------------------------------------------------------------------------------------------

        $sql_insert_hr = "insert into ApplyLeaveHR(id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason)
                                select
                                id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason
                                from ApplyLeave
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_hr); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_hr = "UPDATE ApplyLeaveHR SET ManagerResponse = 'Accepted' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_hr);

        //-----------------------------------------------------------------------------------------------------------------
        //check if dept leave----------------------------------------------------------------------------------------------
        if ($type === 'Department') {
            smtpmailer_LeaveAcceptMan($hremail, $email, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
        } else {
            smtpmailer_LeaveAcceptMan($hremail, $email, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
        }

        //remove leave app from ApplyLeave Table as it has already been addressed
        $sql_delete = "delete from ApplyLeave where id_val = '$id'";
        mysqli_query($conn, $sql_delete);
    }



    //reject
    if ($column === 'Reject' && $hremail === $email) {//if the leave application is rejected and it was done by an Hr
        $sql_getstuff = "SELECT * FROM ApplyLeaveHR where HREmail = '$email' and id_val ='$id'";
        $result = mysqli_query($conn, $sql_getstuff);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $startdate = $row['StartDate'];
        $enddate = $row['EndDate'];
        $numdays = $row['NumDays'];
        $name = $row['FirstName'] . " " . $row['LastName'];
        $dept = $row['EmpDept'];
        $type = $row['LeaveType'];
        $empemail = $row['EmpEmail'];


        //update ApplyLeaveHRArchive---------------------------------------------------------------------------------------------------------
        $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,
            StartDate,EndDate,NumDays,Reason,ManagerResponse)
                                select
                                id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
                                from ApplyLeaveHR
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Rejected' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_hr_archive);

        //---------------------------------------------------------------------------------------------------------
        //check if dept leave------------------------------------------------------------------------------
        if ($type === 'Department') {

            smtpmailer_LeaveRejectHR($empemail, $email, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
        } else {
            smtpmailer_LeaveRejectHR($empemail, $email, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
        }

        //delete from applyleavehr
        $sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
        mysqli_query($conn, $sql_delete_hr);
    }

    if ($column === 'Reject' && $manemail === $email) {
        $sql_getstuff = "SELECT * FROM ApplyLeave where ManagerEmail = '$email' and id_val ='$id'"; //get the specific row of data
        $result = mysqli_query($conn, $sql_getstuff);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $startdate = $row['StartDate'];
        //$startdate_leave = date("d F Y", $startdate);
        $enddate = $row['EndDate'];
        //$enddate_leave = date("d F Y", $enddate);
        $numdays = $row['NumDays'];
        $name = $row['FirstName'] . " " . $row['LastName'];
        $dept = $row['EmpDept'];
        $type = $row['LeaveType'];
        $empemail = $row['EmpEmail'];
        $hremail = $row['HREmail'];
        //-------------------------------------------------------------------------------------------------------
        //update ApplyLeaveHR----------------------------------------------------------------------------------------------

        $sql_insert_hr = "insert into ApplyLeaveHR(id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason)
                                select
                                id_val,Firstname,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason
                                from ApplyLeave
                                WHERE id_val = '$id'";
        mysqli_query($conn, $sql_insert_hr); //connect to db and execute
        //update archive table with either accepted or rejected leave app
        $sql_update_hr = "UPDATE ApplyLeaveHR SET ManagerResponse = 'Rejected' WHERE id_val = $id";
        mysqli_query($conn, $sql_update_hr);

        //-----------------------------------------------------------------------------------------------------------------
        //check if dept leave----------------------------------------------------------------------------------------------
        if ($type === 'Department') {
            smtpmailer_LeaveRejectMan($hremail, $email, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
        } else {
            smtpmailer_LeaveRejectMan($hremail, $email, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
        }

        //remove leave app from ApplyLeave Table as it has already been addressed
        $sql_delete = "delete from ApplyLeave where id_val = '$id'";
        mysqli_query($conn, $sql_delete);
    }
}
?>