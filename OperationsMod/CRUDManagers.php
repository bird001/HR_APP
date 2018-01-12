<?php
include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type="text/javascript" src="editrow"></script>
<script type="text/javascript" src="deleterow"></script>
<script>
    function AddManager() {
//pop up window for uploading SchoolListinngs csv files
        window.open("addmanager", "Add Manager", "location=1,status=1,scrollbars=1,width=400,height=400");
    }
</script>

<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#CRUDManagers').dataTable({
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
    <table id = "CRUDManagers" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>ID#</th>
                <th>Email Address</th>
                <th>Departments Managed</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM ManagersDepartments";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                echo '<tr name = "CRUDManagers" id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="noname">' . $row['Name'] . '</td>' .
                '<td class="noempid">' . $row['EmpID'] . '</td>' .
                '<td class="noempemail">' . $row['EmpEmail'] . '</td>' .
                '<td class="Department">' . $row['Department'] . '</td>';

                echo '</tr>';
            }
            ?>


        </tbody>                     
    </table>
    <button class="btn btn-primary" onclick="AddManager();">Add Manager</button>


</div>
<br>
<br>






<?php
include("../Templates/footer_dashboard.php");
?>