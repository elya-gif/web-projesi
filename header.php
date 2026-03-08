<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Başlığı</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- [GÜNCELLEME] 3 ayrı font isteği tek satıra birleştirildi (daha hızlı yükleme) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f1ea;
            padding-top: 110px;
            font-family: Arial, sans-serif;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 30px 40px;
            z-index: 1000;
            background: transparent;
            /* [GÜNCELLEME] color eklendi – scroll öncesi ikon/metin rengi garanti altına alındı */
            color: #1C1C1C;
            transition: 0.3s ease;
        }

        .header.scrolled {
            background: #EAE6E0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .menu {
            font-size: 24px;
            cursor: pointer;
            color: #1C1C1C;
        }

        /* [GÜNCELLEME] Önceki kodda burada hatalı tek "/" karakteri vardı, silindi */
        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo a {
            text-decoration: none;
            font-family: "Cormorant Garamond", serif;
            font-size: 36px;
            letter-spacing: 3px;
            font-weight: 600;
            color: #1C1C1C;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-icons a {
            text-decoration: none;
            color: #1C1C1C;
            font-size: 22px;
            transition: 0.3s;
        }

        .nav-icons a:hover {
            opacity: 0.6;
        }
    </style>
</head>
<body>

<header class="header" id="header">

    <!-- [GÜNCELLEME] id="menuTrigger" eklendi – offcanvas menüyü JS ile bağlamak için gerekli -->
    <div class="menu" id="menuTrigger">
        <i class="fa-solid fa-bars"></i>
    </div>

    <!-- [GÜNCELLEME] href="#" → href="index.php" olarak güncellendi -->
    <div class="logo">
        <a href="index.php">MEGAY MODA</a>
    </div>

    <!-- [GÜNCELLEME] aria-label'lar eklendi – erişilebilirlik için -->
    <div class="nav-icons">
        <a href="#" aria-label="Ara"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#" aria-label="Sepet"><i class="fa-solid fa-basket-shopping"></i></a>
        <a href="#" aria-label="Hesap"><i class="fa-solid fa-circle-user"></i></a>
    </div>

</header>

<script>
    window.addEventListener("scroll", function () {
        const header = document.getElementById("header");
        header.classList.toggle("scrolled", window.scrollY > 50);
    });
</script>

</body>
</html>