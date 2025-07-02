<?php
// csrf_helper.php
// Fungsi bantu untuk melindungi form dari serangan CSRF (Cross Site Request Forgery)

/**
 * Membuat token CSRF dan menyimpannya di session
 *
 * Token ini digunakan untuk melindungi form dari submit palsu dari luar situs
 *
 * @return string Token yang dibuat
 */
function generateCSRFToken() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Buat token acak dan simpan di session
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;

    return $token;
}

/**
 * Mengecek apakah token yang dikirim dari form sesuai dengan token di session
 *
 * @param string $token Token dari form
 * @return bool Apakah token valid
 */
function validateCSRFToken($token) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Menampilkan input hidden yang berisi token CSRF
 * Digunakan di dalam tag <form>
 *
 * Contoh pemakaian:
 * <form method="post">
 *     <?= csrfInput(); ?>
 *     ...
 * </form>
 *
 * @return string
 */
function csrfInput() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}
