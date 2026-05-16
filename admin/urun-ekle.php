<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//include 'auth-check.php';
include '../config.php';
 
$hata   = '';
$basari = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad       = trim($_POST['ad'] ?? '');
    $fiyat    = $_POST['fiyat'] ?? '';
    $kategori = trim($_POST['kategori'] ?? '');
    $stok     = (int)($_POST['stok'] ?? 0);
    $aciklama = trim($_POST['aciklama'] ?? '');
 
    $yuklenen_gorseller = [];
    $izin_verilen_tipler = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $max_boyut           = 5 * 1024 * 1024; // 5MB
 
    // uploads/ klasörü yoksa oluştur
    if (!is_dir('../uploads/')) {
        mkdir('../uploads/', 0755, true);
    }

    // Dosya Yükleme Fonksiyonu (Kod tekrarını önlemek için)
    function gorselYukle($dosya_adi_orj, $dosya_tmp, $dosya_boyut, $dosya_hata) {
        global $izin_verilen_tipler, $max_boyut, $hata;
        
        if ($dosya_hata === UPLOAD_ERR_OK) {
            $uzanti = strtolower(pathinfo($dosya_adi_orj, PATHINFO_EXTENSION));

            if (!in_array($uzanti, $izin_verilen_tipler)) {
                $hata = "Sadece JPG, PNG, WEBP veya GIF yükleyebilirsiniz: $dosya_adi_orj";
                return false;
            } elseif ($dosya_boyut > $max_boyut) {
                $hata = "Görsel boyutu 5MB'dan büyük olamaz: $dosya_adi_orj";
                return false;
            } else {
                $yeni_dosya_adi = uniqid('urun_', true) . '.' . $uzanti;
                $hedef          = '../uploads/' . $yeni_dosya_adi;

                if (move_uploaded_file($dosya_tmp, $hedef)) {
                    return 'uploads/' . $yeni_dosya_adi;
                } else {
                    $hata = "Görsel yüklenemedi. Klasör iznini kontrol edin: $dosya_adi_orj";
                    return false;
                }
            }
        }
        return false;
    }

    // 1. ANA GÖRSELİ YÜKLE
    if (!empty($_FILES['ana_gorsel']['name'])) {
        $yol = gorselYukle(
            $_FILES['ana_gorsel']['name'], 
            $_FILES['ana_gorsel']['tmp_name'], 
            $_FILES['ana_gorsel']['size'], 
            $_FILES['ana_gorsel']['error']
        );
        if ($yol) $yuklenen_gorseller[] = $yol; // İlk sıraya ekle
    }

    // 2. EK GÖRSELLERİ YÜKLE (Çoklu)
    if (!empty($_FILES['ek_gorseller']['name'][0])) {
        $dosya_sayisi = count($_FILES['ek_gorseller']['name']);
        
        for ($i = 0; $i < $dosya_sayisi; $i++) {
            $yol = gorselYukle(
                $_FILES['ek_gorseller']['name'][$i], 
                $_FILES['ek_gorseller']['tmp_name'][$i], 
                $_FILES['ek_gorseller']['size'][$i], 
                $_FILES['ek_gorseller']['error'][$i]
            );
            if ($yol) $yuklenen_gorseller[] = $yol; // Devamına ekle
        }
    }
 
    // --- Zorunlu alan kontrolü ve kayıt ---
    if (empty($hata)) {
        if (empty($ad) || empty($fiyat) || empty($kategori)) {
            $hata = 'Lütfen tüm zorunlu alanları doldurun.';
        } elseif (empty($yuklenen_gorseller)) {
            $hata = 'Lütfen en az bir ana görsel yükleyin.';
        } else {
            // Görseller dizisini veritabanına JSON formatında kaydet
            $gorsel_json = json_encode($yuklenen_gorseller, JSON_UNESCAPED_UNICODE);

            $stmt = $pdo->prepare('INSERT INTO urunler (ad, fiyat, kategori, stok, gorsel, aciklama) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$ad, $fiyat, $kategori, $stok, $gorsel_json, $aciklama]);
            $basari = 'Ürün başarıyla eklendi!';
        }
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
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { padding: 12px 30px; background: #000; color: #fff; border: none; cursor: pointer; border-radius: 4px; margin-top: 10px; }
        button:hover { background: #333; }
        .hata   { color: red;   margin-bottom: 15px; font-weight: bold; }
        .basari { color: green; margin-bottom: 15px; font-weight: bold; }
        .onizleme-kutu { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px; }
        .onizleme-kutu img { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
        label { font-weight: bold; display: block; margin-bottom: 6px; font-size: 0.95em; }
        .gorsel-alani { background: #f9f9f9; padding: 15px; border: 1px solid #eee; border-radius: 6px; margin-bottom: 15px; }
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
 
        <label>Ürün Adı *</label>
        <input type="text" name="ad" placeholder="Örn: Siyah Blazer Ceket" required
               value="<?= htmlspecialchars($_POST['ad'] ?? '') ?>">
 
        <label>Fiyat (₺) *</label>
        <input type="number" name="fiyat" placeholder="299.90" step="0.01" min="0" required
               value="<?= htmlspecialchars($_POST['fiyat'] ?? '') ?>">
 
        <label>Kategori *</label>
        <input type="text" name="kategori" placeholder="elbiseler, toplar vb." required
               value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>">
 
        <label>Stok</label>
        <input type="number" name="stok" placeholder="0" min="0"
               value="<?= htmlspecialchars($_POST['stok'] ?? '0') ?>">
 
        <label>Ürün Açıklaması</label>
        <textarea name="aciklama" rows="4" placeholder="Ürün hakkında kısa bilgi..."><?= htmlspecialchars($_POST['aciklama'] ?? '') ?></textarea>
 
        <div class="gorsel-alani">
            <label>1. Ana Görsel (Kapak Fotoğrafı) *</label>
            <input type="file" name="ana_gorsel" accept="image/*" id="ana_gorsel_input" required>
            <div class="onizleme-kutu" id="ana_onizleme"></div>

            <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">

            <label>2. Ek Görseller (İsteğe Bağlı - Birden fazla seçebilirsiniz)</label>
            <p style="font-size: 0.8em; color: #666; margin-top:-5px;">*Birden fazla görsel seçmek için CTRL tuşuna basılı tutarak tıklayın veya fareyle sürükleyin.</p>
            <input type="file" name="ek_gorseller[]" accept="image/*" id="ek_gorseller_input" multiple>
            <div class="onizleme-kutu" id="ek_onizleme"></div>
        </div>
 
        <button type="submit">Ürün Ekle</button>
    </form>
 
    <script>
        // Ana Görsel Önizleme
        document.getElementById('ana_gorsel_input').addEventListener('change', function () {
            const div = document.getElementById('ana_onizleme');
            div.innerHTML = ''; 
            if (this.files[0]) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[0]);
                div.appendChild(img);
            }
        });

        // Ek Görseller Önizleme
        document.getElementById('ek_gorseller_input').addEventListener('change', function () {
            const div = document.getElementById('ek_onizleme');
            div.innerHTML = ''; 
            Array.from(this.files).forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                div.appendChild(img);
            });
        });
    </script>
</body>
</html>