<?php

include('../db/db3.php');
include('../db/db2.php');
include("../Login/session.php");
include('../Pdf/fpdf.php');

class HeaderFooter extends FPDF {

    function Header() {
        $this->Image('/var/www/HR_APP/images/tipheader.jpg', 10, 6, 190);
        //set font 
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        //$this->Cell(30, 100, 'Title', 1, 0, 'C');
        // Line break
        $this->Ln(80);
    }

    function Footer() {
        $this->Image('/var/www/HR_APP/images/tipfooter.jpg', 10, 240, 190);
    }

}

class HeaderLoan extends FPDF {

    function Header() {
        $this->Image('/var/www/HR_APP/images/loan.jpg', 10, 6, 150);
        //set font 
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        //$this->Cell(30, 100, 'Title', 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }

}

function FirstLetter($fname, $lname, $empid) {

    $firstLetter = "Promptness is important in the day-to-day operation of our department."
            . "  While we make allowances for occasional lateness, consistent lateness cannot be tolerated."
            . "Should there be extenuating circumstances, please come and speak with me.  If there is a problem"
            . ", perhaps we can work it out together. \n\n\n\n"
            . "Please sign here ______________________________________";

    //generate Pdf 
    $pdf = new HeaderFooter();
    $pdf->AddPage();
    $pdf->SetTitle("Tardiness Letter 1_" . "$fname" . "_" . "$lname" . "_" . "$empid");

    $pdf->SetFont("Arial", "B", "20");
    $pdf->Cell(0, 10, "Tardiness Letter 1.", 1, 1, "C");

    $pdf->SetFont("Arial", "", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "Name: " . $fname . " " . $lname);
    $pdf->write(5, "\n");
    $pdf->write(5, "Employee ID: " . $empid);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Dear Mr/Ms $lname");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $firstLetter);

    //used to display the letter[if needed]
    //$pdf->Output('I', $fname . "_" . $lname . "_" . $empid . ".pdf");
    //save pdf to folder
    $pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/First/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    //return to original web page
    header("Location: disciplinaryletters");
}

function SecondLetter($fname, $lname, $empid) {

    $secondLetter = "Promptness is important in the day-to-day operation of our department.  "
            . "While we make allowances for occasional lateness, consistent lateness cannot be tolerated."
            . "This is your second warning in a one year time period.  If this happens again, it will be grounds for suspension."
            . "Should there be extenuating circumstances, please come and speak with me.  If there is a problem,"
            . " perhaps we can work it out together \n\n\n\n"
            . "Please sign here ______________________________________";

    $pdf = new HeaderFooter();
    $pdf->AddPage();
    $pdf->SetTitle("Tardiness Letter 2_" . "$fname" . "_" . "$lname" . "_" . "$empid");

    $pdf->SetFont("Arial", "B", "20");
    $pdf->Cell(0, 10, "Tardiness Letter. 2.", 1, 1, "C");

    $pdf->SetFont("Arial", "", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "Name: " . $fname . " " . $lname);
    $pdf->write(5, "\n");
    $pdf->write(5, "Employee ID: " . $empid);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Dear Mr/Ms $lname");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $secondLetter);

    //$pdf->Output('I', $fname . "_" . $lname . "_" . $empid . ".pdf");
    $pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Second/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    header("Location:../Letters/generateDLetter.php");
}

function SuspensionLetter($fname, $lname, $empid) {

    $suspensionLetter = "This letter serves as a notice of suspension in the matter of your attendance and to set out,"
            . " once again, the procedures and guidelines for your continued employment with TIPFS."
            . "Earlier this Year,you were given an initial written warning about your poor attendance record."
            . " Following that warning, your attendance was monitored and when it was found that there was still "
            . "no improvement; you were given a second written warning."
            . "Since the second warning was issued, there have been seven instances in which you were either absent from work or you were late."
            . " We therefore have no alternative but to inform you that you are now placed on a 5 day suspension without pay effective immediately"
            . "We must also warn you that any further absences from work may lead to termination of your employment with TIPFS."
            . " We hope that you understand the seriousness of this matter and will take the necessary steps to improve your attendance record."
            . " While We do not want to terminate your employment, it is vital that you understand how important it is that you are present at work"
            . " when expected to and willing to do your job. \n\n\n\n"
            . "Please sign here ______________________________________";

    $pdf = new HeaderFooter();
    $pdf->AddPage();
    $pdf->SetTitle("Suspension Letter_" . "$fname" . "_" . "$lname" . "_" . "$empid");

    $pdf->SetFont("Arial", "B", "20");
    $pdf->Cell(0, 10, "Suspension Letter. Tardiness.", 1, 1, "C");

    $pdf->SetFont("Arial", "", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "Name: " . $fname . " " . $lname);
    $pdf->write(5, "\n");
    $pdf->write(5, "Employee ID: " . $empid);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Dear Mr/Ms $lname");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $suspensionLetter);

    //$pdf->Output('I', $fname . "_" . $lname . "_" . $empid . ".pdf");
    $pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Suspension/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    header("Location:../Letters/generateDLetter.php");
}

function DismisalLetter($fname, $lname, $empid) {
    $dismisalLetter = "This is official notice that you are dismissed from employment effective immediately."
            . "You have been late for work on several occasions, despite attempts to correct this behavior through two written reprimand, and suspension without pay."
            . " You have failed to notify the department on occasions when you knew you would be reporting to work late, and you have failed to provide any compelling"
            . " reasons for your continued lateness. This behavior is contrary to departmental policy and has created work delays and morale problems within your work group."
            . "On or before your last day of employment, you must complete the clearance process and return any  property in your possession."
            . " This process begins in the Human Resources Department, and a HR representative will also advise you about your options to continue"
            . " insurance coverage and apply for refund to your retirement fund contributions. \n\n\n\n"
            . "Please sign here _______________________________________";

    $pdf = new HeaderFooter();
    $pdf->AddPage();
    $pdf->SetTitle("Dismisal Letter_" . "$fname" . "_" . "$lname" . "_" . "$empid");

    $pdf->SetFont("Arial", "B", "20");
    $pdf->Cell(0, 10, "Dismisal Letter. Tardiness.", 1, 1, "C");

    $pdf->SetFont("Arial", "", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "Name: " . $fname . " " . $lname);
    $pdf->write(5, "\n");
    $pdf->write(5, "Employee ID: " . $empid);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Dear Mr/Ms $lname");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $dismisalLetter);

    //$pdf->Output('I', $fname . "_" . $lname . "_" . $empid . ".pdf");
    $pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    header("Location:../Letters/generateDLetter.php");
}

function JobLetter($nametitle, $companyname, $companyadd, $manname, $manpos, $empname, $emppos, $empstart, $empsex, $date) {



    if ($empsex == 'M') {
        $title = "Mr. ";
        $ref = "him ";
    } else {
        $title = "Ms. ";
        $ref = "her ";
    }
    $pdf = new HeaderFooter();
    $pdf->AddPage();
    //letter body
    $pdf->SetFont("Times", "BI", "12");
    //date of letter
    $pdf->write(5, $date . "\n");
    //address of place
    $pdf->write(5, "\n");
    $pdf->write(5, $nametitle);
    $pdf->write(5, "\n");
    $pdf->write(5, $companyname);
    $pdf->write(5, "\n");
    $pdf->write(5, $companyadd);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    //contents
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->write(5, "Re: " . $empname);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    //body
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "This is to certify that ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $title . $empname);
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, " has been employed to");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, " The TIP Friendly Society ");
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "since ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $empstart);
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, " in the capacity of ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $emppos . ".");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "TO-DO: Salary to be included when payroll module is finished.");
    $pdf->write(5, "\n");
    $pdf->write(5, "We have found " . $ref . "to be hardworking, loyal and ambitious. We therefore have no reservation in recommending " . $ref . " to your organization.");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Should you need additional information, please feel free to contact us at the numbers listed above.");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Yours truly,");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Tip Friendly Society");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $manname);
    $pdf->write(5, "\n");
    $pdf->write(5, $manpos);


    $pdf->Output('I', $name . " " . "Job Letter" . ".pdf"); //output letter to browser for printing or downloading
    //
    //$pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    //header("Location:../Letters/generateDLetter.php");
}

function RecomLetter($nametitle, $companyname, $companyadd, $manname, $manpos, $empname, $emppos, $empstart, $empsex, $date) {



    if ($empsex == 'M') {
        $title = "Mr. ";
        $ref = "him ";
    } else {
        $title = "Ms. ";
        $ref = "her ";
    }
    $pdf = new HeaderFooter();
    $pdf->AddPage();
    //letter body
    $pdf->SetFont("Times", "BI", "12");
    //date of letter
    $pdf->write(5, $date . "\n");
    //address of place
    $pdf->write(5, "\n");
    $pdf->write(5, $nametitle);
    $pdf->write(5, "\n");
    $pdf->write(5, $companyname);
    $pdf->write(5, "\n");
    $pdf->write(5, $companyadd);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    //contents
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->write(5, "Re: " . $empname);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    //body
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "This is to certify that ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $title . $empname);
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, " has been employed at");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, " The TIP Friendly Society ");
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "from ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $empstart);
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, " in the capacity of ");
    $pdf->SetFont("Times", "B", "12");
    $pdf->write(5, $emppos . ".");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "We have found " . $ref . "to be hardworking, loyal and ambitious. We therefore have no reservation in recommending " . $ref . " to your organization.");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Should you need additional information, please feel free to contact us at the numbers listed above.");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Yours truly,");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Tip Friendly Society");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, $manname);
    $pdf->write(5, "\n");
    $pdf->write(5, $manpos);


    $pdf->Output('I', $name . " " . "Recommendation Letter" . ".pdf");
    //$pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    //header("Location:../Letters/generateDLetter.php");
}

function TravelSubsistence($name, $dept, $from, $to, $dest, $origin, $purpose, $date, $totalkm, $sub) {




    $pdf = new HeaderFooter();
    $pdf->AddPage();
    //letter body
    $pdf->SetFont("Times", "BI", "12");
    //date applied for
    $pdf->write(5, "Date(s) Aplied for:   ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $from . "  to  " . $to . "\n");
    //address of place
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Claimant's Name:    ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $name);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Department:             ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $dept);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Nature of Work:      ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $purpose);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Claimant's Signature:    ________________");
    $pdf->write(5, "                                            ");
    $pdf->write(5, "Date:   " . $date . "\n");
    $pdf->line(10, 150, 210 - 10, 150); // 10mm from each edge
    $pdf->line(10, 151, 210 - 10, 151); // 10mm from each edge
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Origin:           ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $origin);
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Destination:        ");
    $pdf->SetFont("Times", "U", "12");
    $pdf->write(5, $dest);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Travelling Cost: ");
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->write(5, "\$ " . $totalkm);
    $pdf->write(5, "   ");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Meal Cost: \$____________");
    $pdf->write(5, "   ");
    $pdf->write(5, "Subsistence: ");
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->write(5, "\$ " . $sub);
    $pdf->SetFont("Times", "BI", "12");
    $pdf->line(10, 190, 210 - 10, 190); // 20mm from each edge
    $pdf->line(10, 191, 210 - 10, 191); // 20mm from each edge
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Supervisor's Name: ____________________");
    $pdf->write(5, "                   ");
    $pdf->write(5, "Manager's Name: ____________________");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Supervisor's Signature: ____________________");
    $pdf->write(5, "                   ");
    $pdf->write(5, "Manager's Signature: ____________________");
    $pdf->Output('I', $name . " " . "TravelSubsistence" . ".pdf");
    //$pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    //header("Location:../Letters/generateDLetter.php");
}

function MealTravel($name, $dept, $date, $date2, $dest, $purpose, $meal) {




    $pdf = new HeaderFooter();
    $pdf->AddPage();
    //letter body
    $pdf->SetFont("Times", "BI", "12");
    //date applied for
    $pdf->write(5, "Date Aplied for:   ");
    $pdf->write(5, $date. "\n");
    //address of place
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Claimant's Name:    ");
    $pdf->write(5, $name);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Department:             ");
    $pdf->write(5, $dept);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Nature of Work:      ");
    $pdf->write(5, $purpose);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Claimant's Signature: ".$name);
    $pdf->write(5, "                                            ");
    $pdf->write(5, "Date:   " . $date2 . "\n");
    $pdf->line(10, 150, 210 - 10, 150); // 10mm from each edge
    $pdf->line(10, 151, 210 - 10, 151); // 10mm from each edge
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Destination:        ");
    $pdf->write(5, $dest);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Meal Cost: \$" . $meal);
    $pdf->write(5, "         ");
    $pdf->write(5, "Travel Cost: \$" ."___________");
    $pdf->write(5, "   ");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->line(10, 190, 210 - 10, 190); // 20mm from each edge
    $pdf->line(10, 191, 210 - 10, 191); // 20mm from each edge
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Supervisor's Name: ____________________");
    $pdf->write(5, "                   ");
    $pdf->write(5, "Manager's Name: ____________________");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "Supervisor's Signature: ____________________");
    $pdf->write(5, "                   ");
    $pdf->write(5, "Manager's Signature: ____________________");
    $pdf->Output('I', $name . " " . "MealTravel" . ".pdf");
    //$pdf->Output('F', "/var/www/HR_APP/Pdf/pdf_docs/Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf");
    //header("Location:../Letters/generateDLetter.php");
}

function LoanAppAccounts($array, $empname, $empid, $empdept, $empadd, $empnum, $loantype, $amount, $purpose, $monthlyrepayment, $term, $interest, $dateA, $refname1, $refadd1, $refnum1, $refname2, $refadd2, $refnum2, $approved, $approveddate, $vetted, $vetteddate) {


    $pdf = new HeaderLoan();
    $pdf->AddPage();
    //letter body
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->Cell($w, $h, $dateA, $border, $ln, R);
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "Name: " . $empname);
    $pdf->write(5, "\n");
    $pdf->write(5, "ID: " . $empid);
    $pdf->write(5, "\n");
    $pdf->write(5, "Department: " . $empdept);
    $pdf->write(5, "\n");
    $pdf->write(5, "Home Address: " . $empadd);
    $pdf->write(5, "\n");
    $pdf->write(5, "Contact Number: " . $empnum);
    $pdf->write(5, "\n");
    $pdf->write(5, "Loan Type: " . $loantype);
    $pdf->write(5, "\n");
    $pdf->write(5, "Amount Requested: $" . $amount);
    $pdf->write(5, "\n");
    $pdf->write(5, "Purpose: " . $purpose);
    $pdf->write(5, "\n");
    $pdf->write(5, "Monthly Repayment: $" . $monthlyrepayment . "/Month");
    $pdf->write(5, "                   ");
    $pdf->write(5, "Repayment Period: " . $term . " Months");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");

    $pdf->SetFont("Times", "BI", "12");

    $pdf->Cell($w, $h, "__________________________________________________________________________________________", $border, $ln);
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->Cell($w, $h, "References", $border, $ln, C);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");
    $pdf->write(5, "(1)");
    $pdf->write(5, "    Name: " . $refname1);
    $pdf->write(5, "\n");
    $pdf->write(5, "        Address: " . $refadd1);
    $pdf->write(5, "\n");
    $pdf->write(5, "        Contact Number: " . $refnum1);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "(2)");
    $pdf->write(5, "    Name: " . $refname2);
    $pdf->write(5, "\n");
    $pdf->write(5, "        Address: " . $refadd2);
    $pdf->write(5, "\n");
    $pdf->write(5, "        Contact Number: " . $refnum2);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");

    $pdf->SetFont("Times", "BI", "12");
    $pdf->Cell($w, $h, "__________________________________________________________________________________________", $border, $ln);
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BIU", "12");
    $pdf->Cell($w, $h, "Previous Loan Balances", $border, $ln, C);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->Cell(5, $h, "Loan Type", $border, $ln, L);


    $pdf->Cell(180, $h, "Loan Amount", $border, $ln, C);

    $pdf->SetFont("Times", "BIU", "12");
    $pdf->Cell($w, $h, "Repayment Amount", $border, $ln, R);
    $pdf->write(5, "\n");
    $pdf->SetFont("Times", "BI", "12");




    //$pdf->Rect(10, 85, 190, 90, D);
    foreach ($array as $row) {
        $type = $row['LoanType'];
        $loanamount = $row['Amount'];
        $repay = $row['MonthlyRepayment'];
        $dateapproved = $row['DateApproved'];
        $totalrepay += $repay;

        $pdf->Cell(5, $h, $type . " Loan", $border, $ln, L);
        $pdf->Cell(180, $h, "$" . $loanamount, $border, $ln, C);
        $pdf->Cell($w, $h, "$" . $repay, $border, $ln, R);
        $pdf->write(5, "\n");
        $pdf->write(5, "\n");
    }
    $pdf->Cell($w, $h, "Total Loan Repayment: $" . $totalrepay, $border, $ln, R);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->Cell(5, $h, "Approved By: " . $approved, $border, $ln, L);
    $pdf->Cell($w, $h, "Date: " . $approveddate, $border, $ln, R);
    $pdf->write(5, "\n");
    $pdf->Cell($w, $h, "__________________________________________________________________________________________", $border, $ln);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->write(5, "I " . $empname . " acknowledge the receipt of $" . $amount . " as a loan from TIP Friendly Society.");
    $pdf->write(5, " I will repay the principal and interest(at a rate of " . $interest . " % monthly), with a repayment amount of $" . $monthlyrepayment . " over a period of "
            . $term . " months as a settlement of the same.");
    $pdf->write(5, "In the event of termination of employment or death we will proceed according to the policy of the Society.");
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->Cell(5, $h, "Staff's Signature:_________________", $border, $ln, L);
    $pdf->Cell(180, $h, "Date:_________________", $border, $ln, C);
    $pdf->Cell($w, $h, "Witness:_________________", $border, $ln, R);
    $pdf->write(5, "\n");
    $pdf->write(5, "\n");
    $pdf->Cell(5, $h, "Approved by: " . $vetted, $border, $ln, L);
    $pdf->Cell($w, $h, "Date: " . $vetteddate, $border, $ln, R);

    //TO-DO put in the signing of the contract @ the end of the loan app form


    $pdf->Output('I', $empname . " " . $empid . "LoanApplicationForm" . ".pdf");
}
?>

