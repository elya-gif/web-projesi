<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/iyzipay/IyzipayBootstrap.php';
IyzipayBootstrap::init(__DIR__ . '/vendor/iyzipay/src');
include 'config.php';

$form_html = null;
$hata = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sepet = $_SESSION['sepet'] ?? [];

    if (!empty($sepet)) {
        $options = new \Iyzipay\Options();
        $options->setApiKey($iyzico_api_key);
        $options->setSecretKey($iyzico_secret_key);
        $options->setBaseUrl($iyzico_base_url);

        $toplam = 0;
        foreach ($sepet as $urun) {
            $toplam += $urun['fiyat'] * $urun['adet'];
        }
        $toplam += 49.90;
        $toplam_str = number_format($toplam, 2, '.', '');

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId('BYR_' . time());
        $buyer->setName(explode(' ', $_POST['ad_soyad'])[0] ?? 'Ad');
        $buyer->setSurname(explode(' ', $_POST['ad_soyad'])[1] ?? 'Soyad');
        $buyer->setEmail($_POST['email']);
        $buyer->setGsmNumber('+905555555555');
        $buyer->setIdentityNumber('11111111111');
        $buyer->setLastLoginDate('2015-10-05 12:43:35');
        $buyer->setRegistrationDate('2013-04-21 15:12:09');
        $buyer->setRegistrationAddress($_POST['adres']);
        $buyer->setIp($_SERVER['REMOTE_ADDR']);
        $buyer->setCity($_POST['il']);
        $buyer->setCountry('Turkey');
        $buyer->setZipCode($_POST['posta_kodu']);

        $adres = new \Iyzipay\Model\Address();
        $adres->setContactName($_POST['ad_soyad']);
        $adres->setCity($_POST['il']);
        $adres->setCountry('Turkey');
        $adres->setAddress($_POST['adres']);
        $adres->setZipCode($_POST['posta_kodu']);

        $basketItems = [];
        foreach ($sepet as $urun_id => $urun) {
            $item = new \Iyzipay\Model\BasketItem();
            $item->setId('URN_' . $urun_id);
            $item->setName($urun['ad'] ?? $urun['name'] ?? 'Urun');
            $item->setCategory1('Kadin Giyim');
            $item->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $item->setPrice(number_format($urun['fiyat'] * $urun['adet'], 2, '.', ''));
            $basketItems[] = $item;
        }

        $kargo = new \Iyzipay\Model\BasketItem();
        $kargo->setId('KARGO');
        $kargo->setName('Kargo Ucreti');
        $kargo->setCategory1('Kargo');
        $kargo->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $kargo->setPrice('49.90');
        $basketItems[] = $kargo;

        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $conv_id = 'ODEME_' . time();
        $request->setConversationId($conv_id);
        $request->setPrice($toplam_str);
        $request->setPaidPrice($toplam_str);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setEnabledInstallments([1, 2, 3, 6, 9]);
        $request->setCallbackUrl('http://localhost:8888/web-projesi/siparis-onay.php');
        $request->setBuyer($buyer);
        $request->setShippingAddress($adres);
        $request->setBillingAddress($adres);
        $request->setBasketItems($basketItems);

        $form = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

        if ($form->getStatus() === 'success') {
            $form_html = $form->getCheckoutFormContent();
            $_SESSION['conversation_id'] = $conv_id;
        } else {
            $hata = $form->getErrorMessage();
        }
    }
}

$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['uye']);
$mode = $_GET['mod'] ?? $_POST['mod'] ?? '';

if (!$isLoggedIn && $mode !== 'misafir' && $mode !== 'uye') {
    header("Location: odeme-kontrol.php");
    exit;
}

function trPrice($value)
{
    return number_format((float) $value, 2, ",", ".");
}

$memberData = [];
if (isset($_SESSION["uye"]) && is_array($_SESSION["uye"])) {
    $memberData = $_SESSION["uye"];
}

$fields = ["ad_soyad", "email", "telefon", "adres", "ilce", "il", "posta_kodu"];
$formValues = [];
foreach ($fields as $f) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$f])) {
        $formValues[$f] = $_POST[$f];
    } elseif ($isLoggedIn) {
        $formValues[$f] = $memberData[$f] ?? "";
    } else {
        $formValues[$f] = "";
    }
}

$cartItems = [];
if (isset($_SESSION['sepet']) && is_array($_SESSION['sepet'])) {
    foreach ($_SESSION['sepet'] as $item) {
        $cartItems[] = [
            "name" => $item["ad"] ?? "Urun",
            "price" => (float) ($item["fiyat"] ?? 0),
            "qty" => (int) ($item["adet"] ?? 1),
            "size" => $item["beden"] ?? "-",
            "color" => $item["renk"] ?? "-",
        ];
    }
}
$sepetDolu = !empty($cartItems);

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

    .odeme-input,
    .odeme-select {
        width: 100%;
        border: 1px solid #d8d8d8;
        background: #fff;
        color: #111;
        padding: .64rem .72rem;
        font-size: .9rem;
    }

    .odeme-input:focus,
    .odeme-select:focus {
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
            <?php else: ?>
                Misafir olarak devam ediyorsun. Teslimat ve odeme bilgilerini doldurman gerekiyor.
            <?php endif; ?>
        </p>

        <form action="odeme.php" method="post">
            <input type="hidden" name="mod" value="<?php echo htmlspecialchars($mode, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="row g-4">
                <div class="col-lg-8 order-2 order-lg-1">
                    <section class="checkout-card">
                        <h2 class="section-head">İletişim Bilgileri</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="odeme-label" for="ad_soyad">Ad Soyad</label>
                                <input class="odeme-input"
                                    id="ad_soyad" name="ad_soyad" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["ad_soyad"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="email">E-posta</label>
                                <input class="odeme-input" id="email"
                                    name="email" type="email"
                                    value="<?php echo htmlspecialchars((string) $formValues["email"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="telefon">Telefon</label>
                                <input class="odeme-input" id="telefon" name="telefon" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["telefon"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="posta_kodu">Posta Kodu</label>
                                <input class="odeme-input" id="posta_kodu" name="posta_kodu" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["posta_kodu"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-card">
                        <h2 class="section-head">Teslimat adresi</h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="odeme-label" for="adres">Adres</label>
                                <input class="odeme-input" id="adres" name="adres" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["adres"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="ilce">İlçe</label>
                                <input class="odeme-input" id="ilce" name="ilce" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["ilce"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="odeme-label" for="il">İl</label>
                                <input class="odeme-input" id="il" name="il" type="text"
                                    value="<?php echo htmlspecialchars((string) $formValues["il"], ENT_QUOTES, "UTF-8"); ?>"
                                    required>
                            </div>
                        </div>
                    </section>

                    <?php if (isset($hata) && $hata): ?>
                        <div class="alert alert-danger" style="font-size:.85rem;padding:.75rem 1rem;">
                            Ödeme başlatılamadı: <?php echo htmlspecialchars($hata, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($form_html): ?>
                        <section class="checkout-card">
                            <h2 class="section-head">Ödeme</h2>
                            <div id="iyzipay-checkout-form" class="responsive"></div>
                            <?= $form_html ?>
                        </section>
                    <?php elseif ($sepetDolu): ?>
                        <input type="hidden" name="payment_provider" value="iyzico">
                        <button type="submit" class="btn-odeme">Güvenli ödemeye geç</button>
                    <?php else: ?>
                        <p style="font-size:.88rem;color:#c00;margin-top:.5rem;">Sepetiniz boş. Ödeme yapabilmek için önce
                            ürün ekleyin.</p>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 order-1 order-lg-2">
                    <aside class="order-summary">
                        <h2 class="section-head">Siparis ozeti</h2>

                        <?php foreach ($cartItems as $item): ?>
                            <div class="order-item">
                                <div class="order-item-name">
                                    <?php echo htmlspecialchars((string) $item["name"], ENT_QUOTES, "UTF-8"); ?>
                                </div>
                                <div class="order-item-meta">
                                    Adet: <?php echo (int) $item["qty"]; ?> | Beden:
                                    <?php echo htmlspecialchars((string) $item["size"], ENT_QUOTES, "UTF-8"); ?> | Renk:
                                    <?php echo htmlspecialchars((string) $item["color"], ENT_QUOTES, "UTF-8"); ?>
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