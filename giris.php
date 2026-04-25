<?php include "header.php"; ?>

<style>
body {
    background: #fff;
    font-family: Arial, sans-serif;
}

.auth-container {
    width: 350px;
    margin: 120px auto;
}

.auth-container h2 {
    font-size: 22px;
    margin-bottom: 25px;
    font-weight: 600;
}

.auth-container input {
    width: 100%;
    padding: 12px 5px;
    margin-bottom: 20px;
    border: none;
    border-bottom: 1px solid #ccc;
    outline: none;
    font-size: 14px;
}

.auth-container input:focus {
    border-bottom: 1px solid black;
}

.auth-container button {
    width: 100%;
    padding: 14px;
    background: #2f3a40;
    color: #fff;
    border: none;
    margin-top: 10px;
    cursor: pointer;
    font-size: 14px;
    letter-spacing: 1px;
}

.auth-container button:hover {
    opacity: 0.9;
}

.alt-link {
    margin-top: 20px;
    font-size: 13px;
}

.alt-link a {
    color: black;
    text-decoration: underline;
}

/* Hata mesajı */
.auth-error {
    background: #fff5f5;
    border-left: 3px solid #e63946;
    color: #c0392b;
    font-size: 13px;
    padding: 10px 12px;
    margin-bottom: 20px;
    letter-spacing: 0.3px;
}

/* Başarı mesajı */
.auth-success {
    background: #f5fff8;
    border-left: 3px solid #2ecc71;
    color: #1a7a40;
    font-size: 13px;
    padding: 10px 12px;
    margin-bottom: 20px;
    letter-spacing: 0.3px;
}
</style>

<div class="auth-container">
    <h2>OTURUM AÇ</h2>

    <?php if (!empty($hata)): ?>
        <div class="auth-error">
            <?= htmlspecialchars($hata) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($basari)): ?>
        <div class="auth-success">
            <?= htmlspecialchars($basari) ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="E-POSTA" required>
        <input type="password" name="sifre" placeholder="ŞİFRE" required>
        <button type="submit" name="giris">OTURUM AÇ</button>
    </form>

    <div class="alt-link">
        Hesabın yok mu? <a href="kayit.php">Kayıt Ol</a>
    </div>
</div>

<?php include "footer.php"; ?>