<?php

//include ('../db/db3.php');
include('class.phpmailer.php');
include('PHPMailerAutoload.php');

define('GUSER', 'info@tipfriendly.com'); // GMail username
define('GPWD', 'M@rket#1234'); // GMail password

function smtpmailer_Discipline($to, $from, $subject, $attatch) {
//global $error;

    $mail = new PHPMailer;  // create a new object

    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    //$mail->SetFrom(GUSER, 'Tip Friendly Society');
    $mail->SetFrom(GUSER, $from);
    $mail->Subject = $subject;
    $mail->Body = 'Generated by ' . $from;
    $mail->AddAddress($to);
    $mail->addAttachment($attatch);
    $mail->isHTML(true);

    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'message sent';
        exit;
        //return true;
    }
}

function smtpmailer_LeaveAcceptMan($to, $from, $name, $dept, $type, $numdays, $startdate, $enddate) {
//global $error;

    $mail = new PHPMailer;  // create a new object

    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    //$mail->SetFrom(GUSER, $from);
    //$mail->Subject = "Leave Application for $name from $from";
    $mail->Subject = "Leave Application Finalization";
    $mail->Body = "Accepted $name of the $dept Department for $type leave application for $numdays from $startdate to $enddate, please review and finalize";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        $error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'message sent';

        //exit;
        //return true;
    }
}

function smtpmailer_LeaveRejectMan($to, $from, $name, $dept, $type, $numdays, $startdate, $enddate) {
//global $error;

    $mail = new PHPMailer;  // create a new object

    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    //$mail->SetFrom(GUSER, $from);
    //$mail->Subject = "Leave Application for $name::email from $from";
    $mail->Subject = "Leave Application Finalization";
    $mail->Body = "I rejected the leave application of"
            . " $name of the $dept Department for $type leave application for $numdays from $startdate to $enddate, please review and finalize";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        $error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'message sent';

        //exit;
        //return true;
    }
}

function smtpmailer_LeaveAcceptHR($to, $from, $name, $dept, $type, $numdays, $startdate, $enddate) {
//global $error;

    $mail = new PHPMailer;  // create a new object

    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    //$mail->SetFrom(GUSER, $from);
    $mail->Subject = "Leave Accepted";
    $mail->Body = "Dear $name of the $dept Department  your $type leave application for $numdays from $startdate to $enddate has been Accepted ";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'message sent';

        //exit;
        //return true;
    }
}

function smtpmailer_LeaveRejectHR($to, $from, $name, $dept, $type, $numdays, $startdate, $enddate) {
//global $error;

    $mail = new PHPMailer;  // create a new object

    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    //$mail->SetFrom(GUSER, $from);
    $mail->Subject = "Leave Rejected";
    $mail->Body = "Dear $name of the $dept Department  your $type leave application for $numdays from $startdate to $enddate has been Rejected ";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'message sent';

        //exit;
        //return true;
    }
}

function smtpmailer_ApplyLeave($to, $from, $name, $dept, $type, $numdays, $startdate, $enddate) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    //$url = "<html><a href='http://localhost/HR_APP/HR_APP/LeaveMod/LeaveRequests.php'>Leave Requests</a></html>";
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    //$mail->SetFrom(GUSER, $from);
    $mail->Subject = "Leave Application";
    $mail->Body = "$name of the $dept Department has applied for $numdays [$type]. Starting at the $startdate to the $enddate." . "<br>"
            . "Please log into the HR Application in order to vet the leave application.";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        //$error = 'Message sent!';
        echo 'Applied Succesfully';

        //exit;
        //return true;
    }
}

//smtpmailer_ApplyLeave('a.adams@tipfriendly.com', 'a.thomas@tipfriendly.com', 'Andrew Thomas', 'IT', 'Vacation', '8', '22-09-2016', '23-09-2016');


function smtpmailer_OutstandingLeave($to, $name, $days) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    //$url = "<html><a href='http://localhost/HR_APP/HR_APP/LeaveMod/LeaveApply.php'>Leave Apply</a></html>";
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    $mail->Subject = "Outstanding Leave";
    $mail->Body = "Dear $name it has been noted that you have accumulated $days outstanding leave day(s) over a three year period."
            . "Please rectify by going on leave ASAP to clear off the days. \n"
            . "tiphra.com/login";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_LoanApplication($to, $name, $dept) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    //$url = "<html><a href='http://localhost/HR_APP/HR_APP/LeaveMod/LeaveApply.php'>Leave Apply</a></html>";
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Tip Friendly Society');
    $mail->Subject = "Loan Application from " . $name . " of the " . $dept . " Department";
    $mail->Body = "Please Log into the HR Application tiphra.com/login";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_AccountsApprove($to, $name, $dept) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    //$url = "<html><a href='http://localhost/HR_APP/HR_APP/LeaveMod/LeaveApply.php'>Leave Apply</a></html>";
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'TIP Friendly Society');
    $mail->Subject = "Loan Application from " . $name . " of the " . $dept . " Department";
    $mail->Body = "This application has been revised and approved by the Accounts Dept."
            . "Vet and proceed as necessary \n"
            . "tiphra.com/login";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_GMApprove($to, $name, $dept) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    //$url = "<html><a href='http://localhost/HR_APP/HR_APP/LeaveMod/LeaveApply.php'>Leave Apply</a></html>";
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'TIP Friendly Society');
    $mail->Subject = "Loan Application from " . $name . " of the " . $dept . " Department";
    $mail->Body = "This application has been Vetted and approved by the AGM."
            . " Disburse the loan \n"
            . "tiphra.com/login";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_GMApprove2($to, $name, $dept, $type, $amount) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'TIP Friendly Society');
    $mail->Subject = "Loan Application";
    $mail->Body = "Dear $name of the $dept department we would like to inform you that your $type loan request for $ $amount has been approved"
            . ". Please Go to the Accounts Dept to sign the relevant documents.";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_Disburse($to, $name, $dept, $type, $amount) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'TIP Friendly Society');
    $mail->Subject = "Loan Application";
    $mail->Body = "Dear $name of the $dept department we would like to inform you that your $type loan request for $ $amount has been disbursed.";
    $mail->AddAddress($to);
    //$mail->addAttachment($attatch);
    $mail->isHTML(true);



    if (!$mail->send()) {
        //$error = 'Mail error: ' . $mail->ErrorInfo;
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        echo $error;

        //exit;
        //return true;
    }
}

function smtpmailer_Registration($to, $name, $dept, $password) {
//global $error;

    $mail = new PHPMailer;  // create a new object
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'TIP Friendly Society');
    $mail->Subject = "Registration";
    $mail->Body = "Dear $name of the $dept department we would like to inform you that your HRM account has been created "
            . "your username is your email address and your password is $password "
            . "please login at <a href = 'http://tiphra/login'>tiphrapp</a>";
    $mail->AddAddress($to);
    $mail->isHTML(true);



    if (!$mail->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_InventoryRequest($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail) {
//global $error;
    //email to employee--------------------------------------------------------------------------------
    $mailemp = new PHPMailer;  // create a new object
    $mailemp->isSMTP(); // enable SMTP
    //$mailemp->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailemp->SMTPAuth = true;  // authentication enabled
    $mailemp->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailemp->SMTPAutoTLS = false;
    $mailemp->Host = 'smtp.gmail.com';
    $mailemp->Port = 25;
    $mailemp->Username = GUSER;
    $mailemp->Password = GPWD;
    $mailemp->SetFrom(GUSER, $empemail);
    $mailemp->Subject = "Inventory Request";
    $mailemp->Body = "Dear $manname I, $empname, from your department, $empdept, am requesting $itemamount $itemname(s).<br>"
            . "Please login at <a href = 'http://tiphra/login'>tiphrapp</a>";
    $mailemp->AddAddress($manemail);
    $mailemp->isHTML(true);

    //--------------------------------------------------------------------------------------------------------

    if (!$mailemp->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mailemp->ErrorInfo;
        //echo 'Mailer Error: ' . $mailinv->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_InventoryRequestApprove($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail) {
//global $error;
    //email to employee--------------------------------------------------------------------------------
    $mailemp = new PHPMailer;  // create a new object
    $mailemp->isSMTP(); // enable SMTP
    //$mailemp->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailemp->SMTPAuth = true;  // authentication enabled
    $mailemp->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailemp->SMTPAutoTLS = false;
    $mailemp->Host = 'smtp.gmail.com';
    $mailemp->Port = 25;
    $mailemp->Username = GUSER;
    $mailemp->Password = GPWD;
    $mailemp->SetFrom(GUSER, $manemail);
    $mailemp->Subject = "Inventory Request";
    $mailemp->Body = "Dear $empname your request for $itemamount $itemname(s) has been approved, you may approach $invmanname for the item(s) requested)";
    $mailemp->AddAddress($empemail);
    $mailemp->isHTML(true);

    //--------------------------------------------------------------------------------------------------------
    //email to inventory manager------------------------------------------------------------------------------
    $mailinv = new PHPMailer;  // create a new object
    $mailinv->isSMTP(); // enable SMTP
    //$mailinv->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailinv->SMTPAuth = true;  // authentication enabled
    $mailinv->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailinv->SMTPAutoTLS = false;
    $mailinv->Host = 'smtp.gmail.com';
    $mailinv->Port = 25;
    $mailinv->Username = GUSER;
    $mailinv->Password = GPWD;
    $mailinv->SetFrom(GUSER, $manemail);
    $mailinv->Subject = "Inventory Request";
    $mailinv->Body = "Dear $invmanname I, $manname, have approved for $empname to receive $itemamount $itemname from you."
            . " They will be by shortly";
    $mailinv->AddAddress($invmanemail);
    $mailinv->isHTML(true);

    //--------------------------------------------------------------------------------------------------------

    if (!$mailemp->send() || !$mailinv->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mailemp->ErrorInfo;
        //echo 'Mailer Error: ' . $mailinv->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_InventoryRequestDeny($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail) {
//global $error;
    //email to employee--------------------------------------------------------------------------------
    $mailemp = new PHPMailer;  // create a new object
    $mailemp->isSMTP(); // enable SMTP
    //$mailemp->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailemp->SMTPAuth = true;  // authentication enabled
    $mailemp->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailemp->SMTPAutoTLS = false;
    $mailemp->Host = 'smtp.gmail.com';
    $mailemp->Port = 25;
    $mailemp->Username = GUSER;
    $mailemp->Password = GPWD;
    $mailemp->SetFrom(GUSER, $manemail);
    $mailemp->Subject = "Inventory Request";
    $mailemp->Body = "Dear $empname your request for $itemamount $itemname(s) has been denied.)";
    $mailemp->AddAddress($empemail);
    $mailemp->isHTML(true);

    //--------------------------------------------------------------------------------------------------------
    //email to inventory manager------------------------------------------------------------------------------
    $mailinv = new PHPMailer;  // create a new object
    $mailinv->isSMTP(); // enable SMTP
    //$mailinv->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailinv->SMTPAuth = true;  // authentication enabled
    $mailinv->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailinv->SMTPAutoTLS = false;
    $mailinv->Host = 'smtp.gmail.com';
    $mailinv->Port = 25;
    $mailinv->Username = GUSER;
    $mailinv->Password = GPWD;
    $mailinv->SetFrom(GUSER, $manemail);
    $mailinv->Subject = "Inventory Request";
    $mailinv->Body = "Dear $invmanname I, $manname, have denied $empname from receiving $itemamount $itemname from you."
            . " Do not provide this individual with such item";
    $mailinv->AddAddress($invmanemail);
    $mailinv->isHTML(true);

    //--------------------------------------------------------------------------------------------------------

    if (!$mailemp->send() || !$mailinv->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mailemp->ErrorInfo;
        //echo 'Mailer Error: ' . $mailinv->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_InventoryRequestLimited($empname, $empdept, $empemail, $itemname, $itemamount, $manname, $manemail, $invmanname, $invmanemail) {
//global $error;
    //email to employee--------------------------------------------------------------------------------
    $mailemp = new PHPMailer;  // create a new object
    $mailemp->isSMTP(); // enable SMTP
    //$mailemp->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailemp->SMTPAuth = true;  // authentication enabled
    $mailemp->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailemp->SMTPAutoTLS = false;
    $mailemp->Host = 'smtp.gmail.com';
    $mailemp->Port = 25;
    $mailemp->Username = GUSER;
    $mailemp->Password = GPWD;
    $mailemp->SetFrom(GUSER, $manemail);
    $mailemp->Subject = "Inventory Request";
    $mailemp->Body = "Dear $empname, there is not enough inventory for the item(s) you requested, namely $itemamount $itemname(s).)";
    $mailemp->AddAddress($empemail);
    $mailemp->isHTML(true);

    //-------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------

    if (!$mailemp->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mailemp->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_PasswordChange($empname, $empemail, $emppass) {
//global $error;
    //email to employee--------------------------------------------------------------------------------
    $mailemp = new PHPMailer;  // create a new object
    $mailemp->isSMTP(); // enable SMTP
    //$mailemp->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mailemp->SMTPAuth = true;  // authentication enabled
    $mailemp->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mailemp->SMTPAutoTLS = false;
    $mailemp->Host = 'smtp.gmail.com';
    $mailemp->Port = 25;
    $mailemp->Username = GUSER;
    $mailemp->Password = GPWD;
    $mailemp->SetFrom(GUSER, 'TIP Friendly Society');
    $mailemp->Subject = "Password Changed";
    $mailemp->Body = "Dear $empname, your password for the HR Application has been changed to $emppass, your username remains your email address,  "
            . "please log into the <a href = 'http://tiphra/login'>tiphrapp</a>" ;
    $mailemp->AddAddress($empemail);
    $mailemp->isHTML(true);

    //-------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------

    if (!$mailemp->send()) {
        echo 'Try Again';
        //echo 'Mailer Error: ' . $mailemp->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

function smtpmailer_test() {
//global $error;

    $mail = new PHPMailer;  // create a new object
    $mail->isSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 25;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom(GUSER, 'Test');
    $mail->Subject = "test";
    $mail->Body = "just a test";
    $mail->AddAddress('a.thomas@tipfriendly.com');
    $mail->isHTML(true);



    if (!$mail->send()) {
        echo 'Try Again';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        //return false;
    } else {
        $error = 'Message sent!';
        //echo $error;
    }
}

//smtpmailer_test();
?>