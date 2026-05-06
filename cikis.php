<?php
session_start();
session_destroy();

$defaultRedirect = 'giris.php';
$allowedRedirects = ['giris.php', 'index.php'];

$redirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : $defaultRedirect;
if (!in_array($redirect, $allowedRedirects, true)) {
    $redirect = $defaultRedirect;
}

header("Location: " . $redirect);
exit;
?>