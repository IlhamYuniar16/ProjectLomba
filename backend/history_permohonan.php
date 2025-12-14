<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

session_start();
include 'db/db.php';

if (!isset($_SESSION['user'])) {
    echo json_encode([
        "status" => "unauthorized",
        "data" => []
    ]);
    exit;
}

$id_user = (int) $_SESSION['user']['id'];

$query = "SELECT id, nama_pasien, nama_rumah_sakit, golongan_darah, created_at, status_pengajuan FROM permohonan_pasien  WHERE id_user = $id_user";

$result = mysqli_query($db, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);