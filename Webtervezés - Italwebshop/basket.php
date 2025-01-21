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
if (isset($_POST['delete_product']) && isset($_POST['product_id'])) {
    $product_id_to_delete = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id_to_delete])) {
        unset($_SESSION['cart'][$product_id_to_delete]);
        echo "<script> alert('Sikeres törlés!')</script>";
    }
}

if (isset($_POST['update_quantity']) && isset($_POST['product_id'])) {
    $product_id_to_update = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    if (isset($_SESSION['cart'][$product_id_to_update])) {
        $old_quantity = $_SESSION['cart'][$product_id_to_update]['quantity'];
        if ($old_quantity != $new_quantity) {
            $_SESSION['cart'][$product_id_to_update]['quantity'] = $new_quantity;
            echo "<script> alert('Sikeres módosítás!')</script>";
        } else {
            echo "<script> alert('Nincs mit módosítani!')</script>";
        }
    } else {
        echo "<script> alert('Sikertelen módosítás!')</script>";
    }
}

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $subtotal = $product['price'] * $product['quantity'];
        echo "<table class=\"t_basket\">";
        echo "<tr>";
        echo "<td><img src='img/{$product['id']}.jpg' alt='{$product['name']}'></td>";
        echo '<td>'; //név és mennyiség
        echo "<h3>{$product['name']} | {$product['price']} Ft/db.</h3>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='product_id' value='$product_id'>";
        echo "<input type='number' name='new_quantity' value='{$product['quantity']}' min='1' style='width:30px; height:35px; font-size: 20px; margin-right: 15px;'>";
        echo "<button type='submit' name='update_quantity' class='b_basket'>Módosítás</button>";
        echo "</form>";
        echo '</td>';
        echo "<td><h3>{$subtotal} Ft</h3></td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='product_id' value='$product_id'>";
        echo "<button type='submit' name='delete_product' class='b_basket'>Törlés</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        $total += $subtotal;
    }
} else {
    echo "<table class=\"t_basket\">";
    echo "<tr>
            <td>
               <h1> A kosár üres :( </h1>
            </td>
         </tr>";
    echo "</table>";
}


global $conn;
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['coupon_activate'])) {
    if (!empty($_POST['coupon_name'])) {
        $coupon = $_POST['coupon_name'];
        $sql = "SELECT * FROM kuponok WHERE kod = '$coupon'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            $row = mysqli_fetch_assoc($result);
            $discount = ($row['ertek'] / 100) * $total;
            $total -= $discount;
            echo "<script> alert('A kuponkód aktiválva!')</script>";
        } else {
            echo "<script> alert('A kuponkód nem helyes!')</script>";
        }
    }
}

?>


<div class="order">
    <form action="basket.php" method="POST">
        <h1 style="text-align: center; margin: 50px 25px 0; display: inline-block">Kuponkód:</h1>
        <input type="text" name="coupon_name">
        <button class="b_order" name="coupon_activate">Hitelesít</button>
        <br>
        <h1 style="text-align: center; margin: 50px 50px; display: inline-block">Végösszeg: <?php echo $total; ?>
            Ft</h1>
        <button class="b_order" type="submit" name="submit">Megrendel</button>
    </form>

</div>

<?php
include_once('connect.php');

if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    if (isset($_POST["submit"])) {
        echo "<script> alert('Sikeres megrendelés!')
               location.href = 'basket.php';
                </script>";
        unset($_SESSION['cart']);
        exit;
    }
}
if (isset($_POST["submit"])) {
    echo "<script> alert('Bejelentkezés szükséges a megrendeléshez!')</script>";
    exit;
}
?>


<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>