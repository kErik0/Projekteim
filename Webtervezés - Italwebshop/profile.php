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
<?php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
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

<?php
$username = $_SESSION['user'];
global $conn;
include_once('connect.php');
$sql = "SELECT felhasznalonev, nev, email, telefonszam FROM felhasznalo WHERE felhasznalonev = '$username'";;
$result = mysqli_query($conn, $sql);
?>

<?php
include_once('connect.php');

if (isset($_FILES["prof_pic"])) {
    $allowed_extensions = ["jpg", "jpeg", "png"];
    $uploaded_file_extension = strtolower(pathinfo($_FILES["prof_pic"]["name"], PATHINFO_EXTENSION));

    if (in_array($uploaded_file_extension, $allowed_extensions)) {
        $username = $_SESSION['user'];
        $filename = $username . "." . $uploaded_file_extension;
        $target_path = "img/" . $filename;

        if ($_FILES["prof_pic"]["error"] === 0) {
            if ($_FILES["prof_pic"]["size"] <= 31457280) {
                if (move_uploaded_file($_FILES["prof_pic"]["tmp_name"], $target_path)) {
                    echo "<script> alert('Sikeres fájlfeltöltés!') </script>";
                } else {
                    echo "<script> alert('Hiba: A fájl átmozgatása nem sikerült!') </script>";
                }
            } else {
                echo "<script> alert('Hiba: A fájl mérete túl nagy!') </script>";
            }
        } else {
            echo "<script> alert('Hiba: A fájlfeltöltés nem sikerült, Formátum: [felhasznalonév].jpg!') </script>";
        }
    } else {
        echo "<script> alert('Hiba: A fájl kiterjesztése kizárólag jpg lehet!') </script>";
    }
}
?>


<div class="profile">
    <h1 style="text-align: center; padding-top: 20px;">-<?php echo $username; ?>-</h1>
    <div class="profile_img">
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label>
                <input type="file" name="prof_pic" accept="image/*">
                <?php if (!(file_exists("img/" . $username . ".jpg"))): ?>
                    <img src="img/profilkep.jpg" alt="Profilkép" title="Profilkép cseréje" style="margin-bottom: 25px;">
                    <br>
                <?php else: ?>
                    <img src="img/<?php echo $username; ?>.jpg" alt="Profilkép" title="Profilkép cseréje"
                         style="margin-bottom: 25px;"><br>
                <?php endif; ?>
            </label>
            <button type="submit" class="b_basket" name="prof_b">Csere</button>
        </form>
    </div>


    <div class="container">
        <div class="personal-details">
            <h2 style="text-align: center">Személyes adatok</h2>
            <form action="update_profile.php" method="GET">
                <button type="submit" class="b_basket">Módosítás</button>
            </form>
            <?php if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>Teljes név: " . $row['nev'] . "</p>";
                    echo "<p>Felhasználónév: " . $row['felhasznalonev'] . "</p>";
                    echo "<p>Email: " . $row['email'] . "</p>";
                    echo "<p>Telefonszám: " . $row['telefonszam'] . "</p>";
                }
            }
            ?>
        </div>

        <?php
        $username = $_SESSION['user'];
        global $conn;
        include_once('connect.php');
        $sql = "SELECT iranyitoszam, varos, utca, hazszam FROM felhasznalo WHERE felhasznalonev = '$username'";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="shipping-details">
            <h2 style="text-align: center">Szállítási adatok</h2>
            <form action="update_shipping.php" method="GET">
                <button type="submit" class="b_basket">Módosítás</button>
            </form>
            <?php if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>Irányítószám: " . $row['iranyitoszam'] . "</p>";
                    echo "<p>Város: " . $row['varos'] . "</p>";
                    echo "<p>Utca: " . $row['utca'] . "</p>";
                    echo "<p>Házszám: " . $row['hazszam'] . "</p>";
                }
            }
            ?>
        </div>

        <?php
        if (isset($_SESSION['update_success'])) {
            echo "<script> alert('Sikeres módosítás!')</script>";
            unset($_SESSION['update_success']);
        }
        ?>

        <div class="previous-orders">
            <h2 style="text-align: center">Korábbi rendelések</h2>
            <p>Még nem történt korábbi rendelés!</p>
        </div>
    </div>


    <form action="profile.php" method="post">
        <?php
        if (isset($_POST['delete_profile'])) {
            $username = $_SESSION['user'];
            $allowed_extensions = ["jpg", "jpeg", "png"];
            foreach ($allowed_extensions as $extension) {
                $profile_picture_path = "img/" . $username . "." . $extension;
                if (file_exists($profile_picture_path)) {
                    unlink($profile_picture_path);
                    break;
                }
            }
            $sql = "DELETE FROM felhasznalo WHERE felhasznalonev = '$username'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header('Location: prof_delete.php?delete=success');
                exit();
            } else {
                echo "<script> alert('Sikertelen törlés!')</script>";
            }
        }
        ?>
        <input type="hidden" name="delete_profile" value="<?= $row['felhasznalonev']?>">
        <button type="submit" class="b_basket" style="display: block; margin: 0 auto 20px; width: 250px;">Profil törlése</button><br>
    </form>


</div>

<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>



