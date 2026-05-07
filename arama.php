<?php
include 'config.php';
include 'header.php';
?>

<style>
    .pb-product-card {
        border-radius: .75rem;
        border: 1px solid #e6e6e6;
        padding: .6rem;
        background-color: #fff;
        overflow: hidden;
        transition: transform .18s ease, box-shadow .18s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .pb-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(0,0,0,.06);
    }

    .pb-image-wrapper {
        position: relative;
        border-radius: .6rem;
        overflow: hidden;
        background: #f5f5f5;
        aspect-ratio: 3 / 4;
    }

    .pb-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .pb-product-card:hover .pb-image-wrapper img {
        transform: scale(1.05);
    }

    .pb-info {
        padding: .25rem .25rem .2rem;
        display: flex;
        flex-direction: column;
        gap: .2rem;
        flex-grow: 1;
    }

    .pb-name {
        font-size: .9rem;
        font-weight: 500;
    }

    .pb-price-row {
        display: flex;
        align-items: baseline;
        gap: .4rem;
    }

    .pb-price {
        font-size: .95rem;
        font-weight: 600;
    }

    .pb-actions-bottom .btn {
        border-radius: 999px;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .12em;
    }

    body {
    background: #ffffff !important;
}
</style>

<?php
$q = trim($_GET['q'] ?? '');
$urunler = [];

if (!empty($q)) {
    $stmt = $pdo->prepare('SELECT * FROM urunler WHERE ad LIKE ?');
    $stmt->execute(['%' . $q . '%']);
    $urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div style="max-width:1200px; margin:40px auto; padding:20px;">
    <h2>"<?= htmlspecialchars($q) ?>" İçin Arama Sonuçları</h2>
    <p><?= count($urunler) ?> ürün bulundu.</p>

    <div class="row g-3 g-md-4">
        <?php foreach ($urunler as $urun): ?>
            <div class="col-6 col-md-4 col-lg-3">
    <div class="pb-product-card">
        <div class="pb-image-wrapper">
            <img src="<?= htmlspecialchars($urun['gorsel']) ?>" alt="<?= htmlspecialchars($urun['ad']) ?>">
        </div>
        <div class="pb-info">
            <div class="pb-name"><?= htmlspecialchars($urun['ad']) ?></div>
            <div class="pb-price-row">
                <div class="pb-price"><?= number_format($urun['fiyat'], 2, ',', '.') ?> TL</div>
            </div>
            <div class="pb-actions-bottom mt-2">
                <button class="btn btn-outline-dark w-100" onclick="window.location.href='urun-detay.php?id=<?= $urun['id'] ?>'">İncele</button>
            </div>
        </div>
    </div>
</div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>