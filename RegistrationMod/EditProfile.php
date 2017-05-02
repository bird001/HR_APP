<?php
include('../db/db3.php');
include('../Validation/ValidateInput.php');
include("../Templates/header.php");
include("../RegistrationMod/Updates.php");


$idArr = $_POST['checked_id'];
$functiontype = $_POST['EditProfile'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if ($functiontype == 'EditProfile') {

        if (!empty($idArr)) {
            foreach ($idArr as $id) {

                $result = mysqli_query($conn, "select * from Users where id_val = '$id' "); //get the relevant user
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//get the relevent user data
                $fname = $row['FirstName'];
                $lname = $row['LastName'];
                $empid = $row['EmpID'];
                $empemail = $row['EmpEmail'];
                $empsex = $row['EmpSex'];
                $empdept = $row['EmpDept'];
                $status = $row['EmpStatus'];
                $role = $row['EmpRole'];
                $emppos = $row['EmpPosition'];
                $empadd = $row['EmpAddress'];
                $empphone = $row['EmpPhone'];
                $empdob = $row['EmpDOB'];
                $empstart = $row['EmpStartDate'];
                $empnum = $row['id_val'];
            }
        }
    }


    if ($functiontype == 'Update') {
        $fname = $_POST['Fname'];
        $lname = $_POST['Lname'];
        $empid = $_POST['EmpID'];
        $empnum = $_POST['EmpNum'];
        $empemail = $_POST['EmpEmail'];
        $status = $_POST['EmpStatus'];
        $role = $_POST['EmpRole'];
        $empdept = $_POST['EmpDept'];
        $emppos = $_POST['EmpPosition'];
        $empadd = $_POST['EmpAddress'];
        $empphone = $_POST['EmpPhone'];
//$emppass = RandomString(); //md5() to encrypt 
//$emppass2 = $_POST['EmpPass2']; //md5() to encrypt
        $empdob = $_POST['EmpDOB'];
        $empstart = $_POST['EmpStartDate'];
        $empsex = $_POST['EmpSex'];

        $fname_result = ValidateName($fname);
        $lname_result = ValidateName($lname);
        //$emppos_result = ValidatePosition($emppos);
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

        if ($empphone_result == 1 && $empemail_result == 1 && $lname_result == 1 && $fname_result == 1 && $empdob_result == 1 && $empdate_result == 1) {


            Updates($fname,$lname,$empsex,$empid,$empemail,$status,$empdept,$role,$emppos,$empadd,$newDateDOB,$empphone,$newDateStart);
            echo "<script>window.close();</script>";
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
                    <input type="text" name="Fname" id="Fname" class="form-control" value="<?php echo $fname ?>" required/>
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
                    <input type="text" name="Lname" id="Lname" class="form-control" value="<?php echo $lname ?>" required/>
                    <span class="error">
                        <?php
                        if ($lname_result != 1) {
                            echo $lname_result;
                        }
                        ?>
                    </span>
                </div>

                <div class="form-group" style = "display:none">
                    <label for="Employee#" class="control-label">Employee #</label>
                    <input type="number" name="EmpNum" id="EmpNum" class="form-control" value="<?php echo $empnum ?>" required/>
                </div>

                <div class="form-group">
                    <label for="EmployeeID" class="control-label">Employee ID</label>
                    <input type="number" name="EmpID" id="EmpID" class="form-control" value="<?php echo $empid ?>" required/>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="control-label">Email</label>
                    <input type="email" name="EmpEmail" id="EmpEmail" class="form-control" value="<?php echo $empemail ?>" 
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
                    <select class="form-control" name="EmpSex" id="EmpSex"  required>
                        <option selected><?php echo $empsex ?></option>
                        <option>M</option>
                        <option>F</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputEmpDept" class="control-label">Department</label>
                    <select class="form-control" name="EmpDept" id="EmpDept" required >
                        <option selected><?php echo $empdept ?></option>
                        <option>IT</option>
                        <option>CSR</option>
                        <option>Claims</option>
                        <option>Delinquency</option>
                        <option>Accounts</option>
                        <option>Marketing</option>
                        <option>Processing</option>
                        <option>HR</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputStatus" class="control-label">Status</label>
                    <!--<input type="text" name="EmpStatus" id="EmpStatus" class="form-control" placeholder="Permanent" required/>-->
                    <select class="form-control" name="EmpStatus" id="EmpStatus" required>
                        <option selected><?php echo $status ?></option>
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
                        <option selected><?php echo $role ?></option>
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
                    <input type="text" name="EmpPosition" id="EmpPosition" class="form-control" value="<?php echo $emppos ?>" required/>
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
                    <input type="text" name="EmpAddress" id="EmpAddress" class="form-control" value="<?php echo $empadd ?>" required/>
                </div>

                <div class="form-group">  
                    <label for="inputDOB" class="control-label">D.O.B</label>
                    <input type="text" name="EmpDOB" id="EmpDOB" class="form-control" value="<?php echo $empdob ?>" required/>
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
                    <input type="tel" name="EmpPhone" id="EmpPhone" class="form-control" value="<?php echo $empphone ?>" required/>
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
                    <input type="text" name="EmpStartDate" id="EmpStartDate" class="form-control" value="<?php echo $empstart ?>" required/>
                    <span class="error"> 
                        <?php
                        if ($empdate_result != 1) {
                            echo $empdate_result;
                        }
                        ?>
                    </span>
                </div>
                <input class="btn btn-primary" type="submit" name="EditProfile" id ="EditProfile" value="Update"/> 

            </form>
        </div>

    </div>
</body>


