<?php
require_once 'vendor/autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$girisYapildi = isset($_SESSION['kullanici_id']);


$sepetSayi = 0;
if (!empty($_SESSION['sepet']) && is_array($_SESSION['sepet'])) {
    foreach ($_SESSION['sepet'] as $sepet_item) {
        if (isset($sepet_item['adet']) && (int)$sepet_item['adet'] > 0) {
            $sepetSayi += (int) $sepet_item['adet'];
        }
    }
}
?>





<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Başlığı</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f1ea;
            padding-top: 80px;
            font-family: Arial, sans-serif;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            z-index: 1000;
        }

        .header.scrolled {
            background: #EAE6E0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .menu-toggle {
            position: static;
            left: 40px;
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 20px;
            cursor: pointer;
            color: #1C1C1C;
            background: none;
            border: none;
        }

        .logo {
            position: absolute;
            left: 50%;
            top: 5%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
        }

        .logo a {
            font-size: 24px;
            text-decoration: none;
            color: black;

            transition: font-size 0.3s ease-in-out;
        }

        .scrolled .logo a {
            font-size: 36px;
        }

        .logo a {
            text-decoration: none;
            font-family: "Cormorant Garamond", serif;
            font-size: 48px;
            letter-spacing: 3px;
            font-weight: 600;
            color: #1C1C1C;
        }

        .nav-icons {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
            height: 24px;
            margin-top: 0.5%;
        }


        .nav-icons a:hover {
            opacity: 0.6;
        }

        .sepet-sayi {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #000;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .category-bar {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 15px;
            background: #f5f5f5;
        }

        .category-bar a {
            text-decoration: none;
            color: black;
            font-size: 16px;
        }

        .mobile-menu {
            position: fixed;
            left: -260px;
            top: 0;
            width: 260px;
            height: 100%;
            background: white;
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            transition: 0.3s;
            z-index: 20000;
        }

        .menu-title {
            font-size: 20px;
            font-weight: 600;
            padding: 20px 25px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            background: #EAE6E0;
        }


        .search-container {
            display: flex;
            align-items: center;
            height: 24px;
        }

        #searchBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            line-height: 1;
        }

        #searchBtn svg {
            display: block;
        }

        .search-box {
            width: 0;
            opacity: 0;
            overflow: hidden;
            transition: 0.4s ease;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            border-bottom: 1px solid #000;
            padding: 5px 10px;
            width: 220px;
            font-size: 15px;
        }

        .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-icons a {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #1C1C1C;
            transition: 0.3s;
            position: relative;
        }

        .nav-icons svg {
            width: 22px;
            height: 22px;
            display: block;
        }

        .nav-icons.active .search-box {
            width: 230px;
            opacity: 1;
            margin-left: 10px;
        }

        .nav-icons.active>a {
            display: none;
        }

        .mobile-menu a {
            padding: 15px 25px;
            text-decoration: none;
            color: black;
            font-size: 18px;
        }

        .mobile-menu.active {
            left: 0;
        }

        @media (max-width:1200px) {
            .category-bar {
                display: none;
            }
        }

        @media (max-width:1200px) {
            .menu-toggle {
                display: flex;
            }
        }


        @media (max-width: 991px) {
            .header {
                padding: 15px 20px;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
            .menu-toggle {
                margin: 0 !important;
            }
            .logo {
                position: static !important;
                transform: none !important;
                flex: 1 !important;
                display: flex !important;
                justify-content: center !important;
                padding: 0 10px !important;
            }
            .logo a {
                font-size: 16px !important; 
                letter-spacing: 1px !important;
                white-space: nowrap !important;
                display: inline-block !important;
            }
            .scrolled .logo a {
                font-size: 16px !important;
            }
            .nav-icons {
                margin-left: 0 !important;
                margin-top: 0 !important;
                gap: 12px !important;
            }
            .nav-icons a, .nav-icons svg {
                width: 20px !important;
                height: 20px !important;
            }
        }
    </style>
</head>

<body>

    
    <header class="header" id="header">

        <button class="menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" stroke="black" fill="none" stroke-width="2"
                viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="logo">
            <a href="anasayfa.php">MEGAY MODA</a>
        </div>

        <div class="nav-icons">

            <div class="search-container">

                <a href="#" id="searchBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black"
                        stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>

                <div class="search-box">
                    <form action="arama.php" method="GET">
                        <input type="text" name="q" placeholder="Ürün ara...">
                    </form>
                </div>

            </div>

            <a href="favoriler.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path
                        d="M12 21s-7-4.5-9-8.5C1 8 3.5 5 6.5 5c2 0 3.5 1.5 5.5 3.5C14 6.5 15.5 5 17.5 5 20.5 5 23 8 21 12.5 19 16.5 12 21 12 21z" />
                </svg>
            </a>

            <a href="sepet.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 6h15l-1.5 9h-13z"></path>
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="18" cy="21" r="1"></circle>
                </svg>
                <?php if ($sepetSayi > 0): ?>
                    <span class="sepet-sayi"><?php echo $sepetSayi; ?></span>
                <?php endif; ?>
            </a>

            <?php if ($girisYapildi): ?>
                <a href="profil.php" title="Profil">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black"
                        stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a8.38 8.38 0 0 1 13 0"></path>
                    </svg>
                </a>
            <?php else: ?>
                <a href="giris.php" title="Giriş Yap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black"
                        stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a8.38 8.38 0 0 1 13 0"></path>
                    </svg>
                </a>
            <?php endif; ?>

        </div>

    </header>

    <nav class="category-bar">
        <a href="sayfalist.php?kategori=kazak">Kazak</a>
        <a href="sayfalist.php?kategori=gomlek">Gömlek</a>
        <a href="sayfalist.php?kategori=elbiseler">Elbise</a>
        <a href="sayfalist.php?kategori=tisortler">Tişört</a>
        <a href="sayfalist.php?kategori=toplar">Top | Body</a>
        <a href="sayfalist.php?kategori=etek">Etek</a>
        <a href="sayfalist.php?kategori=sortlar">Şort</a>
    </nav>

    <nav class="mobile-menu" id="mobileMenu">
        <h3 class="menu-title">Kategoriler</h3>
        <a href="sayfalist.php?kategori=kazak">Kazak</a>
        <a href="sayfalist.php?kategori=gomlek">Gömlek</a>
        <a href="sayfalist.php?kategori=elbiseler">Elbise</a>
        <a href="sayfalist.php?kategori=tisortler">Tişört</a>
        <a href="sayfalist.php?kategori=toplar">Top | Body</a>
        <a href="sayfalist.php?kategori=etek">Etek</a>
        <a href="sayfalist.php?kategori=sortlar">Şort</a>
    </nav>

    <script>

        const searchBtn = document.getElementById("searchBtn");
        const navIcons = document.querySelector(".nav-icons");

        searchBtn.addEventListener("click", function (e) {
            e.preventDefault();
            navIcons.classList.toggle("active");
            if (navIcons.classList.contains("active")) {
                document.querySelector(".search-box input").focus();
            }
        });

        document.querySelector(".search-box input").addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                const q = this.value.trim();
                if (q) {
                    window.location.href = "arama.php?q=" + encodeURIComponent(q);
                }
            }
        });

        window.addEventListener("scroll", function () {
            const header = document.getElementById("header");
            header.classList.toggle("scrolled", window.scrollY > 50);
        });

        const menuBtn = document.querySelector(".menu-toggle");
        const mobileMenu = document.getElementById("mobileMenu");

        menuBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            mobileMenu.classList.toggle("active");
        });

        document.addEventListener("click", function (e) {
            if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                mobileMenu.classList.remove("active");
            }
        });

    </script>
</body>
</html>