
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>













<?php
include 'config.php';
include 'header.php'; 



$currentCategory = isset($_GET['kategori']) ? $_GET['kategori'] : 'tum';

$categories = [
    'tum'       => 'Tüm Ürünler',
    'elbiseler' => 'Elbiseler',
    'ceketler'  => 'Ceketler',
    'toplar'    => 'Toplar',
    'bodyler'   => 'Bodyler',
    'sortlar'   => 'Şortlar',
    'tisortler' => 'Tişörtler',
    'etek'      => 'Etekler',
    'gomlek'    => 'Gömlekler',
    'kazak'     => 'Kazaklar',
];

// DB'den ürünleri çek
if ($currentCategory !== 'tum') {
    $stmt = $pdo->prepare('SELECT * FROM urunler WHERE kategori = ?');
    $stmt->execute([$currentCategory]);
} else {
    $stmt = $pdo->query('SELECT * FROM urunler');
}

$urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = isset($categories[$currentCategory]) ? $categories[$currentCategory] : $categories['tum'];
?>

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Koleksiyon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #000000;
            --accent-color: #c9a063;
            --accent-dark: #8b6a2b;
            --border-color: #e6e6e6;
            --muted-text: #666666;
            --badge-bg: #000000;
            --badge-text: #ffffff;
            --heart-active: #e63946;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .pb-collection-header { margin-bottom: 1.5rem; }

        .pb-collection-title {
            font-size: 1.75rem;
            font-weight: 600;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        .pb-collection-subtitle {
            font-size: .9rem;
            color: var(--muted-text);
        }

        .pb-product-card {
            border-radius: .75rem;
            border: 1px solid var(--border-color);
            padding: .6rem;
            background-color: #fff;
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .pb-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(0,0,0,.06);
            border-color: rgba(0,0,0,.08);
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

        .pb-product-card:hover .pb-image-wrapper img { transform: scale(1.05); }

        .pb-actions-top {
            position: absolute;
            top: .5rem;
            right: .5rem;
            display: flex;
            flex-direction: column;
            gap: .3rem;
            z-index: 3;
        }

        .pb-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: none;
            background-color: rgba(255,255,255,.92);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color .15s ease, transform .15s ease, box-shadow .15s ease;
            font-size: 1rem;
        }

        .pb-icon-btn:hover {
            background-color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0,0,0,.18);
        }

        .pb-heart { color: #888; }
        .pb-heart.active { color: var(--heart-active); }

        .pb-hover-panel {
            position: absolute;
            left: 0; right: 0; bottom: -80px;
            padding: .5rem .6rem;
            background-color: rgba(255,255,255,.96);
            display: flex;
            gap: .4rem;
            align-items: center;
            transition: bottom .25s ease;
            z-index: 2;
        }

        .pb-product-card:hover .pb-hover-panel { bottom: 0; }

        @media (max-width: 768px) { .pb-hover-panel { bottom: 0; } }

        .pb-size-select {
            flex: 1;
            border-radius: 0;
            border: 1px solid #000;
            font-size: .8rem;
            padding: .35rem .45rem;
        }

        .pb-hover-add {
            border: none;
            background-color: #000;
            color: #fff;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: .4rem .9rem;
            white-space: nowrap;
            cursor: pointer;
        }

        .pb-hover-add:hover { background-color: #111; }

        .pb-info {
            padding: .25rem .25rem .2rem;
            display: flex;
            flex-direction: column;
            gap: .2rem;
            flex-grow: 1;
        }

        .pb-name { font-size: .9rem; font-weight: 500; }

        .pb-price-row {
            display: flex;
            align-items: baseline;
            gap: .4rem;
        }

        .pb-price { font-size: .95rem; font-weight: 600; }

        .pb-meta {
            font-size: .7rem;
            color: var(--muted-text);
            text-transform: uppercase;
            letter-spacing: .15em;
        }

        .pb-actions-bottom .btn {
            border-radius: 999px;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .pb-scroll-top {
            position: fixed;
            right: 18px; bottom: 18px;
            width: 40px; height: 40px;
            border: 1px solid #000;
            background-color: #fff;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1040;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s ease;
        }

        .pb-scroll-top.visible { opacity: 1; pointer-events: auto; }
        .pb-scroll-top span { font-size: 1.1rem; line-height: 1; }
    </style>
</head>

<div class="container py-4">
    <div class="pb-collection-header">
        <h1 class="pb-collection-title mb-1"><?php echo htmlspecialchars($pageTitle); ?></h1>
        <p class="pb-collection-subtitle mb-0"></p>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="small text-muted">
            <?php echo count($urunler); ?> ürün gösteriliyor
        </div>
    </div>

    <?php if (empty($urunler)): ?>
        <p class="text-muted small">Bu kategori için henüz ürün eklenmedi.</p>
    <?php else: ?>
        <div class="row g-3 g-md-4">
            <?php foreach ($urunler as $urun): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pb-product-card"
                         data-product-id="<?php echo (int)$urun['id']; ?>"
                         data-product-name="<?php echo htmlspecialchars($urun['ad'], ENT_QUOTES); ?>"
                         data-product-price="<?php echo htmlspecialchars((string)$urun['fiyat'], ENT_QUOTES); ?>"
                         data-product-image="<?php echo htmlspecialchars($urun['gorsel'], ENT_QUOTES); ?>"
                         data-product-category="<?php echo htmlspecialchars($urun['kategori'], ENT_QUOTES); ?>">

                        <div class="pb-image-wrapper">
                            <img
                                src="images/<?php echo htmlspecialchars($urun['gorsel']); ?>"
                                alt="<?php echo htmlspecialchars($urun['ad']); ?>"
                            >

                            <div class="pb-actions-top">
                                <button class="pb-icon-btn js-fav" type="button" aria-label="Favorilere ekle">
                                    <span class="pb-heart">&hearts;</span>
                                </button>
                            </div>

                            <div class="pb-hover-panel">
                                <select class="form-select pb-size-select">
                                    <option value="">Beden seç</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                                <button class="pb-hover-add js-hover-add" type="button">Ekle</button>
                            </div>
                        </div>

                        <div class="pb-info">
                            <div class="pb-name"><?php echo htmlspecialchars($urun['ad']); ?></div>

                            <div class="pb-price-row">
                                <div class="pb-price">
                                    <?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL
                                </div>
                            </div>

                            <div class="pb-meta">
                                <?php echo strtoupper($urun['kategori']); ?> • Özel dikim
                            </div>

                            <div class="pb-actions-bottom mt-2">
                                <button class="btn btn-outline-dark w-100 js-quick-view" type="button">
                                    İncele
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<button class="pb-scroll-top" id="scrollTopBtn" aria-label="Yukarı çık">
    <span>&uarr;</span>
</button>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>

<script>
    const FAV_KEY = 'megay_favorites';

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

    document.querySelectorAll('.js-fav').forEach(function (btn) {
        const card = btn.closest('.pb-product-card');
        const heart = btn.querySelector('.pb-heart');
        const productId = card.getAttribute('data-product-id');
        const productData = {
            id: productId,
            name: card.getAttribute('data-product-name') || '',
            price: parseFloat(card.getAttribute('data-product-price') || '0'),
            image: card.getAttribute('data-product-image') || '',
            category: card.getAttribute('data-product-category') || '',
            url: 'urun-detay.php?id=' + productId
        };

        if (isFavorite(productId)) { heart.classList.add('active'); }

        btn.addEventListener('click', function () {
            const added = toggleFavorite(productData);
            heart.classList.toggle('active', added);
        });
    });

    document.querySelectorAll('.js-hover-add').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const card = this.closest('.pb-product-card');
            const select = card.querySelector('.pb-size-select');
            const size = select.value;
            if (!size) { alert('Lütfen beden seçiniz.'); return; }
            alert('Ürün sepete eklendi. Beden: ' + size);
        });
    });

    document.querySelectorAll('.js-quick-view').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const card = this.closest('.pb-product-card');
            const productId = card.getAttribute('data-product-id');
            window.location.href = 'urun-detay.php?id=' + productId;
        });
    });

    const scrollBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', function () {
        scrollBtn.classList.toggle('visible', window.scrollY > 250);
    });
    scrollBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

<?php include 'footer.php'; ?>