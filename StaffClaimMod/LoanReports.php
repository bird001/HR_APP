<?php
include("../Templates/header.php");
$loantype = $_GET['type'];
?>


<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script type = "text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#LoanReports').dataTable({
            'dom': 'lBfrtip',
            'aLengthMenu': [20, 50, 100, 200],
            'iDisplayLength': 20,
            'sPaginationType': 'full_numbers',
            'buttons': [
                {extend: 'excel',
                    title: 'LoanReport',
                    exportOptions: {

                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                },
                {extend: 'pdf',
                    title: 'LoanReport',
                    exportOptions: {

                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        });

        //$(tableTools.fnContainer()).insertBefore('#datatables_wrapper');
    });
</script>

<div class = "container-fluid datatables_wrapper">
    <table id = "LoanReports" class = "table-hover table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="display:none">id_val</th><!--needed for sorting-->
                <th>Name</th>
                <th>Loan Type</th>
                <th>Beginning Balance</th>
                <th>Monthly Repayment($)</th>
                <th>Term(Months)</th>
                <th>Payment</th>
                <th>Date of Payment</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Ending Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($loantype == 'None') {
                ?>
            <h1> Please Select an Option</h1>
            <?php
        }

        if ($loantype == 'All') {
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM LoanApproved";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                //this if statement shows or hides relevant data from the Accounts Supervisor or manager


                echo '<tr id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '"</td>' .
                '<td class="name"> ' . $row['EmpName'] . ' </td>' .
                '<td class="empnum">' . $row['LoanType'] . '</td>' .
                '<td class="bal">' . $row['StartBalance'] . ' </td>' .
                '<td class="type">' . $row['MonthlyRepayment'] . '</td>' .
                '<td class="shrink">' . $row['RepaymentPeriod'] . '</td>' .
                '<td class="days">' . $row['Payment'] . '</td>' .
                '<td class="days">' . $row['PaymentDate'] . '</td>' .
                '<td class="days">' . $row['PrincipalRepaid'] . '</td>' .
                '<td class="days">' . $row['InterestRepaid'] . '</td>' .
                '<td class="days">' . $row['EndBalance'] . '</td>';
                echo '</tr>';
            }
        } 
        if($loantype == 'OutstandingLoans'){
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM LoanApproved where OutstandingPayments = '1' and Refreshable = '0'";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                //this if statement shows or hides relevant data from the Accounts Supervisor or manager


                echo '<tr id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '"</td>' .
                '<td class="name"> ' . $row['EmpName'] . ' </td>' .
                '<td class="empnum">' . $row['LoanType'] . '</td>' .
                '<td class="bal">' . $row['StartBalance'] . ' </td>' .
                '<td class="type">' . $row['MonthlyRepayment'] . '</td>' .
                '<td class="shrink">' . $row['RepaymentPeriod'] . '</td>' .
                '<td class="days">' . $row['Payment'] . '</td>' .
                '<td class="days">' . $row['PaymentDate'] . '</td>' .
                '<td class="days">' . $row['PrincipalRepaid'] . '</td>' .
                '<td class="days">' . $row['InterestRepaid'] . '</td>' .
                '<td class="days">' . $row['EndBalance'] . '</td>';
                echo '</tr>';
            }
            
        } else {
            $email = $_SESSION['login_user'];
            $sql = "SELECT * FROM LoanApproved where LoanType = '$loantype'";
            $results = $dbh->query($sql);
            $rows = $results->fetchAll();

            foreach ($rows as $row) {
                //this if statement shows or hides relevant data from the Accounts Supervisor or manager


                echo '<tr id="' . $row['id_val'] . '">';
                echo '<td class="id" style="display:none">' . $row['id_val'] . '"</td>' .
                '<td class="name"> ' . $row['EmpName'] . ' </td>' .
                '<td class="empnum">' . $row['LoanType'] . '</td>' .
                '<td class="bal">' . $row['StartBalance'] . ' </td>' .
                '<td class="type">' . $row['MonthlyRepayment'] . '</td>' .
                '<td class="shrink">' . $row['RepaymentPeriod'] . '</td>' .
                '<td class="days">' . $row['Payment'] . '</td>' .
                '<td class="days">' . $row['PaymentDate'] . '</td>' .
                '<td class="days">' . $row['PrincipalRepaid'] . '</td>' .
                '<td class="days">' . $row['InterestRepaid'] . '</td>' .
                '<td class="days">' . $row['EndBalance'] . '</td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>                     
    </table>
</div>
<?php
include("../Templates/footer_dashboard.php");
?>