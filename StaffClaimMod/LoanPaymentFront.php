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
</script>
<script>
    function saveToDatabase(editableObj, column, id, name) {
        $(editableObj).css("background", "#FFF url(loaderIcon.gif) no-repeat right");
        $.ajax({
            url: "saverows",
            type: "POST",
            data: 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id + '&name=' + name, // send data to SaveEdit to be processed
        });
        location.reload();//reload to display changes
        //alert(name);
    }
</script>

<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#LoanPayments').dataTable({
            'dom': 'lBfrtip',
            'aLengthMenu': [10, 20, 50],
            'iDisplayLength': 10000,
            'sPaginationType': 'full_numbers',
            'buttons': [
                {extend: 'excel',
                    title: 'LoanStatement',
                    exportOptions: {

                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                },
                {extend: 'pdf',
                    title: 'LoanStatement',
                    exportOptions: {

                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        });

        //$(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
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
    <table id = "LoanPayments" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <?php
            if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role = 'Supervisor')) {
                ?>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th>Name</th>
                    <th>Loan Type</th>
                    <th>Beginning Balance</th>
                    <th>Monthly Repayment($)</th>
                    <!--<th>Repayment Period(Months)</th>-->
                    <th>Term(Months)</th>
                    <th>Payment</th>
                    <th>Date of Payment</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Ending Balance</th>
                    <th>Action</th>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th>Name</th>
                    <th>Loan Type</th>
                    <th>Beginning Balance</th>
                    <th>Monthly Repayment($)</th>
                    <!--<th>Repayment Period(Months)</th>-->
                    <th>Term(Months)</th>
                    <th>Payment</th>
                    <th>Date of Payment</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Ending Balance</th>
                </tr>
                <?php
            }
            ?>
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
                $sqls = "SELECT * FROM LoanApprovedTail where EmpID = $empid";
                $results = $dbh->query($sqls);
                $rows = $results->fetchAll();
            }
            $i = 0;
            foreach ($rows as $row) {
                //this if statement shows or hides relevant data from the Accounts Supervisor or manager
                if (($dept == 'Accounts' && $role == 'Manager') || ($dept == 'Accounts' && $role = 'Supervisor')) {
                    ?>    
                    <tr id="<?php $row['id_val']; ?>">
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
                        <td class="days"> 
                            <form method="post" action="records">
                                <input class="btn btn-xs btn-group-justified" type="submit" name="action" id = "UpdatePayment" value="UpdatePayment">
                                <br>
                                <div id = "dvPayment" name="dvPayment" class="form-group">
                                    <input class ="small" type="number" step="0.01" id="payment" name="payment" class="form-control"/>
                                </div>
                                <!--<input class="btn btn-xs btn-group-justified" type="submit" name="action" id = "ClearBalance" value="ClearBalance">-->
                                <input type="hidden" name="id" value="<?php echo $row['id_val']; ?>"/>
                            </form>
                        </td>
                    </tr>

                    <?php
                } else {
                    ?>
                    <tr id="' . <?php echo $row['id_val']; ?> . '">
                        <td class="id" style="display:none"> <?php echo $row['id_val']; ?>  </td>
                        <td class="name"> <?php echo $row['EmpName']; ?> </td>
                        <td class="empnum"><?php echo $row['LoanType']; ?> </td>
                        <td class="bal"><?php echo $row['StartBalance']; ?> </td>
                        <td class="type"> <?php echo $row['MonthlyRepayment']; ?></td>
                        <td class="shrink"> <?php echo $row['RepaymentPeriod']; ?></td>
                        <td class="days"> <?php echo $row['Payment']; ?></td>
                        <td class="days"> <?php echo $row['PaymentDate']; ?> </td>
                        <td class="days"> <?php echo $row['PrincipalRepaid']; ?></td>
                        <td class="days"> <?php echo $row['InterestRepaid']; ?></td>
                        <td class="days"> <?php echo $row['EndBalance']; ?></td>
                    </tr>
                    <?php
                }
                $i++;
            }
            ?>


        </tbody>                     
    </table>
</div>
<br>
<br>

<?php
include("../Templates/footer_dashboard.php");
?>