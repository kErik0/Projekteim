<?php
session_start();
require_once('db.php');

if(isset($_POST['delete_personnumber'])){
    $personnumber = $_POST['personnumber'];

    
    $query = "DELETE FROM tagok WHERE személyiszám = '$personnumber' ";
    $query_run = mysqli_query($conn, $query);
}
    if ($query_run) {
       $_SESSION['status'] = "Sikeres törlés!";
        header("Location:member_show.php");
    } else {
        $_SESSION['status'] = "Sikertelen törlés!";
        header("Location:member_show.php");
    }
?>