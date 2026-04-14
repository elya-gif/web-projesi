<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['uye']);

if ($isLoggedIn) {
    header("Location: odeme.php?mod=uye");
    exit;
}

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

    .checkout-choice-page {
        min-height: 100vh;
        padding: 3rem 1rem 4rem;
        background: #fff;
    }

    .checkout-title {
        font-size: 1.55rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 1.8rem;
    }

    .checkout-subtitle {
        color: var(--text-muted);
        font-size: .95rem;
        margin-bottom: 1.5rem;
    }

    .checkout-choice-card {
        border: 1px solid var(--border-soft);
        background: #fff;
        height: 100%;
    }

    .checkout-choice-card .card-body {
        padding: 1.4rem;
    }

    .checkout-choice-head {
        font-size: .95rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: .7rem;
    }

    .checkout-choice-text {
        color: #444;
        font-size: .9rem;
        min-height: 48px;
    }

    .btn-checkout-primary {
        display: block;
        width: 100%;
        background: #000;
        color: #fff;
        border: 1px solid #000;
        padding: .8rem 1rem;
        text-decoration: none;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .74rem;
        font-weight: 700;
    }

    .btn-checkout-primary:hover {
        color: #fff;
        background: #222;
    }

    .btn-checkout-secondary {
        display: block;
        width: 100%;
        background: #fff;
        color: #000;
        border: 1px solid #000;
        padding: .8rem 1rem;
        text-decoration: none;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .74rem;
        font-weight: 700;
    }

    .btn-checkout-secondary:hover {
        color: #000;
        background: #f6f6f6;
    }

    @media (min-width: 992px) {
        .checkout-choice-page {
            padding-inline: 0;
        }
    }
</style>

<main class="checkout-choice-page d-flex align-items-start">
    <div class="container">
        <h1 class="checkout-title">Ödeme adımı</h1>
        <p class="checkout-subtitle">
            Ödemeye devam etmek için hesap durumunu seç. Hesabın varsa giriş yaparak kayıtlı adreslerinle hızlıca devam edebilirsin.
        </p>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card checkout-choice-card">
                    <div class="card-body">
                        <h2 class="checkout-choice-head">Kayıtlı müşteri</h2>
                        <p class="checkout-choice-text">Hesabın varsa üye girişi yap, teslimat ve fatura bilgilerin otomatik gelsin.</p>
                        <a href="giris.php?redirect=odeme-kontrol.php" class="btn-checkout-primary">Üye girişi ile devam et</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card checkout-choice-card">
                    <div class="card-body">
                        <h2 class="checkout-choice-head">Misafir alışverişi</h2>
                        <p class="checkout-choice-text">Hesap oluşturmadan devam et, teslimat bilgilerini bu adımda kendin gir.</p>
                        <a href="odeme.php?mod=misafir" class="btn-checkout-secondary">Misafir olarak devam et</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
