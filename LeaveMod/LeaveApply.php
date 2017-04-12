<?php
include("../Login/session.php");
include("../db/db3.php");
include("../Templates/header.php");
?>
<script>
    function AvailableDays() {
        //pop up window for uploading SchoolListinngs csv files
        window.open("AvailableDays.php", "Available Days", "location=1,status=1,scrollbars=1,width=400,height=550");
    }
</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../LeaveMod/LeaveNav.php");
include("../Validation/ValidateInput.php");
include('../PHPMailer/SmtpMailer.php');

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$firstname = $row['FirstName'];
$lastname = $row['LastName'];
$dept = $row['EmpDept'];
$empid = $row['EmpID'];

//get managers email address
$getmanager = "select * from Users where EmpDept = '$dept' and EmpRole = 'Manager'";
$result_manager = mysqli_query($conn, $getmanager);
$row_manager = mysqli_fetch_array($result_manager, MYSQLI_ASSOC);
$manageremail = $row_manager['EmpEmail'];

//get HR email address
$gethr = "select * from Users where EmpDept = 'HR' and EmpRole = 'Manager'";
$result_hr = mysqli_query($conn, $gethr);
$row_hr = mysqli_fetch_array($result_hr, MYSQLI_ASSOC);

$hremail = $row_hr['EmpEmail'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $name = $fname . " " . $lname;
    $empnum = $_POST['EmpNum'];
    $empdept = $_POST['EmpDept'];
    $manemail = $_POST['ManEmail'];
    $leavetype = $_POST['LeaveType'];
    $startdate = $_POST['StartDate'];
    $enddate = $_POST['EndDate'];
    $reason = $_POST['Reason'];
    $hremail = $_POST['HREmail'];

    if (ValidateName($fname) === 1) {
        $fnameSet = 1;
    } else {
        $fnameSet = 0;
        $fnameError = ValidateName($fname); //FirstName
    }

    if (ValidateName($lname) === 1) {
        $lnameSet = 1;
    } else {
        $lnameSet = 0;
        $lnameError = ValidateName($lname);
    }

    if (ValidateEmail($manemail) === 1) {
        $manemailSet = 1;
    } else {
        $manemailSet = 0;
        $manemailError = ValidateEmail($manemail);
    }

    /*
      if (empty($manemail)) {
      $manemailError = "Managers Email is required";
      } else {
      $manemail = validate_input($manemail);
      // check if Mail is valid
      if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $manemail)) {
      $manemailError = "Invalid Email Format";
      $manemailSet = 0;
      } else {

      $sql_emailtest = "SELECT * FROM Users WHERE EmpEmail = '$manemail'";
      $selectresult = mysqli_query($conn, $sql_emailtest);
      if (mysqli_num_rows($selectresult) >= 1) {
      //die('email already exists');
      $manemailSet = 1;
      } else {
      $manemailError = "Email doesn't exist, check spelling or contact admin";
      $manemailSet = 0;
      }
      }
      }
     * 
     */

    if (ValidateDatePast($startdate) === 1) {
        $startdateSet = 1;
    } else {
        $startdateSet = 0;
        $startdateError = ValidateDatePast($startdate);
    }

    if (ValidateDatePast($enddate) === 1) {
        $enddateSet = 1;
    } else {
        $enddateSet = 0;
        $enddateError = ValidateDatePast($enddate);
    }

    if (empty($reason)) {
        $reasonError = "Reason for leave is required";
        $reasonSet = 0;
    } else {
        $reasonSet = 1;
    }



//check date and calculate the working days
    $newSdate = new DateTime(date("Y-m-d", strtotime($startdate)));
    $newEdate = new DateTime(date("Y-m-d", strtotime($enddate)));
    $wkdays = getWeekdayDifference($newSdate, $newEdate);


//check date and calculate hours
    $hours = getHourDifference($startdate, $enddate);
    //echo $startdate;
    //echo $enddate;
    //echo $hours;
//get available days from table
    $user = $_SESSION['login_user'];
    $result = mysqli_query($conn, "select * from Leaves where EmpEmail = '$user'");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $availabledays = $row[$leavetype];


    if ($wkdays <= $availabledays || $hours <= $availabledays || $leavetype === 'NoPayLeave') {

        if ($fnameSet == 1 && $lnameSet == 1 && $manemailSet == 1 && $startdateSet == 1 && $enddateSet == 1 && $reasonSet == 1) {


            if ($leavetype === 'Department') {
                //insert the details into the ApplyLeave table
                $leaveapply = "insert into HR_DEPT.ApplyLeave(FirstName,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason)
      values(
      '$fname','$lname','$empnum','$empdept','$email','$manemail','$hremail','$leavetype','$Sdate','$Edate','$hours','$reason'
      )";
                mysqli_query($conn, $leaveapply);

                //send email to associated Manager and HR
                smtpmailer_ApplyLeave($manemail, $email, $name, $empdept, $leavetype, $hours . " hours", $Sdate, $Edate);
                header("Location: ..Leave/LeaveApply.php");
            } else {
                //insert the details into the ApplyLeave table
                $leaveapply = "insert into HR_DEPT.ApplyLeave(FirstName,LastName,EmpID,EmpDept,EmpEmail,ManagerEmail,HREmail,LeaveType,StartDate,EndDate,NumDays,Reason)
      values(
      '$fname','$lname','$empnum','$empdept','$email','$manemail','$hremail','$leavetype','$Sdate','$Edate','$wkdays','$reason'
      )";
                mysqli_query($conn, $leaveapply);

                //send email to associated ManageR
                smtpmailer_ApplyLeave($manemail, $email, $name, $empdept, $leavetype, $wkdays . " days", $Sdate, $Edate);
                header("Location: ..Leave/LeaveApply.php");
            }
        } else {
            echo "error";
        }
    } else {
        $daysError = "Not Enough Days/Hours";
    }
}
?>
<style>
    form {
        display: inline;
    }
</style>

<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="#" method="post" id="form1" class = "form-group" role="form" >

            <div class="form-group">
                <label for="inputFName" class="control-label">First Name</label>
                <input type="text" name="Fname" id="Fname" class="form-control" value="<?php echo $firstname; ?>" required readonly/>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputLName" class="control-label">Last Name</label>
                <input type="text" name="Lname" id="Lname" class="form-control" value="<?php echo $lastname; ?>" required readonly/>
                <span class="error"><?php echo $lnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="Employee#" class="control-label">Employee #</label>
                <input type="number" name="EmpNum" id="EmpNum" class="form-control" value="<?php echo $empid; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputEmpDept" class="control-label">Department</label>
                <input type="text" name="EmpDept" id="EmpDept" class="form-control" value="<?php echo $dept; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputManEmail" class="control-label">Manager's Email</label>
                <input type="email" name="ManEmail" id="ManEmail" class="form-control" value="<?php echo $manageremail; ?>"  required readonly/>
                <span class="error"><?php echo $manemailError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputHREmail" class="control-label">HR Email</label>
                <input type="email" name="HREmail" id="HREmail" class="form-control" value="<?php echo $hremail; ?>" required readonly/>

            </div>

            <div class="form-group">
                <label for="inputLeaveType" class="control-label">Leave Type</label>
                <select class="form-control" name="LeaveType" id="LeaveType" required>
                    <option>Vacation</option>
                    <option>Sick</option>
                    <option>Department</option>
                    <option>VacationOutstanding</option>
                    <option>Bereavement</option>
                    <option>JuryDuty</option>
                    <option>Maternity</option>
                    <option>Study</option>
                    <option>NoPayLeave</option>
                </select>
            </div>


            <div class="form-group">  
                <label for="inputStartDate" class="control-label">FROM</label>
                <input type="datetime-local" name="StartDate" id="StartDate" class="form-control"  required/>
                <span class="error"><?php echo $startdateError; ?></span>
                <span class="error"><?php echo $daysError; ?></span>
            </div>

            <div class="form-group">  
                <label for="inputEndDate" class="control-label">TO</label>
                <input type="datetime-local" name="EndDate" id="EndDate" class="form-control"  required/>
                <span class="error"><?php echo $enddateError; ?></span>
                <span class="error"><?php echo $daysError; ?></span>
            </div>

            <div class="form-group">
                <label for="inputReason" class="control-label">Reason for Leave</label>
                <input type="text" name="Reason" id="Reason" class="form-control" placeholder="To Fly..." required/>
                <span class="error"><?php echo $reasonError; ?></span>
            </div>



            <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 

        </form>
        <button class="btn btn-primary" onclick='AvailableDays();'>Available Days</button>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>