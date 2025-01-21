<?php
session_start();

global $conn;
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['coupon_save'])) {
    if (!empty($_POST['coupon_name']) && !empty($_POST['value'])) {
        $coupon_name = $_POST['coupon_name'];
        $value = $_POST['value'];
        $sql = "INSERT INTO kuponok (kod, ertek) VALUES ('$coupon_name', '$value')";
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('A kuponkód sikeresen hozzáadva az adatbázishoz.')</script>";
        } else {
            echo "<script> alert('A kuponkódot nem sikerült hozzáadni az adatbázishoz.')</script>";
        }
    }
}

if (isset($_POST['delete_coupon'])) {
    $coupon_id = $_POST['coupon_id'];
    $sql = "DELETE FROM kuponok WHERE id = $coupon_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('A kupon sikeresen törölve.')</script>";
    } else {
        echo "<script> alert('A kupon törlése nem sikerült.')</script>";
    }
}

$sql = "SELECT * FROM kuponok";
$result = $conn->query($sql);
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
        <h2 style="text-align: center">Új kuponkód megadása</h2>
        <form method="post" action="coupon.php">
            <input type="text" name="coupon_name" placeholder="Kupon neve">
            <input type="text" name="value"  placeholder="Értéke" ><br>
            <button type="submit" class="b_basket" id="save" style="margin-top: 15px;" name="coupon_save">Mentés</button>
        </form>
        <form method="GET" action="admin.php">
            <button class="b_basket" style="margin-top: 15px">Mégsem</button>
        </form>
    </div>
</div>

<table class="t_basket" style="font-size: 20px; padding: 20px 0 0;">
        <tr>
            <th>Kupon neve</th>
            <th>Kupon értéke</th>
            <th>Műveletek</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['kod'] . "</td>";
                echo "<td>" . $row['ertek'] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='coupon_id' value='".$row['id']."'>";
                echo "<button type='submit' name='delete_coupon' class='b_basket'>Törlés</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nincsenek kuponok a táblában.</td></tr>";
        }
        ?>
    </table>

<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>
