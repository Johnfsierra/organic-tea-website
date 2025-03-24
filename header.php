<!-- includes/header.php -->
<?php session_start(); ?>
<header>
    <h1 class="logo"><a href="index.php">Emma's Tea Store</a></h1>
    <nav>
        <ul>
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="products.php">Products ▾</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="#">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>