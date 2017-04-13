<?php
include ("../db/db3.php");
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $functiontype = $_POST['Submit'];

    if ($functiontype == 'Login') {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); //md5() to encrypt
        $role = mysqli_real_escape_string($conn, $_POST['EmpRole']);

        $sql_usercheck = "SELECT * FROM Users WHERE EmpEmail='$email' and EmpPass='$password' and EmpRole='$role'";
        $result_usercheck = mysqli_query($conn, $sql_usercheck);
        $row_usercheck = mysqli_fetch_array($result_usercheck, MYSQLI_ASSOC);

        $checkpassword = $row_usercheck['PasswordChanged'];

        $usercheck = mysqli_num_rows($result_usercheck);

        // If result matched $myusername and $mypassword, table row must be 1 row
        if ($usercheck === 1 && $checkpassword === '1') {
            
            $sql_users = "insert into HR_DEPT.UserLog 
            (EmpEmail,TimeLoggedIn) 
            select 
            EmpEmail, now() 
            from 
            HR_DEPT.Users 
            where 
            EmpEmail = '$email'"; //a log of users that have logged into this app
            mysqli_query($conn, $sql_users); //execute the statement
             
            
            $_SESSION['login_user'] = $email;
            $_SESSION['login_pass'] = $password;
            $_SESSION['last_time'] = time();

            header("location: profile");
        }

        if ($usercheck === 1 && $checkpassword === '0') {
            header("location: changepassword");
        }

        if ($usercheck === 0) {
            $error = "Your Login Name or Password is invalid";
        }
    }
}
?>

<html>

    <head>
        <title>HR DEPT</title>
        <link href="bootstrapCSS" rel="stylesheet">

        <script type = "text/javascript" src = "bootstrapValidate"></script>
        <script type = "text/javascript" src = "jquerylib"></script>
        <script type = "text/javascript" src = "bootstrap"></script>
    </head>

    <body bgcolor ="#f9f9f9" >

            <div align="center" class = "form-group">
                <div style ="width:500px;" class = "bg-primary">
                    <img src="http://www.tipfriendly.com/images/tip-logo2.png" alt="Tip Friendly Society">
                    <h1>Human Resource Department</h1>
                </div>
                <div style="width:300px; border: solid 1px #333333; " class = "form-group" align="left">
                    <div class ="bg-primary text-white" padding:5px;"> <b>Login</b> </div>

                    <div style="margin:30px">

                        <form action="" method="post" class = "form-group" align="left">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="j.hancokck@tipfriendly.com" required/>
                            </div>  

                            <div class="form-group">
                                <label for="inputPassword" class="control-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
                            </div>  

                            <div class="form-group">
                                <label for="inputRole" class="control-label">Role</label>
                                <!--<input type="text" name="EmpStatus" id="EmpStatus" class="form-control" placeholder="Permanent" required/>-->
                                <select class="form-control" name="EmpRole" id="EmpRole" required>
                                    <option>Employee</option>
                                    <option>Supervisor</option>
                                    <option>Manager</option>

                                </select>
                            </div>

                            <input class="btn btn-primary" type="submit" name = "Submit" value = "Login"/>                         
                        </form>

                        <div style="font-size:11px; color:#cc0000; margin-top:10px"></div>
                        <?php if (isset($error)) echo $error . "<br/>"; ?>			
                    </div>

                </div>

            </div>
        

    </body>
</html>