<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    echo "<script> alert('Sikeres koráshoz adás!')</script>";
    if ($quantity > 0) {
        $product_id = $_POST['id'];
        $product_name = $_POST['name'];
        $product_price = $_POST['price'];
        $product_details = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity
        );

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        if (array_key_exists($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $product_details;
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

global $conn;
require_once "connect.php";
?>

<!-- SÖRÖK   -->
<table class="t_products">
    <tr>
        <th colspan="4" id="beers">Sörök</th>
    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'kobanyai'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/kobanyai.jpg" alt="Kőbányai">
                    <h3>Kőbányai<br>0.5L | 4.3%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="kobanyai"></label>
                        <input type="hidden" name="id" value="kobanyai">
                        <input type="hidden" name="name" value="Kőbányai">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="kobanyai" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/kobanyai.jpg" alt="Kőbányai">
                <h3>Kőbányai<br>0.5L | 4.3%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'dreher'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar'];
                    ?>
                    <img src="img/dreher.jpg" alt="Dreher">
                    <h3>Dreher<br>0.5L | 4.3%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration: line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="dreher"></label>
                        <input type="hidden" name="id" value="dreher">
                        <input type="hidden" name="name" value="Dreher">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="dreher" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/dreher.jpg" alt="Dreher">
                <h3>Dreher<br>0.5L | 4.3%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'borsodi'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar'];
                    ?>
                    <img src="img/borsodi.jpg" alt="Borsodi">
                    <h3>Borsodi<br>0.5L | 4.5%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="borsodi"></label>
                        <input type="hidden" name="id" value="borsodi">
                        <input type="hidden" name="name" value="Borsodi">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="borsodi" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/borsodi.jpg" alt="Borsodi">
                <h3>Borsodi<br>0.5L | 4.5%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'heineken'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/heineken.jpg" alt="Heineken">
                    <h3>Heineken<br>0.5L | 5%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="heineken"></label>
                        <input type="hidden" name="id" value="heineken">
                        <input type="hidden" name="name" value="Heineken">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="heineken" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/heineken.jpg" alt="Heineken">
                <h3>Heineken<br>0.5L | 5%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>


    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'csiki'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/csiki.jpg" alt="Csíki sör">
                    <h3>Csíki sör<br>0.5L | 6%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="csiki"></label>
                        <input type="hidden" name="id" value="csiki">
                        <input type="hidden" name="name" value="Csíki sör">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="csiki" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/csiki.jpg" alt="Csíki sör">
                <h3>Csíki sör<br>0.5L | 6%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'stella'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/stella.jpg" alt="Stella">
                    <h3>Stella<br>0.5L | 5%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="stella"></label>
                        <input type="hidden" name="id" value="stella">
                        <input type="hidden" name="name" value="Stella">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="stella" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/stella.jpg" alt="Stella">
                <h3>Stella<br>0.5L | 5%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'tuborg'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/tuborg.jpg" alt="Tuborg">
                    <h3>Tuborg<br>0.5L | 4.6%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="tuborg"></label>
                        <input type="hidden" name="id" value="tuborg">
                        <input type="hidden" name="name" value="Tuborg">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="tuborg" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/tuborg.jpg" alt="Tuborg">
                <h3>Tuborg<br>0.5L | 4.6%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lowen'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/lowen.jpg" alt="Löwenbrau">
                    <h3>Löwenbrau<br>0.5L | 4%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="lowen"></label>
                        <input type="hidden" name="id" value="lowen">
                        <input type="hidden" name="name" value="Löwenbrau">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="lowen" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/lowen.jpg" alt="Löwenbrau">
                <h3>Löwenbrau<br>0.5L | 4%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>
    <!-- SÖRÖK VÉGE   -->

    <!-- BOROK  -->
    <tr>
        <th colspan="4" id="wines">Borok</th>
    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'juhasztr'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/juhasztr.jpg" alt="Juhász Testvérek (rosé)">
                    <h3>Juhász Testvérek (rosé)<br>0.75L | 12%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="juhasztr"></label>
                        <input type="hidden" name="id" value="juhasztr">
                        <input type="hidden" name="name" value="Juhász Testvérek (rosé)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="juhasztr" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/juhasztr.jpg" alt="Juhász Testvérek (rosé)">
                <h3>Juhász Testvérek (rosé)<br>0.75L | 12%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'frittmanio'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/frittmanio.jpg" alt="Frittmann Irsai Olivér (fehér)">
                    <h3>Frittmann Irsai Olivér (fehér)<br>0.75L | 11.5%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="frittmanio"></label>
                        <input type="hidden" name="id" value="frittmanio">
                        <input type="hidden" name="name" value="Frittmann Irsai Olivér (fehér)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="frittmanio" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/frittmanio.jpg" alt="Frittmann Irsai Olivér (fehér)">
                <h3>Frittmann Irsai Olivér (fehér)<br>0.75L | 11.5%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'irsaiony'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/irsaiony.jpg" alt="Irsai Olivér Nyakas (fehér)">
                    <h3>Israi Olivér Nyakas (fehér)<br>0.75L | 11.5%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="irsaiony"></label>
                        <input type="hidden" name="id" value="irsaiony">
                        <input type="hidden" name="name" value="Irsai Olivér Nyakas (fehér)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="irsaiony" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/irsaiony.jpg" alt="Irsai Olivér Nyakas (fehér)">
                <h3>Israi Olivér Nyakas (fehér)<br>0.75L | 11.5%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'vargamv'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/vargamv.jpg" alt="Varga Merlot édes (vörös)">
                    <h3>Varga Merlot édes (vörös)<br>0.75L</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="vargamv"></label>
                        <input type="hidden" name="id" value="vargamv">
                        <input type="hidden" name="name" value="Varga Merlot édes (vörös)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="vargamv" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/vargamv.jpg" alt="Varga Merlot édes (vörös)">
                <h3>Varga Merlot édes (vörös)<br>0.75L</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>


    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lafieev'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/lafieev.jpg" alt="LaFiesta Édes Élmény (vörös)">
                    <h3>LaFiesta Édes Élmény (vörös)<br>0.75L | 10%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="lafieev"></label>
                        <input type="hidden" name="id" value="lafieev">
                        <input type="hidden" name="name" value="LaFiesta Édes Élmény (vörös)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="lafieev" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/lafieev.jpg" alt="LaFiesta Édes Élmény (vörös)">
                <h3>LaFiesta Édes Élmény (vörös)<br>0.75L | 10%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'lafieef'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/lafieef.jpg" alt="LaFiesta Édes Élmény (fehér)">
                    <h3>LaFiesta Édes Élmény (fehér)<br>0.75L | 10%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="lafieef"></label>
                        <input type="hidden" name="id" value="lafieef">
                        <input type="hidden" name="name" value="LaFiesta Édes Élmény (fehér)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="lafieef" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/lafieef.jpg" alt="LaFiesta Édes Élmény (fehér)">
                <h3>LaFiesta Édes Élmény (fehér)<br>0.75L | 10%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'egribvv'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/egribvv.jpg" alt="Egri Bikavér (vörös)">
                    <h3>Egri Bikavér (vörös)<br>0.75L</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="egribvv"></label>
                        <input type="hidden" name="id" value="egribvv">
                        <input type="hidden" name="name" value="Egri Bikavér (vörös)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="egribvv" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/egribvv.jpg" alt="Egri Bikavér (vörös)">
                <h3>Egri Bikavér (vörös)<br>0.75L</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'szentik'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/szentik.jpg" alt="Szent István Korona (fehér)">
                    <h3>Szent István Korona (fehér)<br>0.75L | 11%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="szentik"></label>
                        <input type="hidden" name="id" value="szentik">
                        <input type="hidden" name="name" value="Szent István Korona (fehér)">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="szentik" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/szentik.jpg" alt="Szent István Korona (fehér)">
                <h3>Szent István Korona (fehér)<br>0.75L | 11%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>
    <!-- BOROK VÉGE   -->

    <!--RÖVIDEK-->
    <tr>
        <th colspan="4" id="shots">Tömények</th>
    </tr>
    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jager'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/jager.jpg" alt="Jägermeister">
                    <h3>Jägermeister<br>0.7L | 35%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="jager"></label>
                        <input type="hidden" name="id" value="jager">
                        <input type="hidden" name="name" value="Jägermeister">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="jager" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/jager.jpg" alt="Jägermeister">
                <h3>Jägermeister<br>0.7L | 35%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jackd'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/jackd.jpg" alt="Jack Daniel's">
                    <h3>Jack Daniel's<br>0.7L | 40%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="jackd"></label>
                        <input type="hidden" name="id" value="jackd">
                        <input type="hidden" name="name" value="Jack Daniel's">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="jackd" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/jackd.jpg" alt="Jack Daniel's">
                <h3>Jack Daniel's<br>0.7L | 40%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'jimb'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/jimb.jpg" alt="Jim Beam">
                    <h3>Jim Beam<br>0.7L | 40%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="jimb"></label>
                        <input type="hidden" name="id" value="jimb">
                        <input type="hidden" name="name" value="Jim Beam">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="jimb" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/jimb.jpg" alt="Jim Beam">
                <h3>Jim Beam<br>0.7L | 40%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'bombay'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/bombay.jpg" alt="Bombay Sapphire">
                    <h3>Bombay Sapphire<br>0.7L | 40%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="bombay"></label>
                        <input type="hidden" name="id" value="bombay">
                        <input type="hidden" name="name" value="Bombay Sapphire">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="bombay" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/bombay.jpg" alt="Bombay Sapphire">
                <h3>Bombay Sapphire<br>0.7L | 40%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
    </tr>


    <tr>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'absolute'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/absolute.jpg" alt="Absolute Blue">
                    <h3>Absolute Blue<br>0.7L | 40%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="absolute"></label>
                        <input type="hidden" name="id" value="absolute">
                        <input type="hidden" name="name" value="Absolute Blue">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="absolute" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/absolute.jpg" alt="Absolute Blue">
                <h3>Absolute Blue<br>0.7L | 40%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>


        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'malibu'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/malibu.jpg" alt="Malibu">
                    <h3>Malibu<br>0.7L | 21%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="malibu"></label>
                        <input type="hidden" name="id" value="malibu">
                        <input type="hidden" name="name" value="Malibu">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="malibu" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/malibu.jpg" alt="Malibu">
                <h3>Malibu<br>0.7L | 21%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'hubi'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/hubi.jpg" alt="St. Hubertus">
                    <h3>St. Hubertus<br>0.7L | 33%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="hubi"></label>
                        <input type="hidden" name="id" value="hubi">
                        <input type="hidden" name="name" value="St. Hubertus">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="hubi" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/hubi.jpg" alt="St. Hubertus">
                <h3>St. Hubertus<br>0.7L | 33%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
            }
            ?>
        </td>
        <td class="t_products_card">
            <?php
            $sql_check_product = "SELECT * FROM termekek WHERE azonosito = 'unicum'";
            $result_check_product = $conn->query($sql_check_product);
            if ($result_check_product->num_rows > 0) {
                while ($row = $result_check_product->fetch_assoc()) {
                    $product_price = $row['ar'];
                    $product_sale = $row['akcios_ar']; ?>
                    <img src="img/unicum.jpg" alt="Unicum">
                    <h3>Zwack Unicum<br>0.7L | 40%</h3>
                    <?php
                    if ($product_sale !== null && $product_sale > 0) {
                        ?>
                        <p style="text-decoration:red line-through;"><?php echo $product_price; ?> Ft</p>
                        <p>Akciós ár: <?php echo $product_sale; ?> Ft</p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $product_price; ?> Ft</p>
                        <?php
                    }
                    ?>
                    <form class="to_cart" action="products.php" method="post">
                        <label for="unicum"></label>
                        <input type="hidden" name="id" value="unicum">
                        <input type="hidden" name="name" value="Unicum">
                        <?php
                        if ($product_sale !== null && $product_sale > 0) {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_sale; ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                            <?php
                        }
                        ?>
                        <input type="number" id="unicum" name="quantity" value="1" min="0"><br>
                        <button class="b_basket" type="submit" name="add_to_cart">Kosárba</button>
                    </form>
                    <?php
                }
            } else { ?>
                <img src="img/unicum.jpg" alt="Unicum">
                <h3>Zwack Unicum<br>0.7L | 40%</h3>
                <?php echo "<p>A termék törölve lett!</p>";
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