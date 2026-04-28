
<?php http_response_code(404); ?>
<?php include "header.php"; ?>

<style>
body {
    background: #fff;
    font-family: Arial, sans-serif;
}

.error-container {
    width: 400px;
    margin: 150px auto;
    text-align: center;
}

.error-code {
    font-size: 72px;
    font-weight: 600;
    color: #2f3a40;
}

.error-text {
    font-size: 16px;
    margin: 15px 0 30px;
    color: #555;
}

.error-container a {
    display: inline-block;
    padding: 12px 25px;
    background: #2f3a40;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    letter-spacing: 1px;
}

.error-container a:hover {
    opacity: 0.9;
}
</style>

<div class="error-container">
    <div class="error-code">404</div>
    <div class="error-text">
        Aradığınız sayfa bulunamadı.
    </div>

    <a href="sayfalist.php">ANASAYFAYA DÖN</a>
</div>

<?php include "footer.php"; ?>