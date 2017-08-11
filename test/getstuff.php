

<?php

include('../db/db3.php');

$q = $_GET['q'];

//mysqli_select_db($con, "ajax_demo");

if ($q === 'tech') {
    $sql = "SELECT * FROM InventoryTech";
    $result = mysqli_query($conn, $sql);

    echo "<select>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<option disabled selected value> --select item --</option>";
        echo "<option value>" . $row['Item'] . "</option>";
    }
    echo "</select>";
    mysqli_close($con);
}
?>