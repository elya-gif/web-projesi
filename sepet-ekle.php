<?php
session_start();

$urun_id = $_POST['urun_id'];
$ad = $_POST['ad'];
$fiyat = $_POST['fiyat'];
$gorsel = $_POST['gorsel'];
$adet = 1;

// Sepet yoksa oluştur
if (!isset($_SESSION['sepet'])) {
    $_SESSION['sepet'] = [];
}

// Ürün zaten sepette varsa adedi artır, yoksa ekle
if (isset($_SESSION['sepet'][$urun_id])) {
    $_SESSION['sepet'][$urun_id]['adet']++;
} else {
    $_SESSION['sepet'][$urun_id] = [
        'id'     => $urun_id,
        'ad'     => $ad,
        'fiyat'  => $fiyat,
        'gorsel' => $gorsel,
        'adet'   => $adet
    ];
}

header('Location: sepet.php');
exit;
?>