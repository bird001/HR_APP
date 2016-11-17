<?php
include("../Login/session.php");
include("../db/db3.php");
include("../db/db2.php");
?>

<?php include("../Templates/header.php"); ?>
<?php include("../Templates/navigation.php"); ?>
<?php include("../Templates/body.php"); ?>
<?php include("../Letters/lettersNav.php"); ?>

<?php
$user = $login_session;

$result = mysqli_query($conn, "select * from DLetters where EmpEmail = '$user' ");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$fname = $row['EmpFName'];
$lname = $row['EmpLName'];
$empid = $row['EmpID'];

$filepath = "../Pdf/pdf_docs/";

//if first discipline letter exists
if (file_exists($filepath . "First/" . $fname . "_" . $lname . "_" . $empid . ".pdf")) {
    $compfilepath1 = $filepath . "First/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
    $display1 = "float:left";
} else {
    $compfilepath1 = " ";
    $display1 = "display:none";
}

//if second disciplinary letter exists
if (file_exists($filepath . "Second/" . $fname . "_" . $lname . "_" . $empid . ".pdf")) {
    $compfilepath2 = $filepath . "Second/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
    $display2 = "float:left";
} else {
    $compfilepath2 = " ";
    $display2 = "display:none";
}

//if suspension disciplinary letter exists
if (file_exists($filepath . "Suspension/" . $fname . "_" . $lname . "_" . $empid . ".pdf")) {
    $compfilepath3 = $filepath . "Suspension/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
    $display3 = "float:left";
} else {
    $compfilepath3 = " ";
    $display3 = "display:none";
}

//if dismisal disciplinary letter exists
if (file_exists($filepath . "Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf")) {
    $compfilepath4 = $filepath . "Dismisal/" . $fname . "_" . $lname . "_" . $empid . ".pdf";
    $display4 = "float:left";
} else {
    $compfilepath4 = " ";
    $display4 = "display:none";
}
?>


<div class="">
    <iframe class="" style="<?php echo $display1; ?>" src="<?php echo $compfilepath1; ?>" id="FirstDLetter" style="" width="500" height="300"></iframe>
</div>

<div class="">
    <iframe class="" style="<?php echo $display2; ?>" src="<?php echo $compfilepath2; ?>" id="FirstDLetter" style="" width="500" height="300"></iframe>
</div>

<div class="">
    <iframe class="" style="<?php echo $display3; ?>" src="<?php echo $compfilepath3; ?>" id="FirstDLetter" style="" width="500" height="300"></iframe>
</div>

<div class="">
    <iframe class="" style="<?php echo $display4; ?>" src="<?php echo $compfilepath4; ?>" id="FirstDLetter" style="" width="500" height="300"></iframe>
</div>
<?php include("../Templates/footer.php"); ?> 