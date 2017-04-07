<?php

function Create($itemname, $itemid, $itemcategory, $itemamount) {
    global $conn;
    $date_now = date("d-m-Y h:i A");

    $create_query = "insert into Inventory (ItemName, ItemID, Category, ItemAmount, DateInputed) values ('$itemname', '$itemid', '$itemcategory', "
            . "'$itemamount', '$date_now')";

    mysqli_query($conn, $create_query);
}

function Update($itemname, $itemid, $itemcategory, $itemamout){
    global $conn;
    $date_now = date("d-m-Y h:i A");
    
    $update_query = "update Inventory set ItemAmount = '$itemamout', DateInputed = '$date_now' where ItemID = '$itemid' and ItemName = '$itemname'";

    mysqli_query($conn, $update_query);  
}

function Delete($itemname, $itemid, $itemamout){//TO-DO
    global $conn;
    $date_now = date("d-m-Y h:i A");
    
    $update_query = "update Inventory set ItemAmount = '$itemamout', DateInputed = '$date_now' where ItemID = '$itemid' and ItemName = '$itemname'";

    mysqli_query($conn, $update_query);  
}
    
?>

