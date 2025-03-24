<?php include 'includes/header.php'; ?>

<main>
    <section class="signup-form">
        <h2>Create an Account</h2>
        <form action="signup_process.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
