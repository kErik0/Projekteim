<?php
session_start();
require_once('db.php');

if(isset($_POST['match_id'])){
    $match = $_POST['match'];

    
    $query = "DELETE FROM mérkőzések WHERE Mérkőzésszám = '$match' ";
    $query_run = mysqli_query($conn, $query);
}
    if ($query_run) {
       $_SESSION['status'] = "Sikeres törlés!";
        header("Location:matches_show.php");
    } else {
        $_SESSION['status'] = "Sikertelen törlés!";
        header("Location:matches_show.php");
    }
?>