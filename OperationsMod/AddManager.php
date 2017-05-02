<?php
include('../db/db3.php');
include('../Validation/ValidateInput.php');
include("../Templates/header.php");
include("../RegistrationMod/Updates.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $empname = $_POST['EmpName'];
    $empid = $_POST['EmpID'];
    $empemail = $_POST['EmpEmail'];
    $depts = $_POST['Depts'];


    $empname_result = ValidateName($empname);
    $empemail_result = ValidateEmail($empemail);
    $depts_result = ValidateName($depts);



    if ($empname_result == 1 && $empemail_result == 1 && $depts_result == 1) {


        $addmanager = "insert into ManagersDepartments (Name, EmpID,EmpEmail,Department) values "
                . "('$empname','$empid','$empemail','$depts')";
        mysqli_query($conn, $addmanager);
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
                    <label for="inputEmpName" class="control-label">Employee Name</label>
                    <input type="text" name="EmpName" id="EmpName" class="form-control" required/>
                    <span class="error">
                        <?php
                        //if ($fname_result != 1) {
                        //  echo $fname_result;
                        //}
                        ?>
                    </span>

                </div>

                <div class="form-group">
                    <label for="inputEmpID" class="control-label">Employee ID</label>
                    <input type="number" name="EmpID" id="EmpID" class="form-control" value="<?php //echo $empid     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($fname_result != 1) {
                        //  echo $fname_result;
                        //}
                        ?>
                    </span>

                </div>

                <div class="form-group">
                    <label for="inputEmpEmail" class="control-label">Employee Email</label>
                    <input type="email" name="EmpEmail" id="EmpEmail" class="form-control" value="<?php //echo $empemail     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($lname_result != 1) {
                        //  echo $lname_result;
                        //}
                        ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="Depts" class="control-label">Employee Dept</label>
                    <input type="text" name="Depts" id="Depts" class="form-control" value="<?php //echo $empnum     ?>" required/>
                    <span class="error">
                        <?php
                        //if ($lname_result != 1) {
                        //  echo $lname_result;
                        //}
                        ?>
                    </span>
                </div>
                <input class="btn btn-primary" type="submit" name="AddManager" id ="AddManager" value="AddManager"/> 

            </form>
        </div>

    </div>
</body>


