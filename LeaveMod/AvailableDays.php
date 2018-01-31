<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
?>

<html>

    <head>
        <title>Available Days</title>
        <link href="bootstrapCSS" rel="stylesheet">

        <script type = "text/javascript" src = "bootstrapvalidate"></script>
        <script type = "text/javascript" src = "jquerylib"></script>
        <script type = "text/javascript" src = "bootstrap"></script>
    </head>

    <body bgcolor="#FFFFFF">
        <div align="left" class = "form-group">
            <div style="width:500px; " class = "form-group" align="left">
                <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Available Days</b></div>

                <div style="margin:30px">

                    <?php
                    $email = $_SESSION['login_user'];
                    $sql = "SELECT * FROM Leaves where EmpEmail = '$email' ";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    "Vacation Days: " . $row['Vacation'] . "<br>" .
                            "Oustanding Vacation Days: " . $row['VacationOutstanding'] . "<br>" .
                            "Contract Break: " . $row['ContractBreak'] . "<br>" .
                            "Sick Days: " . $row['Sick'] . "<br>" .
                            "Maternity Days: " . $row['Maternity'] . "<br>" .
                            "Study Days: " . $row['Study'] . "<br>" .
                            "Bereavement Days: " . $row['Bereavement'] . "<br>" .
                            "Jury Duty: " . $row['JuryDuty'];
                    ?>
                    <form action="#" method="post" id="form1" class = "form-group" role="form" >
                        <div class="form-group">
                            <label for="VacationDays" class="control-label">Vacation</label>
                            <label for="VacationDays" class="form-control"><?php echo $row['Vacation']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="VacationDaysOut" class="control-label">Outstanding Vacation</label>
                            <label for="VacationDaysOut" class="form-control"><?php echo $row['VacationOutstanding']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="VacationDaysOut" class="control-label">Contract Break</label>
                            <label for="VacationDaysOut" class="form-control"><?php echo $row['ContractBreak']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="SickDays" class="control-label">Sick</label>
                            <label for="SickDays" class="form-control"><?php echo $row['Sick']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="MaternityDays" class="control-label">Maternity</label>
                            <label for="MaternityDays" class="form-control"><?php echo $row['Maternity']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="StudyDays" class="control-label">Study</label>
                            <label for="StudyDays" class="form-control"><?php echo $row['Study']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="BereaveDays" class="control-label">Bereavement</label>
                            <label for="BereaveDays" class="form-control"><?php echo $row['Bereavement']; ?></label>


                        </div>

                        <div class="form-group">
                            <label for="JuryDuty" class="control-label">Jury Duty</label>
                            <label for="JuryDuty" class="form-control"><?php echo $row['JuryDuty']; ?></label>


                        </div>


                    </form>
                </div>
            </div>
        </div>


        <br>
        <br>
    </body>
</html>
