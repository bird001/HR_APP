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
        <form action="../StaffClaimMod/TravelSubsistenceGen.php" method="post" name="mealtravel" id="mealtravel" class = "form-group" >

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
                <label for="inputStartDate" class="control-label">FROM</label>
                <input type="date" name="StartDate" id="StartDate" class="form-control"  required/>
            </div>

            <div class="form-group">  
                <label for="inputEndDate" class="control-label">TO</label>
                <input type="date" name="EndDate" id="EndDate" class="form-control"  required/>
            </div>

            <div class="form-group">
                <label for="inputDest" class="control-label">Destination(TO)</label>
                <input type="text" name="Dest" id="Dest" class="form-control" placeholder="Ocho Rios" required/>
            </div>
            
            <div class="form-group">
                <label for="inputOrigin" class="control-label">Origin(FROM)</label>
                <input type="text" name="Origin" id="Origin" class="form-control" placeholder="Kingston" required/>
            </div>
            
            <div class="form-group">
                <label for="inputKM" class="control-label">KiloMeters</label>
                <input type="number" name="KM" id="KM" class="form-control" required/>
            </div>
            
            <div class="form-group">
                <label for="inputPurpose" class="control-label">Purpose of Travel</label>
                <input type="text" name="Purpose" id="Purpose" class="form-control" placeholder="Work" required/>
            </div>



            <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
        </form>
    </div>
</div>


<?php include("../Templates/footer.php"); ?>