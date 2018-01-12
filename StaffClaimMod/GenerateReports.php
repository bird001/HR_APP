<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
?>
<script>
    function GenerateReports() {
        var options = document.getElementById('reportType').value;
//pop up window for uploading SchoolListinngs csv files
        window.open("loanreports?type="+options, "Loan Reports", "location=1,status=1,scrollbars=1,width=900,height=900");
    }
</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../StaffClaimMod/ClaimsNav.php");
?>
<?php
$email = $_SESSION['login_user'];
$result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$role = $row['EmpRole'];
$dept = $row['EmpDept'];
$position = $row['EmpPosition'];
?>

<br>
<br>
<br>
<!--<form name="bulk_action_form" action="loanreports" method="post" >-->
    <div style="width:500px;" class = "form-group" align="left">
        <div class="form-group">
            <label for="reportType" class="control-label">Report Type</label>
            <select class="form-control" name="reportType" id="reportType" required>
                <option value="None">--select report type--</option>
                <option value="All">Generate All Loans</option>
                <option value="OutstandingLoans">Generate Outstanding Loans</option>
                <?php
                $sql_loans = "select * from LoanTypes";
                $result_loans = $dbh->query($sql_loans);
                $row_loans = $result_loans->fetchAll();
                foreach ($row_loans as $row) {
                    echo '<option value="' . $row['LoanName'] . '">' . $row['LoanName'] . '</option>';
                }
                ?>
            </select>
            <br>
            <br>
            <button class="btn btn-danger" onclick="GenerateReports();">Generate Reports</button>


        </div>
    </div>
<!--</form>-->
