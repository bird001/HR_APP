<?php 
include("../Login/session.php");
include("../db/db3.php");



$email=$_SESSION['login_user'];

$result=mysqli_query($conn,"select * from Users where EmpEmail = '$email' ");

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$fname = $row['FirstName'];
$lname = $row["LastName"];
$empid = $row["EmpID"];
$empmail = $row["EmpEmail"];
$empstatus = $row["EmpStatus"];
$empaddress = $row["EmpAddress"];

?>

<?php include("../Templates/header.php"); ?>
<?php include("../Templates/navigation.php"); ?>
<?php include("../Templates/body.php"); ?>
<table width="398" border="0" align="left" cellpadding="0">
  <tr>
    <td height="26" colspan="2">Your Information</td>
	<!--<td><div align="right"><a href="index.php">logout</a></div></td>-->
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">FirstName:</div></td>
    <td width="165" valign="top"><?php echo $fname ?></td>
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">LastName:</div></td>
    <td width="165" valign="top"><?php echo $lname ?></td>
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">Employee ID:</div></td>
    <td width="165" valign="top"><?php echo $empid ?></td>
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">Email:</div></td>
    <td width="165" valign="top"><?php echo $empmail ?></td>
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">Status:</div></td>
    <td width="165" valign="top"><?php echo $empstatus ?></td>
  </tr>
  
  <tr>
    <td width="82" valign="top"><div align="left">Address:</div></td>
    <td width="165" valign="top"><?php echo $empaddress ?></td>
  </tr>
</table>

<?php include("../Templates/footer.php"); ?> 