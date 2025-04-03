<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/header.php';
include 'includes/db_connect.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($email) || empty($password) || $password !== $confirm) {
        $error = "Please complete all fields and make sure passwords match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashed])) {
            $success = "Account created successfully! Redirecting to login...";
            echo "<script>setTimeout(() => window.location.href = 'login.php', 30000);</script>";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<main>
    <form class="signup-form" method="POST" onsubmit="return validateSignup();">
        <h2>Sign Up</h2>

        <?php if ($error): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif ($success): ?>
            <p class="success-msg"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <?php if (!$success): ?>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm">Confirm Password:</label>
            <input type="password" name="confirm" id="confirm" required>

            <button type="submit">Register</button>
        <?php endif; ?>
    </form>
</main>

<script>
function validateSignup() {
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirm").value;

    if (!username || !email || !password || !confirm) {
        alert("All fields are required.");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email.");
        return false;
    }

    if (password !== confirm) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
</script>

<?php include 'includes/footer.php'; ?>
