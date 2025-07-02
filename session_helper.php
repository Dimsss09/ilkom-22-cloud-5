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
