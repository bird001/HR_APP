<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
?>

<script>
    function showEdit(editableObj) {
        $(editableObj).css("background", "#FFF");
    }

    function saveToDatabase(editableObj, column, id, name) {
        $(editableObj).css("background", "#FFF url(loaderIcon.gif) no-repeat right");
        $.ajax({
            url: "saverows",
            type: "POST",
            data: 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id + '&name=' + name, // send data to SaveEdit to be processed
        });
        location.reload();//reload to display changes
    }
</script>

<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#LoanPayments').dataTable();

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
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
$empid = $row1['EmpID'];
?>
<br>
<div class = "container-fluid datatables_wrapper">
    <!--<form name="bulk_action_form" action="#" method="post" >-->
    <table id = "LoanPayments" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>Loan Type</th>
                <th>Beginning Balance</th>
                <th>Monthly Repayment($)</th>
                <th>Repayment Period(Months)</th>
                <th>Payment</th>
                <th>Date of Payment</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Ending Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role = 'Supervisor')) {
                $email = $_SESSION['login_user'];
                $sql = "SELECT * FROM LoanApproved";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();
            } else {
                $email = $_SESSION['login_user'];
                $sqls = "SELECT * FROM LoanApproved where EmpID = $empid";
                $results = $dbh->query($sqls);
                $rows = $results->fetchAll();
            }

            foreach ($rows as $row) {
                //this if statement shows or hides relevant data from the Accounts Supervisor or manager
                if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role = 'Supervisor')) {
                    ?>    

                    <tr id="' . <?php echo $row['id_val']; ?> . '">
                        <td class="id" style="display:none"> <?php echo $row['id_val']; ?>  </td>
                        <td class="name"> <?php echo $row['EmpName']; ?> </td>
                        <td class="empnum"><?php echo $row['LoanType']; ?> </td>
                        <td class="bal"><?php echo $row['StartBalance']; ?> </td>
                        <td class="type"> <?php echo $row['MonthlyRepayment']; ?></td>
                        <td class="dates"> <?php echo $row['RepaymentPeriod']; ?></td>
                        <?php
                        if ($row['Editable'] == 0) {
                            ?>
                            <td class="days" contenteditable="true" onblur="saveToDatabase(this, 'Payment', '<?php echo $row['id_val']; ?>', 'LoanPayments');"
                                onClick="showEdit(this);"> 
                                    <?php echo $row['Payment']; ?>
                            </td>
                            <?php
                        } else {
                            ?>
                            <td class="days"> <?php echo $row['Payment']; ?> </td>
                            <?php
                        }
                        ?>
                        <td class="days"> <?php echo $row['PaymentDate']; ?> </td>
                        <td class="days"> <?php echo $row['PrincipalRepaid']; ?></td>
                        <td class="days"> <?php echo $row['InterestRepaid']; ?></td>
                        <td class="days"> <?php echo $row['EndBalance']; ?></td>


                        <?php
                    } else {
                        ?>
                    <tr id="' . <?php echo $row['id_val']; ?> . '">
                        <td class="id" style="display:none"> <?php echo $row['id_val']; ?>  </td>
                        <td class="name"> <?php echo $row['EmpName']; ?> </td>
                        <td class="empnum"><?php echo $row['LoanType']; ?> </td>
                        <td class="bal"><?php echo $row['StartBalance']; ?> </td>
                        <td class="type"> <?php echo $row['MonthlyRepayment']; ?></td>
                        <td class="dates"> <?php echo $row['RepaymentPeriod']; ?></td>
                        <td class="days"> <?php echo $row['Payment']; ?></td>
                        <td class="days"> <?php echo $row['PaymentDate']; ?> </td>
                        <td class="days"> <?php echo $row['PrincipalRepaid']; ?></td>
                        <td class="days"> <?php echo $row['InterestRepaid']; ?></td>
                        <td class="days"> <?php echo $row['EndBalance']; ?></td>
                        <?php
                    }
                }
                ?>


        </tbody>                     
    </table>
    <!--</form>-->
</div>
<br>
<br>




<?php
include("../Templates/footer_dashboard.php");
?>