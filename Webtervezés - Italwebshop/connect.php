<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "de-doublerik";


$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Valami miatt nem tud csatlakozni az adatbázishoz!");
}

?>