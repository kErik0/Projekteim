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
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $username = $_POST["username"];
           $password = $_POST["password"];
            require_once "db.php";
            $sql = "SELECT * FROM felhasználó WHERE felhasználónév = '$username'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["Jelszó"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php?login=success");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>A jelszó nem megfelelő!</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>Felhasználónév nem megfelelő!</div>";
            }
        }
        ?>
        <?php
            if (isset($_GET["logout"]) && $_GET["logout"] == "success") {
                echo "<div class='alert alert-success'>Sikeresen kijelentkeztél!</div>";
            }
        ?>
      <form action="login.php" method="post">
        <div class="form-group">
            <input type="text" placeholder="Felhasználónév" name="username" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Jelszó" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Bejelentkezés" name="login" class="btn btn-warning">
        </div>
      </form>
     <div><p>Még nem regisztrált? <a href="register.php">Regisztráció</a></p></div>
    </div>
</body>
</html>