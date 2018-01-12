<?php

//Tally Leave and Carry Over Leave
include("../db/db3.php"); //use when testing
include("../Validation/ValidateInput.php"); //use when testing


$sql_get = "select * from Leaves";
$get_arr = array();
$get_arr = $conn->query($sql_get);

while ($row = $get_arr->fetch_assoc()) {

    $empemail = $row['EmpEmail'];
    $startdate = date("Y", strtotime($row['EmpStartDate']));
    //$startdate1 = date("Y", $startdate);
    $yearsofemp = $row['YearsOfEmployment'];
    $role = $row['EmpRole'];
    $vacationDaysRemain = $row['Vacation']; //get vacation days that haven't been used
    $vacationOutstanding = $row['VacationOutstanding']; //get vacation days that haven't been used
    $now = date("Y");
    $empsex = $row['EmpSex'];
    $outstandingleave = $row['OutstandingLeave_Years'];

    //echo $yearsOfService = dateDifferenceYears($startdate, $now); //calculates the years of service 
    $yearsOfService = $now - $startdate; //calculates the years of service 
    //$yearsOfService = dateDifferenceYears($startdate, "11-08-2016");//for testing




    //if years of service > years of emp then update leave days and employment years
    if ($yearsOfService > $yearsofemp) {
        //update Leaves table with new allocation of leave days for the different types of leave and increment the years of employment column
        //also if any vacation leave is left from the previous year, add it back to the amount and increment OustandingLeave_Years column in Leave Table

        if ($vacationDaysRemain === '0') {
            //begin calculation of leave days---------------------------------------------------------------------------------------------------------------
            $yearsOfEmp = $yearsOfService;
            //vacation days for managers

            if ($yearsOfEmp >= '0' && $yearsOfEmp <= '5' && $role === 'Manager') {
                $vacationDays = "15";
            }

            if ($yearsOfEmp >= '6' && $yearsOfEmp <= '10' && $role === 'Manager') {
                $vacationDays = "20";
            }

            if ($yearsOfEmp >= 11 && $yearsOfEmp <= 15 && $role === 'Manager') {
                $vacationDays = "25";
            }

            if ($yearsOfEmp >= 16 && $role === 'Manager') {
                $vacationDays = "30";
            }

            //vacation days for non managerial
            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5 && $role !== 'Manager') {
                $vacationDays = "10";
            }

            if ($yearsOfEmp >= 6 && $yearsOfEmp <= 10 && $role !== 'Manager') {
                $vacationDays = "15";
            }

            if ($yearsOfEmp >= 11 && $role !== 'Manager') {
                $vacationDays = "20";
            }


            //sick days 
            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5) {
                $sickDays = "10";
            }

            if ($yearsOfEmp >= 6) {
                $sickDays = "15";
            }

            //study days

            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 3) {
                $studyDays = "5";
            }

            if ($yearsOfEmp >= 5) {
                $studyDays = "10";
            }

            //Maternity days

            if ($empsex == "F") {
                $maternityDays = "60";
            }


            $juryDutyDays = "3";

            $bereavementDays = "3";
        } else {
            
            //update oustanding leave by one if employee has carry over leave for that year
            if($outstandingleave === '3'){
            $outstandingleave = $outstandingleave;
            } else{
                $outstandingleave += 1;
            }
            //update Outstanding Leave
            $vacationOutstanding += $vacationDaysRemain;

            //begin calculation of leave days---------------------------------------------------------------------------------------------------------------
            $yearsOfEmp = $yearsOfService; //years the employee has been employed
            //vacation days for managers

            if ($yearsOfEmp >= '0' && $yearsOfEmp <= '5' && $role === 'Manager') {
                $vacationDays = "15";// + $vacationDaysRemain;
            }

            if ($yearsOfEmp >= '6' && $yearsOfEmp <= '10' && $role === 'Manager') {
                $vacationDays = "20";// + $vacationDaysRemain;
            }

            if ($yearsOfEmp >= 11 && $yearsOfEmp <= 15 && $role === 'Manager') {
                $vacationDays = "25";// + $vacationDaysRemain;
            }

            if ($yearsOfEmp >= 16 && $role === 'Manager') {
                $vacationDays = "30";// + $vacationDaysRemain;
            }

            //vacation days for non managerial
            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5 && $role !== 'Manager') {
                $vacationDays = "10";// + $vacationDaysRemain;
            }

            if ($yearsOfEmp >= 6 && $yearsOfEmp <= 10 && $role !== 'Manager') {
                $vacationDays = "15";// + $vacationDaysRemain;
            }

            if ($yearsOfEmp >= 11 && $role !== 'Manager') {
                $vacationDays = "20";// + $vacationDaysRemain;
            }


            //sick days 
            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 5) {
                $sickDays = "10";
            }

            if ($yearsOfEmp >= 6) {
                $sickDays = "15";
            }

            //study days

            if ($yearsOfEmp >= 0 && $yearsOfEmp <= 3) {
                $studyDays = "5";
            }

            if ($yearsOfEmp >= 5) {
                $studyDays = "10";
            }

            //Maternity days

            if ($empsex == "F") {
                $maternityDays = "60";
            }


            $juryDutyDays = "3";

            $bereavementDays = "3";
            //end calculation of leave days-----------------------------------------------------------------------------------------------------------------
        //
        }
        //update the employee years of service
        $sql_update = "update Leaves set YearsOfEmployment = '$yearsOfService' where EmpEmail = '$empemail'";
        mysqli_query($conn, $sql_update); //execute
        //update the different leave types and carry over leave from vacation
        $leave = "update HR_DEPT.Leaves set Vacation = '$vacationDays', VacationOutstanding = '$vacationOutstanding',Sick = '$sickDays',Maternity = '$maternityDays',Study='$studyDays',Bereavement='$bereavementDays',"
                . "JuryDuty='$juryDutyDays' where EmpEmail = '$empemail'";
        mysqli_query($conn, $leave); //execute
        //update oustanding leave column by one if employee has carry over leave for that year
        $sql_update = "update HR_DEPT.Leaves set OutstandingLeave_Years = '$outstandingleave' where EmpEmail = '$empemail'";
        mysqli_query($conn, $sql_update);
    }
}
?>

