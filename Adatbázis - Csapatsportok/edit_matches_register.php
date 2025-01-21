
<?php
if(isset($_POST['submit']))
{   
    $winner = $_POST['winner'];
    $location = $_POST['location'];
    $team1_id = $_POST['team1_id'];
    $team2_id = $_POST['team2_id'];
    $match_id = $_POST['match_id'];
    $date = $_POST['date'];
    $errors = array();
           
           if (empty($winner) OR empty($location) OR empty($team1_id) OR empty($team2_id) OR empty($match_id) OR empty($date)) {
            array_push($errors,"Minden mezőt ki kell tölteni!");
           }
           if (strlen($location)<3) {
            array_push($errors,"Nincs ilyen városnév!");
           }
           if (strlen($team1_id)<4) {
            array_push($errors,"Csapatnév nem elég hosszú!");
           }
           if (strlen($team2_id)<4) {
            array_push($errors,"Csapatnév nem elég hosszú!");
           }
           if (strlen($match_id)<1) {
            array_push($errors,"Nem kezdődhet 0-val a mérkőzésszám!");
           }
           require_once "db.php";
           $sql = "SELECT * FROM mérkőzések WHERE mérkőzésszám = '$match_id' ";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }
           else{
    $query ="UPDATE mérkőzések SET Eredmény = '$winner', Helyszín = '$location', Csapat_1_id = '$team1_id', Csapat_2_id = '$team2_id', Dátum = '$date' WHERE mérkőzésszám = '$match_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Sikeres módosítás!";
        header("Location:matches_show.php");
    }
    else
    {
        $_SESSION['status'] = "Sikertelen módosítás!";
        header("Location:matches_show.php");
    }
}
}
?>