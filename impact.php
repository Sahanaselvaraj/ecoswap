<?php
require_once "includes/db.php";
require_once "includes/functions.php";
$totalUsers=(int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalListings=(int)$pdo->query("SELECT COUNT(*) FROM listings")->fetchColumn();
$claimed=(int)$pdo->query("SELECT COUNT(*) FROM listings WHERE status='claimed'")->fetchColumn();
$available=(int)$pdo->query("SELECT COUNT(*) FROM listings WHERE status='available'")->fetchColumn();
$page_title="Community Impact";
require "includes/header.php";
?>
<section class="page-intro"><span class="eyebrow">Together, we make a difference</span><h1>Our community impact</h1><p>Every shared item is one more opportunity to reuse instead of waste.</p></section>
<div class="impact-grid"><div class="impact-card"><span>👥</span><strong><?= $totalUsers ?></strong><p>Community members</p></div><div class="impact-card"><span>📦</span><strong><?= $totalListings ?></strong><p>Total listings created</p></div><div class="impact-card"><span>🤝</span><strong><?= $claimed ?></strong><p>Items claimed</p></div><div class="impact-card"><span>♻️</span><strong><?= $available ?></strong><p>Items still available</p></div></div>
<div class="impact-message"><h2>Reuse is a simple step towards a cleaner community.</h2><p>Share items that are safe, clean and in usable condition. Coordinate collection responsibly and never share private information publicly.</p><a class="button" href="listing.php">Explore Items</a></div>
<?php require "includes/footer.php"; ?>
