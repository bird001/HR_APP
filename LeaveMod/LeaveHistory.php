<?php
//include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

<script type="text/javascript" src="editrow"></script>
<script type="text/javascript" src="deleterow"></script>
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

<script>

    function retract_leave()
    {

        var checkbox_value = "";
        $(":checkbox").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                checkbox_value += $(this).val() + ",";
            }
        });
        var reason_value = $('#TextReason').val();
        //var reason_value = document.getElementById('TextReason').value;
        //alert(checkbox_value);
        //alert(reason_value);

        
        $.ajax({
            type: 'post',
            url: 'retractleaveops',
            data: {
                get_id: checkbox_value,
                get_reason: reason_value
            }
        });

        location.reload();
    }

</script>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#LeaveHistory').dataTable({
            'dom':'lBfrtip',
            'aLengthMenu': [20, 50, 100, 200],
            'iDisplayLength': 20,
            'sPaginationType': 'full_numbers',
            'buttons': ['excel','pdf','print']
        });

        //$(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>

<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../LeaveMod/LeaveNav.php");
?>


<div class = "container-fluid datatables_wrapper">
    <table id = "LeaveHistory" class = "table-hover table-bordered" style="width:150%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th align = "center">
                    <div align = "center">

                    </div>
                </th>
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
                '<td align = "center"><input type="checkbox" id = "checked_id[]" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
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
    <div align="left" class = "form-group">
        <button class="btn btn-primary" onclick="AddLeave();">Add Leave</button>
        <input class="btn btn-primary" type ="button" onclick="retract_leave();" id="RetractLeave" name="RetractLeave" value="Retract"/>
        <br>
        <br>
        <div id = "dvReason" name="dvReason" class="form-group" style="width:500px;display: none">
            <label for="LabelReason" class="control-label">Reason</label>
            <input type="text" id="TextReason" class="form-control"/>
        </div>

    </div>
</div>

<br>
<br>






<?php
include("../Templates/footer_dashboard.php");
?>