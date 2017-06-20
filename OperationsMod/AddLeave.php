<?php
include('../db/db3.php');
include('../Validation/ValidateInput.php');
include("../Templates/header_dashboard.php");
include("../RegistrationMod/Updates.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $name = $fname . " " . $lname;
    $empnum = $_POST['EmpNum'];
    $empdept = $_POST['EmpDept'];
    $emprole = $_POST['EmpRole'];
    $leavetype = $_POST['LeaveType'];
    $startdate = date("d-m-Y", strtotime($_POST['StartDate']));
    $enddate = date("d-m-Y", strtotime($_POST['EndDate']));
    $reason = $_POST['Reason'];
    $operator = $_SESSION['login_user'];
    $date_now = date("d-m-Y h:i A");

    $newSdate = new DateTime(date("Y-m-d", strtotime($startdate)));
    $newEdate = new DateTime(date("Y-m-d", strtotime($enddate)));
    $wkdays = getWeekdayDifference($newSdate, $newEdate);
    
    $fname_result = ValidateName($fname);
    $lname_result = ValidateName($lname);
    $empnum_result = ValidateNumeric($empnum);
    $dept_result = ValidateName($empdept);
    $emprole_result = ValidateName($emprole);
    $sdate_result = ValidateDate($startdate);
    $edate_result = ValidateDate($enddate);



    if ($fname_result == 1 && $lname_result == 1 && $empnum_result == 1 && $dept_result == 1 && $emprole_result == 1 && $sdate_result == 1 && $edate_result == 1) {


        $addleave = "insert into ApplyLeaveHRArchive (FirstName, LastName, EmpID, EmpDept, EmpRole, LeaveType, StartDate, EndDate, NumDays, "
                . "Reason, LastEdited, EditedBy) values "
                . "('$fname','$lname','$empnum','$empdept','$emprole','$leavetype','$startdate','$enddate','$wkdays', '$reason','$date_now','$operator')";
        mysqli_query($conn, $addleave);
        echo "<script>window.close();</script>";
    }
}
?>

<body bgcolor="#FFFFFF">
    <br>
    <div align="left" class = "form-group">
        <div style="width:500px;" class = "form-group" align="left">

            <form action="#" method="post" id="form1" class = "form-group" role="form" >

                <div class="form-group">
                    <label for="inputFName" class="control-label">First Name</label>
                    <input type="text" name="Fname" id="Fname" class="form-control" required/>
                    <span class="error">
                        <?php
                        if ($fname_result != 1) {
                          echo $fname_result;
                        }
                        ?>    
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputLName" class="control-label">Last Name</label>
                    <input type="text" name="Lname" id="Lname" class="form-control" required/>
                    <span class="error">
                        <?php
                        if ($lname_result != 1) {
                          echo $lname_result;
                        }
                        ?>    
                    </span>
                </div>

                <div class="form-group">
                    <label for="Employee#" class="control-label">Employee #</label>
                    <input type="number" name="EmpNum" id="EmpNum" class="form-control" required/>
                    <span class="error">
                        <?php
                        if ($empnum_result != 1) {
                          echo $empnum_result;
                        }
                        ?>    
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputEmpDept" class="control-label">Department</label>
                    <input type="text" name="EmpDept" id="EmpDept" class="form-control" required/>
                    <span class="error">
                        <?php
                        if ($dept_result != 1) {
                          echo $dept_result;
                        }
                        ?>    
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="inputEmpRole" class="control-label">Employee Role</label>
                    <input type="text" name="EmpRole" id="EmpRole" class="form-control" required/>
                    <span class="error">
                        <?php
                        if ($emprole_result != 1) {
                          echo $emprole_result;
                        }
                        ?>    
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputLeaveType" class="control-label">Leave Type</label>
                    <select class="form-control" name="LeaveType" id="LeaveType" required>
                        <option disabled selected value> -- select vacation type -- </option>
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
                    <span class="error">
                        <?php
                        if ($sdate_result != 1) {
                          echo $sdate_result;
                        }
                        ?>    
                    </span>
                </div>

                <div class="form-group">  
                    <label for="inputEndDate" class="control-label">TO</label>
                    <input type="datetime-local" name="EndDate" id="EndDate" class="form-control"  required/>
                    <span class="error">
                        <?php
                        if ($edate_result != 1) {
                          echo $edate_result;
                        }
                        ?>    
                    </span>
                </div>
                
                <div class="form-group">
                <label for="inputReason" class="control-label">Reason for Leave</label>
                <input type="text" name="Reason" id="Reason" class="form-control" placeholder="To Fly..." required/>
                
            </div>
                
                <input class="btn btn-primary" type="submit" name="AddLeave" id ="AddLeave" value="AddLeave"/> 

            </form>
        </div>

    </div>
    <?php
    include("../Templates/footer_dashboard.php");
    ?>

