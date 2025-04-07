<?php
session_start();
// Logout otomatis saat masuk ke index.php
session_unset();
session_destroy();
?>
