<?php
require_once "includes/db.php";
require_once "includes/functions.php";
$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$categories = ['Books','Clothing','Furniture','Electronics','Gardening','Home & Kitchen','Other'];
$sql = "SELECT l.*,u.name AS owner FROM listings l JOIN users u ON u.id=l.user_id WHERE l.status='available'";
$params = [];
if ($q !== '') { $sql .= " AND (l.title LIKE ? OR l.description LIKE ?)"; $params[]="%$q%"; $params[]="%$q%"; }
if (in_array($category, $categories, true)) { $sql .= " AND l.category=?"; $params[]=$category; }
$sql .= " ORDER BY l.created_at DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $items=$stmt->fetchAll();
$page_title="Explore Items";
require "includes/header.php";
?>
<section class="page-intro"><span class="eyebrow">Find your next useful thing</span><h1>Explore shared items</h1><p>Search by item name or choose a category.</p></section>
<form class="search-bar" method="get"><input name="q" placeholder="Search books, clothes, furniture..." value="<?= h($q) ?>"><select name="category"><option value="">All categories</option><?php foreach($categories as $cat): ?><option value="<?= h($cat) ?>" <?= $category===$cat?'selected':'' ?>><?= h($cat) ?></option><?php endforeach; ?></select><button class="button" type="submit">Search</button></form>
<div class="item-grid">
<?php if (!$items): ?><div class="empty-state">No matching items found. Try another search.</div><?php endif; ?>
<?php foreach($items as $item): ?>
<article class="item-card"><div class="item-emoji"><?= $item['category']==='Books'?'📚':($item['category']==='Clothing'?'👕':($item['category']==='Furniture'?'🪑':($item['category']==='Electronics'?'💻':'🌱'))) ?></div><div class="item-content"><span class="tag"><?= h($item['category']) ?></span><h3><?= h($item['title']) ?></h3><p><?= h($item['description']) ?></p><small>Condition: <?= h($item['item_condition']) ?> · <?= h($item['location']) ?></small><small>Shared by <?= h($item['owner']) ?></small>
<?php if (is_logged_in() && current_user_id() != $item['user_id']): ?><form method="post" action="request_item.php"><input type="hidden" name="listing_id" value="<?= (int)$item['id'] ?>"><button class="button small full" type="submit">Express Interest</button></form><?php elseif (!is_logged_in()): ?><a class="button small full" href="login.php">Login to express interest</a><?php else: ?><span class="own-label">Your listing</span><?php endif; ?>
</div></article>
<?php endforeach; ?>
</div>
<?php require "includes/footer.php"; ?>
