<?php

include('../db/db3.php');
include('../PHPMailer/SmtpMailer.php');

function Request($empname, $empdept, $empid, $email, $emplocation, $empfloor, $itemcat, $item, $model, $color, $itemamount) {
    global $conn;

    //get details of that employees manager
    $query_empman = "select * from ManagersDepartments where Department like '%$empdept%'";
    $result_empman = mysqli_query($conn, $query_empman);
    $row_empman = mysqli_fetch_array($result_empman, MYSQLI_ASSOC);

    $manageremail = $row_empman['EmpEmail'];
    $managername = $row_empman['Name'];
    $date_now = date("d-m-Y h:i A");


    //-------------------------------------------------------------------------------------


    if ($itemcat == 'Stationary') {
        //get details of items
        $query_items = "select * from InventoryStationary where Item = '$item'";
        $result_items = mysqli_query($conn, $query_items);
        $item_row = mysqli_fetch_array($result_items, MYSQLI_ASSOC);

        $itemid = $item_row['id_val'];

        //get details of Inventory Manager----------------------------------------------------------
        $invman_query = "select * from ManagersDepartments where Department like '%HR%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['Name'];
    }
    if ($itemcat == 'Tech') {
        //get details of items
        $query_items = "select * from InventoryTech where Item = '$item' and Color = '$color' and Model = '$model'";
        $result_items = mysqli_query($conn, $query_items);
        $item_row = mysqli_fetch_array($result_items, MYSQLI_ASSOC);

        $itemid = $item_row['id_val'];

        //get details of Inventory Manager----------------------------------------------------------
        $invman_query = "select * from ManagersDepartments where Department like '%IT%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['Name'];
    }
    if ($itemcat == 'Sanitary') {
        //get details of items
        $query_items = "select * from InventorySanitary where Item = '$item'";
        $result_items = mysqli_query($conn, $query_items);
        $item_row = mysqli_fetch_array($result_items, MYSQLI_ASSOC);

        $itemid = $item_row['id_val'];

        //get details of Inventory Manager----------------------------------------------------------
        $invman_query = "select * from ManagersDepartments where Department like '%HR%'";
        $invman_results = mysqli_query($conn, $invman_query);
        $invman_row = mysqli_fetch_array($invman_results, MYSQLI_ASSOC);

        $invmanemail = $invman_row['EmpEmail'];
        $invmanname = $invman_row['Name'];
    }
    //------------------------------------------------------------------------------------------
    //insert into table and update the respective managers
    if (!empty($itemid)) {
        $invreq_query = "insert into InventoryRequests (EmpID, EmpName, EmpDept, EmpEmail, EmpLocation, ItemID, ItemName, Model, Color, ItemCategory, EmpFloor, AmountRequested, "
                . "TimeRequested, Manager, ManagerEmail, InventoryManager, InventoryManEmail) values ('$empid','$empname', '$empdept','$email','$emplocation','$itemid',"
                . "'$item','$model','$color','$itemcat','$empfloor','$itemamount','$date_now', '$managername','$manageremail','$invmanname','$invmanemail')";
        mysqli_query($conn, $invreq_query);

        //send email to direct manager
       $cc='e.welsh@tipfriendly.com';//need to make this dynamic TO-DO
        smtpmailer_InventoryRequest($empname, $empdept, $email, $item, $itemamount, $invmanname, $invmanemail,$cc);
    } else {
        echo "The item '" . $item . " $color" . " $model" . "' is currently not in the catalog";
    }
}

function Approve(array $idArr) {
    global $conn;

    foreach ($idArr as $id) {
        //
        $approve_query = "select * from InventoryRequests where id_val = '$id' ";
        $approve_result = mysqli_query($conn, $approve_query);
        $approve_row = mysqli_fetch_array($approve_result, MYSQLI_ASSOC);

        $empid = $approve_row['EmpID'];
        $empname = $approve_row['EmpName'];
        $empdept = $approve_row['EmpDept'];
        $empemail = $approve_row['EmpEmail'];
        $emplocation = $approve_row['EmpLocation'];
        $itemid = $approve_row['ItemID'];
        $itemname = $approve_row['ItemName'];
        $model = $approve_row['Model'];
        $color = $approve_row['Color'];
        $itemcat = $approve_row['ItemCategory'];
        $empfloor = $approve_row['EmpFloor'];
        $amtreq = $approve_row['AmountRequested'];
        $timereq = $approve_row['TimeRequested'];
        $manname = $approve_row['Manager'];
        $manemail = $approve_row['ManagerEmail'];
        $invmanname = $approve_row['InventoryManager'];
        $invmanemail = $approve_row['InventoryManEmail'];

        if ($itemcat === 'Stationary') {

            $getinventory = "select * from InventoryStationary where id_val = $itemid";
            $getinventoryresults = mysqli_query($conn, $getinventory);
            $getinventoryrow = mysqli_fetch_array($getinventoryresults, MYSQLI_ASSOC);

            $invamt = $getinventoryrow['Amount'];
            
            if ($invamt >= $amtreq) {

                //send emails to relevant personnel
                smtpmailer_InventoryRequestApprove($empname, $empdept, $empemail, $itemname, $itemamount, $invmanname, $invmanemail);

                //update Inventory Request table
                $updateinvreq = "update InventoryRequests set ManagerAcceptReject = 'Accepted', ItemDelivered = 'No' where id_val = $id";
                mysqli_query($conn, $updateinvreq);
            } else {
                smtpmailer_InventoryRequestLimited($empname, $empdept, $empemail, $itemname, $amtreq, $manname, $manemail, $invmanname, $invmanemail);
            }
        }

        if ($itemcat === 'Tech') {

            $getinventory = "select * from InventoryTech where id_val = $itemid";
            $getinventoryresults = mysqli_query($conn, $getinventory);
            $getinventoryrow = mysqli_fetch_array($getinventoryresults, MYSQLI_ASSOC);

            $invamt = $getinventoryrow['Amount'];
            $cc='a.thomas@tipfriendly.com';//need to make this dynamic TO-DO
            if ($invamt >= $amtreq) {

                //send emails to relevant personnel
                smtpmailer_InventoryRequestApprove($cc, $empname, $empdept, $empemail, $itemname, $amtreq, $manname, $manemail, $invmanname, $invmanemail);

                //update Inventory Request table
                $updateinvreq = "update InventoryRequests set ManagerAcceptReject = 'Accepted',ItemDelivered = 'No' where id_val = $id";
                mysqli_query($conn, $updateinvreq);
                //------------------------------------------------------------------------------------------------------
            } else {
                smtpmailer_InventoryRequestLimited($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail);
            }
        }

        if ($itemcat === 'sanitary') {
            //TO-DO
        }
    }
}

function Delivered(array $idArr) {
    global $conn;

    foreach ($idArr as $id) {
        //
        $approve_query = "select * from InventoryRequests where id_val = '$id' ";
        $approve_result = mysqli_query($conn, $approve_query);
        $approve_row = mysqli_fetch_array($approve_result, MYSQLI_ASSOC);

        $empid = $approve_row['EmpID'];
        $empname = $approve_row['EmpName'];
        $empdept = $approve_row['EmpDept'];
        $empemail = $approve_row['EmpEmail'];
        $emplocation = $approve_row['EmpLocation'];
        $itemid = $approve_row['ItemID'];
        $itemname = $approve_row['ItemName'];
        $model = $approve_row['Model'];
        $color = $approve_row['Color'];
        $itemcat = $approve_row['ItemCategory'];
        $empfloor = $approve_row['EmpFloor'];
        $amtreq = $approve_row['AmountRequested'];
        $timereq = $approve_row['TimeRequested'];
        $manname = $approve_row['Manager'];
        $manemail = $approve_row['ManagerEmail'];
        $invmanname = $approve_row['InventoryManager'];
        $invmanemail = $approve_row['InventoryManEmail'];

        if ($itemcat === 'Stationary') {

            $getinventory = "select * from InventoryStationary where id_val = $itemid";
            $getinventoryresults = mysqli_query($conn, $getinventory);
            $getinventoryrow = mysqli_fetch_array($getinventoryresults, MYSQLI_ASSOC);

            $invamt = $getinventoryrow['Amount'];

            //update Inventory Request table
            $updateinvreq = "update InventoryRequests set ItemDelivered = 'Delivered' where id_val = $id";
            mysqli_query($conn, $updateinvreq);

            //update the Inventory-------------------------------------------------------------------------------
            $newamt = $invamt - $amtreq;

            $updateinventory = "update InventoryStationary set Amount = '$newamt' where id_val  = $itemid";
            mysqli_query($conn, $updateinventory);

            //------------------------------------------------------------------------------------------------------
            //remove the request from the table and insert into an archive
            $insertarchive = "insert into InventoryRequestsArchive (id_val,EmpID, EmpName, EmpDept, EmpEmail, EmpLocation, "
                    . "ItemID, ItemName, Model, Color, ItemCategory, EmpFloor,"
                    . "AmountRequested, TimeRequested, Manager, ManagerEmail, InventoryManager, "
                    . "InventoryManEmail, ManagerAcceptReject, ItemDelivered) "
                    . "select * from InventoryRequests where id_val = '$id'";
            mysqli_query($conn, $insertarchive);

            $remove = "delete from InventoryRequests where id_val = '$id'";
            mysqli_query($conn, $remove);
        }


        if ($itemcat === 'Tech') {

            $getinventory = "select * from InventoryTech where id_val = $itemid";
            $getinventoryresults = mysqli_query($conn, $getinventory);
            $getinventoryrow = mysqli_fetch_array($getinventoryresults, MYSQLI_ASSOC);

            $invamt = $getinventoryrow['Amount'];

            //update Inventory Request table
            $updateinvreq = "update InventoryRequests set ItemDelivered = 'Delivered' where id_val = $id";
            mysqli_query($conn, $updateinvreq);

            //update the Inventory-------------------------------------------------------------------------------
            $newamt = $invamt - $amtreq;

            $updateinventory = "update InventoryTech set Amount = '$newamt' where id_val  = $itemid";
            mysqli_query($conn, $updateinventory);

            //------------------------------------------------------------------------------------------------------
            //remove the request from the table and insert into an archive
            $insertarchive = "insert into InventoryRequestsArchive (id_val,EmpID, EmpName, EmpDept, EmpEmail, EmpLocation, "
                    . "ItemID, ItemName, Model, Color, ItemCategory, EmpFloor,"
                    . "AmountRequested, TimeRequested, Manager, ManagerEmail, InventoryManager, InventoryManEmail, ManagerAcceptReject, ItemDelivered) "
                    . "select * from InventoryRequests where id_val = '$id'";
            mysqli_query($conn, $insertarchive);

            $remove = "delete from InventoryRequests where id_val = '$id'";
            mysqli_query($conn, $remove);
        }

        if ($itemcat === 'sanitary') {
            //TO-DO
        }
    }
}

function Deny(array $idArr) {
    global $conn;

    foreach ($idArr as $id) {

        $approve_query = "select * from InventoryRequests where id_val = '$id' ";
        $approve_result = mysqli_query($conn, $approve_query);
        $approve_row = mysqli_fetch_array($approve_result, MYSQLI_ASSOC);

        $empid = $approve_row['EmpID'];
        $empname = $approve_row['EmpName'];
        $empdept = $approve_row['EmpDept'];
        $empemail = $approve_row['EmpEmail'];
        $emplocation = $approve_row['EmpLocation'];
        $itemid = $approve_row['ItemID'];
        $itemname = $approve_row['ItemName'];
        $model = $approve_row['Model'];
        $color = $approve_row['Color'];
        $itemcat = $approve_row['ItemCategory'];
        $empfloor = $approve_row['EmpFloor'];
        $amtreq = $approve_row['AmountRequested'];
        $timereq = $approve_row['TimeRequested'];
        $manname = $approve_row['Manager'];
        $manemail = $approve_row['ManagerEmail'];
        $invmanname = $approve_row['InventoryManager'];
        $invmanemail = $approve_row['InventoryManEmail'];



        //send emails to relevant personnel
        smtpmailer_InventoryRequestDeny($empname, $empdept, $empemail, $itemname, $amtreq, $manname, $manemail, $invmanname, $invmanemail);

        //update Inventory Request table
        $updateinvreq = "update InventoryRequests set ManagerAcceptReject = 'Rejected', ItemDelivered = 'No' where id_val = $id";
        mysqli_query($conn, $updateinvreq);


        //remove the request from the table and insert into an archive
        $insertarchive = "insert into InventoryRequestsArchive (id_val,EmpID, EmpName, EmpDept, EmpEmail, EmpLocation, "
                . "ItemID, ItemName, Model, Color, ItemCategory, EmpFloor,"
                . "AmountRequested, TimeRequested, Manager, ManagerEmail, InventoryManager, InventoryManEmail, ManagerAcceptReject, ItemDelivered) "
                . "select * from InventoryRequests where id_val = '$id'";
        mysqli_query($conn, $insertarchive);

        $remove = "delete from InventoryRequests where id_val = $id";
        mysqli_query($conn, $remove);
    }
}

?>