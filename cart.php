<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
// Start or resume cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    // Update quantity
    if (isset($_POST['update_id'], $_POST['new_qty'])) {
        $update_id = $_POST['update_id'];
        $new_qty = max(1, (int)$_POST['new_qty']);
        $_SESSION['cart'][$update_id] = $new_qty;
    }

    // Remove item
    if (isset($_POST['remove_id'])) {
        $remove_id = $_POST['remove_id'];
        unset($_SESSION['cart'][$remove_id]);
    }
}
?>

<main>
    <section class="cart">
        <h2>Your Shopping Cart</h2>
        <?php
        include 'includes/db_connect.php';

        if (empty($_SESSION['cart'])) {
            echo "<p>Your cart is empty.</p>";
        } else {
            echo '<table><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th>Actions</th></tr>';
            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch();

                if ($product) {
                    $line_total = $qty * $product['price'];
                    $total += $line_total;
                    echo "<tr>
                            <td>" . htmlspecialchars($product['name']) . "</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='update_id' value='$product_id'>
                                    <input type='number' name='new_qty' value='$qty' min='1'>
                                    <button type='submit'>Update</button>
                                </form>
                            </td>
                            <td>$" . number_format($product['price'], 2) . "</td>
                            <td>$" . number_format($line_total, 2) . "</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='remove_id' value='$product_id'>
                                    <button type='submit'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
            }
            echo "<tr><td colspan='3'><strong>Total</strong></td><td colspan='2'><strong>$" . number_format($total, 2) . "</strong></td></tr></table>";
        }
        ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
