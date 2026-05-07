<?php
include 'auth-check.php';
include '../config.php';

$hata = '';
$basari = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = trim($_POST['ad']);
    $fiyat = $_POST['fiyat'];
    $kategori = trim($_POST['kategori']);
    $stok = (int)$_POST['stok'];
    $aciklama = trim($_POST['aciklama']);

    // Görsel yükleme
    $gorsel = '';
    if (!empty($_FILES['gorsel']['name'])) {
        $hedef = '../uploads/' . basename($_FILES['gorsel']['name']);
        if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $hedef)) {
            $gorsel = 'uploads/' . basename($_FILES['gorsel']['name']);
        }
    }

    if (empty($ad) || empty($fiyat) || empty($kategori)) {
        $hata = 'Lütfen tüm zorunlu alanları doldurun.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO urunler (ad, fiyat, kategori, stok, gorsel, aciklama) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$ad, $fiyat, $kategori, $stok, $gorsel, $aciklama]);
        $basari = 'Ürün başarıyla eklendi!';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Ekle | Admin</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; }
        input, select, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; }
        button { padding: 12px 30px; background: #000; color: #fff; border: none; cursor: pointer; }
        .hata { color: red; margin-bottom: 15px; }
        .basari { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Ürün Ekle</h2>

    <?php if (!empty($hata)): ?>
        <p class="hata"><?= htmlspecialchars($hata) ?></p>
    <?php endif; ?>
    <?php if (!empty($basari)): ?>
        <p class="basari"><?= htmlspecialchars($basari) ?></p>
    <?php endif; ?>

    <form action="urun-ekle.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="ad" placeholder="Ürün Adı" required>
        <input type="number" name="fiyat" placeholder="Fiyat" step="0.01" required>
        <input type="text" name="kategori" placeholder="Kategori (elbiseler, toplar vb.)" required>
        <input type="number" name="stok" placeholder="Stok" value="0">
        <textarea name="aciklama" placeholder="Ürün Açıklaması" rows="4"></textarea>
        <input type="file" name="gorsel" accept="image/*">
        <button type="submit">Ürün Ekle</button>
    </form>
</body>
</html>