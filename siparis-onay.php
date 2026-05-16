<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. HATALARI GÖRÜNÜR YAPALIM (Siyah 500 ekranı yerine hatayı görebilmek için)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. KÜTÜPHANE DÜZELTMESİ (odeme.php ile aynı yöntemi kullanıyoruz)
require_once 'vendor/autoload.php';
include 'config.php';

// DİKKAT: Veritabanı bağlantı dosyanızın adı neyse onu buraya dahil etmelisin!
// Eğer veritabanı bağlantınız config.php içindeyse sorun yok.
// Ama ayrı bir dosyadaysa (örn: veritabani.php) aşağıdaki satırın başındaki // işaretini silip dosya adını yaz.
// include 'baglan.php'; 

$token = $_POST['token'] ?? null;

if (!$token) {
    http_response_code(400);
    include "header.php";
    echo '<div class="container" style="padding:3rem 1rem;">
            <p style="color:#c00;font-size:.95rem;">Geçersiz istek: ödeme token\'ı bulunamadı.</p>
          </div>';
    include "footer.php";
    exit;
}

$options = new \Iyzipay\Options();
$options->setApiKey($iyzico_api_key);
$options->setSecretKey($iyzico_secret_key);
$options->setBaseUrl($iyzico_base_url);

$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setToken($token);

$result = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

$odeme_basarili = $result->getPaymentStatus() === 'SUCCESS';

if (!$odeme_basarili) {
    include "header.php";
    ?>
    <style>
        :root { --border-soft: #e6e6e6; }
        .error-page { min-height: 60vh; padding: 3rem 1rem 4rem; }
        .error-card {
            max-width: 560px; margin: 0 auto;
            border: 1px solid var(--border-soft);
            background: #fff; padding: 2rem 1.4rem; text-align: center;
        }
        .error-title { font-size:1.2rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.5rem; color:#c00; }
        .error-text  { color:#555; font-size:.9rem; margin-bottom:1.2rem; }
        .btn-back {
            display:inline-block; min-width:200px; padding:.8rem 1rem;
            background:#000; color:#fff; border:1px solid #000;
            text-decoration:none; text-transform:uppercase;
            letter-spacing:.1em; font-size:.75rem; font-weight:700;
        }
        .btn-back:hover { background:#222; color:#fff; }
    </style>
    <main class="error-page d-flex align-items-start">
        <div class="container">
            <section class="error-card">
                <h1 class="error-title">Ödeme Başarısız</h1>
                <p class="error-text">
                    Ödemeniz tamamlanamadı veya doğrulanamadı.<br>
                    <?php if ($result->getErrorMessage()): ?>
                        Hata: <?php echo htmlspecialchars($result->getErrorMessage(), ENT_QUOTES, 'UTF-8'); ?>
                    <?php endif; ?>
                </p>
                <a href="index.php" class="btn-back">Anasayfaya dön</a>
            </section>
        </div>
    </main>
    <?php
    include "footer.php";
    exit;
}

$siparis_id = 0;
$sepet      = $_SESSION['sepet'] ?? [];
$user_id    = $_SESSION['kullanici_id'] ?? null;

if (!empty($sepet)) {
    $toplam = 0;
    foreach ($sepet as $urun) {
        $toplam += $urun['fiyat'] * $urun['adet'];
    }
    $toplam += 49.90;

    // 3. VERİTABANI HATALARINI YAKALAMAK İÇİN TRY-CATCH EKLENDİ
    try {
        if (!isset($pdo)) {
            die("<div style='padding:2rem; color:red; font-weight:bold;'>Veritabanı bağlantısı bulunamadı! Lütfen kodun üst kısmındaki include alanına veritabanı bağlantı dosyanızı (baglan.php vb.) ekleyin.</div>");
        }

        $stmt = $pdo->prepare(
            'INSERT INTO siparisler (kullanici_id, toplam, durum, tarih)
             VALUES (?, ?, ?, NOW())'
        );
        
        // Misafir kullanıcı ise user_id null gidebilir. Eğer veritabanında kullanici_id alanı zorunluysa (NOT NULL), burası hata verecektir.
        $stmt->execute([$user_id, $toplam, 'odendi']);
        $siparis_id = (int) $pdo->lastInsertId();

        $stmt2 = $pdo->prepare(
            'INSERT INTO siparis_urunler (siparis_id, urun_id, adet, fiyat)
             VALUES (?, ?, ?, ?)'
        );
        foreach ($sepet as $urun_id => $urun) {
            $stmt2->execute([$siparis_id, $urun_id, $urun['adet'], $urun['fiyat']]);
        }

        unset($_SESSION['sepet']);
    } catch (PDOException $e) {
        die("<div style='padding:2rem; color:red;'><strong>Veritabanı Hatası:</strong> " . $e->getMessage() . "</div>");
    }
}

$siparis_urunler = [];
if ($siparis_id > 0) {
    try {
        $stmt3 = $pdo->prepare('
            SELECT su.adet, su.fiyat, u.ad, u.gorsel
            FROM siparis_urunler su
            JOIN urunler u ON u.id = su.urun_id
            WHERE su.siparis_id = ?
        ');
        $stmt3->execute([$siparis_id]);
        $siparis_urunler = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('siparis-onay urun sorgu hatasi: ' . $e->getMessage());
    }
}

include "header.php";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    :root { --bg-main:#ffffff; --text-main:#111111; --text-muted:#666666; --border-soft:#e6e6e6; }
    body { background:var(--bg-main) !important; color:var(--text-main); }
    .order-success-page { min-height:100vh; padding:3rem 1rem 4rem; background:#fff; }
    .success-card {
        max-width:760px; margin:0 auto;
        border:1px solid var(--border-soft); background:#fff;
        padding:2rem 1.4rem; text-align:center;
    }
    .success-badge {
        width:56px; height:56px; margin:0 auto 1rem; border-radius:50%;
        border:1px solid #000; display:flex; align-items:center;
        justify-content:center; font-size:1.35rem; font-weight:700;
    }
    .success-title { font-size:1.35rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase; margin-bottom:.5rem; }
    .success-text  { color:var(--text-muted); font-size:.95rem; margin-bottom:1.2rem; }
    .order-no-box  { border:1px dashed #bbb; padding:.9rem 1rem; margin:0 auto 1.2rem; max-width:340px; }
    .order-no-label { font-size:.73rem; letter-spacing:.09em; text-transform:uppercase; color:#555; margin-bottom:.3rem; }
    .order-no-value { font-size:1.05rem; font-weight:700; letter-spacing:.03em; }
    .order-summary-table { width:100%; text-align:left; font-size:.88rem; margin:1.2rem 0; border-collapse:collapse; }
    .order-summary-table th { border-bottom:1px solid #000; padding:.4rem .5rem; font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:#555; }
    .order-summary-table td { padding:.5rem .5rem; border-bottom:1px solid var(--border-soft); vertical-align:middle; }
    .order-summary-table img { width:48px; aspect-ratio:3/4; object-fit:cover; border-radius:3px; }
    .order-total-row { display:flex; justify-content:space-between; font-size:.95rem; font-weight:700; padding:.75rem .5rem 0; border-top:1px solid #000; margin-top:.5rem; }
    .btn-orders {
        display:inline-block; min-width:220px; padding:.85rem 1.1rem;
        background:#000; color:#fff; border:1px solid #000; text-decoration:none;
        text-transform:uppercase; letter-spacing:.1em; font-size:.75rem; font-weight:700;
    }
    .btn-orders:hover { background:#222; color:#fff; }
    @media (min-width:992px) { .order-success-page { padding-inline:0; } }
</style>

<main class="order-success-page d-flex align-items-start">
    <div class="container">
        <section class="success-card shadow-sm">
            <div class="success-badge">✓</div>
            <h1 class="success-title">Siparişiniz alındı</h1>
            <p class="success-text">
                Teşekkür ederiz. Siparişiniz başarıyla oluşturuldu. Hazırlandığında sizi bilgilendireceğiz.
            </p>

            <div class="order-no-box">
                <div class="order-no-label">Sipariş no</div>
                <div class="order-no-value">#<?php echo $siparis_id > 0 ? $siparis_id : htmlspecialchars($result->getPaymentId(), ENT_QUOTES, 'UTF-8'); ?></div>
            </div>

            <?php if (!empty($siparis_urunler)): ?>
            <table class="order-summary-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Ürün</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>Toplam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siparis_urunler as $satir): ?>
                    <tr>
                        <td><img src="images/<?php echo htmlspecialchars($satir['gorsel'], ENT_QUOTES, 'UTF-8'); ?>" alt=""></td>
                        <td><?php echo htmlspecialchars($satir['ad'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo (int) $satir['adet']; ?></td>
                        <td><?php echo number_format($satir['fiyat'], 2, ',', '.'); ?> TL</td>
                        <td><?php echo number_format($satir['fiyat'] * $satir['adet'], 2, ',', '.'); ?> TL</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="order-total-row">
                <span>Genel Toplam</span>
                <span><?php echo number_format($result->getPaidPrice(), 2, ',', '.'); ?> TL</span>
            </div>
            <?php endif; ?>

            <div class="mt-3">
                <a href="index.php" class="btn-orders">Anasayfaya dön</a>
            </div>
        </section>
    </div>
</main>

<?php include "footer.php"; ?>