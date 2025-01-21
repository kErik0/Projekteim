<?php
session_start();

global $conn;
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['desire_save'])) {
    if (!empty($_POST['drink_name']) && !empty($_POST['drink_price'])) {
        $name = $_POST['drink_name'];
        $amount = $_POST['drink_amount'];
        $price = $_POST['drink_price'];
        $sql = "INSERT INTO ital_ohaj (nev, kiszereles, ar) VALUES ('$name', '$amount', '$price')";
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('A kérelem sikeresen hozzáadva az adatbázishoz!')</script>";
        } else {
            echo "<script> alert('A kérelmet nem sikerült hozzáadni az adatbázishoz!')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>DE-DoublErik</title>
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

<div class="profile_edit" style="height: 420px;">
    <div class="personal-details">
        <h2 style="text-align: center">Új ital óhaj</h2>
        <form method="post" action="new_drink.php">
            <input type="text" name="drink_name" placeholder="Ital neve">
            <input type="text" name="drink_amount" placeholder="Mekkora literűt?">
            <input type="text" name="drink_price" placeholder="Ár"><br>
            <button type="submit" class="b_basket" style="margin-top: 10px;" name="desire_save">Mentés</button>
        </form>
        <form method="GET" action="admin.php">
            <button class="b_basket" style="margin-top: 15px">Mégsem</button>
        </form>
    </div>
</div>

<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>
