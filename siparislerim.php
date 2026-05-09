<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['kullanici_id'])) {
    header('Location: giris.php');
    exit;
}

include 'config.php';

$kullanici_id = (int) $_SESSION['kullanici_id'];

$stmt = $pdo->prepare('
    SELECT id, toplam, durum, tarih
    FROM siparisler
    WHERE kullanici_id = ?
    ORDER BY id DESC
');
$stmt->execute([$kullanici_id]);
$siparisler = $stmt->fetchAll(PDO::FETCH_ASSOC);

$durumRenk = [
    'odendi'         => '#2ecc71',
    'bekliyor'       => '#f39c12',
    'hazirlaniyor'   => '#3498db',
    'kargoda'        => '#9b59b6',
    'teslim edildi'  => '#2ecc71',
    'iptal'          => '#e63946',
];

include 'header.php';
?>

<style>
    :root { --border-soft: #e6e6e6; }
    body { background: #fff !important; color: #111; }
    .siparislerim-page { min-height: 100vh; padding: 3rem 1rem 4rem; }
    .page-title {
        font-size: 1.3rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; margin-bottom: 1.6rem;
    }
    .siparis-kart {
        border: 1px solid var(--border-soft); margin-bottom: 1rem;
        background: #fff;
    }
    .siparis-kart-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: .9rem 1.2rem; border-bottom: 1px solid var(--border-soft);
        flex-wrap: wrap; gap: .5rem;
    }
    .siparis-no { font-size: .85rem; font-weight: 700; letter-spacing: .04em; }
    .siparis-tarih { font-size: .78rem; color: #888; }
    .durum-badge {
        display: inline-block; padding: .22rem .7rem;
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #fff; border-radius: 999px;
    }
    .siparis-kart-body { padding: .9rem 1.2rem; }
    .urun-satir {
        display: flex; justify-content: space-between; align-items: center;
        padding: .45rem 0; border-bottom: 1px solid var(--border-soft);
        font-size: .87rem; gap: 1rem;
    }
    .urun-satir:last-child { border-bottom: none; }
    .urun-ad { font-weight: 600; }
    .urun-meta { font-size: .76rem; color: #888; margin-top: .1rem; }
    .urun-fiyat { white-space: nowrap; font-size: .85rem; }
    .siparis-toplam {
        display: flex; justify-content: flex-end;
        font-size: .9rem; font-weight: 700;
        padding-top: .75rem; margin-top: .25rem;
        border-top: 1px solid #111;
    }
    .bos-mesaj {
        text-align: center; padding: 4rem 1rem;
        color: #888; font-size: .95rem;
    }
    .btn-alisveris {
        display: inline-block; margin-top: 1rem;
        padding: .75rem 1.5rem; background: #000; color: #fff;
        text-decoration: none; font-size: .75rem;
        text-transform: uppercase; letter-spacing: .1em; font-weight: 700;
        border: 1px solid #000;
    }
    .btn-alisveris:hover { background: #222; color: #fff; }
</style>

<main class="siparislerim-page">
    <div class="container" style="max-width:760px;">
        <h1 class="page-title">Siparişlerim</h1>

        <?php if (empty($siparisler)): ?>
            <div class="siparis-kart bos-mesaj">
                <p>Henüz hiç siparişin yok.</p>
                <a href="sayfalist.php" class="btn-alisveris">Alışverişe başla</a>
            </div>
        <?php else: ?>
            <?php foreach ($siparisler as $siparis): ?>
                <?php
                $stmt2 = $pdo->prepare('
                    SELECT su.adet, su.fiyat, u.ad
                    FROM siparis_urunler su
                    JOIN urunler u ON u.id = su.urun_id
                    WHERE su.siparis_id = ?
                ');
                $stmt2->execute([$siparis['id']]);
                $urunler = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $renk = $durumRenk[$siparis['durum']] ?? '#888';
                ?>
                <div class="siparis-kart">
                    <div class="siparis-kart-header">
                        <div>
                            <div class="siparis-no">#<?php echo $siparis['id']; ?></div>
                            <div class="siparis-tarih"><?php echo htmlspecialchars($siparis['tarih'] ?? '-'); ?></div>
                        </div>
                        <span class="durum-badge" style="background:<?php echo $renk; ?>">
                            <?php echo htmlspecialchars($siparis['durum']); ?>
                        </span>
                    </div>
                    <div class="siparis-kart-body">
                        <?php foreach ($urunler as $u): ?>
                            <div class="urun-satir">
                                <div>
                                    <div class="urun-ad"><?php echo htmlspecialchars($u['ad']); ?></div>
                                    <div class="urun-meta">Adet: <?php echo (int)$u['adet']; ?></div>
                                </div>
                                <div class="urun-fiyat">
                                    <?php echo number_format($u['fiyat'] * $u['adet'], 2, ',', '.'); ?> TL
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="siparis-toplam">
                            Toplam: <?php echo number_format($siparis['toplam'], 2, ',', '.'); ?> TL
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
