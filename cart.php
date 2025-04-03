<?php
session_start();

// ✅ Verifica si el usuario ha iniciado sesión
// 🚫 Restrict access if user is not logged in

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to view the cart.'); window.location.href='login.php';</script>";
    exit;
}

include 'includes/header.php';
include 'includes/db_connect.php';
?>

<main>
  <section class="cart">
    <h2>Your Shopping Cart</h2>
    <?php
    // ✅ Inicializar el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ✅ Manejar POST (Agregar / Actualizar / Eliminar productos)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Agregar producto al carrito
        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            if (!isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = 1;
            } else {
                $_SESSION['cart'][$productId]++;
            }
        }

        // Actualizar cantidades
        if (isset($_POST['update'])) {
            foreach ($_POST['quantities'] as $productId => $quantity) {
                $_SESSION['cart'][$productId] = (int)$quantity;
            }
        }

        // Eliminar producto
        if (isset($_POST['remove'])) {
            $removeId = $_POST['remove'];
            unset($_SESSION['cart'][$removeId]);
        }
    }

    // ✅ Mostrar contenido del carrito
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        echo '<form method="POST">';
        echo '<table>';
        echo '<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>';

        $total = 0;

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

            if ($product) {
                $lineTotal = $product['price'] * $quantity;
                $total += $lineTotal;

                echo '<tr>';
                echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                echo '<td>$' . number_format($product['price'], 2) . '</td>';
                echo '<td><input type="number" name="quantities[' . $productId . ']" value="' . $quantity . '" min="1" required></td>';
                echo '<td>$' . number_format($lineTotal, 2) . '</td>';
                echo '<td><button type="submit" name="remove" value="' . $productId . '">Remove</button></td>';
                echo '</tr>';
            }
        }

        echo '<tr><td colspan="3"><strong>Total</strong></td><td colspan="2">$' . number_format($total, 2) . '</td></tr>';
        echo '</table>';
        echo '<button type="submit" name="update">Update Cart</button>';
        echo '</form>';
    }
    ?>
  </section>
</main>

<script>
  // Validación de cantidad en cliente
  document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function () {
      if (this.value < 1) {
        alert("Quantity must be at least 1.");
        this.value = 1;
      }
    });
  });
</script>

<?php include 'includes/footer.php'; ?>
