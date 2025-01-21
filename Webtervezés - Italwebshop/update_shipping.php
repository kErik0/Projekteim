<?php
session_start();

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
    <a href="profile.php" id="profile"><span class="menu-text">Profil</span></a>

    <ul class="pages">
        <?php if (isset($_SESSION['user'])): ?>
            <li class="menuitem"><a href="logout.php">Kijelentkezés</a></li>
        <?php else: ?>
            <li class="menuitem"><a href="login.php">Bejelentkezés</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="profile_edit" style="height: 500px;">
    <div class="personal-details">
        <h2 style="text-align: center">Szállítási adatok</h2>
        <?php
        include_once('connect.php');

        global $conn;
        $username = $_SESSION['user'];
        $sql = "SELECT iranyitoszam, varos, utca, hazszam FROM felhasznalo WHERE felhasznalonev = '$username'";
        $result = mysqli_query($conn, $sql);
        ?>
        <form method="post" action="update_shipping.php">
            <?php if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<label for="zipcode">Irányítószám:</label>';
                    echo '<input type="text" id="zipcode" name="zipcode" value="' . $row['iranyitoszam'] . '"><br>';
                    echo '<label for="cityname">Város:</label>';
                    echo '<input type="text" id="cityname" name="cityname" value="' . $row['varos'] . '"><br>';
                    echo '<label for="streetname">Utca:</label>';
                    echo '<input type="text" id="streetname" name="streetname" value="' . $row['utca'] . '"><br>';
                    echo '<label for="housenumber">Házszám:</label>';
                    echo '<input type="text" id="housenumber" name="housenumber" value="' . $row['hazszam'] . '"><br>';
                }
            }
            ?>
            <button type="submit" class="b_basket" id="save">Mentés</button>
        </form>
        <form method="GET" action="profile.php">
            <button class="b_basket" style="margin-top: 15px">Mégsem</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $zipcode = $_POST['zipcode'];
            $cityname = $_POST['cityname'];
            $streetname = $_POST['streetname'];
            $housenumber = $_POST['housenumber'];

            $sql = "UPDATE felhasznalo SET iranyitoszam='$zipcode', varos='$cityname', utca='$streetname', hazszam='$housenumber' WHERE felhasznalonev='$username'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['update_success'] = true;
            header("Location: profile.php");
            exit();
        } else {
            echo "<script> alert('Sikertelen módosítás!')</script>";
        }
        }
        ?>
    </div>
</div>

<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>
