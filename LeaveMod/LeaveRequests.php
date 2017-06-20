<?php
include("../Templates/header.php");
include("../db/db2.php");
include("../db/db3.php");

?>
<script type="text/javascript" src="requestcheckbox"></script>
<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#LeaveRequests').dataTable({
            "sPaginationType": "full_numbers" //show pagination buttons
        });

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>


<?php
include("../Templates/navigation.php");
include("LeaveNav.php");
?>

<?php
$email = $_SESSION['login_user'];
$sql1 = "SELECT * FROM ApplyLeaveHR where ManagerEmail = '$email'";
$sql2 = "SELECT * FROM ApplyLeaveHR where HREmail = '$email'";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

$manemail = $row1['ManagerEmail'];
$hremail = $row2['HREmail'];
//$role = $row1['EmpRole'];
?>

<?php
if (($email === $manemail && empty($row1['ManagerResponse'])) || ($email === $hremail && !empty($row1['ManagerResponse']))) {
    ?>
    <div class = "container-fluid datatables_wrapper">
        <form name="bulk_action_form" action="requestcheck" method="post" >
            <table id = "LeaveRequests" class = "table-hover table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none">id_val</th><!--needed for sorting-->
                        <th align = "center">
                            <div align = "center">

                            </div>
                        </th>
                        <th>Name</th>
                        <th>Emp #</th>
                        <th>Emp Dept</th>
                        <th>Leave Type</th>
                        <th>Dates</th>
                        <th>Duration</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $email = $_SESSION['login_user'];
                    $sql = "SELECT * FROM ApplyLeaveHR where ManagerEmail = '$email' or HREmail = '$email'";
                    $results = $dbh->query($sql);
                    $rows = $results->fetchAll();

                    foreach ($rows as $row) {
                        echo '<tr id="' . $row['id_val'] . '">';
                        echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                        '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                        '<td class="name">' . $row['FirstName'] . " " . $row['LastName'] .
                        '<td class="empnum">' . $row['EmpID'] . '</td>' .
                        '<td class="empdept">' . $row['EmpDept'] . '</td>' .
                        '<td class="type">' . $row['LeaveType'] . '</td>' .
                        '<td class="dates">' . $row['StartDate'] . "-->" . $row['EndDate'] . '</td>';
                        if ($row['LeaveType'] === 'Department') {
                            echo '<td class="days">' . $row['NumDays'] . ' Hours' . '</td>';
                        } else {
                            echo '<td class="days">' . $row['NumDays'] . ' Days' . '</td>';
                        }
                        echo '<td class="reason">' . $row['Reason'] . '</td>';

                        echo '</tr>';
                    }
                    ?>


                </tbody>                     
            </table>
            <input class="btn btn-primary" type="submit" name="Submit" value="Accept"/> 
            <input class="btn btn-primary" type="submit" name="Submit" value="Reject"/> 
        </form>
    </div>
    <?php
}
?>
<br>
<br>
<?php include("../Templates/footer_dashboard.php"); ?> 