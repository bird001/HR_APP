<?php 
include ("../db/db3.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $functiontype = $_POST['Submit'];

    if ($functiontype == 'Change') {
        $changeemail = $_POST['changeemail'];
        $oldpass = $_POST['oldpassword'];
        $newpass1 = $_POST['newpassword1'];
        $newpass2 = $_POST['newpassword2'];

        $sql_getuser = "select * from Users where EmpEmail = '$changeemail' and EmpPass = '$oldpass'";
        $results_getuser = mysqli_query($conn, $sql_getuser);
        $row_getuser = mysqli_fetch_array($results_getuser, MYSQLI_ASSOC);
        
        
        if ($newpass1 != $newpass2) {
            $emppassError = "Passwords Do not Match";
            $emppassSet = 0;
        } else {
            $emppassSet = 1;
        }
        
        if($oldpass != $row_getuser['EmpPass']){
            $oldpassError = "Old Password doesn't match";
            $oldpassSet = 0;
        }else{
            $oldpassSet  = 1;
            
        }
        
        if($changeemail != $row_getuser['EmpEmail']){
            $changeemailError = "Email does not exist";
            $changeemailSet = 0;
        }else{
            $changeemailSet = 1;
        }
        
        if($emppassSet == 1 && $changeemailSet == 1 && $oldpassSet == 1){
            
            $sql_password = "update Users set EmpPass = '$newpass1', PasswordChanged = '1' where EmpEmail = '$changeemail' and EmpPass = '$oldpass'";
            mysqli_query($conn, $sql_password);
            
            header("location: login");
            
        }
    }
}

?>


<html>

    <head>
        <title>HR DEPT</title>
        <link href="bootstrapCSS" rel="stylesheet">

        <script type = "text/javascript" src = "bootstrapvalidate"></script>
        <script type = "text/javascript" src = "jquerylib"></script>
        <script type = "text/javascript" src = "bootstrap"></script>
    </head>

    <body bgcolor="#FFFFFF">
        <br>
        <div align="left" class = "form-group">
            <div style="width:500px;" class = "form-group" align="left">

                <form action="#" method="post" id="form1" class = "form-group" role="form" >
                    <label for="changepword" class="control-label">Change Password</label>
                    <div class="form-group">
                        <label for="inputchangeEmail" class="control-label">Email</label>
                        <input type="text" name="changeemail" id="changeemail" class="form-control" placeholder="j.hancokck@tipfriendly.com" required/>
                    </div>
                    <div class="form-group">
                        <label for="inputOldPassword" class="control-label">Old Password</label>
                        <input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Old Password" required/>
                    </div>
                    <div class="form-group">
                        <label for="inputNewPassword1" class="control-label">New Password</label>
                        <input type="password" name="newpassword1" id="newpassword1" class="form-control" placeholder="New Password" required/>
                    </div>
                    <div class="form-group">
                        <label for="inputNewPassword2" class="control-label">Re-Enter Password</label>
                        <input type="password" name="newpassword2" id="newpassword2" class="form-control" placeholder="Re-Enter Password" required/>
                    </div>

                    <input class="btn btn-primary" type="submit" name = "Submit" value = "Change"/><br>
                    <span class="error"><?php echo $emppassError; ?></span><br>
                    <span class="error"><?php echo $oldpassError; ?></span><br>
                    <span class="error"><?php echo $changeemailError; ?></span>

                </form>
            </div>
        </div>


    </body>
</html>