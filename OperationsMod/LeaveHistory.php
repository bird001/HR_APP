<?php
include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>
<script type="text/javascript" src="deleterow"></script>


<script>
    function AddLeave() {
//pop up window for uploading SchoolListinngs csv files
        window.open("addleave", "Add Leave", "location=1,status=1,scrollbars=1,width=600,height=900");
    }
</script>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#LeaveHistory').dataTable({
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
    <table id = "LeaveHistory" class = "table-hover table-bordered" style="width:150%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>ID#</th>
                <th>Department</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Number of Days</th>
                <th>Managers Response</th>
                <th>HR Response</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM ApplyLeaveHRArchive";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                echo '<tr name = "LeaveHistory" id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="fname">' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>' .
                '<td class="emid">' . $row['EmpID'] . '</td>' .
                '<td class="empdebt">' . $row['EmpDept'] . '</td>' .
                '<td class="leavetype">' . $row['LeaveType'] . '</td>' . 
                '<td class="startdate">' . $row['StartDate'] . '</td>' .       
                '<td class="enddat">' . $row['EndDate'] . '</td>' .       
                '<td class="numdays">' . $row['NumDays'] . '</td>' .       
                '<td class="managerresponse">' . $row['ManagerResponse'] . '</td>' .       
                '<td class="hrresponse">' . $row['HRResponse'] . '</td>';       

                echo '</tr>';
            }
            ?>


        </tbody>                     
    </table>
    <button class="btn btn-primary" onclick="AddLeave();">Add Leave</button>

</div>
<br>
<br>






<?php
include("../Templates/footer_dashboard.php");
?>