<?php
// session_helper.php
// Fungsi bantu untuk mengelola session pengguna
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}
function getCurrentUsername() {
    return isUserLoggedIn() ? $_SESSION['username'] : null;
}
function redirectIfNotLoggedIn($redirectTo = 'login.php') {
    if (!isUserLoggedIn()) {
        header("Location: $redirectTo");
        exit;
    }
}
function logoutUser() {
    session_unset();
    session_destroy();
}
?>
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}
function unsetSession($key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

function isUserRole($expectedRole) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $expectedRole;
}

function redirectBasedOnRole() {
    if (!isset($_SESSION['role'])) return;

    if ($_SESSION['role'] === 'admin') {
        header('Location: admin-dashboard.php');
        exit;
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: user-dashboard.php');
        exit;
    }
}
?> 
