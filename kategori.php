<?php include 'header.php'; ?>

<style>
    :root {
        --color-primary:   #6b212c;
        --color-secondary: #7a90a8;
        --color-accent:    #aecaeb;
        --color-bg:        #eae6e0;
        --color-black:     #000000;
        --color-white:     #ffffff;
    }

    /* Offcanvas – kadın kategorisi */
    .offcanvas-kadin {
        background: var(--color-bg);
        color: var(--color-black);
    }

    .offcanvas-kadin .btn-category {
        border-radius: 0;
        border: none;
        background: var(--color-primary);
        color: var(--color-white);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.8rem;
        text-align: left;
        padding: 0.6rem 0.25rem;
        width: 100%;
    }

    .offcanvas-kadin .btn-category + .btn-category { margin-top: 0.4rem; }

    .offcanvas-kadin .btn-category:hover,
    .offcanvas-kadin .btn-category.active {
        background: var(--color-primary);
        opacity: 0.85;
    }

    /* Kadın master alan */
    #kadin-master {
        background: var(--color-white);
        color: #1C1C1C;
        padding: 3rem 1rem 4rem;
    }

    @media (min-width: 992px) {
        #kadin-master { padding: 4rem 3rem 5rem; }
    }

    .kadin-shell { max-width: 1100px; margin: 0 auto; }

    .kadin-heading {
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-size: 0.9rem;
    }

    /* Kategori panelleri */
    .category-panel {
        display: none;
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.35s ease, transform 0.35s ease;
    }

    .category-panel.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .category-title {
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-size: 0.9rem;
    }

    .category-subtitle {
        font-size: 0.85rem;
        color: rgba(0, 0, 0, 0.65);
    }

    /* Kartlar */
    .category-card {
        border-radius: 0.6rem;
        overflow: hidden;
        background: var(--color-secondary);
    }

    .category-card.alt {
        background: var(--color-accent);
        color: var(--color-black);
    }

    .category-card.alt .card-title,
    .category-card.alt .card-text,
    .category-card.alt a { color: var(--color-black); }

    .category-card a {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    /* Alt kategori listesi */
    .subcategory-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #1C1C1C;
        text-decoration: none;
    }

    .subcategory-badge {
        background: var(--color-primary);
        color: var(--color-white);
        font-size: 0.7rem;
        padding: 0.1rem 0.45rem;
        border-radius: 999px;
    }

    .info-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        border: 1px solid rgba(0, 0, 0, 0.14);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
    }
</style>

<!-- Offcanvas – Kadın Kategori Menüsü -->
<div class="offcanvas offcanvas-start offcanvas-kadin"
     tabindex="-1"
     id="kadinCategoryMenu"
     aria-labelledby="kadinCategoryMenuLabel">

    <div class="offcanvas-header border-bottom border-light border-opacity-25">
        <h5 class="offcanvas-title text-uppercase small" id="kadinCategoryMenuLabel">
            Kadın Kategorileri
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Kapat"></button>
    </div>

    <div class="offcanvas-body">
        <nav class="nav flex-column gap-2 text-uppercase small">
            <button class="btn btn-category active" data-kadin-category="one-cikan">Öne Çıkanlar</button>
            <button class="btn btn-category" data-kadin-category="hazir-giyim">Hazır Giyim</button>
        </nav>
    </div>
</div>

<!-- Ana İçerik -->
<main id="kadin-master">
    <div class="kadin-shell">

        <div class="mb-4">
            <div class="kadin-heading mb-2">Kadın Koleksiyonu</div>
        </div>

        <!-- Panel: Öne Çıkanlar -->
        <section class="category-panel active" data-kadin-panel="one-cikan">
            <header class="mb-3">
                <h2 class="category-title mb-1">Öne Çıkanlar — Kadın</h2>
                <p class="category-subtitle mb-0">Kadın koleksiyonunun en çok tercih edilen görünümlerini keşfedin.</p>
            </header>

            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <div class="card category-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <img src="img/imgkadin-ceket-ornek.jpeg" alt="Kadın ceket örnek görseli" class="img-fluid rounded-3 mb-3">
                                <h3 class="card-title h6 text-uppercase">İkonik Ceketler</h3>
                                <p class="card-text small text-white-50 mb-3">Zamansız silüetler, modern dokunuşlarla yeniden tasarlandı.</p>
                            </div>
                            <a href="#">Koleksiyonu gör</a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="card category-card alt h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <img src="img/imgkadin-elbise-ornek.jpeg" alt="Kadın elbise örnek görseli" class="img-fluid rounded-3 mb-3">
                                <h3 class="card-title h6 text-uppercase">Elbiseler</h3>
                                <p class="card-text small mb-3">Gün boyu konfor ve şehir şıklığı bir arada.</p>
                            </div>
                            <a href="#">Tüm elbiseler</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card category-card h-100" style="background: var(--color-primary);">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h3 class="card-title h6 text-uppercase">Koleksiyona Genel Bakış</h3>
                                <p class="card-text small text-white-50 mb-3">Kadın koleksiyonunun tüm kategorilerine bu sayfadan ulaşabilirsiniz.</p>
                            </div>
                            <span class="info-pill">
                                Tüm Kadın
                                <span class="subcategory-badge">Master Sayfa</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Panel: Hazır Giyim -->
        <section class="category-panel" data-kadin-panel="hazir-giyim">
            <header class="mb-3">
                <h2 class="category-title mb-1">Hazır Giyim</h2>
                <p class="category-subtitle mb-0">Gündüzden geceye uzanan kadın giyim parçaları.</p>
            </header>

            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="subcategory-list">
                        <a href="#">Ceket &amp; Blazer <span class="subcategory-badge">Yeni</span></a>
                        <a href="#">Elbise <span class="subcategory-badge">Klasik</span></a>
                        <a href="#">Gömlek &amp; Bluz <span class="subcategory-badge">İkonik</span></a>
                        <a href="#">Triko <span class="subcategory-badge">Konfor</span></a>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card category-card alt h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <img src="img/kadin-etek-ornek.jpg" alt="Kadın etek örnek görseli" class="img-fluid rounded-3 mb-3">
                                <h3 class="card-title h6 text-uppercase">Stil Hikâyeleri</h3>
                                <p class="card-text small mb-3">Kadın hazır giyim kombinlerini tek bir bakışta keşfedin.</p>
                            </div>
                            <a href="#">Tüm hazır giyim</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<?php include 'footer.php'; ?>

<script>
(function () {
    const offcanvasEl     = document.getElementById('kadinCategoryMenu');
    const menuTrigger     = document.getElementById('menuTrigger');
    const categoryButtons = document.querySelectorAll('[data-kadin-category]');
    const categoryPanels  = document.querySelectorAll('[data-kadin-panel]');

    let offcanvasInstance = null;
    if (offcanvasEl && typeof bootstrap !== 'undefined') {
        offcanvasInstance = new bootstrap.Offcanvas(offcanvasEl);
    }

    if (menuTrigger && offcanvasInstance) {
        menuTrigger.addEventListener('click', function () {
            offcanvasInstance.toggle();
        });
    }

    function showPanel(name) {
        if (!name) return;
        categoryPanels.forEach(function (panel) {
            panel.classList.toggle('active', panel.dataset.kadinPanel === name);
        });
        categoryButtons.forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.kadinCategory === name);
        });
        if (offcanvasInstance) offcanvasInstance.hide();
    }

    categoryButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            showPanel(this.dataset.kadinCategory);
        });
    });
})();
</script>