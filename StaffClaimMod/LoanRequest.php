<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
?>

<script type="text/javascript">
    $(function () {
        $(":checkbox").click(function () {
            if ($(this).is(":checked")) {
                $("#dvReason").show();
            } else {
                $("#dvReason").hide();
            }
        });
    });
</script>
<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#LeaveRequests').dataTable();

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });

    //window.alert("blah");
</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../StaffClaimMod/ClaimsNav.php");
?>



<?php
$email = $_SESSION['login_user'];
$sql1 = "SELECT * FROM  Users where EmpEmail = '$email'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

$position = $row1['EmpPosition'];
$dept = $row1['EmpDept'];
$role = $row1['EmpRole'];
?>

<div class = "container-fluid datatables_wrapper">
    <form name="bulk_action_form" action="generate_approve" method="post" >
        <table id = "LeaveRequests" class = "table-hover table-bordered" style="width:200%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th align = "center">
                        <div align = "center">

                        </div>
                    </th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Loan Type</th>
                    <th>Amount Requested($)</th>
                    <th>Monthly Repayment($)</th>
                    <th>Repayment Period(Months)</th>
                    <th>Interest Per Annum</th>
                    <th>Verified By</th>
                    <th>Approved By</th>
                    <th>Approved Status</th>
                    <th>Reason</th>
                    <th>Vetted By</th>
                    <th>Vetted Status</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $email = $_SESSION['login_user'];
                $sql = "SELECT * FROM LoanApplication";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    //this if statement shows or hides relevant data from the Accounts Supervisor or manager
                    if ($dept == 'Accounts' && empty($row['VerifiedBy']) || (($dept == 'Accounts' && !empty($row['ApprovedBy'])) && ($dept == 'Accounts' && !empty($row['VettedBy'])))) {
                        echo '<tr id="' . $row['id_val'] . '">';
                        echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                        '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                        '<td class="name">' . $row['EmpName'] .
                        '<td class="empnum">' . $row['EmpDept'] . '</td>' .
                        '<td class="empdept">' . $row['LoanType'] . '</td>' .
                        '<td class="type">' . $row['AmountRequested'] . '</td>' .
                        '<td class="dates">' . $row['MonthlyRepayment'] . '</td>' .
                        '<td class="days">' . $row['RepaymentPeriod'] . '</td>' .
                        '<td class="interest">' . $row['InterestPerAnnum'] . '</td>' .
                        '<td class="verify">' . $row['VerifiedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedStatus'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedReason'] . '</td>' .
                        '<td class="vet">' . $row['VettedBy'] . '</td>'.
                        '<td class="vet">' . $row['VettedStatus'] . '</td>'.
                        '<td class="vet">' . $row['VettedReason'] . '</td>';

                        echo '</tr>';
                    }
                    //this if statement shows and hides relevant data from the AGM
                    if ((strpos($position, 'Assistant General Manager') !== false && !empty($row['VerifiedBy'])) &&
                            (strpos($position, 'Assistant General Manager') !== false && empty($row['ApprovedBy']) )) {

                        echo '<tr id="' . $row['id_val'] . '">';
                        echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                        '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                        '<td class="name">' . $row['EmpName'] .
                        '<td class="empnum">' . $row['EmpDept'] . '</td>' .
                        '<td class="empdept">' . $row['LoanType'] . '</td>' .
                        '<td class="type">' . $row['AmountRequested'] . '</td>' .
                        '<td class="dates">' . $row['MonthlyRepayment'] . '</td>' .
                        '<td class="days">' . $row['RepaymentPeriod'] . '</td>' .
                        '<td class="days">' . $row['InterestPerAnnum'] . '</td>' .
                        '<td class="verify">' . $row['VerifiedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedStatus'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedReason'] . '</td>' .
                        '<td class="vet">' . $row['VettedBy'] . '</td>'.
                        '<td class="vet">' . $row['VettedStatus'] . '</td>'.
                        '<td class="vet">' . $row['VettedReason'] . '</td>';

                        echo '</tr>';
                    }
                    //this if statement shows and hides relevant data from the AGM
                    if ((strpos($position, 'General Manager') !== false && !empty($row['VerifiedBy'])) &&
                            (strpos($position, 'General Manager') !== false && !empty($row['ApprovedBy']) ) &&
                            (strpos($position, 'General Manager') !== false && empty($row['VettedBy']) )) {

                        echo '<tr id="' . $row['id_val'] . '">';
                        echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                        '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                        '<td class="name">' . $row['EmpName'] .
                        '<td class="empnum">' . $row['EmpDept'] . '</td>' .
                        '<td class="empdept">' . $row['LoanType'] . '</td>' .
                        '<td class="type">' . $row['AmountRequested'] . '</td>' .
                        '<td class="dates">' . $row['MonthlyRepayment'] . '</td>' .
                        '<td class="days">' . $row['RepaymentPeriod'] . '</td>' .
                        '<td class="days">' . $row['InterestPerAnnum'] . '</td>' .
                        '<td class="verify">' . $row['VerifiedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedBy'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedStatus'] . '</td>' .
                        '<td class="approve">' . $row['ApprovedReason'] . '</td>' .
                        '<td class="vet">' . $row['VettedBy'] . '</td>'.
                        '<td class="vet">' . $row['VettedStatus'] . '</td>'.
                        '<td class="vet">' . $row['VettedReason'] . '</td>';

                        echo '</tr>';
                    }
                }
                ?>


            </tbody>                     
        </table>
        <!---->
        <input class="btn btn-primary" type="submit" name="Request" id = "Generate" value="Generate"/>
        <?php
        if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role == 'Supervisor')) {
            ?>
            <input class="btn btn-primary" type="submit" name="Request" id = "Verify" value="Verify"/>
            <?php
        }
        ?>
        <?php
        if (strpos($position, 'General Manager') !== false) { //either GM or AGM can access this functionality
            ?>

            <input class="btn btn-primary" type="submit" name="Request" id = "Approve" value="Approve"/> 
            <input class="btn btn-primary" type="submit" name="Request" id = "Deny" value="Deny"/>
            <br>
            <br>
            <div id = "dvReason" name="dvReason" class="form-group" style="width:500px;display: none">
                <label for="LabelReason" class="control-label">Reason</label>
                <input type="text" id="TextReason" name="TextReason" class="form-control"/>
                <br> 
            </div>
            <?php
        }
        ?>
        <?php
        if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role == 'Supervisor')) {
            ?>
            <input class="btn btn-primary" type="submit" name="Request" id = "Disburse" value="Disburse"/>
            <span class="error"><?php echo $disburseerror; ?></span>
            <?php
        }
        ?>
    </form>
</div>
<br>
<br>
<?php include("../Templates/footer_dashboard.php"); ?> 