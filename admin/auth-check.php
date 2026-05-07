<?php
session_start();
include '../config.php';

if (!isset($_SESSION['kullanici_id'])) {
    header('Location: ../giris.php');
    exit;
}

// Rol kontrolü
$stmt = $pdo->prepare('SELECT rol FROM kullanicilar WHERE id = ?');
$stmt->execute([$_SESSION['kullanici_id']]);
$kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kullanici || $kullanici['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>