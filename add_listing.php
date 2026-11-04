<?php
require_once "includes/db.php";
require_once "includes/functions.php";
require_login();
$error = "";
$categories = ['Books','Clothing','Furniture','Electronics','Gardening','Home & Kitchen','Other'];
$restricted = "Do not list damaged batteries, hazardous chemicals, weapons, medicines, or other dangerous/illegal items.";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $condition = $_POST['item_condition'] ?? 'Good';
    $location = trim($_POST['location'] ?? '');
    if ($title === '' || $description === '' || $location === '' || !in_array($category, $categories, true)) {
        $error = "Please complete all fields.";
    } elseif (preg_match('/battery|chemical|pesticide|poison|weapon|explosive/i', $title . ' ' . $description)) {
        $error = "This item may be unsafe and cannot be listed on EcoSwap.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO listings (user_id,title,category,description,item_condition,location) VALUES (?,?,?,?,?,?)");
        $stmt->execute([current_user_id(), $title, $category, $description, $condition, $location]);
        set_flash("Your item has been listed!");
        header("Location: my_listings.php"); exit;
    }
}
$page_title = "Add Item";
require "includes/header.php";
?>
<div class="form-wrap wide"><div class="form-card"><span class="eyebrow">Share something useful</span><h1>Add a new item</h1><p>Describe the item clearly so another member can decide if it is useful.</p>
<?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
<form method="post">
<label>Item name<input name="title" maxlength="150" required value="<?= h($_POST['title'] ?? '') ?>"></label>
<label>Category<select name="category" required><option value="">Choose a category</option><?php foreach ($categories as $cat): ?><option <?= (($_POST['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= h($cat) ?></option><?php endforeach; ?></select></label>
<label>Condition<select name="item_condition"><option>Like New</option><option selected>Good</option><option>Used</option></select></label>
<label>Pickup location<input name="location" maxlength="150" required placeholder="Area / city"></label>
<label>Description<textarea name="description" rows="5" required maxlength="1500"><?= h($_POST['description'] ?? '') ?></textarea></label>
<div class="safety-note">Safety reminder: <?= h($restricted) ?></div>
<button class="button full" type="submit">Publish Listing</button></form></div></div>
<?php require "includes/footer.php"; ?>
