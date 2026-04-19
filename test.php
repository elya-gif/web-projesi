<?php
require_once 'config/config.php';

$stmt = $pdo->query("SELECT * FROM urunler");
$urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Ürün Listesi</h2>";
foreach($urunler as $urun) {
    echo $urun['ad'] . " — " . $urun['fiyat'] . " TL <br>";
}
?>