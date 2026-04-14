<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['uye']);
$mode = $_GET['mod'] ?? '';

if (!$isLoggedIn && $mode !== 'misafir') {
    header("Location: odeme-kontrol.php");
    exit;
}

function trPrice($value)
{
    return number_format((float)$value, 2, ",", ".");
}

// Uye bilgilerinin session'dan gelmesi beklenir.
$memberData = [
    "ad_soyad" => "Ayse Yilmaz",
    "email" => "ayse@example.com",
    "telefon" => "05XX XXX XX XX",
    "adres" => "Ataturk Mah. Moda Cad. No:12 D:5",
    "ilce" => "Kadikoy",
    "il" => "Istanbul",
    "posta_kodu" => "34710",
];

if (isset($_SESSION["uye"]) && is_array($_SESSION["uye"])) {
    $memberData = array_merge($memberData, $_SESSION["uye"]);
}

$formValues = [
    "ad_soyad" => $isLoggedIn ? ($memberData["ad_soyad"] ?? "") : "",
    "email" => $isLoggedIn ? ($memberData["email"] ?? "") : "",
    "telefon" => $isLoggedIn ? ($memberData["telefon"] ?? "") : "",
    "adres" => $isLoggedIn ? ($memberData["adres"] ?? "") : "",
    "ilce" => $isLoggedIn ? ($memberData["ilce"] ?? "") : "",
    "il" => $isLoggedIn ? ($memberData["il"] ?? "") : "",
    "posta_kodu" => $isLoggedIn ? ($memberData["posta_kodu"] ?? "") : "",
];

// Sepet: session'dan oku, yoksa ornek veri goster.
$cartItems = [];
if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $cartItems[] = [
            "name" => $item["name"] ?? "Urun",
            "price" => (float)($item["price"] ?? 0),
            "qty" => (int)($item["qty"] ?? 1),
            "size" => $item["size"] ?? "-",
            "color" => $item["color"] ?? "-",
        ];
    }
}

if (empty($cartItems)) {
    $cartItems = [
        ["name" => "Drapeli thong body", "price" => 749.99, "qty" => 1, "size" => "M", "color" => "Siyah"],
        ["name" => "Basic ribana top", "price" => 399.50, "qty" => 2, "size" => "S", "color" => "Beyaz"],
    ];
}

$shipping = 49.90;
$subtotal = 0;
foreach ($cartItems as $row) {
    $subtotal += $row["price"] * $row["qty"];
}
$grandTotal = $subtotal + $shipping;

include "header.php";
?>

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

    .odeme-page {
        min-height: 100vh;
        padding: 3rem 1rem 4rem;
        background: #fff;
    }

    .odeme-title {
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: .4rem;
    }

    .odeme-info {
        color: var(--text-muted);
        font-size: .9rem;
        margin-bottom: 1.4rem;
    }

    .checkout-card {
        border: 1px solid var(--border-soft);
        background: #fff;
        padding: 1.2rem;
        margin-bottom: .9rem;
    }

    .section-head {
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: .95rem;
    }

    .odeme-label {
        display: block;
        font-size: .74rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: .32rem;
    }

    .odeme-input, .odeme-select {
        width: 100%;
        border: 1px solid #d8d8d8;
        background: #fff;
        color: #111;
        padding: .64rem .72rem;
        font-size: .9rem;
    }

    .odeme-input:focus, .odeme-select:focus {
        border-color: #000;
        outline: none;
    }

    .odeme-readonly {
        background: #f8f8f8;
    }

    .odeme-note {
        font-size: .78rem;
        color: #666;
        margin-top: .55rem;
    }

    .order-summary {
        border: 1px solid var(--border-soft);
        background: #fff;
        padding: 1.2rem;
    }

    .order-item {
        padding: .65rem 0;
        border-bottom: 1px solid var(--border-soft);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-name {
        font-size: .86rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: .2rem;
    }

    .order-item-meta {
        font-size: .78rem;
        color: #666;
    }

    .order-item-price {
        font-size: .82rem;
        margin-top: .25rem;
    }

    .sum-row {
        display: flex;
        justify-content: space-between;
        font-size: .86rem;
        margin-top: .45rem;
    }

    .sum-total {
        border-top: 1px solid #000;
        padding-top: .55rem;
        margin-top: .6rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .btn-odeme {
        width: 100%;
        border: 1px solid #000;
        background: #000;
        color: #fff;
        padding: .85rem 1rem;
        text-transform: uppercase;
        font-size: .74rem;
        letter-spacing: .11em;
        font-weight: 700;
        margin-top: 1rem;
    }

    .btn-odeme:hover {
        background: #222;
    }

    @media (min-width: 992px) {
        .odeme-page {
            padding-inline: 0;
        }

        .order-summary {
            position: sticky;
            top: 6rem;
        }
    }
</style>

<main class="odeme-page d-flex align-items-start">
    <div class="container">
        <h1 class="odeme-title">Teslimat ve Ödeme</h1>
        <p class="odeme-info">
            <?php if ($isLoggedIn): ?>
                Kayitli uye bilgilerin otomatik getirildi. Gerekirse teslimat detaylarini guncelleyebilirsin.
            <?php else: ?>
                Misafir olarak devam ediyorsun. Teslimat ve odeme bilgilerini doldurman gerekiyor.
            <?php endif; ?>
        </p>

        <form action="odeme-tamamla.php" method="post">
            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="checkout-card">
                        <h2 class="section-head">İletişim Bilgileri</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="odeme-label" for="ad_soyad">Ad Soyad</label>
                                <input class="odeme-input <?php echo $isLoggedIn ? "odeme-readonly" : ""; ?>" id="ad_soyad" name="ad_soyad" type="text" value="<?php echo htmlspecialchars((string)$formValues["ad_soyad"], ENT_QUOTES, "UTF-8"); ?>" <?php echo $isLoggedIn ? "readonly" : ""; ?> required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="email">E-posta</label>
                                <input class="odeme-input <?php echo $isLoggedIn ? "odeme-readonly" : ""; ?>" id="email" name="email" type="email" value="<?php echo htmlspecialchars((string)$formValues["email"], ENT_QUOTES, "UTF-8"); ?>" <?php echo $isLoggedIn ? "readonly" : ""; ?> required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="telefon">Telefon</label>
                                <input class="odeme-input" id="telefon" name="telefon" type="text" value="<?php echo htmlspecialchars((string)$formValues["telefon"], ENT_QUOTES, "UTF-8"); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="posta_kodu">Posta Kodu</label>
                                <input class="odeme-input" id="posta_kodu" name="posta_kodu" type="text" value="<?php echo htmlspecialchars((string)$formValues["posta_kodu"], ENT_QUOTES, "UTF-8"); ?>" required>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-card">
                        <h2 class="section-head">Teslimat adresi</h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="odeme-label" for="adres">Adres</label>
                                <input class="odeme-input" id="adres" name="adres" type="text" value="<?php echo htmlspecialchars((string)$formValues["adres"], ENT_QUOTES, "UTF-8"); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="ilce">İlçe</label>
                                <input class="odeme-input" id="ilce" name="ilce" type="text" value="<?php echo htmlspecialchars((string)$formValues["ilce"], ENT_QUOTES, "UTF-8"); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="il">İl</label>
                                <input class="odeme-input" id="il" name="il" type="text" value="<?php echo htmlspecialchars((string)$formValues["il"], ENT_QUOTES, "UTF-8"); ?>" required>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-card">
                        <h2 class="section-head">Kart bilgileri </h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="odeme-label" for="card_holder">Kart Üzerindeki İsim</label>
                                <input class="odeme-input" id="card_holder" name="card_holder" type="text" autocomplete="cc-name" required>
                            </div>
                            <div class="col-12">
                                <label class="odeme-label" for="card_number">Kart Numarası</label>
                                <input class="odeme-input" id="card_number" name="card_number" type="text" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" autocomplete="cc-number" required>
                            </div>
                            <div class="col-md-4">
                                <label class="odeme-label" for="expire_month">Ay</label>
                                <select class="odeme-select" id="expire_month" name="expire_month" required>
                                    <option value="">AA</option>
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?php echo str_pad((string)$m, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad((string)$m, 2, "0", STR_PAD_LEFT); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="odeme-label" for="expire_year">Yıl</label>
                                <select class="odeme-select" id="expire_year" name="expire_year" required>
                                    <option value="">YYYY</option>
                                    <?php $currentYear = (int)date("Y"); ?>
                                    <?php for ($y = $currentYear; $y <= $currentYear + 10; $y++): ?>
                                        <option value="<?php echo (string)$y; ?>"><?php echo (string)$y; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="odeme-label" for="cvc">CVC</label>
                                <input class="odeme-input" id="cvc" name="cvc" type="password" inputmode="numeric" maxlength="4" autocomplete="cc-csc" required>
                            </div>
                        </div>
                        <p class="odeme-note">
                            Kart dogrulama ve odeme cekimi Iyzico tarafinda yapilacak sekilde alanlar hazirlandi.
                        </p>
                    </section>

                    <input type="hidden" name="payment_provider" value="iyzico">
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars((string)$grandTotal, ENT_QUOTES, "UTF-8"); ?>">
                    <button type="submit" class="btn-odeme">Guvenli odemeye gec</button>
                </div>

                <div class="col-lg-4">
                    <aside class="order-summary">
                        <h2 class="section-head">Siparis ozeti</h2>

                        <?php foreach ($cartItems as $item): ?>
                            <div class="order-item">
                                <div class="order-item-name"><?php echo htmlspecialchars((string)$item["name"], ENT_QUOTES, "UTF-8"); ?></div>
                                <div class="order-item-meta">
                                    Adet: <?php echo (int)$item["qty"]; ?> | Beden: <?php echo htmlspecialchars((string)$item["size"], ENT_QUOTES, "UTF-8"); ?> | Renk: <?php echo htmlspecialchars((string)$item["color"], ENT_QUOTES, "UTF-8"); ?>
                                </div>
                                <div class="order-item-price">
                                    <?php echo trPrice($item["price"] * $item["qty"]); ?> TL
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="sum-row">
                            <span>Siparis bedeli</span>
                            <span><?php echo trPrice($subtotal); ?> TL</span>
                        </div>
                        <div class="sum-row">
                            <span>Teslimat</span>
                            <span><?php echo trPrice($shipping); ?> TL</span>
                        </div>
                        <div class="sum-row sum-total">
                            <span>Toplam</span>
                            <span><?php echo trPrice($grandTotal); ?> TL</span>
                        </div>
                    </aside>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include "footer.php"; ?>
