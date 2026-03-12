<?php
include "header.php";
?>
<?php
$pageTitle = "Hakkımızda | Özel Terzi Atelier";
?>  <!-- Bootstrap CSS kısmı burdaaaa-->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    > <!-- yazı fontu hakkımızdanın italik durması için-->
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent-deep: #6b212c;   /* koyu bordo */
            --accent-steel: #7a90a8;  /* gri-mavi */
            --accent-sky:  #aecaeb;   /* açık mavi */
            --accent-sand: #eae6e0;   /* çok açık bej */
            --text-main:   #111111;
            --text-muted:  #555555;
            --bg-main:     #ffffff;
        }

        body {
            background: var(--bg-main);
            color: var(--text-main);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .page-wrapper {
            min-height: 100vh;
            padding: 3rem 1rem 4rem;
        }

        .hero-card {
            background: var(--accent-sand);
            border-radius: 1.25rem;
            border: none;
        }

        .hero-label {
    font-family: 'Great Vibes', cursive;  
    font-size: 5rem;                      
    font-weight: 400;
    font-style: normal;
    letter-spacing: 0;
    text-transform: none;                
    color: var(--accent-deep);
    display: flex;
    align-items: center;
    gap: .5rem;
}

.hero-label-dot {
    width: .35rem;
    height: .35rem;
    border-radius: 999px;
    background: var(--accent-deep);
}

        .hero-title {
            font-size: 1.5rem;
            font-weight: 400;
            margin-top: 1rem;
        }

        .hero-subtitle {
            color: var(--text-muted);
            font-size: .95rem;
        }

        .hero-tagline {
            display: inline-block;
            margin-top: 1rem;
            padding: .4rem .9rem;
            border-radius: 999px;
            background: var(--accent-deep);
            color: #fff;
            font-size: .7rem;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 2px solid var(--accent-steel);
            display: inline-block;
            padding-bottom: .25rem;
            margin-bottom: .75rem;
        }

        .section-text {
            color: var(--text-muted);
            font-size: .9rem;
        }

        .pill {
            font-size: .68rem;
            letter-spacing: .16em;
            text-transform: uppercase;
            border-radius: 999px;
            border-width: 1px;
        }

        .pill-light {
            background: #fff;
            border-color: rgba(0,0,0,.08);
            color: var(--text-main);
        }

        .quote-card {
    background: var(--accent-sky);
    border-radius: 1rem;
    border: none;
    max-width: 320px;      
}

.quote-card .card-body {
    padding: 1.25rem 1.5rem;}

        .quote {
            font-style: italic;
            font-size: .95rem;
        }

        .quote-author {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .16em;
        }

        .value-title {
            font-size: .9rem;
            font-weight: 600;
            color: var(--accent-deep); 
            margin-bottom: .35rem;
        }

        .value-text {
            font-size: .82rem;
            color: var(--text-muted);
        }

        @media (min-width: 992px) {
            .page-wrapper {
                padding-inline: 0;
            }
        }
    </style>



<main class="page-wrapper d-flex align-items-start">
    <div class="container">
        <!-- hakkımızda kısmı ilk bölümmm -->
        <section class="mb-5" id="top">
            <div class="card hero-card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="hero-label mb-1">
          <span class="hero-label-dot"></span>
                        Hakkımızda
                    </div>
                    <h1 class="hero-title mb-3">
                        Her dikişte kişiye özel bir hikâye.
                    </h1>
     <p class="hero-subtitle mb-3 mb-md-4">
                        Megay Moda, hazır kalıplara sığmayanlar için kuruldu. Her bedenin,
                        her duruşun ve her hikâyenin kendine has olduğuna inanıyoruz.
                        Bizim için terzilik, kumaştan çok daha fazlası: kendinizi en rahat
                        ve en güçlü hissettiğiniz hâliniz.
                    </p>
     <span class="hero-tagline">
                        Özel terzilik &amp; kişiye özel tasarım
         </span>
                </div>
            </div>
        </section>

        <!-- orta görüntüü-->
        <section class="mb-5">
            <div class="row g-4">
                <div class="col-lg-7">
                    <h2 class="section-title">Neden buradayız?</h2>
                    <p class="section-text mb-3">
                        Yıllarca kalıplara uymaya çalıştık; bedenimizi kıyafete değil,
                        kıyafeti bedenimize uydurmanın ne kadar dönüştürücü olduğunu gördük.
                        Bu yüzden Megay Moda’da  sizinle başlayan ve sizinle biten
                        sakin bir yolculuk.
                    </p>
                    <p class="section-text mb-3">
                        Zamansız, bakıldığında “sade ama çok şık” denen parçalar tasarlıyoruz.
                        İnce elde işçilik, temiz iç dikişler ve gün boyu konfor, her parçanın
                        değişmez kuralı. Gösterişli logolar yerine; kesimin, duruşun ve
                        detayın sessiz lüksüne güveniyoruz.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                       
                        <span class="badge pill pill-light">Yavaş moda</span>
                        <span class="badge pill pill-light">El işçiliği</span>
                        <span class="badge pill pill-light"> özel dikim</span>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card quote-card shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <p class="quote mb-3">
                                “Kıyafetin üzerinizde kaybolmadığı, tam tersine sizi anlattığı
                                anı yakalamak için her dikişi özenle kontrol ediyoruz.”
                            </p>
                            <p class="quote-author mb-0">
                                Kurucu Terzi - G.A.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- değerlerimiz neler kısmı 
          -->
        <section class="mb-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <h3 class="value-title">Mükemmel olmayan mükemmellik</h3>
                    <p class="value-text mb-0">
                        Vücudunuzun doğal hatlarını gizlemek yerine, onları yumuşak omuzlar,
                        dengeli oranlar ve akışkan kumaşlarla öne çıkarıyoruz. 
                    </p>
                </div>
                <div class="col-md-4">
                    <h3 class="value-title">Şeffaf ve sakin süreç</h3>
                    <p class="value-text mb-0">
                        Hangi kumaşın neden seçildiğini, hangi dikişin ne işe yaradığını
                        açıkça paylaşıyoruz. Böylece gardırobunuzda gerçekten size hizmet eden,
                        uzun ömürlü parçalar oluşuyor.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3 class="value-title">Sürdürülebilir zarafet</h3>
                    <p class="value-text mb-0">
                        Az ama özenli üretimi benimsiyoruz. Doğal içerikli kumaşlara,
                        zamansız renklere ve yıllarca giyilebilecek çizgilere öncelik veriyoruz.
                    </p>
                </div>
            </div>
        </section>

        

      
        <section class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
            <div>
                <p class="section-text mb-2">
                    Gardırobunuzda yıllarca severek giyeceğiniz, 
                    parçalar yaratmak için buradayız.
                </p>
                
            </div>
            
        </section>
    </div>
</main>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script>
    
    $(function () {
        
        $('.hero-card').css('opacity', 0).animate({opacity: 1}, 600);
    });
</script>



<?php include "footer.php"; ?>