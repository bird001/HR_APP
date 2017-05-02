<?php
include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>
<script type="text/javascript" src="deleterow"></script>

<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#CRUDLeaves').dataTable({
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
    <table id = "CRUDLeaves" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>ID#</th>
                <th>Vacation</th>
                <th>Vacation Outstanding</th>
                <th>Sick</th>
                <th>Dept</th>
                <th>Maternity</th>
                <th>Study</th>
                <th>Bereavement</th>
                <th>Jury Duty</th>
                <th>Outstanding Years</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM Leaves";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                echo '<tr name = "CRUDLeaves" id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="fname">' . $row['EmpFName'] . ' ' . $row['EmpLName'] . '</td>' .
                '<td class="emid">' . $row['EmpID'] . '</td>' .
                '<td class="Vacation">' . $row['Vacation'] . '</td>' .
                '<td class="VacationOutstanding">' . $row['VacationOutstanding'] . '</td>' .
                '<td class="Sick">' . $row['Sick'] . '</td>' .
                '<td class="Department">' . $row['Department'] . '</td>' .
                '<td class="Maternity">' . $row['Maternity'] . '</td>' .
                '<td class="Study">' . $row['Study'] . '</td>' .
                '<td class="Bereavement">' . $row['Bereavement'] . '</td>' .
                '<td class="JuryDuty">' . $row['JuryDuty'] . '</td>' .
                '<td class="OutstandingLeave_Years">' . $row['OutstandingLeave_Years'] . '</td>';

                echo '</tr>';
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