<?php
session_start();

global $conn;
require_once "connect.php";

//ár módosítás

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modify_price'])) {
        if (isset($_POST['new_price'])) {
            $new_price = intval($_POST['new_price']);
            $product_id = $_POST['id'];
            if ($new_price >= 0) {
                $query = "UPDATE termekek SET ar = $new_price WHERE azonosito = '$product_id'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_affected_rows($conn) > 0) {
                    echo "<script> alert('Az ár sikeresen frissítve!')</script>";
                } else {
                    echo "<script> alert('Nem történt módosítás!')</script>";
                }
            } else {
                echo "<script> alert('Az ár nem lehet negatív!')</script>";
            }
        }
    }
}

//termék törlés

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_item'])) {
        $product_id = $_POST['id'];
        $sql = "DELETE FROM termekek WHERE azonosito = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('A termék sikeresen törölve!')</script>";
        } else {
            echo "<script> alert('Hiba történt a termék törlése közben!')</script>";
        }
    }
}

//akció törlése
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_discount'])) {
        $product_id = $_POST['id'];
        $sql = "UPDATE termekek SET akcios_ar = NULL WHERE azonosito = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Az akció sikeresen törölve!')</script>";
        } else {
            echo "<script> alert('Hiba történt az akció törlése közben!')</script>";
        }
    }
}


//ackió létrehozása

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['apply_discount'])) {
        if (isset($_POST['sale_price'])) {
            $sale_price = intval($_POST['sale_price']);
            $product_id = $_POST['id'];
            if ($sale_price >= 0) {
                $query = "UPDATE termekek SET akcios_ar = $sale_price WHERE azonosito = '$product_id'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_affected_rows($conn) > 0) {
                    echo "<script> alert('Az akció sikeresen létrehozva!')</script>";
                } else {
                    echo "<script> alert('Nem történt létrehozás, adj meg egy árat!')</script>";
                }
            } else {
                echo "<script> alert('Az ár nem lehet negatív!')</script>";
            }
        }
    }
}

//akció módosítása
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modify_discount'])) {
        if (isset($_POST['sale_price'])) {
            $sale_price = intval($_POST['sale_price']);
            $product_id = $_POST['id'];
            if ($sale_price >= 0) {
                $query = "UPDATE termekek SET akcios_ar = $sale_price WHERE azonosito = '$product_id'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_affected_rows($conn) > 0) {
                    echo "<script> alert('Az akció sikeresen módosítva!')</script>";
                } else {
                    echo "<script> alert('Nem történt módosítás!')</script>";
                }
            } else {
                echo "<script> alert('Az ár nem lehet negatív!')</script>";
            }
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
        .menu {
            background-image: url(img/Nav_bar.jpg);
        }
    </style>
</head>
<body>
<?php
if (!isset($_SESSION['admin'])) {
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

<div style="padding-top: 20px; text-align: center">
    <form method="GET" action="new_drink.php">
        <button class="b_basket" style="margin-top: 15px">Hozzáadás</button>
    </form>
    <br>
    <form method="GET" action="coupon.php">
        <button class="b_basket">Kupon</button>
    </form>
</div>
<!-- SÖRÖK   -->
<table class="t_products">
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'kobanyai'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/kobanyai.jpg" alt="Kőbányai">
            <h3>Kőbányai<br>0.5L | 4.3%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="kobanyai"></label>
                        <input type="hidden" name="id" value="kobanyai">
                        <label>Eredeti ár:</label>
                        <input type="number" id="kobanyai" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_kobanyai" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>

                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'dreher'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/dreher.jpg" alt="Dreher">
            <h3>Dreher<br>0.5L | 5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="dreher"></label>
                        <input type="hidden" name="id" value="dreher">
                        <label>Eredeti ár:</label>
                        <input type="number" id="dreher" name="new_price" min="0" value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_dreher" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'borsodi'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/borsodi.jpg" alt="Borsodi">
            <h3>Borsodi<br>0.5L | 4.5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="borsodi"></label>
                        <input type="hidden" name="id" value="borsodi">
                        <label>Eredeti ár:</label>
                        <input type="number" id="borsodi" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_borsodi" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'heineken'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/heineken.jpg" alt="Heineken">
            <h3>Heineken<br>0.5L | 5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="heineken"></label>
                        <input type="hidden" name="id" value="heineken">
                        <label>Eredeti ár:</label>
                        <input type="number" id="heineken" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_heineken" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'csiki'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/csiki.jpg" alt="Csíki sör">
            <h3>Csíki sör<br>0.5L | 6%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="csiki"></label>
                        <input type="hidden" name="id" value="csiki">
                        <label>Eredeti ár:</label>
                        <input type="number" id="csiki" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_csiki" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'stella'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/stella.jpg" alt="Stella">
            <h3>Stella<br>0.5L | 5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="stella"></label>
                        <input type="hidden" name="id" value="stella">
                        <label>Eredeti ár:</label>
                        <input type="number" id="stella" name="new_price" min="0" value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_stella" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'tuborg'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/tuborg.jpg" alt="Tuborg">
            <h3>Tuborg<br>0.5L | 4.6%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="tuborg"></label>
                        <input type="hidden" name="id" value="tuborg">
                        <label>Eredeti ár:</label>
                        <input type="number" id="tuborg" name="new_price" min="0" value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_tuborg" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lowen'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/lowen.jpg" alt="Löwenbrau">
            <h3>Löwenbrau<br>0.5L | 4%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="lowen"></label>
                        <input type="hidden" name="id" value="lowen">
                        <label>Eredeti ár:</label>
                        <input type="number" id="lowen" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_lowen" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>
    <!-- SÖRÖK VÉGE   -->

    <!-- BOROK  -->

    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'juhasztr'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/juhasztr.jpg" alt="Juhász Testvérek (rosé)">
            <h3>Juhász Testvérek (rosé)<br>0.75L | 12%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="juhasztr"></label>
                        <input type="hidden" name="id" value="juhasztr">
                        <label>Eredeti ár:</label>
                        <input type="number" id="juhasztr" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_juhasztr" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'frittmanio'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/frittmanio.jpg" alt="Frittmann Irsai Olivér (fehér)">
            <h3>Frittmann Irsai Olivér (fehér)<br>0.75L | 11.5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="frittmanio"></label>
                        <input type="hidden" name="id" value="frittmanio">
                        <label>Eredeti ár:</label>
                        <input type="number" id="frittmanio" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_frittmanio" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'irsaiony'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/irsaiony.jpg" alt="Israi Olivér Nyakas (fehér)">
            <h3>Israi Olivér Nyakas (fehér)<br>0.75L | 11.5%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="irsaiony"></label>
                        <input type="hidden" name="id" value="irsaiony">
                        <label>Eredeti ár:</label>
                        <input type="number" id="irsaiony" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_irsaiony" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'vargamv'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/vargamv.jpg" alt="Varga Merlot édes (vörös)">
            <h3>Varga Merlot édes (vörös)<br>0.75L</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="vargamv"></label>
                        <input type="hidden" name="id" value="vargamv">
                        <label>Eredeti ár:</label>
                        <input type="number" id="vargamv" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_vargamv" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lafieev'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/lafieev.jpg" alt="LaFiesta Édes Élmény (vörös)">
            <h3>LaFiesta Édes Élmény (vörös)<br>0.75L | 10%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="lafieev"></label>
                        <input type="hidden" name="id" value="lafieev">
                        <label>Eredeti ár:</label>
                        <input type="number" id="lafieev" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_lafieev" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lafieef'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/lafieef.jpg" alt="LaFiesta Édes Élmény (fehér)">
            <h3>LaFiesta Édes Élmény (fehér)<br>0.75L | 10%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="lafieef"></label>
                        <input type="hidden" name="id" value="lafieef">
                        <label>Eredeti ár:</label>
                        <input type="number" id="lafieef" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_lafieef" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'egribvv'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/egribvv.jpg" alt="Egri Bikavér (vörös)">
            <h3>Egri Bikavér (vörös)<br>0.75L</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="egribvv"></label>
                        <input type="hidden" name="id" value="egribvv">
                        <label>Eredeti ár:</label>
                        <input type="number" id="egribvv" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_egribvv" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'szentik'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/szentik.jpg" alt="Szent István Korona (fehér)">
            <h3>Szent István Korona (fehér)<br>0.75L | 11%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="szentik"></label>
                        <input type="hidden" name="id" value="szentik">
                        <label>Eredeti ár:</label>
                        <input type="number" id="szentik" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_szentik" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>
    <!-- BOROK VÉGE   -->

    <!--RÖVIDEK-->
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jager'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/jager.jpg" alt="Jägermeister">
            <h3>Jägermeister<br>0.7L | 35%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="jager"></label>
                        <input type="hidden" name="id" value="jager">
                        <label>Eredeti ár:</label>
                        <input type="number" id="jager" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_jager" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jackd'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/jackd.jpg" alt="Jack Daniel's">
            <h3>Jack Daniel's<br>0.7L | 40%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="jackd"></label>
                        <input type="hidden" name="id" value="jackd">
                        <label>Eredeti ár:</label>
                        <input type="number" id="jackd" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_jackd" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jimb'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/jimb.jpg" alt="Jim Beam">
            <h3>Jim Beam<br>0.7L | 40%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="jimb"></label>
                        <input type="hidden" name="id" value="jimb">
                        <label>Eredeti ár:</label>
                        <input type="number" id="jimb" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_jimb" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'bombay'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/bombay.jpg" alt="Bombay Sapphire">
            <h3>Bombay Sapphire<br>0.7L | 40%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
            while ($row = $result_check_product->fetch_assoc()) {
            echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
            $product_price = $row['ar'];
            $product_sale = $row['akcios_ar']; ?>
            <form method="POST" action="admin.php">
                <label for="bombay"></label>
                <input type="hidden" name="id" value="bombay">
                <label>Eredeti ár:</label>
                <input type="number" id="bombay" name="new_price" min="0" value="<?php echo $product_price; ?>"><br>
                <label>Akciós ár:</label>
                <input type="number" id="sale_bombay" name="sale_price" min="0"
                       value="<?php echo $product_sale; ?>"><br>
                <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít</button>
                <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl</button>
                <?php if ($product_sale > 0) { ?>
                    <button type="submit" class="b_basket" name="modify_discount"
                            style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                    </button>
                <?php } else { ?>
                    <button type="submit" class="b_basket" name="apply_discount"
                            style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                    </button>
                <?php } ?>
                <button type="submit" class="b_basket" name="cancel_discount"
                        style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                </button>
            </form>
        </td>
        <?php }
        } else {
            echo "<p>A termék törölve lett!</p>";
        }
        ?>


    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'absolute'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/absolute.jpg" alt="Absolute Blue">
            <h3>Absolute Blue<br>0.7L | 40%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="absolute"></label>
                        <input type="hidden" name="id" value="absolute">
                        <label>Eredeti ár:</label>
                        <input type="number" id="absolute" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_absolute" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'malibu'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/malibu.jpg" alt="Malibu">
            <h3>Malibu<br>0.7L | 21%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="malibu"></label>
                        <input type="hidden" name="id" value="malibu">
                        <label>Eredeti ár:</label>
                        <input type="number" id="malibu" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_malibu" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'hubi'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/hubi.jpg" alt="St. Hubertus">
            <h3>St. Hubertus<br>0.7L | 33%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="hubi"></label>
                        <input type="hidden" name="id" value="hubi">
                        <label>Eredeti ár:</label>
                        <input type="number" id="hubi" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_hubi" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p>";
            }
            ?>


        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'unicum'";
            $result_check_product = $conn->query($sql_check_product);
            ?>
            <img src="img/unicum.jpg" alt="Unicum">
            <h3>Zwack Unicum<br>0.7L | 40%</h3>
            <?php
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    echo "<p>Jelenlegi ár: " . $row['ar'] . " Ft</p>";
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <form method="POST" action="admin.php">
                        <label for="unicum"></label>
                        <input type="hidden" name="id" value="unicum">
                        <label>Eredeti ár:</label>
                        <input type="number" id="unicum" name="new_price" min="0"
                               value="<?php echo $product_price; ?>"><br>
                        <label>Akciós ár:</label>
                        <input type="number" id="sale_unicum" name="sale_price" min="0"
                               value="<?php echo $product_sale; ?>"><br>
                        <button type="submit" class="b_basket" name="modify_price" style="margin-top: 5px;">Módosít
                        </button>
                        <button type="submit" class="b_basket" name="delete_item" style="margin-top: 5px;">Töröl
                        </button>
                        <?php if ($product_sale > 0) { ?>
                            <button type="submit" class="b_basket" name="modify_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció módosítása
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="b_basket" name="apply_discount"
                                    style="margin-top: 5px; height: 70px; width: 180px;">Akció létrehozása
                            </button>
                        <?php } ?>
                        <button type="submit" class="b_basket" name="cancel_discount"
                                style="margin-top: 5px;height: 70px; width: 180px;">Akció törlése
                        </button>
                    </form>
                <?php }
            } else {
                echo "<p>A termék törölve lett!</p> ?>";
            }
            ?>

        </td>
    </tr>
</table>

<!--RÖVIDEK VÉGE-->
<footer id="footer">
    <p>Albert Erik N6HCN7 <br><a href="mailto:alberterik.tibor@gmail.com">alberterik.tibor@gmail.com</a></p>
    <p>Kovács Erik DX46YF <br><a href="mailto:kovacs.erik626@gmail.com">kovacs.erik626@gmail.com</a></p>
</footer>
</body>
</html>