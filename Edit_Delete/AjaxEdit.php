<?php

include '../db/db2.php';
include('../Login/session.php');
///update table when comments are made
if (isset($_GET['edit'])) {

    $column = $_GET['column'];
    $id = $_GET['id'];
    $newValue = $_GET["newValue"];
    $operator = $login_session;

    $sql = "UPDATE DashBoard SET $column = :value, Time = now() WHERE id_val = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':value', $newValue);
    $stmt->bindParam(':id', $id);
    $response['success'] = $stmt->execute();
    $response['value'] = $newValue;

    echo json_encode($response);
}
?>