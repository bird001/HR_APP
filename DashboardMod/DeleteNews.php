<?php
include('../Login/session.php');
include('../db/db2.php');
include('../db/db3.php');
?>

<html>

    <head>
        <title>Delete News</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src = "jquerylib" type = "text/javascript"></script>
        <script src = "datatableslib" type = "text/javascript"></script>    
        <script src = "tabletoolslib" type = "text/javascript"></script>    
        <script type="text/javascript" src="deleterow"></script>
        <script type = "text/javascript" charset="utf-8">

            $(document).ready(function () {
                $('#DeleteNews').dataTable();
            });
        </script>

        <link href="bootstrapCSS" rel="stylesheet">
        <link href="tabletoolsCSS" rel="stylesheet">
        <link href="datatablesCSS" rel="stylesheet">
    </head>

    <body>
        <div align = "right" class = "container-fluid">

            <div class = "container-fluid datatables_wrapper">
                <form name="bulk_action_form" action="deleterows" method="post" >
                    <table id = "DeleteNews" class = "table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">id_val</th><!--needed for sorting-->
                                <th align = "center">
                                    <div>
                                        <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete" onclick = "deleteConfirm();"/>
                                    </div>
                                    <div align = "center">
                                        <input type="checkbox" name="select_all" id="select_all" value=""/>
                                    </div>
                                </th>                       
                                <th>Headline</th>
                                <th>Story</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM DashBoard where Email = '$login_session' order by Time desc";
                            $results = $dbh->query($sql);
                            $rows = $results->fetchAll();
                            //NB... if you want to make all the rows editable, make the class name the same as the row name`
                            foreach ($rows as $row) {
                                echo '<tr id="' . $row['id_val'] . '">';
                                echo '<td class="if" style="display:none">' . $row['id_val'] . '</td>' .
                                '<td align = "center"><input type="checkbox" name = "checked_id[]" class = "checkbox" value= "' . $row['id_val'] . '" >' . '</td>' .
                                '</form>' .
                                '<td class="headline">' . $row['Headline'] . '</td>' .
                                '<td class="story">' . $row['Story'] . '</td>';

                                echo '</tr>';
                            }
                            ?>


                        </tbody>                     
                    </table>
                </form>
            </div>
        </div>
    </body>

</html>
