
<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $username = $_POST["username"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($username) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"Minden mezőt ki kell tölteni!");
           }
           if (strlen($username)<4) {
            array_push($errors, "A felhasználónév nem elég hosszú!");
           }
           if (strlen($password)<8) {
            array_push($errors,"A jelszó nem lehet rövidebb 8 karakternél!");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"A két jelszó nem egyezik!");
           }
           require_once "db.php";
           $sql = "SELECT * FROM felhasználó WHERE felhasználónév = '$username'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"A felhasználónév már foglalt!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO felhasználó (név, felhasználónév, jelszó) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $username, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Sikeresen regisztráltál!</div>";
            }else{
                die("Sikertelen regisztráció!");
            }
           }
          

        }
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Teljes név">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Felhasználónév">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Jelszó">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Jelszó ismét">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-warning" value="Regisztráció" name="submit">
            </div>
        </form>
        <div>
        <div><p>Már van fiókod? <a href="login.php">Bejelentkezés</a></p></div>
      </div>
    </div>
</body>
</html>