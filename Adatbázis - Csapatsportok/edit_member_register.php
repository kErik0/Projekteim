
<?php
if(isset($_POST['submit']))
{   
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $position = $_POST['position'];
    $personnumber = $_POST['personnumber'];
    $birthday = $_POST['birthday'];
    $errors = array();
           
           if (empty($name) OR empty($nationality) OR empty($position) OR empty($personnumber) OR empty($birthday)) {
            array_push($errors,"Minden mezőt ki kell tölteni!");
           }
           if (strlen($personnumber)<1) {
            array_push($errors,"Személyiszám nem elég hosszú!");
           }
           if (strlen($nationality)<4) {
            array_push($errors,"Nincs ilyen állampolgárság!");
           }
           if (strlen($position)<4) {
            array_push($errors,"Nincs pozíció!");
           }
           if (strlen($name)<4) {
            array_push($errors,"Nem létezik ilyen név!");
           }
           require_once "db.php";
           $sql = "SELECT * FROM tagok WHERE név = '$name' ";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"A mezszám már foglalt!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }
           else{
    $query = "UPDATE tagok SET Név='$name',  Születésidátum='$birthday', Állampolgárság='$nationality', Poszt='$position' WHERE személyiszám='$personnumber' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Sikeresen módosította a tag adatait!";
        header("Location:member_show.php");
    }
    else
    {
        $_SESSION['status'] = "Sikertelenül módosította a tag adatait!";
        header("Location:member_show.php");
    }
}
}
?>