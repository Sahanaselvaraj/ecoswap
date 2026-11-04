<?php
require_once __DIR__ . "/functions.php";
$page_title = $page_title ?? "EcoSwap";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($page_title) ?> | EcoSwap</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <a class="brand" href="index.php">♻ EcoSwap</a>
    <nav>
        <a href="index.php">Home</a>
        <a href="listing.php">Explore</a>
        <?php if (is_logged_in()): ?>
            <a href="add_listing.php">Add Item</a>
            <a href="my_listings.php">My Listings</a>
            <a href="impact.php">Impact</a>
            <a class="nav-user" href="logout.php">Logout (<?= h($_SESSION['user_name'] ?? 'User') ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a class="nav-cta" href="register.php">Join EcoSwap</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
<?php show_flash(); ?>
