<?php
require_once "includes/db.php";
require_once "includes/functions.php";
require_login();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['listing_id'],$_POST['new_status'])) {
    $newStatus = $_POST['new_status'];
    if (in_array($newStatus,['available','claimed'],true)) {
        $stmt=$pdo->prepare("UPDATE listings SET status=? WHERE id=? AND user_id=?");
        $stmt->execute([$newStatus,(int)$_POST['listing_id'],current_user_id()]);
        set_flash("Listing status updated.");
    }
    header("Location: my_listings.php"); exit;
}
$stmt=$pdo->prepare("SELECT * FROM listings WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([current_user_id()]); $items=$stmt->fetchAll();
$stmt=$pdo->prepare("SELECT i.created_at,u.name,u.email,l.title FROM interests i JOIN users u ON u.id=i.user_id JOIN listings l ON l.id=i.listing_id WHERE l.user_id=? ORDER BY i.created_at DESC");
$stmt->execute([current_user_id()]); $interests=$stmt->fetchAll();
$page_title="My Listings";
require "includes/header.php";
?>
<section class="page-intro"><span class="eyebrow">Your EcoSwap activity</span><h1>My Listings</h1><p>Manage the items you have shared and check who is interested.</p><a class="button" href="add_listing.php">＋ Add New Item</a></section>
<h2 class="subheading">Items you shared</h2><div class="table-wrap"><table><tr><th>Item</th><th>Category</th><th>Status</th><th>Update</th></tr>
<?php foreach($items as $item): ?><tr><td><?= h($item['title']) ?></td><td><?= h($item['category']) ?></td><td><span class="status"><?= h(ucfirst($item['status'])) ?></span></td><td><form method="post" class="inline-form"><input type="hidden" name="listing_id" value="<?= (int)$item['id'] ?>"><select name="new_status"><option value="available" <?= $item['status']==='available'?'selected':'' ?>>Available</option><option value="claimed" <?= $item['status']==='claimed'?'selected':'' ?>>Claimed</option></select><button class="button tiny">Save</button></form></td></tr><?php endforeach; ?>
<?php if(!$items): ?><tr><td colspan="4">You have not shared any items yet.</td></tr><?php endif; ?></table></div>
<h2 class="subheading">Interest received</h2><div class="table-wrap"><table><tr><th>Item</th><th>Interested member</th><th>Email</th><th>Date</th></tr>
<?php foreach($interests as $interest): ?><tr><td><?= h($interest['title']) ?></td><td><?= h($interest['name']) ?></td><td><?= h($interest['email']) ?></td><td><?= h($interest['created_at']) ?></td></tr><?php endforeach; ?>
<?php if(!$interests): ?><tr><td colspan="4">No one has expressed interest yet.</td></tr><?php endif; ?></table></div>
<?php require "includes/footer.php"; ?>
