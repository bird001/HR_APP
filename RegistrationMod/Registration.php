<?php
include('../db/db3.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script>
    function Bulk() {
        //pop up window for uploading SchoolListinngs csv files
        window.open("addbulk", "Multiple Registrations", "location=1,status=1,scrollbars=1,width=400,height=400");
    }

</script>

<style>
    form {
        display: inline;
    }
</style>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../RegistrationMod/RegNav.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $functiontype = $_POST['Submit'];


    if ($functiontype == 'Add') {



        $fname = $_POST['Fname'];
        $lname = $_POST['Lname'];
        $empid = $_POST['EmpID'];
        $empemail = $_POST['EmpEmail'];
        $status = $_POST['EmpStatus'];
        $role = $_POST['EmpRole'];
        $empdept = $_POST['EmpDept'];
        $emppos = $_POST['EmpPosition'];
        $empadd = $_POST['EmpAddress'];
        $empphone = $_POST['EmpPhone'];
        $emppass = RandomString(); //md5() to encrypt 
        //$emppass2 = $_POST['EmpPass2']; //md5() to encrypt
        $empdob = $_POST['EmpDOB'];
        $empstart = $_POST['EmpStartDate'];
        $empsex = $_POST['EmpSex'];


        $fname_result = ValidateName($fname);
        $lname_result = ValidateName($lname);
        //$emppos_result = ValidateName($emppos);
        $empemail_result = ValidateEmail($empemail);
        $empphone_result = ValidatePhone($empphone);
        $empdob_result = ValidateDOB($empdob);
        $empdate_result = ValidateDate($empstart);

        //convert DOB to format for DB
        $originalDateDOB = $empdob;
        $newDateDOB = date("d-m-Y", strtotime($originalDateDOB));

        //convert Start Date to format for DB
        $originalDateStart = $empstart;
        $newDateStart = date("d-m-Y", strtotime($originalDateStart));
        $newDateStart2 = date("Y-m-d", strtotime($originalDateStart));



        //begin calculation of leave days---------------------------------------------------------------------------------------------------------------
        $yearsOfEmp = dateDifferenceYears($newDateStart2, date("Y-m-d"));
        //vacation days for managers

        if ($yearsOfEmp >= '0' && $yearsOfEmp <= '5' && $role === 'Manager') {
            $vacationDays = "15";
        }

        if ($yearsOfEmp >= '6' && $yearsOfEmp <= '10' && $role === 'Manager') {
            $vacationDays = "20";
        }

        if ($yearsOfEmp >= 11 && $yearsOfEmp <= 15 && $role === 'Manager') {
            $vacationDays = "25";
        }

        if ($yearsOfEmp >= 16 && $role === 'Manager') {
            $vacationDays = "30";
        }

        //vacation days for non managerial
        if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5 && $role !== 'Manager') {
            $vacationDays = "10";
        }

        if ($yearsOfEmp >= 6 && $yearsOfEmp <= 10 && $role !== 'Manager') {
            $vacationDays = "15";
        }

        if ($yearsOfEmp >= 11 && $role !== 'Manager') {
            $vacationDays = "20";
        }


        //sick days 
        if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5) {
            $sickDays = "10";
        }

        if ($yearsOfEmp >= 6) {
            $sickDays = "15";
        }

        //study days

        if ($yearsOfEmp >= 0 && $yearsOfEmp <= 3) {
            $studyDays = "5";
        }

        if ($yearsOfEmp >= 5) {
            $studyDays = "10";
        }

        //Maternity days

        if ($empsex == "F") {
            $maternityDays = "60";
        } else {
            $maternityDays = "0";
        }


        $juryDutyDays = "3";

        $bereavementDays = "3";

        $deptDays = "72";
        
        $contractbreak = '15';




        //end calculation of leave days-----------------------------------------------------------------------------------------------------------------


        if ($empphone_result == 1 && $empemail_result == 1 && $lname_result == 1 && $fname_result == 1 && $empdob_result == 1 && $empdate_result == 1) {

            //insert into Users table-------------------------------------------------------------------------

            $registration = "insert into HR_DEPT.Users(FirstName,LastName,EmpSex,EmpID,EmpEmail,EmpStatus,EmpDept,EmpRole,EmpPosition,EmpAddress,EmpDOB,EmpPhone,EmpStartDate,EmpPass,TimeCreated,PasswordChanged)
          values(
          '$fname','$lname','$empsex','$empid','$empemail','$status','$empdept','$role','$emppos','$empadd','$newDateDOB','$empphone','$newDateStart','$emppass',NOW(),'0'
          )";
            mysqli_query($conn, $registration);
            //--------------------------------------------------------------------------------------------
            //insert into DLetter tables, disciplinary------------------------------------------------------
            $dletter = "insert into HR_DEPT.DLetters(EmpFName,EmpLName,EmpEmail,EmpID)
          values(
          '$fname','$lname','$empemail','$empid'
          )";

            mysqli_query($conn, $dletter);
            //-----------------------------------------------------------------------------------------
            //insert into Leave table------------------------------------------------------------------------------
            $leave = "insert into HR_DEPT.Leaves(EmpFName,EmpLName,EmpID,EmpEmail,YearsOfEmployment,Vacation,ContractBreak,Sick,Department,Maternity,Study,Bereavement,JuryDuty,
          EmpStartDate,EmpStatus,EmpRole,EmpSex)
          values(
          '$fname','$lname','$empid','$empemail','$yearsOfEmp','$vacationDays','$contractbreak','$sickDays','$deptDays','$maternityDays','$studyDays','$bereavementDays','$juryDutyDays',
          '$newDateStart','$status','$role','$empsex'
          )";
            mysqli_query($conn, $leave);
            //----------------------------------------------------------------------------------------------------------
            //insert into Dashboard table------------------------------------------------------------------------------
            $headline = "New Employee";
            $story = "TIP Welcomes " . $fname . " " . $lname;
            $name_reg = "Reg_Mod";
            $dashboard_reg = "insert into HR_DEPT.DashBoard(Headline,Story,Name,Email,Time)
          values(
          '$headline','$story','$name_reg','$empemail',now()
          )";
            mysqli_query($conn, $dashboard_reg);
            //----------------------------------------------------------------------------------------------------------
            //insert into managers table-----------------------------------------------------------------
            $name = $fname . " " . $lname;
            if ($emprole == "Manager") {
                $managers = "insert into ManagersDepartments (Name,EmpID,EmpEmail,Department) values('$name','$empid','$empmail',"
                        . "'$empdept')";
                mysqli_query($conn, $managers);
            }
            //-------------------------------------------------------------------------------------------

            smtpmailer_Registration($empemail, $fname . " " . $lname, $empdept, $emppass); //send email with password to person
        }
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
                    <input type="text" name="Fname" id="Fname" class="form-control" placeholder="John" required/>
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
                    <input type="text" name="Lname" id="Lname" class="form-control" placeholder="Hancock" required/>
                    <span class="error">
                        <?php
                        if ($lname_result != 1) {
                            echo $lname_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="Employee#" class="control-label">Employee ID</label>
                    <input type="number" name="EmpID" id="EmpID" class="form-control" placeholder="12345" required/>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="control-label">Email</label>
                    <input type="email" name="EmpEmail" id="EmpEmail" class="form-control" placeholder="j.hancock@tipfriendly.com" 
                           data-error="Email address is invalid" required/>
                    <span class="error">
                        <?php
                        if ($empemail_result != 1) {
                            echo $empemail_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputSex" class="control-label">Sex</label>
                    <select class="form-control" name="EmpSex" id="EmpSex" required>
                        <option>M</option>
                        <option>F</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputEmpDept" class="control-label">Department</label>
                    <select class="form-control" name="EmpDept" id="EmpDept" required>
                        <option>IT</option>
                        <option>CSR</option>
                        <option>Claims</option>
                        <option>Delinquency</option>
                        <option>Accounts</option>
                        <option>Marketing</option>
                        <option>Processing</option>
                        <option>HR</option>
                        <option>Branch</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputStatus" class="control-label">Status</label>
                    <!--<input type="text" name="EmpStatus" id="EmpStatus" class="form-control" placeholder="Permanent" required/>-->
                    <select class="form-control" name="EmpStatus" id="EmpStatus" required>
                        <option>Permanent</option>
                        <option>Contract</option>
                        <option>SpecialTemporary</option>
                        <option>Temporary</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputRole" class="control-label">Role</label>
                    <!--<input type="text" name="EmpStatus" id="EmpStatus" class="form-control" placeholder="Permanent" required/>-->
                    <select class="form-control" name="EmpRole" id="EmpRole" required>
                        <option>Employee</option>
                        <option>Supervisor</option>
                        <option>Manager</option>
                        <!-- need to know the leave status and other details on these two positions
                        <option>AssistantGeneralManager</option>
                        <option>GeneralManager</option>
                        -->

                    </select>
                </div>

                <div class="form-group">  
                    <label for="inputPosition" class="control-label">Position</label>
                    <input type="text" name="EmpPosition" id="EmpPosition" class="form-control" placeholder="Delinquency Clerk" required/>
                    <span class="error"> 
                        <?php
                        if ($emppos_result != 1) {
                            echo $emppos_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">  
                    <label for="inputAddress" class="control-label">Address</label>
                    <input type="text" name="EmpAddress" id="EmpAddress" class="form-control" placeholder="72 Pillars" required/>
                </div>

                <div class="form-group">  
                    <label for="inputDOB" class="control-label">D.O.B</label>
                    <input type="date" name="EmpDOB" id="EmpDOB" class="form-control"  required/>
                    <span class="error"> 
                        <?php
                        if ($empdob_result != 1) {
                            echo $empdob_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputPhone" class="control-label">Phone</label>
                    <input type="tel" name="EmpPhone" id="EmpPhone" class="form-control" placeholder="8765555555" required/>
                    <span class="error"> 
                        <?php
                        if ($empphone_result != 1) {
                            echo $empphone_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputEmpStartDate" class="control-label">Date of Employment</label>
                    <input type="date" name="EmpStartDate" id="EmpStartDate" class="form-control" required/>
                    <span class="error"> 
                        <?php
                        if ($empdate_result != 1) {
                            echo $empdate_result;
                        }
                        ?>
                    </span>
                </div>

                <!--
                <div class="form-group">
                    <label for="inputPassword" class="control-label">Password</label>
                    <input type="password" name="EmpPass1"  id="EmpPass1" class="form-control" placeholder="Password" required /><br>
                    <input type="password" name="EmpPass2"  id="EmpPass2" class="form-control" placeholder="Confirm"  required/>
                    
                </div>
                -->
                <input class="btn btn-primary" type="submit" name="Submit" id ="Add" value="Add"/> 

            </form>
            <input class="btn btn-primary" onclick='Bulk();' type="button" name="Submit" id = "Bulk" value="Bulk"/>
        </div>

    </div>
    <?php
    include("../Templates/footer.php");
    ?>
</body>
</html>

