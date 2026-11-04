<?php
require_once "includes/db.php";
require_once "includes/functions.php";
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: listing.php"); exit; }
$listing_id = (int)($_POST['listing_id'] ?? 0);
$stmt=$pdo->prepare("SELECT * FROM listings WHERE id=? AND status='available'");
$stmt->execute([$listing_id]); $item=$stmt->fetch();
if (!$item) { set_flash("This item is no longer available."); header("Location: listing.php"); exit; }
if ((int)$item['user_id'] === (int)current_user_id()) { set_flash("You cannot request your own item."); header("Location: listing.php"); exit; }
try {
    $stmt=$pdo->prepare("INSERT INTO interests (listing_id,user_id) VALUES (?,?)");
    $stmt->execute([$listing_id,current_user_id()]);
    set_flash("Interest sent! The item owner can see your request.");
} catch (PDOException $e) { set_flash("You have already expressed interest in this item."); }
header("Location: listing.php"); exit;
