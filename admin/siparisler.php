<?php
include 'auth-check.php';

// Durum güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['siparis_id'], $_POST['durum'])) {
    $stmt = $pdo->prepare('UPDATE siparisler SET durum = ? WHERE id = ?');
    $stmt->execute([$_POST['durum'], (int)$_POST['siparis_id']]);
    header('Location: siparisler.php?mesaj=guncellendi');
    exit;
}

$siparisler = $pdo->query('
    SELECT s.*, k.ad, k.soyad, k.eposta
    FROM siparisler s
    LEFT JOIN kullanicilar k ON k.id = s.kullanici_id
    ORDER BY s.id DESC
')->fetchAll(PDO::FETCH_ASSOC);

$durumlar = ['bekliyor', 'hazirlaniyor', 'kargoda', 'teslim edildi', 'iptal'];
$durumRenk = [
    'bekliyor'       => '#f39c12',
    'hazirlaniyor'   => '#3498db',
    'kargoda'        => '#9b59b6',
    'teslim edildi'  => '#2ecc71',
    'iptal'          => '#e63946',
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Siparişler | Admin</title>
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
    .siparis-table { background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e8e8e8; }
    .siparis-table th {
        background: #1a1a1a; color: #fff; font-size: .75rem;
        text-transform: uppercase; letter-spacing: .08em;
        padding: .75rem 1rem; font-weight: 600;
    }
    .siparis-table td {
        padding: .75rem 1rem; vertical-align: middle;
        font-size: .88rem; border-bottom: 1px solid #f0f0f0;
    }
    .siparis-table tr:last-child td { border-bottom: none; }
    .durum-badge {
        display: inline-block; padding: .25rem .7rem;
        border-radius: 999px; font-size: .72rem;
        font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #fff;
    }
    .durum-select {
        font-size: .8rem; border: 1px solid #ddd;
        border-radius: 4px; padding: .3rem .5rem;
        background: #fff;
    }
    .btn-guncelle {
        background: #000; color: #fff; border: none;
        padding: .3rem .8rem; font-size: .75rem;
        border-radius: 4px; cursor: pointer;
        text-transform: uppercase; letter-spacing: .05em;
    }
    .btn-guncelle:hover { background: #333; }
    .detay-toggle {
        font-size: .78rem; color: #666; cursor: pointer;
        text-decoration: underline; border: none; background: none;
    }
    .siparis-detay { display: none; background: #fafafa; }
    .siparis-detay td { padding: .5rem 1rem; font-size: .82rem; color: #555; }
</style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="brand">Megay Admin</div>
    <a href="panel.php">📊 Panel</a>
    <a href="urun-listesi.php">📦 Ürünler</a>
    <a href="urun-ekle.php">➕ Ürün Ekle</a>
    <a href="siparisler.php" class="active">🛒 Siparişler</a>
    <a href="../index.php" style="position:absolute; bottom:1rem;">← Siteye Dön</a>
</aside>

<main class="admin-main">
    <div class="admin-header">
        <h1>Siparişler <span class="text-muted" style="font-size:.9rem;">(<?php echo count($siparisler); ?> sipariş)</span></h1>
    </div>

    <?php if (isset($_GET['mesaj'])): ?>
        <div class="alert alert-success py-2 mb-3" style="font-size:.85rem;">
            Sipariş durumu güncellendi.
        </div>
    <?php endif; ?>

    <?php if (empty($siparisler)): ?>
        <div class="siparis-table p-4 text-muted" style="font-size:.9rem;">Henüz sipariş yok.</div>
    <?php else: ?>
    <div class="siparis-table">
        <table class="w-100">
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Müşteri</th>
                    <th>Tarih</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>Güncelle</th>
                    <th>Detay</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siparisler as $siparis): ?>
                <tr>
                    <td>#<?php echo $siparis['id']; ?></td>
                    <td>
                        <div><?php echo htmlspecialchars($siparis['ad'] . ' ' . $siparis['soyad']); ?></div>
                        <div style="font-size:.75rem; color:#888;"><?php echo htmlspecialchars($siparis['eposta']); ?></div>
                    </td>
                    <td><?php echo htmlspecialchars($siparis['tarih'] ?? '-'); ?></td>
                    <td><?php echo number_format($siparis['toplam'], 2, ',', '.'); ?> TL</td>
                    <td>
                        <span class="durum-badge" style="background:<?php echo $durumRenk[$siparis['durum']] ?? '#888'; ?>">
                            <?php echo htmlspecialchars($siparis['durum']); ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" style="display:flex; gap:.4rem; align-items:center;">
                            <input type="hidden" name="siparis_id" value="<?php echo $siparis['id']; ?>">
                            <select name="durum" class="durum-select">
                                <?php foreach ($durumlar as $d): ?>
                                    <option value="<?php echo $d; ?>" <?php echo $siparis['durum'] === $d ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($d); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn-guncelle">Kaydet</button>
                        </form>
                    </td>
                    <td>
                        <button class="detay-toggle" onclick="toggleDetay(<?php echo $siparis['id']; ?>)">
                            Ürünler ▾
                        </button>
                    </td>
                </tr>
                <tr class="siparis-detay" id="detay-<?php echo $siparis['id']; ?>">
                    <td colspan="7">
                        <?php
                        $stmt = $pdo->prepare('
                            SELECT su.adet, su.fiyat, u.ad
                            FROM siparis_urunler su
                            JOIN urunler u ON u.id = su.urun_id
                            WHERE su.siparis_id = ?
                        ');
                        $stmt->execute([$siparis['id']]);
                        $urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($urunler): ?>
                            <table style="width:100%; font-size:.82rem;">
                                <tr style="color:#999;">
                                    <td>Ürün</td><td>Adet</td><td>Fiyat</td><td>Toplam</td>
                                </tr>
                                <?php foreach ($urunler as $u): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($u['ad']); ?></td>
                                    <td><?php echo $u['adet']; ?></td>
                                    <td><?php echo number_format($u['fiyat'], 2, ',', '.'); ?> TL</td>
                                    <td><?php echo number_format($u['fiyat'] * $u['adet'], 2, ',', '.'); ?> TL</td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <span style="color:#aaa;">Ürün bilgisi bulunamadı.</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</main>

<script>
function toggleDetay(id) {
    var row = document.getElementById('detay-' + id);
    row.style.display = row.style.display === 'table-row' ? 'none' : 'table-row';
}
</script>

</body>
</html>