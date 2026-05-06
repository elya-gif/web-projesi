<?php
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM urunler WHERE id = ?');
$stmt->execute([$id]);
$urun = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$urun) {
    header('Location: 404.php');
    exit;
}

include "header.php";
?>

<style>
    :root {
        --bg-color: #ffffff;
        --text-color: #000000;
        --accent-color: #c9a063;
        --accent-dark: #8b6a2b;
        --border-color: #e6e6e6;
        --muted-text: #666666;
        --heart-active: #e63946;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .page-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 24px 16px 40px;
    }

    .breadcrumb {
        font-size: .8rem;
        color: var(--muted-text);
        margin-bottom: 12px;
    }

    .breadcrumb a {
        color: var(--muted-text);
        text-decoration: none;
    }

    .breadcrumb a:hover { text-decoration: underline; }

    .gallery-main {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        background: #f5f5f5;
        aspect-ratio: 3 / 4;
    }

    .gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-thumbs {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }

    .gallery-thumb {
        flex: 1;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid transparent;
        cursor: pointer;
        background: #f5f5f5;
        aspect-ratio: 3 / 4;
    }

    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-thumb.active { border-color: #000; }

    .product-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: .25rem;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: .1rem;
    }

    .size-label { font-size: .85rem; margin-bottom: .3rem; }

    .size-grid {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        margin-bottom: .75rem;
    }

    .size-btn {
        min-width: 44px;
        padding: .35rem .5rem;
        border-radius: 0;
        border: 1px solid var(--border-color);
        background-color: #fff;
        font-size: .8rem;
        cursor: pointer;
    }

    .size-btn:hover { border-color: #000; }

    .size-btn.active {
        border-color: #000;
        background-color: #000;
        color: #fff;
    }

    .size-help {
        font-size: .8rem;
        color: var(--muted-text);
        margin-bottom: 1rem;
    }

    .action-row {
        display: flex;
        gap: .5rem;
        margin-bottom: .75rem;
    }

    .btn-add-to-cart {
        flex: 1;
        border-radius: 999px;
        border: none;
        padding: .6rem 1.2rem;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .15em;
        background-color: #7a90a8;
        color: #fff;
        cursor: pointer;
    }

    .btn-add-to-cart:hover { opacity: 0.9; }

    .btn-fav {
        width: 42px;
        border-radius: 999px;
        border: 1px solid var(--border-color);
        background-color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .btn-fav.active {
        border-color: var(--heart-active);
        color: var(--heart-active);
    }

    .delivery-info,
    .product-description,
    .care-info {
        font-size: .85rem;
        color: var(--muted-text);
        margin-bottom: .7rem;
    }

    .delivery-info strong,
    .product-description strong,
    .care-info strong {
        color: #000;
        font-weight: 500;
    }

    .stok-uyari {
        font-size: .85rem;
        color: #e63946;
        margin-bottom: .75rem;
    }

    @media (max-width: 768px) {
        .page-wrapper { padding-top: 16px; }
        .product-title { margin-top: 12px; }
    }
</style>

<div class="page-wrapper">
    <nav class="breadcrumb">
        <a href="sayfalist.php">Ürünler</a> / <?= htmlspecialchars($urun['ad']) ?>
    </nav>

    <div class="row g-4">
        <div class="col-12 col-md-7">
            <div class="gallery-main" id="mainImage">
                <img src="images/<?= htmlspecialchars($urun['gorsel']) ?>" alt="<?= htmlspecialchars($urun['ad']) ?>">
            </div>

            <div class="gallery-thumbs mt-2">
                <div class="gallery-thumb active" data-image="images/<?= htmlspecialchars($urun['gorsel']) ?>">
                    <img src="images/<?= htmlspecialchars($urun['gorsel']) ?>" alt="">
                </div>
            </div>
        </div>

        <div class="col-12 col-md-5">
            <h1 class="product-title"><?= htmlspecialchars($urun['ad']) ?></h1>

            <div class="product-price"><?= number_format($urun['fiyat'], 2, ',', '.') ?> TL</div>

            <?php if ((int)$urun['stok'] === 0): ?>
                <div class="stok-uyari">⚠ Bu ürün stokta bulunmamaktadır.</div>
            <?php elseif ((int)$urun['stok'] <= 3): ?>
                <div class="stok-uyari">Son <?= (int)$urun['stok'] ?> ürün kaldı!</div>
            <?php endif; ?>

            <div class="size-label">Beden seçin</div>
            <div class="size-grid" id="sizeGrid">
                <button class="size-btn" data-size="XS">XS</button>
                <button class="size-btn" data-size="S">S</button>
                <button class="size-btn" data-size="M">M</button>
                <button class="size-btn" data-size="L">L</button>
                <button class="size-btn" data-size="XL">XL</button>
            </div>
            <div class="size-help">
                <a href="#" style="color:#000; text-decoration:underline; font-size:.8rem;">Beden rehberi</a>
            </div>

            <div class="action-row">
                <button class="btn-add-to-cart" id="addToCartBtn" <?= (int)$urun['stok'] === 0 ? 'disabled' : '' ?>>
                    <?= (int)$urun['stok'] === 0 ? 'Stokta Yok' : 'Sepete ekle' ?>
                </button>
                <button class="btn-fav" id="favBtn" aria-label="Favorilere ekle"
                    data-product-id="<?= $urun['id'] ?>"
                    data-product-name="<?= htmlspecialchars($urun['ad']) ?>"
                    data-product-price="<?= htmlspecialchars($urun['fiyat']) ?>"
                    data-product-image="<?= htmlspecialchars($urun['gorsel']) ?>"
                    data-product-category="<?= htmlspecialchars($urun['kategori']) ?>">
                    ♥
                </button>
            </div>

            <div class="delivery-info">
                <strong>Teslimat:</strong> Standart gönderim 2-5 iş günü içinde gerçekleşmektedir.
            </div>

            <?php if (!empty($urun['aciklama'])): ?>
            <div class="product-description">
                <strong>Ürün açıklaması:</strong> <?= htmlspecialchars($urun['aciklama']) ?>
            </div>
            <?php endif; ?>

            <div class="care-info">
                <strong>Bakım talimatları:</strong> Benzer renklerle 30°C'de yıkayın, ters çevirerek ütüleyin.
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.gallery-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            const src = this.getAttribute('data-image');
            document.querySelector('#mainImage img').src = src;
            document.querySelectorAll('.gallery-thumb').forEach(function (t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    let selectedSize = '';
    document.querySelectorAll('.size-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.size-btn').forEach(function (b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            selectedSize = this.getAttribute('data-size');
        });
    });

    const FAV_KEY = 'megay_favorites';
    const favBtn = document.getElementById('favBtn');

    function getFavorites() {
        try {
            const raw = localStorage.getItem(FAV_KEY);
            const parsed = raw ? JSON.parse(raw) : [];
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) { return []; }
    }

    function saveFavorites(items) {
        localStorage.setItem(FAV_KEY, JSON.stringify(items));
    }

    function isFavorite(productId) {
        return getFavorites().some(function (item) {
            return String(item.id) === String(productId);
        });
    }

    function toggleFavorite(product) {
        const list = getFavorites();
        const index = list.findIndex(function (item) {
            return String(item.id) === String(product.id);
        });
        if (index > -1) { list.splice(index, 1); saveFavorites(list); return false; }
        list.unshift(product); saveFavorites(list); return true;
    }

    const detailProduct = {
        id: favBtn.getAttribute('data-product-id'),
        name: favBtn.getAttribute('data-product-name'),
        price: parseFloat(favBtn.getAttribute('data-product-price') || '0'),
        image: favBtn.getAttribute('data-product-image'),
        category: favBtn.getAttribute('data-product-category'),
        url: 'urun-detay.php?id=' + (favBtn.getAttribute('data-product-id') || '')
    };

    if (isFavorite(detailProduct.id)) { favBtn.classList.add('active'); }

    favBtn.addEventListener('click', function () {
        const added = toggleFavorite(detailProduct);
        this.classList.toggle('active', added);
    });

    document.getElementById('addToCartBtn').addEventListener('click', function () {
        if (!selectedSize) {
            alert('Lütfen bir beden seçin.');
            return;
        }
        alert('Ürün sepete eklendi. Beden: ' + selectedSize);
    });
</script>

<?php include "footer.php"; ?>