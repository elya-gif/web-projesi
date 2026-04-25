<?php
// ============================================================
// GELİŞTİRİCİ A'NIN DB KODU BURAYA GELECEK
// Şimdilik test için sahte veri kullanılıyor:
 
 $urun = null; 

// ============================================================

// 404 kontrolü — ürün bulunamazsa yönlendir
if (!$urun) {
    header("Location: 404.php");
    exit;
}
?>
<?php include "header.php"; ?>

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

    .breadcrumb a:hover {
        text-decoration: underline;
    }

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

    .gallery-thumb.active {
        border-color: #000;
    }

    .product-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: .25rem;
    }

    .product-subtitle {
        font-size: .9rem;
        color: var(--muted-text);
        margin-bottom: .5rem;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: .1rem;
    }

    .product-old-price {
        font-size: .9rem;
        color: var(--muted-text);
        text-decoration: line-through;
    }

    .product-color {
        font-size: .85rem;
        margin-top: .75rem;
        margin-bottom: .35rem;
    }

    .color-swatches {
        display: flex;
        gap: .3rem;
        margin-bottom: 1rem;
    }

    .color-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .color-dot.active {
        border-color: #000;
    }

    .size-label {
        font-size: .85rem;
        margin-bottom: .3rem;
    }

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

    .size-btn:hover {
        border-color: #000;
    }

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

    .btn-add-to-cart:hover {
        background-color: #7A90A8;
    }

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

    .detail-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: .7rem;
    }

    .detail-list li {
        font-size: .85rem;
        color: var(--muted-text);
    }

    .detail-list li::before {
        content: "• ";
    }

    @media (max-width: 768px) {
        .page-wrapper {
            padding-top: 16px;
        }
        .product-title {
            margin-top: 12px;
        }
    }
</style>

<div class="page-wrapper">
    <nav class="breadcrumb">
        <a href="sayfalist.php">Ürünler</a> / <?= htmlspecialchars($urun['ad']) ?>
    </nav>

    <div class="row g-4">
        <div class="col-12 col-md-7">
            <div class="gallery-main" id="mainImage">
                <img src="<?= htmlspecialchars($urun['resim']) ?>" alt="<?= htmlspecialchars($urun['ad']) ?>">
            </div>

            <div class="gallery-thumbs mt-2">
                <div class="gallery-thumb active" data-image="<?= htmlspecialchars($urun['resim']) ?>">
                    <img src="<?= htmlspecialchars($urun['resim']) ?>" alt="">
                </div>
                <div class="gallery-thumb" data-image="images/toplar/top-detay-2.jpg">
                    <img src="images/toplar/top-detay-2.jpg" alt="">
                </div>
                <div class="gallery-thumb" data-image="images/toplar/top-detay-3.jpg">
                    <img src="images/toplar/top-detay-3.jpg" alt="">
                </div>
            </div>
        </div>

        <div class="col-12 col-md-5">
            <h1 class="product-title"><?= htmlspecialchars($urun['ad']) ?></h1>

            <div class="product-price"><?= htmlspecialchars($urun['fiyat']) ?> TL</div>

            <div class="product-color">
                Renk: <strong><?= htmlspecialchars($urun['renk']) ?></strong>
            </div>
            <div class="color-swatches">
                <div class="color-dot active" style="background:#ffffff;"></div>
                <div class="color-dot" style="background:#000000;"></div>
                <div class="color-dot" style="background:#1f2a44;"></div>
            </div>

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
                <button class="btn-add-to-cart" id="addToCartBtn">
                    Sepete ekle
                </button>
                <button class="btn-fav" id="favBtn" aria-label="Favorilere ekle"
                    data-product-id="<?= $urun['id'] ?>"
                    data-product-name="<?= htmlspecialchars($urun['ad']) ?>"
                    data-product-price="<?= htmlspecialchars($urun['fiyat']) ?>"
                    data-product-image="<?= htmlspecialchars($urun['resim']) ?>"
                    data-product-category="<?= htmlspecialchars($urun['kategori']) ?>">
                    ♥
                </button>
            </div>

            <div class="delivery-info">
                <strong>Teslimat:</strong> Standart gönderim 2-5 iş günü içinde gerçekleşmektedir.
            </div>

            <div class="product-description">
                <strong>Ürün açıklaması:</strong> <?= htmlspecialchars($urun['aciklama']) ?>
            </div>

            <ul class="detail-list">
                <li>Fit: Dar kesim</li>
                <li>Uzunluk: Normal boy</li>
                <li>Kol tipi: Kolsuz</li>
                <li>Kumaş: Pamuk karışımlı, esnek</li>
            </ul>

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
        } catch (e) {
            return [];
        }
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

        if (index > -1) {
            list.splice(index, 1);
            saveFavorites(list);
            return false;
        }

        list.unshift(product);
        saveFavorites(list);
        return true;
    }

    const detailProduct = {
        id: favBtn.getAttribute('data-product-id'),
        name: favBtn.getAttribute('data-product-name'),
        price: parseFloat(favBtn.getAttribute('data-product-price') || '0'),
        image: favBtn.getAttribute('data-product-image'),
        category: favBtn.getAttribute('data-product-category'),
        url: 'urun-detay.php?id=' + (favBtn.getAttribute('data-product-id') || '')
    };

    if (isFavorite(detailProduct.id)) {
        favBtn.classList.add('active');
    }

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