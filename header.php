<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CvSU Lost & Found</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Lost and Found Item Monitoring System</h1>
    <p>Cavite State University - Main Campus</p>
</header>
<nav>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="home.php">Home</a>
        <a href="report-item.php">Report Item</a>
        <a href="lost-items.php">Lost Items</a>
        <a href="found-items.php">Found Items</a>
        <a href="my-reports.php">My Reports</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="index.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>
