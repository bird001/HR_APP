<?php
//connect to the database
include ('../db/db3.php');
include ('../Scripts/PHPExcel.php');
include ('../Validation/ValidateInput.php');
include ('../Scripts/PHPExcel/IOFactory.php');
include('../PHPMailer/SmtpMailer.php');

//to-do read in excel file
if ($_FILES[uploaded_file][size] > 0) {

    $filename = $_FILES[uploaded_file][name];
    $tmpname = $_FILES[uploaded_file][tmp_name];
    $filetype = $_FILES[uploaded_file][type];
    //$uploadDirectory = '/home/phoenix/Documents/Files';
    //move_uploaded_file($tmpname, "$uploadDirectory/$filename");

    if (strpos($filetype, 'ms-excel') == true || strpos($filetype, 'openxmlformats-officedocument.spreadsheetml.sheet') == true) { // IF doc is excel, read into database
        $objPHPExcel = PHPExcel_IOFactory::load($tmpname);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                $fname = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $lname = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $empsex = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                $empid = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $empmail = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $empstatus = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $empdept = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $emprole = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $empposition = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $empaddress = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $dob = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(10, $row)->getFormattedValue());
                $empdob = date("d-m-Y", strtotime($dob));
                $empphone = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
                $start = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(12, $row)->getFormattedValue());
                $empstart = date("d-m-Y", strtotime($start));
                $empstartdate = date("Y-m-d", strtotime($start));
                //$emppass = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(13, $row)->getValue());
                $emppass = RandomString();

                //insert into Users table --------------------------------------------------------------------------------------------------------
                $registration = "INSERT INTO Users (FirstName, LastName, EmpSex, EmpID, EmpEmail, EmpStatus, EmpDept, EmpRole, EmpPosition, 
                        EmpAddress, EmpDOB, EmpPhone, EmpStartDate, EmpPass, TimeCreated, PasswordChanged) VALUES ('" . $fname . "', '" . $lname . "','" . $empsex . "','" . $empid . "','" . $empmail . "','" . $empstatus . "',
                        '" . $empdept . "','" . $emprole . "','" . $empposition . "','" . $empaddress . "','" . $empdob . "','" . $empphone . "',
                        '" . $empstart . "','" . $emppass . "', NOW(), '0')";
                mysqli_query($conn, $registration);
                //--------------------------------------------------------------------------------------------------------------------------------
               
            }
        }
    } else {
        echo "incorrect file type, expecting microsoft excel document";
    }
    echo "<script>window.close();</script>";
}


          

//to-do calculate leave days for each entry
//to-do insert each entry into DLetter Tables
//
//to-do insert each entry into Leaves Tables
//to-do update dashboard table
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Import Bulk</title>
        <link href="bootstrapCSS" rel="stylesheet" />
    </head>

    <body>
        <div class = form-group>
            <form class = "form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                Choose your file: <br />
                <input name="uploaded_file" type="file" id="uploaded_file" />
                <input type="submit" name="Submit" value="Submit" />
            </form>
        </div>
    </body>
</html>