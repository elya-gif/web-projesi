<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giriş kontrolü — yapılmadıysa giris.php'ye yönlendir
if (!isset($_SESSION['kullanici_id'])) {
    header('Location: giris.php');
    exit;
}

include 'config.php';

// DB'den kullanıcı bilgilerini çek
$stmt = $pdo->prepare('SELECT * FROM kullanicilar WHERE id = ?');
$stmt->execute([$_SESSION['kullanici_id']]);
$kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kullanici) {
    // Kullanıcı DB'de bulunamazsa oturumu kapat
    session_destroy();
    header('Location: giris.php');
    exit;
}

$adresMesaji  = '';
$kisiselMesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_adres_kaydet'])) {
    $_SESSION['teslimat_adresi'] = trim((string)($_POST['teslimat_adresi'] ?? ''));
    $_SESSION['fatura_adresi']   = trim((string)($_POST['fatura_adresi'] ?? ''));
    $adresMesaji = 'Adres bilgileri güncellendi.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_kisisel_kaydet'])) {
    $_SESSION['kullanici_ad']    = trim((string)($_POST['kullanici_adi'] ?? ''));
    $_SESSION['kullanici_email'] = trim((string)($_POST['kullanici_email'] ?? ''));
    $_SESSION['kullanici_telefon'] = trim((string)($_POST['kullanici_telefon'] ?? ''));
    $kisiselMesaj = 'Kişisel bilgiler güncellendi.';
}

// Gösterilecek değerler — SESSION güncellendiyse onu, yoksa DB'den geleni kullan
$kullaniciAdi    = isset($_SESSION['kullanici_ad']) && $_SESSION['kullanici_ad'] !== ''
                   ? $_SESSION['kullanici_ad'] : $kullanici['ad'];
$kullaniciMail   = isset($_SESSION['kullanici_email']) && $_SESSION['kullanici_email'] !== ''
                   ? $_SESSION['kullanici_email'] : $kullanici['eposta'];
$kullaniciTelefon = isset($_SESSION['kullanici_telefon']) && $_SESSION['kullanici_telefon'] !== ''
                   ? $_SESSION['kullanici_telefon'] : 'Telefon bilgisi eklenmedi.';
$teslimatAdresi  = isset($_SESSION['teslimat_adresi']) && $_SESSION['teslimat_adresi'] !== ''
                   ? $_SESSION['teslimat_adresi'] : 'Adres bilgisi eklenmedi.';
$faturaAdresi    = isset($_SESSION['fatura_adresi']) && $_SESSION['fatura_adresi'] !== ''
                   ? $_SESSION['fatura_adresi'] : 'Adres bilgisi eklenmedi.';

include 'header.php';
?>

<style>
    :root {
        --bg-color: #ffffff;
        --text-color: #000000;
        --accent-color: #c9a063;
        --border-color: #e6e6e6;
        --muted-text: #666666;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .profile-card {
        border: 1px solid var(--border-color);
        border-radius: 14px;
        background-color: #fff;
        padding: 1.2rem;
        height: 100%;
    }

    .profile-title {
        letter-spacing: .1em;
        text-transform: uppercase;
        font-size: .95rem;
        color: var(--muted-text);
        margin-bottom: .9rem;
    }

    .profile-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: .25rem;
    }

    .quick-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        text-decoration: none;
        color: #000;
        padding: .85rem 1rem;
        margin-bottom: .6rem;
        transition: all .15s ease;
        background-color: #fff;
    }

    .quick-link:hover {
        border-color: #000;
        transform: translateY(-1px);
        color: #000;
    }

    .quick-link.logout {
        border-color: #f3d1d1;
        background-color: #fff8f8;
        color: #b02a37;
    }

    .quick-link.logout:hover { border-color: #b02a37; }

    .section-label {
        font-size: .8rem;
        letter-spacing: .08em;
        color: var(--muted-text);
        text-transform: uppercase;
        margin-bottom: .35rem;
    }

    .section-value {
        font-size: .95rem;
        margin-bottom: .9rem;
    }

    .inline-edit-box {
        border-top: 1px dashed var(--border-color);
        margin-top: .6rem;
        padding-top: .9rem;
    }
</style>

<div class="container py-4 py-md-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Profilim</h1>
            <p class="text-muted mb-0">Hesap ayarlarınızı ve sipariş bilgilerinizi buradan yönetin.</p>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-4">
            <div class="profile-card">
                <div class="profile-title">Hesap Özeti</div>
                <div class="profile-name"><?php echo htmlspecialchars($kullaniciAdi); ?></div>
                <div class="text-muted mb-3"><?php echo htmlspecialchars($kullaniciMail); ?></div>
                <div class="small text-muted">Üyeliğiniz aktif durumda.</div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="profile-card">
                <div class="profile-title">Hızlı Erişim</div>
                <a class="quick-link" href="favoriler.php">
                    <span>Favorilerim</span>
                    <span>&rarr;</span>
                </a>
                <a class="quick-link" href="siparislerim.php">
                    <span>Siparişlerim</span>
                    <span>&rarr;</span>
                </a>
                <a class="quick-link logout" href="cikis.php">
                    <span>Çıkış Yap</span>
                    <span>&#x1F511;</span>
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="profile-card">
                <div class="profile-title">Adres Bilgileri</div>
                <div class="section-label">Teslimat Adresi</div>
                <div class="section-value"><?php echo nl2br(htmlspecialchars($teslimatAdresi)); ?></div>

                <div class="section-label">Fatura Adresi</div>
                <div class="section-value"><?php echo nl2br(htmlspecialchars($faturaAdresi)); ?></div>

                <?php if ($adresMesaji !== ''): ?>
                    <div class="alert alert-success py-2 small"><?php echo htmlspecialchars($adresMesaji); ?></div>
                <?php endif; ?>

                <button class="btn btn-outline-dark btn-sm" type="button"
                    data-bs-toggle="collapse" data-bs-target="#adresDuzenleFormu">
                    Adreslerimi Düzenle
                </button>

                <div class="collapse inline-edit-box" id="adresDuzenleFormu">
                    <form method="post" action="">
                        <div class="mb-2">
                            <label class="form-label small mb-1" for="teslimat_adresi">Teslimat Adresi</label>
                            <textarea class="form-control form-control-sm" id="teslimat_adresi" name="teslimat_adresi" rows="3"><?php echo htmlspecialchars($_SESSION['teslimat_adresi'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small mb-1" for="fatura_adresi">Fatura Adresi</label>
                            <textarea class="form-control form-control-sm" id="fatura_adresi" name="fatura_adresi" rows="3"><?php echo htmlspecialchars($_SESSION['fatura_adresi'] ?? ''); ?></textarea>
                        </div>
                        <button class="btn btn-dark btn-sm" type="submit" name="profil_adres_kaydet" value="1">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="profile-card">
                <div class="profile-title">Kişisel Bilgiler</div>
                <div class="section-label">Ad Soyad</div>
                <div class="section-value"><?php echo htmlspecialchars($kullaniciAdi); ?></div>

                <div class="section-label">E-Posta</div>
                <div class="section-value"><?php echo htmlspecialchars($kullaniciMail); ?></div>

                <div class="section-label">Telefon</div>
                <div class="section-value"><?php echo htmlspecialchars($kullaniciTelefon); ?></div>

                <?php if ($kisiselMesaj !== ''): ?>
                    <div class="alert alert-success py-2 small"><?php echo htmlspecialchars($kisiselMesaj); ?></div>
                <?php endif; ?>

                <button class="btn btn-outline-dark btn-sm" type="button"
                    data-bs-toggle="collapse" data-bs-target="#kisiselDuzenleFormu">
                    Bilgilerimi Güncelle
                </button>

                <div class="collapse inline-edit-box" id="kisiselDuzenleFormu">
                    <form method="post" action="">
                        <div class="mb-2">
                            <label class="form-label small mb-1" for="kullanici_adi">Ad Soyad</label>
                            <input class="form-control form-control-sm" id="kullanici_adi" name="kullanici_adi" type="text"
                                value="<?php echo htmlspecialchars($kullaniciAdi); ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small mb-1" for="kullanici_email">E-Posta</label>
                            <input class="form-control form-control-sm" id="kullanici_email" name="kullanici_email" type="email"
                                value="<?php echo htmlspecialchars($kullaniciMail); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small mb-1" for="kullanici_telefon">Telefon</label>
                            <input class="form-control form-control-sm" id="kullanici_telefon" name="kullanici_telefon" type="text"
                                value="<?php echo htmlspecialchars(isset($_SESSION['kullanici_telefon']) ? $_SESSION['kullanici_telefon'] : ''); ?>">
                        </div>
                        <button class="btn btn-dark btn-sm" type="submit" name="profil_kisisel_kaydet" value="1">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>

<?php include 'footer.php'; ?>