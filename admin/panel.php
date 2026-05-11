<?php
include 'auth-check.php';

$toplamUrun = $pdo->query('SELECT COUNT(*) FROM urunler')->fetchColumn();
$toplamSiparis = $pdo->query('SELECT COUNT(*) FROM siparisler')->fetchColumn();
$toplamUye = $pdo->query('SELECT COUNT(*) FROM kullanicilar')->fetchColumn();
$bekleyenSiparis = $pdo->query("SELECT COUNT(*) FROM siparisler WHERE durum = 'bekliyor'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel | Megay Moda</title>
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
    .stat-card {
        background: #fff; border: 1px solid #e8e8e8;
        border-radius: 8px; padding: 1.5rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
    .stat-label { font-size: .8rem; color: #888; margin-top: .2rem; }
    .quick-link {
        display: block; background: #fff; border: 1px solid #e8e8e8;
        border-radius: 8px; padding: 1rem 1.2rem; text-decoration: none;
        color: #111; transition: .15s; margin-bottom: .6rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .quick-link:hover { border-color: #000; color: #000; }
    .quick-link span { font-size: .85rem; font-weight: 600; }
</style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="brand">Megay Admin</div>
    <a href="panel.php" class="active">📊 Panel</a>
    <a href="urun-listesi.php">📦 Ürünler</a>
    <a href="urun-ekle.php">➕ Ürün Ekle</a>
    <a href="siparisler.php">🛒 Siparişler</a>
    <a href="../sayfalist.php" style="margin-top:auto; position:absolute; bottom:1rem;">← Siteye Dön</a>
</aside>

<main class="admin-main">
    <div class="admin-header">
        <h1>Genel Bakış</h1>
        <small class="text-muted"><?php echo date('d.m.Y H:i'); ?></small>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff3e0;">📦</div>
                <div>
                    <div class="stat-value"><?php echo $toplamUrun; ?></div>
                    <div class="stat-label">Toplam Ürün</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#e8f5e9;">🛒</div>
                <div>
                    <div class="stat-value"><?php echo $toplamSiparis; ?></div>
                    <div class="stat-label">Toplam Sipariş</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#e3f2fd;">👤</div>
                <div>
                    <div class="stat-value"><?php echo $toplamUye; ?></div>
                    <div class="stat-label">Toplam Üye</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fce4ec;">⏳</div>
                <div>
                    <div class="stat-value"><?php echo $bekleyenSiparis; ?></div>
                    <div class="stat-label">Bekleyen Sipariş</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <h6 class="text-muted text-uppercase mb-2" style="font-size:.75rem; letter-spacing:.1em;">Hızlı Erişim</h6>
            <a class="quick-link" href="urun-ekle.php">
                <span>➕ Yeni Ürün Ekle</span><span>→</span>
            </a>
            <a class="quick-link" href="urun-listesi.php">
                <span>📦 Ürün Listesi</span><span>→</span>
            </a>
            <a class="quick-link" href="siparisler.php">
                <span>🛒 Siparişleri Görüntüle</span><span>→</span>
            </a>
        </div>
    </div>
</main>

</body>
</html>