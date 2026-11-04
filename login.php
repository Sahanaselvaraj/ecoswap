<?php
require_once "includes/db.php";
require_once "includes/functions.php";
if (is_logged_in()) { header("Location: index.php"); exit; }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php"); exit;
    } else { $error = "Incorrect email or password."; }
}
$page_title = "Login";
require "includes/header.php";
?>
<div class="form-wrap"><div class="form-card"><span class="eyebrow">Welcome back</span><h1>Login to EcoSwap</h1><p>Continue sharing and discovering useful items.</p>
<?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
<form method="post"><label>Email address<input type="email" name="email" required></label><label>Password<input type="password" name="password" required></label><button class="button full" type="submit">Login</button></form>
<p class="form-bottom">New to EcoSwap? <a href="register.php">Create an account</a></p></div></div>
<?php require "includes/footer.php"; ?>
