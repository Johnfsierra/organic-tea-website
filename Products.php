<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a base de datos y header
include 'includes/header.php';
include 'includes/db_connect.php';
?>

<main>
    <section class="products">
        <h2>Our Products</h2>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>

        <div class="product-list">
            <?php
            // Buscar productos
            $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?");
            $stmt->execute([$search]);
            $products = $stmt->fetchAll();

            // Mostrar productos
            if ($products):
                foreach ($products as $product):
            ?>
                <div class="product-item">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php
                endforeach;
            else:
                echo "<p>No products found.</p>";
            endif;
            ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
