<?php
require_once __DIR__ . '/bootstrap.php';
$currentPage = $currentPage ?? '';
$user = $_SESSION['demo_user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'CampusBook') ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=1">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrapper">
        <a href="index.php" class="brand">
            <img src="assets/images/logo.png" alt="CampusBook Logo" class="brand-mark">
            <span>CampusBook</span>
        </a>

        <nav class="main-nav">
            <a class="<?= active_page('home', $currentPage) ?>" href="index.php">Home</a>
            <a class="<?= active_page('login', $currentPage) ?>" href="login.php">Login</a>
            <a class="<?= active_page('register', $currentPage) ?>" href="register.php">Register</a>
            <a class="<?= active_page('dashboard', $currentPage) ?>" href="dashboard.php">Dashboard</a>
            <a class="<?= active_page('appointments', $currentPage) ?>" href="appointments.php">Appointments</a>
        </nav>

        <div class="nav-user">
            <?php if (!empty($_SESSION['logged_in']) && $user): ?>
                <span class="user-chip"><?= htmlspecialchars(explode(' ', $user['full_name'])[0][0] ?? 'S') ?></span>
                <a class="btn btn-outline small" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="btn btn-outline small" href="login.php">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main>
