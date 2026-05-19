<?php
include 'auth-check.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: urun-listesi.php');
    exit;
}

$silId = (int)$_GET['id'];

try {
    $pdo->prepare('DELETE FROM urunler WHERE id = ?')->execute([$silId]);
    header('Location: urun-listesi.php?mesaj=silindi');
    exit;
} catch (PDOException $e) {
    $hataMesaji = urlencode("İşlem sırasında bir hata oluştu.");
    header('Location: urun-listesi.php?hata=' . $hataMesaji);
    exit;

    // die('<pre>' . print_r($e->getMessage(), true) . '</pre>');
}
?>
