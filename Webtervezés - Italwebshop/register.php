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
        .menu {
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
    <?php if (isset($_SESSION['user'])): ?>
        <a href="profile.php" id="profile"><span class="menu-text">Profil</span></a>
    <?php endif; ?>
    <?php if (isset($_SESSION['admin'])): ?>
        <a href="admin.php" id="admin"><span class="menu-text">Admin</span></a>
    <?php endif; ?>

    <ul class="pages">
        <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
            <li class="menuitem"><a href="logout.php">Kijelentkezés</a></li>
        <?php else: ?>
            <li class="menuitem"><a href="login.php">Bejelentkezés</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php
if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $zipcode = $_POST["zipcode"];
    $cityname = $_POST["cityname"];
    $streetname = $_POST["streetname"];
    $housenumber = $_POST["housenumber"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if (empty($fullName) or empty($username) or empty($password) or empty($passwordRepeat) or empty($email) or empty($phone)
        or empty($zipcode) or empty($cityname) or empty($streetname) or empty($housenumber)) {
        array_push($errors, "Minden mezőt ki kell tölteni!");
    }
    if (strlen($username) < 4) {
        array_push($errors, "A felhasználónév nem elég hosszú!");
    }
    if (strlen($phone) < 11) {
        array_push($errors, "A telefonszám nem megfelelő!");
    }
    if (strlen($password) < 8) {
        array_push($errors, "A jelszó nem lehet rövidebb 8 karakternél!");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "A két jelszó nem egyezik!");
    }
    if ($zipcode <= 4) {
        array_push($errors, "Irányítószám nem megfelelő!");
    }
    if ($cityname <= 2) {
        array_push($errors, "Nem létezik ilyen város!");
    }
    if ($streetname <= 2) {
        array_push($errors, "Az utca nem található!");
    }
    if ($housenumber <= 1) {
        array_push($errors, "A házszám nem található!");
    }
    require_once "connect.php";
    global $conn;
    $sql = "SELECT * FROM felhasznalo WHERE felhasznalonev = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        $userExists = false;
        $emailExists = false;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['felhasznalonev'] == $username) {
                $userExists = true;
            }
            if ($row['email'] == $email) {
                $emailExists = true;
            }
        }
        if ($userExists && $emailExists) {
            echo "<script>alert('A felhasználónév és az email már foglalt!');window.location.href='register.php';</script>";
        } elseif ($userExists) {
            echo "<script>alert('A felhasználónév már foglalt!');window.location.href='register.php';</script>";
        } elseif ($emailExists) {
            echo "<script>alert('Az emailcím már foglalt!');window.location.href='register.php';</script>";
        }
        // Kilépés a scriptből
        exit();
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<script> alert('$error')</script>";
        }
    } else {
        $sql = "INSERT INTO felhasznalo (felhasznalonev, nev, email, telefonszam, jelszo, iranyitoszam, varos, utca, hazszam) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $username, $fullName, $email, $phone, $passwordHash, $zipcode, $cityname, $streetname, $housenumber);
            mysqli_stmt_execute($stmt);
            echo "<script> alert('Sikeres regisztráció!')</script>";
        } else {
            die();
        }
    }


}
?>
<div class="register-panel">
    <h2>Regisztráció</h2>
    <h3 style="text-align: center">Személyes adatok</h3>
    <form action="register.php" method="post" class="register-form">
        <input type="text" name="fullname" placeholder="Teljes név" required>
        <input type="text" name="username" placeholder="Felhasználónév" required>
        <input type="email" name="email" placeholder="Email cím" required>
        <input type="password" name="password" placeholder="Jelszó" required>
        <input type="password" name="repeat_password" placeholder="Jelszó ismét" required>
        <input type="tel" name="phone" placeholder="Telefonszám" pattern="[0-9]{9,12}" required><br>

        <h3 style="text-align: center">Szállítási adatok</h3>
        <input type="text" name="zipcode" placeholder="Irányítószám" required>
        <input type="text" name="cityname" placeholder="Város" required>
        <input type="text" name="streetname" placeholder="Utca név" required>
        <input type="text" name="housenumber" placeholder="Házszám" required>
        <button type="submit" class="b_register" name="submit">Regisztráció</button>
        <p class="message">Már regisztrált? <a href="login.php">Bejelentkezés</a></p>
    </form>
</div>
<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>