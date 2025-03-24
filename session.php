<?php
// includes/session.php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}
?>
