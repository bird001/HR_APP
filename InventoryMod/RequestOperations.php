<?php

include('../db/db3.php');
include('../PHPMailer/SmtpMailer.php');

function Request($empname, $email, $empid, $empdept, $itemname, $itemamount) {
    global $conn;

    //get details of that employees manager
    $query_empman = "select * from Users where EmpDept = '$empdept' and EmpRole = 'Manager'";
    $result_empman = mysqli_query($conn, $query_empman);
    $row_empman = mysqli_fetch_array($result_empman, MYSQLI_ASSOC);

    $manageremail = $row_empman['EmpEmail'];
    $managername = $row_empman['FirstName'] . " " . $row_empman['LastName'];

    //get details of items
    $query_items = "select * from Inventory where ItemName = '$itemname'";
    $result_items = mysqli_query($conn, $query_items);
    $item_row = mysqli_fetch_array($result_items, MYSQLI_ASSOC);

    $itemid = $item_row['ItemID'];
    $itemcat = $item_row['Category'];
    //-------------------------------------------------------------------------------------
    //get details of Inventory Manager----------------------------------------------------------

    if ($itemcat == 'StationarySupplies') {
        $invman_query = "select * from Users where EmpPosition like '%HR Manager%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['FirstName'] . " " . $invman_row['LastName'];
    }
    if ($itemcat == 'TechSupplies') {
        $invman_query = "select * from Users where EmpPosition like '%IT Manager%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['FirstName'] . " " . $invman_row['LastName'];
    }
    if ($itemcat == 'SanitarySupplies') {
        $invman_query = "select * from Users where EmpPosition like '%Property Manager%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['FirstName'] . " " . $invman_row['LastName'];
    }
    //------------------------------------------------------------------------------------------
    //insert into table and update the respective managers

    $invreq_query = "insert into InventoryRequests (EmpID, EmpName, EmpDept, EmpEmail, ItemID, ItemName, ItemCategory, AmountRequested, Manager, ManagerEmail, "
            . "InventoryManager, InventoryManEmail) values ('$empid','$empname', '$empdept','$email','$itemid','$itemname','$itemcat','$itemamount','$managername',"
            . "'$manageremail','$invmanname','$invmanemail')";
    mysqli_query($conn, $invreq_query);
}

function Approve(array $idArr) {
    global $conn;

    foreach ($idArr as $id) {
        //
        $approve_query = "select * from InventoryRequests where id_val = '$id' ";
        $approve_result = mysqli_query($conn, $approve_query);
        $approve_row = mysqli_fetch_array($approve_result, MYSQLI_ASSOC);

        $empname = $approve_row['EmpName'];
        $empdept = $approve_row['EmpDept'];
        $empemail = $approve_row['EmpEmail'];
        $itemname = $approve_row['ItemName'];
        $itemid = $approve_row['ItemID'];
        $itemamount = $approve_row['AmountRequested'];
        $manname = $approve_row['Manager'];
        $manemail = $approve_row['ManagerEmail'];
        $invmanname = $approve_row['InventoryManager'];
        $invmanemail = $approve_row['InventoryManEmail'];

        $getinventory = "select * from Inventory where ItemID = $itemid";
        $getinventoryresults = mysqli_query($conn, $getinventory);
        $getinventoryrow = mysqli_fetch_array($getinventoryresults, MYSQLI_ASSOC);

        $invitemamt = $getinventoryrow['ItemAmount'];

        if ($invitemamt >= $itemamount) {

            //send emails to relevant personnel
            smtpmailer_InventoryRequestApprove($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail);

            //update Inventory Request table
            $updateinvreq = "update InventoryRequests set ManagerAcceptReject = 'Accepted' where id_val = $id";
            mysqli_query($conn, $updateinvreq);

            //update the Inventory-------------------------------------------------------------------------------
            $newamt = $invitemamt - $itemamount;

            $updateinventory = "update Inventory set ItemAmount = $newamt where ItemID = $itemid";
            mysqli_query($conn, $updateinventory);

            //------------------------------------------------------------------------------------------------------
            //remove the request from the table and insert into an archive
            $insertarchive = "insert into InventoryRequestsArchive (id_val, EmpID, EmpName, EmpDept, EmpEmail, ItemID, ItemName, ItemCategory, "
                    . "AmountRequested, Manager, ManagerEmail, InventoryManager, InventoryManEmail, ManagerAcceptReject) "
                    . "select * from InventoryRequests where id_val = $id";
            mysqli_query($conn, $insertarchive);

            $remove = "delete from InventoryRequests where id_val = $id";
            mysqli_query($conn, $remove);
        } else {
            smtpmailer_InventoryRequestLimited($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail);
        }
    }
}

function Deny(array $idArr) {
    global $conn;

    foreach ($idArr as $id) {
        $approve_query = "select * from InventoryRequests where id_val = '$id' ";
        $approve_result = mysqli_query($conn, $approve_query);
        $approve_row = mysqli_fetch_array($approve_result, MYSQLI_ASSOC);

        $empname = $approve_row['EmpName'];
        $empdept = $approve_row['EmpDept'];
        $empemail = $approve_row['EmpEmail'];
        $itemname = $approve_row['ItemName'];
        $itemamount = $approve_row['AmountRequested'];
        $manname = $approve_row['Manager'];
        $manemail = $approve_row['ManagerEmail'];
        $invmanname = $approve_row['InventoryManager'];
        $invmanemail = $approve_row['InventoryManEmail'];

        //send emails to relevant personnel
        smtpmailer_InventoryRequestDeny($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail);

        //update Inventory Request table
        $updateinvreq = "update InventoryRequests set ManagerAcceptReject = 'Rejected' where id_val = $id";
        mysqli_query($conn, $updateinvreq);


        //remove the request from the table and insert into an archive
        $insertarchive = "insert into InventoryRequestsArchive (id_val, EmpID, EmpName, EmpDept, EmpEmail, ItemID, ItemName, ItemCategory, "
                . "AmountRequested, Manager, ManagerEmail, InventoryManager, InventoryManEmail, ManagerAcceptReject) "
                . "select * from InventoryRequests where id_val = $id";
        mysqli_query($conn, $insertarchive);

        $remove = "delete from InventoryRequests where id_val = $id";
        mysqli_query($conn, $remove);
    }
}

?>