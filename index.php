<?php
require_once "includes/db.php";
require_once "includes/functions.php";
$page_title = "Home";
$countItems = (int)$pdo->query("SELECT COUNT(*) FROM listings WHERE status='available'")->fetchColumn();
$countUsers = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$countClaimed = (int)$pdo->query("SELECT COUNT(*) FROM listings WHERE status='claimed'")->fetchColumn();
$latest = $pdo->query("SELECT l.*, u.name AS owner FROM listings l JOIN users u ON u.id=l.user_id WHERE l.status='available' ORDER BY l.created_at DESC LIMIT 6")->fetchAll();
require "includes/header.php";
?>
<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow">Reuse • Share • Sustain</span>
        <h1>Your unused things can become someone else's treasure.</h1>
        <p>EcoSwap connects people who have useful items to share with people who need them. Give books, clothes, furniture and more a second life.</p>
        <div class="hero-actions">
            <a class="button" href="listing.php">Explore Items</a>
            <a class="button button-light" href="<?= is_logged_in() ? 'add_listing.php' : 'register.php' ?>">Share an Item</a>
        </div>
    </div>
    <div class="hero-art"><div class="leaf">♻</div><p>Small actions.<br><strong>Big impact.</strong></p></div>
</section>
<section class="stats">
    <div class="stat-card"><strong><?= $countItems ?></strong><span>Available items</span></div>
    <div class="stat-card"><strong><?= $countClaimed ?></strong><span>Items claimed</span></div>
    <div class="stat-card"><strong><?= $countUsers ?></strong><span>Community members</span></div>
</section>
<section class="section-heading">
    <div><span class="eyebrow">Community marketplace</span><h2>Recently shared items</h2></div>
    <a class="text-link" href="listing.php">View all →</a>
</section>
<div class="item-grid">
<?php if (!$latest): ?>
    <div class="empty-state">No items have been added yet. Be the first to share something!</div>
<?php endif; ?>
<?php foreach ($latest as $item): ?>
    <article class="item-card">
        <div class="item-emoji"><?= h($item['category'] === 'Books' ? '📚' : ($item['category'] === 'Clothing' ? '👕' : ($item['category'] === 'Furniture' ? '🪑' : ($item['category'] === 'Electronics' ? '💻' : '🌱')))) ?></div>
        <div class="item-content"><span class="tag"><?= h($item['category']) ?></span><h3><?= h($item['title']) ?></h3><p><?= h(mb_strimwidth($item['description'], 0, 90, '…')) ?></p><small>Shared by <?= h($item['owner']) ?></small><a class="card-link" href="listing.php">Explore items →</a></div>
    </article>
<?php endforeach; ?>
</div>
<section class="callout"><div><h2>Have something you no longer use?</h2><p>Someone nearby might be looking for exactly that.</p></div><a class="button" href="<?= is_logged_in() ? 'add_listing.php' : 'register.php' ?>">Post an Item</a></section>
<?php require "includes/footer.php"; ?>
