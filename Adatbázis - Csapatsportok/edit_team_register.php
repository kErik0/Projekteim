<?php
session_start();

if(isset($_POST['submit']))
{
    $teamid = $_POST['teamid'];
    $teamname = $_POST['teamname'];
    $teamcity = $_POST['teamcity'];
    $teamdate = $_POST['teamdate'];
    $errors = array();
           
           if (empty($teamname) OR empty($teamcity) OR empty($teamdate)) {
            array_push($errors,"Minden mezőt ki kell tölteni!");
           }
           if (strlen($teamname)<4) {
            array_push($errors,"Csapatnév nem elég hosszú!");
           }
           if (strlen($teamcity)<3) {
            array_push($errors,"Nincs ilyen város!");
           }
        
           require_once "db.php";
           $sql = "SELECT * FROM csapat WHERE csapatnév = '$teamname'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"A csapat név már foglalt!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }
           else{
    $query = "UPDATE csapat SET Csapatnév='$teamname', Város='$teamcity', Év='$teamdate' WHERE Csapatszám='$teamid' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Sikeres módosítás!";
        header("Location: index.php");
    }
    else
    {
        $_SESSION['status'] = "Sikertelen módosítás!";
        header("Location: index.php");
    }
    }
}

?>