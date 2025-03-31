
<?php session_start(); ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<main>
  <section class="login-form">
    <h2>Login</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = $_POST['email'] ?? '';
      $password = $_POST['password'] ?? '';

      if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          echo "<p>Login successful. Redirecting...</p>";
          header("Refresh: 2; URL=index.php");
          exit;
        } else {
          echo "<p>Invalid email or password.</p>";
        }
      } else {
        echo "<p>Please fill in all fields.</p>";
      }
    }
    ?>

    <form id="loginForm" method="POST">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
  </section>
</main>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
      alert("All fields are required.");
      e.preventDefault();
      return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      alert("Please enter a valid email address.");
      e.preventDefault();
    }
  });
</script>

<?php include 'includes/footer.php'; ?>
