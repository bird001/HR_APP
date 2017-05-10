<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
include("../Templates/header.php");
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
$sql1 = "SELECT * FROM ApplyLeave where ManagerEmail = '$email'";
$sql2 = "SELECT * FROM ApplyLeave where HREmail = '$email'";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

$manemail = $row1['ManagerEmail'];
$hremail = $row2['HREmail'];
$role = $row1['EmpRole'];
?>

<?php
if ($role === 'Manager') {

    if ($email === $manemail) {
        ?>
        <div class = "container-fluid datatables_wrapper">
            <form>
                <table id = "LeaveRequests" class = "table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="display:none">id_val</th><!--needed for sorting-->
                            <th>Name</th>
                            <th>Emp #</th>
                            <th>Emp Dept</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Accept</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $email = $_SESSION['login_user'];
                        $sql = "SELECT * FROM ApplyLeave where ManagerEmail = '$email' ";
                        $results = $dbh->query($sql);
                        $rows = $results->fetchAll();

                        foreach ($rows as $row) {
                            echo '<tr id="' . $row['id_val'] . '">';
                            echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
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
                            echo '<td class="reason">' . $row['Reason'] . '</td>' .
                            '<td id = "Accept"><input type="checkbox" onclick="handleClick(this);">' . '</td>' .
                            '<td id = "Reject"><input type="checkbox" onclick="handleClick(this);">' . '</td>';

                            echo '</tr>';
                        }
                        ?>


                    </tbody>                     
                </table>
                <!--no use but to refresh-->
                <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
            </form>
        </div>
        <?php
    }
} else {
//if the person logged in is a Manager then load this page
    if ($email === $manemail) {
        ?>
        <div class = "container-fluid datatables_wrapper">
            <form>
                <table id = "LeaveRequests" class = "table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="display:none">id_val</th><!--needed for sorting-->
                            <th>Name</th>
                            <th>Emp #</th>
                            <th>Emp Dept</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Accept</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $email = $_SESSION['login_user'];
                        $sql = "SELECT * FROM ApplyLeave where ManagerEmail = '$email' ";
                        $results = $dbh->query($sql);
                        $rows = $results->fetchAll();

                        foreach ($rows as $row) {
                            echo '<tr id="' . $row['id_val'] . '">';
                            echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
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
                            echo '<td class="reason">' . $row['Reason'] . '</td>' .
                            '<td id = "Accept"><input type="checkbox" onclick="handleClick(this);">' . '</td>' .
                            '<td id = "Reject"><input type="checkbox" onclick="handleClick(this);">' . '</td>';

                            echo '</tr>';
                        }
                        ?>


                    </tbody>                     
                </table>
                <!--no use but to refresh-->
                <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
            </form>
        </div>
        <?php
    } else {
        ?>

        <div class = "container-fluid datatables_wrapper">
            <form>
                <table id = "LeaveRequests" class = "table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="display:none">id_val</th><!--needed for sorting-->
                            <th>Name</th>
                            <th>Emp #</th>
                            <th>Emp Dept</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Days/Hours</th>
                            <th>Reason</th>
                            <th>Managers Response</th>
                            <th>Accept</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $email = $_SESSION['login_user'];
                        $sql = "SELECT * FROM ApplyLeaveHR where HREmail = '$email' ";
                        $results = $dbh->query($sql);
                        $rows = $results->fetchAll();

                        foreach ($rows as $row) {
                            echo '<tr id="' . $row['id_val'] . '">';
                            echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                            '<td class="name">' . $row['FirstName'] . " " . $row['LastName'] .
                            '<td class="empnum">' . $row['EmpID'] . '</td>' .
                            '<td class="empdept">' . $row['EmpDept'] . '</td>' .
                            '<td class="type">' . $row['LeaveType'] . '</td>' .
                            '<td class="dates">' . $row['StartDate'] . "-->" . $row['EndDate'] . '</td>' .
                            '<td class="days">' . $row['NumDays'] . '</td>' .
                            '<td class="reason">' . $row['Reason'] . '</td>' .
                            '<td class="manresp">' . $row['ManagerResponse'] . '</td>' .
                            '<td id = "Accept"><input type="checkbox" onclick="handleClick(this);">' . '</td>' .
                            '<td id = "Reject"><input type="checkbox" onclick="handleClick(this);">' . '</td>';

                            echo '</tr>';
                        }
                        ?>


                    </tbody>                     
                </table>
                <!--no use but to refresh-->
                <input class="btn btn-primary" type="submit" name="Submit" value="Submit "/> 
            </form>
        </div>

        <?php
    }
}
?>
<br>
<br>
<?php include("../Templates/footer_dashboard.php"); ?> 