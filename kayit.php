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
</style>

<div class="auth-container">
    <h2>KAYIT OL</h2>

    <form action="" method="POST">
        <input type="text" name="ad" placeholder="AD SOYAD" required>
        <input type="email" name="email" placeholder="E-POSTA" required>
        <input type="password" name="sifre" placeholder="ŞİFRE" required>
        <button type="submit" name="kayit">KAYIT OL</button>
    </form>

    <div class="alt-link">
        Zaten hesabın var mı? <a href="giris.php">Oturum Aç</a>
    </div>
</div>

<?php include "footer.php"; ?>