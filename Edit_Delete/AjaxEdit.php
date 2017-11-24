<?php

include '../db/db2.php';
include('../Login/session.php');
///update table when comments are made
if (isset($_GET['edit'])) {

    $column = $_GET['column'];
    $id = $_GET['id'];
    $newValue = $_GET["newValue"];
    $oldValue = $_GET["prevContent"];
    $tablename = $_GET["tablename"];
    $operator = $login_session;
    $date_now = date("d-m-Y h:i A");

    if ($tablename == 'EditNews') {
        $sql = "UPDATE DashBoard SET $column = :value, Time = now() WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'CRUDManagers') {
        $sql = "UPDATE ManagersDepartments SET $column = :value WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'InventoryStationary') {
        $sql = "UPDATE InventoryStationary SET $column = :value, LastUpdated = '$date_now' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'InventoryTech') {
        $sql = "UPDATE InventoryTech SET $column = :value, LastUpdated = '$date_now' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'InventorySanitation') {
        $sql = "UPDATE InventorySanitation SET $column = :value, LastUpdated = '$date_now' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'CRUDLeaves') {
        $sql = "UPDATE Leaves SET $column = :value WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'CRUDLoans') {
        $loanchangedate = date("F d, Y");
        $insert_loantype_archive = "insert into LoanTypesArchive(LoanName,LoanID,InterestPerAnnum,TimeToPay,Type,ChangeDate,ChangedBy)
                                select
                                LoanName, LoanID,InterestPerAnnum,TimeToPay,Type,'$loanchangedate','$operator'
                                from LoanTypes
                                WHERE id_val = '$id'";
        mysqli_query($conn, $insert_loantype_archive); //connect to db and execute
        
        $sql = "UPDATE LoanTypes SET $column = :value WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }

    if ($tablename == 'LeaveHistory') {
        $sql = "UPDATE ApplyLeaveHRArchive SET $column = :value, LastEdited = '$date_now', EditedBy = '$operator' WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }
}
?>