<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=megaymod_megay_moda;charset=utf8',
        'megaymod_yenimegay',
        'sifre123!123'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Bağlantı hatası: ' . $e->getMessage());
}

$iyzico_api_key    = 'sandbox-c3xrxzgfsxxw8ENBiqdYbJTynDmsRJ1c';
$iyzico_secret_key = 'sandbox-bp76DUc3B4OrtouyBNbnRmdsY6RVCeQB';
$iyzico_base_url   = 'https://sandbox-api.iyzipay.com';
?>