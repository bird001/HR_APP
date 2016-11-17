<?php
include ("../db/db3.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); //md5() to encrypt
    $role = mysqli_real_escape_string($conn, $_POST['EmpRole']);
    $sql = "SELECT id_val FROM Users WHERE EmpEmail='$email' and EmpPass='$password' and EmpRole='$role'";

    $sql_users = "insert into HR_DEPT.UserLog 
            (EmpEmail,TimeLoggedIn)
            select 
            EmpEmail, now() 
            from 
            HR_DEPT.Users 
            where 
            EmpEmail = '$email'"; //a log of users that have logged into this app

    mysqli_query($conn, $sql_users); //execute the statement

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    //$active=$row['active'];

    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if ($count == 1) {
        //session_register("myusername");
        $_SESSION['login_user'] = $email;
        $_SESSION['login_pass'] = $password;
        $_SESSION['last_time'] = time();

        header("location: ../Welcome/index.php");
    } else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>

<html>

    <head>
        <title>HR DEPT</title>
        <link href="../CSS/bootstrap.min.css" rel="stylesheet">

        <script type = "text/javascript" src = "../js/bootstrapValidator.js"></script>
        <script type = "text/javascript" src = "../js/jquery-2.1.4.min.js"></script>
        <script type = "text/javascript" src = "../js/bootstrap.js"></script>

        <script type = "text/javascript" src = "../Validation/Register.js"></script>
    </head>

    <body bgcolor="#FFFFFF">

        <div align="center" class = "form-group">
            <h1>HR DEPT</h1>
            <div style="width:300px; border: solid 1px #333333; " class = "form-group" align="left">
                <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

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

                        <input class="btn btn-primary" type="submit" value=" Submit "/> 
                        <input class="btn btn-primary" type="button" value="Register" onclick="Register();" ><br />
                    </form>

                    <div style="font-size:11px; color:#cc0000; margin-top:10px"></div>
                    <?php if (isset($error)) echo "Login failed: Incorrect user name, password, or rights<br /-->"; ?>			
                </div>

            </div>

        </div>
        <?php
        /* echo '<p><pre>after: '; // cehck if session destroyeed
          print_r($_SESSION);
          echo '</pre>';
         * 
         */
        ?>
    </body>
</html>