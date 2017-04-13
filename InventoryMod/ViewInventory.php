<?php
include('../Login/session.php');
include('../db/db2.php');
include('../db/db3.php');
?>

<html>

    <head>
        <title>View Inventory</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src = "jquerylib" type = "text/javascript"></script>
        <script src = "datatableslib" type = "text/javascript"></script>    
        <script src = "tabletoolslib" type = "text/javascript"></script>
        <script type = "text/javascript" charset="utf-8">

            $(document).ready(function () {
                $('#ViewInventory').dataTable({
                    "sPaginationType": "full_numbers" //show pagination buttons
                });
            });

        </script>
        <script>

        </script>
        <link href="bootstrapCSS" rel="stylesheet">
        <link href="tableToolsCSS" rel="stylesheet">
        <link href="datatablesCSS" rel="stylesheet">
    </head>

    <body>
        <div class = "container-fluid datatables_wrapper">
            <table id = "ViewInventory" class = "table-hover table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none">id_val</th><!--needed for sorting--> 
                        <th>Item Name</th>
                        <th>Item Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM Inventory";
                    $results = $dbh->query($sql);
                    $rows = $results->fetchAll();
                    //NB... if you want to make all the rows editable, make the class name the same as the row name`
                    foreach ($rows as $row) {
                        echo '<tr name = "ViewInventory" id="' . $row['id_val'] . '">';
                        echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                        '<td class="Headline">' . $row['ItemName'] . '</td>' .
                        '<td class="Story">' . $row['ItemAmount'] . '</td>';

                        echo '</tr>';
                    }
                    ?>


                </tbody>                     
            </table>

        </div>

    </body>

</html>
