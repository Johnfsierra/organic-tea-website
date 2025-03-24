<?php include 'includes/header.php'; ?>

<main>
    <section class="login-form">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
