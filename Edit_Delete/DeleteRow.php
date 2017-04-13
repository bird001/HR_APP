<?php
    // session_start();
    include('../db/db3.php');
    include('../Login/session.php');
        $operator = $login_session;
        $idArr = $_POST['checked_id'];
        foreach($idArr as $id){
            mysqli_query($conn,"DELETE FROM DashBoard WHERE id_val='$id' and Email = '$operator'");
        }
        $_SESSION['success_msg'] = 'News has been deleted successfully.';
        header("Location: deletenews");
    
?>