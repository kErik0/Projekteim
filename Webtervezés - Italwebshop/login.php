<?php
session_start();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>DE-DoublErik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/Icon.png" type="image/x-icon">
    <style>
        .menu{
            background-image: url(img/Nav_bar.jpg);
        }
    </style>
</head>
<body>
<div class="logo_picture">
    <img src="img/Banner_2.jpg" alt="Banner">
</div>
<nav class="menu">
    <a href="index.php" id="house"><span class="menu-text">Főoldal</span></a>
    <a href="products.php" id="product"><span class="menu-text">Termékek</span></a>
    <a href="basket.php" id="basket"><span class="menu-text">Kosár</span></a>
    <?php if(isset($_SESSION['user'])): ?>
        <a href="profile.php" id="profile"><span class="menu-text">Profil</span></a>
    <?php endif; ?>
    <?php if(isset($_SESSION['admin'])): ?>
        <a href="admin.php" id="admin"><span class="menu-text">Admin</span></a>
    <?php endif; ?>

    <ul class="pages">
        <?php if(isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
            <li class="menuitem"><a href="logout.php">Kijelentkezés</a></li>
        <?php else: ?>
            <li class="menuitem"><a href="login.php">Bejelentkezés</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    global $conn;
    require_once "connect.php";
    $sql = "SELECT * FROM felhasznalo WHERE felhasznalonev = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if($username === 'admin'){
        if ($user) {
            if (password_verify($password, $user["jelszo"])) {
                session_start();
                $_SESSION["admin"] = "$username";
                header("Location: admin.php?login=success");
                die();
            }else{
                echo "<script> alert('A jelszó nem megfelelő!')</script>";
            }
        }
    }elseif($user){
        if (password_verify($password, $user["jelszo"])) {
            session_start();
            $_SESSION["user"] = "$username";
            header("Location: index.php?login=success");
            die();
        }else{
            echo "<script> alert('A jelszó nem megfelelő!')</script>";
        }
    }else{
        echo "<script> alert('A felhasználó nem létezik!')</script>";;
    }
}
?>

<div class="login-panel">
    <h2>Bejelentkezés</h2>
    <form class="login_form" action="login.php" method="post">
        <input type="text" placeholder="Felhasználónév" name="username">
        <input type="password" placeholder="Jelszó" name="password">
        <button type="submit" name="submit" class="b_login">Bejelentkezés</button>
        <p class="message">Még nem regisztrált? <a href="register.php">Regisztráció</a></p>
    </form>
</div>

<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>