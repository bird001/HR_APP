<?php
//connect to the database
include ('../db/db2.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Disciplinary Report</title>

        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src = "../js/jquery-2.1.4.min.js" type = "text/javascript"></script>

                <script src = "../js/jquery.dataTables.js" type = "text/javascript"></script>    
                <script src = "../js/tableTools.js" type = "text/javascript"></script>    

                <link rel = "stylesheet" href = "../CSS/datatables.min.css">
                    <link rel = "stylesheet" href = "../CSS/tableTools.css">


                        <script type = "text/javascript" charset="utf-8">
                            $(document).ready(function () {
                                var table = $('#datatables').dataTable();//initialize data tables
                                var tableTools = new $.fn.dataTable.TableTools(table, {
                                    'sSwfPath': '//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf', //initialize datatable functions
                                    'aButtons': [{
                                            'sExtends': 'xls',
                                            'sFileName': 'DesciplinaryReport.xlsx',
                                            'sButtonText': 'Download as Excel',
                                            "oSelectorOpts": {filter: 'applied', order: 'current'}//if filter is applied, only print filter list
                                        }]//buttons to display
                                });
                                $(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
                            });
                            //window.alert("blah");
                        </script>
                        <link href="../CSS/bootstrap.min.css" rel="stylesheet">

                            </head>
                            <body>
                                <div class = "container-fluid datatables_wrapper">
                                    <table id = "datatables" class = "table-hover table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="display:none">id_val</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>ID #</th>
                                                <th>First Letter</th>
                                                <th>Time</th>
                                                <th>Second Letter</th>
                                                <th>Time</th>
                                                <th>Suspension Letter</th>
                                                <th>Time</th>
                                                <th>Dismisal Letter</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = 'select * from DLetters';


                                            //$sql = 'select * from MasterFile,RecieptListings';
                                            $results = $dbh->query($sql);
                                            $rows = $results->fetchAll();
                                            //NB... if you want to make all the rows editable, make the class name the same as the row name`
                                            foreach ($rows as $row) {
                                                echo '<tr>';
                                                echo '<td class="rec_id" style="display:none">' . $row['id_val'] . '</td>' .
                                                '<td class="rec">' . $row['EmpFName'] . '</td>' .
                                                '<td class="memname">' . $row['EmpLName'] . '</td>' .
                                                '<td class="memname">' . $row['EmpEmail'] . '</td>' .
                                                '<td class="memname">' . $row['EmpID'] . '</td>' .
                                                '<td class="accnum">' . $row['FirstDLetter'] . '</td>' .
                                                '<td class="val">' . $row['FirstDLetterTime'] . '</td>' .
                                                '<td class="checknum">' . $row['SecondDLetter'] . '</td>' .
                                                '<td class="transdate">' . $row['SecondDLetterTime'] . '</td>' .
                                                '<td class="transdate">' . $row['SuspDLetter'] . '</td>' .
                                                '<td class="transdate">' . $row['SuspTime'] . '</td>' .
                                                '<td class="transdate">' . $row['DismisalLetter'] . '</td>' .
                                                '<td class="loanbal">' . $row['DisTime'] . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>                     
                                    </table>
                                </div>
                                
                            </body>
                            </html> 

