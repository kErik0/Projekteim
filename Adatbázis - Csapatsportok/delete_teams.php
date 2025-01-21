<?php
session_start();
require_once('db.php');

if(isset($_POST['delete_id'])){
    $teamid = $_POST['teamid'];

    
    $query = "DELETE FROM csapat WHERE csapatszám = '$teamid' ";
    $query_run = mysqli_query($conn, $query);
}
    if ($query_run) {
       $_SESSION['status'] = "Sikeres törlés!";
        header("Location:index.php");
    } else {
        $_SESSION['status'] = "Sikertelen törlés!";
        header("Location:index.php");
    }
?>