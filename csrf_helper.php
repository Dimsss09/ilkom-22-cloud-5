<?php
// csrf_helper.php
// Fungsi bantu untuk melindungi form dari serangan CSRF

/**
 * Membuat token CSRF dan menyimpannya di session
 */
function generateCSRFToken() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf_token'];
}

function getCSRFTokenInput() {
    $token = generateCSRFToken();
    return "<input type='hidden' name='csrf_token' value='$token'>";
}

/**
 * Verifikasi token CSRF dari request
 */
function verifyCSRFToken($submittedToken) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['_csrf_token']) || $submittedToken !== $_SESSION['_csrf_token']) {
        return false;
    }

    return true;
}
