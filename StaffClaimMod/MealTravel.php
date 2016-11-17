<?php
include("../Login/session.php");
include("../db/db3.php");
include("../Templates/header.php");
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../StaffClaimMod/ClaimsNav.php");

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$firstname = $row['FirstName'];
$lastname = $row['LastName'];
$dept = $row['EmpDept'];
?>


<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="../StaffClaimMod/MealTravelGen.php" method="post" name="mealtravel" id="mealtravel" class = "form-group" >

            <div class="form-group">
                <label for="inputFName" class="control-label">First Name</label>
                <input type="text" name="Fname" id="Fname" class="form-control" value="<?php echo $firstname; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputLName" class="control-label">Last Name</label>
                <input type="text" name="Lname" id="Lname" class="form-control" value="<?php echo $lastname; ?>" required readonly/>
            </div>

            <div class="form-group">
                <label for="inputEmpDept" class="control-label">Department</label>
                <input type="text" name="EmpDept" id="EmpDept" class="form-control" value="<?php echo $dept; ?>" required readonly/>
            </div>

            <div class="form-group">  
                <label for="inputDate" class="control-label">Date</label>
                <input type="date" name="Date" id="Date" class="form-control"  required/>
            </div>

            <div class="form-group">
                <label for="inputDest" class="control-label">Destination(Home)</label>
                <input type="text" name="Dest" id="Dest" class="form-control" placeholder="Kingston" required/>
            </div>
            
            <div class="form-group">
                <label for="inputPurpose" class="control-label">Nature of Work Done</label>
                <input type="text" name="Purpose" id="Purpose" class="form-control" placeholder="Work" required/>
            </div>



            <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
        </form>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>