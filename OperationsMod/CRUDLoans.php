<?php
include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>
<script type="text/javascript" src="deleterow"></script>
<script>
    function AddLoan() {
//pop up window for uploading SchoolListinngs csv files
        window.open("addloan", "Add Loan", "location=1,status=1,scrollbars=1,width=400,height=400");
    }
</script>

<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#CRUDLoans').dataTable({
            "aLengthMenu": [20, 50, 100, 200],
            "iDisplayLength": 20,
            "sPaginationType": "full_numbers"
        });

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>

<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../OperationsMod/OperationsNav.php");
?>


<div class = "container-fluid datatables_wrapper">
    <table id = "CRUDLoans" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Loan Name</th>
                <th>Loan ID</th>
                <th>Interest/Annum</th>
                <th>Loan Term (in months)</th>
                <th>Loan Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM LoanTypes";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                echo '<tr name = "CRUDLoans" id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="LoanName">' . $row['LoanName'] . '</td>' .
                '<td class="LoanID">' . $row['LoanID'] . '</td>' .
                '<td class="InterestPerAnnum">' . $row['InterestPerAnnum'] . '</td>' .
                '<td class="TimeToPay">' . $row['TimeToPay'] . '</td>' .
                '<td class="Type">' . $row['Type'] . '</td>';

                echo '</tr>';
            }
            ?>


        </tbody>                     
    </table>
    <button class="btn btn-primary" onclick="AddLoan();">Add Loan Type</button>


</div>
<br>
<br>






<?php
include("../Templates/footer_dashboard.php");
?>