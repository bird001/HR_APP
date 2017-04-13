<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
//include('../Validation/ValidateInput.php');
?>

<?php include("../Templates/header.php"); ?>
<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#Search').dataTable();

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });

    //window.alert("blah");
</script>

<script>

    function GenerateReport() {
        window.open("disciplinaryreport", "GenerateReport", "location=1,status=1,scrollbars=1,width=400,height=400");
    }
</script>

<style>
    form {
        display: inline;
    }
</style>
<?php include("../Templates/navigation.php"); ?>
<?php include("../Templates/body.php"); ?>
<?php include("../Letters/lettersNav.php"); ?>

<div class = "container-fluid datatables_wrapper">
    <form name="bulk_action_form" action="pdf" method="post">
        <table id = "Search" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th>Select</th>       
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Employee Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = 'SELECT * FROM DLetters';
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    echo '<tr id="' . $row['id_val'] . '">';
                    echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                    '<td class="fullname">' . $row['EmpFName'] . ' ' . $row['EmpLName'] . '</td>' .
                    '<td class="empid">' . $row['EmpID'] . '</td>' .
                    '<td class="empemail">' . $row['EmpEmail'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <br>
        <br>
        <input type="submit" class="btn btn-primary" id="DLetter" name="DLetter" value="Generate Letter">
    </form>
    <?php
    $email = $_SESSION['login_user'];
    $result = mysqli_query($conn, "select * from Users where EmpEmail = '$email' ");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $role = $row['EmpRole'];

    if ($role == 'Manager') {
        ?>
        <button class="btn btn-primary" onclick='GenerateReport();'>Generate Report</button>
        <?php
    }
    ?>
</div>
<br>
<br>
<br>
<?php include("../Templates/footer.php"); ?> 
