<?php
include("../Login/session.php");
include("../db/db2.php");
include("../db/db3.php");
?>

<?php include("../Templates/header.php"); ?>
<script type = "text/javascript" charset="utf-8">

    $(document).ready(function () {
        $('#Search').dataTable();

        $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });

    //window.alert("blah");
</script>
<?php include("../Templates/navigation.php"); ?>
<?php include("../Templates/body.php"); ?>
<?php include("../Letters/lettersNav.php"); ?>

<div class = "container-fluid datatables_wrapper">
    <form name="bulk_action_form" action="lettertemplatesgen" method="post" >
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
                $sql = 'SELECT * FROM Users';
                $results = $dbh->query($sql);
                $rows = $results->fetchAll();

                foreach ($rows as $row) {
                    echo '<tr id="' . $row['id_val'] . '">';
                    echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                    '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                    '<td class="fullname">' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>' .
                    '<td class="empid">' . $row['EmpID'] . '</td>' .
                    '<td class="empemail">' . $row['EmpEmail'] . '</td>';

                    echo '</tr>';
                }
                ?>


            </tbody>                     
        </table>
        <br>
        <br>
        <div class="form-group">
            <label for="inputRecName" class="control-label">Recipients Name/Title</label>
            <input type="text" name="RecName" id="RecName" class="form-control" placeholder="The Manager" required/>
            <span class="error"><?php echo $nametitleError; ?></span>
        </div>
        <div class="form-group">
            <label for="inputCompanyName" class="control-label">Company Name</label>
            <input type="text" name="CompanyName" id="CompanyName" class="form-control" placeholder="TIP Friendly Society" required/>
            <span class="error"><?php echo $companynameError; ?></span>
        </div>
        <div class="form-group">
            <label for="inputCompanyAdd" class="control-label">Company Address</label>
            <input type="text" name="CompanyAdd" id="CompanyAdd" class="form-control" placeholder="Blah" required/>
            <span class="error"><?php echo $companyaddError; ?></span>
        </div>
        
        
        <br>
        <br>
        <input type="submit" class="btn btn-primary" id="JobLetter" name="Letter" value="Job Letter"/>
        <input type="submit" class="btn btn-primary" id="RecomLetter" name="Letter" value="Recommendation Letter"/>
    </form>

</div>
<br>
<br>
<br>
<?php include("../Templates/footer.php"); ?> 
