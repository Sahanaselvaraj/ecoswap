<?php
require_once "includes/db.php";
require_once "includes/functions.php";
if (is_logged_in()) { header("Location: index.php"); exit; }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = "Enter your name, a valid email, and a password with at least 6 characters.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            set_flash("Account created successfully. Please log in.");
            header("Location: login.php"); exit;
        } catch (PDOException $e) { $error = "This email may already be registered."; }
    }
}
$page_title = "Register";
require "includes/header.php";
?>
<div class="form-wrap"><div class="form-card"><span class="eyebrow">Become a member</span><h1>Create your account</h1><p>Join the community and give useful things a new home.</p>
<?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
<form method="post">
<label>Full name<input type="text" name="name" required maxlength="100" value="<?= h($_POST['name'] ?? '') ?>"></label>
<label>Email address<input type="email" name="email" required value="<?= h($_POST['email'] ?? '') ?>"></label>
<label>Password<input type="password" name="password" required minlength="6"></label>
<button class="button full" type="submit">Create Account</button>
</form><p class="form-bottom">Already a member? <a href="login.php">Login</a></p></div></div>
<?php require "includes/footer.php"; ?>
