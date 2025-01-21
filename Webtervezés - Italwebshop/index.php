<?php
session_start();
if (isset($_GET["logout"]) && $_GET["logout"] == "success") {
    echo "<script> alert('Sikeresen kijelentkeztél!')</script>";
}

if (isset($_GET["delete"]) && $_GET["delete"] == "success") {
    echo "<script> alert('Sikeresen törölted a profilod!')</script>";
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

<?php
if (isset($_GET["login"]) && $_GET["login"] == "success") {
    echo "<script> alert('Sikeresen bejelentkeztél!')</script>";
}
?>

<div id="introduction">
    <p>Napjainkban az internet egyre nagyobb szerepet kap életünkben, nincs ez másként az ital vásárlás kapcsán sem.
        Az online italrendelés a külföldi piacok utána a magyar piacot is kezdi meghódítani számos előnyével.
        Online italboltunk segítségével nem kell vesződnie italai felkutatásával, beszerzésével, hazacipelésével,
        mivel boltunkban mindent egy helyen megtalál, és a megrendelt italait italkereskedésünk akár ingyenesen házhoz
        szállítja Önnek.
        Az online italrendelés nem csak gyorsabb, hanem egyszerűbb és sok esetben olcsóbb is, mint a hagyományos
        italvásárlás.
        Az internet segítségével megtalálhatja a legkedvezőbb ital árakat anélkül, hogy órákat töltene az italok utáni
        böngészéssel.
        Italkereskedésünk elkötelezett a legmagasabb minőség és a legkedvezőbb ital árak biztosítása mellett , így nem
        csak italaink minősége,
        de ital áraink is igen meggyőzőek.
        Rendeljen bátran ital kínálatunkból, próbálja ki az online ital vásárlást és élvezze előnyeit. </p>
</div>
<table id="homepage_drinks">
    <tr>
        <td class="left"><a href="products.php#beers"><img src="img/Sorok.jpg" alt="sorok"></a></td>
        <td class="middle"><a href="products.php#wines"><img src="img/Borok.jpg" alt="borok"></a></td>
        <td class="right"><a href="products.php#shots"><img src="img/Tomenyek.jpg" alt="Tomenyek"></a></td>
    </tr>
</table>
<div id="info">
    <h2>Miért válasszon minket kereskedőként?</h2>
    <ul>
        <li>A legújabb, legtrendibb, legjobban fogyó, ezáltal legaktuálisabb választékkal rendelkezünk</li>
        <li>Szuper árakat, vonzó akciókat és mennyiségi kedvezményeket kínálunk</li>
        <li>Hatalmas raktárkészlettel rendelkezünk, így sokszor a gyártói hiányos termékek nálunk még sokáig elérhetők
        </li>
        <li>Gyors, pontos és szakszerű a kiszolgálás</li>
        <li>Számos fizetési lehetőséget kínálunk, hogy mindenki megtalálja a számára legmegfelelőbbet</li>
        <li>Vevőszolgálatunk könnyen elérhető és gyorsan és hatékonyan megoldja az esetlegesen felmerülő problémákat
        </li>
    </ul>
    <h2>Raktárunk</h2>
    <p>2980 m² raktárterület áll rendelkezésünkre, a modern, magas polcokon pedig több mint 600 raklapnyi árut tudunk
        elhelyezni. A nagy raktárméret előnye az, hogy a legtöbb terméket nagy mennyiségben tudjuk rendelni, azért, hogy
        olcsó árakat, nagy választékot és gyors kiszolgálást tudjunk biztosítani ügyfeleinknek. Mint független importőr,
        italainkat a nemzetközi piacokról és gyártóktól szerezzük be. Árainkat ezért kizárólag az €/forint árfolyama
        határozza meg.</p>
</div>
<table id="t_videos">
    <tr>
        <td><q class="quotes">A sör annak a bizonyítéka, hogy Isten szeret minket,
            <br>és azt akarja, hogy boldogok legyünk.</q>
            <p>Benjamin Franklin</p></td>
        <td class="right">
            <iframe src="https://www.youtube.com/embed/cUr8jVWauq8" width="500" height="400"></iframe>
        </td>
    </tr>
    <tr>
        <td class="left">
            <iframe src="https://www.youtube.com/embed/3PInCVXBsS8" width="500" height="400"></iframe>
        </td>
        <td><q class="quotes">Ugyan, ugyan, a jó bor jó barát, csak tudni kell hozzá.
            <br>Ne háborogj ellene tovább.</q>
            <p>William Shakespeare</p></td>
    </tr>
</table>
<p style="text-align: center">
    <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d5518.276850329817!2d20.14288085291222!3d46.247475870863795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x4744886557ac1407%3A0x8ef6cdceb30443a2!2sSzeged%2C%20Tisza%20Lajos%20krt.%20103%2C%206725!3m2!1d46.246871!2d20.1469232!5e0!3m2!1shu!2shu!4v1710691984225!5m2!1shu!2shu"
            id="map" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</p>
<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>