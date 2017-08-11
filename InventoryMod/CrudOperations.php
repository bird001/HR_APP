<?php

function CreateStationary($itemname, $color, $brand, $itemamount) {
    global $conn;
    $date_now = date("d-m-Y h:i A");

    $create_query = "insert into InventoryStationary (Item, Color, Brand, Amount, LastUpdated) values ('$itemname','$color', '$brand', "
            . "'$itemamount', '$date_now')";

    mysqli_query($conn, $create_query);
}

function CreateTech($itemname, $color, $brand, $model, $itemamount) {
    global $conn;
    $date_now = date("d-m-Y h:i A");

    $create_query = "insert into InventoryTech (Item, Color, Brand, Model, Amount, LastUpdated) values ('$itemname','$color', '$brand', '$model', "
            . "'$itemamount', '$date_now')";

    mysqli_query($conn, $create_query);
}

function Update($itemname, $itemid, $itemcategory, $itemamout){
    global $conn;
    $date_now = date("d-m-Y h:i A");
    
    $update_query = "update Inventory set ItemAmount = '$itemamout', DateInputed = '$date_now' where ItemID = '$itemid' and ItemName = '$itemname'";

    mysqli_query($conn, $update_query);  
}

    
?>

