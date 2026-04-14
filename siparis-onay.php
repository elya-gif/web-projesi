<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "header.php";

$orderNo = $_GET["siparis_no"] ?? ("MGY" . date("Ymd") . rand(1000, 9999));
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
            <h1 class="success-title">Siparisiniz alindi</h1>
            <p class="success-text">
                Tesekkur ederiz. Siparisiniz basariyla olusturuldu. Hazirlandiginda sizi bilgilendirecegiz.
            </p>

            <div class="order-no-box">
                <div class="order-no-label">Siparis no</div>
                <div class="order-no-value"><?php echo htmlspecialchars((string)$orderNo, ENT_QUOTES, "UTF-8"); ?></div>
            </div>

            <a href="siparislerim.php" class="btn-orders">Siparislerime git</a>
        </section>
    </div>
</main>

<?php include "footer.php"; ?>
