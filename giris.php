<?php include "header.php"; ?>

<style>
.login-container {
    width: 300px;
    margin: 100px auto;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
}

.login-container input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}

.login-container button {
    width: 100%;
    padding: 10px;
    background: black;
    color: white;
    border: none;
    cursor: pointer;
}

.login-container input::placeholder{
    color:#aaa;
}

.kaydol-text {
    margin-top: 15px;
    font-size: 14px;
}

.kaydol-text a {
    color: #6B212C;
    text-decoration: none;
}

.kaydol-text a:hover {
    text-decoration: underline;
}
</style>

<div class="login-container">
    <h2>Giriş Yap</h2>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="E-posta" required>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <button type="submit" name="giris">Giriş Yap</button>
    </form>

    <p class="kaydol-text">
        Hesabın yok mu? <a href="kayit.php">Kaydol</a>
    </p>
</div>

<?php include "footer.php"; ?>