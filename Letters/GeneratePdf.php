<?php

include('../db/db3.php');
include('Letters.php');
include('../PHPMailer/SmtpMailer.php');
include('../Login/session.php');


$operator = $login_session;
$idArr = $_POST['checked_id'];

if (!empty($idArr)) {
    foreach ($idArr as $id) {

        $result = mysqli_query($conn, "select * from DLetters where id_val = '$id' ");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $fname = $row['EmpFName'];
        $lname = $row['EmpLName'];
        $empid = $row['EmpID'];
        $empemail = $row['EmpEmail'];

        $filepath = "/var/www/HR_APP/HR_APP/Pdf/pdf_docs/";

        if (!(file_exists($filepath . "First/" . $fname . "_" . $lname . "_" . $empid . ".pdf"))) {
            //generate the letter
            FirstLetter($fname, $lname, $empid);
            //update database with letter status
            $first_query1 = "update DLetters set FirstDLetter = '1' where id_val = $id";
            $first_query2 = "update DLetters set FirstDLetterTime = now() where id_val = $id";
            mysqli_query($conn, $first_query1);
            mysqli_query($conn, $first_query2);

            //send email to employee with attatched letter----------------------------------------
            $subject1 = "First Disciplinary Letter";
            $attatch1 = $filepath . "First/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
            smtpmailer_Discipline($empemail, $operator, $subject1, $attatch1);
            //------------------------------------------------------------------------------------
        } else {
            if (!(file_exists($filepath . "Second/" . $fname . "_" . $lname . "_" . $empid . ".pdf"))) {
                SecondLetter($fname, $lname, $empid);
                $second_query1 = "update DLetters set SecondDLetter = '1' where id_val = $id";
                $second_query2 = "update DLetters set SecondDLetterTime = now() where id_val = $id";
                mysqli_query($conn, $second_query1);
                mysqli_query($conn, $second_query2);

                //send email to employee with attatched letter----------------------------------------
                $subject2 = "Second Disciplinary Letter";
                $attatch2 = $filepath . "Second/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
                smtpmailer_Discipline($empemail, $operator, $subject2, $attatch2);
                //------------------------------------------------------------------------------------
            } else {
                if (!(file_exists($filepath . "Suspension/" . $fname . "_" . $lname . "_" . $empid . ".pdf"))) {
                    SuspensionLetter($fname, $lname, $empid);
                    $sus_query1 = "update DLetters set SuspDLetter = '1' where id_val = $id";
                    $sus_query2 = "update DLetters set SuspTime = now() where id_val = $id";
                    mysqli_query($conn, $sus_query1);
                    mysqli_query($conn, $sus_query2);

                    //send email to employee with attatched letter----------------------------------------
                    $subject3 = "Suspension Letter";
                    $attatch3 = $filepath . "Suspension/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
                    smtpmailer_Discipline($empemail, $operator, $subject3, $attatch3);
                    //------------------------------------------------------------------------------------
                } else {
                    if (!(file_exists($filepath . "Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf"))) {
                        DismisalLetter($fname, $lname, $empid);
                        $dis_query1 = "update DLetters set DismisalLetter = '1' where id_val = $id";
                        $dis_query2 = "update DLetters set DisTime = now() where id_val = $id";
                        mysqli_query($conn, $dis_query1);
                        mysqli_query($conn, $dis_query2);

                        //send email to employee with attatched letter----------------------------------------
                        $subject4 = "Dismisal Letter";
                        $attatch4 = $filepath . "Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
                        smtpmailer_Discipline($empemail, $operator, $subject4, $attatch4);
                        //------------------------------------------------------------------------------------
                        //TO-DO  notify persons and managers of the dismisal of someone, remove that person from this systems database
                    }
                }
            }
        }
    }
} else {
    header("Location: ../Letters/generateDLetter.php"); //redirect to login page
}
?>
