<?php

include '../db/db3.php';
include('../Login/session.php');
include('../PHPMailer/SmtpMailer.php');


$idArr = $_POST['checked_id'];
$functiontype = $_POST['Submit']; //get the type to determine what to execute

$operator = $login_session;
$result_man = mysqli_query($conn, "select * from ApplyLeaveHR where ManagerEmail = '$operator' or HREmail = '$operator' or ManagerResponse is not null");
$row_man = mysqli_fetch_array($result_man, MYSQLI_ASSOC);

//$result_hr = mysqli_query($conn, "select * from ApplyLeaveHR where HREmail = '$operator'");
//$row_hr = mysqli_fetch_array($result_hr, MYSQLI_ASSOC);

$manemail = $row_man['ManagerEmail'];
$hremail = $row_man['HREmail'];

foreach ($idArr as $id) {
    if ($operator === $manemail && $operator === $hremail) {
        //if both the manager and the hr manager are the same person
        if ($functiontype === 'Accept') {

            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where HREmail = '$operator' and id_val ='$id'"; //get the specific row of data
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

            //TO-DO do a verification on the remaning days here as well, persons could be able to spam alot of leave requests and when they are approved they'll
            //have access to alot of days, shut down this by-pass...if you remember
            $remainingdays = $availabledays - $numdays;
            $updateRemainingDays = "update Leaves set $type = '$remainingdays' where EmpEmail = '$empemail'";
            mysqli_query($conn, $updateRemainingDays);
            //-------------------------------------------------------------------------------------------------------
            //update ApplyLeaveHRArchive---------------------------------------------------------------------------------------------------------
            $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,
  StartDate,EndDate,NumDays,Reason,ManagerResponse)
  select
  id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
  from ApplyLeaveHR
  WHERE id_val = '$id'";
            mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
            //update archive table with either accepted or rejected leave app
            $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Accepted', ManagerResponse = 'Accepted' WHERE id_val = $id";
            mysqli_query($conn, $sql_update_hr_archive);


            if ($type === 'Department') {

                $headline_Sdate = date("d F Y, g:i a", strtotime($startdate));
                $headline_Edate = date("d F Y, g:i a", strtotime($enddate));
                $headline = "Leave Notification";
                $story = $name . " will be on " . $type . " leave from " . $headline_Sdate . " to " . $headline_Edate . " for " . $numdays . " hours";
                $name_leave = "Leave_Mod";
                $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
  values(
  '$headline','$story','$name_leave','$operator',now()
  )";
                mysqli_query($conn, $dashboard_leave);

                smtpmailer_LeaveAcceptHR($empemail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {

                $headline_date = date("d F Y", strtotime($startdate));
                $headline = "Leave Notification";
                $story = $name . " will be on " . $type . " leave as of " . $headline_date . " for " . $numdays . " workdays";
                $name_leave = "Leave_Mod";
                $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
  values(
  '$headline','$story','$name_leave','$operator',now()
  )";
                mysqli_query($conn, $dashboard_leave);

                smtpmailer_LeaveAcceptHR($empemail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }

            //delete from applyleavehr
            $sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
            mysqli_query($conn, $sql_delete_hr);
            //----------------
            header("Location: leaverequests");
        } else {
            //rejecting the leave application
            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where HREmail = '$operator' and id_val ='$id'";
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
            $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,
  StartDate,EndDate,NumDays,Reason,ManagerResponse)
  select
  id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
  from ApplyLeaveHR
  WHERE id_val = '$id'";
            mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
            //update archive table with either accepted or rejected leave app
            $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Rejected', ManagerResponse = 'Rejected' WHERE id_val = $id";
            mysqli_query($conn, $sql_update_hr_archive);

            //---------------------------------------------------------------------------------------------------------
            //check if dept leave------------------------------------------------------------------------------
            if ($type === 'Department') {

                smtpmailer_LeaveRejectHR($empemail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {
                smtpmailer_LeaveRejectHR($empemail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }

            //delete from applyleavehr
            $sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
            mysqli_query($conn, $sql_delete_hr);
            //---------------
            header("Location: leaverequests");
        }
    }

    if ($operator === $manemail) {
        //if the employee is a manager then all leave requests must go straight to the General manager
        if ($functiontype === 'Accept') {
            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where ManagerEmail = '$operator' and id_val ='$id'"; //get the specific row of data
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
            //$empemail = $row['EmpEmail'];
            $hremail = $row['HREmail'];
            //-------------------------------------------------------------------------------------------------------
            //update ApplyLeaveHR----------------------------------------------------------------------------------------------

            $sql_insert_hr = "UPDATE ApplyLeaveHR SET ManagerResponse = 'Accepted' WHERE id_val = $id";
            mysqli_query($conn, $sql_insert_hr); //connect to db and execute
            //-----------------------------------------------------------------------------------------------------------------
            //check if dept leave----------------------------------------------------------------------------------------------
            if ($type === 'Department') {
                smtpmailer_LeaveAcceptMan($hremail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {
                smtpmailer_LeaveAcceptMan($hremail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }
            header("Location: leaverequests");
        } else {
            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where ManagerEmail = '$operator' and id_val ='$id'"; //get the specific row of data
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
            //$empemail = $row['EmpEmail'];
            $hremail = $row['HREmail'];
            //-------------------------------------------------------------------------------------------------------
            //update ApplyLeaveHR----------------------------------------------------------------------------------------------

            $sql_insert_hr = "UPDATE ApplyLeaveHR SET ManagerResponse = 'Rejected' WHERE id_val = $id";
            mysqli_query($conn, $sql_insert_hr); //connect to db and execute
            //-----------------------------------------------------------------------------------------------------------------
            //check if dept leave----------------------------------------------------------------------------------------------
            if ($type === 'Department') {
                smtpmailer_LeaveRejectMan($hremail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {
                smtpmailer_LeaveRejectMan($hremail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }
            header("Location: leaverequests");
        }
    } else {
        //if the employee is not a manager, but rather HR then leave requests will be accepted/rejected and the employee will know their fate
        //along with the removal of the record to be entered into the archive muhahaha!!
        if ($functiontype === 'Accept') {
            //----------------
            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where id_val ='$id'"; //get the specific row of data
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

            //TO-DO do a verification on the remaning days here as well, persons could be able to spam alot of leave requests and when they are approved they'll
            //have access to alot of days, shut down this by-pass...if you remember
            $remainingdays = $availabledays - $numdays;
            $updateRemainingDays = "update Leaves set $type = '$remainingdays' where EmpEmail = '$empemail'";
            mysqli_query($conn, $updateRemainingDays);
            //-------------------------------------------------------------------------------------------------------
            //update ApplyLeaveHRArchive---------------------------------------------------------------------------------------------------------
            $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,LeaveType,
  StartDate,EndDate,NumDays,Reason,ManagerResponse)
  select
  id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
  from ApplyLeaveHR
  WHERE id_val = '$id'";
            mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
            //update archive table with either accepted or rejected leave app
            $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Accepted', HREmail = '$operator' WHERE id_val = $id";
            mysqli_query($conn, $sql_update_hr_archive);


            if ($type === 'Department') {

                $headline_Sdate = date("d F Y, g:i a", strtotime($startdate));
                $headline_Edate = date("d F Y, g:i a", strtotime($enddate));
                $headline = "Leave Notification";
                $story = $name . " will be on " . $type . " leave from " . $headline_Sdate . " to " . $headline_Edate . " for " . $numdays . " hours";
                $name_leave = "Leave_Mod";
                $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
  values(
  '$headline','$story','$name_leave','$operator',now()
  )";
                mysqli_query($conn, $dashboard_leave);

                smtpmailer_LeaveAcceptHR($empemail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {

                $headline_date = date("d F Y", strtotime($startdate));
                $headline = "Leave Notification";
                $story = $name . " will be on " . $type . " leave as of " . $headline_date . " for " . $numdays . " workdays";
                $name_leave = "Leave_Mod";
                $dashboard_leave = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
  values(
  '$headline','$story','$name_leave','$operator',now()
  )";
                mysqli_query($conn, $dashboard_leave);

                smtpmailer_LeaveAcceptHR($empemail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }

            //delete from applyleavehr
            //$sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
            //mysqli_query($conn, $sql_delete_hr);
            //----------------
            header("Location: leaverequests");
        } else {//if HR should reject
            //----------------
            $sql_getstuff = "SELECT * FROM ApplyLeaveHR where id_val ='$id'";
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
            $sql_insert_hr_archive = "insert into ApplyLeaveHRArchive(id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,LeaveType,
                StartDate,EndDate,NumDays,Reason,ManagerResponse)
                select
                id_val,Firstname,LastName,EmpID,EmpDept,EmpRole,EmpEmail,ManagerEmail,LeaveType,StartDate,EndDate,NumDays,Reason,ManagerResponse
                from ApplyLeaveHR
                WHERE id_val = '$id'";
            mysqli_query($conn, $sql_insert_hr_archive); //connect to db and execute
            //update archive table with either accepted or rejected leave app
            $sql_update_hr_archive = "UPDATE ApplyLeaveHRArchive SET HRResponse = 'Rejected', HREmail = '$operator' WHERE id_val = $id";
            mysqli_query($conn, $sql_update_hr_archive);

            //---------------------------------------------------------------------------------------------------------
            //check if dept leave------------------------------------------------------------------------------
            if ($type === 'Department') {

                smtpmailer_LeaveRejectHR($empemail, $operator, $name, $dept, $type, $numdays . " hours", $startdate, $enddate); //send email
            } else {
                smtpmailer_LeaveRejectHR($empemail, $operator, $name, $dept, $type, $numdays . " days", $startdate, $enddate); //send email
            }

            //delete from applyleavehr
            //$sql_delete_hr = "delete from ApplyLeaveHR where id_val = '$id'";
            //mysqli_query($conn, $sql_delete_hr);
            //---------------
            header("Location: leaverequests");
        }
    }
}
?>