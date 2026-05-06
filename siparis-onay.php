<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';
include "header.php";

$siparis_id = isset($_GET['siparis_no']) ? (int)$_GET['siparis_no'] : 0;

$siparis = null;
$siparis_urunler = [];

if ($siparis_id > 0) {
    // Sipariş bilgilerini çek
    $stmt = $pdo->prepare('SELECT * FROM siparisler WHERE id = ?');
    $stmt->execute([$siparis_id]);
    $siparis = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($siparis) {
        // Sipariş ürünlerini urunler tablosuyla birleştirerek çek
        $stmt2 = $pdo->prepare('
            SELECT su.adet, su.fiyat, u.ad, u.gorsel
            FROM siparis_urunler su
            JOIN urunler u ON u.id = su.urun_id
            WHERE su.siparis_id = ?
        ');
        $stmt2->execute([$siparis_id]);
        $siparis_urunler = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<style>
    :root {
        --bg-main: #ffffff;
        --text-main: #111111;
        --text-muted: #666666;
        --border-soft: #e6e6e6;
    }

    body {
        background: var(--bg-main) !important;
        color: var(--text-main);
    }

    .order-success-page {
        min-height: 100vh;
        padding: 3rem 1rem 4rem;
        background: #fff;
    }

    .success-card {
        max-width: 760px;
        margin: 0 auto;
        border: 1px solid var(--border-soft);
        background: #fff;
        padding: 2rem 1.4rem;
        text-align: center;
    }

    .success-badge {
        width: 56px;
        height: 56px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        border: 1px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 700;
    }

    .success-title {
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        margin-bottom: .5rem;
    }

    .success-text {
        color: var(--text-muted);
        font-size: .95rem;
        margin-bottom: 1.2rem;
    }

    .order-no-box {
        border: 1px dashed #bbb;
        padding: .9rem 1rem;
        margin: 0 auto 1.2rem;
        max-width: 340px;
    }

    .order-no-label {
        font-size: .73rem;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: #555;
        margin-bottom: .3rem;
    }

    .order-no-value {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: .03em;
    }

    .order-summary-table {
        width: 100%;
        text-align: left;
        font-size: .88rem;
        margin: 1.2rem 0;
        border-collapse: collapse;
    }

    .order-summary-table th {
        border-bottom: 1px solid #000;
        padding: .4rem .5rem;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #555;
    }

    .order-summary-table td {
        padding: .5rem .5rem;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: middle;
    }

    .order-summary-table img {
        width: 48px;
        aspect-ratio: 3/4;
        object-fit: cover;
        border-radius: 3px;
    }

    .order-total-row {
        display: flex;
        justify-content: space-between;
        font-size: .95rem;
        font-weight: 700;
        padding: .75rem .5rem 0;
        border-top: 1px solid #000;
        margin-top: .5rem;
    }

    .btn-orders {
        display: inline-block;
        min-width: 220px;
        padding: .85rem 1.1rem;
        background: #000;
        color: #fff;
        border: 1px solid #000;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .75rem;
        font-weight: 700;
    }

    .btn-orders:hover {
        background: #222;
        color: #fff;
    }

    @media (min-width: 992px) {
        .order-success-page {
            padding-inline: 0;
        }
    }
</style>

<main class="order-success-page d-flex align-items-start">
    <div class="container">
        <section class="success-card shadow-sm">
            <div class="success-badge">✓</div>
            <h1 class="success-title">Siparişiniz alındı</h1>
            <p class="success-text">
                Teşekkür ederiz. Siparişiniz başarıyla oluşturuldu. Hazırlandığında sizi bilgilendireceğiz.
            </p>

            <div class="order-no-box">
                <div class="order-no-label">Sipariş no</div>
                <div class="order-no-value">#<?php echo htmlspecialchars((string)$siparis_id, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>

            <?php if ($siparis): ?>
                <div class="order-no-box" style="max-width:400px;">
                    <div class="order-no-label">Tarih</div>
                    <div><?php echo htmlspecialchars($siparis['tarih']); ?></div>
                </div>

                <?php if (!empty($siparis_urunler)): ?>
                <table class="order-summary-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Ürün</th>
                            <th>Adet</th>
                            <th>Fiyat</th>
                            <th>Toplam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($siparis_urunler as $satir): ?>
                        <tr>
                            <td><img src="images/<?php echo htmlspecialchars($satir['gorsel']); ?>" alt=""></td>
                            <td><?php echo htmlspecialchars($satir['ad']); ?></td>
                            <td><?php echo (int)$satir['adet']; ?></td>
                            <td><?php echo number_format($satir['fiyat'], 2, ',', '.'); ?> TL</td>
                            <td><?php echo number_format($satir['fiyat'] * $satir['adet'], 2, ',', '.'); ?> TL</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="order-total-row">
                    <span>Genel Toplam</span>
                    <span><?php echo number_format($siparis['toplam'], 2, ',', '.'); ?> TL</span>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <p class="text-muted small">Sipariş bilgisi bulunamadı.</p>
            <?php endif; ?>

            <div class="mt-3">
                <a href="siparislerim.php" class="btn-orders">Siparişlerime git</a>
            </div>
        </section>
    </div>
</main>

<?php include "footer.php"; ?>