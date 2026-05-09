<?php
session_start();

$urun_id = $_POST['urun_id'];
$adet = (int)$_POST['adet'];

if ($adet < 1) {
    unset($_SESSION['sepet'][$urun_id]);
} else {
    if (isset($_SESSION['sepet'][$urun_id])) {
        $_SESSION['sepet'][$urun_id]['adet'] = $adet;
    }
}

if (isset($_SESSION['sepet']) && empty($_SESSION['sepet'])) {
    unset($_SESSION['sepet']);
}

header('Content-Type: application/json');
echo json_encode(['basari' => true]);
exit;
?>