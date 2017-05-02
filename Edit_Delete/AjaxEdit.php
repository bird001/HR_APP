<?php

include '../db/db2.php';
include('../Login/session.php');
///update table when comments are made
if (isset($_GET['edit'])) {

    $column = $_GET['column'];
    $id = $_GET['id'];
    $newValue = $_GET["newValue"];
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
    
    if ($tablename == 'ViewInventory') {
        $sql = "UPDATE Inventory SET $column = :value, DateInputed = '$date_now' WHERE id_val = :id";
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
        $sql = "UPDATE LoanTypes SET $column = :value WHERE id_val = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':value', $newValue);
        $stmt->bindParam(':id', $id);
        $response['success'] = $stmt->execute();
        $response['value'] = $newValue;

        echo json_encode($response);
    }
}
?>