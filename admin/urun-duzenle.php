<?php
include 'auth-check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM urunler WHERE id = ?');
$stmt->execute([$id]);
$urun = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$urun) {
    header('Location: urun-listesi.php');
    exit;
}

$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad       = trim($_POST['ad']);
    $fiyat    = (float)$_POST['fiyat'];
    $kategori = trim($_POST['kategori']);
    $stok     = (int)$_POST['stok'];
    $aciklama = trim($_POST['aciklama']);
    $gorsel   = $urun['gorsel'];

    // Yeni görsel yüklendiyse
    if (!empty($_FILES['gorsel']['name'])) {
        $izinliUzantilar = ['jpg', 'jpeg', 'png', 'webp'];
        $uzanti = strtolower(pathinfo($_FILES['gorsel']['name'], PATHINFO_EXTENSION));
        if (in_array($uzanti, $izinliUzantilar)) {
            $yeniAd = uniqid('urun_') . '.' . $uzanti;
            if (move_uploaded_file($_FILES['gorsel']['tmp_name'], "../uploads/$yeniAd")) {
                $gorsel = "uploads/".$yeniAd;
            } else {
                $hata = 'Görsel yüklenemedi. Klasör izinlerini kontrol edin.';
            }
        } else {
            $hata = 'Sadece jpg, jpeg, png, webp yüklenebilir.';
        }
    }

    if (!$hata) {
        $stmt = $pdo->prepare('UPDATE urunler SET ad=?, fiyat=?, kategori=?, stok=?, gorsel=?, aciklama=? WHERE id=?');
        $stmt->execute([$ad, $fiyat, $kategori, $stok, $gorsel, $aciklama, $id]);
        header('Location: urun-listesi.php?mesaj=guncellendi');
        exit;
    }
}

$categories = ['elbiseler','ceketler','toplar','bodyler','sortlar','tisortler','etek','gomlek','kazak'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ürün Düzenle | Admin</title>
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
    .form-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 8px; padding: 1.5rem; }
    .form-label { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
    .form-control, .form-select { font-size: .9rem; border-color: #ddd; }
    .form-control:focus, .form-select:focus { border-color: #000; box-shadow: none; }
    .btn-kaydet {
        background: #000; color: #fff; border: none;
        padding: .6rem 1.5rem; font-size: .8rem;
        text-transform: uppercase; letter-spacing: .1em;
        border-radius: 4px;
    }
    .btn-kaydet:hover { background: #333; color: #fff; }
    .gorsel-onizleme { width: 100px; aspect-ratio: 3/4; object-fit: cover; border-radius: 6px; border: 1px solid #e8e8e8; }
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
        <h1>Ürün Düzenle <span class="text-muted" style="font-size:.85rem;">#<?php echo $urun['id']; ?></span></h1>
        <a href="urun-listesi.php" style="font-size:.85rem; color:#666;">← Listeye Dön</a>
    </div>

    <?php if ($hata): ?>
        <div class="alert alert-danger py-2 mb-3" style="font-size:.85rem;"><?php echo htmlspecialchars($hata); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="form-card">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Ürün Adı</label>
                            <input type="text" name="ad" class="form-control" value="<?php echo htmlspecialchars($urun['ad']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fiyat (TL)</label>
                            <input type="number" name="fiyat" step="0.01" class="form-control" value="<?php echo $urun['fiyat']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?php echo $urun['stok']; ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat; ?>" <?php echo $urun['kategori'] === $cat ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($cat); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Açıklama</label>
                            <textarea name="aciklama" class="form-control" rows="3"><?php echo htmlspecialchars($urun['aciklama'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-card">
                    <label class="form-label">Mevcut Görsel</label>
                    <div class="mb-3">
                        <img src="../images/<?php echo htmlspecialchars($urun['gorsel']); ?>"
                             alt="" class="gorsel-onizleme">
                        <div class="mt-1" style="font-size:.78rem; color:#888;"><?php echo htmlspecialchars($urun['gorsel']); ?></div>
                    </div>
                    <label class="form-label">Yeni Görsel Yükle</label>
                    <input type="file" name="gorsel" class="form-control" accept="image/*">
                    <div style="font-size:.75rem; color:#888; margin-top:.4rem;">Boş bırakırsan mevcut görsel korunur.</div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn-kaydet">Kaydet</button>
            </div>
        </div>
    </form>
</main>

</body>
</html>