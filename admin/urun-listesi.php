<?php
// Olası hataları ekrana yazdırması için (Siyah/beyaz ekranı engeller)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'auth-check.php';

// Silme işlemi
if (isset($_GET['sil'])) {
    $silId = (int)$_GET['sil'];

    // --- 1. FİZİKSEL DOSYALARI SİLME BÖLÜMÜ ---
    $stmtGorsel = $pdo->prepare('SELECT gorsel FROM urunler WHERE id = ?');
    $stmtGorsel->execute([$silId]);
    $silinecekUrun = $stmtGorsel->fetch(PDO::FETCH_ASSOC);

    if ($silinecekUrun && !empty($silinecekUrun['gorsel'])) {
        $gorsel_verisi = (string)$silinecekUrun['gorsel'];
        $gorseller = json_decode($gorsel_verisi, true);

        // __DIR__ bulunduğumuz klasörü (admin) verir. /../ ile bir üst klasöre çıkıp uploads'a gireriz.
        if (is_array($gorseller)) {
            foreach ($gorseller as $gorsel_yolu) {
                $tam_yol = __DIR__ . '/../' . $gorsel_yolu; 
                if (file_exists($tam_yol) && is_file($tam_yol)) {
                    unlink($tam_yol); // Sunucudan dosyayı sil
                }
            }
        } 
        else {
            if (strpos($gorsel_verisi, 'uploads/') !== false) {
                $tam_yol = __DIR__ . '/../' . $gorsel_verisi;
            } else {
                $tam_yol = __DIR__ . '/../images/' . $gorsel_verisi;
            }
            
            if (file_exists($tam_yol) && is_file($tam_yol)) {
                unlink($tam_yol);
            }
        }
    }

    // --- 2. VERİTABANINDAN GÜVENLİ SİLME İŞLEMİ ---
    try {
        // Varsa bu ürüne ait sipariş kayıtlarını sil
        $pdo->prepare('DELETE FROM siparis_urunler WHERE urun_id = ?')->execute([$silId]);
        
        // Varsa eski sisteme ait ek görsel kayıtlarını sil
        $pdo->prepare('DELETE FROM urun_gorselleri WHERE urun_id = ?')->execute([$silId]);

        // Artık ana ürünü güvenle silebiliriz
        $pdo->prepare('DELETE FROM urunler WHERE id = ?')->execute([$silId]);
        
        header('Location: urun-listesi.php?mesaj=silindi');
        exit;
    } catch (PDOException $e) {
        $hataMesaji = urlencode("Bu ürün silinemiyor çünkü başka kayıtlarla bağlantısı var.");
        header('Location: urun-listesi.php?hata=' . $hataMesaji);
        exit;
    }
}

// Ürünleri çekme 
$stmt = $pdo->query('SELECT * FROM urunler ORDER BY id DESC');
$urunler = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ürün Listesi | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #f8f8f8; font-family: 'Segoe UI', sans-serif; }
    .admin-sidebar {
        width: 220px; min-height: 100vh; background: #1a1a1a;
        position: fixed; top: 0; left: 0; padding-top: 1.5rem;
    }
    .admin-sidebar .brand {
        color: #fff; font-size: 1.1rem; font-weight: 700;
        letter-spacing: .15em; text-transform: uppercase;
        padding: 0 1.2rem 1.5rem; border-bottom: 1px solid #333;
    }
    .admin-sidebar a {
        display: block; color: #aaa; text-decoration: none;
        padding: .75rem 1.2rem; font-size: .85rem;
        letter-spacing: .05em; transition: .15s;
    }
    .admin-sidebar a:hover, .admin-sidebar a.active { color: #fff; background: #2a2a2a; }
    .admin-sidebar a.active { border-left: 3px solid #c9a063; }
    .admin-main { margin-left: 220px; padding: 2rem; }
    .admin-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 2rem;
    }
    .admin-header h1 { font-size: 1.3rem; font-weight: 700; margin: 0; }
    .urun-table { background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e8e8e8; }
    .urun-table th {
        background: #1a1a1a; color: #fff; font-size: .75rem;
        text-transform: uppercase; letter-spacing: .08em; padding: .75rem 1rem;
        font-weight: 600;
    }
    .urun-table td { padding: .75rem 1rem; vertical-align: middle; font-size: .88rem; border-bottom: 1px solid #f0f0f0; }
    .urun-table tr:last-child td { border-bottom: none; }
    .urun-table img { width: 48px; height: 64px; object-fit: cover; border-radius: 4px; background: #f5f5f5; }
    .btn-duzenle {
        background: #000; color: #fff; border: none;
        padding: .35rem .8rem; font-size: .75rem;
        text-decoration: none; border-radius: 4px;
        letter-spacing: .05em;
    }
    .btn-duzenle:hover { background: #333; color: #fff; }
    .btn-sil {
        background: #fff; color: #e63946; border: 1px solid #e63946;
        padding: .35rem .8rem; font-size: .75rem;
        text-decoration: none; border-radius: 4px;
        letter-spacing: .05em;
    }
    .btn-sil:hover { background: #e63946; color: #fff; }
    .btn-ekle {
        background: #000; color: #fff; border: none;
        padding: .5rem 1.2rem; font-size: .8rem;
        text-decoration: none; border-radius: 4px;
        letter-spacing: .08em; text-transform: uppercase;
    }
    .btn-ekle:hover { background: #333; color: #fff; }
    .stok-az { color: #e63946; font-weight: 600; }
    .stok-ok { color: #2ecc71; font-weight: 600; }
</style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="brand">Megay Admin</div>
    <a href="panel.php">📊 Panel</a>
    <a href="urun-listesi.php" class="active">📦 Ürünler</a>
    <a href="urun-ekle.php">➕ Ürün Ekle</a>
    <a href="siparisler.php">🛒 Siparişler</a>
    <a href="../index.php" style="position:absolute; bottom:1rem;">← Siteye Dön</a>
</aside>

<main class="admin-main">
    <div class="admin-header">
        <h1>Ürün Listesi <span class="text-muted" style="font-size:.9rem;">(<?php echo count($urunler); ?> ürün)</span></h1>
        <a href="urun-ekle.php" class="btn-ekle">+ Yeni Ürün</a>
    </div>

    <?php if (isset($_GET['mesaj'])): ?>
        <div class="alert alert-success py-2 mb-3" style="font-size:.85rem;">
            <?php
            $mesajlar = ['silindi' => 'Ürün başarıyla silindi.', 'guncellendi' => 'Ürün güncellendi.', 'eklendi' => 'Ürün eklendi.'];
            echo $mesajlar[$_GET['mesaj']] ?? '';
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['hata'])): ?>
        <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem;">
            <?php echo htmlspecialchars($_GET['hata']); ?>
        </div>
    <?php endif; ?>

    <div class="urun-table">
        <table class="w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Görsel</th>
                    <th>Ürün Adı</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($urunler as $urun): 
                    
                    // --- LİSTE İÇİN GÖRSEL AYARLAMA ---
                    $liste_gorseli = '../images/placeholder.jpg'; 
                    
                    $gorsel_metni = (string)($urun['gorsel'] ?? ''); 
                    $cozulen_gorsel = json_decode($gorsel_metni, true);
                    
                    if (is_array($cozulen_gorsel) && !empty($cozulen_gorsel)) {
                        $liste_gorseli = '../' . $cozulen_gorsel[0]; 
                    } elseif (!empty($gorsel_metni) && !is_array($cozulen_gorsel)) {
                        if (strpos($gorsel_metni, 'uploads/') !== false) {
                            $liste_gorseli = '../' . $gorsel_metni;
                        } else {
                            $liste_gorseli = '../images/' . $gorsel_metni;
                        }
                    }
                ?>
                <tr>
                    <td>#<?php echo $urun['id']; ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($liste_gorseli); ?>" alt="Ürün Görseli">
                    </td>
                    <td><?php echo htmlspecialchars($urun['ad']); ?></td>
                    <td><?php echo htmlspecialchars($urun['kategori']); ?></td>
                    <td><?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL</td>
                    <td class="<?php echo (int)$urun['stok'] <= 3 ? 'stok-az' : 'stok-ok'; ?>">
                        <?php echo (int)$urun['stok']; ?>
                    </td>
                    <td>
                        <a href="urun-duzenle.php?id=<?php echo $urun['id']; ?>" class="btn-duzenle">Düzenle</a>
                        <a href="urun-sil.php?id=<?php echo $urun['id']; ?>"
                           class="btn-sil ms-1"
                           onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>