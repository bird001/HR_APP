<?php

include("../db/db2.php");
include("../db/db3.php");
include("../Login/session.php");

if (isset($_POST['get_item'])) {
    $invcategory = $_POST['get_item'];
    $invlocation = $_POST['get_location'];
    if ($invcategory === 'Stationary' || $invcategory === 'Sanitary') {
        $invselect = "select distinct Item from Inventory" . $invcategory . " where Location = '$invlocation'";
    } else {
        $invselect = "select distinct Item from Inventory" . $invcategory;
    }
    $find = mysqli_query($conn, $invselect);

    echo "<option disabled selected value> -- select item -- </option>";
    while ($row = mysqli_fetch_array($find)) {
        echo "<option>" . $row['Item'] . "</option>";
    }
    exit;
}

if (isset($_POST['get_model'])) {
    $item = $_POST['get_model'];
    $cat = $_POST['get_cat1'];
    if ($cat === 'Tech') {
        $itemmodel = "select distinct Model from InventoryTech where Item = '$item'";
        $find = mysqli_query($conn, $itemmodel);

        echo "<option disabled selected value> -- select model -- </option>";
        while ($row = mysqli_fetch_array($find)) {
            echo "<option>" . $row['Model'] . "</option>";
        }
        exit;
    } else {
        echo "<option selected value='n/a'>N/A</option>";
    }
}


if (isset($_POST['get_color'])) {
    $item = $_POST['get_color'];
    $cat = $_POST['get_cat2'];
    if ($cat === 'Tech' || $cat === 'Stationary') {
        $itemcolor = "select distinct Color from Inventory" . $cat . " where Item = '$item'";
        $find = mysqli_query($conn, $itemcolor);
        echo "<option disabled selected value> -- select color -- </option>";
        while ($row = mysqli_fetch_array($find)) {
            echo "<option>" . $row['Color'] . "</option>";
        }
        exit;
    } else {
        echo "<option selected value='n/a'>N/A</option>";
    }
}
?>