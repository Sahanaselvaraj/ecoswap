<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}
function current_user_id() {
    return $_SESSION['user_id'] ?? 0;
}
function set_flash($message) {
    $_SESSION['flash'] = $message;
}
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        echo '<div class="notice">'.h($_SESSION['flash']).'</div>';
        unset($_SESSION['flash']);
    }
}
