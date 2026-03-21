<?php
include "header.php";

$pageTitle = "Alışveriş Sepeti | Megay Moda";

// Oturum: kendi yapına göre değiştir
// session_start();
// $logged_in = isset($_SESSION['user_id']);
$logged_in = false; // true yapınca "Oturum aç" butonu gizlenir

// Örnek sepet verisi (veritabanı / session gelince doldurulacak)
$cart_items = [
    [
        'id'         => 1,
        'brand'      => 'Atölye',
        'name'       => 'Drapeli thong body',
        'price'      => 749.99,
        'image'      => 'images/cart/body-1.jpg',
        'product_no' => '1336782002',
        'color'      => 'Siyah',
        'size'       => 'M',
        'qty'        => 1,
    ],
    [
        'id'         => 2,
        'brand'      => 'Atölye',
        'name'       => 'Basic ribana top',
        'price'      => 399.50,
        'image'      => 'images/cart/top-1.jpg',
        'product_no' => '1336782111',
        'color'      => 'Beyaz',
        'size'       => 'S',
        'qty'        => 2,
    ],
];

$shipping_estimate = 49.90;
$subtotal = 0;
foreach ($cart_items as $row) {
    $subtotal += $row['price'] * $row['qty'];
}
$grand_total = $subtotal + $shipping_estimate;
?>


<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
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
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* iletisim: .page-wrapper — sepet sayfası için aynı dolgu ve min-height */
    .page-wrapper.sepet-page {
        min-height: 100vh;
        padding: 3rem 1rem 4rem;
        background: var(--bg-main);
    }

    @media (min-width: 992px) {
        .page-wrapper.sepet-page {
            padding-inline: 0;
        }
    }

    .cart-title {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
        color: #000;
    }

    .cart-item {
        display: flex;
        gap: 1rem;
        padding: 1.25rem 0;
        border-bottom: 1px solid var(--border-soft);
    }

    .cart-item:last-of-type {
        border-bottom: none;
    }

    .cart-item-img-wrap {
        position: relative;
        flex: 0 0 120px;
        max-width: 120px;
        aspect-ratio: 3/4;
        background: #f5f5f5;
        border-radius: 4px;
        overflow: hidden;
    }

    .cart-item-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .cart-item-fav {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(255, 255, 255, .9);
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
        color: #000;
    }

    .cart-item-body {
        flex: 1;
        min-width: 0;
    }

    .cart-item-brand {
        font-size: .75rem;
        color: var(--text-muted);
        margin-bottom: .15rem;
    }

    .cart-item-name {
        font-size: .9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: .35rem;
        color: #000;
    }

    .cart-item-price {
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: .5rem;
        color: #000;
    }

    .cart-item-meta {
        font-size: .8rem;
        color: #333;
        line-height: 1.6;
    }

    .cart-item-meta span {
        display: block;
    }

    .cart-item-line-total {
        font-size: .85rem;
        margin-top: .5rem;
        color: #000;
    }

    .cart-item-line-total strong {
        font-weight: 700;
    }

    .cart-qty-box {
        display: flex;
        align-items: center;
        max-width: 220px;
        border: 1px solid #000;
        margin-top: .75rem;
    }

    .cart-qty-box button {
        flex: 0 0 44px;
        height: 44px;
        border: none;
        background: #fff;
        cursor: pointer;
        font-size: 1.1rem;
        color: #000;
    }

    .cart-qty-box button:hover {
        background: #f5f5f5;
    }

    .cart-qty-box .cart-qty-val {
        flex: 1;
        text-align: center;
        font-size: .95rem;
        font-weight: 600;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }

    .cart-qty-box .cart-btn-remove {
        font-size: 1rem;
    }

    .cart-summary {
        border: 1px solid var(--border-soft);
        padding: 1.25rem;
        margin-top: 1rem;
        background: #fff;
    }

    @media (min-width: 992px) {
        .cart-summary {
            margin-top: 0;
            position: sticky;
            top: 6rem;
        }
    }

    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .85rem;
        padding: .4rem 0;
        color: #333;
    }

    .cart-summary-row.discounts {
        border-bottom: 1px solid var(--border-soft);
        margin-bottom: .5rem;
        padding-bottom: .75rem;
    }

    .cart-summary-row.discounts a {
        color: #000;
        font-weight: 600;
        text-decoration: underline;
    }

    .cart-summary-total {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-top: .75rem;
        padding-top: .75rem;
        border-top: 1px solid #000;
    }

    .btn-cart-checkout {
        display: block;
        width: 100%;
        margin-top: 1rem;
        padding: .85rem 1rem;
        background: #000;
        color: #fff;
        border: none;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-cart-checkout:hover {
        background: #222;
        color: #fff;
    }

    .btn-cart-login {
        display: block;
        width: 100%;
        margin-top: .6rem;
        padding: .75rem 1rem;
        background: #fff;
        color: #000;
        border: 1px solid #000;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        text-align: center;
        text-decoration: none;
    }

    .btn-cart-login:hover {
        background: #f5f5f5;
        color: #000;
    }

    .cart-empty {
        padding: 2rem 0;
        color: var(--text-muted);
        font-size: .95rem;
    }
</style>

<main class="page-wrapper sepet-page d-flex align-items-start">
    <div class="container">
        <h1 class="cart-title">Alışveriş sepeti</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <?php if (empty($cart_items)): ?>
                    <p class="cart-empty">Sepetinizde ürün bulunmuyor.</p>
                    <a href="sayfalist.php" class="btn-cart-login d-inline-block" style="width:auto;">Alışverişe devam et</a>
                <?php else: ?>
                    <?php foreach ($cart_items as $index => $item):
                        $line = $item['price'] * $item['qty'];
                    ?>
                    <div class="cart-item"
                         data-cart-index="<?php echo (int)$index; ?>"
                         data-unit-price="<?php echo htmlspecialchars((string)$item['price'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="cart-item-img-wrap">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                            <button type="button" class="cart-item-fav" aria-label="Favori">♡</button>
                        </div>
                        <div class="cart-item-body">
                            <div class="cart-item-brand"><?php echo htmlspecialchars($item['brand']); ?></div>
                            <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="cart-item-price"><?php echo number_format($item['price'], 2, ',', '.'); ?> TL</div>
                            <div class="cart-item-meta">
                                <span>Ürün no <?php echo htmlspecialchars($item['product_no']); ?></span>
                                <span>Renk <?php echo htmlspecialchars($item['color']); ?></span>
                                <span>Beden <?php echo htmlspecialchars($item['size']); ?></span>
                                <span>Adet <span class="cart-meta-qty"><?php echo (int)$item['qty']; ?></span></span>
                            </div>
                            <div class="cart-item-line-total">
                                Toplam <strong class="cart-line-total"><?php echo number_format($line, 2, ',', '.'); ?> TL</strong>
                            </div>
                            <div class="cart-qty-box">
                                <button type="button" class="cart-btn-remove" aria-label="Sil" title="Sil">🗑</button>
                                <span class="cart-qty-val"><?php echo (int)$item['qty']; ?></span>
                                <button type="button" class="cart-btn-minus" aria-label="Azalt">−</button>
                                <button type="button" class="cart-btn-plus" aria-label="Artır">+</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <?php if (!empty($cart_items)): ?>
                <aside class="cart-summary">
                    <div class="cart-summary-row discounts">
                        <span>İndirimler</span>
                        <a href="#">Ekle</a>
                    </div>
                    <div class="cart-summary-row">
                        <span>Sipariş bedeli</span>
                        <span id="cartSubtotal"><?php echo number_format($subtotal, 2, ',', '.'); ?> TL</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Tahmini teslimat ücreti</span>
                        <span id="cartShipping"><?php echo number_format($shipping_estimate, 2, ',', '.'); ?> TL</span>
                    </div>
                    <div class="cart-summary-row cart-summary-total">
                        <span>Toplam</span>
                        <span id="cartGrandTotal"><?php echo number_format($grand_total, 2, ',', '.'); ?> TL</span>
                    </div>

                    <a href="odeme.php" class="btn-cart-checkout">Ödeme ekranına devam et</a>

                    <?php if (!$logged_in): ?>
                    <a href="giris.php" class="btn-cart-login">Oturum aç</a>
                    <?php endif; ?>
                </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php if (!empty($cart_items)): ?>
<script>
(function () {
    var shipping = <?php echo json_encode($shipping_estimate); ?>;

    function formatPrice(n) {
        return n.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' TL';
    }

    function recalc() {
        var sub = 0;
        document.querySelectorAll('.cart-item').forEach(function (row) {
            var unit = parseFloat(row.getAttribute('data-unit-price')) || 0;
            var q = parseInt(row.querySelector('.cart-qty-val').textContent, 10) || 0;
            sub += unit * q;
            row.querySelector('.cart-line-total').textContent = formatPrice(unit * q);
            var mq = row.querySelector('.cart-meta-qty');
            if (mq) {
                mq.textContent = q;
            }
        });
        var subEl = document.getElementById('cartSubtotal');
        var totalEl = document.getElementById('cartGrandTotal');
        if (subEl) {
            subEl.textContent = formatPrice(sub);
        }
        if (totalEl) {
            totalEl.textContent = formatPrice(sub + shipping);
        }
    }

    document.querySelectorAll('.cart-item').forEach(function (row) {
        var valEl = row.querySelector('.cart-qty-val');
        var minus = row.querySelector('.cart-btn-minus');
        var plus = row.querySelector('.cart-btn-plus');
        var remove = row.querySelector('.cart-btn-remove');

        plus.addEventListener('click', function () {
            var q = parseInt(valEl.textContent, 10) + 1;
            valEl.textContent = q;
            recalc();
        });
        minus.addEventListener('click', function () {
            var q = parseInt(valEl.textContent, 10) - 1;
            if (q < 1) {
                q = 1;
            }
            valEl.textContent = q;
            recalc();
        });
        remove.addEventListener('click', function () {
            row.remove();
            if (!document.querySelector('.cart-item')) {
                location.reload();
            }
            recalc();
        });
    });
})();
</script>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>

<?php include "footer.php"; ?>
