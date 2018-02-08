<?php

include("../db/db3.php");
include('../PHPMailer/SmtpMailer.php');
include("../Validation/ValidateInput.php");




// get inventory status for Stationary Items
$inv_stationary = "select * from InventoryStationary";
$inv_stationary_array = array();
$inv_stationary_array = $conn->query($inv_stationary);

//echo dateDifferenceDays('06-10-2017', date("d-m-Y"));

while ($row = $inv_stationary_array->fetch_assoc()) { //get details on items from stationary table
    $now = date('d-m-Y');
    $itemname = $row['Item'];
    $itemcolor = $row['Color'];
    $itembrand = $row['Brand'];
    $itemamount = $row['Amount'];
    $itemlocation = $row['Location'];
    $itemmodel = 'N/A';
    $address = 'e.welsh@tipfriendly.com';
    $addresscc = 's.grant@tipfriendly.com';
    //$addresscc = 'e.welsh@tipfriendly.com';//this was hard coded, change later when have more time
    //$address = 'a.adams@tipfriendly.com';
    if ($itemamount < 8) { //if item less than threshold then notifiy mr welsh and shonna
        smtpmailer_LowInvAlert($address, $addresscc, $itemname, $itemamount, $itemcolor, $itembrand, $itemmodel);
    }
}


// get inventory status for Tech Items
$inv_tech = "select * from InventoryTech";
$inv_tech_array = array();
$inv_tech_array = $conn->query($inv_tech);


while ($row = $inv_tech_array->fetch_assoc()) { //get details on items from tech table
    $now = date('d-m-Y');
    $itemname = $row['Item'];
    $itemcolor = $row['Color'];
    $itembrand = $row['Brand'];
    $itemmodel = $row['Model'];
    $itemamount = $row['Amount'];
    $itemlocation = $row['Location'];
    $address = 'd.richards@tipfriendly.com';
    $addresscc = 'a.thomas@tipfriendly.com';
    
    if ($itemamount < 8) { //if item less than threshold then notifiy mr welsh and shonna
        smtpmailer_LowInvAlert($address, $addresscc, $itemname, $itemamount, $itemcolor, $itembrand, $itemmodel);
    }
}

//to-do add in sanitary
?>