<?php include "header.php"; ?>

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
        --heart-active: #e63946;
    }

    body {
        background: var(--bg-main) !important;
        color: var(--text-main);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .favs-page {
        min-height: 100vh;
        padding: 3rem 1rem 4rem;
    }

    .favs-title {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: .35rem;
    }

    .favs-subtitle {
        font-size: .9rem;
        color: var(--text-muted);
        margin-bottom: 1.4rem;
    }

    .fav-card {
        border: 1px solid var(--border-soft);
        background: #fff;
        height: 100%;
    }

    .fav-image {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        background: #f5f5f5;
    }

    .fav-body {
        padding: .8rem;
    }

    .fav-name {
        font-size: .88rem;
        font-weight: 600;
        margin-bottom: .25rem;
        min-height: 40px;
    }

    .fav-price {
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: .5rem;
    }

    .fav-meta {
        font-size: .75rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: .6rem;
    }

    .fav-actions {
        display: flex;
        gap: .45rem;
    }

    .fav-btn {
        flex: 1;
        border: 1px solid #000;
        background: #fff;
        color: #000;
        padding: .45rem .5rem;
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
    }

    .fav-btn-dark {
        background: #000;
        color: #fff;
    }

    .fav-btn-dark:hover {
        color: #fff;
        background: #222;
    }

    .fav-remove {
        border-color: var(--heart-active);
        color: var(--heart-active);
    }

    .empty-favs {
        border: 1px dashed #cfcfcf;
        padding: 2rem 1.2rem;
        text-align: center;
        color: var(--text-muted);
        font-size: .95rem;
    }

    @media (min-width: 992px) {
        .favs-page {
            padding-inline: 0;
        }
    }
</style>

<main class="favs-page d-flex align-items-start">
    <div class="container">
        <h1 class="favs-title">Favorilerim</h1>
        <p class="favs-subtitle">favori ürünlerin</p>
        <p class="favs-subtitle" id="favoritesCountText">0 urun</p>

        <div id="favoritesEmpty" class="empty-favs d-none">
            Henuz favori urunun yok. Urun kartlarindaki kalp ikonundan favori ekleyebilirsin.
        </div>

        <div class="row g-3 g-md-4" id="favoritesGrid"></div>
    </div>
</main>

<script>
(function () {
    const FAV_KEY = 'megay_favorites';
    const grid = document.getElementById('favoritesGrid');
    const emptyBox = document.getElementById('favoritesEmpty');
    const countText = document.getElementById('favoritesCountText');

    function formatPrice(n) {
        const value = Number(n || 0);
        return value.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' TL';
    }

    function getFavorites() {
        try {
            const raw = localStorage.getItem(FAV_KEY);
            const parsed = raw ? JSON.parse(raw) : [];
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) {
            return [];
        }
    }

    function saveFavorites(items) {
        localStorage.setItem(FAV_KEY, JSON.stringify(items));
    }

    function removeFavorite(productId) {
        const list = getFavorites().filter(function (item) {
            return String(item.id) !== String(productId);
        });
        saveFavorites(list);
        renderFavorites();
    }

    function renderFavorites() {
        const items = getFavorites();
        grid.innerHTML = '';
        countText.textContent = items.length + ' urun';

        if (!items.length) {
            emptyBox.classList.remove('d-none');
            return;
        }

        emptyBox.classList.add('d-none');

        items.forEach(function (item) {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3';
            col.innerHTML = `
                <article class="fav-card">
                    <img class="fav-image" src="${item.image || ''}" alt="${item.name || ''}">
                    <div class="fav-body">
                        <div class="fav-name">${item.name || ''}</div>
                        <div class="fav-price">${formatPrice(item.price)}</div>
                        <div class="fav-meta">${(item.category || 'urun').toString().toUpperCase()}</div>
                        <div class="fav-actions">
                            <a class="fav-btn fav-btn-dark" href="${item.url || 'urun-detay.php'}">Incele</a>
                            <button type="button" class="fav-btn fav-remove js-fav-remove" data-id="${item.id}">Kaldir</button>
                        </div>
                    </div>
                </article>
            `;
            grid.appendChild(col);
        });

        grid.querySelectorAll('.js-fav-remove').forEach(function (btn) {
            btn.addEventListener('click', function () {
                removeFavorite(this.getAttribute('data-id'));
            });
        });
    }

    renderFavorites();
})();
</script>

<?php include "footer.php"; ?>
