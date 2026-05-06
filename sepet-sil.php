<?php
session_start();

$urun_id = $_POST['urun_id'];

if (isset($_SESSION['sepet'][$urun_id])) {
    unset($_SESSION['sepet'][$urun_id]);
}

header('Content-Type: application/json');
echo json_encode(['basari' => true]);
exit;
?>