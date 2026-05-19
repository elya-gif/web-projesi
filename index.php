<?php
include 'config.php';

$yeni_urunler = $pdo->query('SELECT id, ad, fiyat, gorsel, kategori FROM urunler ORDER BY id DESC LIMIT 8')->fetchAll(PDO::FETCH_ASSOC);

$kategoriler = [
    ['slug' => 'elbiseler', 'ad' => 'Elbise',   'ikon' => '👗'],
    ['slug' => 'gomlek',    'ad' => 'Gömlek',    'ikon' => '👚'],
    ['slug' => 'kazak',     'ad' => 'Kazak',     'ikon' => '🧣'],
    ['slug' => 'etek',      'ad' => 'Etek',      'ikon' => '👘'],
    ['slug' => 'tisortler', 'ad' => 'Tişört',    'ikon' => '👕'],
    ['slug' => 'toplar',    'ad' => 'Top | Body','ikon' => '🩱'],
];

include 'header.php';
?>

<style>
    :root {
        --krem: #EAE6E0;
        --koyu: #1C1C1C;
        --bej: #f4f1ea;
        --sinir: #ddd;
    }

    .hero {
        position: relative;
        height: calc(100vh - 80px);
        min-height: 520px;
        background: linear-gradient(135deg, #e8e0d5 0%, #d6cfc6 50%, #c9c0b5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 75% 50%, rgba(107,33,44,0.08) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 20% 30%, rgba(255,255,255,0.3) 0%, transparent 60%);
    }

    .hero-inner {
        position: relative;
        text-align: center;
        padding: 2rem 1.5rem;
        z-index: 1;
    }

    .hero-label {
        font-family: 'Cormorant Garamond', serif;
        font-size: .85rem;
        letter-spacing: .35em;
        text-transform: uppercase;
        color: #6B212C;
        margin-bottom: 1rem;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 8vw, 6.5rem);
        font-weight: 300;
        line-height: 1.05;
        color: var(--koyu);
        margin-bottom: 1.4rem;
        letter-spacing: .02em;
    }

    .hero-title em {
        font-style: italic;
        color: #6B212C;
    }

    .hero-sub {
        font-size: .95rem;
        color: #555;
        letter-spacing: .06em;
        margin-bottom: 2.2rem;
        max-width: 420px;
        margin-inline: auto;
    }

    .hero-btns {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        display: inline-block;
        padding: .9rem 2.4rem;
        background: var(--koyu);
        color: #fff;
        text-decoration: none;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .15em;
        border: 1px solid var(--koyu);
        transition: .2s;
    }

    .btn-hero-primary:hover { background: #333; color: #fff; }

    .btn-hero-outline {
        display: inline-block;
        padding: .9rem 2.4rem;
        background: transparent;
        color: var(--koyu);
        text-decoration: none;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .15em;
        border: 1px solid var(--koyu);
        transition: .2s;
    }

    .btn-hero-outline:hover { background: var(--koyu); color: #fff; }

    .hero-scroll {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: #888;
        animation: bounce 2s infinite;
    }

    .hero-scroll svg { width: 18px; height: 18px; stroke: #888; }

    @keyframes bounce {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50%       { transform: translateX(-50%) translateY(6px); }
    }

    /* ── BANT ── */
    .info-band {
        background: var(--koyu);
        color: #fff;
        display: flex;
        justify-content: center;
        gap: 0;
        flex-wrap: wrap;
    }

    .info-band-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .9rem 2.2rem;
        font-size: .72rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        border-right: 1px solid #333;
    }

    .info-band-item:last-child { border-right: none; }
    .info-band-item svg { width: 16px; height: 16px; stroke: #c9a063; flex-shrink: 0; }

    /* ── KATEGORİLER ── */
    .section { padding: 4rem 1rem; }
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        font-weight: 400;
        text-align: center;
        margin-bottom: .5rem;
        color: var(--koyu);
    }

    .section-sub {
        text-align: center;
        font-size: .8rem;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 2.5rem;
    }

    .kat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .kat-kart {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        padding: 1.6rem 1rem;
        background: #fff;
        border: 1px solid var(--sinir);
        text-decoration: none;
        color: var(--koyu);
        transition: .2s;
    }

    .kat-kart:hover {
        background: var(--koyu);
        color: #fff;
        border-color: var(--koyu);
    }

    .kat-ikon { font-size: 1.8rem; line-height: 1; }
    .kat-ad { font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }

    /* ── ÖZEL BANNER ── */
    .promo-banner {
        background: linear-gradient(120deg, #6B212C 0%, #8d2a37 100%);
        color: #fff;
        text-align: center;
        padding: 3.5rem 1.5rem;
        margin: 0 1rem 4rem;
        position: relative;
        overflow: hidden;
    }

    .promo-banner::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
    }

    .promo-banner::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -20px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
    }

    .promo-label {
        font-size: .7rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        opacity: .7;
        margin-bottom: .7rem;
    }

    .promo-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 300;
        margin-bottom: .7rem;
        line-height: 1.1;
    }

    .promo-desc {
        font-size: .85rem;
        opacity: .8;
        margin-bottom: 1.6rem;
        max-width: 360px;
        margin-inline: auto;
    }

    .btn-promo {
        display: inline-block;
        padding: .8rem 2rem;
        background: #fff;
        color: #6B212C;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        text-decoration: none;
        border: 1px solid #fff;
        transition: .2s;
    }

    .btn-promo:hover { background: transparent; color: #fff; }

    .urun-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.2rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    .urun-kart {
        background: #fff;
        border: 1px solid var(--sinir);
        text-decoration: none;
        color: var(--koyu);
        display: block;
        transition: .2s;
        position: relative;
    }

    .urun-kart:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-3px); }

    .urun-img-wrap {
        aspect-ratio: 3/4;
        overflow: hidden;
        background: var(--bej);
    }

    .urun-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform .4s;
    }

    .urun-kart:hover .urun-img-wrap img { transform: scale(1.05); }

    .urun-yeni-badge {
        position: absolute;
        top: .75rem; left: .75rem;
        background: var(--koyu);
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: .2rem .55rem;
    }

    .urun-info {
        padding: .85rem .9rem;
    }

    .urun-ad {
        font-size: .85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: .2rem;
    }

    .urun-kat {
        font-size: .72rem;
        color: #999;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: .4rem;
    }

    .urun-fiyat {
        font-size: .9rem;
        font-weight: 700;
    }

    .tum-btn-wrap { text-align: center; margin-top: 2.5rem; }
    .btn-tum {
        display: inline-block;
        padding: .9rem 2.8rem;
        border: 1px solid var(--koyu);
        background: transparent;
        color: var(--koyu);
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        text-decoration: none;
        transition: .2s;
    }
    .btn-tum:hover { background: var(--koyu); color: #fff; }

    .degerler { background: #fff; }
    .deger-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
    }

    .deger-item svg { width: 36px; height: 36px; stroke: #6B212C; margin-bottom: .9rem; }
    .deger-baslik {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: .4rem;
    }
    .deger-acik { font-size: .8rem; color: #888; line-height: 1.6; }

    @media (max-width: 640px) {
        .info-band-item { padding: .7rem 1.2rem; font-size: .65rem; }
        .promo-banner { margin: 0 0 3rem; }
    }
</style>

<section class="hero">
    <div class="hero-inner">
        <p class="hero-label">2026 Yaz Koleksiyonu</p>
        <h1 class="hero-title">Zarafet<br><em>Sende Başlar</em></h1>
        <p class="hero-sub">Özenle seçilmiş parçalar, kaliteli kumaşlar ve zamansız tasarımlar.</p>
        <div class="hero-btns">
            <a href="sayfalist.php" class="btn-hero-primary">Koleksiyonu Keşfet</a>
            <a href="sayfalist.php?kategori=elbiseler" class="btn-hero-outline">Elbiseler</a>
        </div>
    </div>
    <div class="hero-scroll">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
        Kaydır
    </div>
</section>

<div class="info-band">
    <div class="info-band-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
        </svg>
        Ücretsiz Kargo — 1000 TL Üzeri
    </div>
    <div class="info-band-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
        </svg>
        14 Gün İade Garantisi
    </div>
    <div class="info-band-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
        Güvenli Ödeme
    </div>
    <div class="info-band-item">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V20l4.155-4.155"/>
        </svg>
        7/24 Destek
    </div>
</div>

<!-- KATEGORİLER -->
<section class="section" style="background: var(--bej);">
    <div class="container-fluid px-3">
        <p class="section-sub">Kategoriler</p>
        <h2 class="section-title">Ne Arıyorsun?</h2>
        <div class="kat-grid">
            <?php foreach ($kategoriler as $k): ?>
                <a href="sayfalist.php?kategori=<?php echo urlencode($k['slug']); ?>" class="kat-kart">
                    <span class="kat-ikon"><?php echo $k['ikon']; ?></span>
                    <span class="kat-ad"><?php echo htmlspecialchars($k['ad']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- YENİ ÜRÜNLER -->
<section class="section">
    <div class="container-fluid px-3">
        <p class="section-sub">Yeni Gelenler</p>
        <h2 class="section-title">Yeni Koleksiyon</h2>
        <div class="urun-grid">
            <?php foreach ($yeni_urunler as $u): ?>
                <a href="urun-detay.php?id=<?php echo $u['id']; ?>" class="urun-kart">
                    <div class="urun-img-wrap">
                        <?php
                            $gorsel_val = $u['gorsel'];
                            $gorseller_arr = json_decode($gorsel_val, true);
                            if (is_array($gorseller_arr) && !empty($gorseller_arr)) {
                                $gorsel_src = htmlspecialchars($gorseller_arr[0]);
                            } else {
                                $gorsel_src = htmlspecialchars($gorsel_val);
                            }
                        ?>
                        <img src="<?php echo $gorsel_src; ?>"
                             alt="<?php echo htmlspecialchars($u['ad']); ?>"
                             onerror="this.src='images/placeholder.jpg'">
                    </div>
                    <span class="urun-yeni-badge">Yeni</span>
                    <div class="urun-info">
                        <div class="urun-kat"><?php echo htmlspecialchars($u['kategori']); ?></div>
                        <div class="urun-ad"><?php echo htmlspecialchars($u['ad']); ?></div>
                        <div class="urun-fiyat"><?php echo number_format($u['fiyat'], 2, ',', '.'); ?> TL</div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="tum-btn-wrap">
            <a href="sayfalist.php" class="btn-tum">Tüm Ürünleri Gör</a>
        </div>
    </div>
</section>

<div class="promo-banner">
    <p class="promo-label">Özel Teklif</p>
    <h2 class="promo-title">Yazın En Şık<br>Parçaları Burada</h2>
    <p class="promo-desc">Yeni sezon elbise koleksiyonumuzu keşfet, gardırobunu yenile.</p>
    <a href="sayfalist.php?kategori=elbiseler" class="btn-promo">Elbiseleri Keşfet</a>
</div>

<section class="section degerler">
    <div class="container-fluid px-3">
        <p class="section-sub">Neden Megay Moda?</p>
        <h2 class="section-title">Farkımız</h2>
        <div class="deger-grid">
            <div class="deger-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                </svg>
                <div class="deger-baslik">Kaliteli Kumaş</div>
                <div class="deger-acik">Her parça özenle seçilmiş, yüksek kaliteli kumaşlardan üretilir.</div>
            </div>
            <div class="deger-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
                <div class="deger-baslik">Hızlı Teslimat</div>
                <div class="deger-acik">Siparişleriniz 1–3 iş günü içinde kapınıza gelir.</div>
            </div>
            <div class="deger-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                <div class="deger-baslik">Müşteri Memnuniyeti</div>
                <div class="deger-acik">14 gün içinde koşulsuz iade ve değişim imkânı.</div>
            </div>
            <div class="deger-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
                <div class="deger-baslik">Özel Tasarım</div>
                <div class="deger-acik">Sezona özel, trend ve şık parçalar her hafta güncellenir.</div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
