<?php
include("../Login/session.php");
include("../db/db3.php");
include("../Templates/header_dashboard.php");
?>
<script>
function EditNews(){
//pop up window for uploading SchoolListinngs csv files
window.open("../DashboardMod/EditNews.php", "Edit News", "location=1,status=1,scrollbars=1,width=400,height=400");
}

function DeleteNews(){
//pop up window for uploading SchoolListinngs csv files
window.open("../DashboardMod/DeleteNews.php", "Delete News", "location=1,status=1,scrollbars=1,width=400,height=400");
}
</script>
<?php
include("../Templates/navigation_dashboard.php");
include("../DashboardMod/DashNav.php");

$email = $_SESSION['login_user'];
$sql = "SELECT * FROM Users where EmpEmail = '$email' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$firstname = $row['FirstName'];
$lastname = $row['LastName'];
$empid = $row['EmpID'];
$emprole = $row['EmpRole'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['Name'];
$email = $_POST['Email'];
$headline = $_POST['Headline'];
$story = $_POST['Story'];


$addNews = "INSERT INTO DashBoard(Headline, Story, Name, Email, Time)VALUES('$headline', '$story', '$name', '$email', now())";
$result = mysqli_query($conn, $addNews);

if (!$result) {
echo('Error adding news: ' . $mysql_error());
exit();
} else {
mysql_close($link);
echo('Success!');
}
}
?>

<br>
<div align="left" class = "form-group">
    <div style="width:500px;" class = "form-group" align="left">
        <form action="#" method="post" id="form1" class = "form-group" role="form" >

            <div class="form-group">
                <label for="Name" class="control-label">Name</label>
                <input type="text" name="Name" id="Name" class="form-control" value="<?php echo $firstname . " " . $lastname; ?>" required/>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="Email" class="control-label">Email</label>
                <input type="email" name="Email" id="Email" class="form-control" value="<?php echo $email; ?>" required/>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="Headline" class="control-label">Headline</label>
                <input type="textarea" name="Headline" id="Headline" class="form-control" placeholder="Headline..." required/>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <label for="Story" class="control-label">Story</label>                
                <textarea rows="10" cols="10" style="height: 70px;" name="Story" id="Story" class="form-control" placeholder="Story...." required>
                </textarea>
                <span class="error"><?php echo $fnameError; ?></span>
            </div>

            <div class="form-group">
                <input name="hiddenField" type="hidden" value="add_n">
                <input class="btn btn-primary" name="add" type="submit" id="add" value="Submit">
            </div>
        </form>
        <?php
        if($emprole == 'Manager'){
        ?>
        <button class="btn btn-danger" onclick="EditNews();">Edit News</button>
        <button class="btn btn-danger" onclick="DeleteNews();">Delete News</button>

        <?php
        }
        ?>
    </div>
</div>

<?php include("../Templates/footer_dashboard.php"); ?>