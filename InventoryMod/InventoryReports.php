<?php
//include("../Login/session.php");
//include("../db/db2.php");
//include("../db/db3.php");
include("../Templates/header.php");
?>
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#InventoryReports').dataTable({
            
            'dom': 'lBfrtip',
            'aLengthMenu': [20, 50, 100, 200],
            'iDisplayLength': 20,
            'sPaginationType': "full_numbers",
            'buttons': ['excel','pdf','print'
            ]
                    //buttons to display
        });

        //$(table.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>



<?php
include("../Templates/navigation.php");
include("../Templates/body.php");
include("../InventoryMod/InventoryNav.php");
include("../InventoryMod/RequestOperations.php");
?>

<div class = "container-fluid datatables_wrapper">
    <table id = "InventoryReports" class = "table-hover table-bordered" style="width:170%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>Department</th>
                <th>Location</th>
                <th>Floor</th>
                <th>Item Requested</th>
                <th>Amount Requested</th>
                <th>Time Requested</th>
                <th>Item Model</th>
                <th>Item Color</th>
                <th>Item Category</th>
                <th>Manager</th>
                <th>Status</th>
                <th>Delivery Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM InventoryRequestsArchive";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                echo '<tr name = "InventoryReports" id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '</td>' .
                '<td class="fname">' . $row['EmpName'] . '</td>' .
                '<td class="emdep">' . $row['EmpDept'] . '</td>' .
                '<td class="emploc">' . $row['EmpLocation'] . '</td>' .
                '<td class="flr">' . $row['EmpFloor'] . '</td>' .
                '<td class="itmreq">' . $row['ItemName'] . '</td>' .
                '<td class="amtreq">' . $row['AmountRequested'] . '</td>' .
                '<td class="timereq">' . $row['TimeRequested'] . '</td>' .
                '<td class="itmmod">' . $row['Model'] . '</td>' .
                '<td class="itmcol">' . $row['Color'] . '</td>' .
                '<td class="itemcat">' . $row['ItemCategory'] . '</td>' .
                '<td class="man">' . $row['Manager'] . '</td>' .
                '<td class="stat">' . $row['ManagerAcceptReject'] . '</td>'.
                '<td class="itmdel">' . $row['ItemDelivered'] . '</td>';

                echo '</tr>';
            }
            ?>


        </tbody>                     
    </table>


</div>
<br>
<br>
<?php include("../Templates/footer_dashboard.php"); ?> 