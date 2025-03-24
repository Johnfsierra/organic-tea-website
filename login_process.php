<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Hash password (must match hash used in signup)
    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $hashed_password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Incorrect email or password. <a href='login.php'>Try again</a>.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
