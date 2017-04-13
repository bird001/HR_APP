<?php
include('../db/db2.php');
include('../Validation/ValidateInput.php');
include('../PHPMailer/SmtpMailer.php');
include("../Templates/header.php");
?>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#EditReg').dataTable({
            "aLengthMenu": [20, 50, 100, 200],
            "iDisplayLength": 20
        });

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>

<script>
    function EditProfile() {
        //pop up window for uploading SchoolListinngs csv files
        window.open("editprofile", "Edit Profile", "location=1,status=1,scrollbars=1,width=400,height=550");
    }
</script>
<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../RegistrationMod/RegNav.php");
?>


<div class = "container-fluid datatables_wrapper">
    <form name="bulk_action_form" action="editprofile" method="post" target="popup" 
          onsubmit="window.open('about:blank','popup','width=600,height=990');">
        
        <table id = "EditReg" class = "table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display:none">id_val</th><!--needed for sorting-->
                    <th align = "center">
                        <div align = "center">

                        </div>
                    </th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>ID#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $email = $_SESSION['login_user'];
                $sql = "SELECT * FROM Users";
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    echo '<tr id="' . $row['id_val'] . '">';
                    echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                    '<td class="name">' . $row['FirstName'] . " " . $row['LastName'] .
                    '<td class="empnum">' . $row['EmpDept'] . '</td>' .
                    '<td class="empdept">' . $row['EmpID'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <!---->
        <input class="btn btn-primary" type="submit" onclick='EditProfile();' name="EditProfile" id = "EditProfile" value="EditProfile"/>
        
    </form>
</div>
<br>
<br>






<?php
include("../Templates/footer.php");
?>